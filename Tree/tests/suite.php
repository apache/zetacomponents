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
 * @package Tree
 * @subpackage Tests
 */

/**
 * Require the tests
 */
require_once 'tree_node.php';
require_once 'tree_node_list.php';
require_once 'tree_node_list_iterator.php';
require_once 'memory_store.php';
require_once 'visitor.php';
require_once 'visitor_xhtml.php';
require_once 'visitor_xhtml_options.php';
require_once 'visitor_yui.php';
require_once 'visitor_yui_options.php';
require_once 'memory_tree.php';
require_once 'xml_tree.php';
require_once 'copy_tree.php';

/**
 * @package Tree
 * @subpackage Tests
 */
class ezcTreeSuite extends PHPUnit_Framework_TestSuite
{
    public function __construct()
    {
        parent::__construct();
        $this->setName("Tree");

        $this->addTest( ezcTreeNodeTest::suite() );
        $this->addTest( ezcTreeNodeListTest::suite() );
        $this->addTest( ezcTreeNodeListIteratorTest::suite() );
        $this->addTest( ezcTreeMemoryStoreTest::suite() );
        $this->addTest( ezcTreeVisitorTest::suite() );
        $this->addTest( ezcTreeVisitorXHTMLTest::suite() );
        $this->addTest( ezcTreeVisitorXHTMLOptionsTest::suite() );
        $this->addTest( ezcTreeVisitorYUITest::suite() );
        $this->addTest( ezcTreeVisitorYUIOptionsTest::suite() );
        $this->addTest( ezcTreeMemoryTest::suite() );
        $this->addTest( ezcTreeXmlTest::suite() );
        $this->addTest( ezcTreeCopyTest::suite() );
    }

    public static function suite()
    {
        return new ezcTreeSuite();
    }
}

?>
