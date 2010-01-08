<?php
/**
 * File containing the ezcWebdavLockPropertyHandlerCase class.
 * 
 * @package Webdav
 * @version //autogen//
 * @copyright Copyright (C) 2005-2010 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @subpackage Test
 */


/**
 * Test case for the ezcWebdavLockPropertyHandler class.
 * 
 * @package Webdav
 * @version //autogen//
 * @subpackage Test
 */
class ezcWebdavLockPropertyHandlerTest extends ezcTestCase
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
    public function testExtractProperty( $xml, $desiredResult )
    {
        $xmlTool = new ezcWebdavXmlTool();

        $dom = $xmlTool->createDomDocument( $xml );

        $result = $this->propertyHandler->extractLiveProperty( $dom->documentElement, $xmlTool );
        
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
    public function testSerializeProperty( $xml, $property )
    {
        $xmlTool = new ezcWebdavXmlTool();

        $expectedElement = $xmlTool->createDomDocument( $xml )->documentElement;

        $dummyDom = $xmlTool->createDomDocument();
        $dummyDomElement = $dummyDom->appendChild(
            $xmlTool->createDomElement( $dummyDom, 'prop' )
        );
        
        $resultElement = $this->propertyHandler->serializeLiveProperty( $property, $dummyDomElement, $xmlTool );
        
        $this->assertEquals(
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
