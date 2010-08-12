<?php
/**
 * File containing the ezcDbSchemaDbReader interface
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
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 */
/**
 * This class provides the interface for database schema readers
 *
 * @package DatabaseSchema
 * @version //autogen//
 */
interface ezcDbSchemaDbReader extends ezcDbSchemaReader
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
    public function loadFromDb( ezcDbHandler $db );
}
?>
