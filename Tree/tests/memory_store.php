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

/**
 * @package Tree
 * @subpackage Tests
 */
class ezcTreeMemoryStoreTest extends ezcTestCase
{
    public function testMemoryStoreFetchDataForNode()
    {
        $store = new ezcTreeMemoryDataStore;
        $tree  = ezcTreeMemory::create( $store );

        $node = new ezcTreeNode( $tree, 'Mercury', '☿' );
        $ser = serialize( $node );
        self::assertSame( $node->id, 'Mercury' );
        self::assertSame( $node->data, '☿' );

        $store->fetchDataForNode( $node );
        self::assertSame( $node->id, 'Mercury' );
        self::assertSame( $node->data, '☿' );
        self::assertSame( $ser, serialize( $node ) );
    }

    public function testMemoryStoreFetchDataForNodes()
    {
        $store = new ezcTreeMemoryDataStore;
        $tree  = ezcTreeMemory::create( $store );

        $list = new ezcTreeNodeList();
        $list->addNode( new ezcTreeNode( $tree, 'Venus', '♀' ) );
        $list->addNode( new ezcTreeNode( $tree, 'Earth', '♁' ) );
        $ser = serialize( $list );

        $store->fetchDataForNodes( $list );

        self::assertSame( $ser, serialize( $list ) );
    }

    public function testMemoryStoreDeleteDataForNodes()
    {
        $store = new ezcTreeMemoryDataStore;
        $tree  = ezcTreeMemory::create( $store );

        $list = new ezcTreeNodeList();
        $list->addNode( new ezcTreeNode( $tree, 'Mars', '♂' ) );
        $list->addNode( new ezcTreeNode( $tree, 'Jupiter', '♃' ) );
        $ser = serialize( $list );

        $store->deleteDataForNodes( $list );

        self::assertSame( $ser, serialize( $list ) );
    }

    public function testMemoryStoreDataForNode()
    {
        $store = new ezcTreeMemoryDataStore;
        $tree  = ezcTreeMemory::create( $store );

        $node = new ezcTreeNode( $tree, 'Saturn', '♄' );
        $ser = serialize( $node );

        $store->storeDataForNode( $node );

        self::assertSame( $ser, serialize( $node ) );
    }

    public function testMemoryStoreDeleteDataForAllNodes()
    {
        $store = new ezcTreeMemoryDataStore;
        $tree  = ezcTreeMemory::create( $store );

        $uranus = new ezcTreeNode( $tree, 'Uranus', '♅' );
        $tree->setRootNode( $uranus );
        $uranus->addChild( new ezcTreeNode( $tree, 'Miranda', 'Miranda' ) );
        $uranus->addChild( new ezcTreeNode( $tree, 'Ariel', 'Ariel' ) );
        $uranus->addChild( new ezcTreeNode( $tree, 'Umbriel', 'Umbriel' ) );
        $uranus->addChild( new ezcTreeNode( $tree, 'Titania', 'Titania' ) );
        $uranus->addChild( new ezcTreeNode( $tree, 'Oberon', 'Oberon' ) );

        $store->deleteDataForAllNodes();

        self::assertSame( 'Ariel', $tree->fetchNodeById( 'Ariel' )->id );
        self::assertSame( 'Titania', $tree->fetchNodeById( 'Titania' )->data );
    }

    public static function suite()
    {
         return new PHPUnit_Framework_TestSuite( "ezcTreeMemoryStoreTest" );
    }
}

?>
