<?php

/**
 * File containing the ezcDebug class.
 *
 * @package Debug
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * The ezcDebug class provides functionality to format and store debug messages and timers. 
 *
 * The functionality of the Debug component is two folded: 
 * - Debug log messages
 * - Timers
 * 
 * The log messages are heavily based on the {@link EventLog} log messages. In fact
 * internally the EventLog is used with its own log writer. The {@link log()} method
 * is almost the same as from the EventLog. The next example demonstrates how to instantiate the
 * ezcDebug class and write some log messages: 
 * <code>
 * $debug = ezcDebug::getInstance(); 
 * $debug->log( "Connecting with the paynet server", 2 );
 * // ...
 * $debug->log( "Connection failed, retrying in 5 seconds", 1 );
 * // ...
 * $debug->log( "Could not connect with the server", 0 );
 * </code>
 *
 * The second parameter of the log method is the verbosity. This is a number that
 * specifies the importance of the log message. That makes it easier to sort out messages of less importance.
 * In this example, we assumed the more important the message, the lower the 
 * verbosity number.
 *
 * The ezcDebug timer is designed to allow the next two timing methods:
 * - Timers, the time between two points in the program. 
 * - Accumulators, gets the relative time after the script started. 
 *
 * The "Timers" are simply set with the methods {@link startTimer()} and {@link stopTimer()}. The next example
 * demonstrates the timing of a simple calculation:
 * <code>
 * $debug = ezcDebug::getInstance();
 * $debug->startTimer( "Simple calculation" );
 * 
 * // Simple calculation
 * $result = 4 + 6;
 *
 * $debug->stopTimer( "Simple calculation" ); // Parameter can be omitted.
 * </code>
 *
 * To get timing points, accumulators, use the {@link switchTimer()} method. This is shown in the next example:
 * <code>
 * $debug = ezcDebug::getInstance();
 * $debug->startTimer( "My script" );
 * // ...
 * $debug->switchTimer( "Reading ini file" );
 * // ...
 * $debug->switchTimer( "Initializing template parser" );
 * // ...
 * $debug->switchTimer( "Parsing" );
 * // ...
 * $debug->stopTimer();
 * </code>
 *
 * @package Debug
 * @version //autogentag//
 * @mainclass
 */
class ezcDebug
{
    /**
     * Instance of the singleton ezcDebug object.
    *
     * Use the getInstance() method to retrieve the instance.
     *
     * @var ezcDebug
     */
    private static $instance = null;

    /**
     * The formatter that generates the debug output.
     *
     * @var ezcDebugFormatter
     */
    private $formatter = null;

    /**
     * A pointer to the logging system.
     *
     * @var ezcLog
     */
    private $log = null;

    /**
     * The timing object used to store timing information.
     *
     * @var ezcDebugTimer
     */
    private $timer = null;

    /**
     * The writer that holds debug output.
     *
     * @var ezcLogWriter
     */
    private $writer = null;

    /**
     * Constructs a new debug object and attaches it to the log object.
     *
     * This method is private because the getInstance() should be called.
     */
    private function __construct()
    {
        $original = ezcLog::getInstance();

        $this->log = clone( $original ); 
        $this->log->reset();
        $this->log->setMapper( new ezcLogFilterSet() );

        // Set the writer.
        $this->writer = new ezcDebugMemoryWriter();

        $filter = new ezcLogFilter();
        $filter->severity = ezcLog::DEBUG;
        $this->log->getMapper()->appendRule( new ezcLogFilterRule( $filter, $this->writer, true ) );

        $this->reset();
    }


    /**
     * Throws always an {@link ezcBasePropertyNotFoundException}. 
     *
     * @throws ezcBasePropertyNotFoundException
     * @param string $name
     * @ignore
     */
    public function __get( $name )
    {
        throw new ezcBasePropertyNotFoundException( $name );
    }

    /**
     * Throws always an {@link ezcBasePropertyNotFoundException}. 
     *
     * @throws ezcBasePropertyNotFoundException
     * @param string $name
     * @param string $value
     * @ignore
     */
    public function __set( $name, $value )
    {
        throw new ezcBasePropertyNotFoundException( $name );
    }


