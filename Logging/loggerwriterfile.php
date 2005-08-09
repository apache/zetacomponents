<?php

/**
 * Writes the log messages to a file
 * 
 *
 * @package Logger
 * @copyright Copyright (C) 2005 eZ systems as. All rights reserved.
 * @license LGPL {@link http://www.gnu.org/copyleft/lesser.html}
 * @version //autogentag//
**/
abstract class LoggerWriterFile extends LoggerWriter
{
    /**
     * Write the logEntries to a specific file. 
     * 
     * @param string group 
     *      Group of the log data.
     * @param array logEntries  
     *      An array with strings specifying each column to be written.
     */
    public abstract function writeLogEntry( $group, $logData );

    /**
     * Rotate the log.
     */
    private function rotateLog()
    {
    }

    /**
     * Set the rotate log size.
     *
     * @param int $size
     */
    public function setRotateLogSize( $size )
    {
    }

    /**
     *  Set the rotate log time out.
     *
     *  @param int $seconds 
     *      Set the time out in seconds.
     */
    public function setRotateLogTimeOut ( $seconds )
    {
    }
    
}


?>
