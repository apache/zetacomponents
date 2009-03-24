<?php
/**
 * ezcDocumentPdfStyleInferenceTests
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
class ezcDocumentPdfLocationIdTests extends ezcTestCase
{
    protected $document;
    protected $xpath;

    public static function suite()
    {
        return new PHPUnit_Framework_TestSuite( __CLASS__ );
    }

    public function setUp()
    {
        $this->document = new DOMDocument();
        $this->document->registerNodeClass( 'DOMElement', 'ezcDocumentPdfInferencableDomElement' );

        $this->document->load( dirname( __FILE__ ) . '/files/docbook/pdf/location_ids.xml' );

        $this->xpath = new DOMXPath( $this->document );
        $this->xpath->registerNamespace( 'doc', 'http://docbook.org/ns/docbook' );
    }

    public function testRootNodeWithoutFormats()
    {
        $inferencer = new ezcDocumentPdfStyleInferencer();
        $element    = $this->xpath->query( '//doc:article' )->item( 0 );

        $this->assertEquals(
            array(),
            $inferencer->inferenceFormattingRules( $element )
        );
    }

    public function testRootNodeFormatting()
    {
        $inferencer = new ezcDocumentPdfStyleInferencer();
        $element    = $this->xpath->query( '//doc:article' )->item( 0 );

        $inferencer->appendStyleDirectives( array(
            new ezcDocumentPdfCssDirective(
                array( 'article' ),
                array(
                    'foo' => 'bar',
                )
            ),
        ) );

        $this->assertEquals(
            array(
                'foo' => 'bar',
            ),
            $inferencer->inferenceFormattingRules( $element )
        );
    }

    public function testRootNodeFormattingPartialOverwrite()
    {
        $inferencer = new ezcDocumentPdfStyleInferencer();
        $element    = $this->xpath->query( '//doc:article' )->item( 0 );

        $inferencer->appendStyleDirectives( array(
            new ezcDocumentPdfCssDirective(
                array( 'article' ),
                array(
                    'foo' => 'bar',
                    'baz' => 'bar',
                )
            ),
            new ezcDocumentPdfCssDirective(
                array( 'article' ),
                array(
                    'foo' => 'blubb',
                )
            ),
        ) );

        $this->assertEquals(
            array(
                'foo' => 'blubb',
                'baz' => 'bar',
            ),
            $inferencer->inferenceFormattingRules( $element )
        );
    }

    public function testRootNodeFormattingRuleInheritance()
    {
        $inferencer = new ezcDocumentPdfStyleInferencer();
        $element    = $this->xpath->query( '//doc:section' )->item( 0 );

        $inferencer->appendStyleDirectives( array(
            new ezcDocumentPdfCssDirective(
                array( 'article' ),
                array(
                    'foo' => 'bar',
                    'baz' => 'bar',
                )
            ),
            new ezcDocumentPdfCssDirective(
                array( 'article', '> section' ),
                array(
                    'foo' => 'blubb',
                )
            ),
        ) );

        $this->assertEquals(
            array(
                'foo' => 'blubb',
                'baz' => 'bar',
            ),
            $inferencer->inferenceFormattingRules( $element )
        );
    }
}

?>
