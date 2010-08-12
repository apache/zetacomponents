<?php
/**
 * File containing the ezcWebdavAnonymousAuth struct.
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
 * Struct representing an anonymous user.
 *
 * This struct is used to indicate a missing or non-parsable Authorization
 * header. The user must be handled as if he was not authenticated. The
 * $username is empty.
 * 
 * @package Webdav
 * @version //autogen//
 */
class ezcWebdavAnonymousAuth extends ezcWebdavAuth
{
    /**
     * Creates a new basic auth credential struct.
     * 
     * It is not possible to define a $username, since the anonymous user
     * always has the $username ''.
     */
    public function __construct()
    {
        parent::__construct( '' );
    }
}

?>
