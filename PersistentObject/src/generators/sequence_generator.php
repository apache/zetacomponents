<?php
/**
 * File containing the ezcPersistentSequenceGenerator class
 *
 * @package PersistentObject
 * @version //autogen//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Generates IDs based on the PDO::lastInsertId method.
 *
 * It is recommended to use auto_increment id columns for databases supporting
 * it. This includes MySQL and SQLite. Use {@link ezcPersistentNativeGenerator}
 * for those!
 *
 * For none auto_increment databases:
 * <code>
 * CREATE TABLE test ( id integer unsigned not null, PRIMARY KEY (id ));
 * CREATE SEQUENCE test_seq START 1;
 * </code>
 *
 * This class reads the parameters:
 * - sequence - The name of the database sequence keeping track of the ID. This field should be ommited for databases
 *              supporting auto_increment.
 *
 * @package PersistentObject
 *
 * @apichange The usage of this generator for MySQL is deprecated. Use
 *            {@link ezcPersistentNativeGenerator} instead.
 */
class ezcPersistentSequenceGenerator extends ezcPersistentIdentifierGenerator
{
    /**
     * Fetches the next sequence value for PostgreSQL and Oracle implementations.
     * Fetches the next sequence value for PostgreSQL and Oracle implementations.
     * Dispatches to {@link ezcPersistentNativeGenerator} for MySQL.
     *
     * @param ezcPersistentObjectDefinition $def
     * @param ezcDbHandler $db
     * @param ezcQueryInsert $q
     * @return void
     */
    public function preSave( ezcPersistentObjectDefinition $def, ezcDbHandler $db, ezcQueryInsert $q )
    {
        if ( $db->getName() == "mysql" )
        {
            $native = new ezcPersistentNativeGenerator();
            return $native->preSave( $def, $db, $q );
        }
        if ( ( $db->getName() == 'pgsql' || $db->getName() == 'oracle' ) &&
            array_key_exists( 'sequence', $def->idProperty->generator->params ) )
        {
            $seq = $def->idProperty->generator->params['sequence'];
            $q->set( $def->idProperty->columnName, "nextval('{$seq}')" );
        }
    }

    /**
     * Returns the integer value of the generated identifier for the new object.
     * Called right after execution of the insert query.
     * Dispatches to {@link ezcPersistentNativeGenerator} for MySQL.
     *
     * @param ezcPersistentObjectDefinition $def
     * @param ezcDbHandler $db
     * @return int
     */
    public function postSave( ezcPersistentObjectDefinition $def, ezcDbHandler $db )
    {
        if ( $db->getName() == "mysql" || $db->getName() == "sqlite" )
        {
            $native = new ezcPersistentNativeGenerator();
            return $native->postSave( $def, $db );
        }
        $id = null;
        if ( array_key_exists( 'sequence', $def->idProperty->generator->params ) &&
            $def->idProperty->generator->params['sequence'] !== null )
        {
            $id = (int)$db->lastInsertId( $def->idProperty->generator->params['sequence'] );
        }
        else
        {
            $id = (int)$db->lastInsertId();
        }
        // check that the value was in fact successfully received.
        if ( $db->errorCode() != 0 )
        {
            return null;
        }
        return $id;
    }
}

?>
