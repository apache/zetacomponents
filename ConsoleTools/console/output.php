<?php
/**
 * File containing the ezcConsoleOutput class.
 *
 * @package ConsoleTools
 * @version //autogen//
 * @copyright Copyright (C) 2005 eZ systems as. All rights reserved.
 * @license LGPL {@link http://www.gnu.org/copyleft/lesser.html}
 */

/**
 * Class for handling console output.
 * This class handles outputting text to the console. It deals with styling 
 * text in different ways and offers some comfortable options to deal
 * with console text output.
 *
 * <code>
 *
 * $opts = array(
 *  'verboseLevel'  => 10,  // extremly verbose
 *  'autobreak'     => 40,  // will break lines every 40 chars
 *  'styles'        => array(
 *      'default'   => 'green', // green default text
 *      'success'   => 'white', // white success messages
 *  ),
 * );
 * $out = new ezcConsoleOutput($opts);
 *
 * $out->outputText('This is default text ');
 * $out->outputText('including success message', 'success');
 * $out->outputText("and a manual linebreak.\n");
 *
 * $out->outputText("Some verbose output.\n", null, 10);
 * $out->outputText("And some not so verbose, bold output.\n", 'bold', 5);
 *
 * </code>
 * 
 * @package ConsoleTools
 * @version //autogen//
 * @copyright Copyright (C) 2005 eZ systems as. All rights reserved.
 * @license LGPL {@link http://www.gnu.org/copyleft/lesser.html}
 */
class ezcConsoleOutput
{
    /**
     * Options
     * Default:
     *
     * <code>
     * array(
     *   'verboseLevel'  => 1,       // Verbosity level
     *   'autobreak'     => 0,       // Pos <int>. Break lines automatically
     *                               // after this ammount of chars
     *   'useStyles'     => true,    // Whether to enable styles or not
     *   'styles'        => array(   // Style alias definition 
     *                               // {@link ezcConsoleOutput::outputText()}
     *       'default'   => '',      // Default style. If blank, sys default
     *       'error'     => 'red',
     *       'warning'   => 'yellow',
     *       'success'   => 'green',
     *       'file'      => 'blue',
     *       'dir'       => 'green',
     *       'link'      => 'blue',
     *   ),
     * );
     * </code>
     *
     * @see ezcConsoleOutput::setOptions()
     * @see ezcConsoleOutput::getOptions()
     * 
     * @var array(string)
     */
    private $options = array(
        'verboseLevel'  => 1,
        'useStyles'     => true,
        'styles'        => array(
            'default'   => '',
            'error'     => 'red',
            'warning'   => 'yellow',
            'success'   => 'green',
            'file'      => 'blue',
            'dir'       => 'green',
            'link'      => 'blue',
        ),
    );

    /**
     * Stores the hard coded styles available on the console.
     *
     * @var array(string => string)
     */
    private $styles = array(
		'red' => "\033[1;31m",
		'green' => "\033[1;32m",
		'yellow' => "\033[1;33m",
		'blue' => "\033[1;34m",
		'magenta' => "\033[1;35m",
		'cyan' => "\033[1;36m",
		'white' => "\033[1;37m",
		'gray' => "\033[1;30m",
		
		'dark-red' => "\033[0;31m",
		'dark-green' => "\033[0;32m",
		'dark-yellow' => "\033[0;33m",
		'dark-blue' => "\033[0;34m",
		'dark-magenta' => "\033[0;35m",
		'dark-cyan' => "\033[0;36m",
		'dark-white' => "\033[0;37m",
		'dark-gray' => "\033[0;30m",
		
		'red-bg' => "\033[1;41m",
		'green-bg' => "\033[1;42m",
		'yellow-bg' => "\033[1;43m",
		'blue-bg' => "\033[1;44m",
		'magenta-bg' => "\033[1;45m",
		'cyan-bg' => "\033[1;46m",
		'white-bg' => "\033[1;47m",
		
		'bold' => "\033[1;38m",
		'italic' => "\033[0;39m",
		'underline' => "\033[0;39m",
    );

    /**
     * Create a new console output handler.
     *
     * @see ezcConsoleOutput::$options
     * @see ezcConsoleOutput::setOptions()
     * @see ezcConsoleOutput::getOptions()
     *
     * @param array(string) $options Options.
     */
    public function __construct( $options = array() ) {
        
    }

    /**
     * Set options.
     *
     * @see ezcConsoleOutput::getOptions()
     * @see ezcConsoleOutput::$options
     *
     * @param array(string) $options Options.
     * @return void
     */
    public function setOptions( $options ) {
        
    }

    /**
     * Returns options
     *
     * @see ezcConsoleOutput::setOptions()
     * @see ezcConsoleOutput::$options
     * 
     * @return array(string) Options.
     */
    public function getOptions( ) {
        
    }

    /**
     * Print text to the console.
     * Output a string to the console. If $style parameter is ommited, 
     * the default style is chosen. Style can either be a special style
     * {@link eczConsoleOutput::$options}, a style name 
     * {@link ezcConsoleOutput$styles} or 'none' to print without any styling.
     *
     * @param string $text      The text to print.
     * @param string $style     Style chosen for printing.
     * @param int $verboseLevel On which verbose level to output this message.
     * @param int Output this text only in a specific verbosity level
     */
    public function outputText( $text, $style = 'default', $verboseLevel = 1 ) {
        
    }
    
    /**
     * Returns a styled version of the text.
     * Receive a styled version of the inputed text. If $style parameter is 
     * ommited, the default style is chosen. Style can either be a special 
     * style or a direct color name.
     * 
     * {@link ezcConsoleOutput::$options}, a style name 
     * {@link ezcConsoleOutput::$styles} or 'none' to print without any styling.
     *
     * @param string $text  Text to apply style to.
     * @param string $style Style chosen to be applied.
     * @return string
     */
    public function styleText( $text, $style = 'default' ) {
        
    }

    /**
     * Store the current cursor position.
     * Saves the current cursor position to return to it using 
     * {@link ezcConsoleOutput::restorePos()}. Multiple calls
     * to this method will override each other. Only the last
     * position is saved.
     *
     * @todo Shall multiple markers be supported? Must be emulated by the 
     *       class, since not directly supported by ANSI escape seqs.
     *
     * @return void
     */
    public function storePos( ) {
        
    }

    /**
     * Restore a cursor position.
     * Restores the cursor position last saved using
     * {@link ezcConsoleOutput::storePos()}.
     *
     * @return void
     *
     * @throw ezcConsoleOutputException If no position saved.
     */
    public function restorePos( ) {
        
    }
}
