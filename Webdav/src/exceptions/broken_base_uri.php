<?php
/**
 * File containing the ezcWebdavBrokenBaseUriException class
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
 * Exception thrown if an incorrect base URI is given to the basic path factory.
 *
 * <code>
 * <?php
 *  $server->configurations[0]->pathFactory =
 *      new ezcWebdavBasicPathFactory( '/no/uri/path' );
 * ?>
 * </code>
 *
 * @see ezcWebdavBasicPathFactory
 * @package Webdav
 * @version //autogentag//
 */
class ezcWebdavBrokenBaseUriException extends ezcWebdavException
{
    /**
     * Initializes the exception with the given $uri and optional $msg.
     *
     * @param string $uri
     * @param string $msg
     */
    public function __construct( $uri, $msg = null )
    {
        parent::__construct(
            "The string '{$uri}' is not a valid URI to initialize the path factory." .
            ( $msg !== null ? " $msg" : '' )
        );
    }
}

?>
