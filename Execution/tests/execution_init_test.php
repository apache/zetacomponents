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
 * @package Execution
 * @subpackage Tests
 */

/**
 * Including the tests
 */
require 'test_classes/test_classes.php';

/**
 * @package Execution
 * @subpackage Tests
 */
class ezcExecutionInitDefinition extends ezcTestCase
{
    public function testCallbackExists()
    {
        ezcExecution::reset();
        try
        {
            @ezcExecution::init( 'ezcExecutionDoesNotExist' );
            $this->fail( "Expected exception was not thrown" );
        }
        catch ( ezcExecutionInvalidCallbackException $e )
        {
            $this->assertEquals( "Class 'ezcExecutionDoesNotExist' does not exist.", $e->getMessage() );
        }
    }

    public function testAlreadyInitialized()
    {
        ezcExecution::reset();
        try
        {
            ezcExecution::init( 'ExecutionTest2' );
            ezcExecution::init( 'ExecutionTest2' );
            $this->fail( "Expected exception was not thrown" );
        }
        catch ( ezcExecutionAlreadyInitializedException $e )
        {
            $this->assertEquals( "The Execution mechanism is already initialized.", $e->getMessage() );
        }
    }

    public function testReset()
    {
        ezcExecution::reset();
        ezcExecution::init( 'ExecutionTest2' );
        ezcExecution::reset();
        ezcExecution::init( 'ExecutionTest2' );
    }

    public function testInvalidCallbackClass()
    {
        ezcExecution::reset();
        try
        {
            ezcExecution::init( 'ExecutionTest1' );
            $this->fail( "Expected exception was not thrown" );
        }
        catch ( ezcExecutionWrongClassException $e )
        {
            $this->assertEquals( "The class 'ExecutionTest1' does not implement the 'ezcExecutionErrorHandler' interface.", $e->getMessage() );
        }
    }

    public function testCleanExitInitialized()
    {
        ezcExecution::reset();
        ezcExecution::init( 'ExecutionTest2' );
        ezcExecution::cleanExit();
    }

    /**
     * Unfortunately this test is unable to work, because when the uncaught
     * exception would have been run, PHP aborts. So let's leave the test
     * commented out!
     *
    public function testUncaughtException()
    {
        ezcExecution::reset();
        ezcExecution::init( 'ezcExecutionBasicErrorHandler' );
        throw new Exception();
        ezcExecution::reset();
    }
     */

    /**
     * This test would leave a warning when the unit test frameworks ends. As
     * there is no other way of testing this, please leave the test commented
     * out!
     *
    public function testUncleanExit()
    {
        ezcExecution::reset();
        ezcExecution::init( 'ezcExecutionBasicErrorHandler' );
    }
     */

    public static function suite()
    {
         return new PHPUnit_Framework_TestSuite( "ezcExecutionInitDefinition" );
    }
}
?>
