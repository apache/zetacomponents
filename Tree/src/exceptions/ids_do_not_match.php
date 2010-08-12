<?php
/**
 * File containing the ezcTreeIdsDoNotMatchException class.
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
 * @package Tree
 */

/**
 * Exception that is thrown when a node is added through the ArrayAccess
 * interface with a key that is different from the node's ID.
 *
 * @package Tree
 * @version //autogentag//
 */
class ezcTreeIdsDoNotMatchException extends ezcTreeException
{
    /**
     * Constructs a new ezcTreeIdsDoNotMatchException.
     *
     * @param string $expectedId
     * @param string $actualId
     */
    public function __construct( $expectedId, $actualId )
    {
        parent::__construct( "You cannot add the node with node ID '$expectedId' to the list with key '$actualId'. The key needs to match the node ID." );
    }
}
?>
