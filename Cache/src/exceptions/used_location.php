<?php
/**
 * File containing the ezcCacheUsedLocationException.
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
 * @version //autogen//
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 */

/**
 * Exception that is thrown when a given location is already in use.
 * Only one cache may reside in a specific location to avoid conflicts while
 * storing ({@link ezcCacheStorage::store()}) and restoring 
 * ({@link ezcCacheStorage::restore()}) data from a cache. If you try to 
 * configure a cache to be used in location that is already taken by another 
 * cachein ezcCacheManager::createCache(), this exception will be thrown.
 *
 * @package Cache
 * @version //autogen//
 */
class ezcCacheUsedLocationException extends ezcCacheException
{
    /**
     * Creates a new ezcCacheUsedLocationException.
     * 
     * @param string $location The used location.
     * @param string $cacheId  The cache ID using this location.
     * @return void
     */
    function __construct( $location, $cacheId )
    {
        parent::__construct( "Location '{$location}' is already in use by cache with ID '{$cacheId}'." );
    }
}
?>
