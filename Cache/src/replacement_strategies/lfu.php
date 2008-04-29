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
     * Stores the given $itemData in the given storage.
     *
     * @TODO: Document.
     *
     * @param ezcCacheStackStorageConfiguration $storageConfiguration
     * @param ezcCacheStackMetaData $metaData
     * @param string $itemId
     * @param mixed $itemData
     * @param array(string=>string) $itemAttributes
     */
    public static function store(
        ezcCacheStackStorageConfiguration $storageConfiguration,
        ezcCacheStackMetaData $metaData,
        $itemId,
        $itemData,
        $itemAttributes = array()
    )
    {
        // @TODO: Implement.
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
     */
    public static function restore(
        ezcCacheStackStorageConfiguration $storageConfiguration,
        ezcCacheStackMetaData $metaData,
        $itemId,
        $itemAttributes = array(),
        $search = false
    )
    {
        // @TODO: Implement.
    }

    /**
     * Deletes the data with the given $itemId from the given $storage.
     *
     * @TODO: Document.
     *
     * @param ezcCacheStackMetaData $metaData
     * @param string $itemId
     * @param mixed $itemData
     * @param array(string=>string) $itemAttributes
     *
     * @return array(string) Deleted item IDs.
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
    }
}

?>
