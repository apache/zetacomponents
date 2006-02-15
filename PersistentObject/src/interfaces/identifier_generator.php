<?php

/**
 * File containing the ezcPersistentIdentifierGenerator class
 *
 * @package PersistentObject
 * @version //autogen//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * This interface between the class that generates unique identifiers when creating new objects and the session.
 *
 * Implement this interface if you want a new strategy for generating unique identifier.
 * This interface is not intended to be exposed to the application.
 *
 * Implementations should accept any parameters through a associative array in the
 * constructor:
 * <code>
 * public function __construct( array $params );
 * </code>
 *
 * The structure of the parameters is array( 'parameter_name' => 'parameter_value' ).
 *
 * @package PersistentObject
 * @access private
 */
interface ezcPersistentIdentifierGenerator
{
    /**
     * Called prior to executing the insert query that saves the data to the database.
     *
     * All the data has been set on the query prior to calling this method.
     *
     * @param ezcPersistentObjectDefinition $def
     * @param ezcDbHandler $db
     * @param ezcQueryInsert $q
     * @return void
     */
    public function preSave( ezcPersistentObjectDefinition $def, ezcDbHandler $db, ezcQueryInsert $q );

    /**
     * Returns the integer value of the generated identifier for the new object.
     *
     * Called right after execution of the insert query.
     * Returns null if it was not possible to generate a new ID.
     *
     * @param ezcPersistentObjectDefinition $def
     * @param ezcDbHandler $db
     * @return int
     */
    public function postSave( ezcPersistentObjectDefinition $def, ezcDbHandler $db );
}

?>
