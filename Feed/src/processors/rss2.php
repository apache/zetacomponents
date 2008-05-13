<?php
/**
 * File containing the ezcFeedRss2 class.
 *
 * @package Feed
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @filesource
 */

/**
 * Class providing parsing and generating of RSS2 feeds.
 *
 * Specifications:
 * {@link http://www.rssboard.org/rss-specification RSS2 Specifications}.
 *
 * @package Feed
 * @version //autogentag//
 */
class ezcFeedRss2 extends ezcFeedProcessor implements ezcFeedParser
{
    /**
     * Defines the feed type of this processor.
     */
    const FEED_TYPE = 'rss2';

    /**
     * Defines the feed content type of this processor.
     */
    const CONTENT_TYPE = 'application/rss+xml';

    /**
     * Holds the RSS2 feed schema.
     *
     * @var array(string=>mixed)
     */
    private static $rss2Schema = array(
        'title'          => array( '#'          => 'string' ),

        'link'           => array( '#'          => 'string',
                                   'MULTI'      => 'links' ),

        'description'    => array( '#'          => 'string' ),

        'language'       => array( '#'          => 'string' ),
        'copyright'      => array( '#'          => 'string' ),
        'managingEditor' => array( '#'          => 'string' ),
        'webMaster'      => array( '#'          => 'string' ),
        'pubDate'        => array( '#'          => 'string' ),
        'lastBuildDate'  => array( '#'          => 'string' ),
        'category'       => array( '#'          => 'string',
                                   'ATTRIBUTES' => array( 'domain' => 'string' ),
                                   'MULTI'      => 'categories' ),

        'generator'      => array( '#'          => 'string' ),
        'docs'           => array( '#'          => 'string' ),
        'ttl'            => array( '#'          => 'string' ),
        'image'          => array( '#'          => 'string',
                                   'NODES'      => array(
                                                     'url'         => array( '#' => 'string' ),
                                                     'title'       => array( '#' => 'string' ),
                                                     'link'        => array( '#' => 'string' ),

                                                     'description' => array( '#' => 'string' ),
                                                     'width'       => array( '#' => 'string' ),
                                                     'height'      => array( '#' => 'string' ),

                                                     'REQUIRED'    => array( 'url', 'title', 'link' ),
                                                     'OPTIONAL'    => array( 'description', 'width', 'height' ),
                                                     ), ),

        'rating'         => array( '#'          => 'string' ),
        'cloud'          => array( '#'          => 'none',
                                   'ATTRIBUTES' => array( 'domain' => 'string',
                                                          'port' => 'string',
                                                          'path' => 'string',
                                                          'registerProcedure' => 'string',
                                                          'protocol' => 'string' ), ),

        'textInput'      => array( '#'          => 'none',
                                   'NODES'      => array(
                                                     'title'       => array( '#' => 'string' ),
                                                     'description' => array( '#' => 'string' ),
                                                     'name'        => array( '#' => 'string' ),
                                                     'link'        => array( '#' => 'string' ),

                                                     'REQUIRED'    => array( 'title', 'description', 'name', 'link' ),
                                                     ), ),

        'skipHours'      => array( '#'          => 'none',
                                   'NODES'      => array(
                                                     'hour'        => array( '#' => 'string',
                                                                             'MULTI' => 'hours' ),

                                                     'OPTIONAL'    => array( 'hour' ),
                                                     ), ),

        'skipDays'       => array( '#'          => 'none',
                                   'NODES'      => array(
                                                     'day'         => array( '#' => 'string',
                                                                             'MULTI' => 'days' ),

                                                     'OPTIONAL'    => array( 'day' ),
                                                     ), ),

        'item'           => array( '#'          => 'none',
                                   'NODES'      => array(
                                                     'title'        => array( '#' => 'string' ),
                                                     'link'         => array( '#' => 'string' ),
                                                     'description'  => array( '#' => 'string' ),

                                                     'author'       => array( '#' => 'string' ),
                                                     'category'     => array( '#' => 'string',
                                                                              'ATTRIBUTES' => array( 'domain' => 'string' ),
                                                                              'MULTI' => 'categories' ),

                                                     'comments'     => array( '#' => 'string' ),
                                                     'enclosure'    => array( '#' => 'none',
                                                                              'ATTRIBUTES' => array( 'url'    => 'string',
                                                                                                     'length' => 'string',
                                                                                                     'type'   => 'string' ),
                                                                              //'MULTI' => 'enclosures'
                                                                              ),

                                                     'guid'         => array( '#' => 'string',
                                                                              'ATTRIBUTES' => array( 'isPermaLink' => 'string' ) ),

                                                     'pubDate'      => array( '#' => 'string' ),
                                                     'source'       => array( '#' => 'string',
                                                                              'ATTRIBUTES' => array( 'url' => 'string' ) ),

                                                     'AT_LEAST_ONE' => array( 'title', 'description' ),
                                                     'OPTIONAL'     => array( 'title', 'link', 'description',
                                                                              'author', 'category', 'comments',
                                                                              'enclosure', 'guid', 'pubDate',
                                                                              'source' ),
                                                     ),
                                   'ITEMS_MAP'      => array( 'published'  => 'pubDate',
                                                              'id'         => 'guid' ),
                                   'MULTI'      => 'items' ),

        'REQUIRED'       => array( 'title', 'link', 'description' ),
        'OPTIONAL'       => array( 'language', 'copyright', 'managingEditor',
                                   'webMaster', 'pubDate', 'lastBuildDate',
                                   'category', 'generator', 'docs',
                                   'ttl', 'image', 'rating',
                                   'textInput', 'skipHours', 'skipDays',
                                   'cloud',
                                 ), // don't include 'item' here

        'MULTI'          => array( 'links'      => 'link',
                                   'categories' => 'category',
                                   'items'      => 'item' ),

        'ELEMENTS_MAP'   => array( 'author'     => 'managingEditor',
                                   'published'  => 'pubDate',
                                   'updated'    => 'lastBuildDate' ),

        );

