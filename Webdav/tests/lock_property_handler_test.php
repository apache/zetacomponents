<?php
/**
 * File containing the ezcWebdavLockPropertyHandlerCase class.
 * 
 * Licensed to the Apache Software Foundation (ASF) under one
 * or more contributor license agreements.  See the NOTICE file
 * distributed with this work for additional information
 * regarding copyright ownership.  The ASF licenses this file
 * to you under the Apache License, Version 2.0 (the
 * "License"); you may not use this file except in compliance
 * with the License.  You may obtain a copy of the License at
 * 
 *   http://www.apache.org/licenses/LICENSE-2.0
 * 
 * Unless required by applicable law or agreed to in writing,
 * software distributed under the License is distributed on an
 * "AS IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS OF ANY
 * KIND, either express or implied.  See the License for the
 * specific language governing permissions and limitations
 * under the License.
 *
 * @package Webdav
 * @version //autogen//
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
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
