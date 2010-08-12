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
class ezcWebdavGetResponseTest extends ezcTestCase
{
	public static function suite()
	{
		return new PHPUnit_Framework_TestSuite( 'ezcWebdavGetResponseTest' );
	}

    public function testResourceGetUnknownProperty()
    {
        $response = new ezcWebdavGetResourceResponse(
            new ezcWebdavResource(
                '/path',
                new ezcWebdavBasicPropertyStorage()
            )
        );

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
        $response = new ezcWebdavGetResourceResponse(
            new ezcWebdavResource(
                '/path',
                new ezcWebdavBasicPropertyStorage()
            )
        );

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

    public function testCollectionGetUnknownProperty()
    {
        $response = new ezcWebdavGetCollectionResponse(
            new ezcWebdavCollection(
                '/path',
                new ezcWebdavBasicPropertyStorage(),
                array()
            )
        );

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
        $response = new ezcWebdavGetCollectionResponse(
            new ezcWebdavCollection(
                '/path',
                new ezcWebdavBasicPropertyStorage(),
                array()
            )
        );

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

    public function testResourceSetPropertyResource()
    {
        $response = new ezcWebdavGetResourceResponse(
            $resource = new ezcWebdavResource(
                '/path',
                new ezcWebdavBasicPropertyStorage()
            )
        );

        $this->assertSame(
            $resource,
            $response->resource,
            'Wrong default value for property resource in class ezcWebdavGetResourceResponse.'
        );

        try
        {
            $response->resource = 200;
        }
        catch ( ezcBaseValueException $e )
        {
            return true;
        }

        $this->fail( 'Expected ezcBaseValueException.' );
    }

    public function testCollectionSetPropertyCollection()
    {
        $response = new ezcWebdavGetCollectionResponse(
            $collection = new ezcWebdavCollection(
                '/path',
                new ezcWebdavBasicPropertyStorage()
            )
        );

        $this->assertSame(
            $collection,
            $response->collection,
            'Wrong default value for property collection in class ezcWebdavGetCollectionResponse.'
        );

        try
        {
            $response->collection = 200;
        }
        catch ( ezcBaseValueException $e )
        {
            return true;
        }

        $this->fail( 'Expected ezcBaseValueException.' );
    }
}
?>
