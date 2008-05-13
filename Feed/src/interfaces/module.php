<?php
/**
 * File containing the ezcFeedModule class.
 *
 * @package Feed
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @filesource
 */

/**
 * Container for feed module data.
 *
 * Currently implemented by these feed modules:
 *  - Content ({@link ezcFeedContentModule}) -
 *    {@link http://purl.org/rss/1.0/modules/content/ Specifications}
 *  - DublinCore ({@link ezcFeedDublinCoreModule}) -
 *    {@link http://dublincore.org/documents/dces/ Specifications}
 *  - iTunes ({@link ezcFeedITunesModule}) -
 *    {@link http://www.apple.com/itunes/store/podcaststechspecs.html Specifications}
 *  - Geo ({@link ezcFeedGeoModule}) -
 *    {@link http://www.w3.org/2003/01/geo/ Specifications}
 *  - CreativeCommons ({@link ezcFeedCreativeCommonsModule}) -
 *    {@link http://backend.userland.com/creativeCommonsRssModule Specifications}
 *
 * The child classes must implement these static methods:
 *  - getModuleName() - Returns the module name (eg. 'DublinCore')
 *  - getNamespace() - Returns the namespace for the module
 *    (eg. 'http://purl.org/dc/elements/1.1/').
 *  - getNamespacePrefix() - Returns the namespace prefix for the module (eg. 'dc').
 *
 * @package Feed
 * @version //autogentag//
 */
abstract class ezcFeedModule
{
    /**
     * The level of the module data container. Possible values are 'feed' or 'item'.
     *
     * @var string
     * @ignore
     */
    protected $level;

    /**
     * Holds the properties of this class.
     *
     * @var array(string=>mixed)
     */
    protected $properties = array();

    /**
     * Constructs a new ezcFeedModule object.
     *
     * @param string $level The level of the data container ('feed' or 'item')
     */
    public function __construct( $level = 'feed' )
    {
        $this->level = $level;
    }

    /**
     * Sets the property $name to $value.
     *
     * @param string $name The property name
     * @param mixed $value The property value
     * @ignore
     */
    public function __set( $name, $value )
    {
        if ( $this->isElementAllowed( $name ) )
        {
            $node = $this->add( $name );
            $node->set( $value );
        }
        else
        {
            throw new ezcBasePropertyNotFoundException( $name );
        }
    }

    /**
     * Returns the value of property $name.
     *
     * @param string $name The property name
     * @return mixed
     * @ignore
     */
    public function __get( $name )
    {
        if ( $this->isElementAllowed( $name ) )
        {
            return $this->properties[$name];
        }
        else
        {
            throw new ezcBasePropertyNotFoundException( $name );
        }
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
        if ( $this->isElementAllowed( $name ) )
        {
            return isset( $this->properties[$name] );
        }
        else
        {
            return false;
        }
    }

    /**
     * Returns true if the element $name is allowed in the current module at the
     * current level (feed or item), and false otherwise.
     *
     * @param string $name The element name to check if allowed in the current module and level (feed or item)
     * @return bool
     */
    public function isElementAllowed( $name )
    {
        return isset( $this->schema[$this->level][$name] );
    }

    /**
     * Adds a new ezcFeedElement element with name $name to this module and
     * returns it.
     *
     * @throws ezcFeedUnsupportedElementException
     *         if trying to add an element which is not supported.
     *
     * @param string $name The element name
     * @return ezcFeedElement
     */
    public function add( $name )
    {
        if ( $this->isElementAllowed( $name ) )
        {
            $node = new ezcFeedElement( $this->schema[$this->level][$name] );
            $this->properties[$name][] = $node;
            return $node;
        }
        else
        {
            throw new ezcFeedUnsupportedElementException( $name );
        }
    }

    /**
     * Returns a new instance of the $name module with data container level $level.
     *
     * @param string $name The name of the module to create
     * @param string $level The level of the data container ('feed' or 'item')
     * @return ezcFeedModule
     */
    public static function create( $name, $level = 'feed' )
    {
        $supportedModules = ezcFeed::getSupportedModules();

        if ( !isset( $supportedModules[$name] ) )
        {
            throw new ezcFeedUnsupportedModuleException( $name );
        }

        return new $supportedModules[$name]( $level );
    }

    /**
     * Adds the module elements to the $xml XML document, in the container $root.
     *
     * @param DOMDocument $xml The XML document in which to add the module elements
     * @param DOMNode $root The parent node which will contain the module elements
     */
    abstract public function generate( DOMDocument $xml, DOMNode $root );

    /**
     * Parses the XML element $node and creates a feed element in the current
     * module with name $name.
     *
     * @param string $name The name of the element belonging to the module
     * @param DOMElement $node The XML child from which to take the values for $name
     */
    abstract public function parse( $name, DOMElement $node );
}
?>
