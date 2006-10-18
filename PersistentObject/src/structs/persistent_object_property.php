<?php
/**
 * @version //autogen//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @package PersistentObject
 */

/**
 * Defines a persistent object field.
 *
 * @see ezcPersisentObjectDefinition
 *
 * @package PersistentObject
 */
class ezcPersistentObjectProperty
{

    const PHP_TYPE_STRING = 1;
    const PHP_TYPE_INT = 2;
    const PHP_TYPE_FLOAT = 3;
    const PHP_TYPE_ARRAY = 4;
    const PHP_TYPE_OBJECT = 5;

    /**
     * The name of the database field that stores the value.
     */
    public $columnName = null;

    /**
     * The name of the PersistentObject property that holds the value in the PHP object.
     */
    public $propertyName = null;

    /**
     * The type of the PHP property..
     */
    public $propertyType = null;

    /**
     * Constructs a new PersistentObjectField
     */
    public function __construct( $columnName   = '',
                                 $propertyName = '',
                                 $type         = '' )
    {
        $this->columnName   = $columnName;
        $this->propertyName = $propertyName;
        $this->propertyType = $type;
    }

    /**
     * Returns a new instance of this class with the data specified by $array.
     *
     * $array contains all the data members of this class in the form:
     * array('member_name'=>value).
     *
     * __set_state makes this class exportable with var_export.
     * var_export() generates code, that calls this method when it
     * is parsed with PHP.
     *
     * @param array(string=>mixed)
     * @return ezcPersistentObjectProperty
     */
    public static function __set_state( array $array )
    {
        return new ezcPersistentObjectProperty( $array['columnName'],
                                                $array['propertyName'],
                                                $array['propertyType'] );
    }
    
    /**
     * @apichange Never used but left for BC reasons. Will be removed on next 
     *            major version.
     */
    const VISIBILITY_PRIVATE = 1;

    /**
     * @apichange Never used but left for BC reasons. Will be removed on next 
     *            major version.
     */
    const VISIBILITY_PROTECTED = 2;

    /**
     * @apichange Never used but left for BC reasons. Will be removed on next 
     *            major version.
     */
    const VISIBILITY_PUBLIC  = 3;

    /**
     * @apichange Never used but left for BC reasons. Will be removed on next 
     *            major version.
     */
    const VISIBILITY_PROPERTY = 4;
}
?>
