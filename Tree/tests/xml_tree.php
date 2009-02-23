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
class ezcTreeXmlTest extends ezcTreeTest
{
    private $tempDir;

    protected function setUp()
    {
        $this->tempDir = $this->createTempDir( 'ezcXmlTreeTest' );
    }

    protected function tearDown()
    {
        $this->removeTempDir();
    }

    protected function setUpEmptyTestTree()
    {
        $tree = ezcTreeXml::create( 
            $this->tempDir . '/test.xml',
            new ezcTreeXmlInternalDataStore()
        );
        return $tree;
    }

    protected function setUpTestTree()
    {
        copy( dirname( __FILE__ ) . '/files/init.xml', $this->tempDir . '/test.xml' );
        $tree = new ezcTreeXml( 
            $this->tempDir . '/test.xml',
            new ezcTreeXmlInternalDataStore()
        );
        return $tree;
    }

    public function testOpenInvalidFormatXmlTree()
    {
        $dirname = dirname( __FILE__ );
        try
        {
            $tree = new ezcTreeXml( 
                "$dirname/files/invalid-structure.xml",
                new ezcTreeXmlInternalDataStore()
            );
        }
        catch ( ezcTreeInvalidXmlFormatException $e )
        {
            self::assertSame( "The XML file '$dirname/files/invalid-structure.xml' does not validate according to the expected schema:\n$dirname/files/invalid-structure.xml:12:0: Did not expect element foo there\n", $e->getMessage() );
        }
    }

    public function testOpenInvalidXmlTree()
    {
        $dirname = dirname( __FILE__ );
        try
        {
            $tree = new ezcTreeXml( 
                "$dirname/files/invalid-xml.xml",
                new ezcTreeXmlInternalDataStore()
            );
        }
        catch ( ezcTreeInvalidXmlException $e )
        {
            self::assertSame( "The XML file '$dirname/files/invalid-xml.xml' is not well-formed:\n$dirname/files/invalid-xml.xml:28:8: Opening and ending tag mismatch: node line 4 and tree\n$dirname/files/invalid-xml.xml:29:1: Premature end of data in tag tree line 3\n", $e->getMessage() );
        }
    }

    public function testOpenNonExistingXmlTree()
    {
        $dirname = dirname( __FILE__ );
        try
        {
            $tree = new ezcTreeXml( 
                "$dirname/files/does-not-exist.xml",
                new ezcTreeXmlInternalDataStore()
            );
        }
        catch ( ezcBaseFileNotFoundException $e )
        {
            self::assertSame( "The XML file '$dirname/files/does-not-exist.xml' could not be found.", $e->getMessage() );
        }
    }

    public function testCreateXmlTree()
    {
        $tree = ezcTreeXml::create(
            $this->tempDir . '/new-tree.xml', 
            new ezcTreeXmlInternalDataStore()
        );
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

        self::assertXmlFileEqualsXmlFile(
            dirname( __FILE__ ) . '/files/create-test.xml', 
            $this->tempDir . '/new-tree.xml'
        );
    }

    public function testCreateXmlTreeWithPrefix()
    {
        $tree = ezcTreeXml::create(
            $this->tempDir . '/new-tree.xml', 
            new ezcTreeXmlInternalDataStore(),
            'ezc'
        );
        self::assertSame( false, $tree->nodeExists( '1' ) );
        self::assertSame( false, $tree->nodeExists( '3' ) );

        $node = $tree->createNode( 1, "Root Node" );
        self::assertType( 'ezcTreeNode', $node );
        self::assertSame( '1', $node->id );
        $tree->setRootNode( $node );
        self::assertSame( true, $tree->nodeExists( '1' ) );
        self::assertSame( '1', $tree->getRootNode()->id );

        $node2 = $tree->createNode( 2, "Node 2" );
        $node->addChild( $node2 );
        self::assertSame( true, $tree->nodeExists( '2' ) );

        $node->addChild( $node3 = $tree->createNode( 3, "Node 3" ) );
        $node3->addChild( $tree->createNode( 4, "Node 3.4" ) );
        self::assertSame( true, $tree->nodeExists( '3' ) );
        self::assertSame( true, $tree->nodeExists( '4' ) );

        self::assertXmlFileEqualsXmlFile(
            dirname( __FILE__ ) . '/files/create-test-prefix.xml', 
            $this->tempDir . '/new-tree.xml'
        );
    }

