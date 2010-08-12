<?php
/**
 * File containing the ezcWebdavAuthorizer interface.
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
 * Interface for classes providing authorization.
 *
 * This interface must be implemented by classes the provide authorization to
 * an {@link ezcWebdavBackend}. A back end will call the {@link authorize()}
 * method for each path that is affected by request.
 *
 * @version //autogentag//
 * @package Webdav
 */
interface ezcWebdavAuthorizer
{
    /**
     * User desires read access. 
     */
    const ACCESS_READ = 1;

    /**
     * User desires write access. 
     */
    const ACCESS_WRITE = 2;

    /**
     * Checks authorization of the given $user to a given $path.
     *
     * This method checks if the given $user has the permission $access to the
     * resource identified by $path. The $path is the result of a translation
     * by the servers {@link ezcWebdavPathFactory} from the request URI.
     *
     * The $access parameter can be one of
     * <ul>
     *    <li>{@link ezcWebdavAuthorizer::ACCESS_WRITE}</li>
     *    <li>{@link ezcWebdavAuthorizer::ACCESS_READ}</li>
     * </ul>
     *
     * The implementation of this method must only check the given $path, but
     * MUST not check descendant paths, since the back end will issue dedicated
     * calls for such paths. In contrast, the algoritm MUST ensure, that parent
     * permission constraints of the given $paths are met.
     *
     * Examples:
     * Permission is rejected for the paths "/a", "/b/beamme" and "/c/connect":
     *
     * <code>
     * <?php
     * var_dump( $auth->authorize( 'johndoe', '/a' ) ); // false
     * var_dump( $auth->authorize( 'johndoe', '/b' ) ); // true
     * var_dump( $auth->authorize( 'johndoe', '/b/beamme' ) ); // false
     * var_dump( $auth->authorize( 'johndoe', '/c/connect/some/deeper/path' ) ); // false
     * ?>
     * </code>
     * 
     * @param string $user 
     * @param string $path 
     * @param int $access 
     * @return bool
     */
    public function authorize( $user, $path, $access = self::ACCESS_READ );
}

?>
