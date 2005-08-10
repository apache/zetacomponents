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
 *
 * @package ConsoleTools
 * @version //autogen//
 * @copyright Copyright (C) 2005 eZ systems as. All rights reserved.
 * @license LGPL {@link http://www.gnu.org/copyleft/lesser.html}
 */
class ezcConsoleOutput
{
    /**
     * Settings, required
     *
     * @var array(string)
     * @todo: None knowen, yet.
     */
    private $settings = array();
    
    /**
     * Options
     * Default:
     *
     * <code>
     * array(
     *   'verboseLevel'  => 1,
     *   'autobreak'     => 0,          // Do not break lines automatically
     *   'useStyles'     => true,
     *   'styles'        => array(
     *       'default'   => '',
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
     * Create.
     *
     * @param array(string)
     * @param array(string)
     *
     * @todo: Can the default style 
     */
    public function __construct( $settings, $options ) {
        
    }

    /**
     * Set options.
     *
     * @param array(string)
     * @return void
     */
    public function setOptions( $options ) {
        
    }

    /**
     * Returns options
     *
     * @return array(string)
     */
    public function getOptions( ) {
        
    }

    /**
     * Print text to the console.
     * Output a string to the console. If $style parameter is ommited, 
     * the default style is chosen. Style can either be a special style
     * {@see $options}, a style name {@see $styles} or 'none' to print
     * without any styling.
     *
     * @param string
     * @param int Output this text only in a specific verbosity level
     * @param string
     */
    public function outputText( $text, $verboseLevel = 1, $style = 'default' ) {
        
    }
    
    /**
     * Returns a styled version of the text.
     * Receive a styled version of the inputed text. If $style parameter is ommited, 
     * the default style is chosen. Style can either be a special style
     * {@see $options}, a style name {@see $styles} or 'none' to print
     * without any styling.
     *
     * @param string
     * @param string
     * @return string
     */
    public function styleText( $text, $style = 'default' ) {
        
    }

    /**
     * Save the current cursor position.
     * Saves the current cursor position to return to it using 
     * {@link ezcConsoleOutput::restorePos()}. Multiple calls
     * to this method will override each other. Only the last
     * position is saved.
     *
     * @return void
     */
    public function savePos( ) {
        
    }

    /**
     * Restore a cursor position.
     * Restores the cursor position last saved using
     * {@link ezcConsoleOutput::savePos()}.
     *
     * @return void
     *
     * @throw ezcConsoleOutputException If no position saved.
     */
    public function restorePos( ) {
        
    }
}
