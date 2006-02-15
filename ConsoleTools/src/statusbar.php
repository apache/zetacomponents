<?php
/**
 * File containing the ezcConsoleStatusbar class.
 *
 * @package ConsoleTools
 * @version //autogentag//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @filesource
 */

/**
 * Creating  and maintaining status-bars to be printed to the console. 
 *
 * <code>
 * // Construction
 * $status = new ezcConsoleStatusbar( new ezcConsoleOutput() );
 *
 * // Set option
 * $status->options->successChar = '*';
 *
 * // Run statusbar
 * foreach ( $files as $file )
 * {
 *      $res = $file->upload();
 *      // Add status if form of bool true/false to statusbar.
 *      $status->add( $res ); // $res is true or false
 * }
 *
 * // Retreive and display final statusbar results
 * $msg = $status->getSuccess() . ' succeeded, ' . $status->getFailure() . ' failed.';
 * $out->outputText( "Finished uploading files: $msg\n" );
 * </code>
 *  
 * 
 * @package ConsoleTools
 * @version //autogen//
 */
class ezcConsoleStatusbar
{
    /**
     * Options
     *
     * <code>
     * array(
     *   'successChar' => '+',     // Char to indicate success
     *   'failureChar' => '-',     // Char to indicate failure
     * );
     * </code>
     *
     * @var array(string=>string)
     */
    protected $options = array(
        'successChar' => '+',     // Char to indicate success
        'failureChar' => '-',     // Char to indicate failure
    );

    /**
     * The ezcConsoleOutput object to use.
     *
     * @var ezcConsoleOutput
     */
    protected $outputHandler;

    /**
     * Counter for success and failure outputs. 
     * 
     * @var array(bool=>int)
     */
    protected $counter = array( 
        true  => 0,
        false => 0,
    );

    /**
     * Creates a new status bar.
     *
     * @param ezcConsoleOutput $outHandler Handler to utilize for output
     * @param array(string=>string) $settings      Settings
     * @param array(string=>string) $options       Options
     *
     * @see ezcConsoleStatusbar::$options
     */
    public function __construct( ezcConsoleOutput $outHandler, array $options = array() )
    {
        $this->outputHandler = $outHandler;
        $this->setOptions( $options );
    }

    /**
     * Property read access.
     * 
     * @param string $key Name of the property.
     * @return mixed Value of the property or null.
     *
     * @throws ezcBasePropertyNotFoundException
     *         If the the desired property is not found.
     */
    public function __get( $key )
    {
        switch ( $key )
        {
            case 'options':
                return $this->options;
                break;
        }
        throw new ezcBasePropertyNotFoundException( $key );
    }

    /**
     * Set options.
     * Set the options of the status-bar.
     * 
     * @see ezcConsoleStatusbar::$options
     * 
     * @param array(string=>string) $options The optiosn to set.
     * @return void
     */
    public function setOptions( array $options )
    {
        foreach ( $options as $name => $value )
        {
            switch ( $name )
            {
                case 'successChar':
                case 'failureChar':
                    if ( !is_string( $value ) || strlen( $value ) < 1 )
                    {
                        throw new ezcBaseSettingValueException( $name, $value, 'string, not empty' );
                    }
                    break;
                default:
                    throw new ezcBaseSettingNotFoundException( $name );
                    break;
            }
            $this->options[$name] = $value;
        }
    }

    /**
     * Property write access.
     * 
     * @param string $key Name of the property.
     * @param mixed $val  The value for the property.
     *
     * @throws ezcBasePropertyNotFoundException
     *         If a desired property could not be found.
     * @throws ezcBaseValueException
     *         If a desired property value is out of range.
     * @return void
     */
    public function __set( $key, $val )
    {
        switch ( $key )
        {
            case 'successChar':
            case 'failureChar':
                if ( strlen( $val ) < 1 )
                {
                    throw new ezcBaseValueException( $key, $val, 'string, not empty' );
                }
                break;
            default:
                throw new ezcBasePropertyNotFoundException( $key );
        }
        $this->options[$key] = $val;
    }
 
    /**
     * Property isset access.
     * 
     * @param string $key Name of the property.
     * @return bool True is the property is set, otherwise false.
     */
    public function __isset( $key )
    {
        return isset( $this->options[$key] );
    }

    /**
     * Add a status to the status bar.
     * Adds a new status to the bar which is printed immediately. If the
     * cursor is currently not at the beginning of a line, it will move to
     * the next line.
     *
     * @param bool $status Print successChar on true, failureChar on false.
     * @return void
     */
    public function add( $status )
    {
        switch ( $status )
        {
            case true:
                $this->outputHandler->outputText( $this->options['successChar'], 'success' );
                break;

            case false:
                $this->outputHandler->outputText( $this->options['failureChar'], 'failure' );
                break;
            
            default:
                trigger_error( 'Unknown status '.var_export( $status, true ).'.', E_USER_WARNING );
                return;
        }
        $this->counter[$status]++;
    }

    /**
     * Reset the state of the status-bar object to its initial one. 
     * 
     * @return void
     */
    public function reset()
    {
        foreach ( $this->counter as $status => $count )
        {
            $this->counter[$status] = 0;
        }
    }

    /**
     * Returns number of successes during the run.
     * Returns the number of success characters printed from this status bar.
     * 
     * @return int Number of successes.
     */
    public function getSuccessCount()
    {
        return $this->counter[true];
    }

    /**
     * Returns number of failures during the run.
     * Returns the number of failure characters printed from this status bar.
     * 
     * @return int Number of failures.
     */
    public function getFailureCount()
    {
        return $this->counter[false];
    }
}
?>
