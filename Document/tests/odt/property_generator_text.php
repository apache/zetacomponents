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

/**
 * Test suite for class.
 * 
 * @package Document
 * @subpackage Tests
 */
class ezcDocumentOdtTextStylePropertyGeneratorTest extends ezcTestCase
{
    protected $domElement;

    protected $propGenerator;

    public static function suite()
    {
        return new PHPUnit_Framework_TestSuite( __CLASS__ );
    }

    public function setUp()
    {
        $domDocument = new DOMDocument();
        $this->domElement = $domDocument->appendChild(
            $domDocument->createElement( 'parent' )
        );

        $this->propGenerator = new ezcDocumentOdtTextStylePropertyGenerator();
    }

    /**
     * @dataProvider getTextDecorationTestSets
     */
    public function testConvertTextProperties( $styles, $expectedAttributes )
    {
        $this->propGenerator->createProperty(
            $this->domElement,
            $styles
        );

        $children = $this->domElement->getElementsByTagNameNS(
            ezcDocumentOdt::NS_ODT_STYLE,
            'text-properties'
        );

        $this->assertEquals(
            1,
            $children->length,
            'Inconsistent number of property elements.'
        );

        $txtProp = $children->item( 0 );

        $this->assertEquals(
            count( $expectedAttributes ),
            $txtProp->attributes->length,
            'Inconsistent number of text property element attributes.'
        );

        foreach ( $expectedAttributes as $attrDef )
        {
            $this->assertTrue(
                $txtProp->hasAttributeNS(
                    $attrDef[0],
                    $attrDef[1]
                ),
                "Missing attribute '{$attrDef[0]}:{$attrDef[1]}'."
            );
            $this->assertEquals(
                $attrDef[2],
                ( $actAttrVal = $txtProp->getAttributeNS(
                    $attrDef[0],
                    $attrDef[1]
                ) ),
                "Attribute '{$attrDef[0]}:{$attrDef[1]}' has incorrect value '$actAttrVal', expected '{$attrDef[2]}'."
            );

        }
    }

    public static function getTextPropertyTestSets()
    {
        return array_merge(
            self::getTextDecorationTestSets(),
            self::getFontTestSets()
        );
    }

    /**
     * Test sets for the 'text-decoration' style attribute.
     */
    public static function getFontTestSets()
    {
        return array(
            'font-size' => array(
                // styles
                array(
                    'font-size' => new ezcDocumentPcssStyleMeasureValue( 23 )
                ),
                // expected attributes
                array(
                    // NS, attribute name, value
                    array( ezcDocumentOdt::NS_ODT_FO, 'font-size', '23mm' ),
                    array( ezcDocumentOdt::NS_ODT_STYLE, 'font-size-asian', '23mm' ),
                    array( ezcDocumentOdt::NS_ODT_STYLE, 'font-size-complex', '23mm' ),
                )
            ),
            'font-name' => array(
                // styles
                array(
                    'font-name' => new ezcDocumentPcssStyleStringValue( 'DejaVu Sans' )
                ),
                // expected attributes
                array(
                    // NS, attribute name, value
                    array( ezcDocumentOdt::NS_ODT_FO, 'font-name', 'DejaVu Sans' ),
                    array( ezcDocumentOdt::NS_ODT_STYLE, 'font-name-asian', 'DejaVu Sans' ),
                    array( ezcDocumentOdt::NS_ODT_STYLE, 'font-name-complex', 'DejaVu Sans' ),
                )
            ),
            'font-weight' => array(
                // styles
                array(
                    'font-weight' => new ezcDocumentPcssStyleStringValue( '600' )
                ),
                // expected attributes
                array(
                    // NS, attribute weight, value
                    array( ezcDocumentOdt::NS_ODT_FO, 'font-weight', '600' ),
                    array( ezcDocumentOdt::NS_ODT_STYLE, 'font-weight-asian', '600' ),
                    array( ezcDocumentOdt::NS_ODT_STYLE, 'font-weight-complex', '600' ),
                )
            ),
        );
    }

    /**
     * Test sets for the 'text-decoration' style attribute.
     */
    public static function getTextDecorationTestSets()
    {
        return array(
            'text-decoration: line-through' => array(
                // styles
                array(
                    'text-decoration' => new ezcDocumentPcssStyleListValue( array( 'line-through' ) )
                ),
                // expected attributes
                array(
                    // NS, attribute name, value
                    array( ezcDocumentOdt::NS_ODT_STYLE, 'text-line-through-type', 'single' ),
                    array( ezcDocumentOdt::NS_ODT_STYLE, 'text-line-through-style', 'solid' ),
                    array( ezcDocumentOdt::NS_ODT_STYLE, 'text-line-through-width', 'auto' ),
                    array( ezcDocumentOdt::NS_ODT_STYLE, 'text-line-through-color', 'font-color' ),
                )
            ),
            'text-decoration: underline' => array(
                // styles
                array(
                    'text-decoration' => new ezcDocumentPcssStyleListValue( array( 'underline' ) )
                ),
                // expected attributes
                array(
                    // NS, attribute name, value
                    array( ezcDocumentOdt::NS_ODT_STYLE, 'text-underline-type', 'single' ),
                    array( ezcDocumentOdt::NS_ODT_STYLE, 'text-underline-style', 'solid' ),
                    array( ezcDocumentOdt::NS_ODT_STYLE, 'text-underline-width', 'auto' ),
                    array( ezcDocumentOdt::NS_ODT_STYLE, 'text-underline-color', 'font-color' ),
                )
            ),
            'text-decoration: overline' => array(
                // styles
                array(
                    'text-decoration' => new ezcDocumentPcssStyleListValue( array( 'overline' ) )
                ),
                // expected attributes
                array(
                )
            ),
            'text-decoration: blink' => array(
                // styles
                array(
                    'text-decoration' => new ezcDocumentPcssStyleListValue( array( 'blink' ) )
                ),
                // expected attributes
                array(
                    // NS, attribute name, value
                    array( ezcDocumentOdt::NS_ODT_STYLE, 'text-blinking', 'true' ),
                )
            ),
            'text-decoration: multiple' => array(
                // styles
                array(
                    'text-decoration' => new ezcDocumentPcssStyleListValue( array( 'blink', 'underline' ) )
                ),
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
}

?>
