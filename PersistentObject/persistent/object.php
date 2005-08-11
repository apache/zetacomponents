<?php
/**
 * File containing the ezcPersistentObject class
 *
 * @package PersistentObject
 * @version //autogen//
 * @copyright Copyright (C) 2005 eZ systems as. All rights reserved.
 * @license LGPL {@link http://www.gnu.org/copyleft/lesser.html}
 */


/**
 * Database persistance for data objects.
 *
 * This class is used to store an arbitrary data structures to a fixed database
 * table. For each data structure you need to store you need to create one
 * table in the database and one class extending eZPersistentObject containing
 * the same fields. eZPersistentObject then provides all the functionality needed
 * to fetch, list, delete etc.
 *
 * This class uses SQL that is compatible with MySQL, PostgreSQL and Oracle.
 * <code>
 * class MyClass extends eZPersistentObject
 * {
 *    function MyClass( $row )
 *    {
 *        $this->eZPersistentObject( $row );
 *    }
 * }
 * </code>
 * @todo Explain exactly what we mean with a row (simply an array with the field values)
 * @todo Map of property names --> Database Names
 * @todo is the definition of set and getters here necessary if you do this in the derived property classes?
 * @todo attribute and setAttribute is no longer necessary because the values can be fetched directly using the
 *       properties.
 * @todo Make it possible to have private attributes
 * @todo Mention the various limits of the databases. (e.g No CLOB in conditions)
 * @todo Also store the type of the field used in the database in the definition (then we can do checking) (option, checking off?)
 *
 * @package PersistentObject
 * @copyright Copyright (C) 2005 eZ systems as. All rights reserved.
 * @license LGPL {@link http://www.gnu.org/copyleft/lesser.html}
 */
abstract class eczPersistentObject
{
    /**
     * Whether the data is dirty, ie needs to be stored, or not.
     */
     private $PersistentDataDirty;

    /**
     * Initializes the object with the row \a $row. It will try to set
     * each field taken from the database row. Calls fill to do the job.
     */
    public function __construct( $id = -1 )
    {
    }

    /**
     * Returns the definition of this persistent object as an associative array.
     *
     * The purpose of the definition is to clearly define:
     * - The database table to work on
     * - The default way to sort objects in this table
     * - The classname of the persistent object implementation that should be
     *   used to instantiate objects with this definition.
     * - The unique keys used to identify the objects in the database
     * - The mapping between fields in the database
     *
     *
     * The definition array is an associative array consists of these keys:
     * - name - the name of the database table
     * - keys - an array containing the fieldnames uniquely identifying one row in the table
     * - increment_key - the field which is incremented on table inserts. When
     *                   you store a new object this field is set automatically.
     * - class_name - the classname which is used for instantiating new objecs when fetching from the
     *                database.
     * - sort - an associative array which defines the default sorting of lists, the key is the table field while the value
     *          is the sorting method which is either \c asc or \c desc.
     * - fields - an associative array of fields which defines which database
     *            field (the key) is to fetched and how they map to object
     *            member variables (the value). In order to support all the
     *            databases this field must fulfill the following requirements:
     *            an associative array of fields that define which database
     *            field (the key) that a value is mapped from. The value
     *            of this entry is an array explained below.
     * Each field itself is specified through an associative array.
     * The following fields are accepted:
     * - property - the name of the property that stores the value
     * - phptype - the type of the value in PHP.
     * - dbtype - the type of the value in the database.
     * - default - the default value for this field. Note: this is automatically
     *             set to 'null' for fields marked as increment_key.
     * - visibility - the visibility of the field. Can be 'public' (default) and 'private'.
     * - required - sets if the field is required or not. You will not be able to store
     *              objects where required fields have not been set.
     *
     * Example:
     * <code>
     * </code>
     *
     * @return array The definition for the object. This function is abstract
     *         and must be implemented in derivatives.
     */
    protected abstract function definition();

    /**
     * Returns a new persistent object based the $row data.
     *
     * @return object
     */
    public static function constructFromRow( $row )
    {
    }

    /**
     * Returns PHP objects out of the database rows \a $rows.
     *
     * @return array(object)
     */
    public static function constructFromRows( $rows )
    {
    }

