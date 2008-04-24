<?php
/**
 * File containing the ezcSearchEmbeddedManager class
 *
 * @package Search
 * @version //autogen//
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Handles document type definitions embedded in the class the definitions are for.
 *
 * It calls the fetchDefinition() method on the class in order to retrieve the
 * definition. This method is required to return an ezcSearchDocumentDefinition
 * object. The method is part of the interface ezcSearchDefinitionProvider.
 *
 * @version //autogen//
 * @package Search
 */
class ezcSearchEmbeddedManager implements ezcSearchDefinitionManager
{
    /**
     * Holds the search document definitions that are currently cached.
     *
     * @var array(string=>ezcSearchDocumentDefinition)
     */
    private $cache = array();

    /**
     * Constructs a new embedded manager.
     */
    public function __construct()
    {
    }

    /**
     * Returns the definition of the search document with the type $type.
     *
     * TODO: CHeck if the class implements ezcSearchDefinitionProvider.
     *
     * @throws ezcSearchDefinitionNotFoundException if no such definition can be found.
     * @throws ezcSearchDefinitionMissingIdPropertyException
     *         if the definition does not have an "idProperty" attribute.
     * @param string $type
     * @return ezcSearchDocumentDefinition
     */
    public function fetchDefinition( $type )
    {
        // check the cache
        if ( isset( $this->cache[$type] ) )
        {
            return $this->cache[$type];
        }

        // load definition
        $definition = call_user_func( array( $type, 'fetchDefinition' ) );

        if ( $definition->idProperty === null )
        {
            throw new ezcSearchDefinitionInvalidException( 'embed', $type, 'internal', 'Missing ID property' );
        }

        // store in cache
        $this->cache[$type] = $definition;

        // return
        return $definition;
    }
}

?>
