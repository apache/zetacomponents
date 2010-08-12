<?php
/**
 * File containing the ezcWebdavBrokenRequestUriException class
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
 * Exception thrown, when a request URI could not be handled by the default
 * path factory class. This may happen when the server either provides broken
 * environment variables, or the URL has been rewritten somehow. In this case
 * you need to implement your own request factory and tell the server class to
 * use it.
 *
 * <code>
 *  $server->options->pathFactory = 'myPathFactory';
 * </code>
 *
 * @package Webdav
 * @version //autogentag//
 */
class ezcWebdavBrokenRequestUriException extends ezcWebdavException
{
    /**
     * Initializes the exception with the given $uri and sets the exception
     * message from it.
     * 
     * @param string $uri
     */
    public function __construct( $uri )
    {
        parent::__construct( "URI '{$uri}' could not be handled by path factory." );
    }
}

?>
