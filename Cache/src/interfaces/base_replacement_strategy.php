<?php
/**
 * File containing the abstract ezcCacheStackBaseReplacementStrategy class.
 *
 * @package Cache
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @filesource
 */

/**
 * Base class for LRU and LFU replacement strategies.
 *
 * This class implements the LRU and LFU replacement strategies generically.
 * <ul>
 *  <li>{@link ezcCacheStackLruReplacementStrategy}</li>
 *  <li>{@link ezcCacheStackLfuReplacementStrategy}</li>
 * </ul>
 * are both only wrappers around this class, which implement a different {@link
 * checkMetaData()}, since both strategies use different meta data structures.
 *
 * @package Cache
 * @version //autogen//
 *
 * @access private
 */
abstract class ezcCacheStackBaseReplacementStrategy implements ezcCacheStackReplacementStrategy
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
        if ( !$metaData->hasItem( $conf->id, $itemId )
             && $metaData->reachedItemLimit( $conf->id, $conf->itemLimit ) )
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
        $metaData->addItem( $conf->id, $itemId );
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
            $metaData->removeItem( $conf->id, $purgedId );
        }
        $freeNum = $freeNum - count( $purgedIds );

        // Not enough items have been purged, remove manually
        if ( $freeNum > 0 )
        {
            $purgeOrder = $metaData->getReplacementItems();
            foreach ( $purgeOrder as $id => $replacementData )
            {
                // Purge only if available in the current storage
                if ( $metaData->hasItem( $conf->id, $id ) )
                {
                    $deletedIds = $conf->storage->delete( $id );
                    $metaData->removeItem( $conf->id, $id );

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
        $item = $conf->storage->restore(
            $itemId,
            $itemAttributes,
            $search
        );

        // Update item meta data
        if ( $item === false )
        {
            // Item has been purged / got outdated
            $metaData->removeItem( $conf->id, $itemId );
        }
        else
        {
            // Updates the use time
            $metaData->addItem( $conf->id, $itemId );
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
        $deletedIds = $conf->storage->delete(
            $itemId,
            $itemAttributes,
            $search
        );

        // Possibly deleted multiple items
        foreach ( $deletedIds as $id )
        {
            $metaData->removeItem( $conf->id, $id );
        }
        return $deletedIds;
    }

    /**
     * Pseudo implementation.
     *
     * This method would normally be declared abstract. However, PHP does not
     * allow abstract static methods.
     *
     * Deriving classes must check inside this method, if the given $metaData
     * is appropriate for them. If not, an {@link
     * ezcCacheInvalidMetaDataException} must be throwen.
     * 
     * @param ezcCacheStackMetaData $metaData 
     *
     * @throws ezcCacheInvalidMetaDataException
     *         if the given $metaData is not processable by this replacement
     *         strategy.
     */
/*   abstract protected static function checkMetaData( ezcCacheStackMetaData $metaData ) */
}

?>
