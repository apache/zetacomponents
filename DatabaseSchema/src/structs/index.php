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
 * @copyright Copyright (C) 2005-2010 eZ Systems AS. All rights reserved.
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 * @version //autogentag//
 * @filesource
 * @package DatabaseSchema
 */
/**
 * A container to store a table index in.
 *
 * @package DatabaseSchema
 * @version //autogentag//
 */
class ezcDbSchemaIndex extends ezcBaseStruct
{
    /**
     * The fields that make up this index
     *
     * The array is indexed with the name of the field.
     *
     * @var array(string=>ezcDbSchemaIndexField)
     */
    public $indexFields;

    /**
     * Whether this is the primary index for a table.
     *
     * @var bool
     */
    public $primary;

    /**
     * Whether entries in this index need to be unique.
     *
     * @var bool
     */
    public $unique;

    /**
     * Constructs an ezcDbSchemaIndex object.
     *
     * @param array(string=>ezcDbSchemaIndexField) $indexFields
     * @param bool  $primary
     * @param bool  $unique
     */
    function __construct( $indexFields, $primary = false, $unique = true )
    {
        $this->indexFields = $indexFields;
        $this->primary = (bool) $primary;
        $this->unique = (bool) ( $this->primary ? true : $unique );
    }

    static public function __set_state( array $array )
    {
        return new ezcDbSchemaIndex(
             $array['indexFields'], $array['primary'], $array['unique']
        );
    }
}
?>
