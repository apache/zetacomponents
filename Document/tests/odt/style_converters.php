<?php
/**
 * ezcDocumentOdtFormattingPropertiesTest.
 * 
 * @package Document
 * @version //autogen//
 * @subpackage Tests
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

require_once 'property_generator_test.php';

/**
 * Test suite for class.
 * 
 * @package Document
 * @subpackage Tests
 */
class ezcDocumentOdtTextStylePropertyGeneratorTest extends ezcDocumentOdtStylePropertyGeneratorTest
{
    protected $domElement;

    public static function suite()
    {
        return new PHPUnit_Framework_TestSuite( __CLASS__ );
    }

    protected function setUp()
    {
        $domDocument = new DOMDocument();
        $this->domElement = $domDocument->appendChild(
            $domDocument->createElement( 'parent' )
        );
    }

    protected function assertAttributesCorrect( array $expectedAttributes )
    {
        $this->assertEquals(
            count( $expectedAttributes ),
            $this->domElement->attributes->length,
            'Inconsistent number of text property element attributes.'
        );

        foreach ( $expectedAttributes as $attrDef )
        {
            $this->assertTrue(
                $this->domElement->hasAttributeNS(
                    $attrDef[0],
                    $attrDef[1]
                ),
                "Missing attribute '{$attrDef[0]}:{$attrDef[1]}'."
            );
            $this->assertEquals(
                $attrDef[2],
                ( $actAttrVal = $this->domElement->getAttributeNS(
                    $attrDef[0],
                    $attrDef[1]
                ) ),
                "Attribute '{$attrDef[0]}:{$attrDef[1]}' has incorrect value '$actAttrVal', expected '{$attrDef[2]}'."
            );
        }
    }

    /**
     * @dataProvider getTextDecorationTestSets
     */
    public function testConvertTextDecoration( $styleValue, $expectedAttributes )
    {
        $converter = new ezcDocumentOdtTextDecorationStyleConverter();
        $converter->convert( $this->domElement, 'text-decoration', $styleValue );

        $this->assertAttributesCorrect(
            $expectedAttributes
        );
    }

    /**
     * Test sets for the 'text-decoration' style attribute.
     */
    public static function getTextDecorationTestSets()
    {
        return array(
            'line-through' => array(
                // style
                new ezcDocumentPcssStyleListValue( array( 'line-through' ) ),
                // expected attributes
                array(
                    // NS, attribute name, value
                    array( ezcDocumentOdt::NS_ODT_STYLE, 'text-line-through-type', 'single' ),
                    array( ezcDocumentOdt::NS_ODT_STYLE, 'text-line-through-style', 'solid' ),
                    array( ezcDocumentOdt::NS_ODT_STYLE, 'text-line-through-width', 'auto' ),
                    array( ezcDocumentOdt::NS_ODT_STYLE, 'text-line-through-color', 'font-color' ),
                )
            ),
            'underline' => array(
                // style
                new ezcDocumentPcssStyleListValue( array( 'underline' ) ),
                // expected attributes
                array(
                    // NS, attribute name, value
                    array( ezcDocumentOdt::NS_ODT_STYLE, 'text-underline-type', 'single' ),
                    array( ezcDocumentOdt::NS_ODT_STYLE, 'text-underline-style', 'solid' ),
                    array( ezcDocumentOdt::NS_ODT_STYLE, 'text-underline-width', 'auto' ),
                    array( ezcDocumentOdt::NS_ODT_STYLE, 'text-underline-color', 'font-color' ),
                )
            ),
            'overline' => array(
                // style
                new ezcDocumentPcssStyleListValue( array( 'overline' ) ),
                // expected attributes
                array(
                )
            ),
            'blink' => array(
                // style
                new ezcDocumentPcssStyleListValue( array( 'blink' ) ),
                // expected attributes
                array(
                    // NS, attribute name, value
                    array( ezcDocumentOdt::NS_ODT_STYLE, 'text-blinking', 'true' ),
                )
            ),
            'multiple' => array(
                // style
                new ezcDocumentPcssStyleListValue( array( 'blink', 'underline' ) ),
                // expected attributes
                array(
                    // NS, attribute name, value
                    array( ezcDocumentOdt::NS_ODT_STYLE, 'text-blinking', 'true' ),
                    array( ezcDocumentOdt::NS_ODT_STYLE, 'text-underline-type', 'single' ),
                    array( ezcDocumentOdt::NS_ODT_STYLE, 'text-underline-style', 'solid' ),
                    array( ezcDocumentOdt::NS_ODT_STYLE, 'text-underline-width', 'auto' ),
                    array( ezcDocumentOdt::NS_ODT_STYLE, 'text-underline-color', 'font-color' ),
                )
            ),
        );
    }

