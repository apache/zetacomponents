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
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 * @version //autogentag//
 * @filesource
 * @package MvcMailTiein
 * @subpackage Tests
 */
#require_once 'MvcMailTiein/tests/testfiles/testclasses.php';
require_once 'UnitTest/src/regression_test.php';
require_once 'UnitTest/src/regression_suite.php';

/**
 * Test the handler classes.
 *
 * @package MvcMailTiein
 * @subpackage Tests
 */
class ezcMvcMailTieinMailRequestParserTest extends ezcTestRegressionTest
{
    public function __construct()
    {
        $basePath = dirname( __FILE__ ) . '/../testfiles/mail_request_parser';

        $this->readDirRecursively( $basePath, $this->files, 'data' );

        parent::__construct();
    }

    public function testRunRegression( $name )
    {
        $expectedFileName = $name . '.exp';
        if ( !file_exists( $expectedFileName ) )
        {
            self::fail( 'Missing expected data file.' );
        }
        $expected = file_get_contents( $expectedFileName );
        $expected = str_replace( 'PID', getmypid(), $expected );

        $data = file_get_contents( $name );
        $requestParser = new ezcMvcMailRequestParser();

        if ( preg_match( '@\.fail\.@', $name ) )
        {
            try
            {
                $req = $requestParser->createRequest( $data );
            }
            catch ( ezcMvcMailTieinException $e )
            {
                $req = $e->getMessage();
            }
        }
        else
        {
            $req = $requestParser->createRequest( $data );
        }
        self::assertEquals( $expected, var_export( $req, true ) );
    }

    public static function suite()
    {
        return new ezcTestRegressionSuite( __CLASS__ );
    }
}
?>
