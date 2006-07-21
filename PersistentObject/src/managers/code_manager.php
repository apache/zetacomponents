<?php
/**
 * File containing the ezcPersistentCodeManager class
 *
 * @package PersistentObject
 * @version //autogen//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Handles persistent object definitions in plain code style.
 *
 * Each definition must be in a separate file in the directory specified to
 * the constructor. The filename must be the same as the lowercase name of the
 * persistent object class with .php appended. Each file should return the definition of one persistent
 * object class.
 *
 * Example exampleclass.php:
 * <code>
 * <?php
 * $definition = new ezcPersistentObjectDefinition;
 * return $definition;
 * ?>
 * </code>
 * @todo should we cache on this level, int the session or in a separate caching manager?
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
     * Holds the loaded persistent object classes as an array of the format:
     * array('class_name_lower_case' => ezcPersistentDefinition )
     *
     * @var array(string=>ezcPersistentDefinition)
     */
//    private $definitions = array();

    /**
     * Constructs a new code manager that will look for persistent object definitions in the directory $dir.
     *
     * @param string $dir
     */
    public function __construct( $dir )
    {
        // append trailing / to $dir if it does not exist.
        if ( substr( $dir, strlen( $dir ) - 1, 1) != '/' )
        {
            $dir .= '/';
        }
        $this->dir = $dir;
    }

    /**
     * Returns the definition of the persistent object with the class $class.
     *
     * @throws ezcPersistentDefinitionNotFoundException if no such definition can be found.
     * @param string $class
     * @return ezcPersistentDefinition
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
                                                                "Searched for <" . realpath( dirname( $path ) ) . "/" . basename( $path ) . ">." );
        }
        $definition = $this->setupReversePropertyDefinition( $definition );
        return $definition;
    }
}

?>
