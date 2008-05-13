<?php
/**
 * File containing the ezcFeedProcessor class.
 *
 * @package Feed
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @filesource
 */

/**
 * Base class for all feed processors.
 *
 * Currently implemented for these feed types:
 *  - RSS1 ({@link ezcFeedRss1})
 *  - RSS2 ({@link ezcFeedRss2})
 *  - ATOM ({@link ezcFeedAtom})
 *
 * @package Feed
 * @version //autogentag//
 */
abstract class ezcFeedProcessor
{
    /**
     * Holds the feed type (eg. 'rss1').
     *
     * @var string
     * @ignore
     */
    protected $feedType;

    /**
     * Holds the schema for this feed type.
     *
     * @var string
     * @ignore
     */
    protected $schema;

    /**
     * Holds the feed content type (eg. 'application/rss+xml').
     *
     * @var string
     * @ignore
     */
    protected $contentType;

    /**
     * Holds the XML document which is being generated.
     *
     * @var DOMDocument
     * @ignore
     */
    protected $xml;

    /**
     * Holds the root node of the XML document being generated.
     *
     * @var DOMNode
     * @ignore
     */
    protected $root;

    /**
     * Holds the channel element of the XML document being generated.
     *
     * @var DOMElement
     * @ignore
     */
    protected $channel;

    /**
     * Holds the feed elements (ezcFeedElement).
     *
     * @var array(string=>mixed)
     * @ignore
     */
    protected $elements;

    /**
     * Holds the modules used by this feed item.
     *
     * @var array(ezcFeedModule)
     * @ignore
     */
    protected $modules = array();

    /**
     * Holds the prefixes used in the feed generation process.
     *
     * @var array(string)
     * @ignore
     */
    protected $usedPrefixes = array();

    /**
     * Sets the value of element $name to $value based on the feed schema.
     *
     * @param string $name The element name
     * @param mixed $value The new value for the element $name
     * @ignore
     */
    public function __set( $name, $value )
    {
        $name = ezcFeedTools::normalizeName( $name, $this->schema->getElementsMap() );
        if ( !isset( $this->elements[$name] ) )
        {
            if ( $this->schema->isMulti( $name ) )
            {
                $this->elements[$this->schema->getMulti( $name )] = array();
            }
            else if ( $this->schema->isAttribute( $name ) )
            {
                $this->elements[$name] = $value;
                return;
            }
            else
            {
                $this->elements[$name] = new ezcFeedElement( $this->schema->getSchema( $name ) );
            }
        }
        if ( $this->schema->isMulti( $name ) )
        {
            $this->elements[$this->schema->getMulti( $name )][0]->set( $value );
        }
        else
        {
            $this->elements[$name]->set( $value );
        }
    }

    /**
     * Returns the value of element $name based on the feed schema.
     *
     * @param string $name The element name
     * @return mixed
     * @ignore
     */
    public function __get( $name )
    {
        $name = ezcFeedTools::normalizeName( $name, $this->schema->getElementsMap() );
        if ( isset( $this->elements[$name] ) )
        {
            return $this->elements[$name];
        }

        if ( $this->schema->isMulti( $name ) )
        {
            return isset( $this->elements[$this->schema->getMulti( $name )][0] ) ? $this->elements[$this->schema->getMulti( $name )][0] : null;
        }

        return null;
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
        $name = ezcFeedTools::normalizeName( $name, $this->schema->getElementsMap() );
        return isset( $this->elements[$name] );
    }

    /**
     * Returns an XML string from the feed information contained in this
     * processor.
     *
     * @return string
     */
    abstract public function generate();

    /**
     * Adds a new ezcFeedElement element with name $name and returns it, if the
     * feed schema allows this (returns null if the schema does not allow it).
     *
     * @param string $name The element name
     * @return ezcFeedElement|null
     */
    public function add( $name )
    {
        $className = ( $name === 'item' ) ? 'ezcFeedItem' : 'ezcFeedElement';
        $name = ezcFeedTools::normalizeName( $name, $this->schema->getElementsMap() );

        if ( $this->schema->isMulti( $name ) )
        {
            $element = new $className( $this->schema->getSchema( $name ) );
            $this->elements[$this->schema->getMulti( $name )][] = $element;
            return $element;
        }
        else
        {
            $element = new $className( $this->schema->getSchema( $name ) );
            $this->elements[$name] = $element;
            return $element;
        }
    }

    /**
     * Returns true if the module $name is loaded, false otherwise.
     *
     * @param string $name The name of the module to check if loaded at feed-level
     * @return bool
     */
    public function hasModule( $name )
    {
        return isset( $this->modules[$name] );
    }

    /**
     * Returns the loaded module $name.
     *
     * @param string $name The name of the module to return
     * @return ezcFeedModule
     */
    public function getModule( $name )
    {
        return $this->modules[$name];
    }

    /**
     * Returns an array with all the modules loaded at feed-level.
     *
     * @return array(ezcFeedModule)
     */
    public function getModules()
    {
        return $this->modules;
    }

