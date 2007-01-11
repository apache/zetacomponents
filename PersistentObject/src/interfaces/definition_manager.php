<?php
/**
 * File containing the ezcPersistentDefinitionManager class
 *
 * @package PersistentObject
 * @version //autogen//
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Defines the interface for all persistent object definition managers.
 *
 * Definition managers are used to fetch the definition of a specific
 * persistent object. The definition is returned in form of a
 * ezcPersistentObjectDefinition structure.
 *
 * @package PersistentObject
 */
abstract class ezcPersistentDefinitionManager
{
    /**
     * Returns the definition of the persistent object with the class $class.
     *
     * @throws ezcPersistentDefinitionNotFoundException if no such definition can be found.
     * @param string $class
     * @return ezcPersistentDefinition
     */
    public abstract function fetchDefinition( $class );

    // public function storeDefinition( ezcPersistentDefinition $def );

    /**
     * Returns the definition $def with the reverse relations field correctly set up.
     *
     * This method will go through all of the properties in the definition and set up
     * the columns field in the definition.
     *
     * @param ezcPersistentObjectDefinintion $def The target persistent object definition.
     * @return ezcPersistentObjectDefinition
     */
    protected static function setupReversePropertyDefinition( ezcPersistentObjectDefinition $def )
    {
        foreach ( $def->properties as $field )
        {
            $def->columns[$field->columnName] = $field;
        }
        if ( isset( $def->idProperty ) )
        {
            $def->columns[$def->idProperty->columnName] = $def->idProperty;
        }
        return $def;
    }
}
?>
