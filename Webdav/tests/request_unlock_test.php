<?php
/**
 * File containing the ezcWebdavUnlockRequestTest class.
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
 * Test case for the ezcWebdavUnlockRequest class.
 * 
 * @package Webdav
 * @subpackage Tests
 * @version //autogentag//
 */
class ezcWebdavUnlockRequestTest extends ezcWebdavRequestTestCase
{
    public static function suite()
    {
		return new PHPUnit_Framework_TestSuite( __CLASS__ );
    }

    protected function setUp()
    {
        $this->className = 'ezcWebdavUnlockRequest';
        $this->constructorArguments = array(
            '/foo', '/bar'
        );
        $this->defaultValues = array(
        );
        $this->workingValues = array(
        );
        $this->failingValues = array(
        );
    }

    public function testValidateHeadersSuccess()
    {
        $req = new ezcWebdavUnlockRequest( '/foo', '/bar' );
        $req->setHeader( 'Lock-Token', '<opaquelocktoken:a515cfa4-5da4-22e1-f5b5-00a0451e6bf7>' );
        $req->validateHeaders();
    }

    public function testValidateHeadersFailure()
    {
        $req = new ezcWebdavUnlockRequest( '/foo', '/bar' );
        
        try
        {
            $req->validateHeaders();
            $this->fail( 'Exception not thrown on missing Unlock-Token header.' );
        }
        catch ( ezcWebdavMissingHeaderException $e ) {}
    }
}

?>
