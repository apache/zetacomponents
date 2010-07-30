<?php
/**
 * File containing the ezcCacheStorageMemcachePlain class.
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
 * This storage implementation stores data in a Memcache cache.
 *
 * @package Cache
 * @version //autogentag//
 */
class ezcCacheStorageMemcachePlain extends ezcCacheStorageMemcache
{
    /**
     * Fetches data from the cache.
     *
     * @param string $identifier The file to fetch data from
     * @param bool $object Return the object and not the clean data
     * @return mixed The fetched data or false on failure
     */
    protected function fetchData( $identifier, $object = false )
    {
        // @TODO: This is also done in the backend, again. However, since the
        // backend is public, too, we need to keep both for now.
        $data = $this->backend->fetch( $identifier );
        if ( is_object( $data ) && $object === false )
        {
            return $data->data;
        }
        if ( is_object( $data ) && $object !== false )
        {
            return $data;
        }
        else
        {
            return false;
        }
    }

    /**
     * Wraps the data in an ezcCacheStorageMemoryDataStruct structure in order
     * to store it.
     *
     * @throws ezcCacheInvalidDataException
     *         If the data submitted can not be handled by this storage (resource).
     *
     * @param mixed $data Simple type or array
     * @return ezcCacheStorageMemoryDataStruct Prepared data
     */
    protected function prepareData( $data )
    {
        if ( is_resource( $data ) )
        {
            throw new ezcCacheInvalidDataException( gettype( $data ), array( 'simple', 'array', 'object' ) );
        }
        return new ezcCacheStorageMemoryDataStruct( $data, $this->properties['location'] );
    }
}
?>
