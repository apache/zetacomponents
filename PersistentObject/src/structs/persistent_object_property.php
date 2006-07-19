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
    /**
     * Used for fields with private visibility.
     */
    const VISIBILITY_PRIVATE = 1;

    /**
     * Used for fields with protected visibility.
     */
    const VISIBILITY_PROTECTED = 2;

    /**
     * Used for fields with public visibility.
     */
    const VISIBILITY_PUBLIC  = 3;

    /**
     * Used for fields that are properties
     * @todo not visibility but member type?
     */
    const VISIBILITY_PROPERTY = 4;

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

    /*
     * The default value for this field.
     * For fields marked as increment_key 'null' is automaticaly chosen.
     */
//    public $defaultValue = null;

    /*
     * We should add support for mapping later. The current implementation will simply do
     * direct mapping. E.g if the PHP type is a string it will be saved as a string. If the
     * php type is an int the value will be saved as an int.
     *
     * Later we should introduce mapping e.g for date and time types.
     */
    // public $mapping;

    /*
     * The visibility of the field. Can be either VISIBILITY_PRIVATE, VISIBILITY_PROTECTED or VISIBILITY_PUBLIC.
     */
//    public $visibility = null;

    /*
     * Sets if the field is required or not. You will not be able to store
     * objects where required fields have not been set.
     */
//    public $isRequired = false;


    /**
     * Constructs a new PersistentObjectField
     */
    public function __construct( $columnName = '',
                                 $propertyName = '',
                                 $type = ''/*,
                                 $defaultValue = '',
                                 $visibility = '',
                                 $isRequired = false*/ )
    {
        $this->columnName = $columnName;
        $this->propertyName = $propertyName;
        $this->propertyType = $type;
//        $this->defaultValue = $defaultValue;
//        $this->visibility = $visibility;
//        $this->isRequired = $isRequired;
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
                                                $array['type']/*,
                                             $array['defaultValue'],
                                             $array['visibility'],
                                             $array['isRequired']*/ );
    }
}
?>
