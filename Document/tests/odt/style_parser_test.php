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
class ezcDocumentOdtStyleParserTest extends ezcTestCase
{
    protected $domDocument;

    protected $xpath;

    public static function suite()
    {
        return new PHPUnit_Framework_TestSuite( __CLASS__ );
    }

    protected function setUp()
    {
        $this->domDocument = new DOMDocument();
        $this->domDocument->load(
            dirname( __FILE__ ) . '/../files/odt/tests/s_000_simple.fodt'
        );
        $this->xpath = new DOMXpath( $this->domDocument );
        $this->xpath->registerNamespace( 'style', ezcDocumentOdt::NS_ODT_STYLE );
        $this->xpath->registerNamespace( 'text', ezcDocumentOdt::NS_ODT_TEXT );

        $this->parser = new ezcDocumentOdtStyleParser();
    }

    public function testParseStyleSuccess()
    {
        $name   = 'Text_20_body';
        $family = 'paragraph';
        $dom    = $this->xpath->query(
            '//style:style[@style:name="' . $name . '" and @style:family="' . $family . '"]'
        )->item( 0 );

        $style = $this->parser->parseStyle( $dom, $family, $name );

        $this->assertType(
            'ezcDocumentOdtStyle',
            $style
        );

        $this->assertEquals(
            $name,
            $style->name
        );
        $this->assertEquals(
            $family,
            $style->family
        );

        $this->assertTrue(
            $style->formattingProperties->hasProperties(
                ezcDocumentOdtFormattingProperties::PROPERTIES_PARAGRAPH
            )
        );

        $prop = $style->formattingProperties->getProperties(
            ezcDocumentOdtFormattingProperties::PROPERTIES_PARAGRAPH
        );

        $this->assertEquals(
            '0in',
            $prop['margin-top']
        );
    }

    public function testListStyleNumberSuccess()
    {
        $name   = 'L3';
        $dom    = $this->xpath->query(
            '//text:list-style[@style:name="' . $name . '"]'
        )->item( 0 );

        $style = $this->parser->parseListStyle( $dom, $name );

        $this->assertEquals(
            $name,
            $style->name
        );
        $this->assertEquals(
            10,
            count( $style->listLevels )
        );
        $this->assertType(
            'ezcDocumentOdtListLevelStyleNumber',
            $style->listLevels[1]
        );
        $this->assertEquals(
            'a',
            $style->listLevels[1]->numFormat
        );
    }

    public function testListStyleBulletSuccess()
    {
        $name   = 'L2';
        $dom    = $this->xpath->query(
            '//text:list-style[@style:name="' . $name . '"]'
        )->item( 0 );

        $style = $this->parser->parseListStyle( $dom, $name );

        $this->assertEquals(
            $name,
            $style->name
        );
        $this->assertEquals(
            10,
            count( $style->listLevels )
        );
        $this->assertType(
            'ezcDocumentOdtListLevelStyleBullet',
            $style->listLevels[1]
        );
        $this->assertEquals(
            '•',
            $style->listLevels[1]->bulletChar
        );
    }
}

?>
