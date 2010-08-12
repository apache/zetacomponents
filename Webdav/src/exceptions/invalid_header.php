<?php
/**
 * File containing the ezcWebdavInvalidHeaderException class.
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
 * Exception thrown when a request/response object receives an invalid header value.
 *
 * {@link ezcWebdavRequest::validateHeaders()} will throw this exception, if a
 * header, which is essential to the specific request, is not present. {@link
 * ezcWebdavTransport::sendResponse()} will throw this exception if a
 * Content-Type or Content-Length header is set in an empty body request.
 * 
 * @package Webdav
 * @version //autogen//
 */
class ezcWebdavInvalidHeaderException extends ezcWebdavBadRequestException
{
    /**
     * Initializes the exception with the given $headerName, $value (the value
     * of the named header) and $expectedValue and sets the exception message
     * from it.
     * 
     * @param string $headerName    Name of the affected header.
     * @param string $value         Contained value.
     * @param string $expectedValue Expected values.
     * @return void
     */
    public function __construct( $headerName, $value, $expectedValue = null )
    {
        $msg = "The value '{$value}' for the header '{$headerName}' is invalid.";
        if ( $expectedValue !== null )
        {
            $msg .= " Allowed values are: " . $expectedValue . '.';
        }
        parent::__construct( $msg );
    }
}



?>
