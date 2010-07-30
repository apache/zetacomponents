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
 * A container to store table difference information in.
 *
 * @package DatabaseSchema
 * @version //autogentag//
 */
class ezcDbSchemaTableDiff extends ezcBaseStruct
{
    /**
     * All added fields
     *
     * @var array(string=>ezcDbSchemaField)
     */
    public $addedFields;

    /**
     * All changed fields
     *
     * @var array(string=>ezcDbSchemaField)
     */
    public $changedFields;

    /**
     * All removed fields
     *
     * @var array(string=>bool)
     */
    public $removedFields;

    /**
     * All added indexes
     *
     * @var array(string=>ezcDbSchemaIndex)
     */
    public $addedIndexes;

    /**
     * All changed indexes
     *
     * @var array(string=>ezcDbSchemaIndex)
     */
    public $changedIndexes;

    /**
     * All removed indexes
     *
     * @var array(string=>bool)
     */
    public $removedIndexes;

    /**
     * Constructs an ezcDbSchemaTableDiff object.
     *
     * @param array(string=>ezcDbSchemaField) $addedFields
     * @param array(string=>ezcDbSchemaField) $changedFields
     * @param array(string=>bool)             $removedFields
     * @param array(string=>ezcDbSchemaIndex) $addedIndexes
     * @param array(string=>ezcDbSchemaIndex) $changedIndexes
     * @param array(string=>bool)             $removedIndexes
     */
    function __construct( $addedFields = array(), $changedFields = array(),
            $removedFields = array(), $addedIndexes = array(), $changedIndexes =
            array(), $removedIndexes = array() )
    {
        $this->addedFields = $addedFields;
        $this->changedFields = $changedFields;
        $this->removedFields = $removedFields;
        $this->addedIndexes = $addedIndexes;
        $this->changedIndexes = $changedIndexes;
        $this->removedIndexes = $removedIndexes;
    }

    static public function __set_state( array $array )
    {
        return new ezcDbSchemaTableDiff(
             $array['addedFields'], $array['changedFields'], $array['removedFields'],
             $array['addedIndexes'], $array['changedIndexes'], $array['removedIndexes']
        );
    }
}
?>
