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
require_once 'visitor.php';

/**
 * @package Tree
 * @subpackage Tests
 */
class ezcTreeVisitorXHTMLTest extends ezcTreeVisitorTest
{
    public function testVisitorXHTMLDefault()
    {
        $tree = ezcTreeMemory::create( new ezcTreeMemoryDataStore() );
        $this->addTestData( $tree );

        $visitor = new ezcTreeVisitorXHTML();
        $tree->accept( $visitor );
        $expected = file_get_contents( dirname( __FILE__) . '/files/compare/visitor-xhtml-default.txt' );
        self::assertSame( $expected, $visitor->__toString() );
    }

    public function testVisitorXHTMLDisplayRootNode()
    {
        $tree = ezcTreeMemory::create( new ezcTreeMemoryDataStore() );
        $this->addTestData( $tree );

        $visitor = new ezcTreeVisitorXHTML();
        $visitor->options->displayRootNode = true;

        $tree->accept( $visitor );
        $expected = file_get_contents( dirname( __FILE__) . '/files/compare/visitor-xhtml-display-root-node.txt' );
        self::assertSame( $expected, $visitor->__toString() );
    }

    public function testVisitorXHTMLSelectedNodeLink1()
    {
        $tree = ezcTreeMemory::create( new ezcTreeMemoryDataStore() );
        $this->addTestData( $tree );

        $visitor = new ezcTreeVisitorXHTML();
        $visitor->options->selectedNodeLink = true;

        $tree->accept( $visitor );
        $expected = file_get_contents( dirname( __FILE__) . '/files/compare/visitor-xhtml-selected-node-link.txt' );
        self::assertSame( $expected, $visitor->__toString() );
    }

    public function testVisitorXHTMLSelectedNodeLink2()
    {
        $tree = ezcTreeMemory::create( new ezcTreeMemoryDataStore() );
        $this->addTestData( $tree );

        $visitor = new ezcTreeVisitorXHTML();
        $visitor->options->displayRootNode = true;
        $visitor->options->selectedNodeLink = true;

        $tree->accept( $visitor );
        $expected = file_get_contents( dirname( __FILE__) . '/files/compare/visitor-xhtml-selected-node-link2.txt' );
        self::assertSame( $expected, $visitor->__toString() );
    }

    public function testVisitorXHTMLSelectedNodeLink3()
    {
        $tree = ezcTreeMemory::create( new ezcTreeMemoryDataStore() );
        $this->addTestData( $tree );

        $visitor = new ezcTreeVisitorXHTML();
        $visitor->options->displayRootNode = true;
        $visitor->options->selectedNodeLink = true;
        $visitor->options->basePath = 'testing';

        $tree->accept( $visitor );
        $expected = file_get_contents( dirname( __FILE__) . '/files/compare/visitor-xhtml-selected-node-link3.txt' );
        self::assertSame( $expected, $visitor->__toString() );
    }

    public function testVisitorXHTMLXmlId()
    {
        $tree = ezcTreeMemory::create( new ezcTreeMemoryDataStore() );
        $this->addTestData( $tree );

        $visitor = new ezcTreeVisitorXHTML();
        $visitor->options->xmlId = 'tree_id';

        $tree->fetchNodeById( 'Hylobatidae' )->accept( $visitor );
        $expected = file_get_contents( dirname( __FILE__) . '/files/compare/visitor-xhtml-xml-id.txt' );
        self::assertSame( $expected, $visitor->__toString() );
    }

    public function testVisitorXHTMLNoLinks()
    {
        $tree = ezcTreeMemory::create( new ezcTreeMemoryDataStore() );
        $this->addTestData( $tree );

        $options = new ezcTreeVisitorXHTMLOptions;
        $options->addLinks = false;
        $visitor = new ezcTreeVisitorXHTML( $options );

        $tree->fetchNodeById( 'Hylobatidae' )->accept( $visitor );
        $expected = file_get_contents( dirname( __FILE__) . '/files/compare/visitor-xhtml-no-links.txt' );
        self::assertSame( $expected, $visitor->__toString() );
    }

    public function testVisitorXHTMLSubtreeHighlightNodes()
    {
        $tree = ezcTreeMemory::create( new ezcTreeMemoryDataStore() );
        $this->addTestData( $tree );

        $options = new ezcTreeVisitorXHTMLOptions;
        $options->subtreeHighlightNodeIds = array( 'Nomascus', 'Eastern Black Crested Gibbon' );
        $options->addLinks = false;
        $visitor = new ezcTreeVisitorXHTML( $options );

        $tree->fetchNodeById( 'Hylobatidae' )->accept( $visitor );
        $expected = file_get_contents( dirname( __FILE__) . '/files/compare/visitor-xhtml-subtree-highlight-nodes.txt' );
        self::assertSame( $expected, $visitor->__toString() );
    }

    public function testVisitorXHTMLHighlightNodes()
    {
        $tree = ezcTreeMemory::create( new ezcTreeMemoryDataStore() );
        $this->addTestData( $tree );

        $options = new ezcTreeVisitorXHTMLOptions;
        $options->highlightNodeIds = array( 'Nomascus', 'Eastern Black Crested Gibbon' );
        $options->addLinks = false;
        $visitor = new ezcTreeVisitorXHTML( $options );

        $tree->fetchNodeById( 'Hylobatidae' )->accept( $visitor );
        $expected = file_get_contents( dirname( __FILE__) . '/files/compare/visitor-xhtml-highlight-nodes.txt' );
        self::assertSame( $expected, $visitor->__toString() );
    }

    public static function suite()
    {
         return new PHPUnit_Framework_TestSuite( "ezcTreeVisitorXHTMLTest" );
    }
}

?>
