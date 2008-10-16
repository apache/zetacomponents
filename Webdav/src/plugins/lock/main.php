<?php
/**
 * File containing the ezcWebdavLockPlugin class.
 *
 * @package Webdav
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 *
 * @access private
 */
/**
 * ezcWebdavLockPlugin 
 * 
 * @package Webdav
 * @version //autogen//
 *
 * @access private
 */
class ezcWebdavLockPlugin
{
    /**
     * Properties
     * 
     * @var array(string=>mixed)
     */
    protected $properties = array(
        'transport'       => null,
        'propertyHandler' => null,
        'headerHandler'   => null,
    );

    /**
     * Maps request classes to handling methods.
     *
     * @array(string=>string)
     */
    protected static $requestHandlingMap = array(
        'ezcWebdavLockRequest'   => 'handleLockRequest',
        'ezcWebdavUnlockRequest' => 'handleUnlockRequest',
    );

    /**
     * Lock plugin options. 
     * 
     * @var ezcWebdavLockPluginOptions
     */
    protected $options;

    /**
     * Lock transport. 
     * 
     * @var ezcWebdavLockTransport
     */
    protected $transport;

    /**
     * Lock property handler. 
     * 
     * @var ezcWebdavLockPropertyHandler
     */
    protected $propertyHandler;

    /**
     * Lock header handler. 
     * 
     * @var ezcWebdavLockHeaderHandler
     */
    protected $headerHandler;

    /**
     * Creates the objects needed for dispatching the hooks.
     * 
     * @return void
     */
    public function __construct( ezcWebdavLockPluginOptions $options )
    {
        $this->options         = $options;
        $this->headerHandler   = new ezcWebdavLockHeaderHandler();
        $this->propertyHandler = new ezcWebdavLockPropertyHandler();
        $this->transport       = new ezcWebdavLockTransport(
            $this->headerHandler,
            $this->propertyHandler
        );
    }

    /**
     * Callback for the hook ezcWebdavTransport::parseUnknownRequest().
     *
     * This method is attached to the specified hook through {@link
     * ezcWebdavLockPluginConfiguration}.
     *
     * Parameters are:
     * - string path
     * - string body
     * - string requestUri
     *
     * Reacts on the LOCK and UNLOCK request methods.
     * 
     * @param ezcWebdavPluginParameters $params 
     * @return ezcWebdavRequest|null
     */
    public function parseUnknownRequest( ezcWebdavPluginParameters $params )
    {
        return $this->transport->parseRequest(
            $params['requestMethod'],
            $params['path'],
            $params['body']
        );
    }

    /**
     * Callback for the hook ezcWebdavTransport::handleUnknownResponse().
     *
     * Parameters are:
     * - ezcWebdavResponse response
     * 
     * @param ezcWebdavPluginParameters $params 
     * @return ezcWebdavDisplayInformation
     */
    public function processUnknownResponse( ezcWebdavPluginParameters $params )
    {
        return $this->transport->processResponse( $params['response'] );
    }

    /**
     * Callback for the hook ezcWebdavPropertyHandler::extractUnknownLiveProperty().
     *
     * Parameters are:
     * - DOMElement domElement
     * - ezcWebdavXmlTool xmlTool
     * 
     * @param ezcWebdavPluginParameters $params 
     * @return void
     */
    public function extractUnknownLiveProperty( ezcWebdavPluginParameters $params )
    {
        return $this->propertyHandler->extractUnknownLiveProperty(
            $params['domElement'],
            $params['xmlTool']
        );
    }

    /**
     * Callback for the hook ezcWebdavPropertyHandler::serializeUnknownLiveProperty().;
     *
     * Parameters are:
     * - ezcWebdavLiveProperty property
     * - ezcWebdavTransport xmlTool
     * - DOMElement parentElement
     * 
     * @param ezcWebdavPluginParameters $params 
     * @return void
     */
    public function serializeUnknownLiveProperty( ezcWebdavPluginParameters $params )
    {
        return $this->propertyHandler->serializeUnknownLiveProperty(
            $params['property'],
            $params['parentElement'],
            $params['xmlTool']
        );
    }

