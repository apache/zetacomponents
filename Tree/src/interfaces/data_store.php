<?php
/**
 * File containing the ezcTreeDataStore interface.
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
 * ezcTreeDataStore is an interface describing the methods that a 
 * tree data storage module should implement.
 *
 * @package Tree
 * @version //autogentag//
 */
interface ezcTreeDataStore
{
    /**
     * Deletes the data for the node $node from the data store.
     *
     * @param ezcTreeNode $node
    public function deleteDataForNode( ezcTreeNode $node );
     */

    /**
     * Deletes the data for all the nodes in the node list $nodeList.
     *
     * @param ezcTreeNodeList $nodeList
     */
    public function deleteDataForNodes( ezcTreeNodeList $nodeList );

    /**
     * Deletes the data for all the nodes in the store.
     */
    public function deleteDataForAllNodes();

    /**
     * Retrieves the data for the node $node from the data store and assigns it
     * to the node's 'data' property.
     *
     * @param ezcTreeNode $node
     */
    public function fetchDataForNode( ezcTreeNode $node );

    /**
     * Retrieves the data for all the nodes in the node list $nodeList and
     * assigns this data to the nodes' 'data' properties.
     *
     * @param ezcTreeNodeList $nodeList
     */
    public function fetchDataForNodes( ezcTreeNodeList $nodeList );

    /**
     * Stores the data in the node to the data store.
     *
     * @param ezcTreeNode $node
     */
    public function storeDataForNode( ezcTreeNode $node );
}
?>
