<?php
/**
 * File containing the ezcDbSchemaDiffWriter interface
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
 * This class provides the base interface for schema difference writers
 *
 * This interface is extended by both a specific interface for schema
 * difference writers which write to a file (@link ezcDbSchemaDiffFileWriter)
 * and one for writers that apply differences directly to a database instance
 * (@link ezcDbSchemaDiffDbWriter).
 *
 * @package DatabaseSchema
 * @version //autogen//
 */
interface ezcDbSchemaDiffWriter
{
    /**
     * Returns what type of schema difference writer this class implements.
     *
     * Depending on the class it either returns ezcDbSchema::DATABASE (for
     * writers that apply the differences directly to a database) or
     * ezcDbSchema::FILE (for writers that write the differences to a file).
     *
     * @return int
     */
    public function getDiffWriterType();
}
?>
