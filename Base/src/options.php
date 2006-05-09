<?php
/**
 * File containing the ezcBaseOptions class.
 *
 * @package Base
 * @version //autogentag//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * Base options class for all eZ components.
 *
 * @package Base
 */
abstract class ezcBaseOptions implements ArrayAccess
{
    abstract public function __set( $propertyName, $propertyValue );

    /**
     * Construct a new options object.
     * Options are constructed from an option array by default. The constructor
     * automatically passes the given options to the __set() method to set them 
     * in the class.
     * 
     * @return void
     *
     * @throws ezcBasePropertyNotFoundException
     *         If a the value for the property options is not an instance of
     * @throws ezcBaseValueException
     *         If a the value for a property is out of range.
     */
    final public function __construct( array $options = array() )
    {
        foreach ( $options as $option => $value )
        {
            $this->__set( $option, $value );
        }
    }
    
    /**
     * Property get access.
     * Simply returns a given option.
     * 
     * @param string $propertyName The name of the option to get.
     * @return mixed The option value.
     *
     * @throws ezcBasePropertyNotFoundException
     *         If a the value for the property options is not an instance of
     */
    final public function __get( $propertyName )
    {
        if ( isset( $this->$propertyName ) )
        {
            return $this->$propertyName;
        }
        throw new ezcBasePropertyNotFoundException( $propertyName );
    }
    
    /**
     * Returns if an option exists.
     * Allows isset() using ArrayAccess.
     * 
     * @param string $propertyName The name of the option to get.
     * @return bool Wether the option exists.
     */
    final public function offsetExists( $propertyName )
    {
        return isset( $this->$propertyName );
    }

    /**
     * Returns an option value.
     * Get an option value by ArrayAccess.
     * 
     * @param string $propertyName The name of the option to get.
     * @return mixed The option value.
     *
     * @throws ezcBasePropertyNotFoundException
     *         If a the value for the property options is not an instance of
     */
    final public function offsetGet( $propertyName )
    {
        return $this->__get( $propertyName );
    }

    /**
     * Set an option.
     * Sets an option using ArrayAccess.
     * 
     * @param string $propertyName The option to set.
     * @param mixed $propertyValue The value for the option.
     * @return void
     *
     * @throws ezcBasePropertyNotFoundException
     *         If a the value for the property options is not an instance of
     * @throws ezcBaseValueException
     *         If a the value for a property is out of range.
     */
    final public function offsetSet( $propertyName, $propertyValue )
    {
        $this->__set( $propertyName, $propertyValue );
    }

    /**
     * Unset an option.
     * Unsets an option using ArrayAccess.
     * 
     * @param string $propertyName The options to unset.
     * @return void
     *
     * @throws ezcBasePropertyNotFoundException
     *         If a the value for the property options is not an instance of
     * @throws ezcBaseValueException
     *         If a the value for a property is out of range.
     */
    final public function offsetUnset( $propertyName )
    {
        $this->__set( $propertyName, null );
    }
}
?>
