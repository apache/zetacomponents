<?php
/**
 * File containing the ezcWebdavPropFindRequestTest class.
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
 * Test case for the ezcWebdavPropFindRequest class.
 * 
 * @package Webdav
 * @subpackage Tests
 * @version //autogentag//
 */
class ezcWebdavPropFindRequestTest extends ezcWebdavRequestTestCase
{
    public static function suite()
    {
		return new PHPUnit_Framework_TestSuite( __CLASS__ );
    }

    protected function setUp()
    {
        $this->className = 'ezcWebdavPropFindRequest';
        $this->constructorArguments = array(
            '/foo', '/bar'
        );
        $this->defaultValues = array(
            'allProp'  => false,
            'propName' => false,
            'prop'     => null,
        );
        $this->workingValues = array(
            'allProp' => array(
                true,
                false,
            ),
            'propName' => array(
                true,
                false,
            ),
            'prop' => array(
                new ezcWebdavBasicPropertyStorage(),
                null
            ),
        );
        $this->failingValues = array(
            'allProp' => array(
                23,
                23.34,
                'foo bar',
                array( 23, 42 ),
                new stdClass(),
            ),
            'propName' => array(
                23,
                23.34,
                'foo bar',
                array( 23, 42 ),
                new stdClass(),
            ),
            'prop' => array(
                23,
                23.34,
                'foo bar',
                true,
                false,
                new stdClass(),
                array( 23, 42),
            ),
        );
    }

    public function testValidateHeadersSuccess()
    {
        $req = new ezcWebdavPropFindRequest( '/foo', '/bar' );

        $req->setHeader( 'Depth', ezcWebdavPropFindRequest::DEPTH_ONE );
        $req->validateHeaders();

        $req->setHeader( 'Depth', ezcWebdavPropFindRequest::DEPTH_INFINITY );
        $req->validateHeaders();

        $req->setHeader( 'Depth', ezcWebdavPropFindRequest::DEPTH_ZERO );
        $req->validateHeaders();
    }

    public function testValidateHeadersFailure()
    {
        $req = new ezcWebdavPropFindRequest( '/foo', '/bar' );
        
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
