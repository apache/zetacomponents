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

    public static function suite()
    {
         return new PHPUnit_Framework_TestSuite( "ezcTreeXmlTest" );
    }
}

?>
