<?php
/**
 * File containing the ezcPersistentObjectRow class
 *
 * @package PersistentObject
 * @version //autogen//
 * @copyright Copyright (C) 2005 eZ systems as. All rights reserved.
 * @license LGPL {@link http://www.gnu.org/copyleft/lesser.html}
 */

/**
 * Functionality on the record level for eczPersistentObject.
 *
 * eczPersistentObject provides complete objects for all row level data.
 * This class provides the same database functionality, but with the data
 * stored in a serialized array. This is useful internally for
 * eczPersistentObject but also for application developers wanting
 * to handle large amounts of persistent objects with as little
 * overhead as possible.
 *
 * @see eczPersisentObject
 *
 * @todo Write function descriptions. These should be snatched from eczPersistentObject once they are done!
 * @todo Explain exactly what we mean with a record (simply an array with the field values)
 *
 * @package PersistentObject
 * @copyright Copyright (C) 2005 eZ systems as. All rights reserved.
 * @license LGPL {@link http://www.gnu.org/copyleft/lesser.html}
 */
class ezcPersistentRecord
{
    public static function fetchRecord( $def, $conditions, $grouping = null )
    {
    }

    public static function fetchRecords( $def,
                                         $conditions = null,
                                         $sorts = null,
                                         $limit = null,
                                         $grouping = false )

    public static function fetchRecordsCount( $def,
                                              $conditions = null )
    {
    }

    public static function deleteRecords( $def, $conditions = null, $extraConditions = null )
    {
    }

    public static function storeRecords( $def, $records )
    {
    }

    public static function storeRecords( $def, $records )
    {
    }

    /**
     * Returns a value which can be used for new items in table, for instance placement.
     *
     * Uses $def, $orderField $conditions to figure out the currently maximum order value
     * and returns one that is larger.
     *
     * @todo How does it use the above fields to figure out the max order?
     * @param array $def
     * @param string $orderField
     * @param array $conditions
     * @return int
     */
    public static function nextObjectOrder( $def, $orderField, $conditions )
    {
    }

    /**
     * Returns an SQL condition sentence from the conditions $conditions and row data $row.
     *
     * If $row is provided the data from it is preferred over the data provided by the conditions.
     * @todo Move out?
     * @return string
     */
    protected static function conditionSql( $conditions, $record = null )
    {
    }
}
?>
