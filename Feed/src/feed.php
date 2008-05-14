<?php
/**
 * File containing the ezcFeed class.
 *
 * @package Feed
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @filesource
 */

/**
 * Class defining a feed.
 *
 * A feed has a type (eg. RSS1, RSS2 or ATOM). The feed type defines which
 * processor is used to parse and generate that type.
 *
 * The following feed processors are supported by the Feed component:
 *  - ATOM ({@link ezcFeedAtom}) -
 *    {@link http://atompub.org/rfc4287.html RFC4287}
 *  - RSS1 ({@link ezcFeedRss1}) -
 *    {@link http://web.resource.org/rss/1.0/spec Specifications}
 *  - RSS2 ({@link ezcFeedRss2}) -
 *    {@link http://www.rssboard.org/rss-specification Specifications}
 *
 * A new processor can be defined by creating a class which extends the class
 * {@link ezcFeedProcessor} and implements the interface {@link ezcFeedParser}.
 * The new class needs to be added to the supported feed types list by calling
 * the function {@link registerFeed}.
 *
 * Example of creating a feed with a user-defined type:
 * <code>
 * ezcFeed::registerFeed( 'opml', 'myOpmlHandler');
 *
 * $feed = new ezcFeed( 'opml' );
 * // add properties for the Opml feed type to $feed
 * </code>
 *
 * In the above example, myOpmlHandler extends {@link ezcFeedProcessor} and
 * implements {@link ezcFeedParser}.
 *
 * The following modules are supported by the Feed component:
 *  - Content ({@link ezcFeedContentModule}) -
 *    {@link http://purl.org/rss/1.0/modules/content/ Specifications}
 *  - CreativeCommons ({@link ezcFeedCreativeCommonsModule}) -
 *    {@link http://backend.userland.com/creativeCommonsRssModule Specifications}
 *  - DublinCore ({@link ezcFeedDublinCoreModule}) -
 *    {@link http://dublincore.org/documents/dces/ Specifications}
 *  - Geo ({@link ezcFeedGeoModule}) -
 *    {@link http://www.w3.org/2003/01/geo/ Specifications}
 *  - iTunes ({@link ezcFeedITunesModule}) -
 *    {@link http://www.apple.com/itunes/store/podcaststechspecs.html Specifications}
 *
 * A new module can be defined by creating a class which extends the class
 * {@link ezcFeedModule}. The new class needs to be added to the supported modules
 * list by calling {@link registerModule}.
 *
 * Example of creating a feed with a user-defined module:
 * <code>
 * ezcFeed::registerModule( 'Slash', 'mySlashHandler', 'slash');
 *
 * $feed = new ezcFeed( 'rss2' );
 * $item = $feed->add( 'item' );
 * $slash = $item->addModule( 'Slash' );
 * // add properties for the Slash module to $slash
 * </code>
 *
 * In the above example mySlashHandler extends {@link ezcFeedModule}.
 *
 * A feed object can be created in different ways:
 *  - by calling the constructor with the required feed type. Example:
 *  <code>
 *  $feed = new ezcFeed( 'rss2' );
 *  </code>
 *  - by parsing an existing XML file or URI. The feed type of the resulting
 *    ezcFeed object will be autodetected. Example:
 *  <code>
 *  $feed = ezcFeed::parse( 'http://www.example.com/rss2.xml' );
 *  </code>
 *  - by parsing an XML document stored in a string variable. The feed type of
 *    the resulting ezcFeed object will be autodetected. Example:
 *  <code>
 *  $feed = ezcFeed::parseContent( $xmlString );
 *  </code>
 *
 * Operations possible upon ezcFeed objects (in the following examples $feed is
 * an existing {@link ezcFeed} object):
 *  - set a value to the feed object. Example:
 *  <code>
 *  $feed->title = 'News';
 *  </code>
 *  - get a value from the feed object. Example:
 *  <code>
 *  $title = $feed->title;
 *  </code>
 *  - iterate over the items in the feed. Example:
 *  <code>
 *  // retrieve the titles from the feed items
 *  foreach ( $feed->items as $item )
 *  {
 *      $titles[] = $item->title;
 *  }
 *  </code>
 *  - add a new item to the feed. Example:
 *  <code>
 *  $item = $feed->add( 'item' );
 *  $item->title = 'Item title';
 *  </code>
 *  - add a new module to the feed item. Example:
 *  <code>
 *  $item = $feed->add( 'item' );
 *  $module = $item->addModule( 'Content' );
 *  $content->encoded = 'text content which will be encoded';
 *  </code>
 *  - iterate over the loaded modules in a feed item. Example:
 *  <code>
 *  // display the namespaces of the modules loaded in the feed item $item
 *  foreach ( $item->getModules() as $moduleName => $module )
 *  {
 *      echo $module->getNamespace();
 *  }
 *  </code>
 *  - generate an XML document from the {@link ezcFeed} object. The result
 * string should be saved to a file, and a link to a file made accessible to
 * users of the application. Example:
 *  <code>
 *  $xml = $feed->generate();
 *  </code>
 *
 * @property array(ezcFeedElement) $author
 *           Author(s) of the feed.
 *           ATOM-author (required, multiple),
 *           RSS1-none,
 *           RSS2-managingEditor (optional, recommended, single).
 * @property array(ezcFeedElement) $category
 *           Categories for the feed.
 *           ATOM-category (optional, multiple),
 *           RSS1-none,
 *           RSS2-category (optional, multiple).
 * @property ezcFeedElement $cloud
 *           Allows processes to register with a cloud to be notified of updates
 *           to the channel, implementing a lightweight publish-subscribe
 *           protocol for RSS feeds.
 *           ATOM-none,
 *           RSS1-none,
 *           RSS2-cloud (optional, not recommended, single).
 * @property array(ezcFeedElement) $contributor
 *           One contributor for the feed.
 *           ATOM-contributor (optional, not recommended, multiple),
 *           RSS1-none,
 *           RSS2-none.
 * @property ezcFeedElement $copyright
 *           Copyright information for the feed.
 *           ATOM-rights (optional, single),
 *           RSS1-none,
 *           RSS2-copyright (optional, single).
 * @property ezcFeedElement $description
 *           A short description of the feed.
 *           ATOM-subtitle (required, single),
 *           RSS1-description (required, single),
 *           RSS2-description (required, single).
 * @property ezcFeedElement $docs
 *           An URL that points to the documentation for the format used in the
 *           feed file.
 *           ATOM-none,
 *           RSS1-none,
 *           RSS2-docs (optional, not recommended, single) - usual value is
 *           {@link http://www.rssboard.org/rss-specification}.
 * @property ezcFeedElement $generator
 *           Indicates the software used to generate the feed.
 *           ATOM-generator (optional, single),
 *           RSS1-none,
 *           RSS2-generator (optional, single).
 * @property ezcFeedElement $icon
 *           An icon for a feed, similar with favicon.ico for websites.
 *           ATOM-icon (optional, not recommended, single),
 *           RSS1-none,
 *           RSS2-none.
 * @property ezcFeedElement $id
 *           A universally unique and permanent identifier for a feed. For
 *           example, it can be an Internet domain name.
 *           ATOM-id (required, single),
 *           RSS1-about (required, single),
 *           RSS2-none.
 * @property ezcFeedElement $image
 *           An image associated with the feed
 *           ATOM-logo (optional, single),
 *           RSS1-image (optional, single),
 *           RSS2-image (optional, single).
 * @property-read array(ezcFeedItem) $item
 *           Feed items (entries).
 *           ATOM-entry (optional, recommended, multiple),
 *           RSS1-item (required, multiple),
 *           RSS2-item (required, multiple).
 * @property ezcFeedElement $language
 *           The language for the feed.
 *           ATOM-xml:lang attribute for title, description, copyright, content,
 *           comments (optional, single) - accessed as language through ezcFeed,
 *           RSS1-none,
 *           RSS2-language (optional, single).
 * @property array(ezcFeedElement) $link
 *           URLs to the HTML websites corresponding to the channel.
 *           ATOM-link (required one link with rel='self', multiple),
 *           RSS1-link (required, single),
 *           RSS2-link (required, single).
 * @property ezcFeedElement $published
 *           The time the feed was published.
 *           ATOM-none,
 *           RSS1-none,
 *           RSS2-pubDate (optional, not recommended, single).
 * @property ezcFeedElement $rating
 *           The {@link http://www.w3.org/PICS/ PICS} rating for the channel.
 *           ATOM-none,
 *           RSS1-none,
 *           RSS2-rating (optional, not recommended, single).
 * @property ezcFeedElement $skipDays
 *           A hint for aggregators telling them which days they can skip when
 *           reading the feed.
 *           ATOM-none,
 *           RSS1-none,
 *           RSS2-skipDays (optional, not recommended, single).
 * @property ezcFeedElement $skipHours
 *           A hint for aggregators telling them which hours they can skip when
 *           reading the feed.
 *           ATOM-none,
 *           RSS1-none,
 *           RSS2-skipHours (optional, not recommended, single).
 * @property ezcFeedElement $textInput
 *           Specifies a text input box that can be displayed with the feed.
 *           ATOM-none,
 *           RSS1-textinput (optional, not recommended, single),
 *           RSS2-textInput (optional, not recommended, single).
 * @property ezcFeedElement $title
 *           Human readable title for the feed. For example, it can be the same
 *           as the website title.
 *           ATOM-title (required, single),
 *           RSS1-title (required, single),
 *           RSS2-title (required, single).
 * @property ezcFeedElement $ttl
 *           Number of minutes that indicates how long a channel can be cached
 *           before refreshing from the source.
 *           ATOM-none,
 *           RSS1-none,
 *           RSS2-ttl (optional, not recommended, single).
 * @property ezcFeedElement $updated
 *           The last time the feed was updated.
 *           ATOM-updated (required, single),
 *           RSS1-none,
 *           RSS2-lastBuildDate (optional, recommended, single).
 * @property ezcFeedElement $webMaster
 *           The email address of the webmaster responsible for the feed.
 *           ATOM-none,
 *           RSS1-none,
 *           RSS2-webMaster (optional, not recommended, single).
 *
 * @todo parse() and parseContent() should(?) handle common broken XML files
 *       (for example if the first line is not <?xml version="1.0"?>)
 *
 * @package Feed
 * @version //autogentag//
 * @mainclass
 */
