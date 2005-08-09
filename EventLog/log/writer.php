<?php

/**
 * Writes the log messages to a specific output. 
 * 
 *
 * @package Logger
 * @copyright Copyright (C) 2005 eZ systems as. All rights reserved.
 * @license LGPL {@link http://www.gnu.org/copyleft/lesser.html}
 * @version //autogentag//
**/
abstract class LogWriter
{
    /**
     * Write the logEntries to a specific group. 
     * 
     * The group can specify to where the entry should be written. 
     * In the case of a database it can be a column. If the writer
     * writes to file it can be to specify the file name. 
     *
     * @param string group 
     *      Group of the log data.
     * @param array logEntries  
     *      An array with strings specifying each column to be written.
     */
    public abstract function writeLogEntry( $group, $logData );
}


?>
