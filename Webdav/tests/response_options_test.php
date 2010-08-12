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
 * Tests for ezcWebdavErrorResonse class.
 * 
 * @package Webdav
 * @subpackage Tests
 */
class ezcWebdavOptionsResponseTest extends ezcTestCase
{
	public static function suite()
	{
		return new PHPUnit_Framework_TestSuite( 'ezcWebdavOptionsResponseTest' );
	}

    public function testResourceOptionsUnknownProperty()
    {
        $response = new ezcWebdavOptionsResponse();

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

    public function testResourceSetUnknownProperty()
    {
        $response = new ezcWebdavOptionsResponse();

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

    public function testCollectionOptionsUnknownProperty()
    {
        $response = new ezcWebdavOptionsResponse();

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

    public function testCollectionSetUnknownProperty()
    {
        $response = new ezcWebdavOptionsResponse();

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

    public function testValidateHeadersSuccess()
    {
        $response = new ezcWebdavOptionsResponse();
        $response->setHeader( 'Server', 'Some/Server/Software' );

        $response->validateHeaders();
        $this->assertEquals(
            '1',
            $response->getHeader( 'DAV' )
        );

        $response->setHeader( 'DAV', '1, 1#extended' );

        $response->validateHeaders();
        $this->assertEquals(
            '1, 1#extended',
            $response->getHeader( 'DAV' )
        );

        $response->setHeader( 'DAV', '1   ,    2,1#extended' );

        $response->validateHeaders();
        $this->assertEquals(
            '1, 2, 1#extended',
            $response->getHeader( 'DAV' )
        );

        $response->setHeader( 'DAV', '1' );

        $response->validateHeaders();
        $this->assertEquals(
            '1',
            $response->getHeader( 'DAV' )
        );
    }

    public function testValidateHeadersFailure()
    {
        $response = new ezcWebdavOptionsResponse();

        $response->setHeader( 'DAV', null );

        try
        {
            $response->validateHeaders();
            $this->fail( "Exception not thrown on missing header 'DAV'." );
        }
        catch ( ezcWebdavMissingHeaderException $e ) {}

        $response->setHeader( 'DAV', '1, 2#extended' );

        try
        {
            $response->validateHeaders();
            $this->fail( "Exception not thrown on invalid header 'DAV'." );
        }
        catch ( ezcWebdavInvalidHeaderException $e ) {}
    }

}
?>
