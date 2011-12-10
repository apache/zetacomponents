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
 * Test the struct ezcMvcResultCache.
 *
 * @package MvcTools
 * @subpackage Tests
 */
class ezcMvcResultCacheTest extends ezcTestCase
{
    public function testIsStruct()
    {
        $struct = new ezcMvcResultCache();
        $this->assertTrue( $struct instanceof ezcBaseStruct );
    }

    public function testGetSet()
    {
        $struct = new ezcMvcResultCache();
        $struct->vary = 'php';
        $this->assertEquals( 'php', $struct->vary, 'Property vary does not have the expected value' );
        $struct->expire = 'ezc';
        $this->assertEquals( 'ezc', $struct->expire, 'Property expire does not have the expected value' );
        $struct->controls = 'ezp';
        $this->assertEquals( 'ezp', $struct->controls, 'Property controls does not have the expected value' );
        $struct->pragma = 'buddymiles';
        $this->assertEquals( 'buddymiles', $struct->pragma, 'Property pragma does not have the expected value' );
        $struct->lastModified = 'buddyguy';
        $this->assertEquals( 'buddyguy', $struct->lastModified, 'Property lastModified does not have the expected value' );
    }

    public function testSetState()
    {
        $state = array(
        'vary' => 'php',
        'expire' => 'ezc',
        'controls' => 'ezp',
        'pragma' => 'buddymiles',
        'lastModified' => 'buddyguy',
        );
        $struct = ezcMvcResultCache::__set_state( $state );
        $this->assertEquals( 'php', $struct->vary, 'Property vary does not have the expected value' );
        $this->assertEquals( 'ezc', $struct->expire, 'Property expire does not have the expected value' );
        $this->assertEquals( 'ezp', $struct->controls, 'Property controls does not have the expected value' );
        $this->assertEquals( 'buddymiles', $struct->pragma, 'Property pragma does not have the expected value' );
        $this->assertEquals( 'buddyguy', $struct->lastModified, 'Property lastModified does not have the expected value' );
    }

    public static function suite()
    {
        return new PHPUnit_Framework_TestSuite( "ezcMvcResultCacheTest" );
    }
}
?>