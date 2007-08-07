<?php
/**
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package Tree
 */

/**
 * ezcTreeDbParentChild implements a tree backend which stores parent/child
 * information in a simple table containing the node's ID and its parent's ID.
 *
 * The table that stores the index (configured using the $indexTableName argument
 * of the {@see __construct} method) should contain atleast two fields. The
 * first one 'id' will contain the node's ID, the second one 'parent_id' the ID
 * of the node's parent. Both fields should be of the same database field type.
 * Supported field types are either integer or a string type.
 *
 * @property-read ezcTreeXmlDataStore $store
 *                The data store that is used for retrieving/storing data.
 * @property      bool                $prefetch
 *                Whether data pre-fetching is enabled.
 * @property      string              $nodeClassName
 *                Which class is used as tree node - this class *must* inherit
 *                the ezcTreeNode class.
 *
 * @package Tree
 * @version //autogentag//
 * @mainclass
 */
class ezcTreeDbParentChild extends ezcTreeDb
{
    /**
     * Creates a new ezcTreeDbParentChild object.
     *
     * The different arguments to the method configure which database
     * connection ($dbh) is used to access the database and the $indexTableName
     * argument which table is used to retrieve the relation data from. The
     * $store argument configure which data store is used with this tree.
     *
     * It is up to the user to create the database table and make sure it is
     * empty.
     * 
     * @param ezcDbHandler       $dbh
     * @param string             $indexTableName
     * @param ezcTreeDbDataStore $store
     */
    public static function create( ezcDbHandler $dbh, $indexTableName, ezcTreeDbDataStore $store )
    {
        return new ezcTreeDbParentChild( $dbh, $indexTableName, $store );
    }

    /**
     * Runs SQL to get all the children of the node with ID $nodeId as a PDO
     * result set
     *
     * @param string $nodeId
     * @return PDOStatement
     */
    protected function fetchChildRecords( $nodeId )
    {
        $db = $this->dbh;
        $q = $db->createSelectQuery();

        // SELECT id, parent_id
        // FROM indexTable
        // WHERE parent_id = $nodeId
        $q->select( 'id, parent_id' )
          ->from( $db->quoteIdentifier( $this->indexTableName ) )
          ->where( $q->expr->eq( 'parent_id', $q->bindValue( $nodeId ) ) );

        $s = $q->prepare();
        $s->execute();
        return $s;
    }

    /**
     * Adds the children nodes of the node with ID $nodeId to the
     * ezcTreeNodeList $list.
     *
     * @param ezcTreeNodeList $list
     * @param string          $nodeId
     */
    private function addChildNodesDepthFirst( ezcTreeNodeList $list, $nodeId )
    {
        $className = $this->properties['nodeClassName'];
        foreach ( $this->fetchChildRecords( $nodeId ) as $record )
        {
            $list->addNode( new $className( $this, $record['id'] ) );
            $this->addChildNodesDepthFirst( $list, $record['id'] );
        }
    }

