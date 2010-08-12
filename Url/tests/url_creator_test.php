<?php
/**
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
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 * @version //autogentag//
 * @filesource
 * @package Url
 * @subpackage Tests
 */

/**
 * @package Url
 * @subpackage Tests
 */
class ezcUrlCreatorTest extends ezcTestCase
{
    public function testGetUrl()
    {
        ezcUrlCreator::registerUrl( 'map', 'http://www.example.com' );
        $expected = 'http://www.example.com';
        $this->assertEquals( $expected, ezcUrlCreator::getUrl( 'map' ) );
    }

    public function testGetUrlNotRegistered()
    {
        try
        {
            ezcUrlCreator::getUrl( 'not registered url' );
            $this->fail( 'Expected exception was not thrown' );
        }
        catch ( ezcUrlNotRegisteredException $e )
        {
            $expected = "The url 'not registered url' is not registered.";
            $this->assertEquals( $expected, $e->getMessage() );
        }
    }

    public function testGetUrlFormatted()
    {
        ezcUrlCreator::registerUrl( 'map', 'http://www.example.com/images/%s?xsize=%d&ysize=%d&zoom=%d' );
        $expected = 'http://www.example.com/images/map_sweden.gif?xsize=400&ysize=300&zoom=4';
        $this->assertEquals( $expected, ezcUrlCreator::getUrl( 'map', 'map_sweden.gif', 400, 300, 4 ) );
    }

    public function testPrependUrl()
    {
        ezcUrlCreator::registerUrl( 'map', 'http://www.example.com?id=1' );
        $expected = 'http://www.example.com/images?id=1';
        $this->assertEquals( $expected, ezcUrlCreator::prependUrl( 'map', 'images' ) );
    }

    public function testPrependUrlNotRegistered()
    {
        try
        {
            ezcUrlCreator::prependUrl( 'not registered url', 'images' );
            $this->fail( 'Expected exception was not thrown' );
        }
        catch ( ezcUrlNotRegisteredException $e )
        {
            $expected = "The url 'not registered url' is not registered.";
            $this->assertEquals( $expected, $e->getMessage() );
        }
    }

    public static function suite()
    {
         return new PHPUnit_Framework_TestSuite( "ezcUrlCreatorTest" );
    }
}
?>
