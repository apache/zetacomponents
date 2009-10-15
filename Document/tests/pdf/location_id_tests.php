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
        $this->document->registerNodeClass( 'DOMElement', 'ezcDocumentLocateableDomElement' );

        $this->document->load( dirname( __FILE__ ) . '/../files/docbook/pdf/location_ids.xml' );

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

    public function testLocationIdFromStrangeElementId()
    {
        $element = $this->xpath->query( '//doc:sectioninfo' )->item( 0 );

        $this->assertEquals(
            '/article/section#paragraph_with_inline_markup/sectioninfo#some_strange_id_42',
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

    public function testNodeLocationIdWithClass()
    {
        $element = $this->xpath->query( '//doc:para' )->item( 1 );

        $this->assertEquals(
            '/article/section#paragraph_with_inline_markup/para.note_warning',
            $element->getLocationId()
        );
    }

    public function testNodeLocationIdWithRoleNormalization()
    {
        $element = $this->xpath->query( '//doc:emphasis' )->item( 2 );

        $this->assertEquals(
            '/article/section#paragraph_with_inline_markup/para.note_warning/emphasis[Role=strong]',
            $element->getLocationId()
        );
    }
}

?>
