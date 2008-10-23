<?php
/**
 * File containing the ezcWebdavLockPropertyHandlerCase class.
 * 
 * @package Webdav
 * @version //autogen//
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @subpackage Test
 */

require_once 'test_case.php';

/**
 * Test case for the ezcWebdavLockPropertyHandler class.
 * 
 * @package Webdav
 * @version //autogen//
 * @subpackage Test
 */
class ezcWebdavLockPropertyHandlerTest extends ezcWebdavTestCase
{
    protected $propertyHandler;

    public static function suite()
    {
		return new PHPUnit_Framework_TestSuite( __CLASS__ );
    }

    protected function setUp()
    {
        $this->propertyHandler = new ezcWebdavLockPropertyHandler();
    }

    protected function tearDown()
    {
        unset( $this->propertyHandler );
    }

    /**
     * testExtractLiveProperty 
     * 
     * @param mixed $xml 
     * @param mixed $result 
     * @return void
     *
     * @dataProvider provideLivePropertyData
     */
    public function testExtractProperty( $xml, $desiredResult, $live = true )
    {
        $xmlTool = new ezcWebdavXmlTool();

        $dom = $xmlTool->createDomDocument( $xml );

        if ( $live )
        {
            $result = $this->propertyHandler->extractLiveProperty( $dom->documentElement, $xmlTool );
        }
        else
        {
            $result = $this->propertyHandler->extractDeadProperty( $dom->documentElement, $xmlTool );
        }
        
        $this->assertEquals(
            $desiredResult,
            $result
        );
    }

    /**
     * testExtractLiveProperty 
     * 
     * @param mixed $xml 
     * @param mixed $result 
     * @return void
     *
     * @dataProvider provideLivePropertyData
     */
    public function testSerializeProperty( $xml, $property, $live = true )
    {
        $xmlTool = new ezcWebdavXmlTool();

        $expectedElement = $xmlTool->createDomDocument( $xml )->documentElement;

        $dummyDom = $xmlTool->createDomDocument();
        $dummyDomElement = $dummyDom->appendChild(
            $xmlTool->createDomElement( $dummyDom, 'prop' )
        );
        
        if ( $live )
        {
            $resultElement = $this->propertyHandler->serializeLiveProperty( $property, $dummyDomElement, $xmlTool );
        }
        else
        {
            $resultElement = $this->propertyHandler->serializeDeadProperty( $property, $dummyDomElement, $xmlTool );
        }
        
        // @TODO: This does not validate the XML needs to be refactored!
        $this->assertDomTreeEquals(
            $expectedElement,
            $resultElement
        );
    }


    public static function provideLivePropertyData()
    {
        return require( 'data/lock_properties/extract_live_property.php' );
    }

}

?>
