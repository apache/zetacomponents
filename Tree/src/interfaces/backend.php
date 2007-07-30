<?php
/**
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package Tree
 */

/**
 * ezcTreeBackend is an interface that defines all the methods that a backend
 * is required to implement.
 *
 * @package Tree
 * @version //autogentag//
 * @mainclass
 */
interface ezcTreeBackend
{
    /**
     * Returns the node associated with the ID $id.
     *
     * @param string $id
     * @return ezcTreeNode
     */
    public function fetchNodeById( $id );

    /**
     * Returns all the children of the node with ID $id.
     *
     * @param string $id
     * @return ezcTreeNodeList
     */
    public function fetchChildren( $id );

    /**
     * Returns all the nodes in the path from the root node to the node with ID
     * $id, including those two nodes.
     *
     * @param string $id
     * @return ezcTreeNodeList
     */
    public function fetchPath( $id );

    /**
     * Alias for fetchSubtreeDepthFirst().
     *
     * @param string $id
     * @return ezcTreeNodeList
     */
    public function fetchSubtree( $id );

    /**
     * Returns the node with ID $id and all its children, sorted accoring to
     * the `Breadth-first sorting`_ algorithm.
     *
     * @param string $id
     * @return ezcTreeNodeList
     */
    public function fetchSubtreeBreadthFirst( $id );

    /**
     * Returns the node with ID $id and all its children, sorted accoring to
     * the `Depth-first sorting`_ algorithm.
     *
     * @param string $id
     * @return ezcTreeNodeList
     */
    public function fetchSubtreeDepthFirst( $id );

    /**
     * Returns the node with ID $id and all its children, sorted accoring to
     * the `Topological sorting`_ algorithm.
     *
     * @param string $id
     * @return ezcTreeNodeList
     */
    public function fetchSubtreeTopological( $id );


    /**
     * Returns the number of direct children of the node with ID $id
     *
     * @param string $id
     * @return int
     */
    public function getChildCount( $id );

    /**
     * Returns the number of children of the node with ID $id, recursively
     *
     * @param string $id
     * @return int
     */
    public function getChildCountRecursive( $id );

    /**
     * Returns the distance from the root node to the node with ID $id
     *
     * @param string $id
     * @return int
     */
    public function getPathLength( $id );


    /**
     * Returns whether the node with ID $id has children
     *
     * @param string $id
     * @return bool
     */
    public function hasChildNodes( $id );


    /**
     * Returns whether the node with ID $childId is a direct child of the node
     * with ID $parentId
     *
     * @param string $childId
     * @param string $parentId
     * @return bool
     */
    public function isChildOf( $childId, $parentId );

    /**
     * Returns whether the node with ID $childId is a direct or indirect child
     * of the node with ID $parentId
     *
     * @param string $childId
     * @param string $parentId
     * @return bool
     */
    public function isDecendantOf( $childId, $parentId );

    /**
     * Returns whether the nodes with IDs $child1Id and $child2Id are siblings
     * (ie, the share the same parent)
     *
     * @param string $child1Id
     * @param string $child2Id
     * @return bool
     */
    public function isSiblingOf( $child1Id, $child2Id );


    /**
     * Returns whether the node with ID $id exists
     *
     * @param string $id
     * @return bool
     */
    public function nodeExists( $id );

    /**
     * Creates a new tree node, which you can append to the tree by calling
     * appendChild() on the ezcTreeNode object
     *
     * @param string $id
     * @param mixed  $data
     */
    public function createNode( $id, $data );

    /**
     * Sets a new node as root node, this wipes also out the whole tree
     *
     * @param ezcTreeNode $node
     */
    public function setRootNode( ezcTreeNode $node );

    /**
     * Adds the node $childNode as child of the node with ID $parentId
     *
     * @param string $parentId
     * @paran ezcTreeNode $childNode
     */
    public function addChild( $parentId, ezcTreeNode $childNode );

    /**
     * Deletes the node with ID $id from the tree, including all its children
     *
     * @param string $id
     */
    public function delete( $id );

    /**
     * Moves the node with ID $id as child to the node with ID $targetParentId
     *
     * @param string $id
     * @param string $targetParentId
     */
    public function move( $id, $targetParentId );

    /**
     * Starts an transaction in which all tree modifications are queued until 
     * the transaction is committed with the commit() method.
     */
    public function beginTransaction();

    /**
     * Commits the transaction by running the stored instructions to modify
     * the tree structure.
     */
    public function commit();

    /**
     * Adds a new transaction item to the list
     *
     * @param ezcTreeTransactionItem $item
     */
    public function addTransactionItem( ezcTreeTransactionItem $item );

    /**
     * Rolls back the transaction by clearing all stored instructions.
     */
    public function rollback();
}
?>
