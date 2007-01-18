<?php

/**
 * Dialog class to ask a simple question.
 * 
 * @package Framework
 * @version //autogen//
 * @copyright Copyright (C) 2006 eZ systems as. All rights reserved.
 * @author  
 * @license http://ez.no/licenses/new_bsd New BSD License
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
        return ( $this->result !== null );
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
            $this->options->text .
                ( ( $this->options->showResults === true )
                ? " (" . implode( "/", $this->options->validResults ) . ")" .
                    ( ( $this->options->defaultResult !== null )
                        ? " [{$this->options->defaultResult}]"
                        : "" ) .
                     " "
                : " " ),
            $this->options->format
        );
        $line = ezcConsoleDialogViewer::readLine();
        $line = ( $line === "" && $this->options->defaultResult !== null ) ? $this->options->defaultResult : $line;
        if ( ( $resCount = sscanf( $line, $this->options->type, $res ) ) === 1
              && ( is_array( $this->options->validResults ) === false
                   || in_array( $res, $this->options->validResults )
             )
           )
        {
            $this->result = $res;
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
        $this->options = new ezcConsoleQuestionDialogOptions();
    }

    /**
     * Property get access.
     * 
     * @param string $propertyName 
     * @return void
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
