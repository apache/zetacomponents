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
 * @copyright Copyright (C) 2005-2010 eZ Systems AS. All rights reserved.
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 * @version //autogentag//
 * @filesource
 * @package MvcTools
 * @subpackage Tests
 */
require_once 'MvcTools/tests/testfiles/testclasses.php';
require_once 'UnitTest/src/regression_test.php';
require_once 'UnitTest/src/regression_suite.php';

/**
 * Test the handler classes.
 *
 * @package MvcTools
 * @subpackage Tests
 */
class ezcMvcToolsHttpRequestParserTest extends ezcTestRegressionTest
{
    public function __construct()
    {
        $basePath = dirname( __FILE__ ) . '/../testfiles/http_request_parser';

        $this->readDirRecursively( $basePath, $this->files, 'data' );

        parent::__construct();
    }

    public function setUp()
    {
        $this->serverArray = $_SERVER;
        $this->filesArray  = $_FILES;
        $this->requestArray  = $_REQUEST;
        $this->cookieArray  = $_COOKIE;
    }

    public function tearDown()
    {
        $_SERVER = $this->serverArray;
        $_FILES  = $this->filesArray;
        $_REQUEST = $this->requestArray;
        $_COOKIE = $this->cookieArray;
    }

    public function testRunRegression( $name )
    {
        include $name;
        $_SERVER = $server;
        $_FILES  = $files;
        $_REQUEST = $request;
        $_COOKIE = $cookies;
        $requestParser = new ezcMvcHttpRequestParser();
        $req = $requestParser->createRequest();

        $expectedFileName = $name . '.exp';
        if ( !file_exists( $expectedFileName ) )
        {
            self::fail( 'Missing expected data file.' );
            file_put_contents( $expectedFileName, var_export( $req, true ) );
        }
        else
        {
            $expected = file_get_contents( $expectedFileName );
            self::assertEquals( $expected, var_export( $req, true ) );
        }
    }

    public static function suite()
    {
        return new ezcTestRegressionSuite( __CLASS__ );
    }
}
?>
