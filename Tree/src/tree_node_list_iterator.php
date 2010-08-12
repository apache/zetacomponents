<?php
/**
 * File containing the ezcTreeNodeListIterator class.
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
 * ezcTreeNodeListIterator implements an iterator over an ezcTreeNodeList.
 *
 * The iterator is instantiated with both an implementation of an ezcTree and
 * an ezcTreeNodeList object. It can be used to iterate over all the nodes
 * in a list.
 *
 * Example:
 * <code>
 * <?php
 *     // fetch all the nodes in a subtree as an ezcNodeList
 *     $nodeList = $tree->fetchSubtree( 'pan' );
 *     foreach ( new ezcTreeNodeListIterator( $tree, $nodeList ) as $nodeId => $data )
 *     {
 *         // do something with the node ID and data - data is fetched on
 *         // demand
 *     }
 * ?>
 * </code>
 *
 * Data for the nodes in the node lists is fetched on demand, unless
 * the "prefetch" argument is set to true. In that case the iterator will
 * fetch the data when the iterator is instantiated. This reduces the number
 * of queries made for database and persistent object based data stores, but
 * increases memory usage.
 *
 * Example:
 * <code>
 * <?php
 *     // fetch all the nodes in a subtree as an ezcNodeList
 *     $nodeList = $tree->fetchSubtree( 'Uranus' );
 *     // instantiate an iterator with pre-fetching enabled
 *     foreach ( new ezcTreeNodeListIterator( $tree, $nodeList, true ) as $nodeId => $data )
 *     {
 *         // do something with the node ID and data - data is fetched when
 *         // the iterator is instatiated.
 *     }
 * ?>
 * </code>
 *
 * @package Tree
 * @version //autogentag//
 * @mainclass
 */
class ezcTreeNodeListIterator implements Iterator
{
    /**
     * Holds the nodes of this list.
     *
     * @var array(ezcTreeNode)
     */
    private $nodeList;

    /**
     * Holds a link to the tree that contains the nodes that are iterated over.
     *
     * This is used for accessing the data store so that data can be fetched
     * on-demand.
     *
     * @var ezcTree
     */
    private $tree;

    /**
     * Constructs a new ezcTreeNodeListIterator object over $nodeList.
     *
     * The $tree argument is used so that data can be fetched on-demand.
     *
     * @param ezcTree         $tree
     * @param ezcTreeNodeList $nodeList
     * @param bool            $prefetch
     */
    public function __construct( ezcTree $tree, ezcTreeNodeList $nodeList, $prefetch = false )
    {
        $this->tree = $tree;
        if ( $prefetch )
        {
            $this->tree->store->fetchDataForNodes( $nodeList );
        }
        $this->nodeList = $nodeList->nodes;
    }

    /**
     * Rewinds the internal pointer back to the start of the nodelist.
     */
    public function rewind()
    {
        reset( $this->nodeList );
        if ( count( $this->nodeList ) )
        {
            $this->valid = true;
        }
        else 
        {
            $this->valid = false;
        }
    }

    /**
     * Returns the node ID of the current node.
     *
     * @return string
     */
    public function key()
    {
        return key( $this->nodeList );
    }

    /**
     * Returns the data belonging to the current node, and fetches the data in
     * case on-demand fetching is required.
     *
     * @return mixed
     */
    public function current()
    {
        $node = current( $this->nodeList );
        return $node->data;
    }

    /**
     * Advances the internal pointer to the next node in the nodelist.
     */
    public function next()
    {
        $nextElem = next( $this->nodeList );
        if ( $nextElem === false )
        {
            $this->valid = false;
        }
    }

    /**
     * Returns whether the internal pointer is still valid.
     *
     * It returns false when the end of list has been reached.
     *
     * @return bool
     */
    public function valid()
    {
        return $this->valid;
    }
}
?>
