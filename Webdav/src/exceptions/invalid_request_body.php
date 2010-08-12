<?php
/**
 * File containing the ezcWebdavInvalidRequestBodyException class.
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
 * @version //autogen//
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 */
/**
 * Thrown if the request body received was invalid.
 * 
 * @package Webdav
 * @version //autogen//
 */
class ezcWebdavInvalidRequestBodyException extends ezcWebdavBadRequestException
{
    /**
     * Initializes the exception with the given $method and $reason and sets
     * the exception message from it.
     * 
     * @param mixed $method 
     * @param mixed $reason 
     * @return void
     */
    public function __construct( $method, $reason = null )
    {
        parent::__construct(
            "The HTTP request body received for HTTP method '$method' was invalid." . ( $reason !== null ? " Reason: $reason" : '' )
        );
    }
}

?>
