<?php
/**
 * File containing the ezcCacheStackLruReplacementStrategy class.
 *
 * @package Cache
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @filesource
 */

/**
 * Least recently used replacement strategy.
 *
 * This replacement strategy will purge items first that have been used least
 * recently. In case the {@link ezcCacheStackableStorage} this replacement
 * strategy works on runs full, first all outdated items (which are older than
 * TTL) will be purged. If this does not last to achieve the desired free rate
 * of the storage, items will be purged that have not been stored or restored
 * for the longest time, until the free rate is reached.
 *
 * This class is not intended to be used directly, but should be configured to
 * be used by an {@link ezcCacheStack} instance. This can be achieved via
 * {@link ezcCacheStackOptions}.
 *
 * The meta data used internally by this replacement strategy has the following
 * structure:
 * <code>
 * array(
 *     'lru' => array(
 *         '<item_id>' => <timestamp>,
 *         '<item_id>' => <timestamp>,
 *         '<item_id>' => <timestamp>,
 *         // ...
 *     ),
 *     'storages' => array(
 *         <storage_id> => array(
 *             <item_id> => true,
 *             <item_id> => true,
 *             // ...
 *         ),
 *         // ...
 *     ),
 * )
 * </code>
 *
 * @package Cache
 * @version //autogentag//
 */
class ezcCacheStackLruReplacementStrategy implements ezcCacheStackReplacementStrategy
{
    /**
     * Stores the given $itemData in the given storage.
     *
     * This method stores the given $itemData under the given $itemId and
     * assigns the given $itemAttributes to it in the {@link
     * ezcCacheStackableStorage} configured in $conf. The
     * storing results in an update of $metaData, reflecting that the item with
     * $itemId was recently used.
     *
     * The $itemId, $itemData and $itemAttributes parameters correspond to
     * those of {@link ezcCacheStorage::store()}.
     *
     * In case the storage configured in $conf ({@link
     * ezcCacheStackStorageConfiguration::$storage}) exceeds the maximum number
     * of items allowed to be stored ({@link
     * ezcCacheStackStorageConfiguration::$itemLimit}), the amount of {@link
     * ezcCacheStackStorageConfiguration::$freeRate} will be purged from the
     * storage. In this case such items that are outdated by their TTL will be
     * purged. If this does not last, further items will be purged using the
     * LRU (least recently used) replacement strategy.
     *
     * For more information on LRU see {@see
     * http://en.wikipedia.org/wiki/Cache_algorithms}.
     *
     * @param ezcCacheStackStorageConfiguration $conf
     * @param ezcCacheStackMetaData $metaData
     * @param string $itemId
     * @param mixed $itemData
     * @param array(string=>string) $itemAttributes
     *
     * @throws ezcCacheInvalidMetaDataException
     *         if the given $metaData is not processable by this replacement
     *         strategy.
     */
    public static function store(
        ezcCacheStackStorageConfiguration $conf,
        ezcCacheStackMetaData $metaData,
        $itemId,
        $itemData,
        $itemAttributes = array()
    )
    {
        self::checkMetaData( $metaData );

        if ( !isset( $metaData->data['storages'][$conf->id][$itemId] )
              && isset( $metaData->data['storages'][$conf->id] )
              && count( $metaData->data['storages'][$conf->id] ) >= $conf->itemLimit )
        {
            self::freeData(
                $conf,
                $metaData,
                // Number of items to remove, round() returns float
                (int) round( $conf->freeRate * $conf->itemLimit )
            );
        }
        $conf->storage->store(
            $itemId, $itemData, $itemAttributes
        );
        self::addItem( $metaData, $itemId, $conf->id );
    }

    /**
     * Frees $freeNum number of item slots in $storage.
     *
     * This method first purges outdated items from the storage inside
     * $conf using {@link ezcCacheStackableStorage::purge()}.
     * If this does not free $freeNum items, least recently used items
     * (determined from {@link ezcCacheStackMetaData}) will be removed from the
     * storage using {@link ezcCacheStackableStorage::delete()}.
     * 
     * @param ezcCacheStackableStorage $conf 
     * @param ezcCacheStackMetaData $metaData
     * @param int $freeNum
     */
    private static function freeData(
        ezcCacheStackStorageConfiguration $conf,
        ezcCacheStackMetaData $metaData,
        $freeNum
    )
    {
        $purgedIds = $conf->storage->purge();
        // Unset purged items in meta data
        foreach ( $purgedIds as $purgedId )
        {
            self::removeItem( $metaData, $purgedId, $conf->id );
        }
        $freeNum = $freeNum - count( $purgedIds );

        // Not enough items have been purged, remove manually
        if ( $freeNum > 0 )
        {
            asort( $metaData->data['lru'] );
            foreach ( $metaData->data['lru'] as $id => $timestamp )
            {
                // Purge only if available in the current storage
                if ( isset( $metaData->data['storages'][$conf->id][$id] ) )
                {
                    $deletedIds = $conf->storage->delete( $id );
                    self::removeItem( $metaData, $id, $conf->id );

                    // Purged enough?
                    if ( --$freeNum == 0 )
                    {
                        break;
                    }
                }
            }
        }
    }

