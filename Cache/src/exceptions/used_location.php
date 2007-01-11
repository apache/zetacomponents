<?php
/**
 * File containing the ezcCacheUsedLocationException.
 * 
 * @package Cache
 * @version //autogen//
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
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
    function __construct( $location, $cacheId )
    {
        parent::__construct( "Location '{$location}' is already in use by cache with ID '{$cacheId}'." );
    }
}
?>
