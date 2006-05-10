<?php
/**
 * File containing the abstract ezcGraphDataset class
 *
 * @package Graph
 * @version $id$
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * Basic class to contain the charts data
 *
 * @package Graph
 */
class ezcGraphDataset implements ArrayAccess
{

    protected $label;

    protected $color;

    protected $symbol;

    protected $data;

    public function __construct()
    {
        $this->label = new ezcGraphDatasetStringProperty( $this );
        $this->color = new ezcGraphDatasetColorProperty( $this );
        $this->symbol = new ezcGraphDatasetIntProperty( $this );
    }

    /**
     * setData 
     * 
     * @param array $data 
     * @access public
     * @return void
     */
    public function createFromArray( $data = array() ) 
    {
        foreach ( $data as $key => $value )
        {
            if ( is_numeric( $value ) )
            {
                $this->data[$key] = (float) $value;
            }
        }
    }

    public function __set( $propertyName, $propertyValue )
    {
        switch ( $propertyName )
        {
            case 'label':
                $this->label->default = $propertyValue;
            break;
            case 'color':
                $this->color->default = $propertyValue;
            break;
            case 'symbol':
                $this->symbol->default = $propertyValue;
            break;
        }
    }

    public function __get( $propertyName )
    {
        if ( isset( $this->$propertyName ) ) {
            return $this->$propertyName;
        } else {
            throw new ezcBasePropertyNotFoundException( $propertyName );
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
        return isset( $this->data[$key] );
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
        return $this->data[$key];
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
        $this->data[$key] = (float) $value;
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
        unset( $this->data[$key] );
    }
}

?>
