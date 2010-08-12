<?php
/**
 *
 * Licensed to the Apache Software Foundation (ASF) under one
 * or more contributor license agreements.  See the NOTICE file
 * distributed with this work for additional information
 * regarding copyright ownership.  The ASF licenses this file
 * to you under the Apache License, Version 2.0 (the
 * "License"); you may not use this file except in compliance
 * with the License.  You may obtain a copy of the License at
 * 
 *   http://www.apache.org/licenses/LICENSE-2.0
 * 
 * Unless required by applicable law or agreed to in writing,
 * software distributed under the License is distributed on an
 * "AS IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS OF ANY
 * KIND, either express or implied.  See the License for the
 * specific language governing permissions and limitations
 * under the License.
 *
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
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

    protected function setUpEmptyTestTree( $dataTable = 'data', $dataField = 'data', $indexTableSuffix = '' )
    {
        $store = new ezcTreeDbExternalTableDataStore( $this->dbh, $dataTable, 'id', $dataField );
        $tree = ezcTreeDbParentChild::create(
            $this->dbh,
            'parent_child' . $indexTableSuffix,
            $store
        );
        $this->emptyTables();
        return $tree;
    }

    protected function setUpTestTree( $dataTable = 'data', $dataField = 'data', $indexTableSuffix = '' )
    {
        $store = new ezcTreeDbExternalTableDataStore( $this->dbh, $dataTable, 'id', $dataField );
        $tree = new ezcTreeDbParentChild(
            $this->dbh,
            'parent_child' . $indexTableSuffix,
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
