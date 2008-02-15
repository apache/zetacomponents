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
 *  - Content ({@link ezcFeedContentModule})
 *  - DublinCore ({@link ezcFeedDublinCoreModule})
 *
 * @package Feed
 * @version //autogentag//
 */
abstract class ezcFeedModule
{
    /**
     * The level of the module data container. Possible values are 'feed' or 'item.
     *
     * @var string
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
        if ( isset( $this->schema[$this->level][$name] ) )
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
        if ( isset( $this->schema[$this->level][$name] ) )
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
        if ( isset( $this->schema[$this->level][$name] ) )
        {
            return isset( $this->properties[$name] );
        }
        else
        {
            return false;
        }
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
        if ( isset( $this->schema[$this->level][$name] ) )
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
    abstract public function parse( $name, $node );

    /** 
     * Returns the module name.
     *
     * @return string
     */
    abstract public function getModuleName();

    /**
     * Returns the namespace for this module.
     *
     * @return string
     */
    abstract public function getNamespace();

    /**
     * Returns the namespace prefix for this module.
     *
     * @return string
     */
    abstract public function getNamespacePrefix();
}
?>
