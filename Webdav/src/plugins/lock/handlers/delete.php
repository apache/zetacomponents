<?php
/**
 * File containing the ezcWebdavLockDeleteRequestResponseHandler class.
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
 * Handler class for the DELETE request.
 *
 * This class provides plugin callbacks for the DELETE request for {@link
 * ezcWebdavLockPlugin}.
 * 
 * @package Webdav
 * @version //autogen//
 *
 * @access private
 */
class ezcWebdavLockDeleteRequestResponseHandler extends ezcWebdavLockRequestResponseHandler
{
    /**
     * Handles DELETE requests.
     *
     * Performs all lock related checks necessary for the DELETE request. In case
     * a violation with locks is detected or any other pre-condition check
     * fails, this method returns an instance of {@link ezcWebdavResponse}. If
     * everything is correct, null is returned, so that the $request is handled
     * by the backend.
     *
     * @param ezcWebdavRequest $request ezcWebdavDeleteRequest
     * @return ezcWebdavResponse|null
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
                ezcWebdavRequest::DEPTH_INFINITY,
                $request->getHeader( 'If' ),
                $request->getHeader( 'Authorization' ),
                ezcWebdavAuthorizer::ACCESS_WRITE,
                $targetLockRefresher
            ),
            true
        );

        // Lock refresh must occur no matter if the request succeeds
        if ( $targetLockRefresher !== null )
        {
            $targetLockRefresher->sendRequests();
        }

        if ( $violation !== null )
        {
            // ezcWebdavErrorResponse
            return $violation;
        }
    }

    /**
     * Handles responses to the DELTE request.
     *
     * Dummy method to satisfy interface. Nothing to do, if the DELETE request
     * succeeded or failed.
     * 
     * @param ezcWebdavResponse $response 
     * @return null
     */
    public function generatedResponse( ezcWebdavResponse $response )
    {
    }
}

?>
