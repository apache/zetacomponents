<?php
/**
 * File containing the ezcLogWriterDatabase class.
 *
 * @package EventLog
 * @version //autogentag//
 * @copyright Copyright (C) 2005 eZ systems as. All rights reserved.
 * @license LGPL {@link http://www.gnu.org/copyleft/lesser.html}
 */

/**
 * Writes the log messages to the database.
 * 
 * @package EventLog
 * @version //autogentag//
 * @copyright Copyright (C) 2005 eZ systems as. All rights reserved.
 * @license LGPL {@link http://www.gnu.org/copyleft/lesser.html}
 */
abstract class ezcLogWriterDatabase extends ezcLogWriter
{
    /**
     *  Construct a new database log-writer.
     * 
     *  This constructor is a tie-in.
     *
     *  @param Database $databaseInstance
     *      An instance of the database that should be used. 
     */
    public function __construct( $databaseInstance )
    {
    }

    /**
     * The function that actually writes the log entry to the database.
     *
     */
    public function writeLogEntry( array $logEntry )
    {
    }
}

?>
