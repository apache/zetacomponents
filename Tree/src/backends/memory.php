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
class ezcTreeMemory extends ezcTree implements ezcTreeBackend
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

    public static function create( ezcTreeMemoryDataStore $store )
    {
        $newTree = new ezcTreeMemory( $store );
        $newTree->nodeList = null;
        $newTree->rootNode = null;
        return $newTree;
    }

    public function nodeExists( $id )
    {
        return isset( $this->nodeList[$id] );
    }

    private function getNodeById( $id )
    {
        if ( !$this->nodeExists($id) )
        {
            throw new ezcTreeInvalidIdException( $id );
        }
        return $this->nodeList[$id];
    }

    public function fetchChildren( $id )
    {
        $className = $this->properties['nodeClassName'];
        $treeNode = $this->getNodeById( $id );
        $list = new ezcTreeNodeList;
        foreach ( $treeNode->children as $id => $child )
        {
            $list->addNode( $child->node );
        }
        return $list;
    }

    public function fetchPath( $id )
    {
        $className = $this->properties['nodeClassName'];
        $list = new ezcTreeNodeList;
        $list->addNode( new $className( $this, $id ) );

        $memoryNode = $this->getNodeById( $id );
        $memoryNode = $memoryNode->parent;

        while ( $memoryNode !== null )
        {
            $id = $memoryNode->node->id;
            $list->addNode( new $className( $this, $id ) );
            $memoryNode = $memoryNode->parent;
        }
        return $list;
    }

    private function addChildNodes( $list, $nodeId )
    {
        $className = $this->properties['nodeClassName'];
        $memoryNode = $this->getNodeById( $id );

        foreach ( $memoryNode->children as $id => $childMemoryNode )
        {
            $list->addNode( new $className( $this, $id ) );
            $this->addChildNodes( $list, $record['id'] );
        }
    }

    public function fetchSubtree( $nodeId )
    {
        return $this->fetchSubtreeDepthFirst( $nodeId );
    }

    public function fetchSubtreeBreadthFirst( $nodeId )
    {
    }

    public function fetchSubtreeDepthFirst( $nodeId )
    {
        $className = $this->properties['nodeClassName'];
        $list = new ezcTreeNodeList;
        $list->addNode( new $className( $this, $nodeId ) );
        $this->addChildNodes( $list, $nodeId );
        return $list;
    }

    public function fetchSubtreeTopological( $nodeId )
    {
    }



    public function getChildCount( $id )
    {
        return count( $this->getNodeById( $id )->children );
    }

    private function countChildNodes( &$count, $nodeId )
    {
        $count += $this->getChildCount( $nodeId );
    }

    public function getChildCountRecursive( $id )
    {
        $count = 0;
        $this->countChildNodes( $count, $id );
        return $count;
    }

    public function getPathLength( $id )
    {
        /*
        $elem = $this->getNodeById( $id );
        $elem = $elem->parentNode;
        $length = -1;

        while ( $elem !== null && $elem->nodeType == XML_ELEMENT_NODE )
        {
            $elem = $elem->parentNode;
            $length++;
        }
        return $length;
        */
    }

    public function hasChildNodes( $id )
    {
        return count( $this->getNodeById( $id )->children ) > 0;
    }

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

    public function isDecendantOf( $childId, $parentId )
    {
        /*
        $elem = $this->getNodeById( $childId );
        $elem = $elem->parentNode;

        while ( $elem !== null && $elem->nodeType == XML_ELEMENT_NODE )
        {
            $id = $elem->getAttribute( 'id' );
            if ( $id === "id$parentId" )
            {
                    return true;
            }
            $elem = $elem->parentNode;
        }
        return false;
        */
    }

    public function isSiblingOf( $child1Id, $child2Id )
    {
        $elem1 = $this->getNodeById( $child1Id );
        $elem2 = $this->getNodeById( $child2Id );
        return (
            ( $child1Id !== $child2Id ) && 
            ( $elem1->parent === $elem2->parent )
        );
    }

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

    public function addChild( $parentId, ezcTreeNode $childNode )
    {
        // locate parent node
        $parentMemoryNode = $this->getNodeById( $parentId );

        // Create new node
        $newObj = new ezcTreeMemoryNode( $childNode, array(), $parentMemoryNode );

        // Append to parent node
        $parentMemoryNode->children[$childNode->id] = $newObj;

        // Add to node list
        $this->nodeList[$childNode->id] = $newObj;
    }

    public function delete( $id )
    {
        // locate node to move
        $nodeToDelete = $this->getNodeById( $id );

        // Use the parent to remove the child
        unset( $nodeToDelete->parent->children[$id] );

        // Remove from node list
        unset( $this->nodeList[$childNode->id] );
    }

    public function move( $id, $targetParentId )
    {
        // locate node to move
        $nodeToMove = $this->getNodeById( $id );

        // locate new parent
        $newParent = $this->getNodeById( $targetParentId );

        // new placement for node
        $newParent->children[$id] = $nodeToMove;

        // remove old location from previous parent
        unset( $nodeToMode->parent->children[$id] );

        // update parent attribute of the node
        $nodeToMode->parent = $newParent;
    }
}
?>
