<?php
/**
 * File containing the ezcFeedRss class.
 *
 * @package Feed
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @filesource
 */

/**
 * Abstract class providing common functionality for the RSS1 and RSS2
 * processors.
 *
 * Currently implemented for these feed types:
 *  - RSS1 ({@link ezcFeedRss1})
 *  - RSS2 ({@link ezcFeedRss2})
 *
 * @package Feed
 * @version //autogentag//
 */
abstract class ezcFeedRss extends ezcFeedProcessor implements ezcFeedParser
{
    /**
     * Holds the root node of the XML document being generated.
     *
     * @var DOMNode
     */
    protected $root;

    /**
     * Holds the channel element of the XML document being generated.
     *
     * @var DOMElement
     */
    protected $channel;

    /**
     * Holds the image node of the XML document being generated.
     *
     * @var ezcFeedImage
     */
    protected $image;

    /**
     * Holds the item nodes of the XML document being generated.
     *
     * @var array(ezcFeedItem)
     */
    protected $items = array();

    /**
     * Holds meta data for the elements of the XML document being generated.
     *
     * @var array(string=>array(string=>mixed))
     */
    protected $metaData = array();

    /**
     * Creates a root node for the XML document being generated.
     *
     * @param string $version The RSS version for the root node
     */
    public function createRootElement( $version )
    {
        $rss = $this->xml->createElement( 'rss' );
        $rssVersionTag = $this->xml->createAttribute( 'version' );
        $rssVersionContent = $this->xml->createTextNode( $version );
        $rssVersionTag->appendChild( $rssVersionContent );
        $rss->appendChild( $rssVersionTag );
        $this->channel = $channelTag = $this->xml->createElement( 'channel' );
        $rss->appendChild( $channelTag );
        $this->root = $this->xml->appendChild( $rss );
    }

    /**
     * Creates elements in the XML document being generated with name $element
     * and value(s) $value.
     *
     * @param string $element The name of the XML element
     * @param mixed|array(mixed) $value The value(s) for $element
     */
    public function generateMetaData( $element, $value )
    {
        if ( !is_array( $value ) )
        {
            $value = array( $value );
        }
        foreach ( $value as $valueElement )
        {
            $meta = $this->xml->createElement( $element, $valueElement );
            $this->channel->appendChild( $meta );
        }
    }

    /**
     * Sets the namespace attribute in the XML document being generated.
     *
     * @param string $prefix The prefix to use
     * @param string $namespace The namespace to use
     */
    public function generateNamespace( $prefix, $namespace )
    {
        $this->root->setAttributeNS( "http://www.w3.org/2000/xmlns/", "xmlns:$prefix", $namespace );
    }

    /**
     * Creates elements in the node $item of the XML document being generated,
     * with name $element and with value(s) $value.
     *
     * @param DOMNode $item The node where to add $element
     * @param string $element The name of the XML element
     * @param mixed|array(mixed) $value The value(s) for $element
     */
    public function generateItemData( DOMNode $item, $element, $value )
    {
        if ( !is_array( $value ) )
        {
            $value = array( $value );
        }
        foreach ( $value as $valueElement )
        {
            $meta = $this->xml->createElement( $element, $valueElement );
            $item->appendChild( $meta );
        }
    }

    /**
     * Creates elements in the node $item of the XML document being generated,
     * with name $element and with value(s) $value and attributes $attributes.
     *
     * @param DOMNode $item The node where to add $element
     * @param string $element The name of the XML element
     * @param mixed|array(mixed) $value The value(s) for $element
     * @param array(string=>mixed) $attributes The attributes for $element
     */
    public function generateItemDataWithAttributes( DOMNode $item, $element, $value, $attributes )
    {
        if ( !is_array( $value ) )
        {
            $value = array( $value );
        }
        foreach ( $value as $valueElement )
        {
            $meta = $this->xml->createElement( $element, $valueElement );
            foreach ( $attributes as $attrName => $attrValue )
            {
                $attr = $this->xml->createAttribute( $attrName );
                $text = $this->xml->createTextNode( $attrValue );
                $attr->appendChild( $text );
                $meta->appendChild( $attr );
            }
            $item->appendChild( $meta );
        }
    }

