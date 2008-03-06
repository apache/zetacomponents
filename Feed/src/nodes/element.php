<?php
/**
 * File containing the ezcFeedElement class.
 *
 * @package Feed
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @filesource
 */

/**
 * Container for element data.
 *
 * @package Feed
 * @version //autogentag//
 * @mainclass
 */
class ezcFeedElement
{
    /**
     * Holds the schema for this element.
     *
     * @var array(string=>mixed)
     */
    protected $schema;

    /**
     * Holds the data for this element based on the schema.
     *
     * @var array(string=>mixed)
     */
    protected $data;

    /**
     * Constructs a new ezcFeedElement object.
     *
     * @param array(string=>mixed) $schema The sub-schema that defines this element
     */
    public function __construct( array $schema )
    {
        $this->schema = $schema;
    }

    /**
     * Sets the property $name to $value.
     *
     * @param string $name The property name
     * @param mixed $value The property value
     * @ignore
     */
    public function __set( $name, $value )
    {
        $map = isset( $this->schema['ITEMS_MAP'] ) ? $this->schema['ITEMS_MAP'] : array();
        $name = ezcFeedTools::normalizeName( $name, $map );

        if ( isset( $this->schema['ATTRIBUTES'][$name] ) )
        {
            $this->data[$name] = $value;
        }
        else if ( isset( $this->schema['NODES'][$name] ) )
        {
            $this->data[$name] = new ezcFeedElement( $this->schema['NODES'][$name] );
            $this->data[$name]->set( $value );
        }
    }

    /**
     * Returns the value of property $name.
     *
     * @param string $name The property name
     * @return mixed
     * @ignore
     */
    public function __get( $name )
    {
        $map = isset( $this->schema['ITEMS_MAP'] ) ? $this->schema['ITEMS_MAP'] : array();
        $name = ezcFeedTools::normalizeName( $name, $map );

        return isset( $this->data[$name] ) ? $this->data[$name] : null;
    }

    /**
     * Returns if the property $name is set.
     *
     * @param string $name The property name
     * @return bool
     * @ignore
     */
    public function __isset( $name )
    {
        return isset( $this->data[$name] );
    }

    /**
     * Returns the text stored in the feed element.
     *
     * @return string
     * @ignore
     */
    public function __toString()
    {
        if ( isset( $this->data['#'] ) )
        {
            if ( $this->data['#'] instanceof DateTime )
            {
                return $this->data['#']->format( 'U' ) . '';
            }
            else
            {
                return $this->data['#'] . '';
            }
        }
        else
        {
            return '';
        }
    }

    /**
     * Sets the root value of this element to $value.
     *
     * @param mixed $value The element value
     */
    public function set( $value )
    {
        if ( $this->schema['#'] !== 'none' )
        {
            $this->data['#'] = $value;
        }
    }

    /**
     * Returns the root value of this element as string.
     *
     * @return string
     */
    public function get()
    {
        return isset( $this->data['#'] ) ? '' . $this->data['#'] : null;
    }

    /**
     * Returns the root value of this element as mixed.
     *
     * @return mixed
     */
    public function getValue()
    {
        return isset( $this->data['#'] ) ? $this->data['#'] : null;
    }

    /**
     * Adds a new ezcFeedElement element with name $name to this element and
     * returns it.
     *
     * @throws ezcFeedUnsupportedElementException
     *         if trying to add an element which is not supported.
     *
     * @param string $name The element name
     * @return ezcFeedelement
     */
    public function add( $name )
    {
        $map = isset( $this->schema['ITEMS_MAP'] ) ? $this->schema['ITEMS_MAP'] : array();
        $name = ezcFeedTools::normalizeName( $name, $map );

        if ( isset( $this->schema['NODES'][$name] ) )
        {
            $element = new ezcFeedElement( $this->schema['NODES'][$name] );
            $this->data[$name][] = $element;
            return $element;
        }
        else
        {
            throw new ezcFeedUnsupportedElementException( $name );
        }
    }
}
?>
