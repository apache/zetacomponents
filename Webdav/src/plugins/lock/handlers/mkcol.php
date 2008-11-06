<?php
/**
 * File containing the ezcWebdavLockMakeCollectionRequestResponseHandler class.
 *
 * @package Webdav
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 *
 * @access private
 */
/**
 * Handler class for the MKCOL request.
 * 
 * @package Webdav
 * @version //autogen//
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 *
 * @access private
 */
class ezcWebdavLockMakeCollectionRequestResponseHandler extends ezcWebdavLockRequestResponseHandler
{
    /**
     * MKCOL request. 
     * 
     * @var ezcWebdavMakeCollectionRequst
     */
    protected $request;
    
    /**
     * Lock properties to be updated after processing. 
     * 
     * @var ezcWebdavBasicPropertyStorage
     */
    protected $lockProperties;

    /**
     * Handles GET requests.
     *
     * @param ezcWebdavUnlockRequest $request 
     * @return ezcWebdavResponse
     */
    public function receivedRequest( ezcWebdavRequest $request )
    {
        $this->request = $request;

        $target = $request->requestUri;
        $parent = dirname( $target );

        $ifHeader   = $request->getHeader( 'If' );
        $authHeader = $request->getHeader( 'Authorization' );

        $observer = new ezcWebdavLockMultipleCheckObserver();

        $targetLockRefresher = null;
        if ( $ifHeader !== null )
        {
            $targetLockRefresher = new ezcWebdavLockRefreshRequestGenerator(
                $request
            );
            $observer->attach( $targetLockRefresher );
        }

        $propertyCollector = new ezcWebdavLockCheckPropertyCollector();
        $observer->attach( $propertyCollector );

        $violations = $this->tools->checkViolations(
            new ezcWebdavLockCheckInfo(
                $target,
                ezcWebdavRequest::DEPTH_ZERO,
                $ifHeader,
                $authHeader,
                ezcWebdavAuthorizer::ACCESS_WRITE,
                $observer
            ),
            true
        );

        $targetExists = true;
        if ( $violations !== null )
        {
            if ( $violations->responses[0]->status !== ezcWebdavResponse::STATUS_404 )
            {
                // Desired collection exists and conditions are violated
                return $violations;
            }
            if ( $violations->responses[0]->status === ezcWebdavResponse::STATUS_404 )
            {
                $targetExists = false;
                // Desired collection does not exist, check parent
                $violations = $this->tools->checkViolations(
                    new ezcWebdavLockCheckInfo(
                        $parent,
                        ezcWebdavRequest::DEPTH_ZERO,
                        $ifHeader,
                        $authHeader,
                        ezcWebdavAuthorizer::ACCESS_WRITE,
                        $observer
                    ),
                    true
                );
                if ( $violations !== null )
                {
                    return $violations;
                }
            }
        }

        // Lock refresh must occur no matter if the request succeeds
        if ( $targetLockRefresher !== null )
        {
            $targetLockRefresher->sendRequests();
        }

        // Delete lock null before performing the request
        if ( $targetExists )
        {
            $targetProps          = $propertyCollector->getProperties( $target );
            $this->lockProperties = clone $targetProps;
            $lockInfoProp         = $targetProps->get(
                'lockinfo',
                ezcWebdavLockPlugin::XML_NAMESPACE
            );

            if ( $lockInfoProp !== null && $lockInfoProp->null )
            {
                $deleteReq = new ezcWebdavDeleteRequest( $target );
                ezcWebdavLockTools::cloneRequestHeaders( $request, $deleteReq );
                $deleteReq->validateHeaders();
                $deleteRes = ezcWebdavServer::getInstance()->backend->delete(
                    $deleteReq
                );
                if ( !( $deleteRes instanceof ezcWebdavDeleteResponse ) )
                {
                    throw new ezcWebdavInconsistencyException(
                        'Lock null resource could not be deleted, but check did not cause violations.'
                    );
                }

                // Update property
                $lockInfoProp->null = false;
            }
        }

        if ( !isset( $this->lockProperties ) )
        {
            $lockProperties    = $propertyCollector->getProperties( $parent );
            $lockDiscoveryProp = $lockProperties->get( 'lockdiscovery' );

            // Only need to set lock from parent, if this one is locked with depth greater 0.
            // @TODO: This must be changed if we once support more lock types.
            if ( $lockDiscoveryProp !== null
                 && $lockDiscoveryProp->activeLock[0]->depth !== ezcWebdavRequest::DEPTH_ZERO
            )
            {
                $this->lockProperties = clone $lockProperties;
                $lockInfoProp = $this->lockProperties->get(
                    'lockinfo',
                    ezcWebdavLockPlugin::XML_NAMESPACE
                );
                if ( $lockInfoProp !== null && $lockInfoProp->tokenInfos[0]->lockBase === null )
                {
                    $lockInfoProp->tokenInfos[0]->lockBase   = $parent;
                    $lockInfoProp->tokenInfos[0]->lastAccess = null;
                }
            }
        }

        return null;
    }

    /**
     * Handles responses to the MKCOL request.
     *
     *
     * @param ezcWebdavResponse $response 
     * @return ezcWebdavResponse|null
     */
    public function generatedResponse( ezcWebdavResponse $response )
    {
        if ( !( $response instanceof ezcWebdavMakeCollectionResponse ) )
        {
            return null;
        }
        
        $this->updateLockProperties();
    }

    /**
     * Updates the lock properties on the target.
     *
     * Performs the neccessary PROPPATCH requests to update the lock properties
     * on the target (parent is locked or was lock null before).
     * 
     * @return void
     */
    protected function updateLockProperties()
    {
        if ( $this->lockProperties !== null )
        {
            $propPatchReq = new ezcWebdavPropPatchRequest(
                $this->request->requestUri
            );
            ezcWebdavLockTools::cloneRequestHeaders(
                $this->request,
                $propPatchReq
            );
            $propPatchReq->validateHeaders();
            $propPatchReq->updates->attach(
                $this->lockProperties->get( 'lockdiscovery' ),
                ezcWebdavPropPatchRequest::SET
            );
            $propPatchReq->updates->attach(
                $this->lockProperties->get( 'lockinfo', ezcWebdavLockPlugin::XML_NAMESPACE ),
                ezcWebdavPropPatchRequest::SET
            );
            // Don't care about the result, it's to late here anyway
            $propPatchRes = ezcWebdavServer::getInstance()->backend->propPatch(
                $propPatchReq
            );

            if ( !( $propPatchRes instanceof ezcWebdavPropPatchResponse ) )
            {
                throw new ezcWebdavInconsistencyException(
                    'Could not patch lock properties on newly created resource/collection.'
                );
            }
        }
    }
}

?>
