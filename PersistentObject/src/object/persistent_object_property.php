<?php
/**
 * File containing the ezcPersistentObjectProperty class.
 *
 * @version //autogen//
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @package PersistentObject
 */

/**
 * Defines a persistent object field.
 *
 * An instance of this class is used in a {@link ezcPersisentObjectDefinition}
 * object to define a relation between an object property and a database
 * column.
 *
 * @see ezcPersisentObjectDefinition
 *
 * @property string $columnName
 *           The name of the database field that stores the value.
 * @property string $propertyName
 *           The name of the PersistentObject property that holds the value in
 *           the PHP object.
 * @property int $propertyType 
 *           The type of the PHP property. See class constants PHP_TYPE_*.
 * @property ezcPersistentObjectPropertyConversion|null $conversion
 *           A conversion object that will automatically perform conversions on
 *           load and save of a property value.
 *
 * @package PersistentObject
 * @version //autogen//
 */
class ezcPersistentObjectProperty
{

    const PHP_TYPE_STRING = 1;
    const PHP_TYPE_INT = 2;
    const PHP_TYPE_FLOAT = 3;
    const PHP_TYPE_ARRAY = 4;
    const PHP_TYPE_OBJECT = 5;

    /**
     * Holds the properties for this class.
     *
     * @var array
     */
    private $properties = array(
        'columnName'   => null,
        'propertyName' => null,
        'propertyType' => self::PHP_TYPE_STRING,
        'conversion'   => null,
    );

    /**
     * Creates a new property definition object.
     *
     * Creates a new property definition object from the given values. The
     * $columnName refers to the name of the database column that, the
     * $propertyName to the name of the PHP object property it refers to.
     * The $type defines the type of the resulting PHP property, the database
     * value will be casted accordingly after load.
     *
     * @param string $columnName
     * @param string $propertyName
     * @param int $type
     */
    public function __construct( $columnName   = null,
                                 $propertyName = null,
                                 $type         = self::PHP_TYPE_STRING,
                                 $conversion   = null )
    {
        $this->columnName   = $columnName;
        $this->propertyName = $propertyName;
        $this->propertyType = $type;
        $this->conversion   = $conversion;
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
     * @param array(string=>mixed) $array
     * @return ezcPersistentObjectProperty
     */
    public static function __set_state( array $array )
    {
        if ( isset( $array['properties'] ) )
        {
            return new ezcPersistentObjectProperty( $array['properties']['columnName'],
                                                    $array['properties']['propertyName'],
                                                    $array['properties']['propertyType'],
                                                    ( isset( $array['properties']['conversion'] ) ? $array['properties']['conversion'] : null ) );
        }
        else
        {
            // Old style exports
            return new ezcPersistentObjectProperty( $array['columnName'],
                                                    $array['propertyName'],
                                                    $array['propertyType'],
                                                    ( isset( $array['conversion'] ) ? $array['conversion'] : null ) );
        }
    }

    /**
     * Property read access.
     *
     * @param string $propertyName Name of the property.
     * @return mixed Value of the property or null.
     *
     * @throws ezcBasePropertyNotFoundException
     *         If the the desired property is not found.
     * @ignore
     */
    public function __get( $propertyName )
    {
        if ( $this->__isset( $propertyName ) )
        {
            return $this->properties[$propertyName];
        }
        throw new ezcBasePropertyNotFoundException( $propertyName );
    }

    /**
     * Property write access.
     *
     * @param string $propertyName Name of the property.
     * @param mixed $propertyValue  The value for the property.
     *
     * @throws ezcBasePropertyNotFoundException
     *         If a the value for the property options is not an instance of
     * @throws ezcBaseValueException
     *         If a the value for a property is out of range.
     * @ignore
     */
    public function __set( $propertyName, $propertyValue )
    {
        switch ( $propertyName )
        {
            case 'columnName':
            case 'propertyName':
                if ( is_string( $propertyValue ) === false && is_null( $propertyValue ) === false )
                {
                    throw new ezcBaseValueException(
                        $propertyName,
                        $propertyValue,
                        'string or null'
                    );
                }
                break;
            case 'propertyType':
                if ( is_int( $propertyValue ) === false && is_null( $propertyValue ) === false )
                {
                    throw new ezcBaseValueException(
                        $propertyName,
                        $propertyValue,
                        'int or null'
                    );
                }
                break;
            case 'conversion':
                if ( !( $propertyValue instanceof ezcPersistentObjectPropertyConversion ) && !is_null( $propertyValue ) )
                {
                    throw new ezcBaseValueException(
                        $propertyName,
                        $propertyValue,
                        'ezcPersistentObjectPropertyConversion or null'
                    );
                }
                break;
            default:
                throw new ezcBasePropertyNotFoundException( $propertyName );
                break;
        }
        $this->properties[$propertyName] = $propertyValue;
    }

    /**
     * Property isset access.
     *
     * @param string $propertyName Name of the property.
     * @return bool True is the property is set, otherwise false.
     * @ignore
     */
    public function __isset( $propertyName )
    {
        return array_key_exists( $propertyName, $this->properties );
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
