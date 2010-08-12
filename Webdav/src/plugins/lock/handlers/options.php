<?php
/**
 * File containing the ezcWebdavLockOptionsRequestResponseHandler class.
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
 * Handler class for the OPTIONS request.
 *
 * This class provides plugin callbacks for the OPTIONS request for {@link
 * ezcWebdavLockPlugin}.
 * 
 * @package Webdav
 * @version //autogen//
 *
 * @access private
 */
class ezcWebdavLockOptionsRequestResponseHandler extends ezcWebdavLockRequestResponseHandler
{
    /**
     * If this handler requires the backend to get locked. 
     * 
     * @var bool
     */
    public $needsBackendLock = false;

    /**
     * Handles OPTIONS requests.
     *
     * Dummy method to satisfy the interface. Only responses to the OPTIONS
     * request must be handled, which happens in {@link generatedResponse()}.
     *
     * @param ezcWebdavRequest $request  ezcWebdavOptionsRequest
     * @return null
     */
    public function receivedRequest( ezcWebdavRequest $request )
    {
        return null;
    }

    /**
     * Handles responses to the OPTIONS request.
     *
     * This method enhances the generated response to indicate WebDAV
     * compliance classes 1 and 2 and adds the methods LOCK and UNLOCK to the
     * Allow header.
     *
     * @param ezcWebdavResponse $response 
     * @return ezcWebdavResponse|null
     */
    public function generatedResponse( ezcWebdavResponse $response )
    {
        if ( $response instanceof ezcWebdavOptionsResponse )
        {
            $response->setHeader(
                'DAV',
                ezcWebdavOptionsResponse::VERSION_ONE . ',' . ezcWebdavOptionsResponse::VERSION_TWO 
            );
            $allowHeader = $response->getHeader( 'Allow' ) . ', LOCK, UNLOCK';
            $response->setHeader( 'Allow', $allowHeader );
        }
    }
}

?>
