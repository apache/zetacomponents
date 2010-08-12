<?php
/**
 * File containing the ezcCacheInvalidDataException
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
 * Thrown if the data to be stored in a cache can not be handled by the storage.
 * Most {@link ezcCacheStorage} implementations are only capable of storing 
 * scalar and array values, so this exception will be thrown when an incompatible
 * type is submitted for storage, like object or resource.
 * 
 * {@link ezcCacheStorage::store()}
 * {@link ezcCacheStorageFile::store()}
 *
 * {@link ezcCacheStorageFileArray::prepareData()}
 * {@link ezcCacheStorageFileEvalArray::prepareData()}
 * {@link ezcCacheStorageFilePlain::prepareData()}
 *
 * @package Cache
 * @version //autogen//
 */
class ezcCacheInvalidDataException extends ezcCacheException
{
    /**
     * Creates a new ezcCacheInvalidDataException.
     * 
     * @param mixed $actualType    Type of data received.
     * @param array $expectedTypes Expected data types.
     * @return void
     */
    function __construct( $actualType, array $expectedTypes )
    {
        parent::__construct( "The given data was of type '{$actualType}', which can not be stored. Expecting: '" . implode( ', ', $expectedTypes ) . "'." );
    }
}
?>
