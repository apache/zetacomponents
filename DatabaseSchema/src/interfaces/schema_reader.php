<?php
/**
 * File containing the ezcDbSchemaReader interface
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
 * This class provides the base interface for schema readers.
 *
 * This interface is extended by both a specific interface for schema readers
 * who read from a file (@link ezcDbSchemaFileReader) and one for readers that
 * read from a database (@link ezcDbSchemaDbReader).
 *
 * @package DatabaseSchema
 * @version //autogen//
 */
interface ezcDbSchemaReader
{
    /**
     * Returns what type of schema reader this class implements.
     *
     * Depending on the class it either returns ezcDbSchema::DATABASE (for
     * readers that read from a database) or ezcDbSchema::FILE (for readers
     * that read from a file).
     *
     * @return int
     */
    public function getReaderType();
}
?>
