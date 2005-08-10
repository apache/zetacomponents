<?php

/**
 * File containing the ezcDebug class.
 *
 * @package Debug
 * @version //autogentag//
 * @copyright Copyright (C) 2005 eZ systems as. All rights reserved.
 * @license LGPL {@link http://www.gnu.org/copyleft/lesser.html}
 */

/** 
 * The main debug API.
 *
 * TODO: 
 * What to do with recursive timers? Ignore when someone tries to start the 
 * new timer with the same name. 
 *
 * @package Debug
 * @version //autogentag//
 * @copyright Copyright (C) 2005 eZ systems as. All rights reserved.
 * @license LGPL {@link http://www.gnu.org/copyleft/lesser.html}
 */ 
class ezcDebug
{
    /** 
     * @var ezcDebugFormatter
     */
	private $formatter = null;

    /**
     * @var ezcLog
     */
	private $log = null;

    /**
     * @var ezcDebugTimer
     */
	private $timer = null;

    /**
     * @var ezcLogWriter
     */
    private $writer = null;

    /** 
     * Constructs an new Debug class and attaches it to the log object.
     */
	private function __construct()
	{
        $this->log = ezcLog::getInstance();

        // Set the writer.
        $this->writer = new ezcDebugWriterMemory();
        $this->log->assignWriter((ezcLog::ERROR | ezcLog::WARNING | ezcLog::FATAL | ezcLog::NOTICE), array(), array(), $this->writer);
        $this->log->assignGroup((ezcLog::ERROR | ezcLog::WARNING | ezcLog::FATAL | ezcLog::NOTICE), array(), array(), "Debug");

        $this->timer = new ezcDebugTimer();
	}

    /**
     * Set the formatter for the output. 
     * 
     * The HTML formatter is set by default. 
     */
	public function setOutputFormatter( $formatter )
	{
        $this->formatter = $formatter;
	}

    /**
     * Get the formatted output.
     */
    public function getOutput()
    {
        if( is_null( $this->formatter ) ) $this->formatter = new ezcDebugFormatterHTML();
        return $reporter->getOutput( $this->writer, $this->timer );
    }


    /**
     * Starts the timer.
     * 
     * @param string name    Name of the timer.
     * @param string source  Source of the timer.
     * @param string group   Group or category. To which group belongs the 
     *                       timer. 
     * @return void
     */
    public function startTimer( $name, $source, $group )
    {
        $this->timer->startTimer( $name, $source, $group );
    }

    /** 
     * Stores the time from the running timer, and starts a new timer.
     * 
     * @param string $newName   Name of the new timer. 
     * @param string $oldName   The previous timer that must be stopped. 
     *                          Only needed when multiple timers are running. 
     */
    public function switchTimer( $newName, $oldName = false )
    {
        $this->timer->switchTimer( $newName, $oldName );
    }

    /**
     * Stop the timer
     *
     * @param $name Need to supply a name only when multiple timers are running.
     */ 
    public function stopTimer($name = false)
    {
        $this->timer->stopTimer( $name );
    }

    /**
     * Forward the messages to the log.
     */
	public function log( $message, $eventType, $eventSource, $eventCategory = false, $extraInfo = false ) 
	{
        return $this->log->log( $message, $eventType, $eventSource, $eventCategory, $extraInfo );
	}

    /**
     * Dispatches the message and error type to the correct debug or log 
     * function.
     * 
     * This function should be used as the set_error_handler from the 
     * trigger_error function.
     *
     * Use for example the following code in your application:
     * 
     * <code>
     * function errorHandler($a, $b, $c, $d)
     * {
     *    ezcDebug::errorHandler($a, $b, $c, $d);
     * }
     *
     * set_error_handler("errorHandler");
     * </code>
     *
     * Use trigger_error to log warning, error, etc:
     *
     * <code>
     * trigger_error("[Paynet, templates] Cannot load template", E_USER_WARNING);
     * </code>
     */
    public static function errorHandler( $errno, $errstr, $errfile, $errline )
    {
       list( $params, $message ) = ezcDebug::splitErrorString( $errstr );
    }

    /**
     * Subtract the parameters and message from an trigger_error message. 
     * 
     * The format of a trigger_error message is either:
     * <code>
     * "[ function, source, category ] message" 
     * </code>
     * or
     * <code>
     * "[ source, category ] message" 
     * </code>
     *
     * Function can be: START_TIMER, STOP_TIMER, and FATAL.
     * Source: Paynet for example.
     * category: Category for Warnings and Errors. But is a group for timers. 
     *
     * @param  string $str
     * @return array       Returns an array with two elements. First element is
     *                     an array with parameters. The second element 
     *   contains the message. So the structure is as follows: 
     *   <code> 
     *   array( array( param1, param2, param3), message)
     *   </code>
     */
    public static function splitErrorString( $str )
    {
    }
}


?>
