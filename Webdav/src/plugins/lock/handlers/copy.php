<?php
/**
 * File containing the ezcWebdavLockCopyRequestResponseHandler class.
 *
 * @package Webdav
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 *
 * @access private
 */
/**
 * Handler class for the COPY request.
 * 
 * @package Webdav
 * @version //autogen//
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 *
 * @access private
 */
class ezcWebdavLockCopyRequestResponseHandler extends ezcWebdavLockRequestResponseHandler
{
    /**
     * Properties of the destination parent.
     *
     * These properties need to be set on the successfully moved the source to
     * the destination. The properties still need to be manipulated in {@link
     * generatedResponse()}
     * 
     * @var ezcWebdavBasicPropertyStorage
     */
    protected $lockProperties;

    /**
     * The original request.
     * 
     * @var ezcWebdavCopyRequest
     */
    protected $request;

    /**
     * Pathes moved to the destination.
     *
     * Used to determine all paths that need lock updates.
     * 
     * @var array(string)
     */
    protected $sourcePaths;

    /**
     * Handles COPY requests.
     *
     * @param ezcWebdavMoveRequest $request 
     * @return ezcWebdavResponse
     */
    public function receivedRequest( ezcWebdavRequest $request )
    {
        $backend = ezcWebdavServer::getInstance()->backend;

        $this->request = $request;

        $destination = $request->getHeader( 'Destination' );
        $destParent  = dirname( $destination );
        $ifHeader    = $request->getHeader( 'If' );
        $authHeader  = $request->getHeader( 'Authorization' );

        // Check destination parent and collect the lock properties to
        // set after successfully moving

        $multiObserver = new ezcWebdavLockMultipleCheckObserver();

        $destinationPropertyCollector = new ezcWebdavLockCheckPropertyCollector();
        $multiObserver->attach( $destinationPropertyCollector );

        $destinationLockRefresher = null;
        if ( $ifHeader !== null )
        {
            $destinationLockRefresher = new ezcWebdavLockRefreshRequestGenerator(
                $request
            );
            $multiObserver->attach( $destinationLockRefresher );
        }

        $violation = $this->tools->checkViolations(
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
            // Return on first violation
            true
        );

        // Perform lock refresh (must occur no matter if request succeeds)
        if ( $destinationLockRefresher !== null )
        {
            $destinationLockRefresher->sendRequests();
        }

        if ( $violation !== null )
        {
            if ( $violation->status === ezcWebdavResponse::STATUS_404 )
            {
                // Destination parent not found
                return new ezcWebdavErrorResponse(
                    ezcWebdavResponse::STATUS_409,
                    $response->requestUri
                );
            }
            return $violation;
        }

        // Check destination itself, if it exsists

        $violation = $this->tools->checkViolations(
            // Destination (maybe overwritten, maybe not, but we must not
            // care)
            new ezcWebdavLockCheckInfo(
                $destination,
                ezcWebdavRequest::DEPTH_INFINITY,
                $ifHeader,
                $authHeader,
                ezcWebdavAuthorizer::ACCESS_WRITE,
                null,
                false // No lock-null allowed @TODO: Really?
            ),
            // Return on first violation
            true
        );

        // Destination might be there but not violated, or might not be there
        if ( $violation !== null && $violation->status !== ezcWebdavResponse::STATUS_404 )
        {
            // ezcWebdavErrorResponse
            return $violation;
        }

        // Store infos for use on correct moving
        
        $destParentProps = $destinationPropertyCollector->getProperties(
                $destParent
        );

        // Consistency check
        if ( ( $destParentProps->contains( 'lockdiscovery' ) && count( $destParentProps->get( 'lockdiscovery' )->activeLock ) > 0 )
             ^ $destParentProps->contains( 'lockinfo', ezcWebdavLockPlugin::XML_NAMESPACE )
           )
        {
            throw new ezcWebdavInconsistencyException(
                "Resource '{$request->requestUri}' has inconsisten lock properties."
            );
        }
        $this->lockProperties = $destParentProps;

        $sourcePaths = $this->getSourcePaths();
        if ( is_object( $sourcePaths ) )
        {
            // ezcWebdavErrorResponse
            return $sourcePaths;
        }
        $this->sourcePaths = $sourcePaths;

        // Backend now handles the request
        return null;
    }

