<?php
/**
 * File containing the ezcConsoleQuestionDialogCollectionValidator class.
 *
 * @package ConsoleTools
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @filesource
 */

/**
 * Validator class for ezcConsoleQuestionDialog objects that validates a certain datatype.
 * 
 * @package ConsoleTools
 * @version //autogen//
 * @copyright Copyright (C) 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 *
 * @property array $collection
 *           The collection of valid answers.
 * @property mixed $default
 *           Default value.
 * @property int $conversion
 *           ezcConsoleQuestionDialogCollectionValidator::TYPE_*.
 */
class ezcConsoleQuestionDialogCollectionValidator implements ezcConsoleQuestionDialogValidator
{

    /**
     * Collection for verification. 
     * 
     * @var array
     */
    protected $properties  = array(
        "collection"    => array(),
        "default"       => null,
        "conversion"    => self::CONVERT_NONE,
    );

    /**
     * Create a new question dialog collection validator. 
     * 
     * @param array $collection The collection to validate against.
     * @param int $conversion   One of ezcConsoleQuestionDialogCollectionValidator::CONVERT_*.
     * @return void
     */
    public function __construct( array $collection, $default = null, $conversion = self::CONVERT_NONE )
    {
        $this->collection = $collection;
        $this->default = $default;
        $this->conversion = $conversion;
    }

    /**
     * Returns if the result is in the collection.
     * Returns if the result is in the collection or if it is empty and a default is set.
     * 
     * @param mixed $result The result to check.
     * @return bool True if the result is valid. Otherwise false.
     */
    public function validate( $result )
    {
        return in_array( $result, $this->collection );
    }

    /**
     * Returns a fixed version of the result, if possible.
     * If the result was empty and a default is set, this one is returned. Else the
     * configured conversion (if any) is performed.
     * 
     * @param mixed $result The result received.
     * @return mixed The manipulated result.
     */
    public function fixup( $result )
    {
        if ( $result === "" && $this->default !== null )
        {
            return $this->default;
        }
        switch ( $this->conversion )
        {
            case self::CONVERT_UPPER:
                return strtoupper( $result );
            case self::CONVERT_LOWER:
                return strtolower( $result );
            default:
                return $result;
        }
    }

    /**
     * Returns a string that indicates valid results.
     * Returns the string that can will be displayed with the question to
     * indicate valid results to the user and a possibly set default, if
     * available.
     * 
     * @return string
     */
    public function getResultString()
    {
        return "(" . implode( "/", $this->collection ) . ")" . ( $this->default !== null ? " [{$this->default}]" : "" );
    }
    
    /**
     * Property read access.
     * 
     * @param string $key Name of the property.
     * @return mixed Value of the property or null.
     *
     * @throws ezcBasePropertyNotFoundException
     *         If the the desired property is not found.
     * @ignore
     */
    public function __get( $propertyName )
    {
        if ( isset( $this->$propertyName ) )
        {
            return $this->properties[$propertyName];
        }
        throw new ezcBasePropertyNotFoundException( $propertyName );
    }

    /**
     * Property write access.
     * 
     * @param string $key Name of the property.
     * @param mixed $val  The value for the property.
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
            case "collection":
                if ( is_array( $propertyValue ) === false )
                {
                    throw new ezcBaseValueException( $propertyName, $propertyValue, "array" );
                }
                break;
            case "default":
                if ( is_scalar( $propertyValue ) === false && $propertyValue !== null )
                {
                    throw new ezcBaseValueException( $propertyName, $propertyValue, "scalar" );
                }
                break;
            case "conversion":
                if ( $propertyValue !== self::CONVERT_NONE && $propertyValue !== self::CONVERT_UPPER && $propertyValue !== self::CONVERT_LOWER )
                {
                    throw new ezcBaseValueException( $propertyName, $propertyValue, "ezcConsoleQuestionDialogCollectionValidator::CONVERT_*" );
                }
                break;
            default:
                throw new ezcBasePropertyNotFoundException( $propertyName );
        }
        $this->properties[$propertyName] = $propertyValue;
    }

    /**
     * Property isset access.
     * 
     * @param string $key Name of the property.
     * @return bool True is the property is set, otherwise false.
     * @ignore
     */
    public function __isset( $propertyName )
    {
        return array_key_exists( $propertyName, $this->properties );
    }
}

?>
