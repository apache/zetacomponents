<?php
/**
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package Feed
 * @access private
 */
/**
 * @package Feed
 * @version //autogentag//
 * @access private
 */
class ezcFeedRss2 extends ezcFeedRss
{
    /**
     * A list of modules that are supported by this feed type
     *
     * @var array(string)
     */
    protected $supportedModules = array( 'DublinCore' );

    /**
     * A list of required attributes for the channel definition
     *
     * @var array(string)
     */
    static $requiredFeedAttributes = array( 'title', 'link', 'description' );

    /**
     * A list of optional attributes for the channel definition
     *
     * @var array(string)
     */
    static $optionalFeedAttributes = array(
        'language', 'copyright', 'author', 'webMaster', 'published', 'updated',
        'category', 'generator', 'ttl', 'docs', 'image' );

    /**
     * This array maps the common names for channel attributes to feed specific names
     *
     * @var array(string=>string)
     */
    static $feedAttributesMap = array(
        'author' => 'managingDirector',
        'published' => 'pubDate',
        'updated' => 'lastBuildDate',
    );

    static $requiredFeedItemAttributes = array( 'title', 'link', 'description' );
    static $optionalFeedItemAttributes = array( 'author', 'category',
        'comments', 'enclosure', 'guid', 'published', 'source' );
    static $feedItemAttributesMap = array(
        'published' => 'pubDate',
    );

    public function __construct()
    {
        // set default values
        $this->setMetaData( 'published', $this->prepareDate( time() ) );
        $this->setMetaData( 'generator', "eZ components" );
        $this->setMetaData( 'docs', 'http://www.rssboard.org/rss-specification' );
    }

    public function setFeedElement( $element, $value )
    {
        if ( in_array( $element, self::$requiredFeedAttributes ) || in_array( $element, self::$optionalFeedAttributes ) )
        {
            switch ( $element )
            {
                case 'category':
                    $this->setMetaArrayData( $element, $value );
                    break;
                case 'published':
                case 'updated':
                    $this->setMetaData( $element, $this->prepareDate( $value ) );
                    break;
                default:
                    $this->setMetaData( $element, $value );
            }
            $this->processModuleFeedHook( $this, $element, $value );
        }
    }

    public function setFeedItemElement( $item, $element, $value )
    {
        if ( in_array( $element, self::$requiredFeedItemAttributes ) || in_array( $element, self::$optionalFeedItemAttributes ) )
        {
//            $element = $this->normalizeName( $element, self::$feedItemAttributesMap );

            switch ( $element )
            {
                case 'author':
                case 'category':
                    $item->setMetaArrayData( $element, $value );
                    break;
                case 'published':
                    $item->setMetaData( $element, $this->prepareDate( $value ) );
                    break;
                default:
                    $item->setMetaData( $element, $value );
            }
        }
    }

    public function getFeedElement( $element )
    {
        $element = $this->normalizeName( $element, self::$feedAttributesMap );
        return $this->getMetaData( $element );
    }

    public function getFeedItemElement( $item, $element )
    {
        $element = $this->normalizeName( $element, self::$feedItemAttributesMap );
        return $item->getMetaData( $element );
    }

    private function generateItem( $item )
    {
        $itemTag = $this->xml->createElement( 'item' );
        $this->channel->appendChild( $itemTag );

        foreach ( self::$requiredFeedItemAttributes as $attribute )
        {
            $data = $item->getMetaData( $attribute );
            if ( is_null( $data ) )
            {
                throw new ezcFeedRequiredItemDataMissingException( $attribute );
            }
            $this->generateItemData( $itemTag, $attribute, $item->getMetaData( $attribute ) );
        }

        foreach ( self::$optionalFeedItemAttributes as $attribute )
        {
            $normalizedAttribute = $this->normalizeName( $attribute, self::$feedItemAttributesMap );

            $metaData = $item->getMetaData( $attribute );
            if ( !is_null( $metaData ) )
            {
                switch ( $attribute ) {
                    case 'guid':
                        $permalink = substr( $metaData, 0, 7 ) === 'http://' ? "true" : "false";
                        $this->generateItemDataWithAttributes( $itemTag, $normalizedAttribute, $metaData, array( 'isPermalink' => $permalink ) );
                        break;
                    case 'published':
                        $this->generateItemData( $itemTag, $normalizedAttribute, date( 'D, d M Y H:i:s O', $metaData ) );
                        break;
                    default:
                        $this->generateItemData( $itemTag, $normalizedAttribute, $metaData );
                }
            }
        }

        // run module hooks
        foreach ( $this->getModules() as $moduleName => $moduleDescription )
        {
            $prefix = $moduleDescription->moduleObj->getNamespacePrefix();
            $namespace = $moduleDescription->moduleObj->getNamespace();
            $this->generateNamespace( $prefix, $namespace );

            foreach ( $item->getModuleMetaData( $moduleName ) as $element => $value )
            {
                $moduleDescription->moduleObj->generateItemData( $itemTag, $this, $element, $value );
            }
        }
    }