    /**
     * Returns the provided $date in timestamp format.
     *
     * @param mixed $date A date
     * @return int
     */
    public function prepareDate( $date )
    {
        if ( is_int( $date ) || is_numeric( $date ) )
        {
            return $date;
        }
        $ts = strtotime( $date );
        if ( $ts !== false )
        {
            return $ts;
        }
        return time();
    }

    /**
     * Returns the name on which $attributeName is mapped in the $mappingArray
     * array, or $attributeName if a mapping does not exist for $attributeName.
     *
     * @param string $attributeName The attribute name
     * @param array(string=>string) $mappingArray A mapping of attribute names to normalized names
     * @return string
     */
    protected function normalizeName( $attributeName, $mappingArray )
    {
        if ( array_key_exists( $attributeName, $mappingArray ) )
        {
            return $mappingArray[$attributeName];
        }
        return $attributeName;
    }

    /**
     * Returns the name on which $attributeName is mapped in the $mappingArray
     * flipped array, or $attributeName if a mapping does not exist for
     * $attributeName.
     *
     * @param string $attributeName The attribute name
     * @param array(string=>string) $mappingArray A mapping of attribute names to normalized names
     * @return string
     */
    protected function deNormalizeName( $attributeName, $mappingArray )
    {
        return $this->normalizeName( $attributeName, array_flip( $mappingArray ) );
    }

    /**
     * Sets the meta data associated with the XML element name $element to $value.
     *
     * @throws ezcFeedOnlyOneValueAllowedException
     *         If $value is an array.
     *
     * @param string $element The XML element name
     * @param mixed $value The new value for $element
     */
    public function setMetaData( $element, $value )
    {
        if ( is_array( $value ) )
        {
            throw new ezcFeedOnlyOneValueAllowedException( $element );
        }
        $this->metaData[$element] = $value;
    }

    /**
     * Adds $value to the array of meta data associated with the XML element
     * name $element. If $value is an array it is assigned directly to the
     * meta data, clearing old values.
     *
     * @param string $element The XML element name
     * @param mixed $value The new value for $element
     */
    public function setMetaArrayData( $element, $value )
    {
        if ( is_array( $value ) )
        {
            $this->metaData[$element] = $value;
        }
        else
        {
            if ( !isset( $this->metaData[$element] ) )
            {
                $this->metaData[$element] = array();
            }
            $this->metaData[$element][] = $value;
        }
    }

    /**
     * Clears the meta data associated with the XML element name $element.
     *
     * @param string $element The XML element name
     */
    public function unsetMetaData( $element )
    {
        unset( $this->metaData[$element] );
    }

    /**
     * Returns the meta data stored in this processor for the XML element name
     * $element.
     *
     * @param string $element The XML element name
     * @return array(string=>mixed)
     */
    public function getMetaData( $element )
    {
        if ( isset( $this->metaData[$element] ) )
        {
            return $this->metaData[$element];
        }
        return null;
    }

    /**
     * Returns the meta data stored in this processor.
     *
     * @return array(string=>array(string=>mixed))
     */
    protected function getAllMetaData()
    {
        return $this->metaData;
    }

    /**
     * Adds a new feed item to this processor.
     *
     * @param ezcFeedItem $item The feed item object to add
     */
    public function addItem( ezcFeedItem $item )
    {
        $this->items[] = $item;
    }

    /**
     * Returns the feed items in this processor.
     *
     * @return array(ezcFeedItem)
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * Adds a new feed image to this processor.
     *
     * @param ezcFeedImage $image The feed image object to add
     */
    public function setImage( ezcFeedImage $image )
    {
        $this->image = $image;
    }

    /**
     * Returns the feed image in this processor.
     *
     * @return ezcFeedImage
     */
    public function getImage()
    {
        return ( isset( $this->image ) ) ? $this->image : null;
    }
}
?>