    /**
     * Returns the object identified by the definition and the conditions.
     *
     * If the conditions match several objects the first is returned.
     * @see fetchObjectList() for a full description of the input parameters.
     * @todo throw exception instead if several objects are found?
     * @todo Make version of this that is not static? This makes more sense, but might be impractical for
     *       automated code.
     *
     * @throws PersistentObjectException If the fetching of the data failed.
     * @param array $conditions Conditions which determines which rows are fetched
     * @param array $grouping Which elements to group by when retrieving the right object.
     * @param $field_filter Defines which fields to extract. If empty all fields are fetched.
     * @param array $custom_fields An array of extra fields to fetch, each field may be a SQL operation
     * @return mixed Returns either an array or an object depending on $asObject
     */
    public static function fetch( $conditions, $grouping = null, $field_filter = null, $custom_fields = null )
    {
    }

    /**
     * Returns a list of objects fetched from the database.
     * Creates an SQL query out of the different parameters and returns an array with the result.
     *
     * A full example:
     * <code>
     * $filter = array( 'id', 'name' );
     * $conds = array( 'type' => 5,
     *                 'size' => array( false, array( 200, 500 ) ) );
     * $sorts = array( 'name' => 'asc' );
     * $limit = array( 'offset' => 50, 'length' => 10 );
     * eZPersistentObject::fetchObjectList( $def, $filter, $conds, $sorts, $limit, true, false, null )
     * </code>
     *
     *  Counting number of elements.
     * <code>
     * $custom = array( array( 'operation' => 'count( id )',
     *                         'name' => 'count' ) );
     * // Here $field_filter is set to an empty array, that way only count is used in fields
     * $rows = eZPersistentObject::fetchObjectList( $def, array(), null, null, null, false, false, $custom );
     * return $rows[0]['count'];
     * </code>
     *
     *  Counting elements per type using grouping
     * <code>
     * $custom = array( array( 'operation' => 'count( id )',
     *                         'name' => 'count' ) );
     * $group = array( 'type' );
     * $rows = eZPersistentObject::fetchObjectList( $def, array(), null, null, null, false, $group, $custom );
     * return $rows[0]['count'];
     * </code>
     *
     * @throws PersistentObjectException If the fetching of the data failed.
     * @param array $def A definition array of all fields, table name and
     *        sorting
     * @param array $field_filter If defined determines the fields which are
     *        extracted (array of field names), if not all fields are fetched
     * @param array $conds \c null for no special condition or an associative
     *        array of fields to filter on.
     *                   The syntax is \c FIELD => \c CONDITION, \c CONDITION can be one of:
     *                   - Scalar value - Creates a condition where \c FIELD must match the value, e.g
     *                                    \code array( 'id' => 5 ) \endcode
     *                                    generates SQL
     *                                    \code id = 5 \endcode
     *                   - Array with two scalar values - Element \c 0 is the match operator and element \c 1 is the scalar value
     *                                    \code array( 'priority' => array( '>', 5 ) ) \endcode
     *                                    generates SQL
     *                                    \code priority > 5 \endcode
     *                   - Array with range - Element \c 1 is an array with start and stop of range in array
     *                                    \code array( 'type' => array( false, array( 1, 5 ) ) ) \endcode
     *                                    generates SQL
     *                                    \code type BETWEEN 1 AND 5 \endcode
     *                   - Array with multiple elements - Element \c 0 is an array with scalar values
     *                                    \code array( 'id' => array( array( 1, 5, 7 ) ) ) \endcode
     *                                    generates SQL
     *                                    \code id IN ( 1, 5, 7 ) \endcode
     * @param array $sorts An associative array of sorting conditions, if set to \c false ignores settings in \a $def,
     *                   if set to \c null uses settingss in \a $def.
     *                   Syntax is \c FIELD => \c DIRECTION. \c DIRECTION must either be string \c 'asc'
     *                   for ascending or \c 'desc' for descending.
     * @param array $limit An associative array with limitiations, can contain
     *                   - offset - Numerical value defining the start offset for the fetch
     *                   - length - Numerical value defining the max number of items to return
     * @param array $grouping An array of fields to group by or \c null to use grouping in defintion \a $def.
     * @param array $custom_fields Array of \c FIELD elements to add to SQL,
     *        can be used to perform custom fetches, e.g counts. FIELD is an
     *        associative array containing:
     *        - operation - A text field which is included in the field list
     *        - name - If present it adds 'AS name' to the operation.
     */
    public static function fetchList( $conditions = null,
                                      $sorts = null,
                                      $limit = null,
                                      $grouping = null,
                                      $field_filter = null,
                                      $custom_fields = null )
    {
    }

