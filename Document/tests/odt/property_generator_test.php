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
    protected $styleConverters;

    public function setup()
    {
        $this->styleConverters = new ezcDocumentOdtStyleConverterManager();
    }

    protected function getDomElementFixture()
    {
        $domDocument = new DOMDocument();
        return $domDocument->appendChild(
             $domDocument->createElementNS(
                ezcDocumentOdt::NS_ODT_STYLE,
                'style'
             )
        );
    }
    
    protected function assertPropertyExists( $exptectedNs, $expectedName, array $expectedProperties, DOMElement $actualParent )
    {
        $props = $actualParent->getElementsByTagNameNS(
            $exptectedNs,
            $expectedName
        );
        $this->assertEquals( 1, $props->length );

        $prop = $props->item( 0 );

        foreach ( $expectedProperties as $propDef )
        {
            $this->assertTrue(
                $prop->hasAttributeNs(
                    $propDef[0],
                    $propDef[1]
                )
            );
        }
    }
}

?>
