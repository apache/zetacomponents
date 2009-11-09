<?php
/**
 * ezcDocumentOdtStyleTest.
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
class ezcDocumentOdtStyleTest extends ezcTestCase
{
    public static function suite()
    {
        return new PHPUnit_Framework_TestSuite( __CLASS__ );
    }

    public function testConstructorSuccess()
    {
        $style = new ezcDocumentOdtStyle(
            ezcDocumentOdtStyle::FAMILY_TABLE,
            'testTableStyle'
        );

        $this->assertAttributeEquals(
            array(
                'name'                 => 'testTableStyle',
                'family'               => ezcDocumentOdtStyle::FAMILY_TABLE,
                'formattingProperties' => new ezcDocumentOdtFormattingPropertyCollection()
            ),
            'properties',
            $style
        );
    }

    public function testSetFormattingPropertiesSuccess()
    {
        $style = new ezcDocumentOdtStyle(
            ezcDocumentOdtStyle::FAMILY_TABLE,
            'testTableStyle'
        );
        $style->formattingProperties = new ezcDocumentOdtFormattingPropertyCollection();
    }

    public function testSetFormattingPropertiesFailure()
    {
        $style = new ezcDocumentOdtStyle(
            ezcDocumentOdtStyle::FAMILY_TABLE,
            'testTableStyle'
        );
        try
        {
            $style->formattingProperties = new ArrayObject();
            $this->fail( 'Did not fail on invalid value for property $formattingProperties.' );
        } catch ( ezcBaseValueException $e ) {}
    }
}

?>
