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
    );

    /**
     * Creates the objects needed for dispatching the hooks.
     * 
     * @return void
     */
    public function __construct()
    {
        $this->transport       = new ezcWebdavLockPluginTransport();
        $this->propertyHandler = new ezcWebdavLockPluginPropertyHandler();
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
     *
     * Reacts on the LOCK and UNLOCK request methods.
     * 
     * @param ezcWebdavPluginParameters $params 
     * @return void
     */
    public function parseRequest( ezcWebdavPluginParameters $params )
    {
        switch ( $_SERVER['REQUEST_METHOD'] )
        {
            case 'LOCK':
                return $this->transport->parseLockRequest( $params['path'], $params['body'] );
            case 'UNLOCK':
                return $this->transport->parseUnlockRequest( $params['path'], $params['body'] );
        }
    }

    /**
     * Callback for the hook ezcWebdavTransport::handleUnknownResponse().
     *
     * Parameters are:
     * - ezcWebdavResponse reponse
     * 
     * @param ezcWebdavPluginParameters $params 
     * @return void
     */
    public function handleResponse( ezcWebdavPluginParameters $params )
    {
        // @todo anything to do here?
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
     * @return void
     */
    public function receivedRequest( ezcWebdavPluginParameters $params )
    {
        switch ( true )
        {
            case ( $params['request'] instanceof ezcWebdavLockRequest ):
                return $this->handleLockRequest( $params['request'] );
            case ( $params['request'] instanceof ezcWebdavUnlockRequest ):
                return $this->handleUnlockRequest( $params['request'] );
        }
    }

    /**
     * handleLockRequest 
     * 
     * Internal notes:
     *
     * A lock token must be unique throughout all resources for all times. The code snippet
     *
     * <code>
     * $token = md5( uniqid( rand(), true ) ); 
     * </code>
     *
     * Should therefore be used to generate a unique ID. This ID should be
     * appended to the URI of the resource affected. This combination should be
     * sufficiently unique. (e.g. http://webdav/foo/bar.txt#<id>)
     *
     * Everybody has access to lock tokens, so the lock must be bound to a
     * different authetication mechanism. We will go for the IP address in a
     * first glance here and must extend this to be plugable at a later stage,
     * to tie-in Authentication.
     *
     * @todo Tie in Authentication to authenticate for locking
     * @todo A mechanism to determine authorization?
     * 
     * Alternatively: Opaquelock token scheme.
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
        // New lock
        if ( isset( $request->lockInfo ) )
        {
            if ( ( $res = $this->checkLock( $request ) ) !== null )
            {
                return $res;
            }
            return $this->accquireLock( $request );
        }
        // Lock refresh
        else
        {
            return $this->refreshLock( $request );
        }
    }

    /**
     * Checks for active locks.
     * 
     * @param ezcWebdavLockRequest $request 
     * @return null|ezcWebdavErrorResponse Null on success.
     */
    protected function checkLock( ezcWebdavLockRequest $request )
    {
        $propFindRequest = new ezcWebdavPropFindRequest( $request->requestUri );
        $propFindRequest->prop = new ezcWebdavPropertyStorage();
        $propFindRequest->prop->attach(
            new ezcWebdavLockDiscoveryProperty()
        );
        $propFindRequest->prop->attach(
            new ezcWebdavSupportedLockProperty()
        );
        $propFindRequest->setHeader(
            'Depth',
            $request->getHeader( 'Depth' )
        );

        $propFindResponse = ezcWebdavServer::getInstance()->backend->performRequest(
            $propFindRequest
        );

        // Return error, if occured
        if ( $propFindRequest instanceof ezcWebdavErrorResponse )
        {
            return $propFindRequest;
        }
        
        return $this->checkLocks(
            $request,
            $propFindResponse
        );
    }

    /**
     * Checks a response for lock violations.
     * 
     * @param ezcWebdavLockRequest $request 
     * @param ezcWebdavResponse $response 
     * @return null|ezcWebavErrorResponse Null on success.
     */
    protected function checkLockViolation( ezcWebdavLockRequest $request, ezcWebdavResponse $response )
    {
        if ( $response instanceof ezcWebdavMultistatusResponse )
        {
            foreach ( $reponse->responses as $subResponse )
            {
                if ( ( $res = $this->checkLockViolation( $request, $subResponse ) ) !== null )
                {
                    // A recursive call produced an error
                    return $res;
                }
            }
        }
        else if ( $response instanceof ezcWebdavPropFindResponse )
        {
            // Check the propfind response for violations and return error in
            // case
        }
        else
        {
            // Found an invalid response, return it
            return $response;
        }
    }

    /**
     * Handle ezcWebdavUnlockRequest objects.
     * 
     * @param ezcWebavUnlockRequest $request 
     * @return void
     */
    protected function handleUnlockRequest( ezcWebavUnlockRequest $request )
    {

    }

    /**
     * Callback for the hook ezcWebdavServer::generatedResponse().;
     *
     * Parameters are:
     * - ezcWebdavResponse response
     * 
     * @param ezcWebdavPluginParameters $params 
     * @return void
     */
    public function generatedResponse( ezcWebdavPluginParameters $params )
    {
        // @todo: Anything to do here?
    }

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
                if ( !( $propertyValue instanceof ezcWebdavLockPluginTransport ) )
                {
                    throw new ezcBaseValueException( $propertyName, $propertyValue, 'ezcWebdavLockPluginTransport' );
                }
                break;
            case 'propertyHandler':
                if ( !( $propertyValue instanceof ezcWebdavLockPluginPropertyHandler ) )
                {
                    throw new ezcBaseValueException( $propertyName, $propertyValue, 'ezcWebdavLockPluginPropertyHandler' );
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
