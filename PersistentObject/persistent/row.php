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
 * Functionality on the row level for eczPersistentObject.
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
 *
 * @package PersistentObject
 * @copyright Copyright (C) 2005 eZ systems as. All rights reserved.
 * @license LGPL {@link http://www.gnu.org/copyleft/lesser.html}
 */
class ezcPersistentRow
{
    public static function fetchRow( $def, $field_filter, $conditions, $grouping = null, $custom_fields = null )
    {
    }

    public static function fetchRowList( $def,
                                          $fieldFilter = null,
                                          $conditions = null,
                                          $sorts = null,
                                          $limit = null,
                                          $grouping = false,
                                          $customFields = null )

    public static function deleteRows( $def, $conditions = null, $extraConditions = null )
    {
    }

    public static function storeRow( $row, $def, $fieldFilter )
    {
    }

    public static function storeRows( $rows, $def, $fieldFilter  )
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
     * Returns an update SQL call to make rows $id1 and $id2 change places.
     */
    public static function swapRowsSql( $table, $keys, $order_id, $rows, $id1, $id2 )
    {
    }

    /**
     * Returns an SQL condition sentence from the conditions $conditions and row data $row.
     *
     * If $row is provided the data from it is preferred over the data provided by the conditions.
     * @todo Move out?
     * @return string
     */
    protected static function conditionTextByRowSql( $conditions, $row = null )
    {
    }
}
?>
