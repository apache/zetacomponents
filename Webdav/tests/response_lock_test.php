<?php
/**
 * Basic test cases for the error response class.
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
 * @subpackage Tests
 * @version //autogentag//
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 */

/**
 * Reqiuire base test
 */

/**
 * Tests for ezcWebdavLockResponse class.
 * 
 * @package Webdav
 * @subpackage Tests
 */
class ezcWebdavLockResponseTest extends ezcTestCase
{
	public static function suite()
	{
		return new PHPUnit_Framework_TestSuite( 'ezcWebdavLockResponseTest' );
	}

    public function testGetUnknownProperty()
    {
        $lockDiscovery = new ezcWebdavLockDiscoveryProperty();
        $response      = new ezcWebdavLockResponse( $lockDiscovery );

        try
        {
            // Read access
            $response->unknownProperty;
        }
        catch ( ezcBasePropertyNotFoundException $e )
        {
            return true;
        }

        $this->fail( 'Expected ezcBasePropertyNotFoundException.' );
    }

    public function testSetUnknownProperty()
    {
        $lockDiscovery = new ezcWebdavLockDiscoveryProperty();
        $response      = new ezcWebdavLockResponse( $lockDiscovery );

        try
        {
            $response->unknownProperty = 42;
        }
        catch ( ezcBasePropertyNotFoundException $e )
        {
            return true;
        }

        $this->fail( 'Expected ezcBasePropertyNotFoundException.' );
    }

    public function testLockResponsePropertyLockDiscovery()
    {
        $lockDiscovery = new ezcWebdavLockDiscoveryProperty();
        $response      = new ezcWebdavLockResponse( $lockDiscovery );

        $this->assertSame(
            $lockDiscovery,
            $response->lockDiscovery,
            'Wrong default value for property type in class ezcWebdavLockResponse.'
        );

        try
        {
            $response->lockDiscovery = 34650;
        }
        catch ( ezcBaseValueException $e )
        {
            return true;
        }

        $this->fail( 'Expected ezcBaseValueException.' );
    }

    public function testLockResponseConstructor()
    {
        $lockDiscovery = new ezcWebdavLockDiscoveryProperty();
        $response      = new ezcWebdavLockResponse( $lockDiscovery, 'some lock token' );

        $response->setHeader( 'Server', 'Some server' );
        $response->validateHeaders();

        $this->assertEquals(
            'some lock token',
            $response->getHeader( 'Lock-Token' )
        );
    }

    public function testLockResponseToString()
    {
        $lockDiscovery = new ezcWebdavLockDiscoveryProperty();
        $response      = new ezcWebdavLockResponse( $lockDiscovery, 'some lock token' );

        $this->assertSame(
            'HTTP/1.1 200 OK',
            (string) $response
        );
    }
}
?>
