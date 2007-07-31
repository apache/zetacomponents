<?php
/**
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package Tree
 * @subpackage Tests
 */

require_once 'tree.php';
require_once 'db_tree.php';

/**
 * @package Tree
 * @subpackage Tests
 */
class ezcTreeDbParentChildTest extends ezcDbTreeTest
{
    private $tempDir;

    protected function setUp()
    {
        parent::setUp();
    }

    protected function tearDown()
    {
    }

    protected function setUpTestTree()
    {
        $store = new ezcTreeDbExternalTableDataStore( $this->dbh, 'data', 'id', 'data' );
        $tree = new ezcTreeDbParentChild(
            $this->dbh,
            'parent_child',
            $store
        );
        return $tree;
    }

    protected function emptyTables()
    {
        $db = $this->dbh;

        $q = $db->createDeleteQuery();
        $q->deleteFrom( 'parent_child' );
        $s = $q->prepare();
        $s->execute();

        $q = $db->createDeleteQuery();
        $q->deleteFrom( 'data' );
        $s = $q->prepare();
        $s->execute();
    }

    public function testCreateDbTree()
    {
        $this->emptyTables();

        $store = new ezcTreeDbExternalTableDataStore( $this->dbh, 'data', 'id', 'data' );
        $tree = ezcTreeDbParentChild::create(
            $this->dbh,
            'parent_child',
            $store
        );
        self::assertSame( false, $tree->nodeExists( '1' ) );
        self::assertSame( false, $tree->nodeExists( '3' ) );

        $node = $tree->createNode( 1, "Root Node" );
        self::assertType( 'ezcTreeNode', $node );
        self::assertSame( '1', $node->id );
        $tree->setRootNode( $node );
        self::assertSame( true, $tree->nodeExists( '1' ) );

        $node2 = $tree->createNode( 2, "Node 2" );
        $node->addChild( $node2 );
        self::assertSame( true, $tree->nodeExists( '2' ) );

        $node->addChild( $node3 = $tree->createNode( 3, "Node 3" ) );
        $node3->addChild( $tree->createNode( 4, "Node 3.4" ) );
        self::assertSame( true, $tree->nodeExists( '3' ) );
        self::assertSame( true, $tree->nodeExists( '4' ) );
    }

    public function testCreateDbTreeWithTransaction()
    {
        $store = new ezcTreeDbExternalTableDataStore( $this->dbh, 'data', 'id', 'data' );
        $tree = ezcTreeDbParentChild::create(
            $this->dbh,
            'parent_child',
            $store
        );

        $tree->setRootNode( $node = $tree->createNode( 1, "Root Node" ) );
        self::assertSame( true, $tree->nodeExists( '1' ) );

        $tree->beginTransaction();
        $node->addChild( $tree->createNode( 2, "Node 2" ) );
        $node->addChild( $node3 = $tree->createNode( 3, "Node 3" ) );
        $node3->addChild( $tree->createNode( 4, "Node 3.4" ) );

        self::assertSame( false, $tree->nodeExists( '3' ) );
        
        $tree->commit();
        
        self::assertSame( true, $tree->nodeExists( '3' ) );
    }

    public function testMultipleDataFields()
    {
        $store = new ezcTreeDbExternalTableDataStore( $this->dbh, 'data', 'id' );
        $tree = new ezcTreeDbParentChild(
            $this->dbh,
            'parent_child',
            $store
        );
        $node8 = $tree->fetchNodeById( 8 ); // returns 8
        self::assertType( 'ezcTreeNode', $node8 );
        self::assertSame( '8', $node8->id );
        self::assertSame( array( 'data' => 'Node 8', 0 => 'Node 8', 'id' => '8', 1 => '8' ), $node8->data );
    }

    public static function suite()
    {
         return new PHPUnit_Framework_TestSuite( "ezcTreeDbParentChildTest" );
    }
}

?>
