<?php

/**
 * Basic options class for ezcConsoleDialog implementations.
 * 
 * @package ConsoleTools
 * @version //autogen//
 * @copyright Copyright (C) 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 *
 * @property string $text
 *           The text to display before the menu.
 * @property string $formatString
 *           The format string for each menu element.
 * @property string $selectText
 *           The test to display after the menu to indicate the user that he
 *           should select an item.
 * @property ezcConsoleMenuDialogDefaultValidator $validator
 *           The validator to use with this menu.
 * @property string format
 *           The output format for the dialog.
 */
class ezcConsoleMenuDialogOptions extends ezcConsoleDialogOptions
{

    /**
     * Construct a new options object.
     * Options are constructed from an option array by default. The constructor
     * automatically passes the given options to the __set() method to set them 
     * in the class.
     * 
     * @throws ezcBasePropertyNotFoundException
     *         If trying to access a non existent property.
     * @throws ezcBaseValueException
     *         If the value for a property is out of range.
     * @param array(string=>mixed) $options The initial options to set.
     */
    public function __construct( array $options = array() )
    {
        $this->properties["text"]           = "Please choose an item.";
        $this->properties["formatString"]   = "%3s) %s\n";
        $this->properties["selectText"]     = "Select: ";
        $this->properties["validator"]      = new ezcConsoleMenuDialogDefaultValidator();
        parent::__construct( $options );
    }

    /**
     * Property set access.
     * 
     * @param string $propertyName 
     * @param string $propertyValue 
     * @ignore
     * @return void
     */
    public function __set( $propertyName, $propertyValue )
    {
        switch ( $propertyName )
        {
            case "text":
                if ( is_string( $propertyValue ) === false || strlen( $propertyValue ) < 1 )
                {
                    throw new ezcBaseValueException(
                        $propertyName,
                        $propertyValue,
                        "string, length > 0"
                    );
                }
                break;
            case "selectText":
                if ( is_string( $propertyValue ) === false )
                {
                    throw new ezcBaseValueException(
                        $propertyName,
                        $propertyValue,
                        "string"
                    );
                }
                break;
            case "formatString":
                if ( is_string( $propertyValue ) === false )
                {
                    throw new ezcBaseValueException(
                        $propertyName,
                        $propertyValue,
                        "string"
                    );
                }
                break;
            case "validator":
                if ( ( $propertyValue instanceof ezcConsoleMenuDialogValidator ) === false )
                {
                    throw new ezcBaseValueException(
                        $propertyName,
                        $propertyValue,
                        "ezcConsoleMenuDialogValidator"
                    );
                }
            default:
                parent::__set( $propertyName, $propertyValue );
        }
        $this->properties[$propertyName] = $propertyValue;
    }
}

?>
