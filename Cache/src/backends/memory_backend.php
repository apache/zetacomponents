<?php
/**
 * File containing the ezcCacheMemoryBackend class.
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
 * @package Cache
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2010 eZ Systems AS. All rights reserved.
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 * @filesource
 */

/**
 * An abstract class defining the required methods for memory handlers.
 *
 * Implemented in:
 *  - {@link ezcCacheApcBackend}
 *  - {@link ezcCacheMemcacheBackend}
 *
 * @apichange This class will be deprecated in the next major version of the
 *            Cache component. Please do not use it directly, but use an
 *            implementation of  {@link ezcCacheStorage} instead.
 *
 * @package Cache
 * @version //autogentag//
 */
abstract class ezcCacheMemoryBackend
{
    /**
     * Stores the data $var under the key $key.
     *
     * @param string $key
     * @param mixed $var
     * @param int $ttl
     * @return bool
     */
    abstract public function store( $key, $var, $ttl = 0 );

    /**
     * Fetches the data associated with key $key.
     *
     * @param string $key
     * @return mixed
     */
    abstract public function fetch( $key );

    /**
     * Deletes the data associated with key $key.
     *
     * @param string $key
     * @return bool
     */
    abstract public function delete( $key );
}
?>
