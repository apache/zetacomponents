<?php
/**
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package Tree
 */

/**
 * ezcTreeXml is an implementation of a tree backend that operates on
 * an XML file.
 *
 * @property-read ezcTreeXmlDataStore $store
 *
 * @package Tree
 * @version //autogentag//
 * @mainclass
 */
class ezcTreeDbParentChild extends ezcTreeDb
{
    public static function create( ezcDbHandler $dbh, $indexTableName, ezcTreeDbDataStore $store )
    {
        return new ezcTreeDbParentChild( $dbh, $indexTableName, $store );
    }

    private function getParentId( $childId )
    {
        $db = $this->dbh;
        $q = $db->createSelectQuery();

        $q->select( 'id, parent_id' )
          ->from( $db->quoteIdentifier( $this->indexTableName ) )
          ->where( $q->expr->eq( 'id', $q->bindValue( $childId ) ) );

        $s = $q->prepare();
        $s->execute();
        $row = $s->fetch();
        return $row['parent_id'];
    }

    public function isChildOf( $childId, $parentId )
    {
        $id = $this->getParentId( $childId );
        $parentId = (string) $parentId;
        return $parentId === $id;
    }

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

    public function isSiblingOf( $child1Id, $child2Id )
    {
        $id1 = $this->getParentId( $child1Id );
        $id2 = $this->getParentId( $child2Id );
        return $id1 === $id2 && (string) $child1Id !== (string) $child2Id;
    }

    private function fetchChildRecords( $nodeId )
    {
        $db = $this->dbh;
        $q = $db->createSelectQuery();

        $q->select( 'id, parent_id' )
          ->from( $db->quoteIdentifier( $this->indexTableName ) )
          ->where( $q->expr->eq( 'parent_id', $q->bindValue( $nodeId ) ) );

        $s = $q->prepare();
        $s->execute();
        return $s;
    }

    private function addChildNodes( $list, $nodeId )
    {
        $className = $this->properties['nodeClassName'];
        foreach ( $this->fetchChildRecords( $nodeId ) as $record )
        {
            $list->addNode( new $className( $this, $record['id'] ) );
            $this->addChildNodes( $list, $record['id'] );
        }
    }

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

    public function getChildCount( $nodeId )
    {
        $db = $this->dbh;
        $q = $db->createSelectQuery();

        $q->select( 'count(id)' )
          ->from( $db->quoteIdentifier( $this->indexTableName ) )
          ->where( $q->expr->eq( 'parent_id', $q->bindValue( $nodeId ) ) );

        $s = $q->prepare();
        $s->execute();
        return (int) $s->fetchColumn(0);
    }

    private function countChildNodes( &$count, $nodeId )
    {
        foreach ( $this->fetchChildRecords( $nodeId ) as $record )
        {
            $count++;
            $this->countChildNodes( $count, $record['id'] );
        }
    }

    public function getChildCountRecursive( $id )
    {
        $count = 0;
        $this->countChildNodes( $count, $id );
        return $count;
    }

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

    public function hasChildNodes( $nodeId )
    {
        return $this->getChildCount( $nodeId ) > 0;
    }


    public function setRootNode( ezcTreeNode $node )
    {
        $db = $this->dbh;

        $q = $db->createDeleteQuery();
        $q->deleteFrom( $db->quoteIdentifier( $this->indexTableName ) );
        $s = $q->prepare();
        $s->execute();

        $q = $db->createInsertQuery();
        $q->insertInto( $db->quoteIdentifier( $this->indexTableName ) )
          ->set( 'parent_id', "null" )
          ->set( 'id', $q->bindValue( $node->id ) );
        $s = $q->prepare();
        $s->execute();

        $this->store->storeDataForNode( $node, $node->data );
    }

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

    protected function deleteChildNodes( $nodeId )
    {
        $db = $this->dbh;
        $q = $db->createDeleteQuery();

        foreach ( $this->fetchChildRecords( $nodeId ) as $record )
        {
            $this->deleteChildNodes( $record['id'] );
        }

        $q->deleteFrom( $db->quoteIdentifier( $this->indexTableName ) )
          ->where( $q->expr->eq( 'id', $q->bindValue( $nodeId ) ) );
        $s = $q->prepare();
        $s->execute();
    }

    public function delete( $id )
    {
        if ( $this->inTransaction )
        {
            $this->addTransactionItem( new ezcTreeTransactionItem( ezcTreeTransactionItem::DELETE, null, $id ) );
            return;
        }

        $this->deleteChildNodes( $id );
    }

    public function fixateTransaction()
    {
    }
}
?>
