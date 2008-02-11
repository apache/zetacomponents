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
        if ( in_array( $name, $this->schema[$this->level] ) )
        {
            $this->properties[$name] = $value;
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
        if ( in_array( $name, $this->schema[$this->level] ) )
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
        if ( in_array( $name, $this->schema[$this->level] ) )
        {
            return isset( $this->properties[$name] );
        }
        else
        {
            return false;
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
     * Parses the $value and returns a converted value if required based on $name.
     *
     * @param string $name The name of the element belonging to the module
     * @param mixed $value The value which needs to be converted
     * @return mixed
     */
    abstract public function parse( $name, $value );

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
