<?php
/**
 * @copyright Copyright (C) 2005-2010 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package TreeDatabaseTiein
 * @subpackage Tests
 */

require_once 'Tree/tests/tree.php';

/**
 * @package TreeDatabaseTiein
 * @subpackage Tests
 */
abstract class ezcDbTreeTest extends ezcTreeTest
{
    protected $dbh;

    protected function setUp()
    {
        try
        {
            $this->dbh = ezcDbInstance::get();
            $this->removeTables();
            $this->loadSchema();
            $this->insertData();
        }
        catch ( Exception $e )
        {
            $this->markTestSkipped( $e->getMessage() );
        }
    }

    private function loadSchema()
    {
        // create the parent_child table
        $schema = ezcDbSchema::createFromFile(
            'array',
            dirname( __FILE__ ) . '/files/' . $this->schemaName
        );
        $schema->writeToDb( $this->dbh );
    }

    protected function emptyTables()
    {
        $db = $this->dbh;

        foreach ( $this->tables as $table )
        {
            $q = $db->createDeleteQuery();
            $q->deleteFrom( $table );
            $s = $q->prepare();
            $s->execute();
        }
    }

    protected function removeTables()
    {
        try
        {
            foreach ( $this->tables as $table )
            {
                $this->dbh->exec( "DROP TABLE $table" );
            }
        }
        catch ( Exception $e )
        {
            // ignore
        }
    }

    abstract protected function insertData();
    abstract protected function setUpEmptyTestTree();
    abstract protected function setUpTestTree();

    public function testCreateDbTree()
    {
        $tree = $this->setUpEmptyTestTree();

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

    public function testCreateDbTreeStoreData()
    {
        $tree = $this->setUpEmptyTestTree();

        $root = $tree->createNode( 1, "Pantherinae" );
        $tree->setRootNode( $root );

        $root->addChild( $panthera = $tree->createNode( 2, "Panthera" ) );
        $root->addChild( $neofelis = $tree->createNode( 3, "Neofelis" ) );
        $root->addChild( $uncia = $tree->createNode( 4, "Uncia" ) );

        $panthera->addChild( $tree->createNode( 5, "Lion" ) );
        $panthera->addChild( $tree->createNode( 6, "Jaguar" ) );
        $panthera->addChild( $tree->createNode( 7, "Leopard" ) );
        $panthera->addChild( $tree->createNode( 8, "Tiger" ) );

        $neofelis->addChild( $tree->createNode( 9, "Clouded Leopard" ) );
        $neofelis->addChild( $tree->createNode( 10, "Bornean Clouded Leopard" ) );

        $uncia->addChild( $tree->createNode( 11, "Snow Leopard" ) );

        // start over
        $tree = $this->setUpTestTree();

        self::assertSame( true, $tree->nodeExists( '1' ) );
        self::assertSame( true, $tree->nodeExists( '2' ) );
        self::assertSame( true, $tree->nodeExists( '3' ) );
        self::assertSame( true, $tree->nodeExists( '4' ) );
        self::assertSame( "Snow Leopard", $tree->fetchNodeById( '11' )->data );
    }

    public function testCreateDbTreeStoreDataPrefetch()
    {
        $tree = $this->setUpEmptyTestTree();

        $root = $tree->createNode( 1, "Pantherinae" );
        $tree->setRootNode( $root );

        $root->addChild( $panthera = $tree->createNode( 2, "Panthera" ) );
        $root->addChild( $neofelis = $tree->createNode( 3, "Neofelis" ) );
        $root->addChild( $uncia = $tree->createNode( 4, "Uncia" ) );

        $panthera->addChild( $tree->createNode( 5, "Lion" ) );
        $panthera->addChild( $tree->createNode( 6, "Jaguar" ) );
        $panthera->addChild( $tree->createNode( 7, "Leopard" ) );
        $panthera->addChild( $tree->createNode( 8, "Tiger" ) );

        $neofelis->addChild( $tree->createNode( 9, "Clouded Leopard" ) );
        $neofelis->addChild( $tree->createNode( 10, "Bornean Clouded Leopard" ) );

        $uncia->addChild( $tree->createNode( 11, "Snow Leopard" ) );

        // start over
        $tree = $this->setUpTestTree();

        $nodeList = $tree->fetchSubtree( '3' );

        $expected = "something's wrong";
        foreach ( new ezcTreeNodeListIterator( $tree, $nodeList, true ) as $id => $data )
        {
            switch ( $id )
            {
                case 3:
                    $expected = "Neofelis";
                    break;
                case 9:
                    $expected = "Clouded Leopard";
                    break;
                case 10:
                    $expected = "Bornean Clouded Leopard";
                    break;
            }
            self::assertSame( $expected, $data );
        }
    }

    public function testStoreUpdatedData()
    {
        $tree = $this->setUpEmptyTestTree();

        $root = $tree->createNode( 1, "Camelinae" );
        $tree->setRootNode( $root );

        $root->addChild( $tree->createNode( 2, "Lama" ) );
        $root->addChild( $tree->createNode( 3, "Vicugna" ) );
        $root->addChild( $tree->createNode( 4, "Camelus" ) );

        // start over
        $tree = $this->setUpTestTree();

        $camelus = $tree->fetchNodeById( 4 );
        self::assertSame( "Camelus", $camelus->data );
        $camelus->data = "Something Wrong";
        $camelus->data = "Camels";

        // start over
        $tree = $this->setUpTestTree();

        $camelus = $tree->fetchNodeById( 4 );
        self::assertSame( "Camels", $camelus->data );
    }

    public function testCreateDbTreeWithTransaction()
    {
        $tree = $this->setUpEmptyTestTree();

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
        $tree = $this->setUpTestTree( 'data', null );

        $node8 = $tree->fetchNodeById( 8 ); // returns 8
        self::assertType( 'ezcTreeNode', $node8 );
        self::assertSame( '8', $node8->id );
        self::assertSame( array( 'data' => 'Node 8' ), $node8->data );
    }

    public function testStoreUpdatedDataMultipleDataFields()
    {
        $tree = $this->setUpEmptyTestTree( 'datam', null );

        $root = $tree->createNode( 1, array( 'name' => 'Harald V', 'born' => '1937' ) );
        $tree->setRootNode( $root );

        $root->addChild( $tree->createNode( 2, array( 'name' => 'Haakon', 'born' => '1973' ) ) );
        $root->addChild( $tree->createNode( 3, array( 'name' => 'Märtha Louise', 'born' => '1971' ) ) );

        // start over
        $tree = $this->setUpTestTree( 'datam', null );

        $haakon = $tree->fetchNodeById( 2 );
        self::assertEquals( array( 'name' => 'Haakon', 'born' => '1973' ), $haakon->data );
        $haakon->data = array( 'name' => 'Haakon', 'born' => 1981 );
        $haakon->data = array( 'name' => 'Haakon', 'born' => 1983 );

        // start over
        $tree = $this->setUpTestTree( 'datam', null );

        $haakon = $tree->fetchNodeById( 2 );
        self::assertEquals( array( 'name' => 'Haakon', 'born' => '1983' ), $haakon->data );
    }

    public function testNodeListIteratorEmptyList()
    {
        $tree = $this->setUpEmptyTestTree();
        $list = new ezcTreeNodeList;

        foreach ( new ezcTreeNodeListIterator( $tree, $list, true ) as $key => $node )
        {
            self::fail( "The list is not empty." );
        }
    }
}

?>
