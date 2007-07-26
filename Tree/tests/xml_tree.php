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

    protected function setUpTestTree()
    {
        copy( dirname( __FILE__ ) . '/files/init.xml', $this->tempDir . '/test.xml' );
        $tree = new ezcTreeXml( 
            $this->tempDir . '/test.xml',
            new ezcTreeXmlInternalDataStore()
        );
        return $tree;
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

    public static function suite()
    {
         return new PHPUnit_Framework_TestSuite( "ezcTreeXmlTest" );
    }
}

?>
