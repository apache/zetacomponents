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
 * @package MvcTools
 * @subpackage Tests
 */

/**
 * Test the struct ezcMvcResponse.
 *
 * @package MvcTools
 * @subpackage Tests
 */
class ezcMvcResponseTest extends ezcTestCase
{
    public function testIsStruct()
    {
        $struct = new ezcMvcResponse();
        $this->assertTrue( $struct instanceof ezcBaseStruct );
    }

    public function testGetSet()
    {
        $struct = new ezcMvcResponse();
        $struct->status = 'php';
        $this->assertEquals( 'php', $struct->status, 'Property status does not have the expected value' );
        $struct->date = 'ezc';
        $this->assertEquals( 'ezc', $struct->date, 'Property date does not have the expected value' );
        $struct->generator = 'ezp';
        $this->assertEquals( 'ezp', $struct->generator, 'Property generator does not have the expected value' );
        $struct->cache = 'buddymiles';
        $this->assertEquals( 'buddymiles', $struct->cache, 'Property cache does not have the expected value' );
        $struct->cookies = 'buddyguy';
        $this->assertEquals( 'buddyguy', $struct->cookies, 'Property cookies does not have the expected value' );
        $struct->content = 'django';
        $this->assertEquals( 'django', $struct->content, 'Property content does not have the expected value' );
        $struct->body = 'satchmo';
        $this->assertEquals( 'satchmo', $struct->body, 'Property body does not have the expected value' );
    }

    public function testSetState()
    {
        $state = array(
        'status' => 'php',
        'date' => 'ezc',
        'generator' => 'ezp',
        'cache' => 'buddymiles',
        'cookies' => 'buddyguy',
        'content' => 'django',
        'body' => 'satchmo',
        );
        $struct = ezcMvcResponse::__set_state( $state );
        $this->assertEquals( 'php', $struct->status, 'Property status does not have the expected value' );
        $this->assertEquals( 'ezc', $struct->date, 'Property date does not have the expected value' );
        $this->assertEquals( 'ezp', $struct->generator, 'Property generator does not have the expected value' );
        $this->assertEquals( 'buddymiles', $struct->cache, 'Property cache does not have the expected value' );
        $this->assertEquals( 'buddyguy', $struct->cookies, 'Property cookies does not have the expected value' );
        $this->assertEquals( 'django', $struct->content, 'Property content does not have the expected value' );
        $this->assertEquals( 'satchmo', $struct->body, 'Property body does not have the expected value' );
    }

    public static function suite()
    {
        return new PHPUnit_Framework_TestSuite( "ezcMvcResponseTest" );
    }
}
?>