    /**
     * Creates a new RSS2 processor.
     */
    public function __construct()
    {
        $this->feedType = self::FEED_TYPE;
        $this->contentType = self::CONTENT_TYPE;
        $this->schema = new ezcFeedSchema( self::$rss2Schema );

        // set default values
        $this->published = ezcFeedTools::prepareDate( time() );
        $version = ( ezcFeed::GENERATOR_VERSION === '//auto' . 'gentag//' ) ? 'dev' : ezcFeed::GENERATOR_VERSION;
        $this->generator = "eZ Components Feed {$version} (" . ezcFeed::GENERATOR_URI . ")";
        $this->docs = 'http://www.rssboard.org/rss-specification';
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

        $this->generateRequired();
        $this->generateOptional();
        $this->generateFeedModules( $this->channel );
        $this->generateItems();

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
        if ( $xml->documentElement->tagName !== 'rss' )
        {
            return false;
        }
        if ( !$xml->documentElement->hasAttribute( 'version' ) )
        {
            return false;
        }
        if ( !in_array( $xml->documentElement->getAttribute( 'version' ), array( '0.91', '0.92', '0.93', '0.94', '2.0' ) ) )
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

        foreach ( $channel->childNodes as $channelChild )
        {
            if ( $channelChild->nodeType == XML_ELEMENT_NODE )
            {
                $tagName = $channelChild->tagName;
                $tagName = ezcFeedTools::deNormalizeName( $tagName, $this->schema->getElementsMap() );

                switch ( $tagName )
                {
                    case 'title':
                    case 'description':
                    case 'language':
                    case 'copyright':
                    case 'author':
                    case 'webMaster':
                    case 'generator':
                    case 'ttl':
                    case 'docs':
                    case 'rating':
                        $feed->$tagName = $channelChild->textContent;
                        break;

                    case 'link':
                    case 'category':
                        $element = $feed->add( $tagName );
                        $element->set( $channelChild->textContent );
                        break;

                    case 'cloud':
                        $element = $feed->add( $tagName );
                        break;

                    case 'published':
                    case 'updated':
                        $feed->$tagName = ezcFeedTools::prepareDate( $channelChild->textContent );
                        break;

                    case 'item':
                        $element = $feed->add( $tagName );
                        $this->parseItem( $feed, $element, $channelChild );
                        break;

                    case 'image':
                        $image = $feed->add( 'image' );
                        $this->parseImage( $feed, $image, $channelChild );
                        break;

                    case 'skipHours':
                        $element = $feed->add( $tagName );
                        $this->parseSkipHours( $feed, $element, $channelChild );
                        break;

                    case 'skipDays':
                        $element = $feed->add( $tagName );
                        $this->parseSkipDays( $feed, $element, $channelChild );
                        break;

                    case 'textInput':
                        $element = $feed->add( $tagName );
                        $this->parseTextInput( $feed, $element, $channelChild );
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
                    if ( in_array( $tagName, array( 'category', 'cloud' ) ) )
                    {
                        $element->{$attribute->name} = $attribute->value;
                    }
                    else
                    {
                        $feed->$tagName->{$attribute->name} = $attribute->value;
                    }
                }
            }
        }
        return $feed;
    }

