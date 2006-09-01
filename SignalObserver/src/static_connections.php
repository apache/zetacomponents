<?php
/**
 * @copyright Copyright (C) 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package SignalObserver
 */

/**
 * ezcSignalStaticConnections makes it possible to connect to signals through the signals identifier.
 *
 * The static connections allow you to:
 * - connect to a signal sent by any object signal collection with the same identifier. Usually the
 *   identifier is set to the name of the class holding the collection. Using the static connections
 *   you can connect to a signal sent by any object of that class.
 *
 * - connect to a signal that does not yet exist. This allows you to delay initialization of the
 *   emitting object until it is needed.
 *
 * TODO: examples
 *
 * @property array $connections Holds the internal structure of signals. The format is
 *                 array(priority=>array(slots)). It can be both read and set in order
 *                 to provide easy setup of the static connections from disk.
 *
 * @version //autogen//
 * @mainclass
 * @package SignalObserver
 */
class ezcSignalStaticConnections
{
    /**
     * Holds the properties of this class.
     *
     * @var array(string=>array(signalName=>array(slots)))
     */
    private $properties = array();

    /**
     * ezcSignalStaticConnections singleton instance
     *
     * @var ezcConfigurationManager
     */
    private static $instance = null;

    /**
     * Holds the connections for this object.
     *
     * @var array(string=>array(int=>array(callback)))
     */
    private $connections = array();

    public static function getInstance()
    {
        if( self::$instance === null )
        {
            self::$instance = new ezcSignalStaticConnections();
        }
        return self::$instance;
    }

    /**
     * Sets the property $name to $value.
     *
     * @throws ezcBasePropertyNotFoundException if the property does not exist.
     * @param string $name
     * @param mixed $value
     * @return void
     */
    public function __set( $name, $value )
    {
        switch ( $name )
        {
            case 'connections':
                $this->properties[$name] = $value;
                break;
            default:
                throw new ezcBasePropertyNotFoundException( $name );
                break;
        }

    }

    /**
     * Returns the property $name.
     *
     * @throws ezcBasePropertyNotFoundException if the property does not exist.
     * @param string $name
     * @return mixed
     */
    public function __get( $name )
    {
        switch ( $name )
        {
            case 'connections':
                return $this->properties[$name];
                break;

            default:
                throw new ezcBasePropertyNotFoundException( $name );
                break;
        }
    }


    /**
     * Connects the signal $signal emited by any ezcSignalCollection with the identifier
     * $identifier to the slot $slot.
     *
     * To control the order in which slots are called you can set a priority
     * from 1 - 65 536. The lower the number the higher the priority. The default
     * priority is 1000.
     * Slots with the same priority may be called with in any order.
     *
     * A slot will be called once for every time it is connected. It is possible
     * to connect a slot more than once.
     *
     * See the PHP documentation for examples on the callback type.
     * http://php.net/callback
     *
     * We reccommend avoiding excessive usage of the $priority parameter
     * since it makes it much harder to track how your program works.
     *
     * @param string $identifier
     * @param string $signal
     * @param callback $slot
     * @param int priority
     * @return void
     */
    public function connect( $identifier, $signal, $slot )
    {
        if( !isset( $this->connections[$identifier] ) )
        {
            $this->connections[$identifier] = array();
        }
        $this->connections[$identifier][$signal][] = $slot;
    }
}

?>
