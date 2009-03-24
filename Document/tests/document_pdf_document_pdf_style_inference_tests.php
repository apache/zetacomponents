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
class ezcDocumentPdfStyleInferenceTests extends ezcTestCase
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

        $this->document->load( dirname( __FILE__ ) . '/files/docbook/ezxml/s_004_paragraph.xml' );

        $this->xpath = new DOMXPath( $this->document );
        $this->xpath->registerNamespace( 'doc', 'http://docbook.org/ns/docbook' );
    }

    public function testRootNodeLocationId()
    {
        $element = $this->xpath->query( '//doc:article' )->item( 0 );

        $this->assertEquals(
            '/article',
            $element->getLocationId()
        );
    }

    public function testSectionNodeLocationId()
    {
        $element = $this->xpath->query( '//doc:section' )->item( 0 );

        $this->assertEquals(
            '/article/section#paragraph_with_inline_markup',
            $element->getLocationId()
        );
    }

    public function testNodeLocationIdWithRole()
    {
        $element = $this->xpath->query( '//doc:emphasis' )->item( 1 );

        $this->assertEquals(
            '/article/section#paragraph_with_inline_markup/para/emphasis[Role=strong]',
            $element->getLocationId()
        );
    }

    public function testEmptyRuleSet()
    {
        $inferencer = new ezcDocumentPdfStyleInferencer();
        $element    = $this->xpath->query( '//doc:section' )->item( 0 );

        $this->assertEquals(
            array(),
            $inferencer->inferenceFormattingRules( $element )
        );
    }

    public function testRootNodeSingleRule()
    {
        $inferencer = new ezcDocumentPdfStyleInferencer();

        $inferencer->appendStyleDirectives( array(
            new ezcDocumentPdfCssDirective(
                'article',
                array(
                    'foo' => 'bar',
                )
            ),
        ) );

        $element    = $this->xpath->query( '//doc:article' )->item( 0 );

        $this->assertEquals(
            array(
                'foo' => 'bar',
            ),
            $inferencer->inferenceFormattingRules( $element )
        );
    }
}

?>
