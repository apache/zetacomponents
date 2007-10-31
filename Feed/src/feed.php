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
 * A feed has a type (eg. RSS1, RSS2 or ATOM). The feed type defines which
 * processor is used to parse and generate that type.
 *
 * The following feed processors are supported by the Feed component:
 *  - RSS1 ({@link ezcFeedRss1}) -
 *    {@link http://web.resource.org/rss/1.0/spec Specifications}
 *  - RSS2 ({@link ezcFeedRss2}) -
 *    {@link http://www.rssboard.org/rss-specification Specifications}
 *  - ATOM ({@link ezcFeedAtom}) -
 *    {@link http://atompub.org/rfc4287.html RFC4287}
 *
 * A new processor can be defined by creating a class which extends the class
 * {@link ezcFeedProcessor} and implements the interface {@link ezcFeedParser},
 * and adding it to the {@link self::$supportedFeedTypes} array.
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
 *  - set/get a value from the feed document. Example:
 *  <code>
 *  $feed->title = 'News';
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
 *  - generate an XML document from the {@link ezcFeed} object. Example:
 *  <code>
 *  $xml = $feed->generate();
 *  </code>
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
 *
 * @package Feed
 * @version //autogentag//
 * @mainclass
 */
class ezcFeed
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
     * @param string $property The property name
     * @param mixed $value The property value
     * @ignore
     */
    public function __set( $property, $value )
    {
        switch ( $property )
        {
            case 'title': // required in RSS1, RSS2, ATOM
            case 'category':
            case 'categories':
            case 'subtitle': // ATOM only
            case 'link': // required in RSS2, rdf:about AND link in RSS1
            case 'links': // required in RSS2, rdf:about AND link in RSS1
            case 'description': // required in RSS1, RSS2
            case 'language':
            case 'copyright': // rights in ATOM
            case 'author': // managingEditor in RSS2, required in ATOM
            case 'webMaster': // RSS2 only
            case 'published': // pubDate in RSS2
            case 'updated':   // lastBuildDate in RSS2, required in ATOM
            case 'generator':
            case 'ttl':
            case 'id': // ATOM only, required in ATOM
            case 'image': // icon in ATOM
            case 'docs':
            case 'skipHours': // optional in RSS2
            case 'skipDays': // optional in RSS2
            case 'rating':
            case 'textInput':
                $this->feedProcessor->set( $property, $value );
                break;

            default:
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
            case 'category':
            case 'categories':
            case 'subtitle': // ATOM only
            case 'link': // required in RSS2, rdf:about AND link in RSS1
            case 'links': // required in RSS2, rdf:about AND link in RSS1
            case 'description': // required in RSS1, RSS2
            case 'language':
            case 'copyright': // rights in ATOM
            case 'author': // managingEditor in RSS2, required in ATOM
            case 'webMaster': // RSS2 only
            case 'published': // pubDate in RSS2
            case 'updated':   // lastBuildDate in RSS2, required in ATOM
            case 'generator':
            case 'ttl':
            case 'id': // ATOM only, required in ATOM
            case 'item':
            case 'items':
            case 'image': // icon in ATOM
            case 'docs':
            case 'skipHours': // optional in RSS2
            case 'skipDays': // optional in RSS2
            case 'rating':
            case 'textInput':
                $value = $this->feedProcessor->get( $property );
                return $value;

            default:
                throw new ezcBasePropertyNotFoundException( $property );
        }
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
            throw new ezcFeedCanNotParseException( $uri, "{$uri} is not a valid XML file" );
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
        $xml = new DOMDocument();
        $retval = @$xml->loadXML( $content );
        if ( $retval === false )
        {
            throw new ezcFeedParseErrorException( "Content is no valid XML" );
        }

        return self::dispatchXml( $xml );
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
     * @ignore
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
}
?>