    public function testSetPrefix()
    {
        $tree = ezcTreeXml::create(
            $this->tempDir . '/new-tree.xml', 
            new ezcTreeXmlInternalDataStore(),
            'ezc'
        );

        try
        {
            $tree->prefix = 'foo';
            self::fail( "Expected exception not thrown" );
        }
        catch ( ezcBasePropertyPermissionException $e )
        {
            self::assertSame( "The property 'prefix' is read-only.", $e->getMessage() );
        }
    }

    public function testIssetAndGetPrefix()
    {
        $tree = ezcTreeXml::create(
            $this->tempDir . '/new-tree.xml', 
            new ezcTreeXmlInternalDataStore(),
            'ezc'
        );

        self::assertSame( true, isset( $tree->prefix ) );
        self::assertSame( 'ezc', $tree->prefix );
    }

    public function testCreateXmlTreeWithTransaction()
    {
        $tree = ezcTreeXml::create(
            $this->tempDir . '/new-tree.xml', 
            new ezcTreeXmlInternalDataStore()
        );

        $tree->setRootNode( $node = $tree->createNode( 1, "Root Node" ) );
        self::assertSame( true, $tree->nodeExists( '1' ) );

        $tree->beginTransaction();
        $node->addChild( $tree->createNode( 2, "Node 2" ) );
        $node->addChild( $node3 = $tree->createNode( 3, "Node 3" ) );
        $node3->addChild( $tree->createNode( 4, "Node 3.4" ) );

        self::assertSame( false, $tree->nodeExists( '3' ) );
        
        $tree->commit();
        
        self::assertSame( true, $tree->nodeExists( '3' ) );

        self::assertXmlFileEqualsXmlFile(
            dirname( __FILE__ ) . '/files/create-test.xml', 
            $this->tempDir . '/new-tree.xml'
        );
    }

    public function testStoreUpdatedData()
    {
        $tree = ezcTreeXml::create(
            $this->tempDir . '/new-tree.xml', 
            new ezcTreeXmlInternalDataStore()
        );

        $root = $tree->createNode( 1, "Camelinae" );
        $tree->setRootNode( $root );

        $root->addChild( $tree->createNode( 2, "Lama" ) );
        $root->addChild( $tree->createNode( 3, "Vicugna" ) );
        $root->addChild( $tree->createNode( 4, "Camelus" ) );

        // start over
        $tree = new ezcTreeXml(
            $this->tempDir . '/new-tree.xml', 
            new ezcTreeXmlInternalDataStore()
        );

        $camelus = $tree->fetchNodeById( 4 );
        self::assertSame( "Camelus", $camelus->data );
        $camelus->data = "Something Wrong";
        $camelus->data = "Camels";

        // start over
        $tree = new ezcTreeXml(
            $this->tempDir . '/new-tree.xml', 
            new ezcTreeXmlInternalDataStore()
        );

        $camelus = $tree->fetchNodeById( 4 );
        self::assertSame( "Camels", $camelus->data );
    }