    /**
     * Removes the given $itemIds from $metaData.
     *
     * Updates the given $metaData in terms of removing the assignement between
     * $itemId and $storageId. If $itemId is then indicated to not be stored in
     * any other storage, it is completly removed from the $metaData, freeing up 1 slot
     * 
     * @param ezcCacheStackMetaData $metaData 
     * @param string $itemId 
     * @param string $storageId 
     */
    private static function removeItem( ezcCacheStackMetaData $metaData, $itemId, $storageId )
    {
        // Unset assignement to storage
        unset( $metaData->data['storages'][$storageId][$itemId] );
        
        // Is item available somewhere else?
        foreach ( $metaData->data['storages'] as $storageId => $storedItems )
        {
            if ( isset( $storedItems[$itemId] ) )
            {
                // Item available in other storage
                return;
            }
        }

        // Item not present anywhere
        unset( $metaData->data['lru'][$itemId] );
    }

    /**
     * Add $itemId to $metaData with $storageId.
     * 
     * @param ezcCacheStackMetaData $metaData 
     * @param string $itemId 
     * @param string $storageId 
     */
    private static function addItem( ezcCacheStackMetaData $metaData, $itemId, $storageId )
    {
        $metaData->data['lru'][$itemId]                  = time();
        $metaData->data['storages'][$storageId][$itemId] = true;
    }

    /**
     * Restores the data with the given $dataId from the given $storage.
     *
     * @TODO: Document.
     *
     * @param ezcCacheStackStorageConfiguration $conf
     * @param ezcCacheStackMetaData $metaData
     * @param string $itemId
     * @param mixed $itemData
     * @param array(string=>string) $itemAttributes
     *
     * @return mixed Restored data or false.
     *
     * @throws ezcCacheInvalidMetaDataException
     *         if the given $metaData is not processable by this replacement
     *         strategy.
     */
    public static function restore(
        ezcCacheStackStorageConfiguration $conf,
        ezcCacheStackMetaData $metaData,
        $itemId,
        $itemAttributes = array(),
        $search = false
    )
    {
        self::checkMetaData( $metaData );
        $item = $conf->storage->restore(
            $itemId,
            $itemAttributes,
            $search
        );
        // Update item meta data
        if ( $item === false )
        {
            // Item has been purged / got outdated
            self::removeItem( $metaData, $itemId, $conf->id );
        }
        else
        {
            // Updates the use time
            self::addItem( $metaData, $itemId, $conf->id );
        }
        return $item;
    }

    /**
     * Deletes the data with the given $itemId from the given $storage.
     *
     * @TODO: Document.
     *
     * @param ezcCacheStackStorageConfiguration $conf
     * @param ezcCacheStackMetaData $metaData
     * @param string $itemId
     * @param mixed $itemData
     * @param array(string=>string) $itemAttributes
     *
     * @return array(string) Deleted item IDs.
     *
     * @throws ezcCacheInvalidMetaDataException
     *         if the given $metaData is not processable by this replacement
     *         strategy.
     */
    public static function delete(
        ezcCacheStackStorageConfiguration $conf,
        ezcCacheStackMetaData $metaData,
        $itemId,
        $itemAttributes = array(),
        $search = false
    )
    {
        self::checkMetaData( $metaData );
        $deletedIds = $conf->storage->delete(
            $itemId,
            $itemAttributes,
            $search
        );

        // Possibly deleted multiple items
        foreach ( $deletedIds as $id )
        {
            self::removeItem( $metaData, $id, $conf->id );
        }
        return $deletedIds;
    }

    /**
     * Checks if the given meta data is processable.
     *
     * Throws an exception if the given meta data is not processable.
     * 
     * @param ezcCacheStackMetaData $metaData 
     *
     * @throws ezcCacheInvalidMetaDataException
     *         if the given $metaData is not processable by this replacement
     *         strategy.
     */
    private static function checkMetaData( ezcCacheStackMetaData $metaData )
    {
        // Initialize, if empty
        if ( $metaData->id === null )
        {
            $metaData->id   = __CLASS__;
            $metaData->data = array(
                'lru'      => array(),
                'storages' => array(),
            );
            return;
        }

        // Sanity check
        if ( $metaData->id !== __CLASS__ )
        {
            throw new ezcCacheInvalidMetaDataException(
                $metaData,
                __CLASS__
            );
        }
    }
}

?>
