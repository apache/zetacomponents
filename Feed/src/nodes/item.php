<?php
/**
 * File containing the ezcFeedItem class.
 *
 * @package Feed
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @filesource
 */

/**
 * Container for item data.
 *
 * @package Feed
 * @version //autogentag//
 * @mainclass
 */
class ezcFeedItem extends ezcFeedElement
{
    /**
     * Holds the modules used by this feed item.
     *
     * @var array(ezcFeedModule)
     */
    protected $modules = array();

    /**
     * Constructs a new ezcFeedElement object.
     *
     * @param array(string=>mixed) $schema The sub-schema that defines this element
     */
    public function __construct( array $schema )
    {
        $this->schema = $schema;
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
        $supportedModules = ezcFeed::getSupportedModules();
        if ( isset( $supportedModules[$name] ) )
        {
            $this->modules[$name] = $value;
            return;
        }
        parent::__set( $name, $value );
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
        $supportedModules = ezcFeed::getSupportedModules();
        if ( isset( $supportedModules[$name] ) )
        {
            if ( isset( $this->$name ) )
            {
                return $this->modules[$name];
            }
            else
            {
                throw new ezcFeedUndefinedModuleException( $name );
            }
        }
        return parent::__get( $name );
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
        $supportedModules = ezcFeed::getSupportedModules();
        if ( isset( $supportedModules[$name] ) )
        {
            return isset( $this->modules[$name] );
        }
        return parent::__isset( $name );
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
        $this->$name = ezcFeedModule::create( $name, 'item' );
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
        return isset( $this->modules[$name] );
    }

    /**
     * Returns an array with all the modules defined for this feed item.
     *
     * @return array(ezcFeedModule)
     */
    public function getModules()
    {
        return $this->modules;
    }
}
?>
