<?php

/**
 * File containing the ezcDebugWriterMemory class.
 *
 * @package Debug
 * @version //autogentag//
 * @copyright Copyright (C) 2005 eZ systems as. All rights reserved.
 * @license LGPL {@link http://www.gnu.org/copyleft/lesser.html}
 */

/** 
 * This class implements a LogWriter. This writer will write all the log messages
 * it receives to an internal structure. The whole internal structure can be sent
 * to an formatter when the getLogEntries() method is called. 
 *
 * @package Debug
 * @version //autogentag//
 * @copyright Copyright (C) 2005 eZ systems as. All rights reserved.
 * @license LGPL {@link http://www.gnu.org/copyleft/lesser.html}
 */ 
class ezcDebugWriterMemory extends ezcLogWriter
{
    /**
     * Internal structure to keep the log messages.
     */
    private $logData = array();

    /**
     * Writes a log entry to the internal memory structure. 
     * 
     * @param string $group
     * @param array $logData
     */
    public function writeLogEntry( $group, $logData )
    {
    }

    /** 
     * Returns all log entries in an array.
     * 
     * @returns array
     */
    public function getLogEntries()
    {
    }
}


?>
