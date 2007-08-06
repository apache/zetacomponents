<?php
/**
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package Tree
 */

/**
 * ezcTreeDbNestedSet implements a tree backend which stores parent/child
 * information with left and right values.
 *
 * The table that stores the index (configured using the $indexTableName argument
 * of the {@see __construct} method) should contain atleast four fields. The
 * first one 'id' will contain the node's ID, the second one 'parent_id' the ID
 * of the node's parent. Both fields should be of the same database field type.
 * Supported field types are either integer or a string type.  The other two
 * fields "lft" and "rgt" will store the left and right values that the
 * algorithm requires. These two fields should be of an integer type.
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
class ezcTreeDbNestedSet extends ezcTreeDb
{
    /**
     * Creates a new ezcTreeDbNestedSet object.
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
        return new ezcTreeDbNestedSet( $dbh, $indexTableName, $store );
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

        $db = $this->dbh;
        $q = $db->createSelectQuery();

        // SELECT parent.id
        // FROM indexTable as node,
        //      indexTable as parent
        // WHERE
        //     node.lft BETWEEN parent.lft AND parent.rgt
        //     AND
        //     node.if = $id
        // ORDER BY parent.lft
        $q->select( 'parent.id' )
          ->from( $db->quoteIdentifier( $this->indexTableName ) . " as node" )
          ->from( $db->quoteIdentifier( $this->indexTableName ) . " as parent" )
          ->where( $q->expr->lAnd(
              $q->expr->between( 'node.lft', 'parent.lft', 'parent.rgt' ),
              $q->expr->eq( 'node.id', $q->bindValue( $id ) )
            ))
          ->orderBy( 'parent.lft' );

        $s = $q->prepare();
        $s->execute();

        foreach ( $s as $result )
        {
            $list->addNode( new $className( $this, $result['id'] ) );
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
        $db = $this->dbh;

        // Fetch parent information
        list( $left, $right, $width ) = $this->fetchNodeInformation( $nodeId );

        // Fetch subtree
        //   SELECT id
        //   FROM indexTable
        //   WHERE lft BETWEEN $left AND $right
        //   ORDER BY lft
        $q = $db->createSelectQuery();
        $q->select( 'id' )
          ->from( $db->quoteIdentifier( $this->indexTableName ) )
          ->where( $q->expr->between( 'lft', $q->bindValue( $left ), $q->bindValue( $right ) ) )
          ->orderBy( 'lft' );
        $s = $q->prepare();
        $s->execute();

        foreach ( $s as $result )
        {
            $list->addNode( new $className( $this, $result['id'] ) );
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

        // Remove nodes from tree
        //   DELETE FROM indexTable
        $q = $db->createDeleteQuery();
        $q->deleteFrom( $db->quoteIdentifier( $this->indexTableName ) );
        $s = $q->prepare();
        $s->execute();

        // Remove all data belonging to those nodes
        $this->store->deleteDataForAllNodes();

        // Create new root node
        //   INSERT INTO indexTable
        //   SET parent_id = null,
        //       id = $node->id,
        //       lft = 1, rgt = 2
        $q = $db->createInsertQuery();
        $q->insertInto( $db->quoteIdentifier( $this->indexTableName ) )
          ->set( 'parent_id', "null" )
          ->set( 'id', $q->bindValue( $node->id ) )
          ->set( 'lft', 1 )
          ->set( 'rgt', 2 );
        $s = $q->prepare();
        $s->execute();

        // Store data for new root node
        $this->store->storeDataForNode( $node, $node->data );
    }

    /**
     * Updates the left and right values of the nodes that are added while
     * adding a whole subtree as child of a node.
     *
     * The method does not update nodes where the IDs are in the $excludedIds
     * list.
     *
     * @param int $right
     * @param int $width
     * @param array(string) $excludedIds
     */
    protected function updateNestedValuesForSubtreeAddition( $right, $width, $excludedIds = array() )
    {
        $db = $this->dbh;

        // Move all the right values + $width for nodes where the the right value >=
        // the parent right value:
        //   UPDATE indexTable
        //   SET rgt = rgt + $width
        //   WHERE rgt >= $right
        $q = $db->createUpdateQuery();
        $q->update( $db->quoteIdentifier( $this->indexTableName ) )
          ->set( 'rgt', $q->expr->add( 'rgt', $width ) )
          ->where( $q->expr->gte( 'rgt', $right ) );
        if ( count( $excludedIds ) )
        {
            $q->where( $q->expr->not( $q->expr->in( 'id', $excludedIds ) ) );
        }
        $q->prepare()->execute();

        // Move all the left values + $width for nodes where the the right value >=
        // the parent left value
        //   UPDATE indexTable
        //   SET lft = lft + $width
        //   WHERE lft >= $right
        $q = $db->createUpdateQuery();
        $q->update( $db->quoteIdentifier( $this->indexTableName ) )
          ->set( 'lft', $q->expr->add( 'lft', $width ) )
          ->where( $q->expr->gte( 'lft', $right ) );
        if ( count( $excludedIds ) )
        {
            $q->where( $q->expr->not( $q->expr->in( 'id', $excludedIds ) ) );
        }
        $q->prepare()->execute();
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

        // Fetch parent's information
        list( $left, $right, $width ) = $this->fetchNodeInformation( $parentId );

        // Update left and right values to account for new subtree
        $this->updateNestedValuesForSubtreeAddition( $right, $width );

        // Add new node
        if ( $width == 2 )
        {
            $newLeft = $left + 1;
            $newRight = $left + 2;
        }
        else
        {
            $newLeft = $right;
            $newRight = $right + 1;
        }

        // INSERT INTO indexTable
        // SET parent_id = $parentId,
        //     id = $childNode->id,
        //     lft = $newLeft,
        //     rgt = $newRight
        $q = $db->createInsertQuery();
        $q->insertInto( $db->quoteIdentifier( $this->indexTableName ) )
          ->set( 'parent_id', $q->bindValue( $parentId ) )
          ->set( 'id', $q->bindValue( $childNode->id ) )
          ->set( 'lft', $q->bindValue( $newLeft ) )
          ->set( 'rgt', $q->bindValue( $newRight ) );
        $s = $q->prepare();
        $s->execute();

        // Add the data for the new node
        $this->store->storeDataForNode( $childNode, $childNode->data );
    }

    /**
     * Returns the left, right and width values for the node with ID $id as an
     * array.
     *
     * The format of the array is:
     * - 0: left value
     * - 1: right value
     * - 2: width value (right - left + 1)
     *
     * @param string $id
     * @return array(int)
     */
    protected function fetchNodeInformation( $id )
    {
        $db = $this->dbh;

        // SELECT lft, rgt, rft-lft+1 as width
        // FROM indexTable
        // WHERE id = $id
        $q = $db->createSelectQuery();
        $q->select( 'lft, rgt, rgt - lft + 1 as width' )
          ->from( $db->quoteIdentifier( $this->indexTableName ) )
          ->where( $q->expr->eq( 'id', $q->bindValue( $id ) ) );
        $s = $q->prepare();
        $s->execute();
        $r = $s->fetchAll( PDO::FETCH_NUM );
        return $r[0];
    }

    /**
     * Updates the left and right values in case a subtree is deleted
     *
     * @param int $right
     * @param int $width
     */
    protected function updateNestedValuesForSubtreeDeletion( $right, $width )
    {
        $db = $this->dbh;

        // Move all the right values + $width for nodes where the the right
        // value > the parent right value
        //   UPDATE indexTable
        //   SET rgt = rgt - $width
        //   WHERE rgt > $right
        $q = $db->createUpdateQuery();
        $q->update( $db->quoteIdentifier( $this->indexTableName ) )
          ->set( 'rgt', $q->expr->sub( 'rgt', $width ) )
          ->where( $q->expr->gt( 'rgt', $right ) );
        $q->prepare()->execute();

        // Move all the right values + $width for nodes where the the left
        // value > the parent right value
        //   UPDATE indexTable
        //   SET lft = lft - $width
        //   WHERE lft > $right
        $q = $db->createUpdateQuery();
        $q->update( $db->quoteIdentifier( $this->indexTableName ) )
          ->set( 'lft', $q->expr->sub( 'lft', $width ) )
          ->where( $q->expr->gt( 'lft', $right ) );
        $q->prepare()->execute();
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

        // Delete all data for the deleted nodes
        $nodeList = $this->fetchSubtree( $id );
        $this->store->deleteDataForNodes( $nodeList );

        // Fetch node information
        list( $left, $right, $width ) = $this->fetchNodeInformation( $id );

        // DELETE FROM indexTable
        // WHERE lft BETWEEN $left and $right
        $db = $this->dbh;
        $q = $db->createDeleteQuery();
        $q->deleteFrom( $db->quoteIdentifier( $this->indexTableName ) )
          ->where( $q->expr->between( 'lft', $left, $right ) );
        $s = $q->prepare();
        $s->execute();

        // Update the left and right values to account for the removed subtree
        $this->updateNestedValuesForSubtreeDeletion( $right, $width );
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

        // Get the nodes that are gonne be moved in the subtree
        $ids = array();
        foreach( $this->fetchSubtreeDepthFirst( $id )->getNodes() as $node )
        {
            $ids[] = $node->id;
        }

        // Update parent ID for the node
        //   UPDATE indexTable
        //   SET parent_id = $targetParentId
        //   WHERE id = $id
        $q = $db->createUpdateQuery();
        $q->update( $db->quoteIdentifier( $this->indexTableName ) )
          ->set( 'parent_id', $q->bindValue( $targetParentId ) )
          ->where( $q->expr->eq( 'id', $q->bindValue( $id ) ) );

        $s = $q->prepare();
        $s->execute();

        // Fetch node information
        list( $origLeft, $origRight, $origWidth ) = $this->fetchNodeInformation( $id );

        // Update the nested values to account for the moved subtree (delete part)
        $this->updateNestedValuesForSubtreeDeletion( $origRight, $origWidth );

        // Fetch node information
        list( $targetParentLeft, $targetParentRight, $targerParentWidth ) = $this->fetchNodeInformation( $targetParentId );

        // Update the nested values to account for the moved subtree (addition part)
        $this->updateNestedValuesForSubtreeAddition( $targetParentRight, $origWidth, $ids );

        // Update nodes in moved subtree
        $adjust = $targetParentRight - $origLeft;

        // UPDATE indexTable
        // SET rgt = rgt + $adjust
        // WHERE id in $ids
        $q = $db->createUpdateQuery();
        $q->update( $db->quoteIdentifier( $this->indexTableName ) )
          ->set( 'rgt', $q->expr->add( 'rgt', $adjust ) )
          ->where( $q->expr->in( 'id', $ids ) );
        $q->prepare()->execute();

        // UPDATE indexTable
        // SET lft = lft + $adjust
        // WHERE id in $ids
        $q = $db->createUpdateQuery();
        $q->update( $db->quoteIdentifier( $this->indexTableName ) )
          ->set( 'lft', $q->expr->add( 'lft', $adjust ) )
          ->where( $q->expr->in( 'id', $ids ) );
        $q->prepare()->execute();
    }

    public function fixateTransaction()
    {
    }
}
?>
