<?php
/**
 * File containing the ezcFeed class.
 *
 * @package Feed
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @filesource
 */

/**
 * Class defining a feed.
 *
 * A feed has a type (eg. RSS1, RSS2 or ATOM) and one or more modules (eg.
 * Content, DublinCore).
 *
 * The feed type defines which processor is used to parse and generate that type.
 * The following feed processors are supported by the Feed component:
 *  - RSS1 ({@link ezcFeedRss1}) -
 *    {@link http://web.resource.org/rss/1.0/spec Specifications}
 *  - RSS2 ({@link ezcFeedRss1}) -
 *    {@link http://www.rssboard.org/rss-specification Specifications}
 *  - ATOM ({@link ezcFeedAtom}) -
 *    {@link http://atompub.org/rfc4287.html RFC4287}
 *
 * A new processor can be defined by creating a class which extends the class
 * {@link ezcFeedProcessor} and implements the interface {@link ezcFeedParser},
 * and adding it to the {@link self::$supportedFeedTypes} array.
 *
 * A module is a part of a feed. The following modules are supported by the Feed
 * component:
 *  - Content ({@link ezcFeedModuleContent}) -
 *    {@link http://web.resource.org/rss/1.0/modules/content/ Specifications}
 *  - DublinCore ({@link ezcFeedModuleDublinCore}) -
 *    {@link http://web.resource.org/rss/1.0/modules/dc/ Specifications}
 *
 * A new module can be defined by creating a class which implements the interface
 * {@link ezcFeedModule}, and adding it to the {@link self::$supportedModules}
 * array.
 *
 * A feed object can be created in different ways:
 *  - by calling the constructor with the required feed type. Example:
 *      <code>
 *        // create an RSS2 feed
 *        $feed = new ezcFeed( 'rss2' );
 *      </code>
 *  - by parsing an existing XML file or uri. The feed type of the resulting
 *    ezcFeed object will be autodetected. Example:
 *      <code>
 *        // create an RSS2 feed from the XML file at http://www.example.com/rss2.xml
 *        $feed = ezcFeed::parse( 'http://www.example.com/rss2.xml' );
 *      </code>
 *  - by parsing an XML document stored in a string variable. The feed type of
 *    the resulting ezcFeed object will be autodetected. Example:
 *      <code>
 *        // create an RSS2 feed from the XML document stored in $xmlString
 *        $feed = ezcFeed::parseContent( $xmlString );
 *      </code>
 *
 * Operations possible upon ezcFeed objects (in the following examples $feed is
 * an existing ezcFeed object):
 *  - add a module to the feed. Example:
 *      <code>
 *        $feed->addModule( 'ezcFeedModuleDublinCore' );
 *      </code>
 *  - set/get a value from the feed document. Example:
 *      <code>
 *        $feed->title = 'News';
 *        $title = $feed->title;
 *      </code>
 *  - set/get a value from a module in the feed document. Example:
 *      <code>
 *        $feed->DublinCore->description = 'Detailed description';
 *        $title = $feed->DublinCore->description;
 *      </code>
 *  - iterate over the items in the feed. An item in the feed is of class
 *    {@link ezcFeedItem}. Example:
 *      <code>
 *        // retrieve the titles from the feed items
 *        foreach ( $feed as $item )
 *        {
 *            $titles[] = $item->title;
 *        }
 *      </code>
 *  - generate an XML document from the ezcFeed object. Example:
 *      <code>
 *        $xml = $feed->generate();
 *      </code>
 *
 * @property string $title
 *           Required in RSS1, RSS2, ATOM.
 * @property string $subtitle
 *           ATOM only.
 * @property string $link
 *           Required in RSS2, rdf:about AND link in RSS1.
 * @property string $description
 *           Required in RSS1, RSS2.
 * @property string $language
 *           Language string.
 * @property string $copyright
 *           Rights in ATOM.
 * @property string $author
 *           Same as managingEditor in RSS2, required in ATOM.
 * @property string $webMaster
 *           RSS2 only.
 * @property string $published
 *           Same as pubDate in RSS2.
 * @property string $updated
 *           Same as lastBuildDate in RSS2, required in ATOM.
 * @property string $category
 *           Category string.
 * @property string $generator
 *           Generator string.
 * @property string $ttl
 *           Time-to-live.
 * @property string $image
 *           Same as icon in ATOM.
 * @property string $id
 *           ATOM only, required in ATOM.
 * @property-read array(int=>ezcFeedItem) $items
 *                The items belonging to the feed.
 *
 * @package Feed
 * @version //autogentag//
 * @mainclass
 */
class ezcFeed implements Iterator
{
    /**
     * Holds a list of all supported feed types.
     *
     * @var array(string=>string)
     */
    protected static $supportedFeedTypes = array(
        'rss1' => 'ezcFeedRss1',
        'rss2' => 'ezcFeedRss2',
        'atom' => 'ezcFeedAtom',
    );

