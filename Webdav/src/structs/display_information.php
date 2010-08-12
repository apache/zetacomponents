<?php
/**
 * File containing the ezcWebdavDisplayInformation base struct.
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
 * Display information base class.
 *
 * Instances of classes extending this base class are used inside {@link
 * ezcWebdavTransport} to encapsulate response information to be displayed.
 * 
 * @version //autogentag//
 * @package Webdav
 */
abstract class ezcWebdavDisplayInformation
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
     * The concrete data type of this property is defined in the extending
     * classes.
     * 
     * @var DOMDocument|sring|null
     */
    public $body;
    
    /**
     * Creates a new display information.
     *
     * By default an instance of this class carries a {@link ezcWebdavResponse}
     * $repsonse object, which holds header information, and a $body. The
     * content of $body depends on the type of display information. Extending
     * classes may possibly not carry a body at all.
     * 
     * @param ezcWebdavResponse $response 
     * @param DOMDocument|string|null $body 
     * @return void
     */
    public function __construct( ezcWebdavResponse $response, $body )
    {
        $this->response = $response;
        $this->body     = $body;
    }
}

?>