    /**
     * Creates a root node for the XML document being generated.
     *
     * @param string $version The RSS version for the root node (eg. '2.0')
     */
    private function createRootElement( $version )
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
     * Adds the required feed elements to the XML document being generated.
     */
    private function generateRequired()
    {
        foreach ( $this->schema->getRequired() as $element )
        {
            $data = $this->schema->isMulti( $element ) ? $this->{$this->schema->getMulti( $element )} : $this->$element;
            if ( is_null( $data ) )
            {
                throw new ezcFeedRequiredMetaDataMissingException( "/{$this->root->nodeName}/{$element}" );
            }

            if ( !is_array( $data ) )
            {
                $data = array( $data );
            }

            foreach ( $data as $dataNode )
            {
                $this->generateNode( $this->channel, $element, $dataNode );
            }
        }
    }

    /**
     * Adds the optional feed elements to the XML document being generated.
     */
    private function generateOptional()
    {
        foreach ( $this->schema->getOptional() as $element )
        {
            $normalizedAttribute = ezcFeedTools::normalizeName( $element, $this->schema->getElementsMap() );
            $data = $this->schema->isMulti( $element ) ? $this->{$this->schema->getMulti( $element )} : $this->$element;

            if ( !is_null( $data ) )
            {
                switch ( $element )
                {
                    case 'pubDate':
                    case 'lastBuildDate':
                        $this->generateMetaData( $this->channel, $element, ezcFeedTools::prepareDate( $data->getValue() )->format( 'D, d M Y H:i:s O' ) );
                        break;

                    case 'image':
                        $this->generateImage( $this->image );
                        break;

                    case 'skipHours':
                        $this->generateSkipHours( $this->skipHours );
                        break;

                    case 'skipDays':
                        $this->generateSkipDays( $this->skipDays );
                        break;

                    case 'textInput':
                        $this->generateTextInput( $this->textInput );
                        break;

                    case 'cloud':
                        $this->generateCloud( $this->cloud );
                        break;

                    default:
                        if ( !is_array( $data ) )
                        {
                            $data = array( $data );
                        }

                        foreach ( $data as $dataNode )
                        {
                            $this->generateNode( $this->channel, $element, $dataNode );
                        }
                        break;
                }
            }
        }
    }

    /**
     * Creates an XML node in the XML document being generated.
     *
     * @param DOMNode $root The root in which to create the node $element
     * @param string $element The name of the node to create
     * @param array(string=>mixed) $dataNode The data for the node to create
     */
    private function generateNode( DOMNode $root, $element, $dataNode )
    {
        $attributes = array();
        foreach ( $this->schema->getAttributes( $element ) as $attribute => $type )
        {
            if ( isset( $dataNode->$attribute ) )
            {
                $attributes[$attribute] = $dataNode->$attribute;
            }
        }

        if ( count( $attributes ) >= 1 )
        {
            $this->generateMetaDataWithAttributes( $root, $element, $dataNode, $attributes );
        }
        else
        {
            $this->generateMetaData( $root, $element, $dataNode );
        }
    }

    /**
     * Adds an image node to the XML document being generated.
     *
     * @param ezcFeedElement $feedElement The image feed element
     */
    private function generateImage( ezcFeedElement $feedElement )
    {
        $image = $this->xml->createElement( 'image' );
        $this->channel->appendChild( $image );

        foreach ( $this->schema->getRequired( 'image' ) as $element )
        {
            $data = $this->schema->isMulti( 'image', $element ) ? $this->{$this->schema->getMulti( 'image', $element )} : $feedElement->$element;
            if ( is_null( $data ) )
            {
                throw new ezcFeedRequiredMetaDataMissingException( "/{$this->root->nodeName}/image/{$element}" );
            }

            $this->generateMetaData( $image, $element, $data );
        }

        foreach ( $this->schema->getOptional( 'image' ) as $element )
        {
            $data = $this->schema->isMulti( 'image', $element ) ? $this->{$this->schema->getMulti( 'image', $element )} : $feedElement->$element;
            if ( !is_null( $data ) )
            {
                $this->generateMetaData( $image, $element, $data );
            }
        }
    }

