<?php
/**
 * File containing the ezcCacheStoragePlain class.
 *
 * @package Cache
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @filesource
 */

/**
 * This class implements a simple storage to cache plain text 
 * on the filesystem. It takes it's base methods from the extended 
 * storage base class {@link ezcCacheStorageFile}.
 *
 * In contrast to other {@link ezcCacheStorageFile} implementations, the stored
 * cache data is restored using PHP's file_get_contents() class. This cache
 * is not capable to store array values. If numeric values are stored the 
 * restored values will be of type string. The same applies to values of the 
 * simple type bool. It is highly recommended that you cast the resulting
 * value to it's correct type, also PHP will automatically perform this cast
 * when necessary. An explicit cast ensures, that type consistant comparisons
 * (using the === or !== operators) will not fail on restored cache data.
 *
 * An even better solution, if you want to store non-string values, are the
 * usage of {@link ezcCacheStorageFileArray} and 
 * {@link ezcCacheStorageFileEvalArray} storage classes, since those keep the
 * variable types of you cached data consistant.
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
class ezcCacheStorageFilePlain extends ezcCacheStorageFile
{
    /**
     * Fetch data from the cache.
     * This method does the fetching of the data itself. In this case, the
     * method simply includes the file and returns the value returned by the
     * include (or false on failure).
     * 
     * @param string $filename The file to fetch data from.
     * @return mixed The fetched data or false on failure.
     */
    protected function fetchData( $filename )
    {
        return file_get_contents( $filename );
    }
    
    /**
     * Serialize the data for storing.
     * Serializes a PHP variable (except type resource and object) to a
     * executable PHP code representation string.
     * 
     * @param mixed $data Simple type or array
     * @return string The serialized data
     *
     * @throws ezcCacheInvalidDataException
     *         If the data submitted is an array,object or a resource, since 
     *         this implementation of {@link ezcCacheStorageFile} can only deal 
     *         with scalar values.
     */
    protected function prepareData( $data )
    {
        if ( is_scalar( $data ) === false ) 
        {
            throw new ezcCacheInvalidDataException( gettype( $data ), array( 'simple' ) );
        }
        return ( string ) $data;
    }
}
?>
