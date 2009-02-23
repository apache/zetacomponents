<?php
/**
 * File containing the ezcPersistentCodeManager class
 *
 * @package PersistentObject
 * @version //autogen//
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Handles persistent object definitions in plain code style.
 *
 * Each definition must be in a separate file in the directory specified to the
 * constructor. The filename must be the same as the lowercase name of the
 * persistent object class with .php appended. Each file should return the
 * definition of one persistent object class.
 *
 * Example exampleclass.php:
 * <code>
 * <?php
 * $definition = new ezcPersistentObjectDefinition;
 * return $definition;
 * ?>
 * </code>
 *
 * @version //autogen//
 * @package PersistentObject
 */
class ezcPersistentCodeManager extends ezcPersistentDefinitionManager
{
    /**
     * Holds the path to the directory where the definitions are stored.
     *
     * @var string
     */
    private $dir;

    /**
     * Constructs a new code manager that will look for persistent object definitions in the directory $dir.
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
     * Returns the definition of the persistent object with the class $class.
     *
     * @throws ezcPersistentDefinitionNotFoundException if no such definition can be found.
     * @throws ezcPersistentDefinitionMissingIdPropertyException
     *         if the definition does not have an "idProperty" attribute.
     * @param string $class
     * @return ezcPersistentObjectDefinition
     */
    public function fetchDefinition( $class )
    {
        $definition = null;
        $path = $this->dir . strtolower( $class ) . '.php';
        if ( file_exists( $path ) )
        {
            $definition = require $path;
        }
        if ( !( $definition instanceof ezcPersistentObjectDefinition ) )
        {
            throw new ezcPersistentDefinitionNotFoundException( $class,
                                                                "Searched for '" . realpath( dirname( $path ) ) . "/" . basename( $path ) . "'." );
        }
        if ( $definition->idProperty === null )
        {
            throw new ezcPersistentDefinitionMissingIdPropertyException( $class );
        }
        $definition = $this->setupReversePropertyDefinition( $definition );
        return $definition;
    }
}

?>