    /**
     * Holds a list of all supported feed modules.
     *
     * @var array(string=>string)
     */
    protected static $supportedModules = array(
        'Content'    => 'ezcFeedModuleContent',
        'DublinCore' => 'ezcFeedModuleDublinCore',
    );

    /**
     * Holds the feed processor.
     *
     * @var ezcFeedProcessor
     * @ignore
     */
    protected $feedProcessor;

    /**
     * Holds the feed type.
     *
     * @var string
     * @ignore
     */
    protected $feedType;

    /**
     * Holds the feed items to be iterated.
     *
     * @var array(ezcFeedItem)
     * @ignore
     */
    protected $iteratorItems = array();

    /**
     * Holds the number of feed items.
     *
     * @var int
     * @ignore
     */
    protected $iteratorElementCount = 0;

    /**
     * Holds the current feed item.
     *
     * @var int
     * @ignore
     */
    protected $iteratorPosition = 0;

    /**
     * Creates a new feed of type $type.
     *
     * Example:
     * <code>
     * // create an RSS2 feed
     * $feed = new ezcFeed( 'rss2' );
     * </code>
     *
     * @throws ezcFeedUnsupportedTypeException
     *         If the passed $type is an unsupported feed type.
     *
     * @param string $type The feed type
     */
    public function __construct( $type )
    {
        $type = strtolower( $type );

        if ( !isset( self::$supportedFeedTypes[$type] ) )
        {
            throw new ezcFeedUnsupportedTypeException( $type );
        }

        $this->feedType = $type;
        $this->feedProcessor = new self::$supportedFeedTypes[$type];
    }

    /**
     * Sets the property $property to $value.
     *
     * @throws ezcBasePropertyPermissionException
     *         If $property is a read-only property.
     * @throws ezcBaseValueException
     *         If trying to assign a wrong value to the property $property.
     *
     * @param string $property The property name
     * @param mixed $value The property value
     * @ignore
     */
    public function __set( $property, $value )
    {
        switch ( $property )
        {
            case 'title': // required in RSS1, RSS2, ATOM
            case 'subtitle': // ATOM only
            case 'link': // required in RSS2, rdf:about AND link in RSS1
            case 'description': // required in RSS1, RSS2
            case 'language':
            case 'copyright': // rights in ATOM
            case 'author': // managingEditor in RSS2, required in ATOM
            case 'webMaster': // RSS2 only
            case 'published': // pubDate in RSS2
            case 'updated':   // lastBuildDate in RSS2, required in ATOM
            case 'category':
            case 'generator':
            case 'ttl':
            case 'image': // icon in ATOM
            case 'id': // ATOM only, required in ATOM
                $this->feedProcessor->setFeedElement( $property, $value );
                break;

            case 'items':
                throw new ezcBasePropertyPermissionException( $property, ezcBasePropertyPermissionException::READ );
        }

        $modules = $this->feedProcessor->getModules();
        foreach ( $modules as $moduleName => $moduleObj )
        {
            if ( $property == $moduleName )
            {
                $this->$moduleName = $value;
            }
        }
    }

    /**
     * Returns the value of property $property.
     *
     * @throws ezcBasePropertyNotFoundException
     *         If the property $property does not exist.
     *
     * @param string $property The property name
     * @return mixed
     * @ignore
     */
    public function __get( $property )
    {
        switch ( $property )
        {
            case 'title': // required in RSS1, RSS2, ATOM
            case 'subtitle': // ATOM only
            case 'link': // required in RSS2, rdf:about AND link in RSS1
            case 'description': // required in RSS1, RSS2
            case 'language':
            case 'copyright': // rights in ATOM
            case 'author': // managingEditor in RSS2, required in ATOM
            case 'webMaster': // RSS2 only
            case 'published': // pubDate in RSS2
            case 'updated':   // lastBuildDate in RSS2, required in ATOM
            case 'category':
            case 'generator':
            case 'ttl':
            case 'image': // icon in ATOM
            case 'id': // ATOM only, required in ATOM
                return $this->feedProcessor->getFeedElement( $property );

            case 'items':
                return (array) $this->feedProcessor->getItems();

            default:
                throw new ezcBasePropertyNotFoundException( $property );
        }
    }

    /**
     * Adds a new module to the feed.
     *
     * Example:
     * <code>
     * $feed->addModule( 'ezcFeedModuleDublinCode' );
     * </code>
     *
     * @throws ezcFeedUnsupportedModuleException
     *         If the module is not supported by this feed processor.
     *
     * @param string $className The class of the module
     */
    public function addModule( $className )
    {
        if ( !in_array( $className, self::$supportedModules ) )
        {
            throw new ezcFeedUnsupportedModuleException( $className );
        }

        $moduleObj = new $className( $this->feedType );
        $moduleName = $moduleObj->getModuleName();
        $this->$moduleName = $this->feedProcessor->addModule( $moduleName, $moduleObj );
    }

