<?php
/**
 * File containing the ezcFeedRss1 class.
 *
 * @package Feed
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @filesource
 */

/**
 * Class providing parsing and generating of RSS1 feeds.
 *
 * Specifications:
 * {@link http://www.rssboard.org/rss-specification RSS1 Specifications}
 *
 * @package Feed
 * @version //autogentag//
 */
class ezcFeedRss1 extends ezcFeedProcessor implements ezcFeedParser
{
    /**
     * Defines the feed type of this processor.
     */
    const FEED_TYPE = 'rss1';

    /**
     * Defines the feed content type of this processor.
     */
    const CONTENT_TYPE = 'application/rss+xml';

    /**
     * Holds the definitions for the elements in RSS1.
     *
     * @var array(string=>mixed)
     */
    private static $rss1Schema = array(
        // these are actually part of channel: title, link, description, items, image, textinput
        // the channel also requires the rdf:about attribute
        'title'        => array( '#' => 'string' ),
        'link'         => array( '#' => 'string' ),
        'description'  => array( '#' => 'string' ),
        'items'        => array( '#' => 'none',
                                 'ATTRIBUTES' => array( 'resource' => 'string' ) ),

        'image'        => array( '#'          => 'none',
                                 'ATTRIBUTES' => array( 'about'   => 'string' ),
                              
                                 'NODES'      => array(
                                                   'title'        => array( '#' => 'string' ),
                                                   'url'          => array( '#' => 'string' ),
                                                   'link'         => array( '#' => 'string' ),

                                                   'REQUIRED'     => array( 'title', 'url', 'link' ),
                                                   ), ),

        // outside channel
        'item'         => array( '#'          => 'none',
                                 'ATTRIBUTES' => array( 'about'   => 'string',
                                                        'resource'=> 'string', ),

                                 'NODES'      => array(
                                                   'title'        => array( '#' => 'string' ),
                                                   'link'         => array( '#' => 'string' ),

                                                   'description'  => array( '#' => 'string' ),

                                                   'REQUIRED'     => array( 'title', 'link' ),
                                                   'OPTIONAL'     => array( 'description' ),
                                                   ),

                                 'ITEMS_MAP'  => array( 'id'  => 'about' ),

                                 'MULTI'      => 'items' ),

        'textinput'    => array( '#'          => 'string',
                                 'ATTRIBUTES' => array( 'about'   => 'string' ),
                                 
                                 'NODES'      => array(
                                                   'title'        => array( '#' => 'string' ),
                                                   'description'  => array( '#' => 'string' ),
                                                   'name'         => array( '#' => 'string' ),
                                                   'link'         => array( '#' => 'string' ),

                                                   'REQUIRED'     => array( 'title', 'description', 'name',
                                                                            'link' ),
                                                   ), ),

        // the channel/about attribute is required
        'ATTRIBUTES'   => array( 'about'      => 'string' ),

        'REQUIRED'     => array( 'title', 'link', 'description' ),
        'OPTIONAL'     => array( 'image', 'textinput' ),

        'MULTI'        => array( 'items'      => 'item' ),
        
        'ELEMENTS_MAP' => array( 'textInput'  => 'textinput',
                                 'id'         => 'about' ),

        );

    /**
     * Creates a new RSS1 processor.
     */
    public function __construct()
    {
        $this->feedType = self::FEED_TYPE;
        $this->contentType = self::CONTENT_TYPE;
        $this->schema = new ezcFeedSchema( self::$rss1Schema );
    }

    /**
     * Returns an XML string from the feed information contained in this
     * processor.
     *
     * @return string
     */
    public function generate()
    {
        $this->xml = new DOMDocument( '1.0', 'utf-8' );
        $this->xml->formatOutput = 1;
        $this->createRootElement( '2.0' );

        $this->generateChannel();
        $this->generateFeedModules( $this->channel );
        $this->generateItems();
        $this->generateImage();
        $this->generateTextInput();

        return $this->xml->saveXML();
    }

