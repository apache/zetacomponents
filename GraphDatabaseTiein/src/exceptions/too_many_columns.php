<?php
/**
 * File containing the ezcGraphDatabaseTooManyColumnsException class
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
 * @package GraphDatabaseTiein
 * @version //autogen//
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 */
/**
 * Exception thrown if a data set has too many columns for a key value 
 * association.
 *
 * @package GraphDatabaseTiein
 * @version //autogen//
 */
class ezcGraphDatabaseTooManyColumnsException extends ezcGraphDatabaseException
{
    /**
     * Constructor
     * 
     * @param array $row
     * @return void
     * @ignore
     */
    public function __construct( $row )
    {
        $columnCount = count( $row );
        parent::__construct( "'{$columnCount}' columns are too many in a result." );
    }
}

?>
