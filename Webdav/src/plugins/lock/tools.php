<?php
/**
 * File containing the ezcWebdavLockTools class.
 *
 * @package Webdav
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 *
 * @access private
 */
/**
 * Tool class for use in the lock plugin.
 *
 * This class contains several tool methods, which are used by the lock plugin
 * and its handlers.
 * 
 * @package Webdav
 * @version //autogen//
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 *
 * @access private
 */
class ezcWebdavLockTools
{
    /**
     * Plugin options.
     * 
     * @var ezcWebdavLockPluginOptions
     */
    public $options;

    /**
     * Default headers to clone in {@link cloneRequestHeaders()}.
     * 
     * @var array(string)
     */
    protected static $defaultCloneHeaders = array(
        'Authorization',
    );

    /**
     * Creates a new tool instances.
     * 
     * @param ezcWebdavLockPluginOptions $options 
     */
    public function __construct( ezcWebdavLockPluginOptions $options )
    {
        $this->options = $options;
    }

    /**
     * Clones headers in $from to headers in $to.
     *
     * Clones all headers with names given in $heades from the request $from to
     * the request in $to. In case $defaultHeaders is set to true, the headers
     * mentioned in {@link $defaultCloneHeaders} are cloned in addition.
     *
     * Note, that this method does not call {@link
     * ezcWebdavRequest::validateHeaders()}, since headers in $to might still
     * be incomplete. You need to call this method manually, before sending $to
     * to the backend or accessing its headers for reading.
     * 
     * @param ezcWebdavRequest $from 
     * @param ezcWebdavRequest $to 
     * @param array $headers 
     * @param bool $defaultHeaders 
     */
    public static function cloneRequestHeaders(
        ezcWebdavRequest $from,
        ezcWebdavRequest $to,
        $headers = array(),
        $defaultHeaders = true
    )
    {
        if ( $defaultHeaders )
        {
            $headers = array_merge( self::$defaultCloneHeaders, $headers );
            $headers = array_unique( $headers );
        }

        foreach( $headers as $headerName )
        {
            $to->setHeader( $headerName, $from->getHeader( $headerName ) );
        }
    }

    /**
     * Checks the given $request for If header and general lock violations.
     *
     * This method performs a PROPFIND request on the backend and retrieves the
     * properties <lockdiscovery>, <getetag> and <lockinfo> for all affected
     * resources. It then checks for the following violations:
     *
     * <ul>
     *   <li>Authorization</li>
     *   <li>Restrictions to etags and lock tokens provided by the If header</li>
     *   <li>General violations of other users locks</li>
     * </ul>
     *
     * Since the utilized information from the PROPFIND request must be used in
     * other places around this class, the method may receive a $generator
     * object. This object will be notified of every processed resource and
     * receives the properties listed above. You should use this mechanism to
     * avoid duplicate requesting of these properties and store the information
     * you desire in the background. In case the checkViolations() method
     * returns null, all checks passed and you can savely execute the desired
     * requests. If $returnOnViolation is set, violations are not collected
     * until all resources are checked, but the method returns as soon as the
     * first violation occurs.
     * 
     * @param ezcWebdavLockCheckInfo $checkInfo
     * @param bool $returnOnViolation
     * @return ezcWebdavMultistatusResponse|ezcWebdavErrorResponse|null
     */
    public function checkViolations( ezcWebdavLockCheckInfo $checkInfo, $returnOnViolation = false )
    {
        $srv = ezcWebdavServer::getInstance();

        $propFind       = new ezcWebdavPropFindRequest( $checkInfo->path );
        $propFind->prop = new ezcWebdavBasicPropertyStorage();

        $propFind->prop->attach( new ezcWebdavLockDiscoveryProperty() );
        $propFind->prop->attach( new ezcWebdavGetEtagProperty() );
        $propFind->prop->attach( new ezcWebdavLockInfoProperty() );

        $propFind->setHeader(
            'Depth',
            ( $checkInfo->depth !== null ? $checkInfo->depth : ezcWebdavRequest::DEPTH_ONE )
        );
        $propFind->setHeader( 'Authorization', $checkInfo->authHeader );

        $propFind->validateHeaders();

        $propFindMultistatusRes = $srv->backend->performRequest( $propFind );

        if ( !( $propFindMultistatusRes instanceof ezcWebdavMultistatusResponse ) )
        {
            // Bubble up error from backend
            return $propFindMultistatusRes;
        }

        foreach ( $propFindMultistatusRes->responses as $propFindRes )
        {
            if ( ( $res = $this->checkEtagsAndLocks( $propFindRes, $checkInfo ) ) !== null )
            {
                return $res;
            }

            // Notify request generator on affected ressource
            if ( $checkInfo->requestGenerator !== null )
            {
                $checkInfo->requestGenerator->notify( $propFindRes );
            }
        }

        return null;
    }

