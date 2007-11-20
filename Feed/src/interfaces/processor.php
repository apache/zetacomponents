<?php
/**
 * File containing the ezcFeedProcessor class.
 *
 * @package Feed
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @filesource
 */

/**
 * Base class for all feed processors.
 *
 * Currently implemented for these feed types:
 *  - RSS1 ({@link ezcFeedRss1})
 *  - RSS2 ({@link ezcFeedRss2})
 *  - ATOM ({@link ezcFeedAtom})
 *
 * @package Feed
 * @version //autogentag//
 */
abstract class ezcFeedProcessor
{
    /**
     * Holds the feed type (eg. 'rss1').
     *
     * @var string
     * @ignore
     */
    protected $feedType;

    /**
     * Holds the feed schema for the current feed type.
     *
     * @var array(string=>mixed)
     * @ignore
     */
    protected $schema;

    /**
     * Holds the XML document which is being generated.
     *
     * @var DOMDocument
     * @ignore
     */
    protected $xml;

    /**
     * Holds the root node of the XML document being generated.
     *
     * @var DOMNode
     * @ignore
     */
    protected $root;

    /**
     * Holds the channel element of the XML document being generated.
     *
     * @var DOMElement
     * @ignore
     */
    protected $channel;

    /**
     * Holds the feed elements (ezcFeedElement).
     *
     * @var array(string=>mixed)
     * @ignore
     */
    protected $elements;

    /**
     * Holds the prefixes used in the feed generation process.
     *
     * @var array(string)
     * @ignore
     */
    protected $usedPrefixes = array();

    /**
     * Returns an XML string from the feed information contained in this
     * processor.
     *
     * @return string
     */
    abstract public function generate();

    /**
     * Creates a node in the XML document being generated with name $element
     * and value(s) $value.
     *
     * @param DOMNode $root The root in which to create the node $element
     * @param string $element The name of the XML element
     * @param mixed|array(mixed) $value The value(s) for $element
     */
    public function generateMetaData( DOMNode $root, $element, $value )
    {
        if ( !is_array( $value ) )
        {
            $value = array( $value );
        }
        foreach ( $value as $valueElement )
        {
            $meta = $this->xml->createElement( $element, $valueElement );
            $root->appendChild( $meta );
        }
    }

    /**
     * Creates elements in the XML document being generated with name $element
     * and value(s) $value.
     *
     * @param DOMNode $root The root in which to create the node $element
     * @param string $element The name of the XML element
     * @param mixed|array(mixed) $value The value(s) for $element
     * @param array(string=>mixed) $attributes The attributes to add to the node
     */
    public function generateMetaDataWithAttributes( DOMNode $root, $element, $value = false, array $attributes )
    {
        if ( !is_array( $value ) )
        {
            $value = array( $value );
        }
        foreach ( $value as $valueElement )
        {
            if ( $valueElement === false )
            {
                $meta = $this->xml->createElement( $element );
            }
            else
            {
                $meta = $this->xml->createElement( $element, $valueElement );
            }
            foreach ( $attributes as $attrName => $attrValue )
            {
                $attr = $this->xml->createAttribute( $attrName );
                $text = $this->xml->createTextNode( $attrValue );
                $attr->appendChild( $text );
                $meta->appendChild( $attr );
            }
            $root->appendChild( $meta );
        }
    }

    /**
     * Adds an attribute to the XML node $node.
     *
     * @param DOMNode $node The node to add the attribute to
     * @param string $attribute The name of the attribute to add
     * @param mixed $value The value of the attribute
     */
    public function addAttribute( DOMNode $node, $attribute, $value )
    {
        $attr = $this->xml->createAttribute( $attribute );
        $val = $this->xml->createTextNode( $value );
        $attr->appendChild( $val );
        $node->appendChild( $attr );
    }

    /**
     * Sets the value of element $name to $value based on the feed schema.
     *
     * @param string $name The element name
     * @param mixed $value The new value for the element $name
     */
    public function set( $name, $value )
    {
        $name = ezcFeedTools::normalizeName( $name, $this->schema->getElementsMap() );
        if ( !isset( $this->elements[$name] ) )
        {
            if ( $this->schema->isMulti( $name ) )
            {
                $this->elements[$this->schema->getMulti( $name )] = array();
            }
            else if ( $this->schema->isAttribute( $name ) )
            {
                $this->elements[$name] = $value;
                return;
            }
            else
            {
                $this->elements[$name] = new ezcFeedElement( $this->schema->getSchema( $name ) );
            }
        }
        if ( $this->schema->isMulti( $name ) )
        {
            $this->elements[$this->schema->getMulti( $name )][0]->set( $value );
        }
        else
        {
            $this->elements[$name]->set( $value );
        }
    }

    /**
     * Returns the value of element $name based on the feed schema.
     *
     * @param string $name The element name
     * @return mixed
     */
    public function get( $name )
    {
        $name = ezcFeedTools::normalizeName( $name, $this->schema->getElementsMap() );
        if ( isset( $this->elements[$name] ) )
        {
            return $this->elements[$name];
        }

        if ( $this->schema->isMulti( $name ) )
        {
            return isset( $this->elements[$this->schema->getMulti( $name )][0] ) ? $this->elements[$this->schema->getMulti( $name )][0] : null;
        }

        return null;
    }

    /**
     * Adds a new ezcFeedElement element with name $name and returns it, if the
     * feed schema allows this (returns null if the schema does not allow it).
     *
     * @param string $name The element name
     * @return ezcFeedelement|null
     */
    public function add( $name )
    {
        $className = ( $name === 'item' ) ? 'ezcFeedItem' : 'ezcFeedElement';
        $name = ezcFeedTools::normalizeName( $name, $this->schema->getElementsMap() );

        if ( $this->schema->isMulti( $name ) )
        {
            $element = new $className( $this->schema->getSchema( $name ) );
            $this->elements[$this->schema->getMulti( $name )][] = $element;
            return $element;
        }
        else
        {
            $element = new $className( $this->schema->getSchema( $name ) );
            $this->elements[$name] = $element;
            return $element;
        }
    }
}
?>
