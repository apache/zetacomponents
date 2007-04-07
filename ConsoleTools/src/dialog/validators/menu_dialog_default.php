<?php
/**
 * File containing the ezcConsoleMenuDialogDefaultValidator class.
 *
 * @package ConsoleTools
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @filesource
 */

/**
 * Default validator for ezcConsoleMenuDialog.
 * 
 * @package ConsoleTools
 * @version //autogen//
 * @copyright Copyright (C) 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 *
 * @property array $elements The elements of the menu.
 * @property string $default The default value.
 */
class ezcConsoleMenuDialogDefaultValidator implements ezcConsoleMenuDialogValidator
{
    /**
     * Properties 
     * 
     * @var array
     */
    protected $properties = array(
        "elements"      => array(),
        "default"       => null,
        "conversion"    => self::CONVERT_NONE,
    );

    /**
     * Creates a new validator. 
     * 
     * @param array $elements The elements of the menu.
     * @param mixed $default  The default value.
     * @return void
     */
    public function __construct( array $elements = array(), $default = null, $conversion = self::CONVERT_NONE )
    {
        $this->elements     = $elements;
        $this->default      = $default;
        $this->conversion   = $conversion;
    }

    /**
     * Returns if the given result is valid. 
     * 
     * @param mixed $result The received result.
     * @return bool If the result is valid.
     */
    public function validate( $result )
    {
        return isset( $this->elements[$result] );
    }

    /**
     * Returns a fixed version of the result, if possible.
     * This method tries to repair the submitted result, if it is not valid,
     * yet. Fixing can be done in different ways, like casting into a certain
     * datatype, string manipulation, creating an object. A result returned
     * by fixup must not necessarily be valid, so a dialog should call validate
     * after trying to fix the result.
     * 
     * @param mixed $result The received result.
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
            case self::CONVERT_LOWER:
                return strtolower( $result );
            case self::CONVERT_UPPER:
                return strtoupper( $result );
            case self::CONVERT_NONE:
            default:
                return $result;
        }
    }

    /**
     * Returns a string of possible results to be displayed with the question. 
     * For example "(y/n) [y]" to indicate "y" and "n" are valid values and "y" is
     * preselected.
     *
     * @return string The result string.
     */
    public function getResultString()
    {
        return $this->default === null ? "" : " [{$this->default}]";
    }

    /**
     * Returns an array of the elements to display. 
     * 
     * @return array(string=>string) Elements to display.
     */
    public function getElements()
    {
        return $this->elements;
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
            case "elements":
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
                    throw new ezcBaseValueException( "conversion", $conversion, "ezcConsoleMenuDialogDefaultValidator::CONVERT_*" );
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