    /**
     * Returns true if the parser can parse the provided XML document object,
     * false otherwise.
     *
     * @param DOMDocument $xml The XML document object to check for parseability
     * @return bool
     */
    public static function canParse( DOMDocument $xml )
    {
        if ( strpos( $xml->documentElement->tagName, 'RDF' ) === false )
        {
            return false;
        }

        return true;
    }

    /**
     * Parses the provided XML document object and returns an ezcFeed object
     * from it.
     *
     * @throws ezcFeedParseErrorException
     *         If an error was encountered during parsing.
     *
     * @param DOMDocument $xml The XML document object to parse
     * @return ezcFeed
     */
    public function parse( DOMDocument $xml )
    {
        $feed = new ezcFeed( self::FEED_TYPE );
        $rssChildren = $xml->documentElement->childNodes;
        $channel = null;

        $this->usedPrefixes = $this->fetchUsedPrefixes( $xml );

        foreach ( $rssChildren as $rssChild )
        {
            if ( $rssChild->nodeType === XML_ELEMENT_NODE
                 && $rssChild->tagName === 'channel' )
            {
                $channel = $rssChild;
            }
        }

        if ( $channel === null )
        {
            throw new ezcFeedParseErrorException( null, "No channel tag" );
        }

        if ( $channel->hasAttributes() )
        {
            foreach ( $channel->attributes as $attribute )
            {
                $tagName = ezcFeedTools::deNormalizeName( $attribute->name, $this->schema->getElementsMap() );
                $feed->$tagName = $attribute->value;
            }
        }

        foreach ( $channel->childNodes as $channelChild )
        {
            if ( $channelChild->nodeType == XML_ELEMENT_NODE )
            {
                $tagName = $channelChild->tagName;
                $tagName = ezcFeedTools::deNormalizeName( $tagName, $this->schema->getElementsMap() );

                switch ( $tagName )
                {
                    case 'title':
                    case 'link':
                    case 'description':
                        $feed->$tagName = $channelChild->textContent;
                        break;

                    case 'items':
                        $seq = $channelChild->getElementsByTagName( 'Seq' );
                        if ( $seq->length === 0 )
                        {
                            break;
                        }

                        $lis = $seq->item( 0 )->getElementsByTagName( 'li' );

                        foreach ( $lis as $el )
                        {
                            $resource = $el->getAttribute( 'resource' );

                            $item = ezcFeedTools::getNodeByAttribute( $xml->documentElement, 'item', 'rdf:about', $resource );
                            $element = $feed->add( 'item' );
                            $this->parseItem( $feed, $element, $item );
                        }
                        break;

                    case 'image':
                        $resource = $channelChild->getAttribute( 'rdf:resource' );

                        $image = ezcFeedTools::getNodeByAttribute( $xml->documentElement, 'image', 'rdf:about', $resource );
                        $this->parseImage( $feed, $image );
                        break;

                    case 'textInput':
                        $resource = $channelChild->getAttribute( 'rdf:resource' );

                        $textInput = ezcFeedTools::getNodeByAttribute( $xml->documentElement, 'textinput', 'rdf:about', $resource );
                        $this->parseTextInput( $feed, $textInput );
                        break;

                    default:
                        // check if it's part of a known module/namespace
                        $this->parseModules( $feed, $channelChild, $tagName );

                        // continue 2 = ignore modules when getting attributes below
                        continue 2;
                }
            }

            if ( $channelChild->hasAttributes() )
            {
                foreach ( $channelChild->attributes as $attribute )
                {
                    $feed->$tagName->{$attribute->name} = $attribute->value;
                }
            }
        }

        return $feed;
    }

