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
require_once 'MvcTools/tests/testfiles/controller.php';

/**
 * Test the handler classes.
 *
 * @package MvcTools
 * @subpackage Tests
 */
class ezcMvcToolsControllerTest extends ezcTestCase
{
    public function testEmptyAction()
    {
        try
        {
            $f = new testControllerController( null, new ezcMvcRequest() );
            self::fail( 'Expected exception not thrown.' );
        }
        catch ( ezcMvcControllerException $e )
        {
            self::assertEquals( "The 'testControllerController' controller requires an action.", $e->getMessage() );
        }
    }

    public function testSetAction()
    {
        $f = new testControllerController( 'testAction', new ezcMvcRequest() );
        self::assertEquals( "testAction", $this->readAttribute( $f, 'action' ) );
    }

    public function testGetNonExistingVariables()
    {
        $r = new ezcMvcRequest;
        $r->variables = array( 'var1' => 42, 'var42' => 'bansai!' );
        $f = new testControllerController( 'testAction', $r );

        try
        {
            $foo = $f->new;
            self::fail( 'Expected exception not thrown.' );
        }
        catch ( ezcBasePropertyNotFoundException $e )
        {
            self::assertEquals( "No such property name 'new'.", $e->getMessage() );
        }
    }

    public function testSetVariables()
    {
        $r = new ezcMvcRequest;
        $r->variables = array( 'var1' => 42, 'var42' => 'bansai!' );
        $f = new testControllerController( 'testAction', $r );

        self::assertEquals( 42, $f->var1 );
        self::assertEquals( 'bansai!', $f->var42 );
    }

    public function testSetProperties()
    {
        $r = new ezcMvcRequest;
        $r->variables = array( 'var1' => 42, 'var42' => 'bansai!' );
        $f = new testControllerController( 'testAction', $r );

        try
        {
            $f->new = 'fail!';
            self::fail( 'Expected exception not thrown.' );
        }
        catch ( ezcBasePropertyPermissionException $e )
        {
            self::assertEquals( "The property 'new' is read-only.", $e->getMessage() );
        }

        try
        {
            $f->var = 'modified';
            self::fail( 'Expected exception not thrown.' );
        }
        catch ( ezcBasePropertyPermissionException $e )
        {
            self::assertEquals( "The property 'var' is read-only.", $e->getMessage() );
        }
    }

    public function testIssetProperties()
    {
        $r = new ezcMvcRequest;
        $r->variables = array( 'var1' => 42, 'var42' => 'bansai!' );
        $f = new testControllerController( 'testAction', $r );

        self::assertEquals( false, isset( $f->notSet ) );
        self::assertEquals( true, isset( $f->var1 ) );
    }

    public function testRoutingInformation()
    {
        $r = new ezcMvcRequest;
        $r->variables = array( 'var1' => 42, 'var42' => 'bansai!' );
        $f = new testControllerController( 'testAction', $r );
        $f->setRouter( new testSimpleRouter( $r ) );

        self::assertEquals( new testSimpleRouter( $r ), $f->getRouter() );
    }

    public function testCreateActionMethod()
    {
        $f = new testControllerController( 'test', new ezcMvcRequest() );
        self::assertEquals( 'doTest', $f->testCreateActionMethod() );

        $f = new testControllerController( 'test_action', new ezcMvcRequest() );
        self::assertEquals( 'doTestAction', $f->testCreateActionMethod() );

        $f = new testControllerController( 'testAction', new ezcMvcRequest() );
        self::assertEquals( 'doTestAction', $f->testCreateActionMethod() );

        $f = new testControllerController( 'test_with_more_than_OneWord', new ezcMvcRequest() );
        self::assertEquals( 'doTestWithMoreThanOneWord', $f->testCreateActionMethod() );
    }

    public static function suite()
    {
         return new PHPUnit_Framework_TestSuite( "ezcMvcToolsControllerTest" );
    }
}
?>
