<?php
/**
 * File containing the ezcDbSchemaCommonSqlReader class.
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
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 */

/**
 * An abstract class that implements some common functionality required by
 * multiple database backends.
 *
 * @package DatabaseSchema
 * @version //autogentag//
 */
abstract class ezcDbSchemaCommonSqlReader implements ezcDbSchemaDbReader
{
    /**
     * Returns an ezcDbSchema created from the database schema in the database referenced by $db
     *
     * This method analyses the current database referenced by $db and creates
     * a schema definition out of this. This schema definition is returned as
     * an (@link ezcDbSchema) object.
     *
     * @param ezcDbHandler $db
     * @return ezcDbSchema
     */
    public function loadFromDb( ezcDbHandler $db )
    {
        $this->db = $db;
        return new ezcDbSchema( $this->fetchSchema() );
    }

    /**
     * Returns what type of schema reader this class implements.
     *
     * This method always returns ezcDbSchema::DATABASE
     *
     * @return int
     */
    public function getReaderType()
    {
        return ezcDbSchema::DATABASE;
    }

    /**
     * Loops over all the table names in the array and extracts schema
     * information.
     *
     * This method extracts information about a database's schema from the
     * database itself and returns this schema as an ezcDbSchema object.
     *
     * @param array(string) $tables
     * @return ezcDbSchema
     */
    protected function processSchema( array $tables )
    {
        $schemaDefinition = array();
        array_walk( $tables, create_function( '&$item,$key', '$item = $item[0];' ) );

        // strip out the prefix and only return tables with the prefix set.
        $prefix = ezcDbSchema::$options->tableNamePrefix;

        foreach ( $tables as $tableName )
        {
            $tableNameWithoutPrefix = substr( $tableName, strlen( $prefix ) );
            // Process table if there was no prefix, or when a prefix was
            // found. In the latter case the prefix would be missing from
            // $tableNameWithoutPrefix due to the substr() above, and hence,
            // $tableName and $tableNameWithoutPrefix would be different.
            if ( $prefix === '' || $tableName !== $tableNameWithoutPrefix )
            {
                $fields  = $this->fetchTableFields( $tableName );
                $indexes = $this->fetchTableIndexes( $tableName );

                $schemaDefinition[$tableNameWithoutPrefix] = ezcDbSchema::createNewTable( $fields, $indexes );
            }
        }

        return $schemaDefinition;
    }

}
?>
