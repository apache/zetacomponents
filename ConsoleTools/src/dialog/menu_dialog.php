<?php

/**
 * Dialog class to ask a simple question.
 * 
 * @package Framework
 * @version //autogen//
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @author  
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
class ezcConsoleMenuDialog implements ezcConsoleDialog
{

    /**
     * Dialog result 
     * 
     * @var mixed
     */
    protected $result;

    /**
     * Properties 
     * 
     * @var array
     */
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
    public function __construct( ezcConsoleOutput $output, ezcConsoleMenuDialogOptions $options = null )
    {
        $this->output  = $output;
        $this->options = $options === null ? new ezcConsoleMenuDialogOptions() : $options;
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
        $text = "{$this->options->text}\n";
        foreach ( $this->options->validator->getElements() as $key => $entry )
        {
            $text .= sprintf(
                $this->options->formatString,
                $key,
                $entry
            );
        }
        $text .= "\n{$this->options->selectText}{$this->options->validator->getResultString()} ";

        $this->output->outputText( $text, $this->options->format );

        $result = $this->options->validator->fixup( ezcConsoleDialogViewer::readLine() );
        if ( $this->options->validator->validate( $result ) )
        {
            $this->result = $result;
        }
    }

    /**
     * Reset the dialog.
     * 
     * @return void
     */
    public function reset()
    {
        $this->result = null;
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
     * @param string $propertyValue Vakue to set.
     * @return void
     * @ignore
     */
    public function __set( $propertyName, $propertyValue )
    {
        switch ( $propertyName )
        {
            case "options":
                if ( ( $propertyValue instanceof ezcConsoleMenuDialogOptions ) === false )
                {
                    throw new ezcBaseValueException( $propertyName, get_class( $propertyValue ), "instance of ezcConsoleMenuDialogOptions" );
                }
                break;
            case "output":
                if ( ( $propertyValue instanceof ezcConsoleOutput ) === false )
                {
                    throw new ezcBaseValueException( $propertyName, get_class( $propertyValue ), "instance of ezcConsoleOutput" );
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
