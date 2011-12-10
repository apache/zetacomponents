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
 * Test the struct ezcMvcInternalRedirect.
 *
 * @package MvcTools
 * @subpackage Tests
 */
class ezcMvcInternalRedirectTest extends ezcTestCase
{
    public function testIsStruct()
    {
        $struct = new ezcMvcInternalRedirect();
        $this->assertTrue( $struct instanceof ezcBaseStruct );
    }

    public function testGetSet()
    {
        $struct = new ezcMvcInternalRedirect();
        $struct->request = 'php';
        $this->assertEquals( 'php', $struct->request, 'Property request does not have the expected value' );
    }

    public function testSetState()
    {
        $state = array(
        'request' => 'php',
        );
        $struct = ezcMvcInternalRedirect::__set_state( $state );
        $this->assertEquals( 'php', $struct->request, 'Property request does not have the expected value' );
    }

    public static function suite()
    {
        return new PHPUnit_Framework_TestSuite( "ezcMvcInternalRedirectTest" );
    }
}
?>