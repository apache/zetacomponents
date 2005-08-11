<?php
/**
 * File containing the ezcLog class.
 *
 * @package EventLog
 * @version //autogentag//
 * @copyright Copyright (C) 2005 eZ systems as. All rights reserved.
 * @license LGPL {@link http://www.gnu.org/copyleft/lesser.html}
 */

/**
 * Record log messages and audit trails to a file, database, or any other 
 * writer.
 *
 * Call the getInstance() method from the log in order to create a new 
 * object. 
 * TODO long description
 *
 * @package EventLog
 * @version //autogentag//
 * @copyright Copyright (C) 2005 eZ systems as. All rights reserved.
 * @license LGPL {@link http://www.gnu.org/copyleft/lesser.html}
 */
class ezcLog
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
     * $var ezcLogMap
	 * Contains the mapping between the log message and the writer.
	 *
	 * This mapping specifies the format and storage of the log entries. For
	 * example: write the Audit trails to the database, and the error messages
	 * to a file and a stream. 
	 */
	private $writerMap;

    /**
     * $var ezcLogContext
	 * Stores the context of the eventType and eventSources
	 */
	protected $context;


	/**
     * @var Log
	 * Store the instance of this class.
	 */
	private static $instance = null;
	

	/**
	 * Don't call the constructor, use the getInstance method instead to get an 
     * Logger object. 
	 */
	private function __construct()
	{
	}

	/** 
 	 * Returns the instance of the class.
	 *
	 * @returns Instance of this class. 
	 */
	public function getInstance()
	{
	}

	/**
	 * Set default logging values.
	 */
	public function setDefaults()
	{
		// assignGroups
		// assignWriters
	}

    /** 
     * Enable writer exceptions to be thrown when an log entry couldn't be written 
     * in a specific writer. 
     */
    public function enableWriterExceptions()
    {
    }

    /** 
     * Disable writer exceptions to be thrown when an log entry couldn't be written 
     * in a specific writer. 
     *
     * Actually, this is quite the opposite of enableWriterExceptions() :-). 
     */
    public function disableWriterExceptions()
    {
    }

    /**
     *  Set the context of event source. These context will be added everytime 
     *  the set event source is given. 
     *
     *  @param array(string) $eventSource
     *      An array with strings specifying the event sources. 
     *  @param array(string => string) $context
     *      Set the context with an associative array consisting of context name and 
     *      value. 
     */
    public function setContext( $eventSource, $context ) 
    {
    }
    
	/**
	 * Write a message to the log.
	 * 
	 * Program related messages, such as errors, warning, or user related
	 * messages, audit trails, can be written.
	 * 
	 * @param string message
	 *        The log message that should be written.
	 * @param int eventType    
	 *        The eventType which should be one of the following constants: 
	 *        DEBUG, WARNING, SUCCES_AUDIT, FAIL_AUDIT, INFO, ERROR, FATAL.
	 * @param string eventSource 
	 * 		  The component or part of the program this log message applies to: 
	 *        E.g. Paynet.
	 * @param string eventCategory
	 *        The category of the message. This makes the most sense for audit 
	 *        trails. Examples are: edit, published, login/logout, etc.
     * @param array(string => string) extraInfo
     *        An associative array to store additional fields to the log. 
     *        For the DEBUG, INFO, WARNING, ERROR, and FINAL event types 
     *        the File and Line contexts exist.
     *
     * @throws ezcLogWriterException when exception are enabled in the Log 
     *         class and a log entry couldn't be written.
     * 
	 * <code>
     * $myLog->log( "Paynet failed to connect with the server", Log::WARNING, "PAYNET", false, array( "File" => __FILE__, "Line" => __LINE__) );
	 * $mylog->log( "Wrong CC number inserted", Log::FAILED_AUDIT, "PAYNET", "Security");
     * </code>
     * 
     */ 
	public function log( $message, $eventType, $eventSource, $eventCategory = false, $extraInfo = false ) 
	{
	}

	/**
	 * Assigns a writer to a group of specific messages.  
	 *
	 * @param integer eventTypeMask
	 * 		The bit mask of the eventTypes. 
	 * @param array(string) eventSources
	 *      Multiple eventSources are assigned in the array. Empty array means all.
	 * @param array(string) eventCategories
	 *      Multiple eventCategories are assigned in the array. Empty array means all.
	 * @param object Writer
	 * 		The writer that writes the log message. These writers implement the writer interface. 
	 *      An user can implement its own log writer.
	 * 
	 * @return void
     * @throws ezcLogWriterException if the assigned writer is from the wrong type.
	 * 
	 * <code>
	 * 	assignWriter( Log::SUCCES_AUDIT | Log::FAILED_AUDIT, array(), array(), new DatabaseWriter("localhost", ..) );
	 * 	assignWriter( Log::ERROR | Log::FATAL, array("PAYNET"), array(), new MailWriter("rb@ez.no", ..) );
	 * 	assignWriter( Log::ERROR | Log::FATAL, array(), new UnixFileWriter() );
     * </code>
	 */
	public function assignWriter( $eventTypeMask, $eventSources, $eventCategories, $Writer )
	{
	}

    /**
     * Returns an array with the writers attached to the log.
     * 
     * @return array(ezcLogWriter)
     */
    public function getWriters()
    {
    }

    /**
     * Attaches an eventTypeContext the the log. These are hardcoded, so they 
     * are set up by the Log.
     *
     * @param integer $eventTypeMask 
     *      Mask with eventTypes which will trigger a certain context.
     * @param array(string => string) $context
     *      Array with context strings.
     */
    protected function assignEventTypeContext ( $eventTypeMask, $context ) 
    {
    }


    /**
     * @param array(string) $eventTypeSources 
     *      Array with eventSources (strings) which will trigger a certain 
     *      context.
     * @param array(string => string) context
     *      Array with context strings.
     */
    public function assignEventSourceContext ( $eventSources, $context )
    {
    }

    /**
     * Write the log message to the correct writer. 
     */
    private function writeLogMessage()
    {
    }
    
	/**
	 * Usually called by the trigger_error function. 
	 * 
	 * This method calls the log function.
	 */
	public static function ErrorHandler()
	{
	}

}
	
?>
