<?php
/**
 * File containing the ezcPersistentSingleTableMap.
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
 * @package PersistentObject
 * @version //autogentag//
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 */

/**
 * Class to create {ezcPersistentRelation::$columnMap} properties.
 * Maps a source table and column and to a destination table and column, to
 * establish a relation between the 2 tables.
 * 
 * @package PersistentObject
 * @version //autogen//
 */
class ezcPersistentSingleTableMap extends ezcBaseStruct
{

    /**
     * Column of the first table used for mapping. 
     * 
     * @var string
     */
    public $sourceColumn;

    /**
     * Column of the second table, which should be mapped to the first column. 
     * 
     * @var string
     */
    public $destinationColumn;

    /**
     * Create a new ezcPersistentSingleTableMap. 
     * 
     * @param string $sourceColumn      {@link $sourceColumn}
     * @param string $destinationColumn {@link $destinationColumn}
     */
    public function __construct( $sourceColumn, $destinationColumn )
    {
        $this->sourceColumn         = $sourceColumn;
        $this->destinationColumn    = $destinationColumn;
    }

    /**
     * Sets the state of this map.
     *
     * @param array(key=>value) $state
     * @ignore
     */
    public static function __set_state( array $state )
    {
        return new ezcPersistentSingleTableMap(
            $state["sourceColumn"],
            $state["destinationColumn"]
        );
    }
}

?>
