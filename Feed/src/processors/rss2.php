<?php
/**
 * File containing the ezcFeedRss2 class.
 *
 * @package Feed
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @filesource
 */

/**
 * Class providing parsing and generating of RSS2 feeds.
 *
 * @package Feed
 * @version //autogentag//
 */
class ezcFeedRss2 extends ezcFeedRss
{
    /**
     * Defines the feed type of this processor.
     */
    const FEED_TYPE = 'rss2';

    /**
     * Holds a list of modules that are supported by this feed type.
     *
     * @var array(string)
     */
    protected $supportedModules = array( 'DublinCore', 'Content' );

    /**
     * Holds a list of required attributes for the channel definition.
     *
     * @var array(string)
     */
    protected static $requiredFeedAttributes = array( 'title', 'link', 'description' );

    /**
     * Holds a list of optional attributes for the channel definition.
     *
     * @var array(string)
     */
    protected static $optionalFeedAttributes = array(
        'language', 'copyright', 'author', 'webMaster', 'published', 'updated',
        'category', 'generator', 'ttl', 'docs', 'image' );

    /**
     * Holds a mapping of the common names for channel attributes to feed specific
     * names.
     *
     * @var array(string=>string)
     */
    protected static $feedAttributesMap = array(
        'author' => 'managingEditor',
        'published' => 'pubDate',
        'updated' => 'lastBuildDate',
    );

    /**
     * Holds a list of required attributes for items definitions.
     *
     * @var array(string)
     */
    protected static $requiredFeedItemAttributes = array( 'title', 'link', 'description' );

    /**
     * Holds a list of optional attributes for items definitions.
     *
     * @var array(string)
     */
    protected static $optionalFeedItemAttributes = array( 'author', 'category',
        'comments', 'enclosure', 'guid', 'published', 'source' );

    /**
     * Holds a mapping of the common names for items attributes to feed specific
     * names.
     *
     * @var array(string=>string)
     */
    protected static $feedItemAttributesMap = array(
        'published' => 'pubDate',
    );

    /**
     * Holds the prefixes used in the feed generation process.
     *
     * @var array(string)
     * @ignore
     */
    protected $usedPrefixes = array();

    /**
     * Creates a new RSS2 processor.
     */
    public function __construct()
    {
        // set default values
        $this->setMetaData( 'published', $this->prepareDate( time() ) );
        $this->setMetaData( 'generator', "eZ Components" );
        $this->setMetaData( 'docs', 'http://www.rssboard.org/rss-specification' );
        $this->feedType = self::FEED_TYPE;
    }