    /**
     * Returns all pathes in the copy source.
     *
     * This method performs the necessary checks on the source to copy. It
     * returns all paths that are to be moved. In case of any violation of the
     * checks, the method must hold and return an instance of
     * ezcWebdavErrorResponse instead of the desired paths.
     * 
     * @return array(string)|ezcWebdavErrorResponse
     */
    protected function getSourcePaths()
    {
        $propFindReq = new ezcWebdavPropFindRequest( $this->request->requestUri );
        $propFindReq->prop = new ezcWebdavBasicPropertyStorage();
        $propFindReq->prop->attach( new ezcWebdavLockInfoProperty() );
        $propFindReq->prop->attach( new ezcWebdavLockDiscoveryProperty() );
        ezcWebdavLockTools::cloneRequestHeaders(
            $this->request,
            $propFindReq,
            array( 'If', 'Depth' )
        );
        $propFindReq->validateHeaders();

        $propFindMultiStatusRes = ezcWebdavServer::getInstance()->backend->propFind(
            $propFindReq
        );

        if ( !( $propFindMultiStatusRes instanceof ezcWebdavMultiStatusResponse ) )
        {
            return $propFindMultiStatusRes;
        }

        $paths = array();
        foreach ( $propFindMultiStatusRes->responses as $propFindRes )
        {
            $paths[] = $propFindRes->node->path;
            foreach ( $propFindRes->responses as $propStatRes )
            {
                if ( $propStatRes->status === ezcWebdavResponse::STATUS_200
                     && $propStatRes->storage->contains( 'lockinfo', ezcWebdavLockPlugin::XML_NAMESPACE )
                     && $propStatRes->storage->get( 'lockinfo', ezcWebdavLockPlugin::XML_NAMESPACE )->null
                )
                {
                    return $this->tools->createLockFailureResponse(
                        array(
                            ezcWebdavErrorResponse(
                                ezcWebdavResponse::STATUS_405,
                                $propFindRes->node->path,
                                'Operation not posible on lock null resource.'
                            ),
                        ),
                        $propFind->node,
                        $propStatRes->storage->get( 'lockdiscovery' )
                    );
                }
            }
        }
        return $paths;
    }

    /**
     * Handles responses to the COPY request.
     * 
     * @param ezcWebdavCopyResponse $response 
     * @return ezcWebdavResponse|null
     */
    public function generatedResponse( ezcWebdavResponse $response )
    {
        if ( !( $response instanceof ezcWebdavCopyResponse ) )
        {
            return null;
        }

        $backend = ezcWebdavServer::getInstance()->backend;

        // Backend successfully performed request, update with LOCK from parent

        $request    = $this->request;
        $source     = $request->requestUri;
        $dest       = $request->getHeader( 'Destination' );
        $destParent = dirname( $dest );
        $paths      = $this->sourcePaths;

        // Empty lock discovery to remove existing locks on destination,
        // if destination parent was not locked
        $lockDiscovery = ( $this->lockProperties->contains( 'lockdiscovery' )
            ? clone $this->lockProperties->get( 'lockdiscovery' )
            : new ezcWebdavLockDiscoveryProperty()
        );

        // Empty lock info (will be used for removal), if destination parent
        // was not locked
        $lockInfo =  ( $this->lockProperties->contains( 'lockinfo', ezcWebdavLockPlugin::XML_NAMESPACE )
            ? clone $this->lockProperties->get( 'lockinfo', ezcWebdavLockPlugin::XML_NAMESPACE )
            : new ezcWebdavLockInfoProperty()
        );

        // Sanity check
        if ( count( $lockDiscovery->activeLock ) !== count( $lockInfo->tokenInfos ) )
        {
            throw new ezcWebdavInconsistencyException(
                'Lock discovery and lock info properties out of sync.'
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
            $newPath      = str_replace( $source, $dest, $path );
            $propPatchReq = new ezcWebdavPropPatchRequest( $newPath );
            // Lock discovery is a live property, may not be removed
            $propPatchReq->updates->attach( $lockDiscovery, ezcWebdavPropPatchRequest::SET );
            // Lock info is dead
            $propPatchReq->updates->attach(
                $lockInfo,
                ( count( $lockInfo->tokenInfos ) !== 0
                    ? ezcWebdavPropPatchRequest::SET
                    : ezcWebdavPropPatchRequest::REMOVE
                )
            );
            ezcWebdavLockTools::cloneRequestHeaders(
                $request,
                $propPatchReq
            );
            $propPatchReq->validateHeaders();

            $propPatchRes = $backend->propPatch( $propPatchReq );

            if ( !( $propPatchRes instanceof ezcWebdavPropPatchResponse ) )
            {
                throw new ezcWebdavInconsistencyException(
                    "Could not set lock on resource {$newPath}."
                );
            }
        }
       
        return null;
    }
}

?>
