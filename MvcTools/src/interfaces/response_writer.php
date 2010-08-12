<?php
/**
 * File containing the ezcMvcResponseWriter class
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
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 * @version //autogentag//
 * @filesource
 * @package MvcTools
 */

/**
 * Abstract class defining a response writer.
 *
 * A response writer takes an ezcMvcResponse object and sends the response back
 * to the client after preparing it for this specific medium.
 *
 * @package MvcTools
 * @version //autogentag//
 */
abstract class ezcMvcResponseWriter
{
    /**
     * Creates a new response writer object
     *
     * @param ezcMvcResponse $response
     */
    abstract public function __construct( ezcMvcResponse $response );

    /**
     * Takes the raw protocol depending response body, and the protocol
     * abstract response headers and forges a response to the client. Then it sends
     * the assembled response to the client.
     */
    abstract public function handleResponse();
}
?>
