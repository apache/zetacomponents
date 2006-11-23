<?php
/**
 * File containing the ezcCacheInvalidStorageClassException.
 * 
 * @package Cache
 * @version //autogen//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
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
    function __construct( $storageClass )
    {
        parent::__construct( "'{$storageClass}' is not a valid storage class. Storage classes must extend ezcCacheStorage." );
    }
}
?>
