<?php
/**
 * File containing the ezcWebdavLockPropPatchRequestResponseHandler class.
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
 * Handler class for the PROPPATCH request.
 *
 * This class provides plugin callbacks for the PROPPATCH request for {@link
 * ezcWebdavLockPlugin}.
 * 
 * @package Webdav
 * @version //autogen//
 *
 * @access private
 */
class ezcWebdavLockPropPatchRequestResponseHandler extends ezcWebdavLockRequestResponseHandler
{
    /**
     * Handles PROPPATCH requests.
     *
     * Performs all lock related checks necessary for the PROPPATCH request. In
     * case a violation with locks is detected or any other pre-condition check
     * fails, this method returns an instance of {@link ezcWebdavResponse}. If
     * everything is correct, null is returned, so that the $request is handled
     * by the backend.
     *
     * @param ezcWebdavPropPatchRequest $request 
     * @return ezcWebdavResponse
     */
    public function receivedRequest( ezcWebdavRequest $request )
    {
        $ifHeader = $request->getHeader( 'If' );

        $targetLockRefresher = null;
        if ( $ifHeader !== null )
        {
            $targetLockRefresher = new ezcWebdavLockRefreshRequestGenerator(
                $request
            );
        }

        $violation = $this->tools->checkViolations(
            new ezcWebdavLockCheckInfo(
                $request->requestUri,
                ezcWebdavRequest::DEPTH_ZERO,
                $request->getHeader( 'If' ),
                $request->getHeader( 'Authorization' ),
                ezcWebdavAuthorizer::ACCESS_WRITE,
                $targetLockRefresher,
                false
            ),
            true
        );

        if ( $violation !== null )
        {
            // ezcWebdavErrorResponse
            return $violation;
        }

        // Lock refresh must occur no matter if the request succeeds
        if ( $targetLockRefresher !== null )
        {
            $targetLockRefresher->sendRequests();
        }

        if ( $request->updates->contains( 'lockdiscovery' ) )
        {
            return new ezcWebdavMultistatusResponse(
                new ezcWebdavErrorResponse(
                    ezcWebdavResponse::STATUS_409,
                    $request->requestUri,
                    "Property 'lockdiscovery' is readonly."
                )
            );
        }
        if ( $request->updates->contains( 'lockinfo' ) )
        {
            return new ezcWebdavMultistatusResponse(
                new ezcWebdavErrorResponse(
                    ezcWebdavResponse::STATUS_409,
                    $request->requestUri,
                    "Property 'lockinfo' is readonly."
                )
            );
        }
    }

    /**
     * Handles responses to the PROPPATCH request.
     *
     * Dummy method to satisfy interface. Does nothing at all, since no checks
     * are necessary.
     * 
     * @param ezcWebdavResponse $response 
     * @return null
     */
    public function generatedResponse( ezcWebdavResponse $response )
    {
    }
}

?>
