<?php
/**
 * File containing the ezcSearchHandler interface.
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
 * @package Search
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2010 eZ Systems AS. All rights reserved.
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 */

/**
 * Defines interface for all the search backend implementations.
 *
 * @version //autogentag//
 * @package Search
 */
interface ezcSearchHandler
{
    /**
     * Creates a search query object with the fields from the definition filled in.
     *
     * @param string $type
     * @param ezcSearchDocumentDefinition $definition
     * @return ezcSearchFindQuery
     */
    public function createFindQuery( $type, ezcSearchDocumentDefinition $definition );

    /**
     * Builds the search query and returns the parsed response
     *
     * @param ezcSearchFindQuery $query
     * @return ezcSearchResult
     */
    public function find( ezcSearchFindQuery $query );

    /**
     * Finds a document by the document's $id
     *
     * @param mixed $id
     * @param ezcSearchDocumentDefinition $definition
     */
    public function findById( $id, ezcSearchDocumentDefinition $definition );
}
?>
