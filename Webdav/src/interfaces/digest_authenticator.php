<?php
/**
 * File containing the ezcWebdavDigestAuthenticator interface.
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
 * Interface for Digest authentication mechanism.
 *
 * This interface must be implemented by objects that provide authentication
 * through a username/password combination, as defined by the HTTP Digest
 * authentication method.
 *
 * An instance of a class implementing this interface may be used in the {@link
 * ezcWebdavServer} $auth property. The WebDAV server will then use this
 * instance to perform authentication. In addition, classes may implement
 * {@link ezcWebdavBasicAuthenticator} and are highly recommended to do so.
 *
 * @see ezcWebdavServer
 * @see ezcWebdavBasicAuthenticator
 * @see ezcWebdavAuthorizer
 * @see ezcWebdavDigestAuth
 *
 * @version //autogentag//
 * @package Webdav
 */
interface ezcWebdavDigestAuthenticator extends ezcWebdavBasicAuthenticator
{
    /**
     * Checks authentication for the given $data.
     *
     * This method performs authentication as defined by the HTTP Digest
     * authentication mechanism. The received struct contains all information
     * necessary.
     *
     * If authentication succeeded true is returned, otherwise false.
     * 
     * @param ezcWebdavDigestAuth $data 
     * @return bool
     */
    public function authenticateDigest( ezcWebdavDigestAuth $data );
}

?>