    /**
     * Creates a root node for the XML document being generated.
     *
     * @param string $version The RSS version for the root node
     */
    private function createRootElement( $version )
    {
        $rss = $this->xml->createElementNS( 'http://www.w3.org/1999/02/22-rdf-syntax-ns#', 'rdf:RDF' );
        $this->addAttribute( $rss, 'xmlns', 'http://purl.org/rss/1.0/' );

        $this->channel = $channelTag = $this->xml->createElement( 'channel' );
        $rss->appendChild( $channelTag );
        $this->root = $this->xml->appendChild( $rss );
    }

    /**
     * Adds the required feed elements to the XML document being generated.
     */
    private function generateChannel()
    {
        $data = $this->id;

        if ( is_null( $data ) )
        {
            throw new ezcFeedRequiredMetaDataMissingException( "/{$this->root->nodeName}/@about" );
        }

        $aboutAttr = $this->xml->createAttribute( 'rdf:about' );
        $aboutVal = $this->xml->createTextNode( $data );
        $aboutAttr->appendChild( $aboutVal );
        $this->channel->appendChild( $aboutAttr );

        foreach ( $this->schema->getRequired() as $element )
        {
            $data = $this->schema->isMulti( $element ) ? $this->{$this->schema->getMulti( $element )} : $this->$element;
            if ( is_null( $data ) )
            {
                throw new ezcFeedRequiredMetaDataMissingException( "/{$this->root->nodeName}/{$element}" );
            }

            $attributes = array();
            foreach ( $this->schema->getAttributes( $element ) as $attribute => $type )
            {
                if ( isset( $data->$attribute ) )
                {
                    $attributes[$attribute] = $data->$attribute;
                }
            }
            $this->generateMetaDataWithAttributes( $this->channel, $element, $data, $attributes );
        }

        $items = $this->items;
        if ( count( $items ) === 0 )
        {
            throw new ezcFeedRequiredMetaDataMissingException( "/{$this->root->nodeName}/item" );
        }

        $itemsTag = $this->xml->createElement( 'items' );
        $this->channel->appendChild( $itemsTag );
        $seqTag = $this->xml->createElement( 'rdf:Seq' );
        $itemsTag->appendChild( $seqTag );

        foreach ( $this->items as $item )
        {
            $about = $item->id;
            $liTag = $this->xml->createElement( 'rdf:li' );
            $resourceAttr = $this->xml->createAttribute( 'resource' );
            $resourceVal = $this->xml->createTextNode( $about );
            $resourceAttr->appendChild( $resourceVal );
            $liTag->appendChild( $resourceAttr );
            $seqTag->appendChild( $liTag );
        }

        $image = $this->image;
        if ( $image !== null )
        {
            $imageTag = $this->xml->createElement( 'image' );

            $about = $image->about;
            if ( is_null( $data ) )
            {
                throw new ezcFeedRequiredMetaDataMissingException( "/{$this->root->nodeName}/image/@about" );
            }

            $resourceAttr = $this->xml->createAttribute( 'rdf:resource' );
            $resourceVal = $this->xml->createTextNode( $about );
            $resourceAttr->appendChild( $resourceVal );
            $imageTag->appendChild( $resourceAttr );

            $this->channel->appendChild( $imageTag );
        }

        $textInput = $this->textInput;
        if ( $textInput !== null )
        {
            $textInputTag = $this->xml->createElement( 'textinput' );

            $about = $textInput->about;
            if ( is_null( $data ) )
            {
                throw new ezcFeedRequiredMetaDataMissingException( "/{$this->root->nodeName}/textinput/@about" );
            }

            $resourceAttr = $this->xml->createAttribute( 'rdf:resource' );
            $resourceVal = $this->xml->createTextNode( $about );
            $resourceAttr->appendChild( $resourceVal );
            $textInputTag->appendChild( $resourceAttr );

            $this->channel->appendChild( $textInputTag );
        }
    }

