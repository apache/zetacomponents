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
 * @package MvcTools
 * @subpackage Tests
 */

/**
 * Test the handler classes.
 *
 * @package MvcTools
 * @subpackage Tests
 */
class ezcMvcToolsBugzillaRequestFilterTest extends ezcTestCase
{
    public function testFilter()
    {
        $request = new ezcMvcRequest;
        $request->variables['subject'] = 'The short description';
        $request->body = <<<ENDBODY
@product      = Bugzilla
@component    = general
@version      = All
@groupset     = ReadWorld ReadPartners
@op_sys       = Linux
@priority     = P3
@rep_platform = i386

This is the description of the bug I found. It is not necessary to start
it with a keyword.

Note: The short_description is necessary and may be given with the keyword
@short_description or will be retrieved from the mail subject.
ENDBODY;
        $filter = new ezcMvcMailBugzillaRequestFilter();
        $filter->filterRequest( $request );

        self::assertSame( $request->variables['short_desc'], "The short description" );
        self::assertSame( $request->variables['description'], "This is the description of the bug I found. It is not necessary to start it with a keyword. Note: The short_description is necessary and may be given with the keyword @short_description or will be retrieved from the mail subject." );
        self::assertSame( $request->variables['product'], "Bugzilla" );
        self::assertSame( $request->variables['rep_platform'], "i386" );
    }

    public function testFilterWithOverriddenShortDesc()
    {
        $request = new ezcMvcRequest;
        $request->variables['subject'] = 'The short description';
        $request->body = <<<ENDBODY
@short_desc = The overridden
short description
@product    = eZ Components
ENDBODY;
        $filter = new ezcMvcMailBugzillaRequestFilter();
        $filter->filterRequest( $request );

        self::assertSame( $request->variables['product'], "eZ Components" );
        self::assertSame( $request->variables['short_desc'], "The overridden short description" );
    }

    public static function suite()
    {
         return new PHPUnit_Framework_TestSuite( __CLASS__ );
    }
}
?>
