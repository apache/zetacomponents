<?php
/**
 * File containing the ezcSignalObserver class.
 *
 * @package SignalObserver
 * @version //autogen//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * The ezcSignalObserver is an application wide single class to allow
 * communication between Modules that don't know each other. The class
 * implements a global observer patter. Each class can provide slots to
 * the observer, where other classes can connect to.
 *
 * @example ../../docs/example.php
 * 
 * @package SignalObserver
 * @version //autogen//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
class ezcSignalObserver
{
    /**
     * Connections known by the observer.
     * Whenever a connection is created, it will be stored here.
     *
     * @var array()
     */
    public $connections = array();
    
    /**
     * Singleton instance.
     * The global instance of the observer. Can be retreived using
     * {@link ezcSignalObserver::getInstance()}.
     *
     * @var ezcSignalObserver
     */
    static public $instance = null;

    /**
     * Constructor
     * The constructor is private, please use singleton impelemntation
     * {@ling ezcSignalObserver::getInstance()}.
     */
    private function __construct()
    {
    }
    
    /**
     * Returns global instance of ezcSignalObserver.
     * Implementation of the singleton pattern. Whenever the ezcSignalObserver
     * is needed, you can grab it calling this static function.
     *
     * @return ezcSignalObserver Single instance.
     */
    static function getInstance()
    {
    }

    /**
     * Connect a signal to a slot.
     * This method is used to connect a specific $signal (which is
     * emitted by the $srcClass source class) to a specific slot
     * (which is a static method of another class).
     *
     * Each time the $srcClass will process the action described in
     * $signal (which is the name of the action), the defined connection
     * will be called (a signal will be emited) to announce this action
     * to every class that has connected to it.
     *
     * @param string $srcClass  The class that will emit the signal.
     * @param string $signal    The signal name to connect to.
     * @param string $destClass The class that will receive the signal.
     * @param string $slot      The method called $destClass to emit the signal.
     *
     * @return bool True on success, otherwise false.
     */
    public function connect( $srcClass, $signal, $destClass, $slot )
    {
    }

    /**
     * Remove a connection.
     * This method will remove a connection that has been stablished by 
     * {ezcSignalObserver::connect()} or {ezcSignalObserver::setConnections()}.
     *
     * @param string $srcClass  The class that would emit the signal.
     * @param string $signal    The signal name the connection was to.
     * @param string $destClass The class that would receive the signal.
     * @param string $slot      The method called $destClass to emit the signal.
     *
     * @return bool True on success, otherwise false.
     */
    public function disconnect( $srcClass, $signal, $destClass, $slot )
    {
    }
    
    /**
     * Emit a signal to all observing classes.
     * This method emits a signal. When this happens all classes that are 
     * connected to this singal will receive a call to their slot.
     *
     * The number of arguments passed to this function is variable. At least 
     * the first 3 parameters are required, where the 3rd parameter can be
     * extended to as many as the $destClass'es $slot awaits. In other words 
     * that means, that you must provide as many $data parameters as expected 
     * by the $slot method.
     *
     * @param string $srcClass The class emiting this signal.
     * @param string $signal   The name of the signal emitted.
     * @param mixed $data      The data to transfer to $slot.
     * @param mixed $data      More data to transfer to $slot.
     * @param mixed ...
     *
     * @return bool True on success, otherwise failure.
     * @throws ezcSignalObserverException 
     * @see ezcSignalObserverException::CODE_INVALID_DATA
     */ 
    public function emit( $srcClass, $signal, $data )
    {
    }

    /**
     * Returns the connections array.
     * Returns the array of connections defined inside the class.
     *
     * @see ezcSignalObserver::$connections
     * @return array(string) Connections defined.
     */
    function getConnections()
    {
    }

    /**
     * Set all connections.
     * This is a convenience method to set all connections at once. All
     * existing connections will be overwritten by this method!
     *
     * @see ezcSignalObserver::$connections
     * @param array(string) Connections to define.
     */
    function setConnections( $connections )
    {
    }
}
?>