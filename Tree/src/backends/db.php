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
abstract class ezcTreeDb extends ezcTree implements ezcTreeBackend
{
    protected $dbh;

    protected $indexTableName;

    /**
     * Constructs a new ezcTreeXml object
     */
    public function __construct( ezcDbHandler $dbh, $indexTableName, ezcTreeDbDataStore $store )
    {
        parent::__construct();
        $this->dbh = $dbh;
        $this->indexTableName = $indexTableName;
        $this->properties['store'] = $store;
    }

    public function nodeExists( $id )
    {
        $db = $this->dbh;
        $q = $db->createSelectQuery();

        $q->select( 'id' )
          ->from( $db->quoteIdentifier( $this->indexTableName ) )
          ->where( $q->expr->eq( 'id', $q->bindValue( $id ) ) );

        $s = $q->prepare();
        $s->execute();

        return count( $s->fetchAll() ) ? true : false;
    }

    public function fetchChildren( $id )
    {
    }

    public function fetchPath( $id )
    {
    }

    public function fetchSubtree( $id, $searchMethod = ezcTree::DEPTH_FIRST )
    {
    }

    public function getChildCount( $id )
    {
    }

    public function getChildCountRecursive( $id )
    {
    }

    public function getPathLength( $id )
    {
    }

    public function hasChildNodes( $id )
    {
    }

    public function isDecendantOf( $childId, $parentId )
    {
    }

    public function isSiblingOf( $child1Id, $child2Id )
    {
    }

    public function setRootNode( ezcTreeNode $node )
    {
    }

    public function addChild( $parentId, ezcTreeNode $childNode )
    {
    }

    public function delete( $id )
    {
    }

    public function move( $id, $targetParentId )
    {
    }
}
?>
