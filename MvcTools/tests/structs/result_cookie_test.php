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
 * Test the struct ezcMvcResultCookie.
 *
 * @package MvcTools
 * @subpackage Tests
 */
class ezcMvcResultCookieTest extends ezcTestCase
{
    public function testIsStruct()
    {
        $struct = new ezcMvcResultCookie();
        $this->assertTrue( $struct instanceof ezcBaseStruct );
    }

    public function testGetSet()
    {
        $struct = new ezcMvcResultCookie();
        $struct->name = 'php';
        $this->assertEquals( 'php', $struct->name, 'Property name does not have the expected value' );
        $struct->value = 'ezc';
        $this->assertEquals( 'ezc', $struct->value, 'Property value does not have the expected value' );
        $struct->expire = 'ezp';
        $this->assertEquals( 'ezp', $struct->expire, 'Property expire does not have the expected value' );
        $struct->path = 'buddymiles';
        $this->assertEquals( 'buddymiles', $struct->path, 'Property path does not have the expected value' );
        $struct->domain = 'buddyguy';
        $this->assertEquals( 'buddyguy', $struct->domain, 'Property domain does not have the expected value' );
        $struct->secure = 'django';
        $this->assertEquals( 'django', $struct->secure, 'Property secure does not have the expected value' );
        $struct->httpOnly = 'satchmo';
        $this->assertEquals( 'satchmo', $struct->httpOnly, 'Property httpOnly does not have the expected value' );
    }

    public function testSetState()
    {
        $date = new DateTime();
        $state = array(
        'name' => 'php',
        'value' => 'ezc',
        'expire' => $date,
        'path' => 'buddymiles',
        'domain' => 'buddyguy',
        'secure' => 'django',
        'httpOnly' => 'satchmo',
        );
        $struct = ezcMvcResultCookie::__set_state( $state );
        $this->assertEquals( 'php', $struct->name, 'Property name does not have the expected value' );
        $this->assertEquals( 'ezc', $struct->value, 'Property value does not have the expected value' );
        $this->assertEquals( $date, $struct->expire, 'Property expire does not have the expected value' );
        $this->assertEquals( 'buddymiles', $struct->path, 'Property path does not have the expected value' );
        $this->assertEquals( 'buddyguy', $struct->domain, 'Property domain does not have the expected value' );
        $this->assertEquals( 'django', $struct->secure, 'Property secure does not have the expected value' );
        $this->assertEquals( 'satchmo', $struct->httpOnly, 'Property httpOnly does not have the expected value' );
    }

    public static function suite()
    {
        return new PHPUnit_Framework_TestSuite( "ezcMvcResultCookieTest" );
    }
}
?>
