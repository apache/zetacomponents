<?php
/**
 * File containing the ezcWebdavLockPluginOptionsTest class.
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
 * Test case for the ezcWebdavLockPluginOptions class.
 * 
 * @package Webdav
 * @version //autogen//
 * @subpackage Test
 */
class ezcWebdavLockPluginOptionsTest extends ezcTestCase
{
    public static function suite()
    {
		return new PHPUnit_Framework_TestSuite( __CLASS__ );
    }

    public function testConstructorSuccess()
    {
        $opt = new ezcWebdavLockPluginOptions();

        $this->assertAttributeEquals(
            array(
                'lockTimeout'         => 900,
                'backendLockTimeout'  => 10000000,
                'backendLockWaitTime' => 10000,
            ),
            'properties',
            $opt
        );

        $opt = new ezcWebdavLockPluginOptions(
            array(
                'lockTimeout'         => 123,
                'backendLockTimeout'  => 123456,
                'backendLockWaitTime' => 1234,
            )
        );

        $this->assertAttributeEquals(
            array(
                'lockTimeout'         => 123,
                'backendLockTimeout'  => 123456,
                'backendLockWaitTime' => 1234,
            ),
            'properties',
            $opt
        );
    }

    public function testSetAccessSuccess()
    {
        $opt = new ezcWebdavLockPluginOptions();

        $this->assertSetProperty(
            $opt,
            'lockTimeout',
            array( 1, 23, 42, 100000, 2147483647 )
        );
        $this->assertSetProperty(
            $opt,
            'backendLockTimeout',
            array( 1, 23, 42, 100000, 2147483647 )
        );
        $this->assertSetProperty(
            $opt,
            'backendLockWaitTime',
            array( 1, 23, 42, 100000, 2147483647 )
        );
    }

    public function testSetAccessFailure()
    {
        $opt = new ezcWebdavLockPluginOptions();

        $this->assertSetPropertyFails(
            $opt,
            'lockTimeout',
            array( 0, -42, true, false, 'foo', 23.42, array(), new stdClass() )
        );
        $this->assertSetPropertyFails(
            $opt,
            'backendLockTimeout',
            array( 0, -42, true, false, 'foo', 23.42, array(), new stdClass() )
        );
        $this->assertSetPropertyFails(
            $opt,
            'backendLockWaitTime',
            array( 0, -42, true, false, 'foo', 23.42, array(), new stdClass() )
        );
    }

    public function testGetAccessFailure()
    {
        $opt = new ezcWebdavLockPluginOptions();

        try
        {
            echo $opt->foo;
            $this->fail( 'Exception not thrown on get access to non-existent property.' );
        }
        catch( ezcBasePropertyNotFoundException $e ) {}
    }

    public function testIssetAccess()
    {
        $opt = new ezcWebdavLockPluginOptions();

        $this->assertTrue(
            isset( $opt->lockTimeout )
        );
        $this->assertTrue(
            isset( $opt->backendLockTimeout )
        );
        $this->assertTrue(
            isset( $opt->backendLockWaitTime )
        );
        $this->assertFalse(
            isset( $opt->foo )
        );
    }
}

?>
