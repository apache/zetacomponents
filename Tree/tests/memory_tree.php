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
 * @copyright Copyright (C) 2005-2010 eZ Systems AS. All rights reserved.
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 * @version //autogentag//
 * @filesource
 * @package Tree
 * @subpackage Tests
 */

require_once 'tree.php';

/**
 * @package Tree
 * @subpackage Tests
 */
class ezcTreeMemoryTest extends ezcTreeTest
{
    private $tempDir;

    protected function setUpEmptyTestTree()
    {
        $tree = ezcTreeMemory::create( new ezcTreeMemoryDataStore() );
        return $tree;
    }

    protected function setUpTestTree()
    {
        $tree = $this->setUpEmptyTestTree();
        $tree->setRootNode( $root = $tree->createNode( 1, 'Node 1' ) );

        $root->addChild( $node2 = $tree->createNode( 2, 'Node 2' ) );
        $root->addChild( $node3 = $tree->createNode( 3, 'Node 3' ) );
        $root->addChild( $node4 = $tree->createNode( 4, 'Node 4' ) );
        $root->addChild( $node5 = $tree->createNode( 5, 'Node 5' ) );

        $node4->addChild( $node6 = $tree->createNode( 6, 'Node 6' ) );
        $node6->addChild( $node7 = $tree->createNode( 7, 'Node 7' ) );
        $node6->addChild( $node8 = $tree->createNode( 8, 'Node 8' ) );

        $node5->addChild( $node9 = $tree->createNode( 9, 'Node 9' ) );

        return $tree;
    }

    public function testCreateMemoryTree()
    {
        $tree = ezcTreeMemory::create( new ezcTreeMemoryDataStore() );
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

    public function testCreateMemoryTreeWithTransaction()
    {
        $tree = ezcTreeMemory::create( new ezcTreeMemoryDataStore() );

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

    public static function suite()
    {
         return new PHPUnit_Framework_TestSuite( "ezcTreeMemoryTest" );
    }
}

?>
