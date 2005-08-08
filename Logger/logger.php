<?php

/**
 * Record log messages and audit trails to a file, database, or any other 
 * writer.
 *
 * Call the getInstance() method from the logger in order to create a new 
 * object. 
 * TODO long description
 *
 * @package Logger
 * @copyright Copyright (C) 2005 eZ systems as. All rights reserved.
 * @license LGPL {@link http://www.gnu.org/copyleft/lesser.html}
 * @version //autogentag//
**/
class Logger
{
	// Define the event types. 
	const DEBUG          = 1;
	const SUCCESS_AUDIT  = 2;
	const FAILED_AUDIT   = 4;
	const INFO           = 8;
	const WARNING        = 16; 
	const ERROR          = 32; 
	const FATAL          = 64; 
	
	/**
     * @var Map
	 * Contains the mapping between the log message and the group.
	 *
	 * This mapping specifies the group or files, depending upon the writer,
	 * the log will be written. 
     *
	**/
	private $groupMap;

	/**
     * $var Map
	 * Contains the mapping between the log message and the writer.
	 *
	 * This mapping specifies the format and storage of the log entries. For
	 * example: write the Audit trails to the database, and the error messages
	 * to a file and a stream. 
	**/
	private $writerMap;

    /**
     * $var Context
	 * Stores the context of the eventType and eventSources
	**/
	private $context;


	/**
     * @var Logger
	 * Store the instance of this class.
	**/
	private static $instance = null;
	

	/**
	 *  Don't call the constructor, use the getInstance method instead. 
	**/
	private function __construct()
	{
	}

	/** 
 	 * Creates and returns a new instance of the class or returns the existing
	 * class.
	 *
	 * @return Instance of this class. 
	**/
	public function getInstance()
	{
	}

	/**
	 * Set default logging values.
	**/
	public function setDefaults()
	{
		// assignGroups
		// assignWriters
	}

    /**
     * Enable context checking during development. 
     */
    public function enableContextChecking()
    {
    }

    /**
     * Do not check the log context. 
    **/
    public function disableContextChecking()
    {
    }
	
	/**
	 * Write a message to the log.
	 * 
	 * Program related messages, such as errors, warning, or user related
	 * messages, audit trails, can be written.
	 * 
	 * @param string message
	 *         The log message that should be written.
	 * @param int eventType    
	 *         The eventType which should be one of the following constants: 
	 *         DEBUG, WARNING, SUCCES_AUDIT, FAIL_AUDIT, INFO, ERROR, FATAL.
	 * @param string eventSource 
	 * 			The component or part of the program this log message applies to: 
	 *          E.g. Paynet.
	 * @param string eventCategory
	 *          The category of the message. This makes the most sense for audit 
	 *          trails. Examples are: edit, published, login/logout, etc.
     * @param array context
     *          An associative array to store additional fields to the log. 
     *          For the DEBUG, INFO, WARNING, ERROR, and FINAL event types 
     *          the File and Line contexts exist.
     *
	 * @example
     * $myLog->log( "Paynet failed to connect with the server", $myLog->WARNING, "PAYNET", false, array( "File" => __FILE__, "Line" => __LINE__) );
	 * $mylog->log( "Wrong CC number inserted", $myLog->FAILED_AUDIT, "PAYNET", "Security");
    **/ 
	public function log( $message, $eventType, $eventSource, $eventCategory = false, $context = false ) 
	{
	}

	/**
	 * Assigns a writer to a group of specific messages.  
	 *
	 * @param integer eventTypeMask
	 * 		The bit mask of the eventTypes. 
	 * @param array eventSources
	 *      Multiple eventSources are assigned in the array. Empty array means all.
	 * @param array eventCategories
	 *      Multiple eventCategories are assigned in the array. Empty array means all.
	 * @param object Writer
	 * 		The writer that writes the log message. These writers implement the writer interface. 
	 *      An user can implement its own log writer.
	 * 
	 * @return void
	 * 
	 * @example
	 * 	assignWriter( $log->SUCCES_AUDIT | $log->FAILED_AUDIT, array(), array(), new DatabaseWriter("localhost", ..) );
	 * 	assignWriter( $log->ERROR | $log->FATAL, array("PAYNET"), array(), new MailWriter("rb@ez.no", ..) );
	 * 	assignWriter( $log->ERROR | $log->FATAL, array(), new UnixFileWriter() );
	**/
	public function assignWriter( $eventTypeMask, $eventSources, $eventCategories, $Writer)
	{
	}

    /**
     * Returns an array with the writers attached to the logger.
     * 
     * @return array
     */
    public function getWriters()
    {
    }

	/**
	 * Assigns a group to a specific messages.
	 * 
	 * @example
	 * assignGroup( (SUCCESS_AUDIT | FAILED_AUDIT), array(), array("Login/Logout"), "Security" )
	 * assignGroup( (ERROR | FATAL), array(), array(), "error")
	 * assignGroup( DEBUG, array("Paynet"), array(), "paynet_debug"); 
	**/
	public function assignGroup ( $eventType, $eventSources, $eventCategories, $GroupName)
	{
		//writerMap->setMapping($eventType, eventSources, eventCategories, GroupName);
	}


    /**
     * Returns an array with the groups attached to the logger.
     */
    public function getGroups()
    {
    }


    /**
     * Attaches an eventTypeContext the the logger.
     *
     * @param array $eventTypeMask 
     *      Mask with eventTypes which will trigger a certain context.
     * @param array context
     *      Array with context strings.
     */
    public function assignEventTypeContext ($eventTypeMask, $context) 
    {
    }


    /**
     * @param array $eventTypeSources 
     *      Array with eventSources (strings) which will trigger a certain 
     *      context.
     * @param array context
     *      Array with context strings.
     */
    public function assignEventSourceContext ( $eventSources, $context )
    {
    }

    /**
     * Write the log message to the correct writer. 
    **/
    private function writeLogMessage ()
    {
    }
    
	/**
	 * Usually called by the trigger_error function. 
	 * 
	 * This method calls the log function.
	 */
	public static function ErrorHandler ()
	{
	}
}
	
?>
