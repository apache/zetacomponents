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

/**
 * Test the handler classes.
 *
 * @package MvcTools
 * @subpackage Tests
 */
class ezcMvcToolsRecodeResponseFilterTest extends ezcTestCase
{
    public function setUp()
    {
        if ( !extension_loaded( 'xdebug' ) )
        {
            self::markTestSkipped( "Xdebug is required." );
        }
    }

    public function testFilterDefaultConversion()
    {
        $response = new ezcMvcResponse;
        $response->body = 'Ze Body';
        $filter = new ezcMvcRecodeResponseFilter();
        $filter->filterResponse( $response );

        self::assertSame( 'Ze Body', $response->body );
    }

    public function testFilterUtf8ToLatin()
    {
        $response = new ezcMvcResponse;
        $response->body = 'blåbærøl';
        $filter = new ezcMvcRecodeResponseFilter;
        $filter->setOptions( array( 'toEncoding' => 'latin1' ) );
        $filter->filterResponse( $response );

        self::assertSame( 'bl' . chr( 0xE5 ) . 'b' . chr( 0xE6 ) . 'r' . chr( 0xF8 ) . 'l', $response->body );
    }

    public function testFilterLatinToUtf8()
    {
        $response = new ezcMvcResponse;
        $response->body = 'bl' . chr( 0xE5 ) . 'b' . chr( 0xE6 ) . 'r' . chr( 0xF8 ) . 'l';
        $filter = new ezcMvcRecodeResponseFilter;
        $filter->setOptions( array( 'fromEncoding' => 'latin1' ) );
        $filter->filterResponse( $response );

        self::assertSame( 'blåbærøl', $response->body );
    }

    public function testWithBrokenInput()
    {
        $response = new ezcMvcResponse;
        $response->body = 'bl' . chr( 0xE5 ) . 'b' . chr( 0xE6 ) . 'r' . chr( 0xF8 ) . 'l';
        $filter = new ezcMvcRecodeResponseFilter;
        $filter->setOptions( array( 'toEncoding' => 'latin1' ) );
        try
        {
            $filter->filterResponse( $response );
            self::fail( "Expected exception not thrown." );
        }
        catch ( ezcMvcInvalidEncodingException $e )
        {
            self::assertSame( "The string '{$response->body}' is invalid in character set 'utf-8'.", $e->getMessage() );
        }
    }

    public static function suite()
    {
         return new PHPUnit_Framework_TestSuite( __CLASS__ );
    }
}
?>
