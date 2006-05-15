<?php
/**
 * File containing the abstract ezcGraphDatasetProperty class
 *
 * @package Graph
 * @version //autogentag//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * Abstract class for properties of datasets
 *
 * @package Graph
 */
abstract class ezcGraphDatasetProperty implements ArrayAccess
{
    /**
     * Default value for this property
     * 
     * @var mixed
     */
    protected $defaultValue;

    /**
     * Contains specified values for single dataset elements
     * 
     * @var array
     */
    protected $dataValue;

    /**
     * Contains a reference to the dataset to check for availability of data
     * keys
     * 
     * @var ezcGraphDataset
     */
    protected $dataset;

    /**
     * Abstract method to contain the check for validity of the value
     * 
     * @param & $value 
     * @abstract
     * @access protected
     * @return void
     */
    abstract protected function checkValue( &$value );

    public function __construct( ezcGraphDataset $dataset )
    {
        $this->dataset = $dataset;
    }

    /**
     * Set the default value for this property
     * 
     * @param string $name Property name
     * @param mixed $value Property value
     * @return void
     */
    public function __set( $name, $value )
    {
        if ( $name === 'default' &&
             $this->checkValue( $value ) )
        {
            $this->defaultValue = $value;
        }
    }

    /**
     * Get the default value for this property
     * 
     * @param string $name Property name
     * @return mixed
     */
    public function __get( $name )
    {
        if ( $name === 'default' )
        {
            return $this->defaultValue;
        }
    }

    /**
     * Returns if an option exists.
     * Allows isset() using ArrayAccess.
     * 
     * @param string $key The name of the option to get.
     * @return bool Wether the option exists.
     */
    final public function offsetExists( $key )
    {
        return isset( $this->dataset[$key] );
    }

    /**
     * Returns an option value.
     * Get an option value by ArrayAccess.
     * 
     * @param string $key The name of the option to get.
     * @return mixed The option value.
     *
     * @throws ezcBasePropertyNotFoundException
     *         If a the value for the property options is not an instance of
     */
    final public function offsetGet( $key )
    {
        if ( isset( $this->dataValue[$key] ) )
        {
            return $this->dataValue[$key];
        }
        elseif ( isset( $this->dataset[$key] ) )
        {
            return $this->defaultValue;
        }
        else
        {
            throw new ezcGraphNoSuchDataException( $key );
        }
    }

    /**
     * Set an option.
     * Sets an option using ArrayAccess.
     * 
     * @param string $key The option to set.
     * @param mixed $value The value for the option.
     * @return void
     *
     * @throws ezcBasePropertyNotFoundException
     *         If a the value for the property options is not an instance of
     * @throws ezcBaseValueException
     *         If a the value for a property is out of range.
     */
    final public function offsetSet( $key, $value )
    {
        if ( isset( $this->dataset[$key] ) &&
             $this->checkValue( $value ) )
        {
            $this->dataValue[$key] = $value;
        }
        else
        {
            throw new ezcGraphNoSuchDataException( $key );
        }
    }

    /**
     * Unset an option.
     * Unsets an option using ArrayAccess.
     * 
     * @param string $key The options to unset.
     * @return void
     *
     * @throws ezcBasePropertyNotFoundException
     *         If a the value for the property options is not an instance of
     * @throws ezcBaseValueException
     *         If a the value for a property is out of range.
     */
    final public function offsetUnset( $key )
    {
        if ( isset( $this->dataset[$value] ) )
        {
            unset( $this->dataValue[$key] );
        }
        else
        {
            throw new ezcGraphNoSuchDataException( $key );
        }
    }
}

?>