class ezcFeed
{
    /**
     * The version of the feed generator, to be included in the generated feeds.
     */
    const GENERATOR_VERSION = '//autogentag//';

    /**
     * The uri of the feed generator, to be included in the generated feeds.
     */
    const GENERATOR_URI = 'http://ezcomponents.org/docs/tutorials/Feed';

    /**
     * Holds a list of all supported feed types.
     *
     * @var array(string=>string)
     */
    private static $supportedFeedTypes = array();

    /**
     * Holds a list of all supported modules.
     *
     * @var array(string=>string)
     */
    private static $supportedModules = array();

    /**
     * Holds a list of all supported modules prefixes.
     *
     * @var array(string=>string)
     */
    private static $supportedModulesPrefixes = array();

    /**
     * Holds the feed processor.
     *
     * @var ezcFeedProcessor
     */
    private $feedProcessor;

    /**
     * Holds the feed type (eg. 'rss2').
     *
     * @var string
     */
    private $feedType;

    /**
     * Holds the feed content type (eg. 'application/rss+xml').
     *
     * @var string
     */
    private $contentType;

    /**
     * Creates a new feed of type $type.
     *
     * The $type value is one returned by {@link getSupportedTypes()}.
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
        self::initSupportedTypes();

        $type = strtolower( $type );

        if ( !isset( self::$supportedFeedTypes[$type] ) )
        {
            throw new ezcFeedUnsupportedTypeException( $type );
        }

        $this->feedType = $type;
        $this->feedProcessor = new self::$supportedFeedTypes[$type];
        $this->contentType = $this->feedProcessor->getContentType();
    }

    /**
     * Sets the property $property to $value.
     *
     * @param string $property The property name
     * @param mixed $value The property value
     * @ignore
     */
    public function __set( $property, $value )
    {
        switch ( $property )
        {
            case 'author':
            case 'category':
            case 'cloud':
            case 'contributor':
            case 'copyright':
            case 'description':
            case 'docs':
            case 'generator':
            case 'icon':
            case 'id':
            case 'image':
            case 'language':
            case 'link':
            case 'published':
            case 'rating':
            case 'skipDays':
            case 'skipHours':
            case 'textInput':
            case 'title':
            case 'ttl':
            case 'updated':
            case 'webMaster':
                $this->feedProcessor->$property = $value;
                break;

            default:
                $supportedModules = ezcFeed::getSupportedModules();
                if ( isset( $supportedModules[$property] ) )
                {
                    $this->feedProcessor->setModule( $property, $value );
                    return;
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
            case 'author':
            case 'category':
            case 'cloud':
            case 'contributor':
            case 'copyright':
            case 'description':
            case 'docs':
            case 'generator':
            case 'icon':
            case 'id':
            case 'image':
            case 'item':
            case 'language':
            case 'link':
            case 'published':
            case 'rating':
            case 'skipDays':
            case 'skipHours':
            case 'textInput':
            case 'title':
            case 'ttl':
            case 'updated':
            case 'webMaster':
                $value = $this->feedProcessor->$property;
                return $value;

            default:
                $supportedModules = ezcFeed::getSupportedModules();
                if ( isset( $supportedModules[$property] ) )
                {
                    if ( isset( $this->$property ) )
                    {
                        return $this->feedProcessor->getModule( $property );
                    }
                    else
                    {
                        throw new ezcFeedUndefinedModuleException( $property );
                    }
                }
        }

        throw new ezcFeedUnsupportedModuleException( $property );
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
        switch ( $name )
        {
            case 'author':
            case 'category':
            case 'cloud':
            case 'contributor':
            case 'copyright':
            case 'description':
            case 'docs':
            case 'generator':
            case 'icon':
            case 'id':
            case 'image':
            case 'item':
            case 'language':
            case 'link':
            case 'published':
            case 'rating':
            case 'skipDays':
            case 'skipHours':
            case 'textInput':
            case 'title':
            case 'ttl':
            case 'updated':
            case 'webMaster':
                return isset( $this->feedProcessor->$name );

            default:
                $supportedModules = ezcFeed::getSupportedModules();
                if ( isset( $supportedModules[$name] ) )
                {
                    return $this->hasModule( $name );
                }
        }

        return false;
    }

    /**
     * Adds a new module to this item and returns it.
     *
     * @todo check if module is already added, maybe return the existing module
     *
     * @param string $name The name of the module to add
     * @return ezcFeedModule
     */
    public function addModule( $name )
    {
        $this->$name = ezcFeedModule::create( $name, 'feed' );
        return $this->$name;
    }

    /**
     * Returns true if the module $name is loaded, false otherwise.
     *
     * @param string $name The name of the module to check if loaded for this item
     * @return bool
     */
    public function hasModule( $name )
    {
        return $this->feedProcessor->hasModule( $name );
    }

    /**
     * Returns an array with all the modules loaded at feed-level.
     *
     * @return array(ezcFeedModule)
     */
    public function getModules()
    {
        return $this->feedProcessor->getModules();
    }

    /**
     * Adds a new element with name $name to the feed and returns it.
     *
     * Example:
     * <code>
     * // $feed is an ezcFeed object
     * $item = $feed->add( 'item' );
     * $item->title = 'Item title';
     * </code>
     *
     * @param string $name The name of the element to add
     * @return ezcFeedElement
     */
    public function add( $name )
    {
        return $this->feedProcessor->add( $name );
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
     * @throws ezcFeedParseErrorException
     *         If the content at $uri is not a valid XML document.
     *
     * @param string $uri An URI which stores an XML document
     * @return ezcFeed
     */
    public static function parse( $uri )
    {
        if ( !file_exists( $uri ) )
        {
            $headers = @get_headers( $uri );
            if ( preg_match( "|200|", $headers[0] ) === 0 )
            {
                throw new ezcBaseFileNotFoundException( $uri );
            }
        }

        $xml = new DOMDocument();
        $retval = @$xml->load( $uri );
        if ( $retval === false )
        {
            throw new ezcFeedParseErrorException( $uri, "It is not a valid XML file" );
        }

        return self::dispatchXml( $xml );
    }

    /**
     * Parses the XML document stored in $content and returns an ezcFeed object
     * with the type autodetected from the XML document.
     *
     * Example of parsing an XML document stored in a string:
     * <code>
     * // $xmlString contains a valid XML string
     * $feed = ezcFeed::parseContent( $xmlString );
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
        $xml = new DOMDocument();
        $retval = @$xml->loadXML( $content );
        if ( $retval === false )
        {
            throw new ezcFeedParseErrorException( null, "Content is no valid XML" );
        }

        return self::dispatchXml( $xml );
    }

    /**
     * Returns the supported feed types.
     *
     * The array returned is (default):
     * <code>
     * array(
     *    'rss1' => 'ezcFeedRss1',
     *    'rss2' => 'ezcFeedRss2',
     *    'atom' => 'ezcFeedAtom'
     * );
     * </code>
     *
     * If the function {@link registerFeed} was used to add another supported feed
     * type to ezcFeed, it will show up in the returned array as well.
     *
     * @return array(string)
     */
    public static function getSupportedTypes()
    {
        return self::$supportedFeedTypes;
    }

    /**
     * Returns the supported feed modules.
     *
     * The array returned is (default):
     * <code>
     * array(
     *    'Content'         => 'ezcFeedContentModule',
     *    'CreativeCommons' => 'ezcFeedCreativeCommonsModule',
     *    'DublinCore'      => 'ezcFeedDublinCoreModule',
     *    'Geo'             => 'ezcFeedGeoModule',
     *    'iTunes'          => 'ezcFeedITunesModule'
     * );
     * </code>
     *
     * If the function {@link registerModule} was used to add another supported
     * module type to ezcFeed, it will show up in the returned array as well.
     *
     * @return array(string=>string)
     */
    public static function getSupportedModules()
    {
        return self::$supportedModules;
    }

    /**
     * Returns the supported feed modules prefixes.
     *
     * The array returned is (default):
     * <code>
     * array(
     *    'content'         => 'Content',
     *    'creativeCommons' => 'CreativeCommons',
     *    'dc'              => 'DublinCore',
     *    'geo'             => 'Geo',
     *    'itunes'          => 'iTunes'
     * );
     * </code>
     *
     * If the function {@link registerModule} was used to add another supported
     * module type to ezcFeed, it will show up in the returned array as well.
     *
     * @return array(string=>string)
     */
    public static function getSupportedModulesPrefixes()
    {
        return self::$supportedModulesPrefixes;
    }

    /**
     * Returns the feed type of this feed object (eg. 'rss2').
     *
     * @return string
     */
    public function getFeedType()
    {
        return $this->feedType;
    }

    /**
     * Returns the feed content type of this feed object
     * (eg. 'application/rss+xml').
     *
     * @return string
     */
    public function getContentType()
    {
        return $this->contentType;
    }

    /**
     * Adds the feed type $name to the supported list of feed types.
     *
     * After registering a feed type, it can be used to create or parse feed
     * documents.
     *
     * Example of creating a feed with a user-defined type:
     * <code>
     * ezcFeed::registerFeed( 'opml', 'myOpmlHandler');
     *
     * $feed = new ezcFeed( 'opml' );
     * // add properties for the Opml feed type to $feed
     * </code>
     *
     * In the above example, myOpmlHandler extends {@link ezcFeedProcessor}
     * and implements {@link ezcFeedParser}.
     *
     * @param string $name The feed type (eg. 'opml' )
     * @param string $class The handler class for this feed type (eg. 'myOpmlHandler')
     */
    public static function registerFeed( $name, $class )
    {
        self::$supportedFeedTypes[$name] = $class;
    }

    /**
     * Removes a previously registered feed type from the list of supported
     * feed types.
     *
     * @param string $name The name of the feed type to remove (eg. 'opml')
     */
    public static function unregisterFeed( $name )
    {
        if ( isset( self::$supportedFeedTypes[$name] ) )
        {
            unset( self::$supportedFeedTypes[$name] );
        }
    }

    /**
     * Adds the module $name to the supported list of modules.
     *
     * After registering a module, it can be used to create or parse feed
     * documents.
     *
     * Example of creating a feed with a user-defined module:
     * <code>
     * ezcFeed::registerModule( 'Slash', 'mySlashHandler', 'slash');
     *
     * $feed = new ezcFeed( 'rss2' );
     * $item = $feed->add( 'item' );
     * $slash = $item->addModule( 'Slash' );
     * // add properties for the Slash module to $slash
     * </code>
     *
     * @param string $name The module name (eg. 'Slash' )
     * @param string $class The handler class for this module (eg. 'mySlashHandler')
     * @param string $namespacePrefix The XML namespace prefix for this module (eg. 'slash')
     */
    public static function registerModule( $name, $class, $namespacePrefix )
    {
        self::$supportedModules[$name] = $class;
        self::$supportedModulesPrefixes[$namespacePrefix] = $name;
    }

    /**
     * Removes a previously registered module from the list of supported modules.
     *
     * @param string $name The name of the module to remove (eg. 'Slash')
     */
    public static function unregisterModule( $name )
    {
        if ( isset( self::$supportedModules[$name] ) )
        {
            $namePrefix = null;
            foreach ( self::$supportedModulesPrefixes as $prefix => $module )
            {
                if ( $module === $name )
                {
                    $namePrefix = $prefix;
                    break;
                }
            }
            unset( self::$supportedModulesPrefixes[$prefix] );
            unset( self::$supportedModules[$name] );
        }
    }

    /**
     * Parses the $xml object by dispatching it to the processor that can
     * handle it.
     *
     * @throws ezcFeedParseErrorException
     *         If the $xml object could not be parsed by any available processor.
     *
     * @param DOMDocument $xml The XML object to parse
     * @return ezcFeed
     */
    private static function dispatchXml( DOMDocument $xml )
    {
        if ( count( self::getSupportedTypes() ) === 0 )
        {
            self::initSupportedTypes();
        }

        foreach ( self::getSupportedTypes() as $feedType => $feedClass )
        {
            $canParse = call_user_func( array( $feedClass, 'canParse' ), $xml );
            if ( $canParse === true )
            {
                $processor = new $feedClass;
                return $processor->parse( $xml );
            }
        }

        throw new ezcFeedParseErrorException( $xml->documentURI, 'Feed type not recognized' );
    }

    /**
     * Initializes the supported feed types and modules to the default values.
     */
    private static function initSupportedTypes()
    {
        self::registerFeed( 'rss1', 'ezcFeedRss1' );
        self::registerFeed( 'rss2', 'ezcFeedRss2' );
        self::registerFeed( 'atom', 'ezcFeedAtom' );

        self::registerModule( 'Content', 'ezcFeedContentModule', 'content' );
        self::registerModule( 'CreativeCommons', 'ezcFeedCreativeCommonsModule', 'creativeCommons' );
        self::registerModule( 'DublinCore', 'ezcFeedDublinCoreModule', 'dc' );
        self::registerModule( 'Geo', 'ezcFeedGeoModule', 'geo' );
        self::registerModule( 'iTunes', 'ezcFeedITunesModule', 'itunes' );
    }
}
?>
