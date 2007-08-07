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
class ezcTreeDbMaterializedPathTest extends ezcDbTreeTest
{
    private $tempDir;

    protected $tables  = array( 'materialized_path', 'data', 'datam' );
    protected $schemaName = 'materialized_path.dba';

    public function insertData()
    {
        // insert test data
        $data = array(
            // child -> parent
            1 => array( 'null', '/1' ),
            2 => array(      1, '/1/2' ),
            3 => array(      1, '/1/3' ),
            4 => array(      1, '/1/4' ),
            6 => array(      4, '/1/4/6' ),
            7 => array(      6, '/1/4/6/7' ),
            8 => array(      6, '/1/4/6/8' ),
            5 => array(      1, '/1/5' ),
            9 => array(      5, '/1/5/9' ),
        );
        foreach( $data as $childId => $details )
        {
            list( $parentId, $path ) = $details;
            $this->dbh->exec( "INSERT INTO materialized_path(id, parent_id, path) VALUES( $childId, $parentId, '$path' )" );
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
        $tree = ezcTreeDbMaterializedPath::create(
            $this->dbh,
            'materialized_path',
            $store
        );
        $this->emptyTables();
        return $tree;
    }

    protected function setUpTestTree( $dataTable = 'data', $dataField = 'data' )
    {
        $store = new ezcTreeDbExternalTableDataStore( $this->dbh, $dataTable, 'id', $dataField );
        $tree = new ezcTreeDbMaterializedPath(
            $this->dbh,
            'materialized_path',
            $store
        );
        return $tree;
    }

    public static function suite()
    {
         return new PHPUnit_Framework_TestSuite( "ezcTreeDbMaterializedPathTest" );
    }
}

?>