    /**
     * @dataProvider getColorTestSets
     */
    public function testConvertColor( $styleValue, $expectedAttributes )
    {
        $converter = new ezcDocumentOdtColorStyleConverter();
        $converter->convert( $this->domElement, 'color', $styleValue );

        $this->assertAttributesCorrect(
            $expectedAttributes
        );
    }

    /**
     * Test sets for color style attributes.
     */
    public static function getColorTestSets()
    {
        return array(
            'non-transparent' => array(
                // style
                new ezcDocumentPcssStyleColorValue(
                    array(
                        'red'   => 1.0,
                        'green' => 1.0,
                        'blue'  => 1.0,
                        'alpha' => 0.4,
                    )
                ),
                // expected attributes
                array(
                    // NS, attribute name, value
                    array( ezcDocumentOdt::NS_ODT_FO, 'color', '#ffffff' ),
                )
            ),
            'transparent' => array(
                // style
                new ezcDocumentPcssStyleColorValue(
                    array(
                        'red'   => 1.0,
                        'green' => 1.0,
                        'blue'  => 1.0,
                        'alpha' => 0.5,
                    )
                ),
                // expected attributes
                array(
                    // NS, attribute name, value
                    array( ezcDocumentOdt::NS_ODT_FO, 'color', 'transparent' ),
                )
            ),
            'value' => array(
                // style
                new ezcDocumentPcssStyleColorValue(
                    array(
                        'red'   => 0.75294117647059,
                        'green' => 1.0,
                        'blue'  => 0,
                        'alpha' => 0.0,
                    )
                ),
                // expected attributes
                array(
                    // NS, attribute name, value
                    array( ezcDocumentOdt::NS_ODT_FO, 'color', '#c0ff00' ),
                )
            ),
        );
    }

    /**
     * @dataProvider getBackgroundColorTestSets
     */
    public function testConvertBackgroundColor( $styleValue, $expectedAttributes )
    {
        $converter = new ezcDocumentOdtColorStyleConverter();
        $converter->convert( $this->domElement, 'background-color', $styleValue );

        $this->assertAttributesCorrect(
            $expectedAttributes
        );
    }

    /**
     * Test sets for background-color style attributes.
     */
    public static function getBackgroundColorTestSets()
    {
        // Re-use color test sets, but with background-color attribute name
        $colorTestSets = self::getColorTestSets();
        foreach ( $colorTestSets as $setId => $set )
        {
            foreach( $set[1] as $attrId => $attrDef )
            {
                $attrDef[1] = 'background-color';
                $colorTestSets[$setId][1][$attrId] = $attrDef;
            }
        }
        return $colorTestSets;
    }

    /**
     * @dataProvider getFontSizeTestSets
     */
    public function testConvertFontSize( $styleValue, $expectedAttributes )
    {
        $converter = new ezcDocumentOdtFontSizeStyleConverter();
        $converter->convert( $this->domElement, 'font-size', $styleValue );

        $this->assertAttributesCorrect(
            $expectedAttributes
        );
    }

    /**
     * Test sets for font style attributes.
     */
    public static function getFontSizeTestSets()
    {
        return array(
            'font-size' => array(
                // styles
                new ezcDocumentPcssStyleMeasureValue( 23 ),
                // expected attributes
                array(
                    // NS, attribute name, value
                    array( ezcDocumentOdt::NS_ODT_FO, 'font-size', '23mm' ),
                    array( ezcDocumentOdt::NS_ODT_STYLE, 'font-size-asian', '23mm' ),
                    array( ezcDocumentOdt::NS_ODT_STYLE, 'font-size-complex', '23mm' ),
                )
            ),
        );
    }

    /**
     * @dataProvider getTextFontNameTestSets
     */
    public function testConvertMiscFontProperty( $styleValue, $expectedAttributes )
    {
        $converter = new ezcDocumentOdtFontStyleConverter();
        $converter->convert( $this->domElement, 'font-name', $styleValue );

        $this->assertAttributesCorrect(
            $expectedAttributes
        );
    }

    public static function getTextFontNameTestSets()
    {
        return array(
            'font-name' => array(
                // styles
                new ezcDocumentPcssStyleStringValue( 'DejaVu Sans' ),
                // expected attributes
                array(
                    // NS, attribute name, value
                    array( ezcDocumentOdt::NS_ODT_FO, 'font-name', 'DejaVu Sans' ),
                    array( ezcDocumentOdt::NS_ODT_STYLE, 'font-name-asian', 'DejaVu Sans' ),
                    array( ezcDocumentOdt::NS_ODT_STYLE, 'font-name-complex', 'DejaVu Sans' ),
                )
            ),
        );
    }
}

?>
