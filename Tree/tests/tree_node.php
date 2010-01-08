<?php
/**
 * @copyright Copyright (C) 2005-2010 eZ Systems AS. All rights reserved.
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
class ezcTreeNodeTest extends ezcTestCase
{
    public function setUp()
    {
        $this->tree = ezcTreeMemory::create( new ezcTreeMemoryDataStore() );
    }

    public function testConstruct()
    {
        $node = new ezcTreeNode( $this->tree, 'H', 'Hydrogen' );
    }

    public function testGetId()
    {
        $node = new ezcTreeNode( $this->tree, 'He', 'Helium' );
        self::assertSame( 'He', $node->id );
    }

    public function testGetData()
    {
        $node = new ezcTreeNode( $this->tree, 'Li', 'Lithium' );
        self::assertSame( 'Lithium', $node->data );
    }

    public function testGetDataOnDemand()
    {
        $tree = ezcTreeMemory::create( new TestTranslateDataStore() );
        $node = new ezcTreeNode( $tree, 'Be' );
        self::assertSame( 'Beryllium', $node->data );
    }

    public function testGetUnknownProperty()
    {
        $node = new ezcTreeNode( $this->tree, 'B', 'Boron' );

        try
        {
            $dummy = $node->unknown;
            self::fail( "Expected exception not thrown" );
        }
        catch ( ezcBasePropertyNotFoundException $e )
        {
            self::assertSame( "No such property name 'unknown'.", $e->getMessage() );
        }
    }

    public function testSetId()
    {
        $node = new ezcTreeNode( $this->tree, 'C', 'Carbon' );
        
        try
        {
            $node->id = 'Koolstof';
            self::fail( "Expected exception not thrown" );
        }
        catch ( ezcBasePropertyPermissionException $e )
        {
            self::assertSame( "The property 'id' is read-only.", $e->getMessage() );
        }
    }

    public function testSetUnknownProperty()
    {
        $node = new ezcTreeNode( $this->tree, 'N', 'Nitrogen' );
        
        try
        {
            $node->unknown = 42;
            self::fail( "Expected exception not thrown" );
        }
        catch ( ezcBasePropertyNotFoundException $e )
        {
            self::assertSame( "No such property name 'unknown'.", $e->getMessage() );
        }
    }

    public function testIssetProperty()
    {
        $node = new ezcTreeNode( $this->tree, 'Pl', 'Plutonium' );
        self::assertSame( true, isset( $node->id ) );
        self::assertSame( true, isset( $node->tree ) );
        self::assertSame( true, isset( $node->data ) );
        self::assertSame( true, isset( $node->dataFetched ) );
        self::assertSame( true, isset( $node->dataStored ) );
        self::assertSame( false, isset( $node->unknown ) );
    }

    public function testAddChild()
    {
        $node = new ezcTreeNode( $this->tree, 'O', 'Oxygen' );
        $this->tree->setRootNode( $node );

        $childNode = new ezcTreeNode( $this->tree, 'F', 'Iron' );
        $node->addChild( $childNode );

        $nodeO = $this->tree->fetchNodeById( 'O' );
        $nodeF = $this->tree->fetchNodeById( 'F' );
        self::assertSame( true, $nodeF->isChildOf( $nodeO ) );
    }

    public function testFetchChildren()
    {
        $node = new ezcTreeNode( $this->tree, 'Ne', 'Neon' );
        $this->tree->setRootNode( $node );

        $childNode = new ezcTreeNode( $this->tree, 'Na', 'Natrium' );
        $node->addChild( $childNode );
        $childNode = new ezcTreeNode( $this->tree, 'Mg', 'Magnesium' );
        $node->addChild( $childNode );

        $nodeNe = $this->tree->fetchNodeById( 'Ne' );
        $children = $nodeNe->fetchChildren();
        self::assertSame( 'ezcTreeNodeList', get_class( $children ) );
        self::assertSame( 2, $children->size );
    }

    public function testFetch()
    {
        $tree = ezcTreeMemory::create( new TestTranslateDataStore() );
        $node = new ezcTreeNode( $tree, 'Al' );
        self::assertSame( 'Al', $node->id );
        self::assertSame( false, $node->dataFetched );
        self::assertSame( 'Aluminium', $node->data );
        self::assertSame( true, $node->dataFetched );
    }

    public function testSetDataFetchedNotBool()
    {
        $node = new ezcTreeNode( $this->tree, 'Si', 'Silicon' );
        
        try
        {
            $node->dataFetched = 42;
            self::fail( "Expected exception not thrown" );
        }
        catch ( ezcBaseValueException $e )
        {
            self::assertSame( "The value '42' that you were trying to assign to setting 'dataFetched' is invalid. Allowed values are: boolean.", $e->getMessage() );
        }
    }

    public function testSetDataStoredNotBool()
    {
        $node = new ezcTreeNode( $this->tree, 'P', 'Phosphorus' );
        
        try
        {
            $node->dataStored = "oops!";
            self::fail( "Expected exception not thrown" );
        }
        catch ( ezcBaseValueException $e )
        {
            self::assertSame( "The value 'oops!' that you were trying to assign to setting 'dataStored' is invalid. Allowed values are: boolean.", $e->getMessage() );
        }
    }

    public function testSetDataFetched()
    {
        $node = new ezcTreeNode( $this->tree, 'S', 'Sulfur' );
        
        $node->dataFetched = true;
        self::assertSame( true, $node->dataFetched );
        $node->dataFetched = false;
        self::assertSame( false, $node->dataFetched );
    }

    public function testSetDataStored()
    {
        $node = new ezcTreeNode( $this->tree, 'Cl', 'Chlorine' );
        
        $node->dataStored = true;
        self::assertSame( true, $node->dataStored );
        $node->dataStored = false;
        self::assertSame( false, $node->dataStored );
    }

    public static function suite()
    {
         return new PHPUnit_Framework_TestSuite( "ezcTreeNodeTest" );
    }
}

?>
