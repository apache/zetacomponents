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
 * Allows for object persistence in a database
 *
 *  Classes which stores simple types in databases should inherit from this
 *  and implement the definition() function. The class will then get initialization,
 *  fetching, listing, moving, storing and deleting for free as well as attribute
 *  access. The new class must have a constructor which takes one parameter called
 *  \c $row and pass that this constructor.
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
 * <code>
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
     * If the parameter \a $row is an integer it will try to fetch it
     * from the database using it as the unique ID.
     */
    public function __construct( $row )
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
     * - fields - an associative array of fields which defines which database
     *            field (the key) is to fetched and how they map to object
     *            member variables (the value). In order to support all the
     *            databases this field must fulfill the following requirements:
     * - keys - an array of fields which is used for uniquely identifying the object in the table.
     * - function_attributes - an associative array of attributes which maps to member functions, used for fetching data with functions.
     * - set_functions - an associative array of attributes which maps to member functions, used for setting data with functions.
     * - increment_key - the field which is incremented on table inserts.
     * - class_name - the classname which is used for instantiating new objecs when fetching from the
     *                database.
     * - sort - an associative array which defines the default sorting of lists, the key is the table field while the value
     *          is the sorting method which is either \c asc or \c desc.
     * - name - the name of the database table
     *
     * Example:
     * <code>
     * function definition()
     * {
     *    return array( "fields" => array( "id" => "ID",
     *                                     "version" => "Version",
     *                                     "name" => "Name" ),
     *                  "keys" => array( "id", "version" ),
     *                  "function_attributes" => array( "current" => "currentVersion",
     *                                                  "class_name" => "className" ),
     *                  "increment_key" => "id",
     *                  "class_name" => "eZContentClass",
     *                  "sort" => array( "id" => "asc" ),
     *                  "name" => "ezcontentclass" );
     * }
     * </code>
     * @return array The definition for the object. This function is abstract
     *         and must be implemented in derivatives.
     */
    protected abstract function definition();


    /**
     * Fills this object with the data from the $row.
     *
     * Matching of the data to the field is done through the object definition.
     * @param array $row
     * @return void
     */
    public function fillFromRow( $row )
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
     * @param array $def The object definition
     * @param $field_filters Defines which fields to extract. If empty all fields are fetched.
     * @param array $conds Conditions which determines which rows are fetched
     * @param array boolean $asObject If the result should be returned as a row or an object.
     * @param array $grouping Which elements to group by when retrieving the right object.
     * @param array $custom_fields
     * @return mixed Returns either an array or an object depending on $asObject
     */
    public static function &fetchObject( $def, $field_filters, $conds, $asObject = true, $grouping = null, $custom_fields = null )
    {
    }

    /**
     * Deletes this object from the database
     *
     * By default it will use all the fields and their values as the condition
     * for the delete. This can be overrided through the $conditions variable.
     * It uses removeObject to do the real job and passes the object defintion,
     * conditions and extra conditions \a $extraConditions to this function.
     * \note Transaction unsafe. If you call several transaction unsafe methods you must enclose
     * the calls within a db transaction; thus within db->begin and db->commit.
     *
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
     * @param array $def The definition of the object type to delete.
     * @param array $conditions An associative array of keys and values that
     *        will be used as conditions for the delete.
     * @param array @extraConditions Extra conditions that replace or append
     *        the existing conditions.
     * @return void
     */
    public static function deleteObject( &$def, $conditions = null, $extraConditions = null )
    {
    }

    /**
     * Stores this object to the database if the data is considered dirty.
     *
     * This method uses storeObject() to do the actual
     * job and passes \a $fieldFilters to it.
     * \note Transaction unsafe. If you call several transaction unsafe methods you must enclose
     * the calls within a db transaction; thus within db->begin and db->commit.
     * @param array fieldFilters If specified only certain fields will be stored.
     * @return void
     */
    public function store( $fieldFilters = null )
    {
        eZPersistentObject::storeObject( $this, $fieldFilters );
    }

    /**
     * Stores the persistent object $obj to the database.
     *
     * \note Transaction unsafe. If you call several transaction unsafe methods you must enclose
     * the calls within a db transaction; thus within db->begin and db->commit.
     *
     * @param object @obj
     * @param fieldFilters If specified only certain fields will be stored.
     * @return void
     */
    private function storeObject( $obj, $fieldFilters = null )
    {
    }

    /**
     * Returns an SQL sentence from the conditions \a $conditions and row data \a $row.
     * If \a $row is empty (null) it uses the condition data instead of row data.
     * @return string
     */
    protected function conditionTextByRowSql( $conditions, $row = null )
    {
    }


    /**
     * Returns a list of objects fetched from the database    Creates an SQL query out of the different parameters and returns an array with the result.
     *     If \a $asObject is true the array contains objects otherwise a db row.
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
     * // Here $field_filters is set to an empty array, that way only count is used in fields
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
     * @param array $def A definition array of all fields, table name and
     *        sorting
     * @param array $field_filters If defined determines the fields which are
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
     * @param boolean $asObject If \c true then it will return an array with objects, objects are created from class defined in \a $def.
     *        If \c false it will just return the rows fetch from database.
     * @param array $grouping An array of fields to group by or \c null to use grouping in defintion \a $def.
     * @param array $custom_fields Array of \c FIELD elements to add to SQL,
     *        can be used to perform custom fetches, e.g counts. FIELD is an
     *        associative array containing:
     *        - operation - A text field which is included in the field list
     *        - name - If present it adds 'AS name' to the operation.
     */
    static public function fetchObjectList( $def,
                              $field_filters = null,
                              $conds = null,
                              $sorts = null,
                              $limit = null,
                              $asObject = true,
                              $grouping = false,
                              $custom_fields = null )
    {
    }

    /**
     * Returns PHP objects out of the database rows \a $rows.
     * Each object is created from class \$ class_name and is passed
     * as a row array as parameter.
     *
     * @param object $asObject If \c true then objects will be created,
     *                      if not it just returns \a $rows as it is.
     * @return object
     */
    protected static function &objectsFromRows( $rows, $class_name )
    {
    }

    /**
     * Returns an update SQL call to make rows $id1 and $id2 change places.
     */
    protected function swapRowsSql( $table, &$keys, &$order_id, &$rows, $id1, $id2 )
    {
    }

    /**
     * Returns an order value which can be used for new items in table, for instance placement.
     * Uses \a $def, \a $orderField and \a $conditions to figure out the currently maximum order value
     * and returns one that is larger.
     * @param array $def
     * @param string $orderField
     * @param array $conditions
     * @return int
     */
    protected function nextObjectOrder( &$def, $orderField, $conditions )
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
    protected function reorderObject( &$def,
                            /*! Associative array with one element, the key is the order id and values is order value. */
                            $orderField,
                            $conditions,
                            $down = true )
    {
    }

    /**
     * Returns the $array of strings properly escaped for the current database
     *
     * @param array $array
     * @return array
     */
    private function &escapeArray( &$array )
    {
    }

    /**
     * Stores a list of objects to the database.
     * Transaction unsafe. If you call several transaction unsafe methods you must enclose
     * the calls within a db transaction; thus within db->begin and db->commit.
     * @param array $parameters The list of
     *   $db =& eZDB::instance();
     *   $def =& $parameters['definition'];
     *   $table =& $def['name'];
     *   $fields =& $def['fields'];
     *   $keys =& $def['keys'];
     *   $updateFields =& $parameters['update_fields'];
     *   $conditions =& $parameters['conditions'];
     * @return void
     */
    protected static function storeObjectList( $parameters )
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
    protected function setHasDirtyData( $hasDirtyData )
    {
    }
}

?>
