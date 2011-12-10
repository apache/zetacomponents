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
 * Test the struct ezcMvcResultContent.
 *
 * @package MvcTools
 * @subpackage Tests
 */
class ezcMvcResultContentTest extends ezcTestCase
{
    public function testIsStruct()
    {
        $struct = new ezcMvcResultContent();
        $this->assertTrue( $struct instanceof ezcBaseStruct );
    }

    public function testGetSet()
    {
        $struct = new ezcMvcResultContent();
        $struct->language = 'php';
        $this->assertEquals( 'php', $struct->language, 'Property language does not have the expected value' );
        $struct->type = 'ezc';
        $this->assertEquals( 'ezc', $struct->type, 'Property type does not have the expected value' );
        $struct->charset = 'ezp';
        $this->assertEquals( 'ezp', $struct->charset, 'Property charset does not have the expected value' );
        $struct->encoding = 'buddymiles';
        $this->assertEquals( 'buddymiles', $struct->encoding, 'Property encoding does not have the expected value' );
    }

    public function testSetState()
    {
        $state = array(
        'language' => 'php',
        'type' => 'ezc',
        'charset' => 'ezp',
        'encoding' => 'buddymiles',
        'disposition' => new ezcMvcResultContentDisposition(),
        );
        $struct = ezcMvcResultContent::__set_state( $state );
        $this->assertEquals( 'php', $struct->language, 'Property language does not have the expected value' );
        $this->assertEquals( 'ezc', $struct->type, 'Property type does not have the expected value' );
        $this->assertEquals( 'ezp', $struct->charset, 'Property charset does not have the expected value' );
        $this->assertEquals( 'buddymiles', $struct->encoding, 'Property encoding does not have the expected value' );
    }

    public static function suite()
    {
        return new PHPUnit_Framework_TestSuite( "ezcMvcResultContentTest" );
    }
}
?>
