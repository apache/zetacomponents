<?php
/**
 * File containing the ezcWebdavStringDisplayInformation class.
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
 * Display information with string body.
 *
 * Used by {@link ezcWebdavTransport} to transport information on displaying a
 * response to the browser. This display information carries a string body.
 *
 * @version //autogentag//
 * @package Webdav
 */
class ezcWebdavStringDisplayInformation extends ezcWebdavDisplayInformation
{
    /**
     * Response object to extract headers from.
     * 
     * @var ezcWebdavResponse
     */
    public $response;

    /**
     * Representation of the response body.
     * 
     * @var string
     */
    public $body;
    
    /**
     * Creates a new display information object.
     *
     * This display information must be created with a string $body.
     *
     * @param ezcWebdavResponse $response 
     * @param string $body 
     * @return void
     */
    public function __construct( ezcWebdavResponse $response, $body )
    {
        $this->response = $response;
        $this->body     = $body;
    }
}

?>
