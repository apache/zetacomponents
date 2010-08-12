<?php
/**
 * File containing the ezcPersistentStateTransformer class.
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
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 * @access private
 */

/**
 * This internal class provides functionality to transform between
 * row and state arrays.
 *
 * @package PersistentObject
 * @version //autogen//
 * @access private
 */
class ezcPersistentStateTransformer
{
    /**
     * Returns the the row $row retrieved from PDO transformed into a state array
     * that can be used to set the state on a persistent object.
     *
     * $def holds the definition of the persistent object the $row maps to.
     *
     * The most basic task is to transform the database column names into
     * property names.
     *
     * @throws ezcPersistentException if a fatal error occured during the transformation
     * @param array $row
     * @param ezcPersistentObjectDefinition $def
     * @return array
     */
    public static function rowToStateArray( array $row, ezcPersistentObjectDefinition $def )
    {
        // Sanity check for reverse-lookup
        // Issue #12108
        if ( count( $def->columns ) === 0 )
        {
            throw new ezcPersistentObjectException(
                "The PersistentObject definition for class {$def->class} was not initialized correctly.",
                'Missing reverse lookup for columns. Check the definition manager.'
            );
        }

        $result = array();
        foreach ( $row as $key => $value )
        {
            if ( $key === $def->idProperty->resultColumnName )
            {
                $result[$def->idProperty->propertyName] = $value;
            }
            else
            {
                $result[$def->columns[$key]->propertyName] = ( 
                    !is_null( $def->columns[$key]->converter )
                        ? $def->columns[$key]->converter->fromDatabase( $value )
                        : $value );
            }
        }
        return $result;
    }
}

?>
