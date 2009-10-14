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
class ezcDocumentOdtFormattingPropertiesTest extends ezcTestCase
{
    public static function suite()
    {
        return new PHPUnit_Framework_TestSuite( __CLASS__ );
    }

    public function testConstructorSuccess()
    {
        $props = new ezcDocumentOdtFormattingProperties(
            ezcDocumentOdtFormattingProperties::PROPERTIES_TEXT
        );

        $this->assertAttributeEquals(
            ezcDocumentOdtFormattingProperties::PROPERTIES_TEXT,
            'type',
            $props
        );
    }
    
    public function testAppendValueFailure()
    {
        $props = new ezcDocumentOdtFormattingProperties(
            ezcDocumentOdtFormattingProperties::PROPERTIES_TEXT
        );

        try
        {
            $props->append( 'foo' );
            $this->fail( 'Exception not thrown on invalid method call to append().' );
        }
        catch ( RuntimeException $e ) {}
    }
    
    public function testExchangeArrayFailure()
    {
        $props = new ezcDocumentOdtFormattingProperties(
            ezcDocumentOdtFormattingProperties::PROPERTIES_TEXT
        );

        try
        {
            $props->exchangeArray( array() );
            $this->fail( 'Exception not thrown on invalid method call to exchangeArray().' );
        }
        catch ( RuntimeException $e ) {}
    }

    public function testOffsetSetSuccess()
    {
        $props = new ezcDocumentOdtFormattingProperties(
            ezcDocumentOdtFormattingProperties::PROPERTIES_TEXT
        );

        $props['foo'] = 23;

        $this->assertEquals(
            23,
            $props['foo']
        );
    }

    public function testOffsetSetFailure()
    {
        $props = new ezcDocumentOdtFormattingProperties(
            ezcDocumentOdtFormattingProperties::PROPERTIES_TEXT
        );

        try
        {
            $props[23] = 'foo';
            $this->fail( 'Exception not thrown on invalid offset 23.' );
        }
        catch ( ezcBaseValueException $e ) {}
    }
}

?>
