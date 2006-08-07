<?php
/**
 * File containing the abstract ezcGraphDataSet class
 *
 * @package Graph
 * @version //autogentag//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * Basic class to contain the charts data
 *
 * @package Graph
 */
class ezcGraphDataSet implements ArrayAccess, Iterator
{

    /**
     * labels for dataset and dataset elements
     * 
     * @var ezcGraphDataSetStringProperty
     */
    protected $label;

    /**
     * Colors for dataset elements
     * 
     * @var ezcGraphDataSetColorProperty
     */
    protected $color;

    /**
     * Symbols for dataset elements
     * 
     * @var ezcGraphDataSetIntProperty
     */
    protected $symbol;

    /**
     * Status if dataset element is hilighted
     * 
     * @var ezcGraphDataSetBooleanProperty
     * @access protected
     */
    protected $highlight;

    /**
     * Array which contains the data of the dataset
     * 
     * @var array
     */
    protected $data;

    /**
     * Current dataset element
     * needed for iteration over dataset with ArrayAccess
     * 
     * @var mixed
     */
    protected $current;

    /**
     * Color palette used for dataset colorization
     * 
     * @var ezcGraphPalette
     */
    protected $pallet;

    public function __construct()
    {
        $this->label = new ezcGraphDataSetStringProperty( $this );
        $this->color = new ezcGraphDataSetColorProperty( $this );
        $this->symbol = new ezcGraphDataSetIntProperty( $this );
        $this->highlight = new ezcGraphDataSetBooleanProperty( $this );

        $this->highlight->default = false;
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
            case 'highlight':
            case 'hilight':
                $this->highlight->default = $propertyValue;
                break;
            case 'palette':
                $this->palette = $propertyValue;
                $this->color->default = $this->palette->dataSetColor;
                $this->symbol->default = $this->palette->dataSetSymbol;
                break;
        }
    }

    public function __get( $propertyName )
    {
        if ( isset( $this->$propertyName ) ) {
            return $this->$propertyName;
        }
        else 
        {
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

    final public function current()
    {
        $keys = array_keys( $this->data );
        if ( !isset( $this->current ) )
        {
            $this->current = 0;
        }

        return $this->data[$keys[$this->current]];
    }

    final public function next()
    {
        $keys = array_keys( $this->data );
        if ( ++$this->current >= count( $keys ) )
        {
            return false;
        }
        else 
        {
            return $this->data[$keys[$this->current]];
        }
    }

    final public function key()
    {
        $keys = array_keys( $this->data );
        return $keys[$this->current];
    }

    final public function valid()
    {
        $keys = array_keys( $this->data );
        return isset( $keys[$this->current] );
    }

    final public function rewind()
    {
        $this->current = 0;
    }
}

?>
