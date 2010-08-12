<?php
/**
 * File containing the ezcWebdavMissingServerVariableException class
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
 * Exception thrown, when a required server environment variable has not been
 * set by the webserver.
 *
 * @package Webdav
 * @version //autogentag//
 */
class ezcWebdavMissingServerVariableException extends ezcWebdavException
{
    /**
     * Initializes the exception with the given $name (the key of the $_SERVER
     * array) and sets the exception message from it.
     * 
     * @param string $name
     */
    public function __construct( $name )
    {
        parent::__construct( "Required server variable '{$name}' is not available. Please check your web server configuration." );
    }
}

?>
