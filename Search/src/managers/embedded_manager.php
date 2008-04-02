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
 * Handles document type definitions in XML format.
 *
 * Each definition must be in a separate file in the directory specified to the
 * constructor. The filename must be the same as the lowercase name of the
 * document type with .xml appended. Each file should return the definition of
 * one document type.
 *
 * Example exampleclass.xml:
 * <code>
 * <?xml version="1.0" charset="utf-8"?>
 * <document>
 *   <field type="id">id</field>
 *   <field type="string" boost="2">title</field>
 *   <field type="text">description</field>
 * </document>
 * </code>
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

    private $typeMap = array(
        'id' => ezcSearchDocumentDefinition::STRING,
        'string' => ezcSearchDocumentDefinition::STRING,
        'text' => ezcSearchDocumentDefinition::TEXT,
        'html' => ezcSearchDocumentDefinition::HTML,
        'date' => ezcSearchDocumentDefinition::DATE,
    );

    /**
     * Constructs a new XML manager that will look for search document definitions in the directory $dir.
     */
    public function __construct()
    {
    }

    /**
     * Returns the definition of the search document with the type $type.
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

        // store in cache
        $this->cache[$type] = $definition;

        // return
        return $definition;
    }
}

?>