    /**
     * Creates and returns a new feed item for this feed.
     *
     * Example:
     * <code>
     * $item = $feed->newItem();
     * </code>
     *
     * @return ezcFeedItem
     */
    public function newItem()
    {
        $item = new ezcFeedItem( $this->feedProcessor );
        $this->feedProcessor->addItem( $item );
        return $item;
    }

    /**
     * Generates and returns an XML document from the current object.
     *
     * @return string
     */
    public function generate()
    {
        return $this->feedProcessor->generate();
    }

    /**
     * Rewinds the cursor in the items array. Required by the Iterator interface.
     */
    public function rewind()
    {
        $this->iteratorItems = $this->feedProcessor->getItems();
        $this->iteratorElementCount = count( $this->iteratorItems );
        $this->iteratorPosition = 0;
    }

    /**
     * Returns the current item in the items array. Required by the Iterator
     * interface.
     *
     * @return ezcFeedItem
     */
    public function current()
    {
        return $this->iteratorItems[$this->iteratorPosition];
    }

    /**
     * Returns the current key in the items array. Required by the Iterator
     * interface.
     *
     * @return int
     */
    public function key()
    {
        return $this->iteratorPosition;
    }

    /**
     * Returns if the current item in the items array is not in the last position.
     * Required by the Iterator interface.
     *
     * @return bool
     */
    public function valid()
    {
        return $this->iteratorPosition < $this->iteratorElementCount;
    }

    /**
     * Advances the current item in the items array. Required by the Iterator
     * interface.
     */
    public function next()
    {
        $this->iteratorPosition++;
    }

    /**
     * Parses the XML document in the $uri and returns an ezcFeed object with
     * the type autodetected from the XML document.
     *
     * Example of parsing an XML document stored in an URI:
     * <code>
     * $feed = ezcFeed::parse( 'http://www.example.com/rss2.xml' );
     * </code>
     *
     * @throws ezcBaseFileNotFoundException
     *         If the XML file at $uri could not be found.
     *
     * @param string $uri An URI which stores an XML document
     * @return ezcFeed
     */
    public static function parse( $uri )
    {
        $xml = new DomDocument;
        $retval = @$xml->load( $uri );
        if ( $retval === false )
        {
            throw new ezcBaseFileNotFoundException( $uri );
        }
        return self::dispatchXml( $xml );
    }

    /**
     * Parses the XML document stored in $content and returns an ezcFeed object
     * with the type autodetected from the XML document.
     *
     * Example of parsing an XML document stored in a string:
     * <code>
     * // $xmlString contains a valid XML document
     * $feed = ezcFeed::parse( $xmlString );
     * </code>
     *
     * @throws ezcFeedParseErrorException
     *         If $content is not a valid XML document.
     *
     * @param string $content A string variable which stores an XML document
     * @return ezcFeed
     */
    public static function parseContent( $content )
    {
        $xml = new DomDocument;
        $retval = @$xml->loadXML( $content );
        if ( $retval === false )
        {
            throw new ezcFeedParseErrorException( "Content is no valid XML" );
        }
        return self::dispatchXml( $xml );
    }

    /**
     * Returns the supported feed types (the keys of the
     * {@link self::$supportedFeedTypes} array).
     *
     * @return array(string)
     */
    public static function getSupportedTypes()
    {
        return array_keys( self::$supportedFeedTypes );
    }

    /**
     * Returns the supported modules (the {@link self::$supportedModules} array).
     *
     * @return array(string=>string)
     */
    public static function getSupportedModules()
    {
        return self::$supportedModules;
    }

    /**
     * Returns a new $moduleName module object of feed type $feedType.
     *
     * @param string $moduleName A module name, for example 'DublinCore'
     * @param string $feedType A feed type, for example 'rss2'
     * @return ezcFeedModule
     */
    public static function getModule( $moduleName, $feedType )
    {
        return new self::$supportedModules[$moduleName]( $feedType );
    }

    /**
     * Parses the $xml object by dispatching it to the processor that can
     * handle it.
     *
     * @throws ezcFeedCanNotParseException
     *         If the $xml object could not be parsed by any available processor.
     *
     * @param DOMDocument $xml The XML object to parse
     * @return ezcFeed
     */
    protected static function dispatchXml( DOMDocument $xml )
    {
        foreach ( self::$supportedFeedTypes as $feedType => $feedClass )
        {
            $canParse = call_user_func( array( $feedClass, 'canParse' ), $xml );
            if ( $canParse === true )
            {
                $processor = new $feedClass;
                return $processor->parse( $xml );
            }
        }

        throw new ezcFeedCanNotParseException( $xml->documentURI, 'Feed type not recognized' );
    }
}
?>