    /**
     * Callback for the hook ezcWebdavServer::receivedRequest().
     *
     * Parameters are:
     * - ezcWebdavRequest request
     *
     * Needs to react directly on:
     * - ezcWebdavLockRequest
     * - ezcWebdavUnlockRequest
     *
     * Needs to check if lock violations occur on:
     * - ezcWebdavCopyRequest
     * - ezcWebdavMoveRequest
     * - ezcWebdavMakeCollectionRequest
     * - ezcWebdavPropPatchRequest
     * - ezcWebdavPutRequest
     * 
     * @param ezcWebdavPluginParameters $params 
     * @return ezcWebdavResponse|null
     */
    public function receivedRequest( ezcWebdavPluginParameters $params )
    {
        $ifHeader = $this->headerHandler->parseIfHeader( $params['request'] );

        if ( $ifHeader !== null )
        {
            $params['request']->setHeader( 'If', $ifHeader );
        }

        if ( isset( self::$requestHandlingMap[get_class( $params['request'] )] ) )
        {
            $method = self::$requestHandlingMap[get_class( $params['request'] )];
            return $this->$method( $params['request'] );
        }
        // return null
    }

    public function generatedResponse( ezcWebdavPluginParameters $params )
    {
        // @TODO: Implement and document!
    }

    //
    //
    // Request handling
    //
    //

    /**
     * Handles LOCK requests (completely).
     * 
     * Internal notes:
     *
     * A lock token must be unique throughout all resources for all times. The code snippet
     *
     * <code>
     * $token = md5( $serverInfo . $pathInfo . uniqid( rand(), true ) ); 
     * </code>
     *
     * The created MD5 hash should be represented as an opaquelock: UUID.
     *
     * Write LOCK affects:
     *  - PUT
     *  - POST
     *  - PROPPATCH
     *  - LOCK
     *  - UNLOCK
     *  - MOVE
     *  - DELETE
     *  - MKCOL
     * 
     * Lock null resources
     *
     * @param ezcWebdavLockRequest $request 
     * @return void
     */
    protected function handleLockRequest( ezcWebdavLockRequest $request )
    {
        // Authentication has already taken place here.
        
        // New lock
        if ( $request->lockInfo !== null )
        {
            return $this->acquireLock( $request );
        }
        // Lock refresh
        else
        {
            return $this->refreshLock( $request );
        }
    }

    protected function refreshLock( ezcWebdavLockRequest $request )
    {
        throw new RuntimeException( 'Not implemented.' );
    }
    

    /**
     * Aquires a new lock.
     *
     * Performs all necessary checks for the lock to be acquired by $request.
     * If any failures occur, either an instance of {@link
     * ezcWebdavErrorResponse} or {@link ezcWebdavMultistatusResponse} is
     * returned. If the lock was acquired successfully, an instance of {@link
     * ezcWebdavLockResponse} is returned.
     * 
     * @param ezcWebdavLockRequest $request 
     * @return ezcWebdavResponse
     */
    private function acquireLock( ezcWebdavLockRequest $request )
    {
        // Active lock part to be used in PROPPATCH requests and LOCK response
        $lockToken = $this->generateLockToken( $request );
        $activeLock = $this->generateActiveLock(
            $request,
            $lockToken,
            $this->getTimeoutValue( $request )
        );

        // Generates PROPPATCH requests while checking violations
        $requestGenerator = new ezcWebdavLockLockRequestGenerator(
            $request,
            $activeLock
        );

        // Check violations and collect PROPPATCH requests
        $res = $this->checkViolations( $request, $requestGenerator );

        if ( $res !== null )
        {
            // 404 -> need to create lock-null resource
            if ( $res instanceof ezcWebdavErrorResponse && $res->status === ezcWebdavResponse::STATUS_404 )
            {
                return $this->createLockNullResource( $request );
            }

            // Other violations -> return error response
            return $res;
        }
        
        $affectedLockDiscovery = null;

        // Send all generated PROPPATCH requests to the backend to update lock information
        foreach ( $requestGenerator->getRequests() as $propPatch )
        {
            // Store main affected resources property for use in LOCK response
            // Might include other locks, too, so we grab it here instead of
            // using the $activeLock content from above
            if ( $propPatch->requestUri === $request->requestUri )
            {
                $affectedLockDiscovery = $propPatch->updates->get( 'lockdiscovery' );
            }

            // Authorization for lock assignement
            $propPatch->setHeader( 'Authorization', $request->getHeader( 'Authorization' ) );

            $propPatch->validateHeaders();

            $res = ezcWebdavServer::getInstance()->backend->performRequest(
                $propPatch
            );

            if ( !( $res instanceof ezcWebdavPropPatchResponse  ) )
            {
                // An error occured while performing PROPPATCH, very bad thing!
                // @TODO: Should usually cleanup successful patches again!
                return $res;
            }
        }

        return new ezcWebdavLockResponse( $affectedLockDiscovery, $lockToken );
    }