    /**
     * Returns all the children of the node with ID $id.
     *
     * @param string $id
     * @return ezcTreeNodeList
     */
    public function fetchChildren( $id )
    {
        $className = $this->properties['nodeClassName'];
        $list = new ezcTreeNodeList;
        foreach ( $this->fetchChildRecords( $id ) as $record )
        {
            $list->addNode( new $className( $this, $record['id'] ) );
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
        $className = $this->properties['nodeClassName'];
        $list = new ezcTreeNodeList;
        $list->addNode( new $className( $this, $id ) );

        $id = $this->getParentId( $id );

        while ( $id != null )
        {
            $list->addNode( new $className( $this, $id ) );
            $id = $this->getParentId( $id );
        }
        return $list;
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
        $className = $this->properties['nodeClassName'];
        $list = new ezcTreeNodeList;
        $list->addNode( new $className( $this, $nodeId ) );
        $this->addChildNodesDepthFirst( $list, $nodeId );
        return $list;
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
     * Adds the children nodes of the node with ID $nodeId to the
     * ezcTreeNodeList $list.
     *
     * @param ezcTreeNodeList $list
     * @param string          $nodeId
     */
    protected function addChildNodesBreadthFirst( ezcTreeNodeList $list, $nodeId )
    {
        $className = $this->properties['nodeClassName'];
        $childRecords = $this->fetchChildRecords( $nodeId )->fetchAll();
        foreach ( $childRecords as $record )
        {
            $list->addNode( new $className( $this, $record['id'] ) );
        }
        foreach ( $childRecords as $record )
        {
            $this->addChildNodesBreadthFirst( $list, $record['id'] );
        }
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
        $className = $this->properties['nodeClassName'];
        $list = new ezcTreeNodeList;
        $list->addNode( new $className( $this, $nodeId ) );
        $this->addChildNodesBreadthFirst( $list, $nodeId );
        return $list;
    }

    /**
     * Returns the number of direct children of the node with ID $id
     *
     * @param string $id
     * @return int
     */
    public function getChildCount( $nodeId )
    {
        $db = $this->dbh;
        $q = $db->createSelectQuery();

        // SELECT count(id)
        // FROM indexTable
        // WHERE parent_id = $nodeId
        $q->select( 'count(id)' )
          ->from( $db->quoteIdentifier( $this->indexTableName ) )
          ->where( $q->expr->eq( 'parent_id', $q->bindValue( $nodeId ) ) );

        $s = $q->prepare();
        $s->execute();
        return (int) $s->fetchColumn(0);
    }

    /**
     * Adds the number of children with for the node with ID $nodeId nodes to
     * $count recursively.
     *
     * @param int &$count
     * @param string $nodeId
     */
    protected function countChildNodes( &$count, $nodeId )
    {
        foreach ( $this->fetchChildRecords( $nodeId ) as $record )
        {
            $count++;
            $this->countChildNodes( $count, $record['id'] );
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
        $this->countChildNodes( $count, $id );
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
        $id = $this->getParentId( $id );
        $length = 0;

        while ( $id !== null )
        {
            $id = $this->getParentId( $id );
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
    public function hasChildNodes( $nodeId )
    {
        return $this->getChildCount( $nodeId ) > 0;
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
        $id = $this->getParentId( $childId );
        $parentId = (string) $parentId;
        return $parentId === $id;
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
        $parentId = (string) $parentId;
        $id = $childId;
        do
        {
            $id = $this->getParentId( $id );
            if ( $parentId === $id )
            {
                return true;
            }
        } while ( $id !== null );
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
        $id1 = $this->getParentId( $child1Id );
        $id2 = $this->getParentId( $child2Id );
        return $id1 === $id2 && (string) $child1Id !== (string) $child2Id;
    }

    /**
     * Sets a new node as root node, this wipes also out the whole tree
     *
     * @param ezcTreeNode $node
     */
    public function setRootNode( ezcTreeNode $node )
    {
        $db = $this->dbh;

        $q = $db->createDeleteQuery();
        $q->deleteFrom( $db->quoteIdentifier( $this->indexTableName ) );
        $s = $q->prepare();
        $s->execute();
        $this->store->deleteDataForAllNodes();

        $q = $db->createInsertQuery();
        $q->insertInto( $db->quoteIdentifier( $this->indexTableName ) )
          ->set( 'parent_id', "null" )
          ->set( 'id', $q->bindValue( $node->id ) );
        $s = $q->prepare();
        $s->execute();

        $this->store->storeDataForNode( $node, $node->data );
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

        $db = $this->dbh;

        $q = $db->createInsertQuery();
        $q->insertInto( $db->quoteIdentifier( $this->indexTableName ) )
          ->set( 'parent_id', $q->bindValue( $parentId ) )
          ->set( 'id', $q->bindValue( $childNode->id ) );
        $s = $q->prepare();
        $s->execute();

        $this->store->storeDataForNode( $childNode, $childNode->data );
    }

    /**
     * Deletes all nodes in the node list $list
     *
     * @param ezcTreeNodeList $list
     */
    private function deleteNodes( ezcTreeNodeList $list )
    {
        $db = $this->dbh;
        $q = $db->createDeleteQuery();
        $idList = array_keys( $list->getNodes() );

        // DELETE FROM indexTable
        // WHERE id in ( $list );
        $q->deleteFrom( $db->quoteIdentifier( $this->indexTableName ) );
        $q->where( $q->expr->in( 'id', $idList ) );
        $s = $q->prepare();
        $s->execute();
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

        $nodeList = $this->fetchSubtree( $id );
        $this->deleteNodes( $nodeList );
        $this->store->deleteDataForNodes( $nodeList );
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

        $db = $this->dbh;
        $q = $db->createUpdateQuery();

        $q->update( $db->quoteIdentifier( $this->indexTableName ) )
          ->set( 'parent_id', $q->bindValue( $targetParentId ) )
          ->where( $q->expr->eq( 'id', $q->bindValue( $id ) ) );

        $s = $q->prepare();
        $s->execute();
    }

    public function fixateTransaction()
    {
    }
}
?>
