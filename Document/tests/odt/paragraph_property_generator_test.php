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
class ezcDocumentOdtStyleParagraphPropertyGeneratorTest extends ezcDocumentOdtStylePropertyGeneratorTest
{
    public static function suite()
    {
        return new PHPUnit_Framework_TestSuite( __CLASS__ );
    }

    public function testCtor()
    {
        $gen = new ezcDocumentOdtStyleParagraphPropertyGenerator(
            $this->styleConverters
        );

        $this->assertAttributeSame(
            $this->styleConverters,
            'styleConverters',
            $gen
        );

        $this->assertAttributeEquals(
            array(
                'text-align',
                'widows',
                'orphans',
                'text-indent',
                'margin'
            ),
            'styleAttributes',
            $gen
        );
    }

    public function testCreateProperty()
    {
        $gen = new ezcDocumentOdtStyleParagraphPropertyGenerator(
            $this->styleConverters
        );
        $parent = $this->getDomElementFixture();

        $gen->createProperty(
            $parent,
            array(
                'text-align' => new ezcDocumentPcssStyleStringValue( 'center' ),
            )
        );

        $this->assertPropertyExists(
            ezcDocumentOdt::NS_ODT_STYLE,
            'paragraph-properties',
            array(
                array(
                    ezcDocumentOdt::NS_ODT_FO,
                    'text-align'
                ),
            ),
            $parent
        );
    }
}

?>
