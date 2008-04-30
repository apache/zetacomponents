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
 * Least recently used replacement strategy.
 *
 *  Meta data has the following structure:
 *  <code>
 *  array(
 *      'lru' => array(
 *          '<id>' => <timestamp>,
 *          '<id>' => <timestamp>,
 *          '<id>' => <timestamp>,
 *          // ...
 *      ),
 *      'storages' => array(
 *          <id> => array(
 *              <storage_id> => true,
 *              <storage_id> => true,
 *              // ...
 *          ),
 *          // ...
 *      ),
 *  )
 *  </code>
 *
 * @todo Document.
 * 
 * @package Cache
 * @version //autogentag//
 */
class ezcCacheStackLruReplacementStrategy implements ezcCacheStackReplacementStrategy
{
    /**
     * Stores the given $itemData in the given storage.
     *
     * @TODO: Document.
     *
     * @param ezcCacheStackStorageConfiguration $storageConfiguration
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
        ezcCacheStackStorageConfiguration $storageConfiguration,
        ezcCacheStackMetaData $metaData,
        $itemId,
        $itemData,
        $itemAttributes = array()
    )
    {
        self::checkMetaData( $metaData );

        if ( ( !isset( $metaData->data['lru'][$itemId] ) )
              && count( $metaData->data['lru'] ) >= $storageConfiguration->itemLimit )
        {
            self::freeData(
                $storageConfiguration,
                $metaData,
                // Number of items to remove
                round( $storageConfiguration->freeRate * $storageConfiguration->itemLimit )
            );
        }
        $storageConfiguration->storage->store(
            $itemId, $itemData, $itemAttributes
        );
        // Actualize LRU timestamp
        $metaData->data['lru'][$itemId] = time();
        // Define that data is stored in the given storage
        $metaData->data['storages'][$itemId][$storageConfiguration->id] = true;
    }

    /**
     * Frees $freeNum number of item slots in $storage.
     *
     * @TODO: DOcument.
     * 
     * @param ezcCacheStackableStorage $storage 
     * @param ezcCacheStackMetaData $metaData 
     * @param int $freeNum 
     */
    public static function freeData(
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

        // Not enough items have been purged, remove manually
        if ( ( $freeNum = ( $freeNum - count( $purgedIds ) ) ) > 0 )
        {
            asort( $metaData->data['lru'] );
            foreach ( $metaData->data['lru'] as $id => $timestamp )
            {
                $conf->storage->delete( $id );
                self::removeItem( $metaData, $id, $conf->id );
                // Decrement number of items to free
                if ( --$freeNum == 0 )
                {
                    // Enough purged
                    break;
                }
            }
        }
    }

    /**
     * Removes the given $itemIds from $metaData.
     * 
     * @param ezcCacheStackMetaData $metaData 
     * @param string $itemId 
     * @param string $storageId 
     */
    public static function removeItem( ezcCacheStackMetaData $metaData, $itemId, $storageId )
    {
        unset(
            $metaData->data['lru'][$itemId],
            $metaData->data['storages'][$itemId][$storageId]
        );
        // Item not stored anywhere anymore?
        if ( isset( $metaData->data['storages'][$itemId] ) 
             && count( $metaData->data['storages'][$itemId] ) === 0 )
        {
            unset( $metaData->data['storages'][$itemId] );
        }
    }

    /**
     * Restores the data with the given $dataId from the given $storage.
     *
     * @TODO: Document.
     *
     * @param ezcCacheStackStorageConfiguration $storageConfiguration
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
        ezcCacheStackStorageConfiguration $storageConfiguration,
        ezcCacheStackMetaData $metaData,
        $itemId,
        $itemAttributes = array(),
        $search = false
    )
    {
        self::checkMetaData( $metaData );
        $item = $storageConfiguration->storage->restore(
            $itemId,
            $itemAttributes,
            $search
        );
        // Update item meta data
        if ( $item === false )
        {
            self::removeItem( $metaData, $itemId, $storageConfiguration->id );
        }
        else
        {
            $metaData->data['lru'][$itemId] = time();
            $metaData->data['storage'][$storageConfiguration->id] = true;
        }
        return $item;
    }

    /**
     * Deletes the data with the given $itemId from the given $storage.
     *
     * @TODO: Document.
     *
     * @param ezcCacheStackStorageConfiguration $storageConfiguration
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
        ezcCacheStackStorageConfiguration $storageConfiguration,
        ezcCacheStackMetaData $metaData,
        $itemId,
        $attributes = array(),
        $search = false
    )
    {
        // @TODO: Implement.
        self::checkMetaData( $metaData );
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
            $metaData->id = __CLASS__;
            $metaData->data = array(
                'lru'      => array(),
                'storages' => array(),
            );
        }
        // Check
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
