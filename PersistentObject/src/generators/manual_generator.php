<?php
/**
 * File containing the ezcPersistentManualGenerator class
 *
 * Licensed to the Apache Software Foundation (ASF) under one
 * or more contributor license agreements.  See the NOTICE file
 * distributed with this work for additional information
 * regarding copyright ownership.  The ASF licenses this file
 * to you under the Apache License, Version 2.0 (the
 * "License"); you may not use this file except in compliance
 * with the License.  You may obtain a copy of the License at
 * 
 *   http://www.apache.org/licenses/LICENSE-2.0
 * 
 * Unless required by applicable law or agreed to in writing,
 * software distributed under the License is distributed on an
 * "AS IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS OF ANY
 * KIND, either express or implied.  See the License for the
 * specific language governing permissions and limitations
 * under the License.
 *
 * @package PersistentObject
 * @version //autogen//
 * @copyright Copyright (C) 2005-2010 eZ Systems AS. All rights reserved.
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 */

/**
 * This identifier generator does not generate any ID's. Instead the user must manually
 * assign an ID when the object is saved.
 *
 * This is useful don't want any automatic id generation.
 *
 * @version //autogen//
 * @package PersistentObject
 */
class ezcPersistentManualGenerator extends ezcPersistentIdentifierGenerator
{
    /**
     * Holds the Id temporily while storing.
     *
     * @var int
     */
    private $id = null;

    /**
     * Returns true if the object is persistent already.
     *
     * Called in the beginning of the save process.
     *
     * Persistent objects that are being saved must not exist in the database already.
     *
     * @param ezcPersistentObjectDefinition $def
     * @param ezcDbHandler $db
     * @param array(key=>value) $state
     * @return void
     */
    public function checkPersistence( ezcPersistentObjectDefinition $def, ezcDbHandler $db, array $state )
    {
        // store id
        $this->id = $state[$def->idProperty->propertyName];

        // check if there is an object with this id already
        $q = $db->createSelectQuery();
        $q->select( '*' )->from(
            $db->quoteIdentifier( $def->table )
        )->where(
            $q->expr->eq(
                $db->quoteIdentifier( $def->idProperty->columnName ),
                $q->bindValue( $this->id, null, $def->idProperty->databaseType )
            )
        );
        try
        {
            $stmt = $q->prepare();
            $stmt->execute();
        }
        catch ( PDOException $e )
        {
            throw new ezcPersistentQueryException( $e->getMessage(), $q );
        }

        $row = $stmt->fetch( PDO::FETCH_ASSOC );
        $stmt->closeCursor();
        if ( $row !== false ) // we got a result
        {
            return true;
        }

        return false;
    }

    /**
     * Sets the correct id on the insert query.
     *
     * @param ezcPersistentObjectDefinition $def
     * @param ezcDbHandler $db
     * @param ezcQueryInsert $q
     * @return void
     */
    public function preSave( ezcPersistentObjectDefinition $def, ezcDbHandler $db, ezcQueryInsert $q )
    {
        // Sanity check.
        // ID must have been stored during the persistence check before inserting the object.
        if ( $this->id === null )
        {
            throw new ezcPersistentIdentifierGenerationException(
                $def->class,
                'ezcPersistentManualGenerator expects the ID to be present before saving.'
            );
        }
        $q->set(
            $db->quoteIdentifier( $def->idProperty->columnName ),
            $q->bindValue( $this->id, null, $def->idProperty->databaseType )
        );
    }

    /**
     * Returns the value of the generated identifier for the new object.
     *
     * Called right after execution of the insert query.
     *
     * @param ezcPersistentObjectDefinition $def
     * @param ezcDbHandler $db
     * @return int
     */
    public function postSave( ezcPersistentObjectDefinition $def, ezcDbHandler $db )
    {
        return $this->id;
    }
}

?>
