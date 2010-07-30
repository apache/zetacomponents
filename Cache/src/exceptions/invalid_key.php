<?php
/**
 * File containing the ezcCacheInvalidKeyException
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
 * @copyright Copyright (C) 2005-2010 eZ Systems AS. All rights reserved.
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 */
/**
 * Exception thrown if a certain cache key could not be processed by a backend.
 *
 * The keys used in memory backends (like {@link ezcCacheMemcacheBackend})
 * underly certain validation rules. If one of these rules does not match a
 * key, this exception is thrown.
 * 
 * @package Cache
 * @version //autogen//
 */
class ezcCacheInvalidKeyException extends ezcCacheException
{
    /**
     * Creates a new invalid key exception.
     *
     * Indicates that $key is not a valid cache key for a certain storage.
     * $reason specifies what is invalid about the key.
     * 
     * @param string $key 
     * @param string $reason 
     */
    public function __construct( $key, $reason = null )
    {
        parent::__construct(
            "The cache key '$key' is invalid." . ( $reason !== null ? ' Reason: ' . $reason : '' )
        );
    }
}

?>
