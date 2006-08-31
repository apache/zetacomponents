<?php
/**
 * @copyright Copyright (C) 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package SignalObserver
 */

/**
 * ezcSignalCollection implements a mechanism for inter and intra object communication.
 *
 * TODO: examples
 *
 * @property bool $signalsBlocked     If set to true emits will not cause any slots to be called.
 *
 * @property-read string $identifier  The identifier of this signal collection.
 *                                    Usually the class name of the object containing the collection.
 *
 * @version //autogen//
 * @mainclass
 * @package SignalObserver
 */
class ezcSignalCollection
{
    /**
     * Holds the properties of this class.
     *
     * @var array(string=>mixed)
     */
    private $properties = array();

    /**
     * Holds the connections for this object.
     *
     * @var array(string=>array(int=>array(callback)))
     */
    private $connections = array();

    /**
     * Constructs a new signal collection with the identifier $identifier.
     *
     * The identifier can be used to connect to signals statically using
     * ezcSignalStaticConnections.
     *
     * @param string $identifier
     */
    public function __construct( $identifier )
    {
        $this->identifier = $identifier;
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
            case 'signalsBlocked':
                $this->properties[$name] = $value;
                break;
            case 'identifier':
                throw new ezcBasePropertyPermissionException( $name, ezcBasePropertyPermissionException::READ );
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
            case 'signalsBlocked':
            case 'identifier':
                return $this->properties[$name];
                break;

            default:
                throw new ezcBasePropertyNotFoundException( $name );
                break;
        }
    }


    /**
     * Emits the signal with the name $signal
     *
     * Any additional parameters are sent as parameters to the slot.
     *
     * @param string $signal
     * @param ... signal parameters
     * @return void
     */
    public function emit( $signal )
    {
        if( $this->signalsBlocked )
        {
            return;
        }

        if( isset( $this->connections[$signal] ) )
        {
            foreach( $this->connections[$signal] as $slot )
            {
                call_user_func( $slot );
            }
        }

        $staticConnections = ezcSignalStaticConnections::getInstance()->loadStaticSignals( $this->identifier );
        if( $staticConnections != null )
        {
            foreach( $staticConnections[$signal] as $slot )
            {
                call_user_func( $slot );
            }
        }
    }

    /**
     * Connects the signal $signal to the slot $slot.
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
     * http://php.net/callback.
     *
     * We reccommend avoiding excessive usage of the $priority parameter
     * since it makes it much harder to track how your program works.
     *
     * @param string $signal
     * @param callback $slot
     * @param int priority
     * @return void
     */
    public function connect( $signal, $slot, $priority = 1000 )
    {
        if( !isset( $this->connections[$priority] ) )
        {
            $this->connections[$priority] = array();
        }
        $this->connections[$signal][$priority][] = $slot;
    }

    /**
     * Disconnects the $slot from the $signal.
     *
     * If the priority is given it will try to disconnect a slot with that priority.
     * If no such slot is found no slot will be disconnected.
     *
     * If no priority is given it will disconnect the slot with the highest priority.
     *
     * @param string $signal
     * @param callback $slot
     * @param int priority
     * @return void
     */
    public function disconnect( $signal, $slot, $priority = null )
    {
    }
}
?>