    /**
     * Adds the feed items to the XML document being generated.
     */
    private function generateItems()
    {
        foreach ( $this->items as $element )
        {
            $itemTag = $this->xml->createElement( 'item' );
            $this->root->appendChild( $itemTag );

            $data = $element->id;
            if ( is_null( $data ) )
            {
                throw new ezcFeedRequiredMetaDataMissingException( "/{$this->root->nodeName}/item/@about" );
            }

            $aboutAttr = $this->xml->createAttribute( 'rdf:about' );
            $aboutVal = $this->xml->createTextNode( $data );
            $aboutAttr->appendChild( $aboutVal );
            $itemTag->appendChild( $aboutAttr );

            foreach ( $this->schema->getRequired( 'item' ) as $attribute )
            {
                $data = $element->$attribute;

                if ( is_null( $data ) )
                {
                    throw new ezcFeedRequiredMetaDataMissingException( "/{$this->root->nodeName}/item/{$attribute}" );
                }

                $data = ( $data instanceof ezcFeedElement ) ? $data->__toString() : $data;
                $normalizedAttribute = ezcFeedTools::normalizeName( $attribute, $this->schema->getItemsMap() );

                $attributes = array();
                $this->generateMetaData( $itemTag, $attribute, $data );
            }

            foreach ( $this->schema->getOptional( 'item' ) as $attribute )
            {
                $data = $element->$attribute;
                if ( !is_null( $data ) )
                {
                    $data = ( $data instanceof ezcFeedElement ) ? $data->__toString() : $data;
                    $normalizedAttribute = ezcFeedTools::normalizeName( $attribute, $this->schema->getItemsMap() );

                    $attributes = array();
                    $this->generateMetaData( $itemTag, $attribute, $data );
                }
            }

            $this->generateModules( $element, $itemTag );
        }
    }

    /**
     * Adds the feed image to the XML document being generated.
     */
    private function generateImage()
    {
        $image = $this->image;
        if ( $image !== null )
        {
            $imageTag = $this->xml->createElement( 'image' );
            $this->root->appendChild( $imageTag );

            $data = $image->about;
            if ( is_null( $data ) )
            {
                throw new ezcFeedRequiredMetaDataMissingException( "/{$this->root->nodeName}/image/@about" );
            }

            $aboutAttr = $this->xml->createAttribute( 'rdf:about' );
            $aboutVal = $this->xml->createTextNode( $data );
            $aboutAttr->appendChild( $aboutVal );
            $imageTag->appendChild( $aboutAttr );

            foreach ( $this->schema->getRequired( 'image' ) as $attribute )
            {
                $data = $image->$attribute;
                if ( is_null( $data ) )
                {
                    throw new ezcFeedRequiredMetaDataMissingException( "/{$this->root->nodeName}/image/{$attribute}" );
                }

                $data = ( $data instanceof ezcFeedElement ) ? $data->__toString() : $data;
                $normalizedAttribute = ezcFeedTools::normalizeName( $attribute, $this->schema->getItemsMap() );

                $attributes = array();
                $this->generateMetaData( $imageTag, $attribute, $data );
            }
        }
    }

    /**
     * Adds the feed textinput to the XML document being generated.
     */
    private function generateTextInput()
    {
        $textInput = $this->textInput;
        if ( $textInput !== null )
        {
            $textInputTag = $this->xml->createElement( 'textinput' );
            $this->root->appendChild( $textInputTag );

            $data = $textInput->about;
            if ( is_null( $data ) )
            {
                throw new ezcFeedRequiredMetaDataMissingException( "/{$this->root->nodeName}/textinput/@about" );
            }

            $aboutAttr = $this->xml->createAttribute( 'rdf:about' );
            $aboutVal = $this->xml->createTextNode( $data );
            $aboutAttr->appendChild( $aboutVal );
            $textInputTag->appendChild( $aboutAttr );

            foreach ( $this->schema->getRequired( 'textinput' ) as $attribute )
            {
                $data = $textInput->$attribute;
                if ( is_null( $data ) )
                {
                    throw new ezcFeedRequiredMetaDataMissingException( "/{$this->root->nodeName}/textinput/{$attribute}" );
                }

                $data = ( $data instanceof ezcFeedElement ) ? $data->__toString() : $data;
                $normalizedAttribute = ezcFeedTools::normalizeName( $attribute, $this->schema->getItemsMap() );

                $attributes = array();
                $this->generateMetaData( $textInputTag, $attribute, $data );
            }
        }
    }

