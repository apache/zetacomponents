<?php
/**
 * File containing the ezcCacheStackReplacementStrategy interface.
 *
 * @package Cache
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @filesource
 */

/**
 * Interface to be implemented by stack replacement strategies.
 *
 * This interface is to be implemented by replacement strategy classes, which
 * can be configured to be used by an {@link ezcCacheStack}. The defined
 * methods wrap around their counterparts on {@link ezcCacheStorage}.
 *
 * A replacement strategy must take care about the actual
 * storing/restoring/deleting of cache items in the given storage. In addition
 * it must take care about keeping the needed meta data actual and about
 * purging data from the cache storage, if it runs full.
 * 
 * @package Cache
 * @version //autogentag//
 */
interface ezcCacheStackReplacementStrategy
{
    /**
     * Stores the given $itemData in the given $storage.
     *
     * This method needs to take care about storing an item in a given
     * $storage. The items $itemId, the $itemData to store and the
     * $itemAttributes are given. In addition a $storage which implements
     * {@link ezcCacheStorage} is given, that should be used to perform the
     * actual store().
     *
     * In addition to these parameters, the method receives the $metaData
     * struct that should be used to store the meta information needed by the
     * replacement strategy. To enable this, the ID of the storage in the stack
     * ($storageId) is given in addition. Important here is, that the
     * $storageId is saved in relation to the $itemId, to keep track of which
     * item is available in which storage. This is needed to remove items from
     * the meta data successfully as soon as they are removed from all
     * storages.
     *
     * @param ezcCacheStackableStorage $storage
     * @param string $storageId
     * @param ezcCacheStorageMetaData $metaData
     * @param string $itemId
     * @param mixed $itemData
     * @param array(string=>string) $itemAttributes
     */
    public static function store(
        ezcCacheStackableStorage $storage,
        $storageId,
        ezcCacheStorageMetaData $metaData,
        $itemId,
        $itemData,
        $itemAttributes = array()
    );

    public static function restore(
        ezcCacheStackableStorage $storage,
        $storageId,
        ezcCacheStorageMetaData $metaData,
        $itemId,
        $attributes = array(),
        $search = false
    );

    public static function delete(
        ezcCacheStackableStorage $storage,
        $storageId,
        ezcCacheStorageMetaData $metaData,
        $itemId,
        $attributes = array(),
        $search = false
    );
}

?>
