<?php
/**
 * File containing the ezcDbSchemaUniqueIndexNameValidator class.
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
 * @package DatabaseSchema
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2010 eZ Systems AS. All rights reserved.
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 */

/**
 * ezcDbSchemaUniqueIndexNameValidator checks for duplicate index names.
 *
 * @todo implement from an interface
 * @package DatabaseSchema
 * @version //autogentag//
 */
class ezcDbSchemaUniqueIndexNameValidator
{
    /**
     * Validates if all the index names used are unique accross the schema.
     *
     * This method loops over all the indexes in all tables and checks whether
     * they have been used before.
     *
     * @param ezcDbSchema $schema
     * @return array(string)
     */
    static public function validate( ezcDbSchema $schema )
    {
        $indexes = array();
        $errors = array();

        /* For each table we check all auto increment fields. */
        foreach ( $schema->getSchema() as $tableName => $table )
        {
            foreach ( $table->indexes as $indexName => $dummy )
            {
                $indexes[$indexName][] = $tableName;
            }
        }

        foreach ( $indexes as $indexName => $tableList )
        {
            if ( count( $tableList ) > 1 )
            {
                $errors[] = "The index name '$indexName' is not unique. It exists for the tables: '" . join( "', '", $tableList ) . "'.";
            }
        }

        return $errors;
    }
}
?>
