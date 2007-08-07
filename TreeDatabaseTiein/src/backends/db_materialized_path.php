<?php
/**
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package Tree
 */

/**
 * ezcTreeDbMaterializedPath implements a tree backend which stores parent/child
 * information in a path like string (such as /1/4/6/8).
 *
 * The table that stores the index (configured using the $indexTableName argument
 * of the {@see __construct} method) should contain atleast three fields. The
 * first one 'id' will contain the node's ID, the second one 'parent_id' the ID
 * of the node's parent. Both fields should be of the same database field type.
 * Supported field types are either integer or a string type. The third field
 * 'path' will contain the path string. This should be a text field. The size
 * of the field determines the maximum depth the tree can have.
 *
 * @property-read ezcTreeDbDataStore $store
 *                The data store that is used for retrieving/storing data.
 * @property      bool $prefetch
 *                Whether data pre-fetching is enabled.
 * @property      string $nodeClassName
 *                Which class is used as tree node - this class *must* inherit
 *                the ezcTreeNode class.
 *
 * @package Tree
 * @version //autogentag//
 * @mainclass
 */
class ezcTreeDbMaterializedPath extends ezcTreeDb
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
        return new ezcTreeDbMaterializedPath( $dbh, $indexTableName, $store );
    }

    /**
     * Returns the parent id and path the node with ID $id as an array.
     *
     * The format of the array is:
     * - 0: parent id
     * - 1: path
     *
     * @param string $id
     * @return array(int)
     */
    protected function fetchNodeInformation( $id )
    {
        $db = $this->dbh;

        // SELECT parent_id, path
        // FROM indexTable
        // WHERE id = $id
        $q = $db->createSelectQuery();
        $q->select( 'parent_id, path' )
          ->from( $db->quoteIdentifier( $this->indexTableName ) )
          ->where( $q->expr->eq( 'id', $q->bindValue( $id ) ) );
        $s = $q->prepare();
        $s->execute();
        $r = $s->fetchAll( PDO::FETCH_NUM );
        return $r[0];
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

        // Fetch node information
        list( $parentId, $path ) = $this->fetchNodeInformation( $id );

        $parts = split( '/', $path );
        array_shift( $parts );

        foreach ( $parts as $id )
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

        // Fetch information for node
        list( $parentId, $path ) = $this->fetchNodeInformation( $nodeId );

        $db = $this->dbh;
        $q = $db->createSelectQuery();

        // SELECT id
        // FROM materialized_path
        // WHERE path LIKE '$path/%'
        $q->select( 'id' )
          ->from( $db->quoteIdentifier( $this->indexTableName ) )
          ->where( $q->expr->like( 'path', $q->bindValue( "$path/%" ) ) );
        $s = $q->prepare();
        $s->execute();

        foreach ( $s as $record )
        {
            $list->addNode( new $className( $this, $record['id'] ) );
        }

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
     * Returns the number of children of the node with ID $id, recursively
     *
     * @param string $id
     * @return int
     */
    public function getChildCountRecursive( $id )
    {
        // Fetch information for node
        list( $parentId, $path ) = $this->fetchNodeInformation( $id );

        $db = $this->dbh;
        $q = $db->createSelectQuery();

        // SELECT count(id)
        // FROM materialized_path
        // WHERE path LIKE '$path/%'
        $q->select( 'count(id)' )
          ->from( $db->quoteIdentifier( $this->indexTableName ) )
          ->where( $q->expr->like( 'path', $q->bindValue( "$path/%" ) ) );
        $s = $q->prepare();
        $s->execute();
        $r = $s->fetch( PDO::FETCH_NUM );

        return (int) $r[0];
    }

    /**
     * Returns the distance from the root node to the node with ID $id
     *
     * @param string $id
     * @return int
     */
    public function getPathLength( $id )
    {
        // Fetch information for node
        list( $parentId, $path ) = $this->fetchNodeInformation( $id );

        return substr_count( $path, '/' ) - 1;
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
        // Fetch node information
        list( $dummyParentId, $path ) = $this->fetchNodeInformation( $childId );

        $parts = split( '/', $path );
        array_shift( $parts );

        return in_array( $parentId, $parts ) && ( $childId !== $parentId );
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
          ->set( 'id', $q->bindValue( $node->id ) )
          ->set( 'path', $q->bindValue( '/' . $node->id ) );
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

        // Fetch parent information
        list( $parentParentId, $path ) = $this->fetchNodeInformation( $parentId );

        $q = $db->createInsertQuery();
        $q->insertInto( $db->quoteIdentifier( $this->indexTableName ) )
          ->set( 'parent_id', $q->bindValue( $parentId ) )
          ->set( 'id', $q->bindValue( $childNode->id ) )
          ->set( 'path', $q->bindValue( $path . '/' . $childNode->id ) );
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

        list( $origParentId, $origPath ) = $this->fetchNodeInformation( $id );
        list( $targetParentParentId, $targetParentPath ) = $this->fetchNodeInformation( $targetParentId );

        // Get path to parent of $id
        // - position of last /
        $pos = strrpos( $origPath, '/' );
        // - parent path and its length
        $parentPath = substr( $origPath, 0, $pos );
        $parentPathLength = strlen( $parentPath ) + 1;

        $db = $this->dbh;

        // Update parent ID in node $id
        $q = $db->createUpdateQuery();
        $q->update( $db->quoteIdentifier( $this->indexTableName ) )
          ->set( 'parent_id', $q->bindValue( $targetParentId ) )
          ->where( $q->expr->eq( 'id', $q->bindValue( $id ) ) );
        $s = $q->prepare();
        $s->execute();

        // Update paths for subtree
        // UPDATE indexTable
        // SET path = $targetParentPath || SUBSTR( path, $parentPathLength ) )
        // WHERE id = $id
        //    OR path LIKE '$origPath/%'
        $q = $db->createUpdateQuery();
        $q->update( $db->quoteIdentifier( $this->indexTableName ) )
          ->set( 'path', $q->expr->concat(
                             $q->bindValue( $targetParentPath ),
                             $q->expr->subString( 'path', $q->bindValue( $parentPathLength ) )
            ) )
          ->where( $q->expr->lOr(
                $q->expr->eq( 'id', $q->bindValue( $id ) ),
                $q->expr->like( 'path', $q->bindValue( "$origPath/%" ) )
            ) );
        $s = $q->prepare();
        $s->execute();
    }

    public function fixateTransaction()
    {
    }
}
?>
