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
 * @package Cache
 * @version //autogentag//
 */
class ezcCacheStackLruReplacementStrategy extends ezcCacheStackBaseReplacementStrategy
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
        return parent::store( $conf, $metaData, $itemId, $itemData, $itemAttributes );
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
        return parent::restore( $conf, $metaData, $itemId, $itemAttributes, $search );
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
        return parent::delete( $conf, $metaData, $itemId, $itemAttributes, $search );
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
     *
     * @access private
     */
    protected static function checkMetaData( ezcCacheStackMetaData $metaData )
    {
        if ( !( $metaData instanceof ezcCacheStackLruMetaData ) )
        {
            throw new ezcCacheInvalidMetaDataException(
                $metaData,
                'ezcCacheStackLruMetaData'
            );
        }
    }
}

?>
