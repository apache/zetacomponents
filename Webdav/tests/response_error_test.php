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
 * Tests for ezcWebdavErrorResponse class.
 * 
 * @package Webdav
 * @subpackage Tests
 */
class ezcWebdavErrorResponseTest extends ezcTestCase
{
	public static function suite()
	{
		return new PHPUnit_Framework_TestSuite( 'ezcWebdavErrorResponseTest' );
	}

    public function testGetUnknownProperty()
    {
        $response = new ezcWebdavErrorResponse( ezcWebdavResponse::STATUS_404 );

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
        $response = new ezcWebdavErrorResponse( ezcWebdavResponse::STATUS_404 );

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

    public function testErrorResponseOptionStatus()
    {
        $response = new ezcWebdavErrorResponse( ezcWebdavResponse::STATUS_404 );

        $this->assertSame(
            ezcWebdavResponse::STATUS_404,
            $response->status,
            'Wrong default value for property type in class ezcWebdavErrorResponse.'
        );

        try
        {
            $response->status = 34650;
        }
        catch ( ezcBaseValueException $e )
        {
            return true;
        }

        $this->fail( 'Expected ezcBaseValueException.' );
    }

    public function testErrorResponseOptionRequestUri()
    {
        $response = new ezcWebdavErrorResponse( ezcWebdavResponse::STATUS_404, '/requested' );

        $this->assertSame(
            '/requested',
            $response->requestUri,
            'Wrong default value for property requestUri in class ezcWebdavErrorResponse.'
        );

        $response->requestUri = '/foo';
        $this->assertSame(
            '/foo',
            $response->requestUri,
            'Setting property value did not work for property requestUri in class ezcWebdavErrorResponse.'
        );

        try
        {
            $response->requestUri = false;
        }
        catch ( ezcBaseValueException $e )
        {
            return true;
        }

        $this->fail( 'Expected ezcBaseValueException.' );
    }

    public function testErrorResponseToString()
    {
        $response = new ezcWebdavErrorResponse( ezcWebdavResponse::STATUS_404, '/requested' );

        $this->assertSame(
            'HTTP/1.1 404 Not Found',
            (string) $response
        );
    }
}
?>