    protected function getTimeoutValue( ezcWebdavLockRequest $request )
    {
        // Default
        $timeout = $this->options->lockTimeout;

        $timeoutHeader = $request->getHeader( 'Timeout' );
        foreach ( $timeoutHeader as $desiredTimeout )
        {
            if ( $desiredTimeout < $timeout )
            {
                $timeout = $desiredTimeout;
            }
        }

        return $timeout;
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
    protected function generateActiveLock( ezcWebdavLockRequest $request, $lockToken, $timeout )
    {
        return new ezcWebdavLockDiscoveryPropertyActiveLock(
            $request->lockInfo->lockType,
            $request->lockInfo->lockScope,
            $request->getHeader( 'Depth' ),
            $request->lockInfo->owner,
            $timeout,
            array( $lockToken )
        );
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
    protected function generateLockToken( ezcWebdavLockRequest $request )
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

    protected function checkViolations( ezcWebdavRequest $request, ezcWebdavLockRequestGenerator $generator )
    {
        $srv = ezcWebdavServer::getInstance();

        $propFind       = new ezcWebdavPropFindRequest( $request->requestUri );
        $propFind->prop = new ezcWebdavBasicPropertyStorage();

        $propFind->prop->attach( new ezcWebdavLockDiscoveryProperty() );
        $propFind->prop->attach( new ezcWebdavGetEtagProperty() );
        $propFind->setHeader(
            'Depth',
            ( $depth = $request->getHeader( 'Depth' ) ) !== null ? $depth : ezcWebdavRequest::DEPTH_ONE
        );

        $propFind->validateHeaders();

        $propFindMultistatusRes = $srv->backend->performRequest( $propFind );

        if ( !( $propFindMultistatusRes instanceof ezcWebdavMultistatusResponse ) )
        {
            return $propFindMultistatusRes;
        }

        $violations = array();
        foreach ( $propFindMultistatusRes->responses as $propFindRes )
        {
            // Check authorization of the affected node
            if ( !$srv->isAuthorized(
                    $request,
                    $propFindRes->node->path,
                    ezcWebdavAuthorizer::ACCESS_WRITE
                 ) 
            )
            {
                $violations[] = $srv->createUnauthorizedResponse( $propFindRes->path, 'Authorization failed' );
                // No need for further checks on this path
                continue;
            }

            // Auth check passed, check etags and lock tokens
            foreach ( $propFindRes->responses as $propStatRes )
            {
                // @TODO: Do we need to obey to other statuus, too?
                if ( $propStatRes->status === ezcWebdavResponse::STATUS_200 )
                {
                    $res = $this->checkEtagsAndLocks( $propStatRes->storage, $request );
                    if ( $res !== null )
                    {
                        $violations[] = $res;
                    }
                }
                // Notify request generator
                if ( $generator !== null )
                {
                    $generator->notify( $propFindRes );
                }
            }
        }

        if ( $violations !== array() )
        {
            return new ezcWebdavMultistatusResponse( $violations );
        }
        // return null;
    }

    protected function checkEtagsAndLocks( ezcWebdavPropertyStorage $propertyStorage, ezcWebdavRequest $req )
    {
        if ( ( $ifHeader = $req->getHeader( 'If' ) ) === null ||
             ( $ifHeaderItems = $ifHeader[$req->requestUri] ) === array()
        )
        {
            // No If header items for this path, just check if item is not
            // locked exclusively
            if ( $propertyStorage->contains( 'lockdiscovery' ) )
            {
                $lockDiscoveryProperty = $propertyStorage->get( 'lockdiscovery' );
                foreach ( $lockDiscoveryProperty->activeLock as $activeLock )
                {
                    if ( $activeLock->lockType === ezcWebdavLockRequest::SCOPE_EXCLUSIVE )
                    {
                        // Found an exlusive lock, operation not permitted
                        return new ezcWebdavErrorResponse(
                            ezcWebdavResponse::STATUS_423,
                            $req->requestUri,
                            "Resource locked exclusively by {$activeLock->owner}."
                        );
                    }
                }
            }

            // If no return happened so far, everything seems to be fine
            return null;
        }

        // An If header is present for the affected resource and its items are
        // in $ifHeaderItems

        $etag = ( $propertyStorage->contains( 'getetag' ) ? $propertyStorage->get( 'getetag' )->etag : null );
        $lockTokens = array();

        // Fetch all lock tokens assigned
        if ( $propertyStorage->contains( 'lockdiscovery' ) )
        {
            $lockDiscoveryProperty = $propertyStorage->get( 'lockdiscovery' );
            foreach ( $lockDiscoveryProperty->activeLock as $activeLock )
            {
                $lockTokens = $lockTokens + $activeLock->tokens;
            }
            $lockTokens = array_unique( $lockTokens );
        }
        
        $verified = false;

        // Logical OR connected items
        foreach ( $ifHeaderItems as $item )
        {
            // Logical AND connected etags and lockitems
            foreach ( $item->eTags as $itemEtag )
            {
                if ( $etag !== $itemEtag )
                {
                    // Etag not validated
                    continue 2;
                }
            }
            foreach ( $item->lockTokens as $itemLockToken )
            {
                if ( !in_array( $itemLockToken, $lockTokens ) )
                {
                    // Lock token not provided
                    continue 2;
                }
            }
            // All tests passed for a combination
            $verified = true;
            break;
        }

        if ( !$verified )
        {
            return new ezcWebdavErrorResponse(
                ezcWebdavResponse::STATUS_409,
                $req->requestUri,
                'No valid state provided in If header'
            );
        }
        // All right!
        return null;
    }

    //
    //
    // Property access
    //
    //

    /**
     * Sets a property.
     *
     * This method is called when an property is to be set.
     * 
     * @param string $propertyName The name of the property to set.
     * @param mixed $propertyValue The property value.
     * @return void
     * @ignore
     *
     * @throws ezcBasePropertyNotFoundException
     *         if the given property does not exist.
     * @throws ezcBaseValueException
     *         if the value to be assigned to a property is invalid.
     * @throws ezcBasePropertyPermissionException
     *         if the property to be set is a read-only property.
     */
    public function __set( $propertyName, $propertyValue )
    {
        switch ( $propertyName )
        {
            case 'transport':
                if ( !( $propertyValue instanceof ezcWebdavLockTransport ) )
                {
                    throw new ezcBaseValueException( $propertyName, $propertyValue, 'ezcWebdavLockTransport' );
                }
                break;
            case 'propertyHandler':
                if ( !( $propertyValue instanceof ezcWebdavLockPropertyHandler ) )
                {
                    throw new ezcBaseValueException( $propertyName, $propertyValue, 'ezcWebdavLockPropertyHandler' );
                }
                break;
            case 'headerHandler':
                if ( !( $propertyValue instanceof ezcWebdavLockHeaderHandler ) )
                {
                    throw new ezcBaseValueException( $propertyName, $propertyValue, 'ezcWebdavLockPropertyHandler' );
                }
                break;

            default:
                throw new ezcBasePropertyNotFoundException( $propertyName );
        }
        $this->properties[$propertyName] = $propertyValue;
    }

    /**
     * Property get access.
     *
     * Simply returns a given property.
     *
     * @param string $propertyName The name of the property to get.
     * @return mixed The property value.
     *
     * @ignore
     *
     * @throws ezcBasePropertyNotFoundException
     *         if the given property does not exist.
     * @throws ezcBasePropertyPermissionException
     *         if the property to be set is a write-only property.
     */
    public function __get( $propertyName )
    {
        if ( $this->__isset( $propertyName ) )
        {
            return $this->properties[$propertyName];
        }
        throw new ezcBasePropertyNotFoundException( $propertyName );
    }
    
    /**
     * Returns if a property exists.
     *
     * Returns true if the property exists in the {@link $properties} array
     * (even if it is null) and false otherwise. 
     *
     * @param string $propertyName Option name to check for.
     * @return void
     * @ignore
     */
    public function __isset( $propertyName )
    {
        return array_key_exists( $propertyName, $this->properties );
    }
}

?>
