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
     * Creates a new tool instances.
     * 
     * @param ezcWebdavLockPluginOptions $options 
     */
    public function __construct( ezcWebdavLockPluginOptions $options )
    {
        $this->options = $options;
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
     * @param array(ezcWebdavLockCheckInfo) $checkInfos
     * @param bool $returnOnViolation
     * @return ezcWebdavMultistatusResponse|ezcWebdavErrorResponse|null
     */
    public function checkViolations( array $checkInfos, $returnOnViolation = false )
    {
        $srv = ezcWebdavServer::getInstance();

        // Might contain multiple check infos, if multiple paths are affected
        foreach ( $checkInfos as $checkInfo )
        {

            $propFind       = new ezcWebdavPropFindRequest( $checkInfo->path );
            $propFind->prop = new ezcWebdavBasicPropertyStorage();

            $propFind->prop->attach( new ezcWebdavLockDiscoveryProperty() );
            $propFind->prop->attach( new ezcWebdavGetEtagProperty() );
            $propFind->prop->attach( new ezcWebdavLockInfoProperty() );

            $propFind->setHeader(
                'Depth',
                ( $checkInfo->depth !== null ? $checkInfo->depth : ezcWebdavRequest::DEPTH_ONE )
            );

            $propFind->validateHeaders();

            $propFindMultistatusRes = $srv->backend->performRequest( $propFind );

            if ( !( $propFindMultistatusRes instanceof ezcWebdavMultistatusResponse ) )
            {
                // Bubble up error from backend
                return $propFindMultistatusRes;
            }

            $violations       = array();
            $mainLockProperty = null;

            foreach ( $propFindMultistatusRes->responses as $propFindRes )
            {
                // Check authorization of the affected node
                if ( !$srv->isAuthorized(
                        $propFindRes->node->path,
                        $checkInfo->authHeader,
                        $checkInfo->access
                     ) 
                )
                {
                    $unauthorizedRes = $srv->createUnauthorizedResponse(
                        $propFindRes->node->path,
                        'Authorization failed.'
                    );


                    $violations[] = $unauthorizedRes;

                    // Return instead of collect violations
                    if ( $returnOnViolation )
                    {
                        return $violations;
                    }

                    // No need for further checks on this path, if authorization failed
                    continue;
                }

                if ( ( $res = $this->checkEtagsAndLocks( $propFindRes, $checkInfo ) ) !== null )
                {
                    $violations[] = $res;

                    // Return instead of collect violations
                    if ( $returnOnViolation )
                    {
                        return $violations;
                    }
                }

                // Notify request generator on affected ressource
                if ( $checkInfo->requestGenerator !== null )
                {
                    $checkInfo->requestGenerator->notify( $propFindRes );
                }

                // Store main lock property for use in MultiStatus
                if ( $propFindRes->node->path === $checkInfo->path )
                {
                    foreach ( $propFindRes->responses as $propStatRes )
                    {
                        if ( $propStatRes->storage->contains( 'lockdiscovery' ) )
                        {
                            $mainLockNode     = $propFindRes->node;
                            $mainLockProperty = $propStatRes->storage->get( 'lockdiscovery' );
                            break;
                        }
                    }
                }
            }
        }

        if ( $violations !== array() )
        {
            return $this->createLockFailureResponse(
                $violations,
                $mainLockNode,
                $mainLockProperty
             );
        }
        // return null;
    }

    /**
     * Creates a failure response for lock requests.
     *
     * The RFC requires that the <lockdiscovery> property affected by the
     * request is submitted together with all failures. This method creates the
     * desired multi status response and returns it. If the affected main
     * resource in $node does not have a <lockdiscovery> property attached, a
     * new one is created.
     * 
     * @param array(ezcWebdavResponse) $baseResponses
     * @param ezcWebdavCollection|ezcWebdavResource $node 
     * @param ezcWebdavLockDiscoveryProperty $lockDiscoveryProp 
     * @return ezcWebdavMultistatusResponse
     */
    public function createLockFailureResponse( array $baseResponses, $node, $lockDiscoveryProp = null )
    {
        $propStat = new ezcWebdavPropStatResponse(
            new ezcWebdavBasicPropertyStorage() ,
            ezcWebdavResponse::STATUS_424
        );
        $propStat->storage->attach(
            ( $lockDiscoveryProp === null ? new ezcWebdavLockDiscoveryProperty() : $lockDiscoveryProp )
        );

        return new ezcWebdavMultistatusResponse(
            $baseResponses,
            new ezcWebdavPropFindResponse(
                $node,
                $propStat
            )
        );
    }

    /**
     * Checks if a resource is a lock-null resource.
     *
     * Checks if the resource described by $checkInfo is a lock-null resource.
     * 
     * @param ezcWebdavLockCheckInfo $checkInfo 
     * @return bool
     */
    public function isLockNullResource( ezcWebdavLockCheckInfo $checkInfo )
    {
        $propertyCollector = new ezcWebdavLockCheckPropertyCollector();
        $checkRes = $this->checkViolations( array( $checkInfo ) );

        if ( $checkRes instanceof ezcWebdavMultistatusResponse )
        {
            $propertyStorage = $propertyCollector->getProperties(
                $checkInfo->path
            );
            return (
                $propertyStorage->contains( 'lockinfo', ezcWebdavLockPlugin::XML_NAMESPACE )
                && $propertyStorage->get( 'lockinfo', ezcWebdavLockPlugin::XML_NAMESPACE )->null
            );
        }
        return false;
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
     * Checks the given properties for violations in the given request headers.
     *
     * Checks the If header of the given request against the lock tokens and
     * the ETag assigned to a resource affected by the $req.
     * 
     * @param ezcWebdavPropertyStorage $propertyStorage 
     * @param ezcWebdavLockCheckInfo $checkInfo
     * @return void
     */
    public function checkEtagsAndLocks( ezcWebdavPropFindResponse $propFindRes, ezcWebdavLockCheckInfo $checkInfo )
    {
        $auth = ezcWebdavServer::getInstance()->auth;

        $path = $propFindRes->node->path;

        // Extract interesting responses
        $lockDiscoveryProp = null;
        $getEtagProp = null;
        foreach ( $propFindRes->responses as $propStatRes )
        {
            // 200 OK status response, everything else is uninteressting
            if ( $propStatRes->status === ezcWebdavResponse::STATUS_200 )
            {
                $storage           = $propStatRes->storage;
                $lockDiscoveryProp = $storage->get( 'lockdiscovery' );
                $getEtagProp       = $storage->get( 'getetag' );
                $lockInfoProp      = $storage->get( 'lockinfo', ezcWebdavLockPlugin::XML_NAMESPACE );
            }
        }

        if ( $lockInfoProp !== null && $lockInfoProp->null && !$checkInfo->lockNullMayOccur )
        {
            // Found a lock null resource while must not occur
            return new ezcWebdavErrorResponse(
                ezcWebdavResponse::STATUS_405,
                $path,
                'Operation not possible on lock-null resource.'
            );
        }

        $ifHeaderItems = ( $checkInfo->ifHeader !== null ? $checkInfo->ifHeader[$path] : null );
        // @TODO This might only work properly with single locks!
        if ( $ifHeaderItems === array() && $lockInfoProp !== null )
        {
            // Try lock bases
            foreach ( $lockInfoProp->tokenInfos as $tokenInfo )
            {
                if ( $tokenInfo->lockBase !== null
                     && $auth->ownsLock( $checkInfo->authHeader->username, $tokenInfo->token )
                )
                {
                    $ifHeaderItems = $checkInfo->ifHeader[$tokenInfo->lockBase];
                }
                if ( $ifHeaderItems !== array() )
                {
                    // Found condition set!
                    break;
                }
            }
        }

        // Extract If header items relevant for the given $request
        if ( $checkInfo->ifHeader === null || $ifHeaderItems === null || $ifHeaderItems === array() )
        {
            // No If header items for this path, just check if item is not
            // locked exclusively
            if ( $lockDiscoveryProp !== null && count( $lockDiscoveryProp->activeLock ) > 0 )
            {
                // Found lock, operation not permitted
                return new ezcWebdavErrorResponse(
                    ezcWebdavResponse::STATUS_423,
                    $path,
                    "Resource locked exclusively by '{$lockDiscoveryProp->activeLock[0]->owner}'."
                );
            }

            // No ETag check neccessary, since no If header present
            return null;
        }

        // Check If header conditions

        // Fetch all lock tokens assigned
        $lockTokens = array();
        if ( $lockDiscoveryProp !== null )
        {
            foreach ( $lockDiscoveryProp->activeLock as $activeLock )
            {
                $lockTokens[] = $activeLock->token;
            }
        }

        $etag = ( $getEtagProp !== null ? $getEtagProp->etag : '' );

        $lockVerified = false;
        $etagVerified = false;

        // Logical OR connected items
        foreach ( $ifHeaderItems as $item )
        {
            // Check lock tokens first
            foreach ( $item->lockTokens as $itemLockToken )
            {
                if ( !in_array( $itemLockToken, $lockTokens ) )
                {
                    // Lock token condition failed, check next condition set
                    $lockVerified = false;
                    continue 2;
                }
                if ( !$auth->ownsLock( $checkInfo->authHeader->username, $itemLockToken ) )
                {
                    // Lock token does not belong to the user
                    $lockVerified = false;
                    continue 2;
                }
                $lockVerified = true;

                // Found lock token, check ETags
                foreach ( $item->eTags as $itemEtag )
                {
                    if ( $etag !== $itemEtag )
                    {
                        // Etag condition failed, check next condition set
                        $lockVerified = false;
                        $etagVerified = false;
                        continue 3;
                    }
                }
                $etagVerified = true;
            }
            // If not continued, check passed!
            break;
        }

        if ( !$lockVerified )
        {
            return new ezcWebdavErrorResponse(
                ezcWebdavResponse::STATUS_423,
                $path
            );
        }

        if ( !$etagVerified )
        {
            return new ezcWebdavErrorResponse(
                ezcWebdavResponse::STATUS_409,
                $path,
                'ETag validation failed.'
            );
        }

        // All right!
        return null;
    }
}

?>
