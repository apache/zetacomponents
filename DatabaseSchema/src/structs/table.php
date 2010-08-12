<?php
/**
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
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 * @version //autogentag//
 * @filesource
 * @package DatabaseSchema
 */
/**
 * A container to store a table definition in.
 *
 * @package DatabaseSchema
 * @version //autogentag//
 */
class ezcDbSchemaTable extends ezcBaseStruct
{
    /**
     * A list of all the fields in this table.
     *
     * The array is indexed with the field name.
     *
     * @var array(string=>ezcDbSchemaField)
     */
    public $fields;

    /**
     * A list of all the indexes on this table.
     *
     * The array is indexed with the index name, where the index with the name
     * 'primary' is a special one describing the primairy key.
     *
     * @var array(string=>ezcDbSchemaIndex)
     */
    public $indexes;
    
    /**
     * Constructs an ezcDbSchemaTable object.
     *
     * @param array(string=>ezcDbSchemaField) $fields
     * @param array(string=>ezcDbSchemaIndex) $indexes
     */
    function __construct( $fields, $indexes = array() )
    {
        $this->fields = $fields;
        $this->indexes = $indexes;
    }

    static public function __set_state( array $array )
    {
        return new ezcDbSchemaTable(
            $array['fields'], $array['indexes']
        );
    }
}
?>
