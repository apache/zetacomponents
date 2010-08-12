<?php
/**
 * File containing the ezcWebdavLockMakeCollectionRequestResponseHandler class.
 *
 * Licensed to the Apache Software Foundation (ASF) under one
 * or more contributor license agreements.  See the NOTICE file
 * distributed with this work for additional information
 * regarding copyright ownership.  The ASF licenses this file
 * to you under the Apache License, Version 2.0 (the
 * "License"); you may not use this file except in compliance
 * with the License.  You may obtain a copy of the License at
 * 
 *   http://www.apache.org/licenses/LICENSE-2.0
 * 
 * Unless required by applicable law or agreed to in writing,
 * software distributed under the License is distributed on an
 * "AS IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS OF ANY
 * KIND, either express or implied.  See the License for the
 * specific language governing permissions and limitations
 * under the License.
 *
 * @package Webdav
 * @version //autogentag//
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 *
 * @access private
 */
/**
 * Handler class for the MKCOL request.
 *
 * This class provides plugin callbacks for the MKCOL request for {@link
 * ezcWebdavLockPlugin}.
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
     * If the lock property above is from the parent or the destination itself. 
     * 
     * @var book
     */
    protected $isParentProp = false;

    /**
     * Handles MKCOL requests.
     *
     * Performs all lock related checks necessary for the MKCOL request. In
     * case a violation with locks is detected or any other pre-condition check
     * fails, this method returns an instance of {@link ezcWebdavResponse}. If
     * everything is correct, null is returned, so that the $request is handled
     * by the backend.
     *
     * @param ezcWebdavRequest $request ezcWebdavMakeCollectionRequest
     * @return ezcWebdavResponse|null
     */
    public function receivedRequest( ezcWebdavRequest $request )
    {
        $this->request = $request;

        $target = $request->requestUri;
        $parent = dirname( $target );

        $ifHeader   = $request->getHeader( 'If' );
        $authHeader = $request->getHeader( 'Authorization' );

        $targetLockRefresher = null;
        if ( $ifHeader !== null )
        {
            $targetLockRefresher = new ezcWebdavLockRefreshRequestGenerator(
                $request
            );
        }

        $violation = $this->tools->checkViolations(
            new ezcWebdavLockCheckInfo(
                $target,
                ezcWebdavRequest::DEPTH_ZERO,
                $ifHeader,
                $authHeader,
                ezcWebdavAuthorizer::ACCESS_WRITE,
                $targetLockRefresher
            ),
            true
        );

        if ( $violation !== null && $violation->status !== ezcWebdavResponse::STATUS_404 )
        {
            // Desired collection exists and conditions are violated
            return $violation;
        }

        if ( $violation !== null && $violation->status === ezcWebdavResponse::STATUS_404 )
        {
            // Desired collection does not exist, check parent
            $violation = $this->tools->checkViolations(
                new ezcWebdavLockCheckInfo(
                    $parent,
                    ezcWebdavRequest::DEPTH_ZERO,
                    $ifHeader,
                    $authHeader,
                    ezcWebdavAuthorizer::ACCESS_WRITE,
                    $targetLockRefresher
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

        // Lock refresh must occur no matter if the request succeeds
        if ( $targetLockRefresher !== null )
        {
            $targetLockRefresher->sendRequests();

            // Store property for later patching
            $this->lockDiscoveryProp = $targetLockRefresher->getLockDiscoveryProperty(
                $target
            );
            if ( $this->lockDiscoveryProp === null )
            {
                $this->lockDiscoveryProp = $targetLockRefresher->getLockDiscoveryProperty(
                    $parent
                );
                $this->isParentProp = true;
            }
        }

        return null;
    }

    /**
     * Handles responses to the MKCOL request.
     *
     * This method reacts on the response generated by the backend for a MKCOL
     * request. It takes care of adding all necessary locks to the newly
     * created collection, indicated by its parent.
     *
     * Returns null, if no errors occured, an {@link ezcWebdavErrorResponse}
     * otherwise.
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
     */
    protected function updateLockProperties()
    {
        if ( !$this->isParentProp )
        {
            // No need to update
            return null;
        }

        $lockDiscoveryProp = (
            $this->lockDiscoveryProp !== null
                ? clone $this->lockDiscoveryProp
                : new ezcWebdavLockDiscoveryProperty()
        );

        $destParent  = dirname( $this->request->requestUri );

        foreach ( $lockDiscoveryProp->activeLock as $id => $activeLock )
        {
            if ( $activeLock->depth !== ezcWebdavRequest::DEPTH_INFINITY )
            {
                unset( $lockDiscoveryProp->activeLock[$id] );
                continue;
            }

            if ( $activeLock->baseUri === null )
            {
                $activeLock->baseUri   = $destParent;
                $activeLock->lastAccess = null;
            }
        }

        $propPatchReq = new ezcWebdavPropPatchRequest(
            $this->request->requestUri
        );
        
        ezcWebdavLockTools::cloneRequestHeaders(
            $this->request,
            $propPatchReq
        );
        $propPatchReq->validateHeaders();

        $propPatchReq->updates->attach(
            $lockDiscoveryProp,
            ezcWebdavPropPatchRequest::SET
        );

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

?>
