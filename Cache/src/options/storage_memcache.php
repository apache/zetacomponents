<?php
/**
 * File containing the ezcCacheStorageMemcacheOptions class.
 *
 * @package Cache
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @filesource
 */

/**
 * Option class for defining a connection to a Memcache server.
 *
 * @property string $host
 *           The name of the Memcache host to use, usually localhost.
 * @property int $port
 *           The port on which to connect to host, usually 11211.
 * @property bool $persistent
 *           If a persistent connection to the Memcache host is needed. Default
 *           is false. A persistent connection stays open between requests.
 * @property bool $compressed
 *           If on-the-fly compression is needed. Default is false. Requires the
 *           zlib PHP extension.
 *
 * @package Cache
 * @version //autogentag//
 */
class ezcCacheStorageMemcacheOptions extends ezcBaseOptions
{
    /**
     * Parent storage options. 
     * 
     * @var ezcCacheStorageOptions
     */
    protected $storageOptions;

    /**
     * Constructs an object with the specified values.
     *
     * @throws ezcBasePropertyNotFoundException
     *         If $options contains a property not defined.
     * @throws ezcBaseValueException
     *         If $options contains a property with a value not allowed.
     * @param array(string=>mixed) $options
     */
    public function __construct( array $options = array() )
    {
        $this->properties['host'] = false;
        $this->properties['port'] = false;
        $this->properties['persistent'] = false;
        $this->properties['compressed'] = false;
        $this->storageOptions = new ezcCacheStorageOptions();

        parent::__construct( $options );
    }

    /**
     * Sets the option $name to $value.
     *
     * @throws ezcBasePropertyNotFoundException
     *         If the property $name is not defined.
     * @throws ezcBaseValueException
     *         If $value is not correct for the property $name.
     * @param string $name
     * @param mixed $value
     * @ignore
     */
    public function __set( $name, $value )
    {
        switch ( $name )
        {
            case 'host':
                $this->properties[$name] = $value;
                break;

            case 'port':
                if ( $value !== false && !is_int( $value ) )
                {
                    throw new ezcBaseValueException( $name, $value, 'int' );
                }
                $this->properties[$name] = $value;
                break;

            case 'persistent':
            case 'compressed':
                if ( !is_bool( $value ) )
                {
                    throw new ezcBaseValueException( $name, $value, 'bool' );
                }
                $this->properties[$name] = $value;
                break;

            default:
                // Delegate
                $this->storageOptions->$name = $value;
        }
    }

    /**
     * Returns the value of the option $name.
     * 
     * @throws ezcBasePropertyNotFoundException
     *         If the property $name is not defined.
     * @param string $name The name of the option to get.
     * @return mixed The option value.
     * @ignore
     */
    public function __get( $name )
    {
        if ( isset( $this->properties[$name] ) === true )
        {
            return $this->properties[$name];
        }

        // Delegate
        return $this->storageOptions->$name;
    }

    /**
     * Returns if option $name is defined.
     * 
     * @param string $name Option name to check for
     * @return bool
     * @ignore
     */
    public function __isset( $name )
    {
        return ( isset( $this->properties[$name] ) || isset( $this->storageOptions->$name ) );
    }
}
?>
