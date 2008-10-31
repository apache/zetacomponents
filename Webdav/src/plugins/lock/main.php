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
        }

        if ( isset( self::$requestHandlingMap[get_class( $request )] ) )
        {
            $request->validateHeaders();
            $method = self::$requestHandlingMap[get_class( $request )];
            return $this->$method( $request );
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

        $res = $this->checkViolations( $request, $reqGen );
        
        if ( $res !== null )
        {
            return $res;
        }

        $backend = ezcWebdavServer::getInstance()->backend;
        foreach ( $reqGen->getRequests() as $propPatch )
        {
            $propPatch->validateHeaders();
            $res = $backend->propPatch( $propPatch );
            if ( !( $res instanceof ezcWebdavPropPatchResponse ) )
            {
                return $res;
            }
        }

        return new ezcWebdavLockResponse(
            $reqGen->getMainLockDiscoveryProperty()
        );
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
     * Checks
     * 
     * @param ezcWebdavRequest $request 
     * @param ezcWebdavLockRequestGenerator $generator 
     * @return void
     */
    protected function checkViolations( ezcWebdavRequest $request, ezcWebdavLockRequestGenerator $generator = null )
    {
        $srv = ezcWebdavServer::getInstance();

        $propFind       = new ezcWebdavPropFindRequest( $request->requestUri );
        $propFind->prop = new ezcWebdavBasicPropertyStorage();

        $propFind->prop->attach( new ezcWebdavLockDiscoveryProperty() );
        $propFind->prop->attach( new ezcWebdavGetEtagProperty() );
        $propFind->prop->attach( new ezcWebdavLockInfoProperty() );

        $propFind->setHeader(
            'Depth',
            ( $depth = $request->getHeader( 'Depth' ) ) !== null ? $depth : ezcWebdavRequest::DEPTH_ONE
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
                    $request,
                    $propFindRes->node->path,
                    ezcWebdavAuthorizer::ACCESS_WRITE
                 ) 
            )
            {
                $violations[] = $srv->createUnauthorizedResponse(
                    $propFindRes->node->path,
                    'Authorization failed'
                );
                // No need for further checks on this path
                continue;
            }

            if ( ( $res = $this->checkEtagsAndLocks( $propFindRes, $request ) ) !== null )
            {
                $violations[] = $res;
            }

            // Notify request generator on affected ressource
            if ( $generator !== null )
            {
                $generator->notify( $propFindRes );
            }

            // Store main lock property for use in MultiStatus
            if ( $propFindRes->node->path === $request->requestUri )
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

        if ( $violations !== array() )
        {
            // RFC requires the <lockdiscovery> property to be included
            $propStatRes = new ezcWebdavPropStatResponse(
                new ezcWebdavBasicPropertyStorage(),
                ezcWebdavResponse::STATUS_424
            );
            $propStatRes->storage->attach( $mainLockProperty );
            $violations[] = new ezcWebdavPropFindResponse(
                $mainLockNode,
                $propStatRes
            );

            return new ezcWebdavMultistatusResponse( $violations );
        }
        // return null;
    }

    /**
     * Checks the given properties for violations in the given request headers.
     *
     * Checks the If header of the given request against the lock tokens and
     * the ETag assigned to a resource affected by the $req.
     * 
     * @param ezcWebdavPropertyStorage $propertyStorage 
     * @param ezcWebdavRequest $request
     * @return void
     */
    protected function checkEtagsAndLocks( ezcWebdavPropFindResponse $propFindRes, ezcWebdavRequest $request )
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
                $storage = $propStatRes->storage;
                $lockDiscoveryProp = ( $storage->contains( 'lockdiscovery' ) ? $storage->get( 'lockdiscovery' ) : null );
                $getEtagProp = ( $storage->contains( 'getetag' ) ? $storage->get( 'getetag' ) : null );
            }
        }

        // Extract If header items relevant for the given $request
        if ( ( $ifHeader = $request->getHeader( 'If' ) ) === null ||
             ( $ifHeaderItems = $ifHeader[$path] ) === array()
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

        $verified = false;

        // Logical OR connected items
        foreach ( $ifHeaderItems as $item )
        {
            // Logical AND connected etags and lockitems
            foreach ( $item->eTags as $itemEtag )
            {
                if ( $etag !== $itemEtag )
                {
                    // Etag condition failed, check next condition set
                    continue 2;
                }
            }
            foreach ( $item->lockTokens as $itemLockToken )
            {
                if ( !in_array( $itemLockToken, $lockTokens ) )
                {
                    // Lock token condition failed, check next condition set
                    continue 2;
                }
            }
            // All tests passed for this condition set
            $verified = true;
            break;
        }

        if ( !$verified )
        {
            return new ezcWebdavErrorResponse(
                ezcWebdavResponse::STATUS_409,
                $path,
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
