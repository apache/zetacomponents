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
        $freeNum = $freeNum - count( $purgedIds );

        // Not enough items have been purged, remove manually
        if ( $freeNum > 0 )
        {
            asort( $metaData->data['lfu'] );
            foreach ( $metaData->data['lfu'] as $id => $timestamp )
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
        unset( $metaData->data['lfu'][$itemId] );
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
        if( isset( $metaData->data['lfu'][$itemId] ) )
        {
            ++$metaData->data['lfu'][$itemId];
        }
        else
        {
            $metaData->data['lfu'][$itemId] = 1;
        }
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
            // Update usage
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