    public function testStoreUpdatedData2()
    {
        $tree = ezcTreeXml::create(
            $this->tempDir . '/new-tree.xml', 
            new ezcTreeXmlInternalDataStore()
        );
        $tree->autoId = true;

        $rootNode = $tree->createNode( null, 'Elements' );
        $tree->setRootNode( $rootNode );

        $nonMetal = $tree->createNode( 'NonMetals', 'Non-Metals' );
        $rootNode->addChild( $nonMetal );
        $nobleGasses = $tree->createNode( null, 'Noble Gasses' );
        $rootNode->addChild( $nobleGasses );

        $nonMetal->addChild( $tree->createNode( null, 'Hydrogen' ) );
        $nonMetal->addChild( $tree->createNode( null, 'Carbon' ) );

        // start over
        $tree = new ezcTreeXml(
            $this->tempDir . '/new-tree.xml', 
            new ezcTreeXmlInternalDataStore()
        );

        $nonMetals = $tree->fetchNodeById( 'NonMetals' );
        self::assertSame( "Non-Metals", $nonMetals->data );
        $nonMetals->data = "Non-Metals renamed";

        // start over
        $tree = new ezcTreeXml(
            $this->tempDir . '/new-tree.xml', 
            new ezcTreeXmlInternalDataStore()
        );
        $nonMetals = $tree->fetchNodeById( 'NonMetals' );
        self::assertSame( "Non-Metals renamed", $nonMetals->data );
    }

    public function testReloadAutoGenId()
    {
        $tree = ezcTreeXml::create(
            $this->tempDir . '/new-tree.xml', 
            new ezcTreeXmlInternalDataStore()
        );
        $tree->autoId = true;

        $root = $tree->createNode( null, "Camelinae" );
        $tree->setRootNode( $root );

        $root->addChild( $tree->createNode( null, "Lama" ) );
        $root->addChild( $tree->createNode( null, "Vicugna" ) );
        $root->addChild( $tree->createNode( null, "Camelus" ) );

        // start over
        $tree = new ezcTreeXml(
            $this->tempDir . '/new-tree.xml', 
            new ezcTreeXmlInternalDataStore()
        );

        $root = $tree->getRootNode();
        $newNode = $tree->createNode( null, "Oempa" );
        $root->addChild( $newNode );

        $camelus = $tree->fetchNodeById( 5 );
        self::assertSame( "Oempa", $camelus->data );
    }

    public function testReloadAutoGenIdWithPrefix()
    {
        $tree = ezcTreeXml::create(
            $this->tempDir . '/new-tree.xml', 
            new ezcTreeXmlInternalDataStore(),
            'ezc'
        );
        $tree->autoId = true;

        $root = $tree->createNode( null, "Camelinae" );
        $tree->setRootNode( $root );

        $root->addChild( $tree->createNode( null, "Lama" ) );
        $root->addChild( $tree->createNode( null, "Vicugna" ) );
        $root->addChild( $tree->createNode( null, "Camelus" ) );

        // start over
        $tree = new ezcTreeXml(
            $this->tempDir . '/new-tree.xml', 
            new ezcTreeXmlInternalDataStore()
        );
        $root = $tree->getRootNode();
        $newNode = $tree->createNode( null, "Oempa" );
        $root->addChild( $newNode );

        $camelus = $tree->fetchNodeById( 5 );
        self::assertSame( "Oempa", $camelus->data );

        // start over
        $tree = new ezcTreeXml(
            $this->tempDir . '/new-tree.xml', 
            new ezcTreeXmlInternalDataStore()
        );
        $root = $tree->fetchNodeById( 5 );
        $newNode = $tree->createNode( null, "Loempa" );
        $root->addChild( $newNode );

        $camelus = $tree->fetchNodeById( 5 );
        self::assertSame( "Oempa", $camelus->data );
        $camelus = $tree->fetchNodeById( 6 );
        self::assertSame( "Loempa", $camelus->data );
    }

    // test for bug #13155
    public function testFetchDataNode1()
    {
        $dirname = dirname( __FILE__ );
        $tree = new ezcTreeXml( 
            "$dirname/files/fetch-data-test.xml",
            new ezcTreeXmlInternalDataStore()
        );
        try
        {
            $node = $tree->fetchNodeById( 1 );
            $data = $node->data;
            self::fail( "Expected exception not thrown." );
        }
        catch ( ezcTreeDataStoreMissingDataException $e )
        {
            self::assertEquals( "The data store does not have data stored for the node with ID '1'.", $e->getMessage() );
        }
    }

    public static function suite()
    {
         return new PHPUnit_Framework_TestSuite( "ezcTreeXmlTest" );
    }
}

?>
