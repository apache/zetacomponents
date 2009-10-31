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
            ( $res instanceof DOMNode )
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
            ( $res instanceof DOMNode )
        );
        $this->assertEquals(
            XML_DOCUMENT_FRAG_NODE,
            $res->nodeType
        );

        $this->assertEquals(
            1,
            $res->childNodes->length
        );

        $this->assertEquals(
            XML_TEXT_NODE,
            $res->childNodes->item( 0 )->nodeType
        );

        $this->assertEquals(
            $in->wholeText,
            $res->childNodes->item( 0 )->wholeText
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
            ( $res instanceof DOMNode )
        );
        $this->assertEquals(
            XML_DOCUMENT_FRAG_NODE,
            $res->nodeType
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
            $res->childNodes->length
        );

        $this->assertEquals(
            XML_TEXT_NODE,
            $res->childNodes->item( 0 )->nodeType
        );
        $this->assertEquals(
            "Some text ",
            $res->childNodes->item( 0 )->wholeText
        );

        $this->assertEquals(
            XML_ELEMENT_NODE,
            $res->childNodes->item( 1 )->nodeType
        );
        $this->assertEquals(
            's',
            $res->childNodes->item( 1 )->localName
        );
        $this->assertEquals(
            '2',
            $res->childNodes->item( 1 )->getAttributeNS(
                ezcDocumentOdt::NS_ODT_TEXT,
                'c'
            )
        );

        $this->assertEquals(
            XML_TEXT_NODE,
            $res->childNodes->item( 2 )->nodeType
        );
        $this->assertEquals(
            "with multiple",
            $res->childNodes->item( 2 )->wholeText
        );

        $this->assertEquals(
            XML_ELEMENT_NODE,
            $res->childNodes->item( 3 )->nodeType
        );
        $this->assertEquals(
            'tab',
            $res->childNodes->item( 3 )->localName
        );
        $this->assertEquals(
            3,
            $res->childNodes->item( 3 )->getAttributeNS(
                ezcDocumentOdt::NS_ODT_TEXT,
                'c'
            )
        );

        $this->assertEquals(
            XML_TEXT_NODE,
            $res->childNodes->item( 4 )->nodeType
        );
        $this->assertEquals(
            "whitespaces in",
            $res->childNodes->item( 4 )->wholeText
        );

        $this->assertEquals(
            XML_ELEMENT_NODE,
            $res->childNodes->item( 5 )->nodeType
        );
        $this->assertEquals(
            'line-break',
            $res->childNodes->item( 5 )->localName
        );
        $this->assertEquals(
            2,
            $res->childNodes->item( 5 )->getAttributeNS(
                ezcDocumentOdt::NS_ODT_TEXT,
                'c'
            )
        );

        $this->assertEquals(
            XML_TEXT_NODE,
            $res->childNodes->item( 6 )->nodeType
        );
        $this->assertEquals(
            " ",
            $res->childNodes->item( 6 )->wholeText
        );

        $this->assertEquals(
            XML_ELEMENT_NODE,
            $res->childNodes->item( 7 )->nodeType
        );
        $this->assertEquals(
            'tab',
            $res->childNodes->item( 7 )->localName
        );
        $this->assertEquals(
            1,
            $res->childNodes->item( 7 )->getAttributeNS(
                ezcDocumentOdt::NS_ODT_TEXT,
                'c'
            )
        );

        $this->assertEquals(
            XML_TEXT_NODE,
            $res->childNodes->item( 8 )->nodeType
        );
        $this->assertEquals(
            " ",
            $res->childNodes->item( 8 )->wholeText
        );

        $this->assertEquals(
            XML_ELEMENT_NODE,
            $res->childNodes->item( 9 )->nodeType
        );
        $this->assertEquals(
            's',
            $res->childNodes->item( 9 )->localName
        );
        $this->assertEquals(
            1,
            $res->childNodes->item( 9 )->getAttributeNS(
                ezcDocumentOdt::NS_ODT_TEXT,
                'c'
            )
        );

        $this->assertEquals(
            XML_TEXT_NODE,
            $res->childNodes->item( 10 )->nodeType
        );
        $this->assertEquals(
            "it.",
            $res->childNodes->item( 10 )->wholeText
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
