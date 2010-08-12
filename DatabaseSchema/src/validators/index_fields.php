<?php
/**
 * File containing the ezcDbSchemaIndexFieldsValidator class.
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
 * ezcDbSchemaIndexFieldsValidator validates whether fields used in indexes exist.
 *
 * @todo implement from an interface
 * @package DatabaseSchema
 * @version //autogentag//
 */
class ezcDbSchemaIndexFieldsValidator
{
    /**
     * Validates if all the fields used in all indexes exist.
     *
     * This method loops over all the fields in the indexes of each table and
     * checks whether the fields that is used in an index is also defined in
     * the table definition. It will return an array containing error strings
     * for each non-supported type that it finds.
     *
     * @param ezcDbSchema $schema
     * @return array(string)
     */
    static public function validate( ezcDbSchema $schema )
    {
        $errors = array();

        /* For each table we first retrieve all the field names, and then check
         * per index whether the fields it references exist */
        foreach ( $schema->getSchema() as $tableName => $table )
        {
            $fields = array_keys( $table->fields );

            foreach ( $table->indexes as $indexName => $index )
            {
                foreach ( $index->indexFields as $indexFieldName => $dummy )
                {
                    if ( !in_array( $indexFieldName, $fields ) )
                    {
                        $errors[] = "Index '$tableName:$indexName' references unknown field name '$tableName:$indexFieldName'.";
                    }
                }
            }
        }

        return $errors;
    }
}
?>
