<?php
/**
 * File containing the ezcConsoleQuestionDialogRegexValidator class.
 *
 * @package ConsoleTools
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @filesource
 */

/**
 * Regex validator for ezcConsoleQuestionDialog
 * Validator class for ezcConsoleQuestionDialog objects that validates by
 * matching a certain regular expression.
 * 
 * @package ConsoleTools
 * @version //autogen//
 *
 * @property string $pattern
 *                  The pattern to use for validation. Delimiters and modifiers
 *                  included.
 * @property mixed $default
 *           A default value if no (an empty string) result given.
 */
class ezcConsoleQuestionDialogRegexValidator implements ezcConsoleQuestionDialogValidator
{

    /**
     * Properties
     * 
     * @var array(string=>mixed)
     */
    protected $properties = array(
        "pattern" => null,
        "default" => null,
    );

    /**
     * Create a new question dialog type validator. 
     * 
     * @param string $pattern Pattern to validate against. Delimiters and
     *                        modifiers included.
     * @param mixed $default  Default value according to $type.
     * @return void
     */
    public function __construct( $pattern, $default = null )
    {
        $this->pattern = $pattern;
        $this->default = $default;
    }

    /**
     * Returns if the result is of the given type.
     * Returns if the result is of the given type or empty and a default value is set.
     * 
     * @param mixed $result The result to check.
     * @return bool True if the result is valid. Otherwise false.
     */
    public function validate( $result )
    {
        if ( $result === "" )
        {
            return $this->default !== null;
        }
        return preg_match( $this->pattern, $result ) > 0;
    }

    /**
     * Returns the manipulated value.
     * Returns the value casted into the correct type or the default value, if
     * it exists and the result is empty.
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
        return $result;
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
        return "(match {$this->pattern})" . ( $this->default !== null ? " [{$this->default}]" : "" );
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
        if ( $this->__isset( $propertyName ) )
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
            case "pattern":
                if ( is_string( $propertyValue ) === false || strlen( $propertyValue ) < 2 )
                {
                    throw new ezcBaseValueException( $propertyName, $propertyValue, "string, length > 1" );
                }
                break;
            case "default":
                if ( is_scalar( $propertyValue ) === false && $propertyValue !== null )
                {
                    throw new ezcBaseValueException( $propertyName, $propertyValue, "scalar" );
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
