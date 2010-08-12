<?php
/**
 * File containing the ezcWebdavBackendChange interface.
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
 */
/**
 * Interface implemented by backends which support the DELETE, COPY and MOVE operations.
 *
 * If a backend supports the following request method, it must implement this
 * interface:
 *
 * <ul>
 *     <li>DELETE</li>
 *     <li>COPY</li>
 *     <li>MOVE</li>
 * </ul>
 *
 * @version //autogentag//
 * @package Webdav
 */
interface ezcWebdavBackendChange
{
    /**
     * Serves DELETE requests.
     *
     * The method receives a {@link ezcWebdavDeleteRequest} objects containing
     * all relevant information obout the clients request and will return an
     * instance of {@link ezcWebdavErrorResponse} on error or {@link
     * ezcWebdavDeleteResponse} on success.
     * 
     * @param ezcWebdavDeleteRequest $request 
     * @return ezcWebdavResponse
     */
    public function delete( ezcWebdavDeleteRequest $request );

    /**
     * Serves COPY requests.
     *
     * The method receives a {@link ezcWebdavCopyRequest} objects containing
     * all relevant information obout the clients request and will return an
     * instance of {@link ezcWebdavErrorResponse} on error or {@link
     * ezcWebdavCopyResponse} on success. If only some operations failed, this
     * method may return an instance of {@link ezcWebdavMultistatusResponse}.
     * 
     * @param ezcWebdavCopyRequest $request 
     * @return ezcWebdavResponse
     */
    public function copy( ezcWebdavCopyRequest $request );

    /**
     * Serves MOVE requests.
     *
     * The method receives a {@link ezcWebdavMoveRequest} objects containing
     * all relevant information obout the clients request and will return an
     * instance of {@link ezcWebdavErrorResponse} on error or {@link
     * ezcWebdavMoveResponse} on success. If only some operations failed, this
     * method may return an instance of {@link ezcWebdavMultistatusResponse}.
     * 
     * @param ezcWebdavMoveRequest $request 
     * @return ezcWebdavResponse
     */
    public function move( ezcWebdavMoveRequest $request );
}

?>
