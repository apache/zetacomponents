<?php
/**
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package TreeDatabaseTiein
 * @subpackage Tests
 */

require_once 'Tree/tests/tree.php';
require_once 'db_tree.php';

/**
 * @package TreeDatabaseTiein
 * @subpackage Tests
 */
class ezcTreeDbNestedSetTest extends ezcDbTreeTest
{
    private $tempDir;

    protected $tables  = array( 'nested_set', 'data', 'datam' );
    protected $schemaName = 'nested_set.dba';

    public function insertData()
    {
        // insert test data
        $data = array(
            // child -> parent
            1 => array( 'null',  1, 18 ),
            2 => array(      1,  2,  3 ),
            3 => array(      1,  4,  5 ),
            4 => array(      1,  6, 13 ),
            6 => array(      4,  7, 12 ),
            7 => array(      6,  8,  9 ),
            8 => array(      6, 10, 11 ),
            5 => array(      1, 14, 17 ),
            9 => array(      5, 15, 16 ),
        );
        foreach( $data as $childId => $details )
        {
            list( $parentId, $left, $right ) = $details;
            $this->dbh->exec( "INSERT INTO nested_set(id, parent_id, lft, rgt) VALUES( $childId, $parentId, $left, $right )" );
        }

        // add data
        for ( $i = 1; $i <= 8; $i++ )
        {
            $this->dbh->exec( "INSERT INTO data(id, data) values ( $i, 'Node $i' )" );
        }
    }

    protected function setUpEmptyTestTree( $dataTable = 'data', $dataField = 'data', $indexTableSuffix = '' )
    {
        $store = new ezcTreeDbExternalTableDataStore( $this->dbh, $dataTable, 'id', $dataField );
        $tree = ezcTreeDbNestedSet::create(
            $this->dbh,
            'nested_set' . $indexTableSuffix,
            $store
        );
        $this->emptyTables();
        return $tree;
    }

    protected function setUpTestTree( $dataTable = 'data', $dataField = 'data', $indexTableSuffix = '' )
    {
        $store = new ezcTreeDbExternalTableDataStore( $this->dbh, $dataTable, 'id', $dataField );
        $tree = new ezcTreeDbNestedSet(
            $this->dbh,
            'nested_set' . $indexTableSuffix,
            $store
        );
        return $tree;
    }

    public function testVerifyLeftRightValues1()
    {
        $tree = $this->setUpEmptyTestTree();

        $node = $tree->createNode( 1, "één" );
        $tree->setRootNode( $node );
        $this->assertLeftRight( 1, 1, 2 );

        $node->addChild( $node2 = $tree->createNode( 2, "twee" ) );
        $this->assertLeftRight( 1, 1, 4 );
        $this->assertLeftRight( 2, 2, 3 );

        $node->addChild( $node3 = $tree->createNode( 3, "drie" ) );
        $this->assertLeftRight( 1, 1, 6 );
        $this->assertLeftRight( 2, 2, 3 );
        $this->assertLeftRight( 3, 4, 5 );

        $node3->addChild( $node4 = $tree->createNode( 4, "vier" ) );
        $this->assertLeftRight( 1, 1, 8 );
        $this->assertLeftRight( 2, 2, 3 );
        $this->assertLeftRight( 3, 4, 7 );
        $this->assertLeftRight( 4, 5, 6 );

        $node4->addChild( $tree->createNode( 5, "vijf" ) );
        $this->assertLeftRight( 1, 1, 10 );
        $this->assertLeftRight( 2, 2,  3 );
        $this->assertLeftRight( 3, 4,  9 );
        $this->assertLeftRight( 4, 5,  8 );
        $this->assertLeftRight( 5, 6,  7 );

        $node4->addChild( $tree->createNode( 6, "zes" ) );
        $this->assertLeftRight( 1, 1, 12 );
        $this->assertLeftRight( 2, 2,  3 );
        $this->assertLeftRight( 3, 4, 11 );
        $this->assertLeftRight( 4, 5, 10 );
        $this->assertLeftRight( 5, 6,  7 );
        $this->assertLeftRight( 6, 8,  9 );

        $node->addChild( $node7 = $tree->createNode( 7, "zeven" ) );
        $this->assertLeftRight( 1,  1, 14 );
        $this->assertLeftRight( 2,  2,  3 );
        $this->assertLeftRight( 3,  4, 11 );
        $this->assertLeftRight( 4,  5, 10 );
        $this->assertLeftRight( 5,  6,  7 );
        $this->assertLeftRight( 6,  8,  9 );
        $this->assertLeftRight( 7, 12, 13 );

        $node7->addChild( $node8 = $tree->createNode( 8, "acht" ) );
        $this->assertLeftRight( 1,  1, 16 );
        $this->assertLeftRight( 2,  2,  3 );
        $this->assertLeftRight( 3,  4, 11 );
        $this->assertLeftRight( 4,  5, 10 );
        $this->assertLeftRight( 5,  6,  7 );
        $this->assertLeftRight( 6,  8,  9 );
        $this->assertLeftRight( 7, 12, 15 );
        $this->assertLeftRight( 8, 13, 14 );

        $node8->addChild( $tree->createNode( 9, "negen" ) );
        $this->assertLeftRight( 1,  1, 18 );
        $this->assertLeftRight( 2,  2,  3 );
        $this->assertLeftRight( 3,  4, 11 );
        $this->assertLeftRight( 4,  5, 10 );
        $this->assertLeftRight( 5,  6,  7 );
        $this->assertLeftRight( 6,  8,  9 );
        $this->assertLeftRight( 7, 12, 17 );
        $this->assertLeftRight( 8, 13, 16 );
        $this->assertLeftRight( 9, 14, 15 );
    }

    private function assertLeftRight( $id, $left, $right )
    {
        $q = $this->dbh->createSelectQuery();
        $q->select( 'lft', 'rgt' )
          ->from( 'nested_set' )
          ->where( $q->expr->eq( 'id', $q->bindValue( $id ) ) );
        $s = $q->prepare();
        $s->execute();

        $r = $s->fetch( PDO::FETCH_ASSOC );
        if ( $r['lft'] != $left )
        {
            $this->fail( "Expected left value for node '$id' was not '$left', but '{$r['lft']}'." );
        }
        if ( $r['rgt'] != $right )
        {
            $this->fail( "Expected right value for node '$id' was not '$right', but '{$r['rgt']}'." );
        }

    }

    public static function suite()
    {
         return new PHPUnit_Framework_TestSuite( "ezcTreeDbNestedSetTest" );
    }
}

?>