    /**
     * Resets the log messages and timer information.
     * 
     * @return void
     */
    public function reset()
    {
        $this->writer->reset();
        $this->timer = new ezcDebugTimer();
    }

    /**
     * Returns the instance of this class.
     *
     * When the ezcDebug instance is created it is automatically added to the instance
     * of ezcLog.
     *
     * @return ezcDebug
     */
    public static function getInstance()
    {
        if ( is_null( self::$instance ))
        {
            self::$instance = new ezcDebug();
            ezcBaseInit::fetchConfig( 'ezcInitDebug', self::$instance );
        }

        return self::$instance;
    }

    /** 
     * Returns the instance of the EventLog used in this class.
     *
     * The returned instance is not the same as retrieved via the 
     * ezcLog::getInstance() method. 
     * 
     * @return ezcLog
     */ 
    public function getEventLog()
    {
        return $this->log;
    }

    /**
     * Sets the formatter $reporter for the output.
     *
     * If no formatter is set {@link ezcDebugHtmlReporter} will be used by default.
     *
     * @param ezcDebugOutputFormatter $formatter
     * @return void
     */
    public function setOutputFormatter( ezcDebugOutputFormatter $formatter )
    {
        $this->formatter = $formatter;
    }

    /**
     * Returns the formatted debug output.
     *
     * @return string
     */
    public function generateOutput()
    {
        if ( is_null( $this->formatter ) )
            $this->formatter = new ezcDebugHtmlFormatter();

        return $this->formatter->generateOutput( $this->writer->getStructure(), $this->timer->getTimeData() );
    }


    /**
     * Starts the timer with the identifier $name.
     *
     * Optionally, a timer group can be given with the $group parameter.
     *
     * @param string name
     * @param string group
     * @return void
     */
    public function startTimer( $name, $group = null )
    {
        $this->timer->startTimer( $name, $group );
    }

    /**
     * Stores the time from the running timer, and starts a new timer.
     *
     * @param string $newName   Name of the new timer.
     * @param string $oldName   The previous timer that must be stopped.
     *                          Only needed when multiple timers are running.
     * @return void
     */
    public function switchTimer( $newName, $oldName = false )
    {
        $this->timer->switchTimer( $newName, $oldName );
    }

    /**
     * Stops the timer identified by $name.
     *
     * $name can be omitted if only one timer is running.
     *
     * @param $name
     * @return void
     */
    public function stopTimer( $name = false )
    {
        $this->timer->stopTimer( $name );
    }

    /**
     * Writes the debug message $message with verbosity $verbosity.
     *
     * @param string $message
     * @param int $verbosity
     * @param array(string=>string) $extraInfo
     * @return void
     */
    public function log( $message, $verbosity, array $extraInfo = array() )
    {
        // Add the verbosity
        $extraInfo = array_merge( array( "verbosity" => $verbosity ), $extraInfo );
        $this->log->log( $message, ezcLog::DEBUG, $extraInfo );
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
     * function debugHandler( $a, $b, $c, $d )
     * {
     *     ezcDebug::debugHandler( $a, $b, $c, $d );
     * }
     *
     * set_error_handler( "debugHandler" );
     * </code>
     *
     * Use trigger_error() to log warning, error, etc:
     *
     * <code>
     * trigger_error( "[Paynet, templates] Cannot load template", E_USER_WARNING );
     * </code>
     *
     * See the PHP documentation of
     * {@link http://php.net/trigger_error trigger_error} for more information.
     *
     * @param int $errno
     * @param string $errstr
     * @param string $errfile
     * @param int $errline
     * @return void
     */
    public static function debugHandler( $errno, $errstr, $errfile, $errline )
    {
        $log = ezcLog::getInstance();
        $debug = ezcDebug::getInstance();
        $lm = new ezcDebugMessage( $errstr, $errno, $log->source, $log->category );

        $debug->log(
            $lm->message, $lm->severity,
            array( "source" => $lm->source, "category" => $lm->category, "verbosity" => $lm->verbosity, "file" => $errfile, "line" => $errline )
        );
    }
}
?>
