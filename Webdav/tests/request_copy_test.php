<?php
/**
 * File containing the ezcWebdavCopyRequestTest class.
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
require_once 'request_test.php';

/**
 * Test case for the ezcWebdavCopyRequest class.
 * 
 * @package Webdav
 * @subpackage Tests
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 */
class ezcWebdavCopyRequestTest extends ezcWebdavRequestTestCase
{
    public static function suite()
    {
		return new PHPUnit_Framework_TestSuite( __CLASS__ );
    }

    protected function setUp()
    {
        $this->className = 'ezcWebdavCopyRequest';
        $this->constructorArguments = array(
            '/foo', '/bar'
        );
        $this->defaultValues = array(
            'propertyBehaviour' => null,
        );
        $this->workingValues = array(
            'propertyBehaviour' => new ezcWebdavRequestPropertyBehaviourContent(),
        );
        $this->failingValues = array(
            'propertyBehaviour' => array(
                23,
                23.34,
                true,
                false,
                array( 23, 42 ),
                new stdClass(),
            ),
        );
    }

    public function testValidateHeadersSuccess()
    {
        $req = new ezcWebdavCopyRequest( '/foo', '/bar' );

        $req->setHeader( 'Destination', '/foo/bar' );
        $req->validateHeaders();

        $req->setHeader( 'Overwrite', 'F' );
        $req->validateHeaders();
        
        $req->setHeader( 'Overwrite', 'T' );
        $req->validateHeaders();

        $req->setHeader( 'Depth', ezcWebdavCopyRequest::DEPTH_ONE );
        $req->validateHeaders();

        $req->setHeader( 'Depth', ezcWebdavCopyRequest::DEPTH_INFINITY );
        $req->validateHeaders();

        $req->setHeader( 'Depth', ezcWebdavCopyRequest::DEPTH_ZERO );
        $req->validateHeaders();
    }

    public function testValidateHeadersFailure()
    {
        $req = new ezcWebdavCopyRequest( '/foo', '/bar' );

        $req->setHeader( 'Overwrite', null );
        try
        {
            $req->validateHeaders();
            $this->fail( 'Exception not thrown on missing Overwrite header.' );
        }
        catch ( ezcWebdavMissingHeaderException $e ) {}
        
        $req->setHeader( 'Overwrite', 'A' );
        try
        {
            $req->validateHeaders();
            $this->fail( 'Exception not thrown on invalid Overwrite header.' );
        }
        catch ( ezcWebdavInvalidHeaderException $e ) {}
        // Fix this problem to test others
        $req->setHeader( 'Overwrite', 'T' );
        
        $req->setHeader( 'Depth', null );
        try
        {
            $req->validateHeaders();
            $this->fail( 'Exception not thrown on missing Depth header.' );
        }
        catch ( ezcWebdavMissingHeaderException $e ) {}

        $req->setHeader( 'Depth', 'A' );
        try
        {
            $req->validateHeaders();
            $this->fail( 'Exception not thrown on invalid Depth header.' );
        }
        catch ( ezcWebdavInvalidHeaderException $e ) {}
    }
}

?>
