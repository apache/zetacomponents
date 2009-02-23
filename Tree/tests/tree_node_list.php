<?php
/**
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
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
class ezcTreeNodeListTest extends ezcTestCase
{
    public function setUp()
    {
        $this->tree = ezcTreeMemory::create( new ezcTreeMemoryDataStore() );
    }

    public function testAddNode()
    {
        $list = new ezcTreeNodeList;

        $node5 = new ezcTreeNode( $this->tree, '5' );
        $node5->data = 'vijf';
        $list->addNode( $node5 );

        $node42 = new ezcTreeNode( $this->tree, '42' );
        $node42->data = 'tweeenveertig';
        $list->addNode( $node42 );

        self::assertSame( array( '5' => $node5, '42' => $node42 ), $list->nodes );
    }

    public function testGetSize()
    {
        $list = new ezcTreeNodeList;

        self::assertSame( 0, $list->size );

        $node = new ezcTreeNode( $this->tree, '7' );
        $node->data = 'zeven';
        $list->addNode( $node );

        self::assertSame( 1, $list->size );
    }

    public function testSetSize()
    {
        $list = new ezcTreeNodeList;
        
        try
        {
            $list->size = 42;
            self::fail( "Expected exception not thrown" );
        }
        catch ( ezcBasePropertyPermissionException $e )
        {
            self::assertSame( "The property 'size' is read-only.", $e->getMessage() );
        }
    }

    public function testGetUnknownProperty()
    {
        $list = new ezcTreeNodeList;
        
        try
        {
            $dummy = $list->unknown;
            self::fail( "Expected exception not thrown" );
        }
        catch ( ezcBasePropertyNotFoundException $e )
        {
            self::assertSame( "No such property name 'unknown'.", $e->getMessage() );
        }
    }

    public function testSetUnknownProperty()
    {
        $list = new ezcTreeNodeList;
        
        try
        {
            $list->unknown = 42;
            self::fail( "Expected exception not thrown" );
        }
        catch ( ezcBasePropertyNotFoundException $e )
        {
            self::assertSame( "No such property name 'unknown'.", $e->getMessage() );
        }
    }

    public function testOffsetExists()
    {
        $list = new ezcTreeNodeList;

        $node = new ezcTreeNode( $this->tree, '8' );
        $node->data = 'acht';
        $list->addNode( $node );

        self::assertSame( true, isset( $list['8'] ) );
    }

    public function testOffsetGet()
    {
        $list = new ezcTreeNodeList;

        $node = new ezcTreeNode( $this->tree, '19' );
        $node->data = 'negentien';
        $list->addNode( $node );

        self::assertSame( $node, $list['19'] );
    }

    public function testOffsetSet()
    {
        $list = new ezcTreeNodeList;

        $node = new ezcTreeNode( $this->tree, '12' );
        $node->data = 'twaalf';

        self::assertSame( false, isset( $list['12'] ) );
        $list['12'] = $node;
        self::assertSame( true, isset( $list['12'] ) );
        self::assertSame( $node, $list['12'] );
    }

    public function testOffsetSetWrongClass()
    {
        $list = new ezcTreeNodeList;

        try
        {
            $list['4'] = new StdClass;
            self::fail( "Expected exception not thrown" );
        }
        catch ( ezcTreeInvalidClassException $e )
        {
            self::assertSame( "An object of class 'ezcTreeNode' is used, but an object of class 'stdClass' is expected.", $e->getMessage() );
        }
    }

    public function testOffsetSetWrongId()
    {
        $list = new ezcTreeNodeList;

        try
        {
            $node = new ezcTreeNode( $this->tree, '16' );
            $node->data = 'zestien';
            $list['6'] = $node;
            self::fail( "Expected exception not thrown" );
        }
        catch ( ezcTreeIdsDoNotMatchException $e )
        {
            self::assertSame( "You cannot add the node with node ID '16' to the list with key '6'. The key needs to match the node ID.", $e->getMessage() );
        }
    }

    public function testOffsetUnset()
    {
        $list = new ezcTreeNodeList;

        $node = new ezcTreeNode( $this->tree, '78' );
        $node->data = 'achtenzeventig';
        $list->addNode( $node );

        self::assertSame( true, isset( $list['78'] ) );
        unset( $list['78'] );
        self::assertSame( false, isset( $list['78'] ) );
    }

    public function testFetchAllDataEmptyList()
    {
        $list = new ezcTreeNodeList;
        $list->fetchDataForNodes();
        self::assertSame( 0, $list->size );
    }

    public function testFetchAllData()
    {
        $tree = ezcTreeMemory::create( new TestTranslateDataStore() );

        $list = new ezcTreeNodeList;
        $list->addNode( $node = new ezcTreeNode( $tree, 'Aries' ) );
        $list->addNode( $node = new ezcTreeNode( $tree, 'Taurus' ) );
        $list->addNode( $node = new ezcTreeNode( $tree, 'Gemini' ) );
        $list->addNode( $node = new ezcTreeNode( $tree, 'Cancer' ) );
        foreach( $list->nodes as $node )
        {
            self::assertSame( false, $node->dataFetched );
        }

        $list->fetchDataForNodes();

        foreach( $list->nodes as $node )
        {
            self::assertSame( true, $node->dataFetched );
        }
        self::assertSame( '♋', $list['Cancer']->data );
    }

    public function testSame()
    {
    }

    public static function suite()
    {
         return new PHPUnit_Framework_TestSuite( "ezcTreeNodeListTest" );
    }
}

?>
