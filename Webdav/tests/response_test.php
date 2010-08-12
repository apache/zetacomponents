<?php
/**
 * Basic test cases for the response class.
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
 * Tests for ezcWebdavBasicPathFactory class.
 * 
 * @package Webdav
 * @subpackage Tests
 */
class ezcWebdavResponseTest extends ezcWebdavRequestTestCase
{
    public static function suite()
    {
		return new PHPUnit_Framework_TestSuite( __CLASS__ );
    }

    protected function setUp()
    {
        $this->className = 'ezcWebdavMultistatusResponse';
        $this->defaultValues = array(
            'responseDescription' => null,
        );
        $this->workingValues = array(
            'responseDescription' => array(
                'This is nice response!',
            ),
        );
        $this->failingValues = array(
            'responseDescription' => array( 
                42,
                true,
            ),
        );
    }

    public function testMultistatusResponseSingle()
    {
        $response = new ezcWebdavMultistatusResponse(
            $error = new ezcWebdavErrorResponse( ezcWebdavResponse::STATUS_404 )
        );

        $this->assertEquals(
            $response->responses,
            array( $error ),
            'Expected array with one response.'
        );
    }

    public function testMultistatusResponseMultiple()
    {
        $response = new ezcWebdavMultistatusResponse(
            $error1 = new ezcWebdavErrorResponse( ezcWebdavResponse::STATUS_404 ),
            $error2 = new ezcWebdavErrorResponse( ezcWebdavResponse::STATUS_409 )
        );

        $this->assertEquals(
            $response->responses,
            array( $error1, $error2 ),
            'Expected array with one response.'
        );
    }

    public function testMultistatusResponseMultipleFlatten()
    {
        $response = new ezcWebdavMultistatusResponse(
            $error1 = new ezcWebdavErrorResponse( ezcWebdavResponse::STATUS_404 ),
            array(
                $error2 = new ezcWebdavErrorResponse( ezcWebdavResponse::STATUS_409 ),
            )
        );

        $this->assertEquals(
            $response->responses,
            array( $error1, $error2 ),
            'Expected array with one response.'
        );
    }

    public function testMultistatusResponseMultipleOnlyFlatten()
    {
        $response = new ezcWebdavMultistatusResponse(
            array(
                $error1 = new ezcWebdavErrorResponse( ezcWebdavResponse::STATUS_404 ),
                $error2 = new ezcWebdavErrorResponse( ezcWebdavResponse::STATUS_409 ),
            )
        );

        $this->assertEquals(
            $response->responses,
            array( $error1, $error2 ),
            'Expected array with one response.'
        );
    }
}

?>
