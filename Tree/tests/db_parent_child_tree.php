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

    protected $tables  = array( 'parent_child', 'data', 'datam' );
    protected $schemaName = 'parent_child.dba';

    public function insertData()
    {
        // insert test data
        $data = array(
            // child -> parent
            1 => 'null',
            2 => 1,
            3 => 1,
            4 => 1,
            6 => 4,
            7 => 6,
            8 => 6,
            5 => 1,
            9 => 5
        );
        foreach( $data as $childId => $parentId )
        {
            $this->dbh->exec( "INSERT INTO parent_child(id, parent_id) VALUES( $childId, $parentId )" );
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
        $tree = ezcTreeDbParentChild::create(
            $this->dbh,
            'parent_child',
            $store
        );
        $this->emptyTables();
        return $tree;
    }

    protected function setUpTestTree( $dataTable = 'data', $dataField = 'data' )
    {
        $store = new ezcTreeDbExternalTableDataStore( $this->dbh, $dataTable, 'id', $dataField );
        $tree = new ezcTreeDbParentChild(
            $this->dbh,
            'parent_child',
            $store
        );
        return $tree;
    }

    public static function suite()
    {
         return new PHPUnit_Framework_TestSuite( "ezcTreeDbParentChildTest" );
    }
}

?>
