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
class ezcCacheStackLfuReplacementStrategy extends ezcCacheStackBaseReplacementStrategy
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
     * Returns a fresh meta data instance.
     *
     * Returns a freshly created instance of {@link ezcCacheStackLfuMetaData}.
     * 
     * @return ezcCacheStackLfuMetaData
     */
    public static function createMetaData()
    {
        return new ezcCacheStackLfuMetaData();
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
    protected static function checkMetaData( ezcCacheStackMetaData $metaData )
    {
        if ( !( $metaData instanceof ezcCacheStackLfuMetaData ) )
        {
            throw new ezcCacheInvalidMetaDataException(
                $metaData,
                'ezcCacheStackLfuMetaData'
            );
        }
    }
}

?>
