<?php
/**
 * ezcDocumentOdtFormattingPropertiesTest.
 * 
 * @package Document
 * @version //autogen//
 * @subpackage Tests
 * @copyright Copyright (C) 2005-2010 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Test suite for class.
 * 
 * @package Document
 * @subpackage Tests
 */
class ezcDocumentOdtStyleExtractorTest extends ezcTestCase
{
    protected $domDocument;

    public static function suite()
    {
        return new PHPUnit_Framework_TestSuite( __CLASS__ );
    }

    protected function setUp()
    {
        $this->domDocument = new DOMDocument();
        $this->domDocument->load( dirname( __FILE__ ) . '/../files/odt/tests/s_000_simple.fodt' );
    }
    
    public function testCtor()
    {
        $extr = $this->getExtractorFixture();

        $this->assertAttributeSame(
            $this->domDocument,
            'odt',
            $extr
        );

        $this->assertType(
            'DOMXpath',
            $this->readAttribute( $extr, 'xpath' )
        );
    }

    public function testExtractStyleSuccess()
    {
        $extr = $this->getExtractorFixture();

        $style = $extr->extractStyle( 'paragraph', 'Text_20_body' );

        $this->assertType(
            'DOMElement',
            $style
        );
        $this->assertEquals(
            'style',
            $style->localName
        );
        $this->assertEquals(
            'Text_20_body',
            $style->getAttributeNS(
                ezcDocumentOdt::NS_ODT_STYLE,
                'name'
            )
        );
    }

    public function testExtractDefaultStyleSuccess()
    {
        $extr = $this->getExtractorFixture();

        $style = $extr->extractStyle( 'paragraph' );

        $this->assertType(
            'DOMElement',
            $style
        );
        $this->assertEquals(
            'default-style',
            $style->localName
        );
        $this->assertFalse(
            $style->hasAttributeNs(
                ezcDocumentOdt::NS_ODT_STYLE,
                'name'
            )
        );
        $this->assertEquals(
            'paragraph',
            $style->hasAttributeNs(
                ezcDocumentOdt::NS_ODT_STYLE,
                'family'
            )
        );
    }

    public function testExtractStyleFailure()
    {
        $extr = $this->getExtractorFixture();

        try
        {
            $extr->extractStyle( 'paragraph', 'foobar' );
            $this->fail( 'Exception not thrown on extraction of non-existent style.' );
        }
        catch ( RuntimeException $e ) {}
    }

    public function testExtractDefaultStyleFailure()
    {
        $extr = $this->getExtractorFixture();

        try
        {
            $extr->extractStyle( 'foobar' );
            $this->fail( 'Exception not thrown on extraction of non-existent default style.' );
        }
        catch ( RuntimeException $e ) {}
    }

    public function testExtractListStyleSuccess()
    {
        $extr = $this->getExtractorFixture();

        $style = $extr->extractListStyle( 'L2' );

        $this->assertEquals(
            'list-style',
            $style->localName
        );
        $this->assertEquals(
            'L2',
            $style->getAttributeNS(
                ezcDocumentOdt::NS_ODT_STYLE,
                'name'
            )
        );
    }

    public function testExtractListStyleFailure()
    {
        $extr = $this->getExtractorFixture();

        try
        {
            $extr->extractListStyle( 'foobar' );
            $this->fail( 'Exception not thrown on extraction of non-existent list style.' );
        }
        catch ( RuntimeException $e ) {}
    }

    protected function getExtractorFixture()
    {
        return new ezcDocumentOdtStyleExtractor( $this->domDocument );
    }
}

?>