    /**
     * Checks if a resource is a lock-null resource.
     *
     * Checks if the resource described by $checkInfo is a lock-null resource.
     * Returns an error response on failure.
     * 
     * @param ezcWebdavLockCheckInfo $checkInfo 
     * @return bool|ezcWebdavErrorResponse
     */
    public function isLockNullResource( ezcWebdavLockCheckInfo $checkInfo )
    {
        $propFindReq = new ezcWebdavPropFindRequest(
            $checkInfo->path
        );
        $propFindReq->setHeader( 'Authorization', $checkInfo->authHeader );
        $propFindReq->setHeader( 'Depth', ezcWebdavRequest::DEPTH_ZERO );
        $propFindReq->validateHeaders();

        $propFindReq->prop = new ezcWebdavBasicPropertyStorage();
        $propFindReq->prop->attach( new ezcWebdavLockInfoProperty() );
        $propFindReq->prop->attach( new ezcWebdavLockDiscoveryProperty() );

        $propFindMultistatusRes =
            ezcWebdavServer::getInstance()->backend->propFind( $propFindReq );

        if ( !( $propFindMultistatusRes instanceof ezcWebdavMultistatusResponse ) )
        {
            return $propFindMultistatusRes;
        }

        $propFindRes = $propFindMultistatusRes->responses[0];
        if ( $checkInfo->requestGenerator !== null )
        {
            $checkInfo->requestGenerator->notify(
                $propFindRes
            );
        }
        
        $lockInfoProp = $propFindRes->responses[0]->storage->get(
            'lockinfo',
            ezcWebdavLockPlugin::XML_NAMESPACE
        );

        return ( $lockInfoProp !== null && $lockInfoProp->null );
    }

    /**
     * Returns a lock token for the resource affected by $request.
     *
     * Generates a lock token that obeys to the opaquelocktoken scheme, using a
     * UUID v3.
     * 
     * @param ezcWebdavLockRequest $request 
     * @return string
     *
     * @TODO Should we use sha1 instead of md5?
     */
    public function generateLockToken( ezcWebdavLockRequest $request )
    {
        $rawToken = md5(
            $_SERVER['SERVER_PROTOCOL'] . $_SERVER['HTTP_HOST'] . $request->requestUri . microtime( true )
        );

        // @TODO: Needs version number in UUID v3/5!

        return sprintf(
            'opaquelocktoken:%s-%s-%s-%s-%s',
            substr( $rawToken,  0, 8 ),
            substr( $rawToken,  8, 4 ),
            substr( $rawToken, 12, 4 ),
            substr( $rawToken, 16, 4 ),
            substr( $rawToken, 20 )
        );
    }

    /**
     * Returns a new active lock element according to the given data.
     *
     * Creates a new instance of {@link
     * ezcWebdavLockDiscoveryPropertyActiveLock} that can be used with an
     * {@link ezcWebdavLockDiscoveryProperty}. Most information for this
     * property content is fetched from the given $request. The $lockToken for
     * the acquired lock must be provided in addition. Information used is:
     * 
     * @param ezcWebdavLockRequest $request 
     * @param string $lockToken 
     * @return ezcWebdavLockDiscoveryPropertyActiveLock
     */
    public function generateActiveLock( ezcWebdavLockRequest $request, $lockToken )
    {
        return new ezcWebdavLockDiscoveryPropertyActiveLock(
            $request->lockInfo->lockType,
            $request->lockInfo->lockScope,
            $request->getHeader( 'Depth' ),
            $request->lockInfo->owner,
            $this->getTimeoutValue(
                ( $timeouts = $request->getHeader( 'Timeout' ) ) === null ? array() : $timeouts
            ),
            // Generated lock tokens conform to the opaquelocktoken URI scheme
            new ezcWebdavPotentialUriContent( $lockToken, true )
        );
    }

