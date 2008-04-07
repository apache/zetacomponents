<?php
/**
 * File containing the ezcSearchCodeManager class
 *
 * @package Search
 * @version //autogen//
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Handles document type definitions in plain code (PHP script) style.
 *
 * Each definition must be in a separate file in the directory specified to the
 * constructor. The filename must be the same as the lowercase name of the
 * document type with .php appended. Each file should return the definition of
 * one document type.
 *
 * Example exampleclass.php:
 * <code>
 * <?php
 * $definition = new ezcSearchDocumentDefinition;
 * return $definition;
 * ?>
 * </code>
 *
 * @version //autogen//
 * @package Search
 */
class ezcSearchCodeManager implements ezcSearchDefinitionManager
{
    /**
     * Holds the path to the directory where the definitions are stored.
     *
     * @var string
     */
    private $dir;

    /**
     * Holds the search document definitions that are currently cached.
     *
     * @var array(string=>ezcSearchDocumentDefinition)
     */
    private $cache = array();

    /**
     * Constructs a new code manager that will look for search document definitions in the directory $dir.
     *
     * @param string $dir
     */
    public function __construct( $dir )
    {
        // append trailing / to $dir if it does not exist.
        if ( substr( $dir, -1 ) != DIRECTORY_SEPARATOR )
        {
            $dir .= DIRECTORY_SEPARATOR;
        }
        $this->dir = $dir;
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
        $definition = null;
        $path = $this->dir . strtolower( $type ) . '.php';
        if ( file_exists( $path ) )
        {
            $definition = require $path;
        }
        if ( !( $definition instanceof ezcSearchDocumentDefinition ) )
        {
            throw new ezcSearchDefinitionNotFoundException( $type, "Searched for '" . realpath( dirname( $path ) ) . "/" . basename( $path ) . "'." );
        }
        if ( $definition->idProperty === null )
        {
            throw new ezcSearchDefinitionMissingIdPropertyException( $type );
        }

        // store in cache
        $this->cache[$type] = $definition;

        // return
        return $definition;
    }
}

?>
