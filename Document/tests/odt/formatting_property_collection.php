<?php
/**
 * ezcDocumentOdtFormattingPropertyCollectionTest.
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
class ezcDocumentOdtFormattingPropertyCollectionTest extends ezcTestCase
{
    public static function suite()
    {
        return new PHPUnit_Framework_TestSuite( __CLASS__ );
    }

    public function setUp()
    {
        $this->propColl = new ezcDocumentOdtFormattingPropertyCollection();
    }

    public function tearDown()
    {
        unset( $this->propColl );
    }

    public function testConstructorSuccess()
    {
        $this->assertAttributeEquals(
            array(),
            'properties',
            $this->propColl
        );
    }

    public function testSetPropertiesSuccess()
    {

        $props = new ezcDocumentOdtFormattingProperties(
            ezcDocumentOdtFormattingProperties::PROPERTIES_TEXT
        );
        $this->propColl->setProperties(
            $props
        );

        $this->assertAttributeEquals(
            array(
                ezcDocumentOdtFormattingProperties::PROPERTIES_TEXT => $props
            ),
            'properties',
            $this->propColl
        );
    }

    public function testSetPropertiesFailure()
    {

        $props = new ezcDocumentOdtFormattingProperties(
            ezcDocumentOdtFormattingProperties::PROPERTIES_TEXT
        );
        $this->propColl->setProperties(
            $props
        );

        try
        {
            $this->propColl->setProperties( $props );
            $this->fail( 'Exception not thrown on double setting of properties.' );
        }
        catch ( ezcDocumentOdtFormattingPropertiesExistException $e ) {}
    }

    public function testReplacePropertiesSuccessSingle()
    {

        $props = new ezcDocumentOdtFormattingProperties(
            ezcDocumentOdtFormattingProperties::PROPERTIES_TEXT
        );
        $this->propColl->replaceProperties(
            $props
        );

        $this->assertAttributeEquals(
            array(
                ezcDocumentOdtFormattingProperties::PROPERTIES_TEXT => $props
            ),
            'properties',
            $this->propColl
        );
    }

    public function testReplacePropertiesSuccessDouble()
    {

        $props = new ezcDocumentOdtFormattingProperties(
            ezcDocumentOdtFormattingProperties::PROPERTIES_TEXT
        );
        $this->propColl->replaceProperties(
            $props
        );
        $this->propColl->replaceProperties(
            $props
        );

        $this->assertAttributeEquals(
            array(
                ezcDocumentOdtFormattingProperties::PROPERTIES_TEXT => $props
            ),
            'properties',
            $this->propColl
        );
    }

    public function testHasPropertiesSuccess()
    {

        $props = new ezcDocumentOdtFormattingProperties(
            ezcDocumentOdtFormattingProperties::PROPERTIES_TEXT
        );
        $this->propColl->setProperties(
            $props
        );

        $this->assertTrue(
            $this->propColl->hasProperties( ezcDocumentOdtFormattingProperties::PROPERTIES_TEXT )
        );
    }

    public function testHasPropertiesFailure()
    {
        $this->assertFalse(
            $this->propColl->hasProperties( ezcDocumentOdtFormattingProperties::PROPERTIES_TEXT )
        );
    }

    public function testGetPropertiesSuccess()
    {

        $props = new ezcDocumentOdtFormattingProperties(
            ezcDocumentOdtFormattingProperties::PROPERTIES_TEXT
        );
        $this->propColl->setProperties(
            $props
        );

        $this->assertSame(
            $props,
            $this->propColl->getProperties( ezcDocumentOdtFormattingProperties::PROPERTIES_TEXT )
        );
    }

    public function testGetPropertiesFailure()
    {

        $props = new ezcDocumentOdtFormattingProperties(
            ezcDocumentOdtFormattingProperties::PROPERTIES_TEXT
        );

        $this->assertNull(
            $this->propColl->getProperties( ezcDocumentOdtFormattingProperties::PROPERTIES_TEXT )
        );
    }
}

?>
