<?php
/**
 * File containing the ezcWebdavBasicAuthenticator interface.
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
 * Interface for Basic authentication mechanism.
 *
 * This interface must be implemented by objects that provide authentication
 * through a username/password combination, as defined by the HTTP Basic
 * authentication method.
 *
 * An instance of a class implementing this interface may be used in the {@link
 * ezcWebdavServer} $auth property. The WebDAV server will then use this
 * instance to perform authentication. In addition, classes may implement
 * {@link ezcWebdavDigestAuthenticator} and are highly recommended to do so.
 *
 * @see ezcWebdavServer
 * @see ezcWebdavDigestAuthenticator
 * @see ezcWebdavAuthorizer
 * @see ezcWebdavBasicAuth
 *
 * @version //autogentag//
 * @package Webdav
 */
interface ezcWebdavBasicAuthenticator extends ezcWebdavAnonymousAuthenticator
{
    /**
     * Checks authentication for the given $user.
     *
     * This method checks the given user/password credentials encapsulated in
     * $data. Returns true if the user was succesfully recognized and the
     * password is valid for him, false otherwise. In case no username and/or
     * password was provided in the request, empty strings are provided as the
     * parameters of this method.
     * 
     * @param ezcWebdavBasicAuth $data
     * @return bool
     */
    public function authenticateBasic( ezcWebdavBasicAuth $data );
}

?>
