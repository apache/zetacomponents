<?php
/**
 * File containing the ezcConsoleStatusbar class.
 *
 * @package ConsoleTools
 * @version //autogen//
 * @copyright Copyright (C) 2005 eZ systems as. All rights reserved.
 * @license LGPL {@link http://www.gnu.org/copyleft/lesser.html}
 */

/**
 * Creating  and maintaining statusbars to be printed to the console. 
 *
 * <code>
 *
 * // ... creating ezcConsoleOutput object
 * 
 * $opt = array(
 *  'successChar'   => '+',
 *  'failureChar'   => '-',
 * );
 * $status = new ezcConsoleStatusbar($opt);
 * foreach ($files as $file) {
 *      $res = $file->upload();
 *      $status->add($res); // $res is true or false
 * }
 *
 * $msg = $status->getSuccess().' succeeded, '.$status->getFailure().' failed.';
 * $out->outputText("Finished uploading files. $msg \n");
 *
 * </code>
 *  
 * 
 * @package ConsoleTools
 * @version //autogen//
 * @copyright Copyright (C) 2005 eZ systems as. All rights reserved.
 * @license LGPL {@link http://www.gnu.org/copyleft/lesser.html}
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
     * @var array(string)
     */
    protected $options = array(
        'successChar' => '+',     // Char to indicate success
        'failureChar' => '-',     // Char to indicate failure
    );
   
    /**
     * Creates a new status bar.
     *
     * @param ezcConsoleOutput $outHandler Handler to utilize for output
     * @param array(string) $settings      Settings
     * @param array(string) $options       Options
     *
     * @see ezcConsoleStatusbar::$options
     */
    public function __construct( ezcConsoleOutput $outHandler, $options = array() ) {
        
    }
    
    /**
     * Add a status to the status bar.
     * Adds a new status to the bar which is printed immediatelly. If the
     * cursor is currently not at the beginning of a line, it will move to
     * the next line.
     *
     * @param bool $status Print successChar on true, failureChar on false.
     */
    public function add( $status ) {
        
    }

    /**
     * Returns number of successes during the run.
     * Returns the number of success characters printed from this status bar.
     * 
     * @returns int Number of successes.
     */
    public function getSuccesses( ) {
        
    }
    
    /**
     * Returns number of failures during the run.
     * Returns the number of failure characters printed from this status bar.
     * 
     * @returns int Number of failures.
     */
    public function getFailures( ) {
        
    }

}
