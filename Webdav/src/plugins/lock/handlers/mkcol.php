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
     * Lock property to be updated after processing. 
     * 
     * @var ezcWebdavLockDiscoveryProperty
     */
    protected $lockDiscoveryProp;

    /**
     * Lock property to be updated after processing. 
     * 
     * @var ezcWebdavLockInfoProperty
     */
    protected $lockInfoProp;

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

        $violation = $this->tools->checkViolations(
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
        if ( $violation !== null )
        {
            if ( $violation->status !== ezcWebdavResponse::STATUS_404 )
            {
                // Desired collection exists and conditions are violated
                return $violation;
            }
            if ( $violation->status === ezcWebdavResponse::STATUS_404 )
            {
                $targetExists = false;
                // Desired collection does not exist, check parent
                $violation = $this->tools->checkViolations(
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
                if ( $violation !== null )
                {
                    if ( $violation->status === ezcWebdavResponse::STATUS_404 )
                    {
                        // The parent does not exist, not the target.
                        $violation->status = ezcWebdavResponse::STATUS_409;
                    }
                    return $violation;
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
            $targetProps  = $propertyCollector->getProperties( $target );
            $lockInfoProp = $targetProps->get(
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
            }
            // Clone and update properties
            if ( $lockInfoProp !== null )
            {
                $this->lockInfoProp       = clone $lockInfoProp;
                $this->lockInfoProp->null = false;
                $this->lockDiscoveryProp  = clone $targetProps->get( 'lockdiscovery' );
            }
        }

        if ( !$targetExists )
        {
            // Target does not exist or is not locked
            $lockProperties    = $propertyCollector->getProperties( $parent );
            $lockDiscoveryProp = $lockProperties->get( 'lockdiscovery' );

            // Only need to set lock from parent, if this one is locked with depth greater 0.
            // @TODO: This must be changed if we once support shared locks.
            if ( $lockDiscoveryProp !== null && count( $lockDiscoveryProp->activeLock ) > 0
                 && $lockDiscoveryProp->activeLock[0]->depth !== ezcWebdavRequest::DEPTH_ZERO
            )
            {
                $lockInfoProp = $lockProperties->get(
                    'lockinfo',
                    ezcWebdavLockPlugin::XML_NAMESPACE
                );
                // Sanity check
                if ( $lockInfoProp === null )
                {
                    throw new ezcWebdavInconsistencyException(
                        "Properties lock discovery and lock info out of sync on '$parent'."
                    );
                }
                $this->lockDiscoveryProp = clone $lockDiscoveryProp;
                $this->lockInfoProp      = clone $lockInfoProp;
                // If $parent is a lock base, indicate it for the new child
                foreach ( $this->lockInfoProp->tokenInfos as $tokenInfo )
                {
                    if ( $tokenInfo->lockBase === null )
                    {
                        $tokenInfo->lockBase   = $parent;
                        $tokenInfo->lastAccess = null;
                    }
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
        if ( $this->lockDiscoveryProp !== null )
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
                $this->lockDiscoveryProp,
                ezcWebdavPropPatchRequest::SET
            );
            $propPatchReq->updates->attach(
                $this->lockInfoProp,
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