    /**
     * Deletes this object from the database
     *
     * By default it will use all the fields and their values as the condition
     * for the delete. This can be overrided through the $conditions variable.
     * It uses removeObject to do the real job and passes the object defintion,
     * conditions and extra conditions \a $extraConditions to this function.
     *
     * When you have called delete on an object the increment_key's are reset.
     * Any subsequent calls that store the object will create a new object.
     * \note Transaction unsafe. If you call several transaction unsafe methods you must enclose
     * the calls within a db transaction; thus within db->begin and db->commit.
     *
     * @throws PersistentObjectException If the delete operation failed.
     * @param array $conditions An associative array of keys and values that
     *        will be used as conditions for the delete.
     * @param array @extraConditions Extra conditions that replace or append
     *        the existing conditions.
     * @return void
     */
    public function delete( $conditions = null, $extraConditions = null )
    {
    }

    /**
     * Deletes an object from the table defined in \a $def with conditions \a $conditions
     * and extra conditions \a $extraConditions. The extra conditions will either be
     * appended to the existing conditions or overwrite existing fields.
     * Uses conditionText() to create the condition SQL.
     * \note Transaction unsafe. If you call several transaction unsafe methods you must enclose
     * the calls within a db transaction; thus within db->begin and db->commit.
     *
     * @throws PersistentObjectException If the delete operation failed.
     * @param array $def The definition of the object type to delete.
     * @param array $conditions An associative array of keys and values that
     *        will be used as conditions for the delete.
     * @param array @extraConditions Extra conditions that replace or append
     *        the existing conditions.
     * @return void
     */
    public static function deleteObjects( $conditions = null, $extraConditions = null )
    {
    }

    /**
     * Stores this object to the database if the data is considered dirty.
     *
     * This method uses storeObject() to do the actual
     * job and passes \a $fieldFilter to it.
     * \note Transaction unsafe. If you call several transaction unsafe methods you must enclose
     * the calls within a db transaction; thus within db->begin and db->commit.
     *
     * @throws PersistentObjectException If the delete operation failed.
     * @param array fieldFilters If specified only certain fields will be stored.
     * @return void
     */
    public function store( $fieldFilter = null )
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

    /**
     * Moves a row in a database table. \a $def is the object definition.
     * Uses \a $orderField to determine the order of objects in a table, usually this
     * is a placement of some kind. It uses this order field to figure out how move
     * the row, the row is either swapped with another row which is either above or
     * below according to whether \a $down is true or false, or it is swapped
     * with the first item or the last item depending on whether this row is first or last.
     * Uses \a $conditions to figure out unique rows.
     * \sa swapRow
     * \note Transaction unsafe. If you call several transaction unsafe methods you must enclose
     * the calls within a db transaction; thus within db->begin and db->commit.
     *
     * @todo Is this thing really necessary?!?
     * @return void
     */
    protected function reorderObject( $def, $orderField, $conditions, $down = true )
    {
    }

    /**
     * Return the attributes of this persistent object.
     *
     * The attributes are taken from the definition object.
     * @return array
     */
    public function attributes()
    {
    }

    /**
     * Returns true if the attribute $attr is part of the definition fields or
     * function attributes.
     *
     * @param string @attr
     * @return boolean
     */
    public function hasAttribute( $attr )
    {
    }

    /**
     * Return if the object data has been changed since last synchronization with the
     * database.
     * @return boolean
     */
    public function hasDirtyData()
    {
    }

    /**
     * Sets whether the object has dirty data or not.
     *
     * @param boolean @hasDirtyData
     * @return void
     */
    protected function setDirtyData( $dirtyData )
    {
    }

    /**
     * Fills this object with the data from the $row.
     *
     * Matching of the data to the field is done through the object definition.
     * @param array $row
     * @return void
     */
    private function fillFromRow( $row )
    {
    }

    /**
     * Returns the $array of strings properly escaped for the current database
     *
     * @param array $array
     * @return array
     */
    private function escapeArray( $array )
    {
    }
}

?>
