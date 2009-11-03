<?php
/**
 * ezcDocumentOdtTextProcessorTest.
 * 
 * @package Document
 * @version //autogen//
 * @subpackage Tests
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Test suite for class.
 * 
 * @package Document
 * @subpackage Tests
 */
class ezcDocumentOdtTextProcessorTest extends ezcTestCase
{
    protected $sourceRoot;

    protected $targetRoot;

    protected $proc;

    public static function suite()
    {
        return new PHPUnit_Framework_TestSuite( __CLASS__ );
    }

    public function setUp()
    {
        $sourceDoc = new DOMDocument();
        $sourceDoc->registerNodeClass(
            'DOMElement',
            'ezcDocumentLocateableDomElement'
        );
        $this->sourceRoot = $sourceDoc->appendChild(
            $sourceDoc->createElement(
                'docbook'
            )
        );

        $targetDoc = new DOMDocument();
        $this->targetRoot = $targetDoc->appendChild(
            $targetDoc->createElementNS(
                ezcDocumentOdt::NS_ODT_TEXT,
                'text'
            )
        );

        $this->proc = new ezcDocumentOdtTextProcessor();
    }

    public function testNoLiteral()
    {
        $in = $this->sourceRoot->appendChild(
            new DOMText( "Some text   with multiple\t\t\twhitespaces in\n\n \t  it." )
        );
        
        $res = $this->proc->processText( $in, $this->targetRoot );

        $this->assertTrue(
            is_array( $res )
        );
        $this->assertEquals(
            1,
            count( $res )
        );
        $this->assertTrue(
            ( $res = $res[0] ) instanceof DOMNode
        );

        $this->assertEquals(
            XML_TEXT_NODE,
            $res->nodeType
        );

        $this->assertEquals(
            $in->wholeText,
            $res->wholeText
        );
    }

    public function testLiteralNoReplacement()
    {
        $ll = $this->sourceRoot->appendChild(
            $this->sourceRoot->ownerDocument->createElement(
                'literallayout'
            )
        );
        $in = $ll->appendChild(
            new DOMText( "Some text without multiple whitespaces in it." )
        );
        
        $res = $this->proc->processText( $in, $this->targetRoot );

        $this->assertTrue(
            is_array( $res )
        );
        $this->assertEquals(
            1,
            count( $res )
        );
        $this->assertTrue(
            ( $res[0] instanceof DOMNode )
        );

        $this->assertEquals(
            XML_TEXT_NODE,
            $res[0]->nodeType
        );

        $this->assertEquals(
            $in->wholeText,
            $res[0]->wholeText
        );
    }

    public function testLiteralReplacement()
    {
        $ll = $this->sourceRoot->appendChild(
            $this->sourceRoot->ownerDocument->createElement(
                'literallayout'
            )
        );
        $in = $ll->appendChild(
            new DOMText( "Some text   with multiple\t\t\twhitespaces in\n\n \t  it." )
        );

        $res = $this->proc->processText( $in, $this->targetRoot );

        $this->assertTrue(
            is_array( $res )
        );

        // 0  => "Some text "
        // 1  => <text:s c="2"/>
        // 2  => "with multiple"
        // 3  => <text:tab c="3"/>
        // 4  => "whitespaces in"
        // 5  => <text:line-break c="2"/>
        // 6  => " "
        // 7  => <text:tab c="1"/>
        // 8  => " "
        // 9  => <text:s c="1"/>
        // 10 => "it."

        $this->assertEquals(
            11,
            count( $res )
        );

        $this->assertEquals(
            XML_TEXT_NODE,
            $res[0]->nodeType
        );
        $this->assertEquals(
            "Some text ",
            $res[0]->wholeText
        );

        $this->assertEquals(
            XML_ELEMENT_NODE,
            $res[1]->nodeType
        );
        $this->assertEquals(
            's',
            $res[1]->localName
        );
        $this->assertEquals(
            '2',
            $res[1]->getAttributeNS(
                ezcDocumentOdt::NS_ODT_TEXT,
                'c'
            )
        );

        $this->assertEquals(
            XML_TEXT_NODE,
            $res[2]->nodeType
        );
        $this->assertEquals(
            "with multiple",
            $res[2]->wholeText
        );

        $this->assertEquals(
            XML_ELEMENT_NODE,
            $res[3]->nodeType
        );
        $this->assertEquals(
            'tab',
            $res[3]->localName
        );
        $this->assertEquals(
            3,
            $res[3]->getAttributeNS(
                ezcDocumentOdt::NS_ODT_TEXT,
                'c'
            )
        );

        $this->assertEquals(
            XML_TEXT_NODE,
            $res[4]->nodeType
        );
        $this->assertEquals(
            "whitespaces in",
            $res[4]->wholeText
        );

        $this->assertEquals(
            XML_ELEMENT_NODE,
            $res[5]->nodeType
        );
        $this->assertEquals(
            'line-break',
            $res[5]->localName
        );
        $this->assertEquals(
            2,
            $res[5]->getAttributeNS(
                ezcDocumentOdt::NS_ODT_TEXT,
                'c'
            )
        );

        $this->assertEquals(
            XML_TEXT_NODE,
            $res[6]->nodeType
        );
        $this->assertEquals(
            " ",
            $res[6]->wholeText
        );

        $this->assertEquals(
            XML_ELEMENT_NODE,
            $res[7]->nodeType
        );
        $this->assertEquals(
            'tab',
            $res[7]->localName
        );
        $this->assertEquals(
            1,
            $res[7]->getAttributeNS(
                ezcDocumentOdt::NS_ODT_TEXT,
                'c'
            )
        );

        $this->assertEquals(
            XML_TEXT_NODE,
            $res[8]->nodeType
        );
        $this->assertEquals(
            " ",
            $res[8]->wholeText
        );

        $this->assertEquals(
            XML_ELEMENT_NODE,
            $res[9]->nodeType
        );
        $this->assertEquals(
            's',
            $res[9]->localName
        );
        $this->assertEquals(
            1,
            $res[9]->getAttributeNS(
                ezcDocumentOdt::NS_ODT_TEXT,
                'c'
            )
        );

        $this->assertEquals(
            XML_TEXT_NODE,
            $res[10]->nodeType
        );
        $this->assertEquals(
            "it.",
            $res[10]->wholeText
        );
    }

    protected function dumpDom( DOMNode $node, $indent = '' )
    {
        echo $indent;
        switch ( $node->nodeType )
        {
            case XML_ELEMENT_NODE:
                echo "-- <{$node->tagName}>";
                break;
            case XML_TEXT_NODE:
                echo '-- "' . $node->nodeValue . '"';
                break;
        }
        echo "\n";

        if ( $node->childNodes !== null )
        {
            foreach ( $node->childNodes as $child )
            {
                $this->dumpDom( $child );
            }
        }
    }
}



?>
