<?php
/**
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
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
class ezcTreeVisitorTest extends ezcTestCase
{
    public function setUp()
    {
        $this->tree = ezcTreeMemory::create( new ezcTreeMemoryDataStore() );
    }

    protected function addTestData( $tree )
    {
        $primates = array(
            'Hominoidea' => array(
                'Hylobatidae' => array(
                    'Hylobates' => array(
                        'Lar Gibbon',
                        'Agile Gibbon',
                        'Müller\'s Bornean Gibbon',
                        'Silvery Gibbon',
                        'Pileated Gibbon',
                        'Kloss\'s Gibbon',
                    ),
                    'Hoolock' => array(
                        'Western Hoolock Gibbon',
                        'Eastern Hoolock Gibbon',
                    ),
                    'Symphalangus' => array(),
                    'Nomascus' => array(
                        'Black Crested Gibbon',
                        'Eastern Black Crested Gibbon',
                        'White-cheecked Crested Gibbon',
                        'Yellow-cheecked Gibbon',
                    ),
                ),
                'Hominidae' => array(
                    'Pongo' => array(
                        'Bornean Orangutan',
                        'Sumatran Orangutan',
                    ), 
                    'Gorilla' => array(
                        'Western Gorilla' => array(
                            'Western Lowland Gorilla',
                            'Cross River Gorilla',
                        ),
                        'Eastern Gorilla' => array(
                            'Mountain Gorilla',
                            'Eastern Lowland Gorilla',
                        ),
                    ), 
                    'Homo' => array(
                        'Homo Sapiens' => array(
                            'Homo Sapiens Sapiens',
                            'Homo Superior'
                        ),
                    ),
                    'Pan' => array(
                        'Common Chimpanzee',
                        'Bonobo',
                    ),
                ),
            ),
        );

        $root = $tree->createNode( 'Hominoidea', 'Hominoidea' );
        $tree->setRootNode( $root );

        $this->addChildren( $root, $primates['Hominoidea'] );
    }

    private function addChildren( ezcTreeNode $node, array $children )
    {
        foreach( $children as $name => $child )
        {
            if ( is_array( $child ) )
            {
                $newNode = $node->tree->createNode( $name, $name );
                $node->addChild( $newNode );
                $this->addChildren( $newNode, $child );
            }
            else
            {
                $newNode = $node->tree->createNode( $child, $child );
                $node->addChild( $newNode );
            }
        }
    }

    public function testVisitor1()
    {
        $tree = ezcTreeMemory::create( new ezcTreeMemoryDataStore() );
        $this->addTestData( $tree );

        $visitor = new ezcTreeVisitorGraphViz;
        $tree->accept( $visitor );
        self::assertSame( 'c422c6271ff3c9a213156e660a1ba8b2', md5( (string) $visitor ) );
    }

    public function testVisitor2()
    {
        $tree = ezcTreeMemory::create( new ezcTreeMemoryDataStore() );
        $this->addTestData( $tree );

        $expected = file_get_contents( dirname( __FILE__) . '/files/compare/visitor-visitor2.txt' );

        $visitor = new ezcTreeVisitorPlainText;
        $tree->accept( $visitor );
        self::assertSame( $expected, (string) $visitor );

        $visitor = new ezcTreeVisitorPlainText( ezcTreeVisitorPlainText::SYMBOL_UTF8 );
        $tree->accept( $visitor );
        self::assertSame( $expected, (string) $visitor );
    }

    public function testVisitor3()
    {
        $tree = ezcTreeMemory::create( new ezcTreeMemoryDataStore() );
        $this->addTestData( $tree );

        $visitor = new ezcTreeVisitorPlainText( ezcTreeVisitorPlainText::SYMBOL_ASCII );
        $tree->accept( $visitor );
        $expected = file_get_contents( dirname( __FILE__) . '/files/compare/visitor-visitor3.txt' );
        self::assertSame( $expected, (string) $visitor );
    }

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
         return new PHPUnit_Framework_TestSuite( "ezcTreeVisitorTest" );
    }
}

?>
