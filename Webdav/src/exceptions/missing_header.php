<?php
/**
 * File containing the ezcWebdavMissingHeaderException class.
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
 * Exception thrown when a request/response object misses an essential header essential.
 *
 * {@link ezcWebdavRequest::validateHeaders()} will throw this exception, if a
 * header, which is essential to the specific request, is not present. {@link
 * ezcWebdavTransport::sendResponse()} will throw this exception, if a non-XML
 * body should be sent and the header is not set.
 * 
 * @package Webdav
 * @version //autogen//
 */
class ezcWebdavMissingHeaderException extends ezcWebdavBadRequestException
{
    /**
     * Initializes the exception with the given $headerName and sets the exception
     * message from it.
     * 
     * @param string $headerName Name of the missing header.
     * @return void
     */
    public function __construct( $headerName )
    {
        parent::__construct( "The header '$headerName' is required by the request sent or the response to send but was not set." );
    }
}

?>
