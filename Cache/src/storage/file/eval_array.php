<?php
/**
 * File containing the ezcCacheStorageEvalarray class.
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
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 * @filesource
 */

/**
 * This cache storage implementation stores arrays and scalar values (int,
 * float, string, bool) in files on your hard disk as PHP code. In contrast to
 * its sibling class {@link ezcCacheStorageFileArray}, the stored PHP code is
 * not simply required to restore the cache data, but is evaluated using PHP's
 * eval() function.  It takes its base methods from the extended storage base
 * class {@link ezcCacheStorageFile}.
 *
 * Main purpose behind these 2 similar implementations is the following:
 * Most byte code caches are capable of caching code for included files,
 * but not for eval()'ed strings. Therefore the 
 * {@link ezcCacheStorageFileEvalarray} class will permit you to get your cached
 * data not cached a second time by an accellerator like APC, whereas the 
 * {@link ezcCacheStorageFileArray} class will permit you to explicitly allow 
 * this. ATTENTION: If you do not use a byte code cache with your PHP 
 * installation, the use of {@link ezcCacheStorageFileArray} is recommended over 
 * the usage of {@link ezcCacheStorageEvalarray}, since eval() is much slower 
 * than directly requiring the stored PHP code.
 *
 * For example code of using a cache storage, see {@link ezcCacheManager}.
 *
 * The Cache package contains several other implementations of 
 * {@link ezcCacheStorageFile}. As there are:
 *
 * - ezcCacheStorageFileArray
 * - ezcCacheStorageFilePlain
 * 
 * @package Cache
 * @version //autogentag//
 */
class ezcCacheStorageFileEvalArray extends ezcCacheStorageFile
{
    /**
     * Fetch data from a given file name. 
     *
     * @see ezcCacheStorageFile::restore()
     * 
     * @param string $filename The file to fetch data from.
     * @return mixed The data read from the file.
     */
    protected function fetchData( $filename )
    {
        return eval( file_get_contents( $filename ) );
    }
     
    /**
     * Serialize the data for storing.
     * Serializes a PHP variable (except type resource and object) to a
     * executable PHP code representation string.
     * 
     * @param mixed $data Simple type or array to serialize.
     * @return string The serialized data
     *
     * @throws ezcCacheInvalidDataException
     *         If the data submitted is an object or a resource, since this 
     *         implementation of {@link ezcCacheStorageFile} can only deal with
     *         scalar and array values.
     */
    protected function prepareData( $data )
    {
        if ( is_object( $data ) || is_resource( $data ) ) 
        {
            throw new ezcCacheInvalidDataException( gettype( $data ), array( 'simple', 'array' ) );
        }
        return "return " . var_export( $data, true ) . ";\n?>\n";
    }
}
?>