    /**
     * Sets the value of the feed element $element to $value.
     *
     * The hook {@link ezcFeedProcessor::processModuleFeedSetHook()} is called
     * before setting $element.
     *
     * @param string $element The feed element
     * @param mixed $value The new value of $element
     */
    public function setFeedElement( $element, $value )
    {
        $this->processModuleFeedSetHook( $this, $element, $value );
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
        }
    }

    /**
     * Sets the value of the feed element $element of feed item $item to $value.
     *
     * The hook {@link ezcFeedProcessor::processModuleItemSetHook()} is called
     * before setting $element.
     *
     * @param ezcFeedItem $item The feed item object
     * @param string $element The feed element
     * @param mixed $value The new value of $element
     */
    public function setFeedItemElement( ezcFeedItem $item, $element, $value )
    {
        $this->processModuleItemSetHook( $item, $element, $value );
        if ( in_array( $element, self::$requiredFeedItemAttributes ) || in_array( $element, self::$optionalFeedItemAttributes ) )
        {
            switch ( $element )
            {
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

    /**
     * Returns the value of the feed element $element.
     *
     * @param string $element The feed element
     * @return mixed
     */
    public function getFeedElement( $element )
    {
        $element = $this->normalizeName( $element, self::$feedAttributesMap );
        return $this->getMetaData( $element );
    }

    /**
     * Returns the value of the element $element of feed item $item.
     *
     * @param ezcFeedItem $item The feed item object
     * @param string $element The feed element
     * @return mixed
     */
    public function getFeedItemElement( ezcFeedItem $item, $element )
    {
        $element = $this->normalizeName( $element, self::$feedItemAttributesMap );
        return $item->getMetaData( $element );
    }

    /**
     * Generates the required data for the feed item $item and includes it in
     * the XML document which is being generated.
     *
     * The hook {@link ezcFeedProcessor::processModuleItemGenerateHook()} is
     * called for each attribute in the item.
     *
     * @param ezcFeedItem $item The feed item object
     * @return string
     */
    protected function generateItem( ezcFeedItem $item )
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
            if ( $this->processModuleItemGenerateHook( $item, $attribute, $data ) !== false )
            {
                $this->generateItemData( $itemTag, $attribute, $item->getMetaData( $attribute ) );
            }
        }

        foreach ( self::$optionalFeedItemAttributes as $attribute )
        {
            $normalizedAttribute = $this->normalizeName( $attribute, self::$feedItemAttributesMap );

            $metaData = $item->getMetaData( $attribute );
            if ( $this->processModuleItemGenerateHook( $item, $attribute, $data ) !== false )
            {
                if ( !is_null( $metaData ) )
                {
                    switch ( $attribute ) {
                        case 'guid':
                            $permalink = substr( $metaData, 0, 7 ) === 'http://' ? "true" : "false";
                            $this->generateItemDataWithAttributes( $itemTag, $normalizedAttribute, $metaData, array( 'isPermaLink' => $permalink ) );
                            break;
                        case 'published':
                            $this->generateItemData( $itemTag, $normalizedAttribute, date( 'D, d M Y H:i:s O', $metaData ) );
                            break;
                        default:
                            $this->generateItemData( $itemTag, $normalizedAttribute, $metaData );
                    }
                }
            }
        }

        // run module hooks
        foreach ( $this->getModules() as $moduleName => $moduleDescription )
        {
            $prefix = $moduleDescription->moduleObj->getNamespacePrefix();
            $namespace = $moduleDescription->moduleObj->getNamespace();
            $this->generateNamespace( $prefix, $namespace );

            foreach ( $item->getAllModuleMetaData( $moduleName ) as $element => $value )
            {
                $moduleDescription->moduleObj->generateItemData( $itemTag, $this, $element, $value );
            }
        }
    }

    /**
     * Returns an XML string from the feed information contained in this
     * processor.
     *
     * The hooks {@link ezcFeedProcessor::processModuleFeedGenerateHook()} and
     * {@link ezcFeedProcessor::processModuleItemGenerateHook()} are used for
     * each attribute in the feed and in the feed items.
     *
     * @return string
     */
    public function generate()
    {
        $this->xml = new DOMDocument( '1.0', 'utf-8' );
        $this->xml->formatOutput = 1;
        $this->createRootElement( '2.0' );

        foreach ( self::$requiredFeedAttributes as $attribute )
        {
            $data = $this->getMetaData( $attribute );
            if ( is_null( $data ) )
            {
                throw new ezcFeedRequiredMetaDataMissingException( $attribute );
            }
            if ( $this->processModuleFeedGenerateHook( $attribute, $data ) !== false )
            {
                $this->generateMetaData( $attribute, $data );
            }
        }

        foreach ( self::$optionalFeedAttributes as $attribute )
        {
            $normalizedAttribute = $this->normalizeName( $attribute, self::$feedAttributesMap );
            $data = $this->getMetaData( $attribute );

            if ( !is_null( $data ) )
            {
                if ( $this->processModuleFeedGenerateHook( $attribute, $data ) !== false )
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
        }

        // run module hooks
        foreach ( $this->getModules() as $moduleName => $moduleDescription )
        {
            $prefix = $moduleDescription->moduleObj->getNamespacePrefix();
            $namespace = $moduleDescription->moduleObj->getNamespace();
            $this->generateNamespace( $prefix, $namespace );

            foreach ( $this->getAllModuleMetaData( $moduleName ) as $element => $value )
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
        if ( $xml->documentElement->getAttribute( 'version' ) !== "2.0" )
        {
            return false;
        }
        return true;
    }

    /**
     * Parses the provided XML element object and stores it as a feed item in
     * the provided ezcFeed object.
     *
     * @param ezcFeed $feed The feed object in which to store the parsed XML element as a feed item
     * @param DOMElement $xml The XML element object to parse
     */
    public function parseItem( ezcFeed $feed, DOMElement $item )
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
                        $array = $feedItem->$tagName;
                        $array[] = $itemChild->textContent;
                        $feedItem->$tagName = $array;
                        break;
                    default:
                        // check if it's part of a known module/namespace
                        $parts = explode( ':', $tagName );
                        if ( count( $parts ) == 2 && in_array( $parts[0], array_keys( $this->usedPrefixes ) ) )
                        {
                            $moduleName = $this->usedPrefixes[$parts[0]];
                            $element = $parts[1];
                            $feedItem->$moduleName->$element = $itemChild->textContent;
                        }
                }
            }
        }
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
        $feed = new ezcFeed( 'rss2' );
        $rssChildren = $xml->documentElement->childNodes;
        $channel = null;

        // figure out modules
        $supportedModules = ezcFeed::getSupportedModules();
        $this->usedPrefixes = array();
        $xp = new DOMXpath( $xml );
        $set = $xp->query( './namespace::*', $xml->documentElement );
        $this->usedNamespaces = array();
        foreach ( $set as $node )
        {
            foreach ( $supportedModules as $moduleName => $moduleClass )
            {
                $moduleNamespace = call_user_func( array( $moduleClass, 'getNamespace' ) );
                if ( $moduleNamespace == $node->nodeValue )
                {
                    $feed->addModule( $moduleClass );
                    $this->usedPrefixes[call_user_func( array( $moduleClass, 'getNamespacePrefix' ) )] = $moduleName;
                }
            }
        }

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
                    case 'category':
                        $feed->$tagName = $channelChild->textContent;
                        break;

                    case 'published':
                    case 'updated':
                        $feed->$tagName = $this->prepareDate( $channelChild->textContent );
                        break;

                    case 'item':
                        $this->parseItem( $feed, $channelChild );
                        break;

                    default:
                        // check if it's part of a known module/namespace
                        $parts = explode( ':', $tagName );
                        if ( count( $parts ) == 2 && in_array( $parts[0], array_keys( $this->usedPrefixes ) ) )
                        {
                            $moduleName = $this->usedPrefixes[$parts[0]];
                            $element = $parts[1];
                            $feed->$moduleName->$element = $channelChild->textContent;
                        }
                }
            }
        }
        return $feed;
    }
}
?>
