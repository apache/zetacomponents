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
 * @todo Mention the various limits of the databases. (e.g No CLOB in conditions)
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
     protected $persistentDataDirty;

    /**
     * Initializes the object with the ID $id. If no $id is set the object is
     * filled with the default values.
     */
    public function __construct( $id = -1 )
    {
    }


    /**
     * Resets unique ID fields to null when cloning. This way cloned objects
     * get a new entry in the database when stored.
     */
    private function __clone()
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
     * - keys - an array containing the fieldnames uniquely identifying one record in the table
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
     * Returns a new persistent object based the $record data.
     *
     * @return object
     */
    public static function constructFromRecord( $record )
    {
    }

    /**
     * Returns PHP objects out of the database rows \a $rows.
     *
     * @return array(object)
     */
    public static function constructFromRecords( $records )
    {
    }

    /**
     * Returns the object identified by the definition and the conditions.
     *
     * If the conditions match several objects the first is returned.
     * @see fetchObjectList() for a full description of the input parameters.
     *
     * @throws PersistentObjectException If the fetching of the data failed.
     * @throws PersistentObjectException If more than one result was found.
     *
     * @param array $conditions Conditions which determines which records are fetched
     * @param array $grouping Which elements to group by when retrieving the right object.
     * @param $field_filter Defines which fields to extract. If empty all fields are fetched.
     * @param array $custom_fields An array of extra fields to fetch, each field may be a SQL operation
     * @return mixed Returns either an array or an object depending on $asObject
     */
    public static function fetch( $definition, $conditions, $grouping = null )
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
    public static function fetchObjects( $definition,
                                         $conditions = null,
                                         $sorts = null,
                                         $limit = null,
                                         $grouping = null )
    {
    }

    /**
     * Returns the number of matching records selecting based on $definition and $conditions
     *
     * @return int
     */
    public static function fetchObjectsCount( $definition,
                                              $conditions = null )
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
     * @return void
     */
    public function delete()
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
     * Return the properties of this persistent object.
     *
     * The properties are extracted from the definition array.
     * @return array
     */
    public function properties()
    {
    }

    /**
     * Returns true if the property $attr is part of the definition.
     *
     * @param string @attr
     * @return boolean
     */
    public function hasProperty( $attr )
    {
    }

    /**
     * Return if any of the properties have been changed since last synchronization with the
     * database.
     * @return boolean
     */
    public function hasDirtyData()
    {
    }

    /**
     * Fills this object with the data from the $row.
     *
     * Matching of the data to the field is done through the object definition.
     * @param array $record
     * @return void
     */
    private function fillFromRecords( $record )
    {
    }
}

?>
