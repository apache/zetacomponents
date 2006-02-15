<?php
/**
 * @version //autogen//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @package PersistentObject
 */

/**
 * Defines a persistent object id field.
 * The column must be of type int both in PHP and in the database.
 * The default value will always be null.
 *
 * @see ezcPersisentObjectProperty for descriptions for some the constants used in this class.
 *
 * @package PersistentObject
 */
class ezcPersistentObjectIdProperty
{
    /**
     * The name of the database field that stores the value.
     */
    public $columnName;

    /**
     * The name of the PersistentObject property that holds the value in the PHP object.
     */
    public $propertyName;

    /**
     * The visibility of the field. Can be either VISIBILITY_PRIVATE, VISIBILITY_PROTECTED or VISIBILITY_PUBLIC.
     */
    public $visibility;

    public $generator; // sequence

    /**
     * Constructs a new PersistentObjectField
     */
    public function __construct( $columnName = '',
                                 $propertyName = '',
                                 $visibility = '',
                                 ezcPersistentGeneratorDefinition $generator = null )
    {
        $this->columnName = $columnName;
        $this->propertyName = $propertyName;
        $this->visibility = $visibility;
        $this->generator = $generator;
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
     * @return ezcPersistentObjectIdProperty
     */
    public static function __set_state( array $array )
    {
        return new ezcPersistentObjectField( $array['columnName'],
                                             $array['propertyName'],
                                             $array['visibility'] );
    }
}

?>
