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
 * Least frequently used replacement strategy.
 *
 * @todo Document.
 * 
 * @package Cache
 * @version //autogentag//
 */
class ezcCacheStackLfuReplacementStrategy implements ezcCacheStackReplacementStrategy
{
    /**
     * Stores the given $itemData in the given $storage.
     *
     * @todo Document.
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
    )
    {
        // @TODO Implement.
    }

    /**
     * Restores the data with the given $dataId from the given $storage.
     *
     * @todo Document.
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
    )
    {
        // @TODO Implement.
    }

    /**
     * Deletes the data with the given $itemId from the given $storage.
     *
     * @todo Document.
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
    )
    {
        // @TODO Implement.
    }
}

?>
