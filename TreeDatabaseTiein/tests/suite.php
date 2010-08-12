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

/**
 * Require the tests
 */
require_once 'Tree/tests/tree.php';
require_once 'db_materialized_path_tree.php';
require_once 'db_materialized_path_tree_diff_separator.php';
require_once 'db_nested_set_tree.php';
require_once 'db_parent_child_tree.php';
require_once 'copy_tree.php';
require_once 'xml_tree_db_storage.php';

/**
 * @package TreeDatabaseTiein
 * @subpackage Tests
 */
class ezcTreeDatabaseTieinSuite extends PHPUnit_Framework_TestSuite
{
    public function __construct()
    {
        parent::__construct();
        $this->setName("TreeDatabaseTiein");

        $this->addTest( ezcTreeDbMaterializedPathTest::suite() );
        $this->addTest( ezcTreeDbMaterializedPathTestWithDifferentSeparator::suite() );
        $this->addTest( ezcTreeDbNestedSetTest::suite() );
        $this->addTest( ezcTreeDbParentChildTest::suite() );
        $this->addTest( ezcTreeDbCopyTest::suite() );
        $this->addTest( ezcTreeXmlWithDbStorageTest::suite() );
    }

    public static function suite()
    {
        return new ezcTreeDatabaseTieinSuite();
    }
}

?>
