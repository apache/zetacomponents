<?php
/**
 * File containing the ezcWebdavLockRequestResponseHandler class.
 *
 * @package Webdav
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 *
 * @access private
 */
/**
 * Handler class for the LOCK request.
 * 
 * @package Webdav
 * @version //autogen//
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 *
 * @access private
 */
class ezcWebdavLockLockRequestResponseHandler extends ezcWebdavLockRequestResponseHandler
{
    /**
     * Handles responses to the LOCK request.
     *
     * Unused since the LOCK request is completely handled by {@link
     * receivedRequest()}.
     *
     * @param ezcWebdavLockResponse $response 
     * @return ezcWebdavResponse|null
     */
    public function generatedResponse( ezcWebdavResponse $response )
    {
        return null;
    }

    /**
     * Handles LOCK requests (completely).
     *
     * {@inheritdoc}
     *
     * @param ezcWebdavLockRequest $request 
     * @return void
     */
    public function receivedRequest( ezcWebdavRequest $request )
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
    protected function acquireLock( ezcWebdavLockRequest $request )
    {
        $auth = ezcWebdavServer::getInstance()->auth;

        $authHeader = $request->getHeader( 'Authorization' );

        // Active lock part to be used in PROPPATCH requests and LOCK response
        $lockToken  = $this->tools->generateLockToken( $request );
        $activeLock = $this->tools->generateActiveLock(
            $request,
            $lockToken
        );

        // Generates PROPPATCH requests while checking violations
        $requestGenerator = new ezcWebdavLockLockRequestGenerator(
            $request,
            $activeLock
        );

        // Check violations and collect PROPPATCH requests
        $res = $this->tools->checkViolations(
            new ezcWebdavLockCheckInfo(
                $request->requestUri,
                $request->getHeader( 'Depth' ),
                $request->getHeader( 'If' ),
                $authHeader,
                ezcWebdavAuthorizer::ACCESS_WRITE,
                $requestGenerator
            )
        );

        if ( $res !== null )
        {
            // ezcWebdavMultistatusResponse, 1st 404 -> need to create
            // lock-null resource
            if ( $res->responses[0] instanceof ezcWebdavErrorResponse
                 && $res->responses[0]->status === ezcWebdavResponse::STATUS_404
            )
            {
                return $this->createLockNullResource( $request );
            }

            // Other violations -> return multistatus
            return $res;
        }

        // Assign lock to user
        $auth->assignLock( $authHeader->username, $lockToken );
        
        $affectedLockDiscovery = null;

        // Send all generated PROPPATCH requests to the backend to update lock information
        foreach ( $requestGenerator->getRequests() as $propPatch )
        {
            // Authorization for lock assignement
            ezcWebdavLockTools::cloneRequestHeaders( $request, $propPatch );
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

        $res = $this->tools->checkViolations(
            new ezcWebdavLockCheckInfo(
                $request->requestUri,
                $request->getHeader( 'Depth' ),
                $request->getHeader( 'If' ),
                $request->getHeader( 'Authorization' ),
                ezcWebdavAuthorizer::ACCESS_WRITE,
                $reqGen
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

        $checkRes = $this->tools->checkViolations(
            new ezcWebdavLockCheckInfo(
                dirname( $request->requestUri ),
                ezcWebdavRequest::DEPTH_ZERO,
                $request->getHeader( 'If' ),
                $request->getHeader( 'Authorization' ),
                ezcWebdavAuthorizer::ACCESS_WRITE
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
        ezcWebdavLockTools::cloneRequestHeaders( $request, $putReq, array( 'If' ) );
        $putReq->setHeader( 'Content-Length', '0' );
        $putReq->validateHeaders();

        $putRes = $backend->put( $putReq );

        if ( !( $putRes instanceof ezcWebdavPutResponse ) )
        {
            return $this->tools->createLockFailureResponse(
                array( $putRes ),
                new ezcWebdavResource( $request->requestUri )
            );
        }

        // Patch necessary properties
        
        $lockToken         = $this->tools->generateLockToken( $request );
        $lockDiscoveryProp = new ezcWebdavLockDiscoveryProperty(
            new ArrayObject(
                array(
                    $this->tools->generateActiveLock( $request, $lockToken )
                )
            )
        );

        $propPatchReq = new ezcWebdavPropPatchRequest( $request->requestUri );
        $propPatchReq->updates->attach(
            $lockDiscoveryProp,
            ezcWebdavPropPatchRequest::SET
        );
        $propPatchReq->updates->attach(
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
            ),
            ezcWebdavPropPatchRequest::SET
        );
        ezcWebdavLockTools::cloneRequestHeaders( $request, $propPatchReq );
        $propPatchReq->validateHeaders();

        $propPatchRes = $backend->propPatch( $propPatchReq );

        if ( !( $propPatchRes instanceof ezcWebdavPropPatchResponse ) )
        {
            return $this->tools->createLockFailureResponse(
                array( $propPatchRes ),
                new ezcWebdavResource( $request->requestUri )
            );
        }
        
        return new ezcWebdavLockResponse(
            $lockDiscoveryProp,
            $lockToken
        );
    }
}

?>