    /**
     * Returns an appropriate timeout value for the given LOCK request.
     *
     * Checks each of the Timeout header values of the $request and chooses the
     * smallest timeout among these and the {@link ezcWebdavLockPluginOptions}
     * $timeout property. The timeout returned corresponds to number of seconds
     * of inactivity, before a lock is released.
     * 
     * @param array(int) $timeoutValues
     * @return int
     */
    public function getTimeoutValue( array $timeoutValues )
    {
        // Default
        $timeout = $this->options->lockTimeout;

        foreach ( $timeoutValues as $desiredTimeout )
        {
            if ( $desiredTimeout < $timeout )
            {
                $timeout = $desiredTimeout;
            }
        }

        return $timeout;
    }

    /**
     * Returns if the given $response resulted from a lock problem.
     *
     * If the given $response is null, no error happened at all (returns
     * false). Otherwise the first response in the multi status is checked for
     * lock violation errors.
     * 
     * @param ezcWebdavMultiStatusResponse $response 
     * @return bool
     */
    public function isLockError( ezcWebdavMultiStatusResponse $response = null )
    {
        if ( $response === null )
        {
            return false;
        }
        $status = $response->responses[0]->status;
        return (
            $status === ezcWebdavResponse::STATUS_405
            || $status === ezcWebdavResponse::STATUS_409
            || $status === ezcWebdavResponse::STATUS_423
            || $status === ezcWebdavResponse::STATUS_424
        );
    }

    /**
     * Checks if etag and locks on a resource violate the If header.
     * 
     * @param ezcWebdavPropFindResponse $propFindRes 
     * @param ezcWebdavLockCheckInfo $checkInfo 
     * @return null|ezcWebdavErrorResponse
     */
    protected function checkEtagsAndLocks( ezcWebdavPropFindResponse $propFindRes, ezcWebdavLockCheckInfo $checkInfo )
    {
        // @TODO: This only works for exclusive locks

        $path = $propFindRes->node->path;
        $data = $this->extractCheckProperties( $propFindRes );

        // Check for lock null
        if ( !$checkInfo->lockNullMayOccur && $data['lockinfo'] !== null && $data['lockinfo']->null )
        {
            return $this->createLockViolation(
                new ezcWebdavErrorResponse(
                    ezcWebdavResponse::STATUS_405,
                    $path
                ),
                $propFindRes->node,
                $data['lockdiscovery']
            );
        }

        $ifItems = $this->getIfHeaderItems( $path, $checkInfo->ifHeader );

        // No If header item, not condition
        if ( $ifItems === array() )
        {
            return $this->checkLockedBySomeoneElse(
                $propFindRes->node,
                $data,
                $checkInfo->authHeader
            );
        }

        $activeLockTokens = $this->extractActiveTokens(
            $data['lockdiscovery'],
            $checkInfo->authHeader
        );
        $activeEtag = ( $data['getetag'] !== null ? $data['getetag']->etag : '' );
       
        $lockWasVerified = false;
        $etagWasVerified = false;

        // Check all possible item series
        foreach ( $ifItems as $ifItem )
        {
            if ( $this->checkLock( $ifItem, $activeLockTokens )
                 && $this->checkEtag( $ifItem, $activeEtag ) )
            {
                // All fine :)
                return null;
            }
        }

        // If header not verified
        return $this->createLockViolation(
            new ezcWebdavErrorResponse(
                ezcWebdavResponse::STATUS_412,
                $path
            ),
            $propFindRes->node,
            $data['lockdiscovery']
        );
    }

    /**
     * Returns a corresponding set of If header items for $path.
     *
     * Checks the given $ifHeader recursively, for conditions to apply to
     * $path. If no condition is found, an empty array is returned.
     * 
     * @param string $path 
     * @param ezcWebdavLockIfHeaderList $ifHeader 
     * @return array(ezcWebdavLockIfHeaderListItem)
     */
    protected function getIfHeaderItems( $path, ezcWebdavLockIfHeaderList $ifHeader = null )
    {
        if ( $ifHeader === null )
        {
            return array();
        }

        while ( $path !== '/' )
        {
            $ifHeaderItems = $ifHeader[$path];
            if ( $ifHeaderItems !== array() )
            {
                return $ifHeaderItems;
            }
            $path = dirname( $path );
        }
        return array();
    }

    /**
     * Extracts active lock tokens from a lockdiscovery property.
     *
     * Returns an array of string lock tokens, that are active on the affected
     * resource and owned by the currently active user.
     * 
     * @param ezcWebdavLockDiscoveryProperty $lockDiscovery 
     * @param ezcWebdavAuth $authHeader 
     * @return array(string)
     */
    protected function extractActiveTokens(
        ezcWebdavLockDiscoveryProperty $lockDiscovery = null,
        ezcWebdavAuth $authHeader
    )
    {
        $activeLockTokens = array();
        if ( $lockDiscovery !== null )
        {
            $auth = ezcWebdavServer::getInstance()->auth;
            foreach ( $lockDiscovery->activeLock as $activeLock )
            {
                $token = (string) $activeLock->token;
                if ( $auth->ownsLock( $authHeader->username, $token ) )
                {
                    $activeLockTokens[] = $token;
                }
            }
        }
        return $activeLockTokens;
    }

