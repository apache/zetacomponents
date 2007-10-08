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
 * @package Feed
 * @version //autogentag//
 */
abstract class ezcFeedRss extends ezcFeedProcessor implements ezcFeedParser
{
    protected $root;
    protected $channel;
    protected $items = array();
    private $metaData = array();

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

    public function generateNamespace( $prefix, $namespace )
    {
        $this->root->setAttributeNS( "http://www.w3.org/2000/xmlns/", "xmlns:$prefix", $namespace );
    }

    public function generateItemData( $item, $element, $value )
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

    public function generateItemDataWithAttributes( $item, $element, $value, $attributes )
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

    public function generateImage( $item, $title, $link, $imageUrl )
    {
        $image = $this->xml->createElement( 'image' );
        $title = $this->xml->createElement( 'title', $title );
        $link = $this->xml->createElement( 'link', $link );
        $url = $this->xml->createElement( 'url', $imageUrl );
        $image->appendChild( $title );
        $image->appendChild( $link );
        $image->appendChild( $url );
        $item->appendChild( $image );
    }

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

    public function addItem( $item )
    {
        $this->items[] = $item;
    }
    
    protected function normalizeName( $attributeName, $mappingArray )
    {
        if ( array_key_exists( $attributeName, $mappingArray ) )
        {
            return $mappingArray[$attributeName];
        }
        return $attributeName;
    }

    protected function deNormalizeName( $attributeName, $mappingArray )
    {
        return $this->normalizeName( $attributeName, array_flip( $mappingArray ) );
    }

    public function getItems()
    {
        return $this->items;
    }

    public function setMetaData( $element, $value )
    {
        if ( is_array( $value ) )
        {
            throw new ezcFeedOnlyOneValueAllowedException( $element );
        }
        $this->metaData[$element] = $value;
    }

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

    public function unsetMetaData( $element )
    {
        unset( $this->metaData[$element] );
    }

    public function getMetaData( $element )
    {
        if ( isset( $this->metaData[$element] ) )
        {
            return $this->metaData[$element];
        }
        return NULL;
    }

    protected function getAllMetaData()
    {
        return $this->metaData;
    }
}
?>
