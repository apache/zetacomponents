<?php
/**
 * File containing the ezcWebdavPathFactory interface.
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
 * Basic path factory interface.
 *
 * An object that implements this interface is meant to be used in {@link
 * ezcWebdavServerConfiguration} as the $pathFactory property. The instance of
 * {@link ezcWebdavTransport} utilizes the path factory to translate between
 * external paths/URIs and paths that are usable with the a {@link
 * ezcWebdavBackend}.
 *
 * You may want to provide custome implementations for different mappings.
 *
 * @see ezcWebdavBasicPathFactory
 * @see ezcWebdavAutomaticPathFactory
 *
 * @version //autogentag//
 * @package Webdav
 */
interface ezcWebdavPathFactory
{
    /**
     * Parses the given URI to a path suitable to be used in the backend.
     *
     * This method retrieves a URI (either full qualified or relative) and
     * translates it into a local path, which can be understood by the {@link
     * ezcWebdavBackend} instance used in the {@link ezcWebdavServer}.
     *
     * @param string $uri
     * @return string
     */
    public function parseUriToPath( $uri );

    /**
     * Generates a URI from a local path.
     *
     * This method receives a local $path string, representing a resource in
     * the {@link ezcWebdavBackend} and translates it into a full qualified URI
     * to be used as external reference.
     * 
     * @param string $path 
     * @return string
     */
    public function generateUriFromPath( $path );
}

?>
