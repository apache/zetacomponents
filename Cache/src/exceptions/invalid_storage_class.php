<?php
/**
 * File containing the ezcCacheInvalidStorageClassException.
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
 * Exception that is thrown when an invalid storage class is used.
 * All storage classes used with the {@link ezcCacheManager}, by creating a
 * cache instance, using {@link ezcCacheManager::createCache()}. If you
 * provide a non-existant storage class or a class that does not derive from
 * {@link ezcCacheStorage}, this exception will be thrown.
 *
 * @package Cache
 * @version //autogen//
 */
class ezcCacheInvalidStorageClassException extends ezcCacheException
{
    /**
     * Creates a new ezcCacheInvalidStorageClassException
     * 
     * @param string $storageClass The invalid storage class.
     * @return void
     */
    function __construct( $storageClass )
    {
        parent::__construct( "'{$storageClass}' is not a valid storage class. Storage classes must extend ezcCacheStorage." );
    }
}
?>
