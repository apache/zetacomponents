<?php
/**
 * File containing the ezcLogWriterFile class.
 *
 * @package EventLog
 * @version //autogentag//
 * @copyright Copyright (C) 2005 eZ systems as. All rights reserved.
 * @license LGPL {@link http://www.gnu.org/copyleft/lesser.html}
 */

/**
 * Writes the log messages to a file
 *
 * @package EventLog
 * @version //autogentag//
 * @copyright Copyright (C) 2005 eZ systems as. All rights reserved.
 * @license LGPL {@link http://www.gnu.org/copyleft/lesser.html}
 */
abstract class ezcLogWriterFile extends ezcLogWriter
{
    /**
     * @var file_handles  Contains the open files.
     */
    protected $openFiles;

    /** 
     * @var ezcLogMap  Keeps track of which group of messages should be stored 
     *                 in which file. 
     */
    protected $fileMap;

    /** 
     * Sets the log rotation size of the files. 
     *
     * @param integer $size  Maximum file size in bytes.
     */
    public function setLogRotationSize($size)
    {
    }

    /**
     * Returns the log rotation size in bytes.
     *
     * @returns integer
     */
    public function getLogRotationSize()
    {
    }

    /**
     * Sets the maximum number of log rotated files.
     * 
     * @param integer $nrOfFiles
     */
    public function setMaximumLogRotatedFiles( $nrOfFiles )
    {
    }

    /**
     * Set The Log directory to where the files will be written.
     * 
     */
    public function setLogDirectory( $directory ) 
    {
    }
    

    /**
     * The function that actually writes the log entry. The logEntry is an array
     * describing the entries that should be logged. 
     * 
     * <code>
     * $logEntry["message"]   The log message.
     * $logEntry["type"]      The severity.
     * $logEntry["source"]    The source. 
     * $logEntry["category"]  The category. 
     * </code>
     *
     * @returns boolean Returns true when the log entry is correctly written.
     */
    public function writeLogEntry( array $logEntry )
    {
    }

    /**
     * Open file and rotate log automatically.
     */ 
    private function openFile( string $fileName )
    {
    }

    /**
     * Rotate log.
     */
    private function logRotate( $size )
    {
    }

	/**
	 * Assigns a filename to a specific group of messages.
     *
     * @returns boolean True is returned when the filename is writable and 
     *                  correctly bound to a group of messages.
	 * 
     * <code>
	 * assignGroup( (SUCCESS_AUDIT | FAILED_AUDIT), array(), array("Login/Logout"), "Security" )
	 * assignGroup( (ERROR | FATAL), array(), array(), "error")
	 * assignGroup( DEBUG, array("Paynet"), array(), "paynet_debug"); 
     * </code>
	 */
	public function setFileName ( $eventTypeMask, $eventSources, $eventCategories, $filename)
	{
	}


}

?>
