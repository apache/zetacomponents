<?php
/**
 * File containing the ezcTemplateAutoloader class
 *
 * @package Template
 * @version //autogen//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * Base class for template autoloaders.
 *
 * The autoloader is a system which creates objects for handling the specified
 * function, block or resource on demand.
 * This system ensures that as little memory as possible is used by only loading
 * code that will be used in the current request. This is possible since most of
 * the time the template engine will execute already compiled templates.
 *
 * To create a new autoloader the class must be inherited and the abstract
 * functions must be implemented. Also a definition object must be made which
 * points to the location of the autoloader.
 *
 * @note The autoloader system will be invisible for the developer using the
 * template system.
 *
 * @package Template
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogen//
 */
class ezcTemplateAutoloader
{

    /**
     * The definition object which points to the current class.
     * @note __get property
     */
    // private $definition;

    /**
     * An array containing the properties of this object.
     * definition - The definition object which points to the current class.
     */
    private $properties = array( 'definition' => null );

    /**
     * Property get
     */
    public function __get( $name )
    {
        switch( $name )
        {
            case 'definition':
                return $this->properties[$name];
            default:
                throw new ezcBasePropertyNotFoundException( $name );
        }
    }

    /**
     * Property isset
     */
    public function __isset( $name )
    {
        switch( $name )
        {
            case 'definition':
                return true;
            default:
                return false;
        }
    }

    /**
     * Initializes the loader with the definition object.
     *
     * @param ezcTemplateAutoloaderDefinition $definition The object containing the
     * loader definition.
     */
    public function __construct( ezcTemplateAutoloaderDefinition $definition )
    {
    }

    /**
     * Returns an array of function names which this loader can instantiate.
     *
     */
    public function getFunctionHandlers(  )
    {
    }

    /**
     * Returns an array of block names which this loader can instantiate.
     *
     */
    public function getBlockHandlers(  )
    {
    }

    /**
     * Returns an array of resource names which this loader can instantiate.
     *
     */
    public function getResourceHandlers(  )
    {
    }

    /**
     * Creates a new instance of the specified function handler and returns it.
     *
     * @param string $name The name of the function which is needed.
     */
    public function instantiateFunctionHandler( $name )
    {
    }

    /**
     * Creates a new instance of the specified block handler and returns it.
     *
     * @param string $name The name of the block which is needed.
     */
    public function instantiateBlockHandler( $name )
    {
    }

    /**
     * Creates a new instance of the specified resource handler and returns it.
     *
     * @param string $name The name of the resource which is needed.
     */
    public function instantiateResourceHandler( $name )
    {
    }

}
?>
