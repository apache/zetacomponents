<?php
/**
 * File containing the ezcCacheStackLfuReplacementStrategy.
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
 *      'lfu' => array(
 *          '<id>' => <access count>,
 *          '<id>' => <access count>,
 *          '<id>' => <access count>,
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
class ezcCacheStackLfuReplacementStrategy implements ezcCacheStackReplacementStrategy
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

        if ( ( !isset( $metaData->data['lfu'][$itemId] ) )
              && count( $metaData->data['lfu'] ) >= $storageConfiguration->itemLimit )
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
        self::addItem( $metaData, $itemId, $storageConfiguration->id );
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

        // Not enough items have been purged, remove manually
        if ( ( $freeNum = ( $freeNum - count( $purgedIds ) ) ) > 0 )
        {
            asort( $metaData->data['lfu'] );
            foreach ( $metaData->data['lfu'] as $id => $timestamp )
            {
                $deletedIds = $conf->storage->delete( $id );
                self::removeItem( $metaData, $id, $conf->id );

                // Decrement number of items to free, if actually freed
                if ( count( $deletedIds ) > 0 &&  --$freeNum == 0 )
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
    private static function removeItem( ezcCacheStackMetaData $metaData, $itemId, $storageId )
    {

        unset( $metaData->data['storages'][$itemId][$storageId] );
        if ( isset( $metaData->data['storages'][$itemId] ) 
             && count( $metaData->data['storages'][$itemId] ) === 0 )
        {
            // Item is not stored in any other storage
            unset(
                $metaData->data['storages'][$itemId],
                $metaData->data['lfu'][$itemId]
            );
        }
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
        isset( $metaData->data['lfu'][$itemId] )
            ? ++$metaData->data['lfu'][$itemId]
            : $metaData->data['lfu'][$itemId] = 1;
        $metaData->data['storages'][$itemId][$storageId] = true;
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
            self::addItem( $metaData, $itemId, $storageConfiguration->id );
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
        $itemAttributes = array(),
        $search = false
    )
    {
        self::checkMetaData( $metaData );
        $deletedIds = $storageConfiguration->storage->delete(
            $itemId,
            $itemAttributes,
            $search
        );
        foreach ( $deletedIds as $id )
        {
            self::removeItem( $metaData, $id, $storageConfiguration->id );
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
            $metaData->id = __CLASS__;
            $metaData->data = array(
                'lfu'      => array(),
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
