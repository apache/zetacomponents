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
abstract class ezcDocumentOdtStylePropertyGeneratorTest extends ezcTestCase
{
    protected $domElement;

    protected $propGenerator;

    protected function setUp()
    {
        $domDocument = new DOMDocument();
        $this->domElement = $domDocument->appendChild(
            $domDocument->createElement( 'parent' )
        );
    }

    protected function performTestConvertProperties( $ns, $propName, $styles, $expectedAttributes )
    {
        $this->propGenerator->createProperty(
            $this->domElement,
            $styles
        );

        $children = $this->domElement->getElementsByTagNameNS(
            $ns,
            $propName
        );

        $this->assertEquals(
            1,
            $children->length,
            'Inconsistent number of property elements.'
        );

        $prop = $children->item( 0 );

        $this->assertAttributesCorrect( $prop, $expectedAttributes );
    }

    protected function assertAttributesCorrect( DOMElement $actualProp, array $expectedAttributes )
    {
        $this->assertEquals(
            count( $expectedAttributes ),
            $actualProp->attributes->length,
            'Inconsistent number of text property element attributes.'
        );

        foreach ( $expectedAttributes as $attrDef )
        {
            $this->assertTrue(
                $actualProp->hasAttributeNS(
                    $attrDef[0],
                    $attrDef[1]
                ),
                "Missing attribute '{$attrDef[0]}:{$attrDef[1]}'."
            );
            $this->assertEquals(
                $attrDef[2],
                ( $actAttrVal = $actualProp->getAttributeNS(
                    $attrDef[0],
                    $attrDef[1]
                ) ),
                "Attribute '{$attrDef[0]}:{$attrDef[1]}' has incorrect value '$actAttrVal', expected '{$attrDef[2]}'."
            );
        }
    }
}

?>