    /**
     * Parses the provided XML element object and stores it as a feed item in
     * the provided ezcFeed object.
     *
     * @param ezcFeed $feed The feed object in which to store the parsed XML element as a feed item
     * @param ezcFeedElement $element The feed element object that will contain the feed item
     * @param DOMElement $xml The XML element object to parse
     */
    private function parseItem( ezcFeed $feed, ezcFeedElement $element, DOMElement $xml )
    {
        if ( $xml->hasAttributes() )
        {
            foreach ( $xml->attributes as $attribute )
            {
                $tagName = ezcFeedTools::deNormalizeName( $attribute->name, $this->schema->getItemsMap() );
                $element->$tagName = $attribute->value;
            }
        }

        foreach ( $xml->childNodes as $itemChild )
        {
            if ( $itemChild->nodeType == XML_ELEMENT_NODE )
            {
                $tagName = $itemChild->tagName;
                $tagName = ezcFeedTools::deNormalizeName( $tagName, $this->schema->getItemsMap() );

                switch ( $tagName )
                {
                    case 'title':
                    case 'link':
                    case 'description':
                        $element->$tagName = $itemChild->textContent;
                        break;

                    default:
                        // check if it's part of a known module/namespace
                        $this->parseModules( $element, $itemChild, $tagName );

                        // continue = ignore modules when getting attributes below
                        continue;
                }
            }
        }
    }

    /**
     * Parses the provided XML element object and stores it as a feed image in
     * the provided ezcFeed object.
     *
     * @param ezcFeed $feed The feed object in which to store the parsed XML element as a feed image
     * @param DOMElement $xml The XML element object to parse
     */
    private function parseImage( ezcFeed $feed, DOMElement $xml = null )
    {
        $image = $feed->add( 'image' );
        if ( $xml !== null )
        {
            foreach ( $xml->childNodes as $itemChild )
            {
                if ( $itemChild->nodeType == XML_ELEMENT_NODE )
                {
                    $tagName = $itemChild->tagName;
                    switch ( $tagName )
                    {
                        case 'title':
                        case 'link':
                        case 'url':
                            $image->$tagName = $itemChild->textContent;
                            break;
                    }
                }
            }

            if ( $xml->hasAttributes() )
            {
                foreach ( $xml->attributes as $attribute )
                {
                    $image->{$attribute->name} = $attribute->value;
                }
            }
        }
    }

    /**
     * Parses the provided XML element object and stores it as a feed textinput in
     * the provided ezcFeed object.
     *
     * @param ezcFeed $feed The feed object in which to store the parsed XML element as a feed textinput
     * @param DOMElement $xml The XML element object to parse
     */
    private function parseTextInput( ezcFeed $feed, DOMElement $xml = null )
    {
        $textInput = $feed->add( 'textInput' );
        if ( $xml !== null )
        {
            foreach ( $xml->childNodes as $itemChild )
            {
                if ( $itemChild->nodeType == XML_ELEMENT_NODE )
                {
                    $tagName = $itemChild->tagName;
                    switch ( $tagName )
                    {
                        case 'title':
                        case 'description':
                        case 'name':
                        case 'link':
                            $textInput->$tagName = $itemChild->textContent;
                            break;
                    }
                }
            }

            if ( $xml->hasAttributes() )
            {
                foreach ( $xml->attributes as $attribute )
                {
                    $textInput->{$attribute->name} = $attribute->value;
                }
            }
        }
    }
}
?>
