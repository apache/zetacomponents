<?php
/**
 * File containing the ezcCacheStorageApcOptions class.
 *
 * @package Cache
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @filesource
 */

/**
 * Option class for defining a connection to APC.
 *
 * @package Cache
 * @version //autogentag//
 */
class ezcCacheStorageApcOptions extends ezcBaseOptions
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
     * @param string $name The name of the option to get
     * @return mixed The option value
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
