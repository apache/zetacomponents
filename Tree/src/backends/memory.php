<?php
/**
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package Tree
 */

/**
 * ezcTreeMemory is an implementation of a tree backend that operates on
 * an in-memory tree structure.
 *
 * @property-read ezcTreeXmlDataStore $store
 *
 * @package Tree
 * @version //autogentag//
 * @mainclass
 */
class ezcTreeMemory extends ezcTree
{
    /**
     * Contains a list of all nodes, indexed by node ID that link directly to the create node so that they can be looked up quickly.
     *
     * @var array(string=>ezcTreeMemoryNode)
     */
    private $nodeList = array();

    /**
     * Contains the root node.
     *
     * @var ezcTreeMemoryNode
     */
    private $rootNode;

    /**
     * Constructs a new ezcTreeMemory object
     */
    protected function __construct( ezcTreeMemoryDataStore $store )
    {
        $this->properties['store'] = $store;
    }

    /**
     * A factory method that creates a new empty tree using the data store $store
     *
     * @param ezcTreeMemoryDataStore $store
     * @returns ezcTreeMemory
     */
    public static function create( ezcTreeMemoryDataStore $store )
    {
        $newTree = new ezcTreeMemory( $store );
        $newTree->nodeList = null;
        $newTree->rootNode = null;
        return $newTree;
    }

    /**
     * Returns whether the node with ID $id exists
     *
     * @param string $id
     * @return bool
     */
    public function nodeExists( $id )
    {
        return isset( $this->nodeList[$id] );
    }

    /**
     * Returns the node identified by the ID $id
     *
     * @param string $id
     * @throws ezcTreeInvalidIdException if there is no node with ID $id
     * @return ezcTreeNode
     */
    public function fetchNodeById( $id )
    {
        return $this->getNodeById($id)->node;
    }

    /**
     * Returns the node container for node $id
     *
     * @param string $id
     * @throws ezcTreeInvalidIdException if there is no node with ID $id
     * @return ezcTreeMemoryNode
     */
    private function getNodeById( $id )
    {
        if ( !$this->nodeExists($id) )
        {
            throw new ezcTreeInvalidIdException( $id );
        }
        return $this->nodeList[$id];
    }

    /**
     * Returns all the children of the node with ID $id.
     *
     * @param string $id
     * @return ezcTreeNodeList
     */
    public function fetchChildren( $id )
    {
        $treeNode = $this->getNodeById( $id );
        $list = new ezcTreeNodeList;
        foreach ( $treeNode->children as $id => $child )
        {
            $list->addNode( $child->node );
        }
        return $list;
    }

    /**
     * Returns all the nodes in the path from the root node to the node with ID
     * $id, including those two nodes.
     *
     * @param string $id
     * @return ezcTreeNodeList
     */
    public function fetchPath( $id )
    {
        $list = new ezcTreeNodeList;

        $memoryNode = $this->getNodeById( $id );
        $list->addNode( $memoryNode->node );

        $memoryNode = $memoryNode->parent;

        while ( $memoryNode !== null )
        {
            $list->addNode( $memoryNode->node );
            $memoryNode = $memoryNode->parent;
        }
        return $list;
    }

    private function addChildNodes( $list, ezcTreeMemoryNode $memoryNode )
    {
        foreach ( $memoryNode->children as $id => $childMemoryNode )
        {
            $list->addNode( $childMemoryNode->node );
            $this->addChildNodes( $list, $childMemoryNode );
        }
    }

    /**
     * Alias for fetchSubtreeDepthFirst().
     *
     * @param string $id
     * @return ezcTreeNodeList
     */
    public function fetchSubtree( $nodeId )
    {
        return $this->fetchSubtreeDepthFirst( $nodeId );
    }

    /**
     * Returns the node with ID $id and all its children, sorted accoring to
     * the `Breadth-first sorting`_ algorithm.
     *
     * @param string $id
     * @return ezcTreeNodeList
     */
    public function fetchSubtreeBreadthFirst( $nodeId )
    {
    }

    /**
     * Returns the node with ID $id and all its children, sorted accoring to
     * the `Depth-first sorting`_ algorithm.
     *
     * @param string $id
     * @return ezcTreeNodeList
     */
    public function fetchSubtreeDepthFirst( $nodeId )
    {
        $list = new ezcTreeNodeList;
        $memoryNode = $this->getNodeById( $nodeId );
        $list->addNode( $memoryNode->node );
        $this->addChildNodes( $list, $memoryNode );
        return $list;
    }

    /**
     * Returns the node with ID $id and all its children, sorted accoring to
     * the `Topological sorting`_ algorithm.
     *
     * @param string $id
     * @return ezcTreeNodeList
     */
    public function fetchSubtreeTopological( $nodeId )
    {
    }



    /**
     * Returns the number of direct children of the node with ID $id
     *
     * @param string $id
     * @return int
     */
    public function getChildCount( $id )
    {
        return count( $this->getNodeById( $id )->children );
    }

    /**
     * Helper method that iterates recursively over the children of $node to
     * count the number of children.
     *
     * @param integer &$count
     * @param ezcTreeMemoryNode $node
     */
    private function countChildNodes( &$count, ezcTreeMemoryNode $node )
    {
        foreach ( $node->children as $id => $node )
        {
            $count++;
            $this->countChildNodes( $count, $node );
        }
    }

