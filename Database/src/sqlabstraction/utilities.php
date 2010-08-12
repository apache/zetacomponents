<?php
/**
 * File containing the ezcDbUtilities class.
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
 * @package Database
 * @version //autogentag//
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 * @access private
 */

/**
 * Various database methods.
 *
 * @todo this class must be renamed.. or removed?!?
 * @package Database
 * @version //autogentag//
 * @access private
 */
class ezcDbUtilities
{
    /**
     * Database handler used for the utility.
     *
     * @var ezcDbHandler
     */
    protected $db;

    /**
     * Constructs a new db util using the db handler $db.
     *
     * @param ezcDbHandler $db
     */
    public function __construct( ezcDbHandler $db )
    {
        $this->db = $db;
    }

    /**
     * Create temporary table.
     *
     * Developers should use this method rather than creating temporary
     * tables by hand, executing the appropriate SQL queries.
     *
     * If the specified table name contains percent character (%)
     * then it might be substituted with a unique number by some handlers.
     * For example, Oracle handler does this to guarantee uniqueness of
     * temporary tables names.
     * Handlers that do not need this just remove percent characters
     * from the table name.
     *
     * Example of usage:
     * <code>
     * $actualTableName = $db->createTemporaryTable(
     *     'my_tmp_%', 'field1 char(255), field2 int' );
     * $db->dropTemporaryTable( $actualTableName );
     * </code>
     *
     * @see dropTemporaryTable()
     *
     * @param   string $tableName       Name of temporary table user wants
     *                                  to create.
     * @param   string $tableDefinition Definition for the table, i.e.
     *                                  everything that goes between braces after
     *                                  CREATE TEMPORARY TABLE clause.
     * @return string                  Table name, that might have been changed
     *                                  by the handler to guarantee its uniqueness.
     */
    public function createTemporaryTable( $tableName, $tableDefinition )
    {
        $tableName = str_replace( '%', '', $tableName );
        $this->db->exec( "CREATE TEMPORARY TABLE $tableName ($tableDefinition)" );
        return $tableName;
    }

    /**
     * Drop specified temporary table
     * in a portable way.
     *
     * Developers should use this method instead of dropping temporary
     * tables with the appropriate SQL queries
     * to maintain inter-DBMS portability.
     *
     * @see createTemporaryTable()
     *
     * @param   string  $tableName Name of temporary table to drop.
     * @return void
     */
    public function dropTemporaryTable( $tableName )
    {
        $this->db->exec( "DROP TABLE $tableName" );
    }

    /**
     *  List databases on the server.
     *
     * @return array Databases list.
     */
    public function listDatabases()
    {
    }

    /**
     * Check if the database is empty.
     *
     * @return true if the given database contains no objects
     * (tables, sequences, triggers).
     */
    public function checkIfDatabaseIsEmpty()
    {
    }

    /**
     * Remove all tables from the database.
     */
    public function cleanup()
    {
        throw new ezcDbException( "Not implemented" );
    }
}

?>
