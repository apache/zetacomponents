<?php
/**
 * File containing the ezcSearchFindQuery class.
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
 * Class to create select search backend indepentent search queries.
 *
 * @package Search
 * @version //autogentag//
 * @mainclass
 */
interface ezcSearchQuery
{
    /**
     * Creates a new search query with handler $handler and document definition $definition.
     *
     * @param ezcSearchHandler $handler
     * @param ezcSearchDocumentDefinition $definition
     */
    public function __construct( ezcSearchHandler $handler, ezcSearchDocumentDefinition $definition );

    /**
     * Resets the query object for reuse.
     *
     * @return void
     */
    public function reset();

    /**
     * Adds a select/filter statement to the query
     *
     * @param string $clause
     * @return ezcSearchQuery
     */
    public function where( $clause );

    /**
     * Returns the query as a string for debugging purposes
     *
     * @return string
     * @ignore
     */
    public function getQuery();

    /**
     * Returns a string containing a field/value specifier, and an optional boost value.
     * 
     * The method uses the document definition field type to map the fieldname
     * to a solr fieldname, and the $fieldType argument to escape the $value
     * correctly. If a definition is set, the $fieldType will be overridden
     * with the type from the definition.
     *
     * @param string $field
     * @param mixed $value
     *
     * @return string
     */
    public function eq( $field, $value );

    /**
     * Returns a string containing a field/value specifier, and an optional boost value.
     * 
     * The method uses the document definition field type to map the fieldname
     * to a solr fieldname, and the $fieldType argument to escape the values
     * correctly.
     *
     * @param string $field
     * @param mixed $value1
     * @param mixed $value2
     *
     * @return string
     */
    public function between( $field, $value1, $value2 );

    /**
     * Creates an OR clause
     *
     * This method accepts either an array of fieldnames, but can also accept
     * multiple parameters as field names.
     *
     * @param mixed $...
     * @return string
     */
    public function lOr();

    /**
     * Creates an AND clause
     *
     * This method accepts either an array of fieldnames, but can also accept
     * multiple parameters as field names.
     *
     * @param mixed $...
     * @return string
     */
    public function lAnd();

    /**
     * Creates a NOT clause
     *
     * This method accepts a clause and negates it.
     *
     * @param string $clause
     * @return string
     */
    public function not( $clause );
}

?>