    /**
     * Adds a skipHours node to the XML document being generated.
     *
     * @param ezcFeedElement $feedElement The skipHours feed element
     */
    private function generateSkipHours( ezcFeedElement $feedElement )
    {
        $tag = $this->xml->createElement( 'skipHours' );
        $this->channel->appendChild( $tag );

        foreach ( $this->schema->getOptional( 'skipHours' ) as $element )
        {
            $data = $feedElement->$element;
            if ( !is_null( $data ) )
            {
                foreach ( $data as $dataNode )
                {
                    $this->generateMetaData( $tag, $element, $dataNode->__toString() );
                }
            }
        }
    }

    /**
     * Adds a skipDays node to the XML document being generated.
     *
     * @param ezcFeedElement $feedElement The skipDays feed element
     */
    private function generateSkipDays( ezcFeedElement $feedElement )
    {
        $tag = $this->xml->createElement( 'skipDays' );
        $this->channel->appendChild( $tag );

        foreach ( $this->schema->getOptional( 'skipDays' ) as $element )
        {
            $data = $feedElement->$element;
            if ( !is_null( $data ) )
            {
                foreach ( $data as $dataNode )
                {
                    $this->generateMetaData( $tag, $element, $dataNode->__toString() );
                }
            }
        }
    }

    /**
     * Adds an textInput node to the XML document being generated.
     *
     * @param ezcFeedElement $feedElement The textInput feed element
     */
    private function generateTextInput( ezcFeedElement $feedElement )
    {
        $image = $this->xml->createElement( 'textInput' );
        $this->channel->appendChild( $image );

        foreach ( $this->schema->getRequired( 'textInput' ) as $element )
        {
            $data = $data = $this->schema->isMulti( 'textInput', $element ) ? $this->{$this->schema->getMulti( 'textInput', $element )} : $feedElement->$element;
            if ( is_null( $data ) )
            {
                throw new ezcFeedRequiredMetaDataMissingException( "/{$this->root->nodeName}/textInput/{$element}" );
            }

            $this->generateMetaData( $image, $element, $data );
        }
    }

    /**
     * Adds a cloud node to the XML document being generated.
     *
     * @param ezcFeedElement $feedElement The cloud feed element
     */
    private function generateCloud( ezcFeedElement $feedElement )
    {
        $cloud = $this->xml->createElement( 'cloud' );
        $this->channel->appendChild( $cloud );

        $attributes = array();
        foreach ( $this->schema->getAttributes( 'cloud' ) as $element => $value )
        {
            $data = $feedElement->$element;
            if ( is_null( $data ) )
            {
                throw new ezcFeedRequiredMetaDataMissingException( "/{$this->root->nodeName}/cloud/{$element}" );
            }
            $attributes[$element] = $data;
        }

        $this->generateMetaDataWithAttributes( $cloud, $element, false, $attributes );
    }