    /**
     * Returns the number of children of the node with ID $id, recursively
     *
     * @param string $id
     * @return int
     */
    public function getChildCountRecursive( $id )
    {
        $count = 0;
        $node = $this->getNodeById( $id );
        $this->countChildNodes( $count, $node );
        return $count;
    }

    /**
     * Returns the distance from the root node to the node with ID $id
     *
     * @param string $id
     * @return int
     */
    public function getPathLength( $id )
    {
        $childNode = $this->getNodeById( $id );
        $length = -1;

        while ( $childNode !== null )
        {
            $childNode = $childNode->parent;
            $length++;
        }
        return $length;
    }

    /**
     * Returns whether the node with ID $id has children
     *
     * @param string $id
     * @return bool
     */
    public function hasChildNodes( $id )
    {
        return count( $this->getNodeById( $id )->children ) > 0;
    }

    /**
     * Returns whether the node with ID $childId is a direct child of the node
     * with ID $parentId
     *
     * @param string $childId
     * @param string $parentId
     * @return bool
     */
    public function isChildOf( $childId, $parentId )
    {
        $childNode = $this->getNodeById( $childId );
        $parentNode = $this->getNodeById( $parentId );

        if ( $childNode->parent->node === $parentNode->node )
        {
            return true;
        }
        return false;
    }

    /**
     * Returns whether the node with ID $childId is a direct or indirect child
     * of the node with ID $parentId
     *
     * @param string $childId
     * @param string $parentId
     * @return bool
     */
    public function isDecendantOf( $childId, $parentId )
    {
        $childNode = $this->getNodeById( $childId );
        $parentNode = $this->getNodeById( $parentId );

        if ( $childNode === $parentNode )
        {
            return false;
        }

        while ( $childNode !== null )
        {
            if ( $childNode->node === $parentNode->node )
            {
                    return true;
            }
            $childNode = $childNode->parent;
        }
        return false;
    }

    /**
     * Returns whether the nodes with IDs $child1Id and $child2Id are siblings
     * (ie, the share the same parent)
     *
     * @param string $child1Id
     * @param string $child2Id
     * @return bool
     */
    public function isSiblingOf( $child1Id, $child2Id )
    {
        $elem1 = $this->getNodeById( $child1Id );
        $elem2 = $this->getNodeById( $child2Id );
        return (
            ( $child1Id !== $child2Id ) && 
            ( $elem1->parent === $elem2->parent )
        );
    }

    /**
     * Sets a new node as root node, this wipes also out the whole tree
     *
     * @param ezcTreeNode $node
     */
    public function setRootNode( ezcTreeNode $node )
    {
        // wipe nodelist
        $this->nodeList = array();

        // replace root node
        $newObj = new ezcTreeMemoryNode( $node, array() );
        $this->rootNode = $newObj;

        // Add to node list
        $this->nodeList[$node->id] = $newObj;
    }

    /**
     * Adds the node $childNode as child of the node with ID $parentId
     *
     * @param string $parentId
     * @paran ezcTreeNode $childNode
     */
    public function addChild( $parentId, ezcTreeNode $childNode )
    {
        if ( $this->inTransaction )
        {
            $this->addTransactionItem( new ezcTreeTransactionItem( ezcTreeTransactionItem::ADD, $childNode, null, $parentId ) );
            return;
        }

        // locate parent node
        $parentMemoryNode = $this->getNodeById( $parentId );

        // Create new node
        $newObj = new ezcTreeMemoryNode( $childNode, array(), $parentMemoryNode );

        // Append to parent node
        $parentMemoryNode->children[$childNode->id] = $newObj;

        // Add to node list
        $this->nodeList[$childNode->id] = $newObj;
    }

    /**
     * Deletes the node with ID $id from the tree, including all its children
     *
     * @param string $id
     */
    public function delete( $id )
    {
        if ( $this->inTransaction )
        {
            $this->addTransactionItem( new ezcTreeTransactionItem( ezcTreeTransactionItem::DELETE, null, $id ) );
            return;
        }

        // locate node to move
        $nodeToDelete = $this->getNodeById( $id );

        // fetch the whole subtree
        $children = $nodeToDelete->node->fetchSubtree();

        // Use the parent to remove the child
        unset( $nodeToDelete->parent->children[$id] );

        // Remove the node and all its children
        foreach( new ezcTreeNodeListIterator( $this, $children ) as $id => $data )
        {
            unset( $this->nodeList[$id] );
        }
    }

    /**
     * Moves the node with ID $id as child to the node with ID $targetParentId
     *
     * @param string $id
     * @param string $targetParentId
     */
    public function move( $id, $targetParentId )
    {
        if ( $this->inTransaction )
        {
            $this->addTransactionItem( new ezcTreeTransactionItem( ezcTreeTransactionItem::MOVE, null, $id, $targetParentId ) );
            return;
        }

        // locate node to move
        $nodeToMove = $this->getNodeById( $id );

        // locate new parent
        $newParent = $this->getNodeById( $targetParentId );

        // new placement for node
        $newParent->children[$id] = $nodeToMove;

        // remove old location from previous parent
        unset( $nodeToMove->parent->children[$id] );

        // update parent attribute of the node
        $nodeToMove->parent = $newParent;
    }

    public function fixateTransaction()
    {
    }
}
?>
