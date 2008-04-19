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
 * The {@link ezcCacheStorageMetaData} is used to store information needed by
 * the replacement process, as well as information about the state of the
 * storages in the stack and if an item is available in it at all.
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
     * The $itemLimit and $freeRate parameters need to be obey the $itemLimit.
     * If it is reached and the store() method is called, the $freeRate ammount
     * of $itemLimit needs to be cleaned up in the $storage. To achieve this,
     * first the {@link ezcCacheStackableStorage->purge()} method should be
     * used, to remove all outdated content. The method returns an array of
     * cache item ids, to enable the replacement strategy to remove its data
     * accordingly. If this does not reach the desired $freeRate in the cache,
     * items need to be deleted according to the replacement strategy itself,
     * in addition. Therefore the {@link ezcCacheStackableStorage->delete()}
     * method also returns an array of item IDs for updating the meta data.
     *
     * @param ezcCacheStackableStorage $storage
     * @param string $storageId
     * @param ezcCacheStorageMetaData $metaData
     * @param int $itemLimit
     * @param float $freeRate Ranging from 0-1, indicating a fraction..
     * @param string $itemId
     * @param mixed $itemData
     * @param array(string=>string) $itemAttributes
     */
    public static function store(
        ezcCacheStackableStorage $storage,
        $storageId,
        ezcCacheStorageMetaData $metaData,
        $itemLimit,
        $freeRate,
        $itemId,
        $itemData,
        $itemAttributes = array()
    );

    /**
     * Restores the data with the given $dataId from the given $storage.
     *
     * This method needs to take care about restoring an item from the given
     * $storage. The items $itemId and potential $itemAttributes are given for
     * that purpose. The $storage, which implements {@link
     * ezcCacheStackableStorage}, must be used to retreive the data from. If no
     * data is found, boolean false must be returned.
     *
     * In addition to these parameters, the method receives the $metaData
     * struct that should be used to store the meta information needed by the
     * replacement strategy. To enable this, the ID of the storage in the stack
     * ($storageId) is given in addition. The meta data should be updated, if
     * an item is successfully restored, as necessary.
     *
     * The $search parameter is to be forwarded to the
     * {@ezcCacheStackableStorage->restore()} method.
     *
     * @param ezcCacheStackableStorage $storage
     * @param string $storageId
     * @param ezcCacheStorageMetaData $metaData
     * @param string $itemId
     * @param mixed $itemData
     * @param array(string=>string) $itemAttributes
     *
     * @return mixed Restored data or false.
     */
    public static function restore(
        ezcCacheStackableStorage $storage,
        $storageId,
        ezcCacheStorageMetaData $metaData,
        $itemId,
        $itemAttributes = array(),
        $search = false
    );

    /**
     * Deletes the data with the given $itemId from the given $storage.
     *
     * This method needs to take care about deleting an item from the given
     * $storage. The items $itemId and potential $itemAttributes are given for
     * that purpose. The $storage, which implements {@link
     * ezcCacheStackableStorage}, must be used to delete data from. The deleted
     * items IDs should be returned in an array.
     *
     * In addition to these parameters, the method receives the $metaData
     * struct that should be used to store the meta information needed by the
     * replacement strategy. To enable this, the ID of the storage in the stack
     * ($storageId) is given in addition. The meta data should be updated, if
     * an item is successfully restored, as necessary.
     *
     * The $search parameter is to be forwarded to the
     * {@ezcCacheStackableStorage->delete()} method.
     *
     * @param ezcCacheStackableStorage $storage
     * @param string $storageId
     * @param ezcCacheStorageMetaData $metaData
     * @param string $itemId
     * @param mixed $itemData
     * @param array(string=>string) $itemAttributes
     *
     * @return array(string) Deleted item IDs.
     */
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