    /**
     * Adds the feed items to the XML document being generated.
     */
    private function generateItems()
    {
        $items = $this->items;
        if ( $items === null )
        {
            return;
        }

        foreach ( $this->items as $item )
        {
            $itemTag = $this->xml->createElement( 'item' );
            $this->channel->appendChild( $itemTag );

            $atLeastOneRequiredFeedItemPresent = false;
            foreach ( $this->schema->getAtLeastOne( 'item' ) as $attribute )
            {
                $data = $this->schema->isMulti( 'item', $attribute ) ? $this->{$this->schema->getMulti( 'item', $attribute )} : $item->$attribute;
                if ( !is_null( $data ) )
                {
                    $atLeastOneRequiredFeedItemPresent = true;
                    break;
                }
            }

            if ( $atLeastOneRequiredFeedItemPresent === false )
            {
                $requiredElements = $this->schema->getAtLeastOne( 'item' );
                for ( $i = 0; $i < count( $requiredElements ); $i++ )
                {
                    $requiredElements[$i] = "/{$this->root->nodeName}/item/{$requiredElements[$i]}";
                }
                throw new ezcFeedAtLeastOneItemDataRequiredException( $requiredElements );
            }

            foreach ( $this->schema->getOptional( 'item' ) as $attribute )
            {
                $normalizedAttribute = ezcFeedTools::normalizeName( $attribute, $this->schema->getItemsMap() );

                $metaData = $item->$attribute;

                if ( !is_null( $metaData ) )
                {
                    switch ( $attribute )
                    {
                        case 'guid':
                            $attributes = array();
                            if ( isset( $metaData[0]->isPermaLink ) )
                            {
                                $permaLink = ( $metaData[0]->isPermaLink === true ) ? 'true' : 'false';
                                $attributes = array( 'isPermaLink' => $permaLink );
                            }
                            // @todo Investigate if needed to set isPermaLink dependent of the guid
                            // $permaLink = substr( $metaData[0]->__toString(), 0, 7 ) === 'http://' ? "true" : "false";

                            $this->generateMetaDataWithAttributes( $itemTag, $normalizedAttribute, $metaData, $attributes );
                            break;

                        case 'category':
                            foreach ( $metaData as $dataNode )
                            {
                                $attributes = array();
                                foreach ( $this->schema->getAttributes( 'item', $attribute ) as $key => $type )
                                {
                                    if ( isset( $dataNode->$key ) )
                                    {
                                        $attributes[$key] = $dataNode->$key;
                                    }
                                }

                                if ( count( $attributes ) >= 1 )
                                {
                                    $this->generateMetaDataWithAttributes( $itemTag, $normalizedAttribute, $dataNode, $attributes );
                                }
                                else
                                {
                                    $this->generateMetaData( $itemTag, $normalizedAttribute, $dataNode );
                                }
                            }
                            break;

                        case 'pubDate':
                            $this->generateMetaData( $itemTag, $normalizedAttribute, ezcFeedTools::prepareDate( $metaData->getValue() )->format( 'D, d M Y H:i:s O' ) );
                            break;

                        case 'enclosure':
                            foreach ( $metaData as $dataNode )
                            {
                                $attributes = array();
                                foreach ( $this->schema->getAttributes( 'item', $attribute ) as $key => $type )
                                {
                                    if ( isset( $dataNode->$key ) )
                                    {
                                        $attributes[$key] = $dataNode->$key;
                                    }
                                }

                                if ( count( $attributes ) >= 1 )
                                {
                                    $this->generateMetaDataWithAttributes( $itemTag, $normalizedAttribute, false, $attributes );
                                }
                                else
                                {
                                    // @todo Raise exception
                                }
                            }

                            break;

                        case 'source':
                            if ( is_array( $metaData ) )
                            {
                                $metaData = $metaData[0];
                            }

                            if ( !isset( $metaData->url ) )
                            {
                                throw new ezcFeedRequiredMetaDataMissingException( '/rss/item/source/url' );
                            }
                            $attributes = array( 'url' => $metaData->url );
                            $this->generateMetaDataWithAttributes( $itemTag, $normalizedAttribute, $metaData, $attributes );
                            break;

                        default:
                            $this->generateMetaData( $itemTag, $normalizedAttribute, $metaData );
                    }
                }
            }

            $this->generateModules( $item, $itemTag );
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
        foreach ( $xml->childNodes as $itemChild )
        {
            if ( $itemChild->nodeType === XML_ELEMENT_NODE )
            {
                $tagName = $itemChild->tagName;
                $tagName = ezcFeedTools::deNormalizeName( $tagName, $this->schema->getItemsMap() );

                switch ( $tagName )
                {
                    case 'title':
                    case 'link':
                    case 'description':
                    case 'author':
                    case 'comments':
                    case 'source':
                        $element->$tagName = $itemChild->textContent;
                        break;

                    case 'published':
                        $element->$tagName = ezcFeedTools::prepareDate( $itemChild->textContent );
                        break;

                    case 'category':
                    case 'enclosure':
                        $subElement = $element->add( $tagName );
                        $subElement->set( $itemChild->textContent );
                        break;

                    case 'id':
                        $subElement = $element->add( $tagName );
                        $subElement->set( $itemChild->textContent );
                        break;

                    default:
                        // check if it's part of a known module/namespace
                        $this->parseModules( $element, $itemChild, $tagName );

                        // continue 2 = ignore modules when getting attributes below
                        continue 2;
                }

                if ( $itemChild->hasAttributes() )
                {
                    foreach ( $itemChild->attributes as $attribute )
                    {
                        if ( in_array( $tagName, array( 'category', 'enclosure' ) ) )
                        {
                            $subElement->{$attribute->name} = $attribute->value;
                        }
                        else if ( in_array( $tagName, array( 'id' ) ) )
                        {
                            if ( $attribute->name === 'isPermaLink'
                                 && $attribute->value !== null )
                            {
                                $subElement->isPermaLink = ( $attribute->value === "true" ) ? true : false;
                            }
                        }
                        else
                        {
                            $element->$tagName->{$attribute->name} = $attribute->value;
                        }
                    }
                }
            }
        }
    }

    /**
     * Parses the provided XML element object and stores it as a feed image in
     * the provided ezcFeed object.
     *
     * @param ezcFeed $feed The feed object in which to store the parsed XML element as a feed image
     * @param ezcFeedElement $element The feed element object that will contain the feed image
     * @param DOMElement $xml The XML element object to parse
     */
    private function parseImage( ezcFeed $feed, ezcFeedElement $element, DOMElement $xml )
    {
        foreach ( $xml->childNodes as $itemChild )
        {
            if ( $itemChild->nodeType === XML_ELEMENT_NODE )
            {
                $tagName = $itemChild->tagName;

                switch ( $tagName )
                {
                    case 'title': // required in RSS2
                    case 'link': // required in RSS2
                    case 'url': // required in RSS2

                    case 'description':
                    case 'width':
                    case 'height':
                        $element->$tagName = $itemChild->textContent;
                        break;
                }
            }
        }
    }

    /**
     * Parses the provided XML element object and stores it as a feed element
     * of type skipHours in the provided ezcFeed object.
     *
     * @param ezcFeed $feed The feed object in which to store the parsed XML element as a feed element
     * @param ezcFeedElement $element The feed element object that will contain skipHours
     * @param DOMElement $xml The XML element object to parse
     */
    private function parseSkipHours( ezcFeed $feed, ezcFeedElement $element, DOMElement $xml )
    {
        foreach ( $xml->childNodes as $itemChild )
        {
            if ( $itemChild->nodeType === XML_ELEMENT_NODE )
            {
                $tagName = $itemChild->tagName;

                switch ( $tagName )
                {
                    case 'hour':
                        $subElement = $element->add( 'hour' );
                        $subElement->set( $itemChild->textContent );
                        break;
                }
            }
        }
    }

    /**
     * Parses the provided XML element object and stores it as a feed element
     * of type skipDays in the provided ezcFeed object.
     *
     * @param ezcFeed $feed The feed object in which to store the parsed XML element as a feed element
     * @param ezcFeedElement $element The feed element object that will contain skipDays
     * @param DOMElement $xml The XML element object to parse
     */
    private function parseSkipDays( ezcFeed $feed, ezcFeedElement $element, DOMElement $xml )
    {
        foreach ( $xml->childNodes as $itemChild )
        {
            if ( $itemChild->nodeType === XML_ELEMENT_NODE )
            {
                $tagName = $itemChild->tagName;

                switch ( $tagName )
                {
                    case 'day':
                        $subElement = $element->add( 'day' );
                        $subElement->set( $itemChild->textContent );
                        break;
                }
            }
        }
    }

    /**
     * Parses the provided XML element object and stores it as a textInput in
     * the provided ezcFeed object.
     *
     * @param ezcFeed $feed The feed object in which to store the parsed XML element as a textInput
     * @param ezcFeedElement $element The feed element object that will contain the textInput
     * @param DOMElement $xml The XML element object to parse
     */
    private function parseTextInput( ezcFeed $feed, ezcFeedElement $element, DOMElement $xml )
    {
        foreach ( $xml->childNodes as $itemChild )
        {
            if ( $itemChild->nodeType === XML_ELEMENT_NODE )
            {
                $tagName = $itemChild->tagName;

                switch ( $tagName )
                {
                    case 'title': // required in RSS2
                    case 'description': // required in RSS2
                    case 'name': // required in RSS2
                    case 'link': // required in RSS2
                        $element->$tagName = $itemChild->textContent;
                        break;
                }
            }
        }
    }
}
?>
