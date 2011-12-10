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
 * Test the struct ezcMvcRoutingInformation.
 *
 * @package MvcTools
 * @subpackage Tests
 */
class ezcMvcRoutingInformationTest extends ezcTestCase
{
    public function testIsStruct()
    {
        $struct = new ezcMvcRoutingInformation();
        $this->assertTrue( $struct instanceof ezcBaseStruct );
    }

    public function testGetSet()
    {
        $struct = new ezcMvcRoutingInformation();
        $struct->matchedRoute = 'php';
        $this->assertEquals( 'php', $struct->matchedRoute, 'Property matchedRoute does not have the expected value' );
        $struct->controllerClass = 'ezc';
        $this->assertEquals( 'ezc', $struct->controllerClass, 'Property controllerClass does not have the expected value' );
        $struct->action = 'ezp';
        $this->assertEquals( 'ezp', $struct->action, 'Property action does not have the expected value' );
    }

    public function testSetState()
    {
        $state = array(
        'matchedRoute' => 'php',
        'controllerClass' => 'ezc',
        'action' => 'ezp',
        'router' => null,
        );
        $struct = ezcMvcRoutingInformation::__set_state( $state );
        $this->assertEquals( 'php', $struct->matchedRoute, 'Property matchedRoute does not have the expected value' );
        $this->assertEquals( 'ezc', $struct->controllerClass, 'Property controllerClass does not have the expected value' );
        $this->assertEquals( 'ezp', $struct->action, 'Property action does not have the expected value' );
    }

    public static function suite()
    {
        return new PHPUnit_Framework_TestSuite( "ezcMvcRoutingInformationTest" );
    }
}
?>
