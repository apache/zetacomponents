<?php
/**
 * File containing the ezcConsoleProgressbar class.
 *
 * @package ConsoleTools
 * @version //autogen//
 * @copyright Copyright (C) 2005 eZ systems as. All rights reserved.
 * @license LGPL {@link http://www.gnu.org/copyleft/lesser.html}
 */

/**
 * Creating  and maintaining progressbars to be printed to the console. 
 *
 * @todo The author of the PEAR package "Console_ProgressBar" accepted
 *       us to take over his code from that package and improve it for
 *       our needs. {@link http://pear.php.net/package/console_progressbar}
 * 
 * @package ConsoleTools
 * @version //autogen//
 * @copyright Copyright (C) 2005 eZ systems as. All rights reserved.
 * @license LGPL {@link http://www.gnu.org/copyleft/lesser.html}
 */
class ezcConsoleProgressbar
{
    /**
     * Settings for the progress bar.
     * 
     * <code>
     * array(
     *  'max'   => <int>    // Value to progress to
     *  'step'  => <int>    // Stepwidth
     * );
     * </code>
     * 
     * @var array(string)
     */
    protected $settings;

    /**
     * Options
     *
     * <code>
     * array(
     *   'barChar'       => '+',     // Char to fill progress bar with
     *   'emptyChar'     => ' ',     // Char to fill empty space in progress bar with
     *   'progressChar'  => '>',     // Right most char of the progress bar filling
     *   'formatString'  => '[%bar%] %percent%%',   // == "[+++++>    ] 60%"
     *   'width'         => 10,      // Maximum width of the progressbar
     * );
     * </code>
     *
     * 'formatString' can contain the following placeholders:
     *  '%precent%' => Actual percent value
     *  '%max%'     => Maximum value
     *  '%act%'     => Actual value
     *  '%bar%'     => The actual progressbar
     *
     * @var array(string)
     */
    protected $options = array(
        'barChar'       => '+',     // Char to fill progress bar with
        'emptyChar'     => ' ',     // Char to fill empty space in progress bar with
        'progressChar'  => '>',     // Right most char of the progress bar filling
        'formatString'  => '[%bar%] %percent% %',   // Format string
        'width'         => 100,     // Maximum width of the progressbar
    );
   
    /**
     * Creates a new progress bar.
     *
     * @param ezcConsoleOutput
     * @param array(string)
     * @param array(string)
     *
     * @see ezcConsoleTable::$settings
     * @see ezcConsoleTable::$options
     */
    public function __construct( ezcConsoleOutput $outHandler, $settings, $options = array() ) {
        
    }

    /**
     * Start the progress bar
     * Starts the progess bar and sticks it to the current line.
     * No output will be done yet. Call {@link ezcConsoleProgressbar::output()} to
     * ptint the bar.
     * 
     * @return void
     */
    public function start( ) {
        
    }
     
    /**
     * Draw the progress bar.
     * Prints the progressbar to the screen. If start() has not been called yet,
     * the current line is used for {@link ezcConsolProgressbar::start()}.
     * 
     */
    public function output( ) {
        
    }

    /**
     * Advance the progress bar.
     *
     * @param bool Whether to redraw the bar immediatelly.
     */
    public function advance( $redraw = true ) {
        
    }
}
