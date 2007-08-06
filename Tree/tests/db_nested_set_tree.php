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

    protected function setUpEmptyTestTree( $dataTable = 'data', $dataField = 'data' )
    {
        $store = new ezcTreeDbExternalTableDataStore( $this->dbh, $dataTable, 'id', $dataField );
        $tree = ezcTreeDbNestedSet::create(
            $this->dbh,
            'nested_set',
            $store
        );
        $this->emptyTables();
        return $tree;
    }

    protected function setUpTestTree( $dataTable = 'data', $dataField = 'data' )
    {
        $store = new ezcTreeDbExternalTableDataStore( $this->dbh, $dataTable, 'id', $dataField );
        $tree = new ezcTreeDbNestedSet(
            $this->dbh,
            'nested_set',
            $store
        );
        return $tree;
    }

    public static function suite()
    {
         return new PHPUnit_Framework_TestSuite( "ezcTreeDbNestedSetTest" );
    }
}

?>