    /**
     * Returns if the $ifItem validates agains $lockDiscovery.
     * 
     * @param ezcWebdavIfHeaderListItem $ifItem 
     * @param ezcWebdavLockDiscoveryProperty $lockDiscovery 
     * @return bool
     */
    protected function checkLock( ezcWebdavLockIfHeaderListItem $ifItem, array $activeLockTokens )
    {
        foreach ( $ifItem->lockTokens as $lockToken )
        {
            if ( !( $ifItem->negated ^ in_array( $lockToken, $activeLockTokens ) ) )
            {
                return false;
            }
        }
        return true;
    }

    /**
     * Returns in the given $ifItem validates against the $getEtag.
     *
     * @param ezcWebdavIfHeaderListItem $ifItem 
     * @param ezcWebdavGetEtagProperty $getEtag 
     * @return bool
     */
    protected function checkEtag( ezcWebdavLockIfHeaderListItem $ifItem, $activeEtag )
    {
        foreach ( $ifItem->eTags as $etag )
        {
            if ( !( $ifItem->negated ^ $activeEtag === $etag ) )
            {
                return false;
            }
        }
        return true;
    }

    /**
     * Checks if the resource is locked by someone else.
     *
     * Returns null or error response.
     * 
     * @param string $path 
     * @param array(string=>ezcWebdavProperty) $data 
     * @param ezcWebdavAuth $authHeader 
     * @return null|ezcWebdavErrorResponse
     */
    protected function checkLockedBySomeoneElse( $node, array $data, ezcWebdavAuth $authHeader )
    {
        if ( $data['lockdiscovery'] !== null && count( $data['lockdiscovery']->activeLock ) > 0 )
        {
            return $this->createLockViolation(
                new ezcWebdavErrorResponse(
                    ezcWebdavResponse::STATUS_423,
                    $node->path
                ),
                $node,
                $data['lockdiscovery']
            );
        }
        // Not locked
        return null;
    }

    /**
     * Extracts the properties for the If header check from the $propFindRes.
     * 
     * @param ezcWebdavPropFindResponse $propFindRes 
     * @return array(string)
     */
    protected function extractCheckProperties( ezcWebdavPropFindResponse $propFindRes )
    {
        $data = array(
            'getetag'       => null,
            'lockdiscovery' => null,
            'lockinfo'      => null,
        );
        foreach ( $propFindRes->responses as $propStatRes )
        {
            if ( $propStatRes->status === ezcWebdavResponse::STATUS_200 )
            {
                $data['getetag'] = $propStatRes->storage->get( 'getetag' );
                $data['lockdiscovery'] = $propStatRes->storage->get( 'lockdiscovery' );
                $data['lockinfo'] = $propStatRes->storage->get( 'lockinfo', ezcWebdavLockPlugin::XML_NAMESPACE );
            }
        }

        if ( ( $data['lockdiscovery'] === null || count( $data['lockdiscovery']->activeLock ) === 0 )
             ^ $data['lockinfo'] === null )
        {
            throw new ezcWebdavInconsistencyException(
                "Properties 'lockinfo' and 'lockdiscovery' out of sync on '{$propFindRes->node->path}'."
            );
        }
        return $data;
    }

    /**
     * Attaches the given data to the $error.
     *
     * @param ezcWebdavErrorResponse $error
     * @param ezcWebdavResource|ezcWebdavCollection $node
     * @param ezcWebdavLockDiscoveryProperty $lockDiscovery
     * @return ezcWebdavErrorResponse
     */
    protected function createLockViolation(
        ezcWebdavErrorResponse $error,
        $node,
        ezcWebdavLockDiscoveryProperty $lockDiscovery = null
    )
    {
        $error->setPluginData(
            ezcWebdavLockPlugin::PLUGIN_NAMESPACE,
            'node',
            $node
        );
        $error->setPluginData(
            ezcWebdavLockPlugin::PLUGIN_NAMESPACE,
            'lockdiscovery',
            $lockDiscovery
        );
        return $error;
    }

}

?>
