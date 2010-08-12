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

/**
 * @package Feed
 * @subpackage Tests
 */
class ezcFeedAtomRegressionParseTest extends ezcTestRegressionTest
{
    public function __construct()
    {
        $basePath = dirname( __FILE__ ) . DIRECTORY_SEPARATOR . 'regression'
                                        . DIRECTORY_SEPARATOR . 'parse';

        $this->readDirRecursively( $basePath, $this->files, 'in' );

        parent::__construct();
    }

    public static function suite()
    {
        return new ezcTestRegressionSuite( __CLASS__ );
    }

    protected function cleanForCompare( $expected, $parsed )
    {
        $referenceDate = new DateTime();

        if ( isset( $parsed->updated ) )
        {
            if ( $parsed->updated instanceof ezcFeedDateElement
                 && $parsed->updated->date instanceof DateTime )
            {
                $parsed->updated->date = $referenceDate;
                $expected->updated->date = $referenceDate;
            }
        }

        if ( isset( $parsed->DublinCore )
             && isset( $parsed->DublinCore->date )
             && is_array( $parsed->DublinCore->date ) )
        {
            foreach ( $parsed->DublinCore->date as $date )
            {
                $date->date = $referenceDate;
            }
        }

        if ( isset( $expected->DublinCore )
             && isset( $expected->DublinCore->date )
             && is_array( $expected->DublinCore->date ) )
        {
            foreach ( $expected->DublinCore->date as $date )
            {
                $date->date = $referenceDate;
            }
        }

        $this->cleanDate( $parsed, 'updated', $referenceDate );
        $this->cleanDate( $parsed, 'published', $referenceDate );
        $this->cleanDate( $expected, 'updated', $referenceDate );
        $this->cleanDate( $expected, 'published', $referenceDate );
    }

    protected function cleanDate( $feed, $element, $newDate )
    {
        if ( isset( $feed->item ) )
        {
            foreach ( $feed->item as $item )
            {
                if ( isset( $item->$element ) )
                {
                    $item->$element->date = $newDate;
                }
            }

            foreach ( $feed->item as $item )
            {
                if ( isset( $item->$element ) )
                {
                    $item->$element->date = $newDate;
                }

                if ( isset( $item->source ) )
                {
                    if ( is_array( $item->source ) )
                    {
                        $source = $item->source[0];
                    }
                    else
                    {
                        $source = $item->source;
                    }

                    if ( isset( $source->$element ) )
                    {
                        $source->$element->date = $newDate;
                    }
                }

                if ( isset( $item->DublinCore )
                     && isset( $item->DublinCore->date )
                     && is_array( $item->DublinCore->date ) )
                {
                    foreach ( $item->DublinCore->date as $date )
                    {
                        $date->date = $newDate;
                    }
                }
            }
        }
    }

    public function testRunRegression( $file )
    {
        $errors = array();

        $outFile = $this->outFileName( $file, '.in', '.out' );

        try
        {
            $parsed = ezcFeed::parseContent( file_get_contents( $file ) );
            $expected = include_once( $outFile );
            $this->cleanForCompare( $expected, $parsed );
        }
        catch ( ezcFeedException $e )
        {
            $parsed = $e->getMessage();
            $expected = trim( file_get_contents( $outFile ) );
        }
        $this->assertEquals( var_export( $expected, true ), var_export( $parsed, true ), "The " . basename( $outFile ) . " is not the same as the parsed feed from " . basename( $file ) . "." );
    }
}
?>
