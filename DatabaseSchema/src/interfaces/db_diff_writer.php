<?php
/**
 * File containing the ezcDbSchemaDbDiffWriter interface
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
 * This class provides the interface for database schema difference writers
 *
 * @package DatabaseSchema
 * @version //autogen//
 */
interface ezcDbSchemaDiffDbWriter extends ezcDbSchemaDiffWriter
{
    /**
     * Applies the differences contained in $schemaDiff to the database handler $db
     * 
     * @param ezcDbHandler    $db
     * @param ezcDbSchemaDiff $schemaDiff
     */
    public function applyDiffToDb( ezcDbHandler $db, ezcDbSchemaDiff $schemaDiff );

    /**
     * Returns an array with SQL DDL statements from the differences from $schemaDiff
     *
     * Converts the schema differences contained in $schemaDiff to SQL DDL that
     * can be used to upgrade an existing database to the new version with the
     * differences from $schemaDiff. The SQL queries are returned as an array.
     * 
     * @param ezcDbSchemaDiff $schemaDiff
     * @return array(string)
     */
    public function convertDiffToDDL( ezcDbSchemaDiff $schemaDiff );
}
?>
