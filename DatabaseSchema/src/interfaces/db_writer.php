<?php
/**
 * File containing the ezcDbSchemaDbWriter interface
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
 * @version //autogen//
 * @copyright Copyright (C) 2005-2010 eZ Systems AS. All rights reserved.
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 */
/**
 * This class provides the interface for database schema writers
 *
 * @package DatabaseSchema
 * @version //autogen//
 */
interface ezcDbSchemaDbWriter extends ezcDbSchemaWriter
{
    /**
     * Creates the tables contained in $schema in the database that is related to $db
     *
     * This method takes the table definitions from $schema and will create the
     * tables according to this definition in the database that is references
     * by the $db handler. If tables with the same name as contained in the
     * definitions already exist they will be removed and recreated with the
     * new definition.
     *
     * @param ezcDbHandler $db
     * @param ezcDbSchema  $dbSchema
     */
    public function saveToDb( ezcDbHandler $db, ezcDbSchema $dbSchema );

    /**
     * Returns an array with SQL DDL statements that creates the database definition in $dbSchema
     *
     * Converts the schema definition contained in $dbSchema to DDL SQL. This
     * SQL can be used to create tables in an existing database according to
     * the definition.  The SQL queries are returned as an array.
     * 
     * @param ezcDbSchema $dbSchema
     * @return array(string)
     */
    public function convertToDDL( ezcDbSchema $dbSchema );

    /**
     * Checks if the query is allowed.
     *
     * Perform testing if table exist for DROP TABLE query 
     * to avoid stoping execution while try to drop not existent table. 
     * 
     * @param ezcDbHandler $db
     * @param string       $query
     * 
     * @return boolean
     */
    public function isQueryAllowed( ezcDbHandler $db, $query );
}
?>
