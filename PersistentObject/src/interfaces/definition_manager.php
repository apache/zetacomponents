<?php
/**
 * File containing the ezcPersistentDefinitionManager class
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
 * Defines the interface for all persistent object definition managers.
 *
 * Definition managers are used to fetch the definition of a specific
 * persistent object. The definition is returned in form of a
 * ezcPersistentObjectDefinition structure.
 *
 * @version //autogen//
 * @package PersistentObject
 */
abstract class ezcPersistentDefinitionManager
{
    /**
     * Returns the definition of the persistent object with the class $class.
     *
     * @throws ezcPersistentDefinitionNotFoundException if no such definition can be found.
     * @param string $class
     * @return ezcPersistentObjectDefinition
     */
    public abstract function fetchDefinition( $class );

    // public function storeDefinition( ezcPersistentObjectDefinition $def );

    /**
     * Returns the definition $def with the reverse relations field correctly set up.
     *
     * This method will go through all of the properties in the definition and set up
     * the columns field in the definition.
     *
     * @param ezcPersistentObjectDefinition $def The target persistent object definition.
     * @return ezcPersistentObjectDefinition
     */
    protected static function setupReversePropertyDefinition( ezcPersistentObjectDefinition $def )
    {
        foreach ( $def->properties as $field )
        {
            $def->columns[$field->resultColumnName] = $field;
        }
        if ( isset( $def->idProperty ) && $def->idProperty->columnName !== null )
        {
            $def->columns[$def->idProperty->resultColumnName] = $def->idProperty;
        }
        return $def;
    }
}
?>
