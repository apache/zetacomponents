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
 * @package Debug
 * @subpackage Tests
 */

/**
 * Test suite for the ezcDebugOptions class.
 *
 * @package Debug
 * @subpackage Tests
 */
class ezcDebugOptionsTest extends ezcTestCase
{
    public static function suite()
    {
        return new PHPUnit_Framework_TestSuite( __CLASS__ );
    }

    public function testCtor()
    {
        $opts = new ezcDebugOptions();

        $this->assertSame(
            false,
            $opts->stackTrace,
            'Default value for option $stackTrace incorrect.'
        );
        $this->assertSame(
            5,
            $opts->stackTraceDepth,
            'Default value for option $stackTraceDepth incorrect.'
        );
    }

    public function testSetSuccess()
    {
        $opts = new ezcDebugOptions();

        $opts->stackTrace      = true;
        $opts->stackTraceDepth = 100;

        $this->assertSetProperty(
            $opts,
            'stackTrace',
            array( true, false )
        );
        $this->assertSetProperty(
            $opts,
            'stackTraceDepth',
            array( 0, 1, 23 )
        );
        $this->assertSetProperty(
            $opts,
            'stackTraceMaxData',
            array( 0, 1, 23, false )
        );
        $this->assertSetProperty(
            $opts,
            'stackTraceMaxChildren',
            array( 0, 1, 23, false )
        );
        $this->assertSetProperty(
            $opts,
            'stackTraceMaxDepth',
            array( 0, 1, 23, false )
        );
    }

    public function testSetFailure()
    {
        $opts = new ezcDebugOptions();

        $this->assertSetPropertyFails(
            $opts,
            'stackTrace',
            array( null, 23, 'foobar', array(), new stdClass() )
        );
        $this->assertSetPropertyFails(
            $opts,
            'stackTraceDepth',
            array( null, true, -23, 'foobar', array(), new stdClass() )
        );
        $this->assertSetPropertyFails(
            $opts,
            'stackTraceMaxData',
            array( null, true, -23, 'foobar', array(), new stdClass() )
        );
        $this->assertSetPropertyFails(
            $opts,
            'stackTraceMaxChildren',
            array( null, true, -23, 'foobar', array(), new stdClass() )
        );
        $this->assertSetPropertyFails(
            $opts,
            'stackTraceMaxDepth',
            array( null, true, -23, 'foobar', array(), new stdClass() )
        );
    }
}
?>
