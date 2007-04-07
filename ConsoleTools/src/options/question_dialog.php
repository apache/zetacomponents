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
 *           The question itself.
 * @property ezcConsoleQuestionDialogValidator $validator
 *           The validator to use with this dialog.
 * @property bool $displayResults
 *           Wether to display the possible results and the default selection.
 * @property string format
 *           The output format for the dialog.
 */
class ezcConsoleQuestionDialogOptions extends ezcConsoleDialogOptions
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
        $this->properties["text"]           = "Please enter a value: ";
        $this->properties["validator"]      = new ezcConsoleQuestionDialogTypeValidator();
        $this->properties["displayResults"] = false;
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
            case "showResults":
                if ( is_bool( $propertyValue ) === false )
                {
                    throw new ezcBaseValueException( $propertyName, $propertyValue, "bool" );
                }
                break;
            case "validator":
                if ( ( $propertyValue instanceof ezcConsoleQuestionDialogValidator ) === false )
                {
                    throw new ezcBaseValueException( $propertyName, $propertyValue, "ezcConsoleQuestionDialogValidator" );
                }
                break;
            default:
                parent::__set( $propertyName, $propertyValue );
                return;
        }
        $this->properties[$propertyName] = $propertyValue;
    }
}

?>
