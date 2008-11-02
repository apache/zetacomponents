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
     * Namespace of the LOCK plugin. 
     */
    const PLUGIN_NAMESPACE = 'ezcWebdavLockPlugin';

    /**
     * XML namespace for properties.
     */
    const XML_NAMESPACE = 'http://ezcomponents.org/s/Webdav#lock';

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
        'ezcWebdavMoveRequest'   => 'receivedMoveRequest',
    );

    protected static $responseHandlingMap = array(
        'ezcWebdavMoveResponse' => 'processMoveResponse',
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
     * Contains information that needs to be transported between request and response handling.
     *
     * Handling methods will store intermediate information here, while the
     * backend processes a request.
     *
     * @var mixed
     */
    protected $handlingInfo;

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
        return $this->propertyHandler->extractLiveProperty(
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
        return $this->propertyHandler->serializeLiveProperty(
            $params['property'],
            $params['parentElement'],
            $params['xmlTool']
        );
    }

    /**
     * Callback for the hook ezcWebdavPropertyHandler::extractDeadProperty().
     *
     * Parameters are:
     * - DOMElement domElement
     * - ezcWebdavXmlTool xmlTool
     * 
     * @param ezcWebdavPluginParameters $params 
     * @return ezcWebdavDeadProperty|null
     */
    public function extractDeadProperty( ezcWebdavPluginParameters $params )
    {
        // Check namespace before bothering property handler
        if ( $params['domElement']->namespaceURI !== self::XML_NAMESPACE )
        {
            return;
        }

        return $this->propertyHandler->extractDeadProperty(
            $params['domElement'],
            $params['xmlTool']
        );
    }

    /**
     * Callback for the hook ezcWebdavPropertyHandler::serializeDeadProperty().
     *
     * Parameters are:
     * - ezcWebdavDeadProperty property
     * - ezcWebdavXmlTool xmlTool
     * 
     * @param ezcWebdavPluginParameters $params 
     * @return DOMElement|null
     */
    public function serializeDeadProperty( ezcWebdavPluginParameters $params )
    {
        return $this->propertyHandler->serializeDeadProperty(
            $params['property'],
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
        $request  = $params['request'];
        $ifHeader = $this->headerHandler->parseIfHeader( $request );

        if ( $ifHeader !== null )
        {
            $request->setHeader( 'If', $ifHeader );
            $request->validateHeaders();
        }

        $requestClass = get_class( $request );
        if ( isset( self::$requestHandlingMap[$requestClass] ) )
        {
            $method = self::$requestHandlingMap[$requestClass];
            return $this->$method( $request );
        }
        // return null
    }

    public function generatedResponse( ezcWebdavPluginParameters $params )
    {
        $response = $params['response'];
        $responseClass = get_class( $response );

        if ( isset( self::$responseHandlingMap[$responseClass] ) )
        {
            $method = self::$responseHandlingMap[$responseClass];
            return $this->$method( $response );
        }
        // return null;
    }

    //
    //
    // LOCK request handling
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
        $lockToken  = $this->generateLockToken( $request );
        $activeLock = $this->generateActiveLock(
            $request,
            $lockToken
        );

        // Generates PROPPATCH requests while checking violations
        $requestGenerator = new ezcWebdavLockLockRequestGenerator(
            $request,
            $activeLock
        );

        // Check violations and collect PROPPATCH requests
        $res = $this->checkViolations(
            array(
                new ezcWebdavLockCheckInfo(
                    $request->requestUri,
                    $request->getHeader( 'Depth' ),
                    $request->getHeader( 'If' ),
                    $request->getHeader( 'Authorization' ),
                    ezcWebdavAuthorizer::ACCESS_WRITE,
                    $requestGenerator
                ),
            )
        );

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

        return new ezcWebdavLockResponse(
            // Only 1 active lock per resource, so a new response works here
            new ezcWebdavLockDiscoveryProperty( new ArrayObject( array( $activeLock ) ) ),
            $lockToken
        );
    }

    /**
     * Performs a manual request for a lock.
     *
     * Clients may send a lock request without a body and with an If header, to
     * indicate they want to reset the timeout for a lock. This method handles
     * such requests.
     * 
     * @param ezcWebdavLockRequest $request 
     * @return ezcWebdavResponse
     */
    protected function refreshLock( ezcWebdavLockRequest $request )
    {
        if ( ( $ifHeader = $request->getHeader( 'If' ) ) === null )
        {
            return new ezcWebdavErrorResponse(
                ezcWebdavResponse::STATUS_412,
                'If header needs to be provided to refresh a lock.'
            );
        }
        
        $reqGen = new ezcWebdavLockRefreshRequestGenerator(
            $request
        );

        $res = $this->checkViolations(
            array(
                new ezcWebdavLockCheckInfo(
                    $request->requestUri,
                    $request->getHeader( 'Depth' ),
                    $request->getHeader( 'If' ),
                    $request->getHeader( 'Authorization' ),
                    ezcWebdavAuthorizer::ACCESS_WRITE,
                    $reqGen
                ),
            )
        );
        
        if ( $res !== null )
        {
            return $res;
        }

        $reqGen->sendRequests();

        return new ezcWebdavLockResponse(
            $reqGen->getMainLockDiscoveryProperty()
        );
    }

    /**
     * Creates a lock-null resource.
     *
     * In case a LOCK request is issued on a resource, that does not exists, a
     * so-called lock-null resource is created. This resource must support some
     * of the WebDAV requests, but not all. In case an MKCOL or PUT request is
     * issued to such a resource, it is switched to be a real resource. In case
     * the lock is released, all null-lock resources in it are removed.
     * 
     * @param ezcWebdavLockRequest $request 
     * @return ezcWebdavResponse
     */
    protected function createLockNullResource( ezcWebdavLockRequest $request )
    {
        $backend = ezcWebdavServer::getInstance()->backend;

        // Check parent directory for locks and other violations

        $checkRes = $this->checkViolations(
            array(
                new ezcWebdavLockCheckInfo(
                    dirname( $request->requestUri ),
                    ezcWebdavRequest::DEPTH_ZERO,
                    $request->getHeader( 'If' ),
                    $request->getHeader( 'Authorization' ),
                    ezcWebdavAuthorizer::ACCESS_WRITE
                ),
            )
        );

        if ( $checkRes !== null )
        {
            return $checkRes;
        }

        // Create lock null resource

        $putReq = new ezcWebdavPutRequest(
            $request->requestUri,
            ''
        );

        $putRes = $backend->put( $putReq );

        if ( !( $putRes instanceof ezcWebdavPutResponse ) )
        {
            return $this->createLockFailureResponse(
                array( $putRes ),
                new ezcWebdavResource( $request->requestUri )
            );
        }

        // Patch necessary properties
        
        $lockToken         = $this->generateLockToken( $request );
        $lockDiscoveryProp = new ezcWebdavLockDiscoveryProperty(
            new ArrayObject(
                array(
                    $this->generateActiveLock( $request, $lockToken )
                )
            )
        );

        $propPatchReq = new ezcWebdavPropPatchRequest( $request->requestUri );
        $propPatchReq->storage->attach(
            $lockDiscoveryProp,
            ezcWebdavPropPatchRequest::SET
        );
        $propPatchReq->storage->attach(
            new ezcWebdavLockInfoProperty(
                new ArrayObject(
                    array(
                        new ezcWebdavLockTokenInfo(
                            $lockToken,
                            null,
                            new DateTime()
                        ),
                    )
                ),
                // Null resource!
                true
            )
        );

        $propPatchReq->validateHeaders();
        $propPatchRes = $backend->propPatch( $propPatchReq );

        if ( !( $propPatchRes instanceof ezcWebdavPropPatchResponse ) )
        {
            return $this->createLockFailureResponse(
                array( $propPatchRes ),
                new ezcWebdavResource( $request->requestUri )
            );
        }
        
        return new ezcWebdavLockResponse(
            $lockDiscoveryProp,
            $lockToken
        );
    }

    //
    //
    // UNLOCK request handling
    //
    //

    /**
     * Handles UNLOCK requests.
     *
     * This method determines the base of the lock determined by the Lock-Token
     * header of $request and releases the lock from all locked resources. In
     * case a lock null resource is beyond these, it will be deleted.
     * 
     * @param ezcWebdavUnlockRequest $request 
     * @return ezcWebdavResponse
     */
    protected function handleUnlockRequest( ezcWebdavUnlockRequest $request )
    {
        $srv = ezcWebdavServer::getInstance();

        $token = $request->getHeader( 'Lock-Token' );

        if ( $token === null )
        {
            // UNLOCK must have a lock token
            return new ezcWebdavErrorResponse( ezcWebdavResponse::STATUS_412 );
        }


        // Check permission

        if ( !$srv->isAuthorized(
                $request->requestUri,
                $request->getHeader( 'Authorization' ),
                ezcWebdavAuthorizer::ACCESS_WRITE
             ) )
        {
            return $srv->createUnauthorizedResponse(
                $request->requestUri,
                'Authorization failed.'
            );
        }

        // Find properties to determine lock base

        $propFindReq = new ezcWebdavPropFindRequest(
            $request->requestUri
        );
        $propFindReq->prop = new ezcWebdavBasicPropertyStorage();
        $propFindReq->prop->attach(
            new ezcWebdavLockDiscoveryProperty()
        );
        $propFindReq->prop->attach(
            new ezcWebdavLockInfoProperty()
        );
        $propFindReq->setHeader( 'Depth', ezcWebdavRequest::DEPTH_ZERO );
        $propFindReq->validateHeaders();

        $propFindMultistatusRes = $srv->backend->propFind( $propFindReq );

        if ( !( $propFindMultistatusRes instanceof ezcWebdavMultistatusResponse ) )
        {
            return $propFindMultistatusRes;
        }

        $lockDiscoveryProp = null;
        $lockInfoProp = null;

        foreach ( $propFindMultistatusRes->responses as $propFindRes )
        {
            foreach( $propFindRes->responses as $propStatRes )
            {
                if ( $propStatRes->storage->contains( 'lockdiscovery' )
                     && $lockDiscoveryProp === null )
                {
                    $lockDiscoveryProp = $propStatRes->storage->get( 'lockdiscovery' );
                }
                if ( $propStatRes->storage->contains( 'lockinfo', self::XML_NAMESPACE )
                     && $lockInfoProp === null )
                {
                    $lockInfoProp = $propStatRes->storage->get( 'lockinfo', self::XML_NAMESPACE );
                }
                if ( $lockInfoProp !== null && $lockDiscoveryProp !== null )
                {
                    // Found both, finish
                    break 2;
                }
            }
        }

        if ( $lockDiscoveryProp === null && $lockInfoProp === null )
        {
            // Lock was not found (purged?)! Finish successfully.
            return new ezcWebdavResponse( ezcWebdavResponse::STATUS_204 );
        }

        if ( $lockDiscoveryProp === null || $lockInfoProp === null )
        {
            // Inconsistency!
            throw new ezcWebdavInconsistencyException(
                "Properties <lockinfo> and <lockdiscovery> out of sync for path '{$request->requestUri}' with token '$token'."
            );
        }

        $affectedTokenInfo = null;
        foreach ( $lockInfoProp->tokenInfos as $tokenInfo )
        {
            if ( $tokenInfo->token == $token )
            {
                $affectedTokenInfo = $tokenInfo;
            }
        }

        $affectedActiveLock = null;
        foreach ( $lockDiscoveryProp->activeLock as $activeLock )
        {
            // Note the ==, sinde $activeLock->token is an instance of
            // ezcWebdavPotentialUriContent
            if ( $activeLock->token == $token )
            {
                $affectedActiveLock = $activeLock;
                break;
            }
        }

        if ( $affectedTokenInfo === null || $affectedActiveLock === null )
        {
            // Lock not present (purged)! Finish successfully.
            return new ezcWebdavResponse( ezcWebdavResponse::STATUS_204 );
        }

        if ( $affectedTokenInfo->lockBase !== null )
        {
            // Requested resource is not the lock base, recurse
            $request = new ezcWebdavUnlockRequest( $affectedTokenInfo->lockBase );
            $request->setHeader( 'Lock-Token', $token );
            $request->validateHeaders();

            return $this->handleUnlockRequest(
                $request
            );
        }

        // If lock depth is 0, we issue 1 propfind too much here
        // @TODO: Analyse if clients usually lock 0 or infinity
        return $this->performUnlock( $request->requestUri, $token, $affectedActiveLock->depth );
    }

    /**
     * Performs unlocking.
     *
     * Performs a PROPFIND request with the $depth of the lock with $token on
     * the given $path (which must be the lock base). All affected resources
     * get the neccessary properties updated to reflect the change. Lock null
     * resources in the lock are removed.
     * 
     * @param string $path 
     * @param string $token 
     * @param int $depth 
     * @return ezcWebdavResponse
     */
    protected function performUnlock( $path, $token, $depth )
    {
        $backend = ezcWebdavServer::getInstance()->backend;

        // Find alle resources affected by the unlock, including affected properties

        $propFindReq = new ezcWebdavPropFindRequest( $path );
        $propFindReq->prop = new ezcWebdavBasicPropertyStorage();
        $propFindReq->prop->attach( new ezcWebdavLockInfoProperty() );
        $propFindReq->prop->attach( new ezcWebdavLockDiscoveryProperty() );
        $propFindReq->setHeader( 'Depth', $depth );
        $propFindReq->validateHeaders();

        $propFindMultistatusRes = $backend->propFind( $propFindReq );

        // Remove lock information for the lock identified by $token from each affected resource

        foreach ( $propFindMultistatusRes->responses as $propFindRes )
        {
            // Takes properties to be updated
            $changeProps = new ezcWebdavFlaggedPropertyStorage();

            foreach ( $propFindRes->responses as $propStatRes )
            {
                if ( $propStatRes->status === ezcWebdavResponse::STATUS_200 )
                {
                    // Remove affected tokeninfo from lockinfo property

                    if ( $propStatRes->storage->contains( 'lockinfo', self::XML_NAMESPACE ) )
                    {
                        $lockInfoProp = $propStatRes->storage->get( 'lockinfo', self::XML_NAMESPACE );
                        foreach( $lockInfoProp->tokenInfos as $id => $tokenInfo )
                        {
                            if ( $tokenInfo->token === $token )
                            {
                                // Not a null resource

                                unset( $lockInfoProp->tokenInfos[$id] );
                                $changeProps->attach(
                                    $lockInfoProp,
                                    ezcWebdavPropPatchRequest::SET
                                );

                                break;
                            }

                            if ( $lockInfoProp->null === true && count( $lockInfoProp->tokenInfos ) === 0 )
                            {
                                // Null lock resource, delete when no more locks are active

                                $deleteReq = new ezcWebdavDeleteRequest( $propFindRes->node->path );
                                $deleteReq->validateHeaders();
                                $deleteRes = $backend->delete( $deleteReq );
                                if ( !( $deleteRes instanceof ezcWebdavDeleteResponse ) )
                                {
                                    return $deleteRes;
                                }
                                // Skip over further property assignements and PROPPATCH
                                continue 2;
                            }
                        }
                    }
                    
                    // Remove affected active lock part from lockdiscovery property

                    if ( $propStatRes->storage->contains( 'lockdiscovery' ) )
                    {
                        $lockDiscoveryProp = $propStatRes->storage->get( 'lockdiscovery' );
                        foreach ( $lockDiscoveryProp->activeLock as $id => $activeLock )
                        {
                            if ( $activeLock->token === $token )
                            {
                                unset( $lockDiscoveryProp->activeLock[$id] );
                                $changeProps->attach(
                                    $lockDiscoveryProp,
                                    ezcWebdavPropPatchRequest::SET
                                );
                                break;
                            }
                        }
                    }
                }
            }

            // If changed properties have been assigned (in a normal case,
            // both!), perform the PROPPATCH

            if ( count( $changeProps ) )
            {
                $propPatchReq = new ezcWebdavPropPatchRequest(
                    $propFindRes->node->path
                );
                $propPatchReq->updates = $changeProps;
                $propPatchReq->validateHeaders();

                $propPatchRes = $backend->propPatch( $propPatchReq );

                if ( !( $propPatchRes instanceof ezcWebdavPropPatchResponse ) )
                {
                    throw new ezcWebdavInconsistencyException(
                        "Lock token $token could not be unlocked on resource {$propFindRes->node->path}."
                    );
                }
            }
        }

        return new ezcWebdavUnlockResponse( ezcWebdavResponse::STATUS_204 );
    }

    //
    //
    // MOVE request handling
    //
    //

    public function receivedMoveRequest( ezcWebdavMoveRequest $request )
    {
        $backend = ezcWebdavServer::getInstance()->backend;

        $this->handlingInfo = array();

        $destination = $request->getHeader( 'Destination' );
        $destParent  = dirname( $destination );
        $ifHeader    = $request->getHeader( 'If' );
        $authHeader  = $request->getHeader( 'Authorization' );

        // Check violations and collect info for response handling

        $sourcePathCollector = new ezcWebdavLockCheckPathCollector();

        $destinationPropertyCollector = new ezcWebdavLockCheckPropertyCollector();
        $destinationLockRefresher = new ezcWebdavLockRefreshRequestGenerator(
            $request
        );
        $multiObserver = new ezcWebdavLockMultipleCheckObserver();
        $multiObserver->attach( $destinationPropertyCollector );
        $multiObserver->attach( $destinationLockRefresher );

        $violations = $this->checkViolations(
            array(
                // Source
                new ezcWebdavLockCheckInfo(
                    $request->requestUri,
                    ezcWebdavRequest::DEPTH_INFINITY,
                    $ifHeader,
                    $authHeader,
                    ezcWebdavAuthorizer::ACCESS_WRITE,
                    $sourcePathCollector,
                    false // No lock-null allowed
                ),
                // Destination (maybe overwritten, maybe not, but we must not
                // care)
                new ezcWebdavLockCheckInfo(
                    $destination,
                    ezcWebdavRequest::DEPTH_INFINITY,
                    $ifHeader,
                    $authHeader,
                    ezcWebdavAuthorizer::ACCESS_WRITE,
                    null,
                    false // No lock-null allowed
                ),
                // Destination parent dir
                // We also get the lock property from here and refresh the
                // locks on it
                new ezcWebdavLockCheckInfo(
                    $destParent,
                    ezcWebdavRequest::DEPTH_ZERO,
                    $ifHeader,
                    $authHeader,
                    ezcWebdavAuthorizer::ACCESS_WRITE,
                    $multiObserver,
                    false // No lock-null allowed
                ),
            ),
            // Return on first violation
            true
        );

        if ( $violations !== null )
        {
            return new ezcWebdavMultistatusResponse( $violations );
        }

        // Perform lock refresh (most occur no matter if request succeeds)
        $destinationLockRefresher->sendRequests();

        // Store infos for use on correct moving

        
        $destParentProps = $destinationPropertyCollector->getProperties(
                $destParent
        );

        // Consistency check
        if ( $destParentProps->contains( 'lockdiscovery' )
             ^ $destParentProps->contains( 'lockinfo', self::XML_NAMESPACE )
           )
        {
            throw new ezcWebdavInconsistencyException(
                "Resource '{$request->requestUri}' has inconsisten lock properties."
            );
        }

        $this->handlingInfo['props'] = $destParentProps;

        $this->handlingInfo['request']   = $request;
        $this->handlingInfo['destPaths'] = $sourcePathCollector->getPaths();

        // Backend now handles the request
        // return null;
    }

    /**
     *  
     * 
     * @param ezcWebdavMoveResponse $response 
     * @return void
     */
    public function processMoveResponse( ezcWebdavMoveResponse $response )
    {
        $backend = ezcWebdavServer::getInstance()->backend;

        // Backend successfully performed request, update with LOCK from parent

        $request = $this->handlingInfo['request'];
        $source  = $request->requestUri;
        $dest    = $request->getHeader( 'Destination' );
        $paths   = $this->handlingInfo['destPaths'];

        $lockDiscovery = $this->handlingInfo['props']->get( 'lockdiscovery' );
        if ( $lockDiscovery === null )
        {
            // Nothing to do
            return;
        }
        $lockInfo = $this->handlingInfo['props']->get( 'lockinfo', self::XML_NAMESPACE );
        if ( $lockInfo === null )
        {
            throw new ezcWebdavInconsistencyException(
                'Found <lockdiscovery> property but no <lockinfo> property.'
            );
        }

        // Update lock info to subsequent paths
        foreach ( $lockInfo->tokenInfos as $tokenInfo )
        {
            if ( $tokenInfo->lockBase === null )
            {
                $tokenInfo->lockBase   = $destParent;
                $tokenInfo->lastAccess = null;
            }
        }

        foreach ( $paths as $path )
        {
            $newPath   = str_replace( $source, $dest, $path );
            $propPatch = new ezcWebdavPropPatchRequest( $newPath );
            $propPatch->storage->attach( $lockDiscovery );
            $propPatch->storage->attach( $lockInfo );
            $propPatch->setHeader( 'Authorization', $request->getHeader( 'Authorization' ) );

            $propPatchRes = $backend->propPatch( $propPatch );

            if ( !( $propPatchRes instanceof ezcWebdavPropPatchResponse ) )
            {
                throw new ezcWebdavInconsistencyException(
                    "Could not set lock on resource {$newPath}."
                );
            }
        }
       
        // return null;
    }

    //
    //
    // Tool methods
    //
    //

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
    protected function checkViolations( array $checkInfos, $returnOnViolation = false )
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
    protected function createLockFailureResponse( array $baseResponses, $node, $lockDiscoveryProp = null )
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
    protected function isLockNullResource( ezcWebdavLockCheckInfo $checkInfo )
    {
        $propertyCollector = new ezcWebdavLockCheckPropertyCollector();
        $checkRes = $this->checkViolations( array( $checkInfo ) );

        if ( $checkRes instanceof ezcWebdavMultistatusResponse )
        {
            $propertyStorage = $propertyCollector->getProperties(
                $checkInfo->path
            );
            return (
                $propertyStorage->contains( 'lockinfo', self::XML_NAMESPACE )
                && $propertyStorage->get( 'lockinfo', self::XML_NAMESPACE )->null
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
    protected function generateActiveLock( ezcWebdavLockRequest $request, $lockToken )
    {
        return new ezcWebdavLockDiscoveryPropertyActiveLock(
            $request->lockInfo->lockType,
            $request->lockInfo->lockScope,
            $request->getHeader( 'Depth' ),
            $request->lockInfo->owner,
            $this->getTimeoutValue( $request->getHeader( 'Timeout' ) ),
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
    protected function getTimeoutValue( array $timeoutValues )
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
    protected function checkEtagsAndLocks( ezcWebdavPropFindResponse $propFindRes, ezcWebdavLockCheckInfo $checkInfo )
    {
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
                $lockInfoProp      = $storage->get( 'lockinfo', self::XML_NAMESPACE );
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

        // Extract If header items relevant for the given $request
        if ( $checkInfo->ifHeader === null ||
             ( $ifHeaderItems = $checkInfo->ifHeader[$path] ) === array()
        )
        {
            // No If header items for this path, just check if item is not
            // locked exclusively
            if ( $lockDiscoveryProp !== null && count( $lockDiscoveryProp->acquireLock ) > 0 )
            {
                // Found lock, operation not permitted
                return new ezcWebdavErrorResponse(
                    ezcWebdavResponse::STATUS_423,
                    $path,
                    "Resource locked exclusively by '{$activeLock->owner}'."
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
