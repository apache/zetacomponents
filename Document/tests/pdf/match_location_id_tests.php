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
class ezcDocumentPdfMatchLocationIdTests extends ezcTestCase
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

        $this->document->load( dirname( __FILE__ ) . '/../files/docbook/pdf/location_ids.xml' );

        $this->xpath = new DOMXPath( $this->document );
        $this->xpath->registerNamespace( 'doc', 'http://docbook.org/ns/docbook' );
    }

    public function testMatchCommonRootNode()
    {
        $element = $this->xpath->query( '//doc:article' )->item( 0 );

        $directive = new ezcDocumentPdfCssLayoutDirective(
            array( 'article' ),
            array()
        );

        $this->assertEquals(
            true,
            (bool) preg_match( $regexp = $directive->getRegularExpression(), $id = $element->getLocationId() ),
            "Directive $regexp was expected to match elements location id: \"$id\"."
        );
    }

    public function testMatchExplicitRootNode()
    {
        $element = $this->xpath->query( '//doc:article' )->item( 0 );

        $directive = new ezcDocumentPdfCssLayoutDirective(
            array( '> article' ),
            array()
        );

        $this->assertEquals(
            true,
            (bool) preg_match( $regexp = $directive->getRegularExpression(), $id = $element->getLocationId() ),
            "Directive $regexp was expected to match elements location id: \"$id\"."
        );
    }

    public function testNoMatchExplicitRootNode()
    {
        $element = $this->xpath->query( '//doc:section' )->item( 0 );

        $directive = new ezcDocumentPdfCssLayoutDirective(
            array( '> section' ),
            array()
        );

        $this->assertEquals(
            false,
            (bool) preg_match( $regexp = $directive->getRegularExpression(), $id = $element->getLocationId() ),
            "Directive $regexp was expected to NOT match elements location id: \"$id\"."
        );
    }

    public function testNotMatchChildWithParentAssertion()
    {
        $element = $this->xpath->query( '//doc:section' )->item( 0 );

        $directive = new ezcDocumentPdfCssLayoutDirective(
            array( 'article' ),
            array()
        );

        $this->assertEquals(
            false,
            (bool) preg_match( $regexp = $directive->getRegularExpression(), $id = $element->getLocationId() ),
            "Directive $regexp was expected to NOT match elements location id: \"$id\"."
        );
    }

    public function testNoMatchRequiredId()
    {
        $element = $this->xpath->query( '//doc:article' )->item( 0 );

        $directive = new ezcDocumentPdfCssLayoutDirective(
            array( 'article', '#some_id' ),
            array()
        );

        $this->assertEquals(
            false,
            (bool) preg_match( $regexp = $directive->getRegularExpression(), $id = $element->getLocationId() ),
            "Directive $regexp was expected to NOT match elements location id: \"$id\"."
        );
    }

    public function testNoMatchRequiredClass()
    {
        $element = $this->xpath->query( '//doc:article' )->item( 0 );

        $directive = new ezcDocumentPdfCssLayoutDirective(
            array( 'article', '.class' ),
            array()
        );

        $this->assertEquals(
            false,
            (bool) preg_match( $regexp = $directive->getRegularExpression(), $id = $element->getLocationId() ),
            "Directive $regexp was expected to NOT match elements location id: \"$id\"."
        );
    }

    public function testNoMatchRequiredClassAndId()
    {
        $element = $this->xpath->query( '//doc:article' )->item( 0 );

        $directive = new ezcDocumentPdfCssLayoutDirective(
            array( 'article', '.class', '#some_id' ),
            array()
        );

        $this->assertEquals(
            false,
            (bool) preg_match( $regexp = $directive->getRegularExpression(), $id = $element->getLocationId() ),
            "Directive $regexp was expected to NOT match elements location id: \"$id\"."
        );
    }

    public function testMatchNodeWithId()
    {
        $element = $this->xpath->query( '//doc:section' )->item( 0 );

        $directive = new ezcDocumentPdfCssLayoutDirective(
            array( 'section', '#paragraph_with_inline_markup' ),
            array()
        );

        $this->assertEquals(
            true,
            (bool) preg_match( $regexp = $directive->getRegularExpression(), $id = $element->getLocationId() ),
            "Directive $regexp was expected to match elements location id: \"$id\"."
        );
    }

    public function testMatchAnyDescendant()
    {
        $element = $this->xpath->query( '//doc:section' )->item( 0 );

        $directive = new ezcDocumentPdfCssLayoutDirective(
            array( 'article', 'section' ),
            array()
        );

        $this->assertEquals(
            true,
            (bool) preg_match( $regexp = $directive->getRegularExpression(), $id = $element->getLocationId() ),
            "Directive $regexp was expected to match elements location id: \"$id\"."
        );
    }

    public function testMatchDirectDescendant()
    {
        $element = $this->xpath->query( '//doc:section' )->item( 0 );

        $directive = new ezcDocumentPdfCssLayoutDirective(
            array( 'article', 'section' ),
            array()
        );

        $this->assertEquals(
            true,
            (bool) preg_match( $regexp = $directive->getRegularExpression(), $id = $element->getLocationId() ),
            "Directive $regexp was expected to match elements location id: \"$id\"."
        );
    }

    public function testMatchAnyDescendentIgnoreId()
    {
        $element = $this->xpath->query( '//doc:sectioninfo' )->item( 0 );

        $directive = new ezcDocumentPdfCssLayoutDirective(
            array( 'article', 'sectioninfo' ),
            array()
        );

        $this->assertEquals(
            true,
            (bool) preg_match( $regexp = $directive->getRegularExpression(), $id = $element->getLocationId() ),
            "Directive $regexp was expected to match elements location id: \"$id\"."
        );
    }

    public function testNotMatchDirectDescendent()
    {
        $element = $this->xpath->query( '//doc:sectioninfo' )->item( 0 );

        $directive = new ezcDocumentPdfCssLayoutDirective(
            array( 'article', '> sectioninfo' ),
            array()
        );

        $this->assertEquals(
            false,
            (bool) preg_match( $regexp = $directive->getRegularExpression(), $id = $element->getLocationId() ),
            "Directive $regexp was expected to NOT match elements location id: \"$id\"."
        );
    }

    public function testNotMatchPartialId()
    {
        $element = $this->xpath->query( '//doc:sectioninfo' )->item( 0 );

        $directive = new ezcDocumentPdfCssLayoutDirective(
            array( 'section', '#paragraph' ),
            array()
        );

        $this->assertEquals(
            false,
            (bool) preg_match( $regexp = $directive->getRegularExpression(), $id = $element->getLocationId() ),
            "Directive $regexp was expected to NOT match elements location id: \"$id\"."
        );
    }

    public function testMatchByClassName()
    {
        $element = $this->xpath->query( '//doc:para' )->item( 1 );

        $directive = new ezcDocumentPdfCssLayoutDirective(
            array( 'para', '.note_warning' ),
            array()
        );

        $this->assertEquals(
            true,
            (bool) preg_match( $regexp = $directive->getRegularExpression(), $id = $element->getLocationId() ),
            "Directive $regexp was expected to match elements location id: \"$id\"."
        );
    }

    public function testMatchByPartialClassName()
    {
        $element = $this->xpath->query( '//doc:para' )->item( 1 );

        $directive = new ezcDocumentPdfCssLayoutDirective(
            array( 'para', '.note' ),
            array()
        );

        $this->assertEquals(
            true,
            (bool) preg_match( $regexp = $directive->getRegularExpression(), $id = $element->getLocationId() ),
            "Directive $regexp was expected to match elements location id: \"$id\"."
        );
    }

    public function testMatchByPartialClassName2()
    {
        $element = $this->xpath->query( '//doc:para' )->item( 1 );

        $directive = new ezcDocumentPdfCssLayoutDirective(
            array( 'para', '.warning' ),
            array()
        );

        $this->assertEquals(
            true,
            (bool) preg_match( $regexp = $directive->getRegularExpression(), $id = $element->getLocationId() ),
            "Directive $regexp was expected to match elements location id: \"$id\"."
        );
    }

    public function testNotMatchByPartialClassName()
    {
        $element = $this->xpath->query( '//doc:para' )->item( 1 );

        $directive = new ezcDocumentPdfCssLayoutDirective(
            array( 'para', '.not' ),
            array()
        );

        $this->assertEquals(
            false,
            (bool) preg_match( $regexp = $directive->getRegularExpression(), $id = $element->getLocationId() ),
            "Directive $regexp was expected to NOT match elements location id: \"$id\"."
        );
    }

    public function testMatchOnlyByClassName()
    {
        $element = $this->xpath->query( '//doc:para' )->item( 1 );

        $directive = new ezcDocumentPdfCssLayoutDirective(
            array( '.note' ),
            array()
        );

        $this->assertEquals(
            true,
            (bool) preg_match( $regexp = $directive->getRegularExpression(), $id = $element->getLocationId() ),
            "Directive $regexp was expected to match elements location id: \"$id\"."
        );
    }

    public function testNotMatchOnlyByClassName()
    {
        $element = $this->xpath->query( '//doc:para' )->item( 0 );

        $directive = new ezcDocumentPdfCssLayoutDirective(
            array( '.note' ),
            array()
        );

        $this->assertEquals(
            false,
            (bool) preg_match( $regexp = $directive->getRegularExpression(), $id = $element->getLocationId() ),
            "Directive $regexp was expected to NOT match elements location id: \"$id\"."
        );
    }

    public function testMatchOnlyById()
    {
        $element = $this->xpath->query( '//doc:section' )->item( 0 );

        $directive = new ezcDocumentPdfCssLayoutDirective(
            array( '#paragraph_with_inline_markup' ),
            array()
        );

        $this->assertEquals(
            true,
            (bool) preg_match( $regexp = $directive->getRegularExpression(), $id = $element->getLocationId() ),
            "Directive $regexp was expected to match elements location id: \"$id\"."
        );
    }

    public function testNotMatchOnlyById()
    {
        $element = $this->xpath->query( '//doc:article' )->item( 0 );

        $directive = new ezcDocumentPdfCssLayoutDirective(
            array( '#paragraph_with_inline_markup' ),
            array()
        );

        $this->assertEquals(
            false,
            (bool) preg_match( $regexp = $directive->getRegularExpression(), $id = $element->getLocationId() ),
            "Directive $regexp was expected to NOT match elements location id: \"$id\"."
        );
    }

    public function testNotMatchChildOnlyById()
    {
        $element = $this->xpath->query( '//doc:para' )->item( 0 );

        $directive = new ezcDocumentPdfCssLayoutDirective(
            array( '#paragraph_with_inline_markup' ),
            array()
        );

        $this->assertEquals(
            false,
            (bool) preg_match( $regexp = $directive->getRegularExpression(), $id = $element->getLocationId() ),
            "Directive $regexp was expected to NOT match elements location id: \"$id\"."
        );
    }
}

?>
