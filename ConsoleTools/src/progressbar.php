<?php
/**
 * File containing the ezcConsoleProgressbar class.
 *
 * @package ConsoleTools
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @filesource
 */

/**
 * Creating and maintaining progress-bars to be printed to the console. 
 *
 * <code>
 * $out = new ezcConsoleOutput();
 * 
 * // Create progress bar itself
 * $progress = new ezcConsoleProgressbar( $out, 100, array( 'step' => 5 ) );
 * 
 * $progress->options->emptyChar = '-';
 * $progress->options->progressChar = '#';
 * $progress->options->formatString = "Uploading file </tmp/foobar.tar.bz2>: %act%/%max% kb [%bar%]";
 * 
 * // Perform actions
 * $i = 0;
 * while ( $i++ < 20 ) 
 * {
 *     // Do whatever you want to indicate progress for
 *     usleep( mt_rand( 20000, 2000000 ) );
 *     // Advance the progressbar by one step ( uploading 5k per run )
 *     $progress->advance();
 * }
 * 
 * // Finish progress bar and jump to next line.
 * $progress->finish();
 * 
 * $out->outputText( "Successfully uploaded </tmp/foobar.tar.bz2>.\n", 'success' );
 * </code>
 * 
 * @property ezcConsoleProgressbarOptions $options
 *           Contains the options for this class.
 * @property int $max
 *           The maximum progress value to reach.
 *
 * @package ConsoleTools
 * @version //autogen//
 * @mainclass
 */
class ezcConsoleProgressbar
{
    private $delegate;

    /**
     * Creates a new progress bar.
     *
     * @param ezcConsoleOutput $outHandler   Handler to utilize for output
     * @param int $max                       Maximum value, where progressbar 
     *                                       reaches 100%.
     * @param array(string=>string) $options Options
     *
     * @see ezcConsoleProgressbar::$options
     */
    public function __construct( ezcConsoleOutput $outHandler, $max, array $options = array() )
    {
        if ( ezcBaseFeatures::os() === "Windows" )
        {
            $this->delegate = new ezcConsoleProgressbarWindowsRenderer( $outHandler, $max, $options );
        }
        else
        {
            $this->delegate = new ezcConsoleProgressbarPosixRenderer( $outHandler, $max, $options );
        }
    }
    
    /**
     * Start the progress bar
     * Starts the progress bar and sticks it to the current line.
     * No output will be done yet. Call {@link ezcConsoleProgressbar::output()}
     * to print the bar.
     * 
     * @return void
     */
    public function start()
    {
        $this->delegate->start();
    }

    /**
     * Draw the progress bar.
     * Prints the progress-bar to the screen. If start() has not been called 
     * yet, the current line is used for {@link ezcConsolProgressbar::start()}.
     *
     * @return void
     */
    public function output()
    {
        $this->delegate->output();
    }
    
    /**
     * Finish the progress bar.
     * Finishes the bar (jump to 100% if not happened yet,...) and jumps
     * to the next line to allow new output. Also resets the values of the
     * output handler used, if changed.
     *
     * @return void
     */
    public function finish()
    {
        $this->delegate->finish();
    }
    
    /**
     * Set new options.
     * This method allows you to change the options of progressbar.
     *  
     * @param ezcConsoleProgresbarOptions $options The options to set.
     *
     * @throws ezcBaseSettingNotFoundException
     *         If you tried to set a non-existent option value.
     * @throws ezcBaseSettingValueException
     *         If the value is not valid for the desired option.
     * @throws ezcBaseValueException
     *         If you submit neither an array nor an instance of 
     *         ezcConsoleProgresbarOptions.
     */
    public function setOptions( $options ) 
    {
        $this->delegate->setOptions( $options );
    }

    /**
     * Returns the current options.
     * Returns the options currently set for this progressbar.
     * 
     * @return ezcConsoleProgressbarOptions The current options.
     */
    public function getOptions()
    {
        return $this->delegate->getOptions();
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
    public function __get( $key )
    {
        return $this->delegate->$key;
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
     * @ignore
     */
    public function __set( $key, $val )
    {
        $this->delegate->$key = $val;
    }
 
    /**
     * Property isset access.
     * 
     * @param string $key Name of the property.
     * @return bool True is the property is set, otherwise false.
     * @ignore
     */
    public function __isset( $key )
    {
        return isset( $this->delegate->$key );
    }

    /**
     * Advance the progress bar.
     * Advances the progress bar by $step steps. Redraws the bar by default,
     * using the {@link ezcConsoleProgressbar::output()} method.
     *
     * @param bool  $redraw Whether to redraw the bar immediately.
     * @param float $steps  How far the progress bar should advance on this call.
     * @return void
     */
    public function advance( $redraw = true, $step = 1 ) 
    {
        $this->delegate->advance( $redraw, $step );
    }

}
?>