    /**
     * Associates the module $module with the name $name.
     *
     * @param string $name The name of the module associate
     * @param ezcFeedModule $module The module to set under the name $name
     */
    public function setModule( $name, ezcFeedModule $module )
    {
        $this->modules[$name] = $module;
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
     * Creates a node in the XML document being generated with name $element
     * and value(s) $value.
     *
     * @param DOMNode $root The root in which to create the node $element
     * @param string $element The name of the XML element
     * @param mixed|array(mixed) $value The value(s) for $element
     * @ignore
     */
    protected function generateMetaData( DOMNode $root, $element, $value )
    {
        if ( !is_array( $value ) )
        {
            $value = array( $value );
        }
        foreach ( $value as $valueElement )
        {
            $meta = $this->xml->createElement( $element, ( $valueElement instanceof ezcFeedElement ) ? $valueElement->__toString() : (string)$valueElement );
            $root->appendChild( $meta );
        }
    }

    /**
     * Creates elements in the XML document being generated with name $element
     * and value(s) $value.
     *
     * @param DOMNode $root The root in which to create the node $element
     * @param string $element The name of the XML element
     * @param mixed|array(mixed) $value The value(s) for $element
     * @param array(string=>mixed) $attributes The attributes to add to the node
     * @ignore
     */
    protected function generateMetaDataWithAttributes( DOMNode $root, $element, $value = false, array $attributes )
    {
        if ( !is_array( $value ) )
        {
            $value = array( $value );
        }
        foreach ( $value as $valueElement )
        {
            if ( $valueElement === false )
            {
                $meta = $this->xml->createElement( $element );
            }
            else
            {
                $meta = $this->xml->createElement( $element, ( $valueElement instanceof ezcFeedElement ) ? $valueElement->__toString() : (string)$valueElement );
            }
            foreach ( $attributes as $attrName => $attrValue )
            {
                $attr = $this->xml->createAttribute( $attrName );
                $text = $this->xml->createTextNode( $attrValue );
                $attr->appendChild( $text );
                $meta->appendChild( $attr );
            }
            $root->appendChild( $meta );
        }
    }

    /**
     * Creates elements for all modules loaded at item-level, and adds the
     * namespaces required by the modules in the XML document being generated.
     *
     * @param ezcFeedItem $item The feed item containing the modules
     * @param DOMElement $node The XML element in which to add the module elements
     * @ignore
     */
    protected function generateModules( $item, DOMElement $node )
    {
        foreach ( ezcFeed::getSupportedModules() as $module => $class )
        {
            if ( $item->hasModule( $module ) )
            {
                $this->addAttribute( $this->root, 'xmlns:' . $item->$module->getNamespacePrefix(), $item->$module->getNamespace() );
                $item->$module->generate( $this->xml, $node );
            }
        }
    }

    /**
     * Creates elements for all modules loaded at feed-level, and adds the
     * namespaces required by the modules in the XML document being generated.
     *
     * @param DOMElement $node The XML element in which to add the module elements
     * @ignore
     */
    protected function generateFeedModules( DOMElement $node )
    {
        foreach ( ezcFeed::getSupportedModules() as $module => $class )
        {
            if ( $this->hasModule( $module ) )
            {
                $this->addAttribute( $this->root, 'xmlns:' . $this->modules[$module]->getNamespacePrefix(), $this->modules[$module]->getNamespace() );
                $this->modules[$module]->generate( $this->xml, $node );
            }
        }
    }

    /**
     * Parses the XML element $node and creates modules in the feed or
     * feed item $item.
     *
     * @param ezcFeedItem|ezcFeed $item The feed or feed item which will contain the modules
     * @param DOMElement $node The XML element from which to get the module elements
     * @param string $tagName The XML tag name (if it contains ':' it will be considered part of a module)
     * @ignore
     */
    protected function parseModules( $item, DOMElement $node, $tagName )
    {
        $supportedModules = ezcFeed::getSupportedModules();
        if ( strpos( $tagName, ':' ) !== false )
        {
            list( $prefix, $key ) = split( ':', $tagName );
            $moduleName = isset( $this->usedPrefixes[$prefix] ) ? $this->usedPrefixes[$prefix] : null;
            if ( isset( $supportedModules[$moduleName] ) )
            {
                $module = $item->hasModule( $moduleName ) ? $item->$moduleName : $item->addModule( $moduleName );
                $module->parse( $key, $node );
            }
        }
    }

    /**
     * Fetches the supported prefixes and namespaces from the XML document $xml.
     *
     * @param DOMDocument $xml The XML document object to parse
     * @return array(string=>string)
     * @ignore
     */
    protected function fetchUsedPrefixes( DOMDocument $xml )
    {
        $usedPrefixes = array();

        $xp = new DOMXpath( $xml );
        $set = $xp->query( './namespace::*', $xml->documentElement );
        $usedNamespaces = array();

        foreach ( $set as $node )
        {
            foreach ( ezcFeed::getSupportedModules() as $moduleName => $moduleClass )
            {
                $moduleNamespace = call_user_func( array( $moduleClass, 'getNamespace' ) );
                if ( $moduleNamespace === $node->nodeValue )
                {
                    $usedPrefixes[call_user_func( array( $moduleClass, 'getNamespacePrefix' ) )] = $moduleName;
                }
            }
        }

        return $usedPrefixes;
    }

    /**
     * Adds an attribute to the XML node $node.
     *
     * @param DOMNode $node The node to add the attribute to
     * @param string $attribute The name of the attribute to add
     * @param mixed $value The value of the attribute
     * @ignore
     */
    protected function addAttribute( DOMNode $node, $attribute, $value )
    {
        $attr = $this->xml->createAttribute( $attribute );
        $val = $this->xml->createTextNode( $value );
        $attr->appendChild( $val );
        $node->appendChild( $attr );
    }
}
?>