    public function generate()
    {
        $this->xml = new DomDocument( '1.0', 'utf-8' );
        $this->xml->formatOutput = 1;
        $this->createRootElement( '2.0' );

        foreach ( self::$requiredFeedAttributes as $attribute )
        {
            $data = $this->getMetaData( $attribute );
            if ( is_null( $data ) )
            {
                throw new ezcFeedRequiredMetaDataMissingException( $attribute );
            }
            $this->generateMetaData( $attribute, $data );
        }

        foreach ( self::$optionalFeedAttributes as $attribute )
        {
            $normalizedAttribute = $this->normalizeName( $attribute, self::$feedAttributesMap );
            $data = $this->getMetaData( $attribute );

            if ( !is_null( $data ) )
            {
                switch ( $attribute )
                {
                    case 'image':
                        $this->generateImage( $this->channel, $this->getMetaData( 'title' ), $this->getMetaData( 'link' ), $data );
                        break;
                    case 'published':
                    case 'updated':
                        $this->generateMetaData( $normalizedAttribute, date( 'D, d M Y H:i:s O', $data ) );
                        break;
                    default:
                        $this->generateMetaData( $normalizedAttribute, $data );
                }
            }
        }

        // run module hooks
        foreach ( $this->getModules() as $moduleName => $moduleDescription )
        {
            $prefix = $moduleDescription->moduleObj->getNamespacePrefix();
            $namespace = $moduleDescription->moduleObj->getNamespace();
            $this->generateNamespace( $prefix, $namespace );

            foreach ( $this->getModuleMetaData( $moduleName ) as $element => $value )
            {
                $moduleDescription->moduleObj->generateMetaData( $this, $element, $value );
            }
        }

        foreach ( $this->items as $item )
        {
            $this->generateItem( $item );
        }

        return $this->xml->saveXML();
    }

    public static function canParse( DomDocument $xml )
    {
        if ( $xml->documentElement->tagName !== 'rss' )
        {
            return false;
        }
        if ( !$xml->documentElement->hasAttribute( 'version' ) )
        {
            return false;
        }
        if ( $xml->documentElement->getAttribute( 'version' ) !== "2.0" )
        {
            return false;
        }
        return true;
    }

    public function parseItem( ezcFeed $feed, DomElement $item )
    {
        $feedItem = $feed->newItem();
        foreach ( $item->childNodes as $itemChild )
        {
            if ( $itemChild->nodeType == XML_ELEMENT_NODE )
            {
                $tagName = $itemChild->tagName;
                $tagName = $this->deNormalizeName( $tagName, self::$feedItemAttributesMap );
                switch ( $tagName )
                {
                    case 'title':
                    case 'link':
                    case 'description':
                    case 'author':
                    case 'comments':
                    case 'enclosure':
                    case 'guid':
                    case 'source':
                        $feedItem->$tagName = $itemChild->textContent;
                        break;
                    case 'published':
                        $feedItem->$tagName = $this->prepareDate( $itemChild->textContent );
                        break;
                    case 'category':
                        $this->handleArrayValue( $feedItem, $tagName, $itemChild->textContent );
                        break;
                }
            }
        }
    }

    public function parse( DomDocument $xml )
    {
        $feed = ezcFeed::create( 'rss2' );
        $rssChildren = $xml->documentElement->childNodes;
        $channel = null;
        foreach ( $rssChildren as $rssChild )
        {
            if ( $rssChild->nodeType == XML_ELEMENT_NODE && $rssChild->tagName === 'channel' )
            {
                $channel = $rssChild;
            }
        }
        if ( $channel === null ) // add test
        {
            throw new ezcFeedParseErrorException( "No channel tag" );
        }

        foreach ( $channel->childNodes as $channelChild )
        {
            if ( $channelChild->nodeType == XML_ELEMENT_NODE )
            {
                $tagName = $channelChild->tagName;
                $tagName = $this->deNormalizeName( $tagName, self::$feedAttributesMap );
                switch ( $tagName )
                {
                    case 'title':
                    case 'link':
                    case 'description':
                    case 'language':
                    case 'copyright':
                    case 'author':
                    case 'webMaster':
                    case 'generator':
                    case 'ttl':
                    case 'docs':
                        $feed->$tagName = $channelChild->textContent;
                        break;
                    case 'published':
                    case 'updated':
                        $feed->$tagName = $this->prepareDate( $channelChild->textContent );
                        break;
                    case 'category':
                        $this->handleArrayValue( $feed, $tagName, $channelChild->textContent );
                        break;
                    case 'item':
                        $this->parseItem( $feed, $channelChild );
                        break;
                }
            }
        }
        return $feed;
    }
}
?>
