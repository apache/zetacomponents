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
 * @package Feed
 * @subpackage Tests
 */

include_once( 'UnitTest/src/regression_suite.php' );
include_once( 'UnitTest/src/regression_test.php' );
include_once( 'Feed/tests/regression_test.php' );

/**
 * @package Feed
 * @subpackage Tests
 */
class ezcFeedAtomRegressionGenerateTest extends ezcFeedRegressionTest
{
    public function __construct()
    {
        $basePath = dirname( __FILE__ ) . DIRECTORY_SEPARATOR . 'regression'
                                        . DIRECTORY_SEPARATOR . 'generate';

        $this->readDirRecursively( $basePath, $this->files, 'in' );

        parent::__construct();
    }

    public static function suite()
    {
        return new ezcTestRegressionSuite( __CLASS__ );
    }

    protected function cleanForCompare( $text )
    {
        $text = preg_replace( '@<updated>.*?</updated>@', '<updated>XXX</updated>', $text );
        $text = preg_replace( '@<published>.*?</published>@', '<published>XXX</published>', $text );
        $text = preg_replace( '@<generator.*?>.*?</generator>@', '<generator>XXX</generator>', $text );

        $text = preg_replace( '@<dc:date.*?>.*?</dc:date>@', '<dc:date>XXX</dc:date>', $text );
        return $text;
    }

    public function testRunRegression( $file )
    {
        $errors = array();

        $outFile = $this->outFileName( $file, '.in', '.out' );
        $expected = trim( file_get_contents( $outFile ) );
        $data = include_once( $file );
        $feed = $this->createFeed( 'atom', $data );
        try
        {
            $generated = $feed->generate();
            $generated = trim( $this->cleanForCompare( $generated ) );
            $expected = $this->cleanForCompare( $expected );

        }
        catch ( ezcFeedException $e )
        {
            $generated = $e->getMessage();
        }

        $this->assertEquals( $expected, $generated, "The " . basename( $outFile ) . " is not the same as the generated feed from " . basename( $file ) . "." );
    }
}
?>
