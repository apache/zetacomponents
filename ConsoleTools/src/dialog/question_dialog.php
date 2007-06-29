<?php
/**
 * File containing the ezcConsoleQuestionDialog class.
 *
 * @package ConsoleTools
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @filesource
 */

/**
 * Dialog class to ask a simple question.
 * 
 * @package ConsoleTools
 * @version //autogen//
 *
 * @property ezcConsoleQuestionDialogOptions $options
 *           Options for the dialog.
 * @property ezcConsoleOutput $output
 *           Output object for displaying the dialog.
 */
class ezcConsoleQuestionDialog implements ezcConsoleDialog
{

    protected $result;

    protected $properties = array(
        "options"   => null,
        "output"    => null,
    );

    /**
     * Create a new question dialog.
     * 
     * @param ezcConsoleOutput $output Output object.
     * @return void
     */
    public function __construct( ezcConsoleOutput $output, ezcConsoleQuestionDialogOptions $options = null )
    {
        $this->output  = $output;
        $this->options = $options === null ? new ezcConsoleQuestionDialogOptions() : $options;
    }

    /**
     * Returns if the dialog retrieved a valid result.
     * Dialogs are displayed in a loop until they return true here.
     * 
     * @return bool If a valid result was retrieved.
     */
    public function hasValidResult()
    {
        return $this->result !== null;
    }

    /**
     * Returns the result retrieved.
     * If no valid result was retreived, yet, this method should throw an
     * ezcConsoleNoValidDialogResultException.
     * 
     * @return mixed The retreived result.
     */
    public function getResult()
    {
        if ( $this->result === null )
        {
            throw new ezcConsoleNoValidDialogResultException();
        }
        return $this->result;
    }

    /**
     * Show the dialog.
     * Display the dialog and retreive the desired answer from the user.
     * 
     * @return void
     */
    public function display()
    {
        $this->output->outputText(
            $this->options->text . ( $this->options->showResults === true ? " " . $this->options->validator->getResultString() : "" ) . " ",
            $this->options->format
        );
        $result = $this->options->validator->fixup( ezcConsoleDialogViewer::readLine() );
        if ( $this->options->validator->validate( $result ) )
        {
            $this->result = $result;
        }
    }

    /**
     * Reset the result in this question.
     * 
     * @return void
     */
    public function reset()
    {
        $this->result = null;
    }

    /**
     * Returns a ready to use yes/no question dialog.
     * Returns a question dialog, which requests the answers "y" for "yes" or
     * "n" for "no" from the user. The answer is converted to lower-case.
     *
     * <code>
     * // Would you like to proceed? (y/n) 
     * $dialog = ezcConsoleDialog( $out, "Would you like to proceed?" );
     *
     * // Would you like to proceed? (y/n) [n] 
     * $dialog = ezcConsoleDialog( $out, "Would you like to proceed?", "n" );
     * </code>
     * 
     * @param ezcConsoleOutput $out  Output object.
     * @param string $questionString Question string.
     * @param string $default        "y" or "n", if default value is desired.
     * @return ezcConsoleQuestionDialog The created dialog.
     */
    public static function YesNoQuestion( ezcConsoleOutput $out, $questionString, $default = null )
    {
        $opts = new ezcConsoleQuestionDialogOptions();
        $opts->text = $questionString;
        $opts->showResults = true;
        $opts->validator = new ezcConsoleQuestionDialogCollectionValidator(
            array( "y", "n" ),
            $default,
            ezcConsoleQuestionDialogCollectionValidator::CONVERT_LOWER
        );

        return new ezcConsoleQuestionDialog( $out, $opts );
    }

    /**
     * Property get access.
     * 
     * @param string $propertyName 
     * @return void
     * @ignore
     */
    public function __get( $propertyName )
    {
        if ( array_key_exists( $propertyName, $this->properties ) )
        {
            return $this->properties[$propertyName];
        }
        throw new ezcBasePropertyNotFoundException( $propertyName );
    }

    /**
     * Property get access.
     * 
     * @param string $propertyName  Name of the property to set.
     * @param string $propertyValue Value to set.
     * @return void
     * @ignore
     */
    public function __set( $propertyName, $propertyValue )
    {
        switch ( $propertyName )
        {
            case "options":
                if ( ( $propertyValue instanceof ezcConsoleQuestionDialogOptions ) === false )
                {
                    throw new ezcBaseValueException(
                        $propertyName,
                        get_class( $propertyValue ),
                        "instance of ezcConsoleQuestionDialogOptions"
                    );
                }
                break;
            case "output":
                if ( ( $propertyValue instanceof ezcConsoleOutput ) === false )
                {
                    throw new ezcBaseValueException(
                        $propertyName,
                        get_class( $propertyValue ),
                        "instance of ezcConsoleOutput"
                    );
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
     * @param string $propertyName Name of the property to check.
     * @return void
     * @ignore
     */
    public function __isset( $propertyName )
    {
        return array_key_exists( $propertyName, $this->properties );
    }
}

?>
