<?php
/**
 * File containing the ezcWebdavBackendPut interface.
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
 * Interface implemented by backends which support the PUT operation.
 *
 * If a backend supports the PUT request method, it must implement this
 * interface.
 *
 * @version //autogentag//
 * @package Webdav
 */
interface ezcWebdavBackendPut
{
    /**
     * Serves PUT requests.
     *
     * The method receives a {@link ezcWebdavPutRequest} objects containing all
     * relevant information obout the clients request and will return an
     * instance of {@link ezcWebdavErrorResponse} on error or {@link
     * ezcWebdavPutResponse} on success.
     * 
     * @param ezcWebdavPutRequest $request 
     * @return ezcWebdavResponse
     */
    public function put( ezcWebdavPutRequest $request );
}

?>
