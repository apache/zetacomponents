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
 * @package WorkflowDatabaseTiein
 * @subpackage Tests
 * @version //autogentag//
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 */

require_once 'case.php';

/**
 * @package WorkflowDatabaseTiein
 * @subpackage Tests
 */
class ezcWorkflowDatabaseTieinExecutionTest extends ezcWorkflowDatabaseTieinTestCase
{
    public static function suite()
    {
        return new PHPUnit_Framework_TestSuite(
          'ezcWorkflowDatabaseTieinExecutionTest'
        );
    }

    public function testStartInputEnd()
    {
        $this->setUpStartInputEnd();
        $this->dbStorage->save( $this->workflow );

        $execution = new ezcWorkflowDatabaseExecution( $this->db );
        $execution->workflow = $this->workflow;

        $id = $execution->start();

        $this->assertNotNull( $id );
        $this->assertFalse( $execution->hasEnded() );
        $this->assertFalse( $execution->isCancelled() );
        $this->assertFalse( $execution->isResumed() );
        $this->assertTrue( $execution->isSuspended() );

        $execution = new ezcWorkflowDatabaseExecution( $this->db, $id );

        $this->assertFalse( $execution->hasEnded() );
        $this->assertFalse( $execution->isCancelled() );
        $this->assertFalse( $execution->isResumed() );
        $this->assertTrue( $execution->isSuspended() );

        $execution->resume( array( 'variable' => 'value' ) );

        $this->assertTrue( $execution->hasEnded() );
        $this->assertFalse( $execution->isCancelled() );
        $this->assertFalse( $execution->isResumed() );
        $this->assertFalse( $execution->isSuspended() );
    }

    public function testStartInputEndReset()
    {
        $this->setUpStartInputEnd();
        $this->dbStorage->save( $this->workflow );

        $execution = new ezcWorkflowDatabaseExecution( $this->db );
        $execution->workflow = $this->workflow;

        $id = $execution->start();

        $this->assertNotNull( $id );
        $this->assertFalse( $execution->hasEnded() );
        $this->assertFalse( $execution->isCancelled() );
        $this->assertFalse( $execution->isResumed() );
        $this->assertTrue( $execution->isSuspended() );

        $execution = new ezcWorkflowDatabaseExecution( $this->db, $id );

        $this->assertFalse( $execution->hasEnded() );
        $this->assertFalse( $execution->isCancelled() );
        $this->assertFalse( $execution->isResumed() );
        $this->assertTrue( $execution->isSuspended() );

        $execution->resume( array( 'variable' => 'value' ) );

        $this->assertTrue( $execution->hasEnded() );
        $this->assertFalse( $execution->isCancelled() );
        $this->assertFalse( $execution->isResumed() );
        $this->assertFalse( $execution->isSuspended() );

        $execution = new ezcWorkflowDatabaseExecution( $this->db );
        $execution->workflow = $this->workflow;
        $execution->workflow->reset();

        $id = $execution->start();

        $this->assertNotNull( $id );
        $this->assertFalse( $execution->hasEnded() );
        $this->assertFalse( $execution->isCancelled() );
        $this->assertFalse( $execution->isResumed() );
        $this->assertTrue( $execution->isSuspended() );

        $execution = new ezcWorkflowDatabaseExecution( $this->db, $id );

        $this->assertFalse( $execution->hasEnded() );
        $this->assertFalse( $execution->isCancelled() );
        $this->assertFalse( $execution->isResumed() );
        $this->assertTrue( $execution->isSuspended() );

        $execution->resume( array( 'variable' => 'value' ) );

        $this->assertTrue( $execution->hasEnded() );
        $this->assertFalse( $execution->isCancelled() );
        $this->assertFalse( $execution->isResumed() );
        $this->assertFalse( $execution->isSuspended() );
    }

    public function testParallelSplitSynchronization()
    {
        $this->setUpParallelSplitSynchronization2();
        $this->dbStorage->save( $this->workflow );

        $execution = new ezcWorkflowDatabaseExecution( $this->db );
        $execution->workflow = $this->workflow;

        $id = $execution->start();

        $this->assertNotNull( $id );
        $this->assertFalse( $execution->hasEnded() );
        $this->assertFalse( $execution->isCancelled() );
        $this->assertFalse( $execution->isResumed() );
        $this->assertTrue( $execution->isSuspended() );

        $execution = new ezcWorkflowDatabaseExecution( $this->db, $id );

        $this->assertFalse( $execution->hasEnded() );
        $this->assertFalse( $execution->isCancelled() );
        $this->assertFalse( $execution->isResumed() );
        $this->assertTrue( $execution->isSuspended() );

        $execution->resume( array( 'foo' => 'bar' ) );

        $this->assertFalse( $execution->hasEnded() );
        $this->assertFalse( $execution->isCancelled() );
        $this->assertFalse( $execution->isResumed() );
        $this->assertTrue( $execution->isSuspended() );

        $execution = new ezcWorkflowDatabaseExecution( $this->db, $id );

        $this->assertFalse( $execution->hasEnded() );
        $this->assertFalse( $execution->isCancelled() );
        $this->assertFalse( $execution->isResumed() );
        $this->assertTrue( $execution->isSuspended() );

        $execution->resume( array( 'bar' => 'foo' ) );

        $this->assertTrue( $execution->hasEnded() );
        $this->assertFalse( $execution->isCancelled() );
        $this->assertFalse( $execution->isResumed() );
        $this->assertFalse( $execution->isSuspended() );
    }

    public function testNonInteractiveSubWorkflow()
    {
        $this->setUpStartEnd();
        $this->dbStorage->save( $this->workflow );

        $this->setUpWorkflowWithSubWorkflow( 'StartEnd' );
        $this->dbStorage->save( $this->workflow );

        $execution = new ezcWorkflowDatabaseExecution( $this->db );
        $execution->workflow = $this->workflow;

        $id = $execution->start();

        $this->assertNull( $id );
        $this->assertTrue( $execution->hasEnded() );
        $this->assertFalse( $execution->isCancelled() );
        $this->assertFalse( $execution->isResumed() );
        $this->assertFalse( $execution->isSuspended() );
    }

    public function testInteractiveSubWorkflow()
    {
        $this->setUpStartInputEnd();
        $this->dbStorage->save( $this->workflow );

        $this->setUpWorkflowWithSubWorkflow( 'StartInputEnd' );
        $this->dbStorage->save( $this->workflow );

        $execution = new ezcWorkflowDatabaseExecution( $this->db );
        $execution->workflow = $this->workflow;

        $id = $execution->start();

        $this->assertNotNull( $id );
        $this->assertFalse( $execution->hasEnded() );
        $this->assertFalse( $execution->isCancelled() );
        $this->assertFalse( $execution->isResumed() );
        $this->assertTrue( $execution->isSuspended() );

        $execution = new ezcWorkflowDatabaseExecution( $this->db, $id );

        $this->assertFalse( $execution->hasEnded() );
        $this->assertFalse( $execution->isCancelled() );
        $this->assertFalse( $execution->isResumed() );
        $this->assertTrue( $execution->isSuspended() );

        $execution->resume( array( 'variable' => 'value' ) );

        $this->assertTrue( $execution->hasEnded() );
        $this->assertFalse( $execution->isCancelled() );
        $this->assertFalse( $execution->isResumed() );
        $this->assertFalse( $execution->isSuspended() );
    }

    public function testInvalidExecutionIdThrowsException()
    {
        try
        {
            $execution = new ezcWorkflowDatabaseExecution( $this->db, '1' );
        }
        catch ( ezcWorkflowExecutionException $e )
        {
            $this->assertEquals( '$executionId must be an integer.', $e->getMessage() );
            return;
        }

        $this->fail( 'Expected an ezcWorkflowExecutionException to be thrown.' );
    }

    public function testNotExistingExecutionThrowsException()
    {
        try
        {
            $execution = new ezcWorkflowDatabaseExecution( $this->db, 1 );
        }
        catch ( ezcWorkflowExecutionException $e )
        {
            $this->assertEquals( 'Could not load execution state.', $e->getMessage() );
            return;
        }

        $this->fail( 'Expected an ezcWorkflowExecutionException to be thrown.' );
    }

    public function testProperties()
    {
        $execution = new ezcWorkflowDatabaseExecution( $this->db );

        $this->assertTrue( isset( $execution->definitionStorage ) );
        $this->assertTrue( isset( $execution->workflow ) );
        $this->assertFalse( isset( $execution->foo ) );
    }

    public function testProperties2()
    {
        $execution = new ezcWorkflowDatabaseExecution( $this->db );

        try
        {
            $execution->workflow = new StdClass;
        }
        catch ( ezcBaseValueException $e )
        {
            $this->assertEquals( 'The value \'O:8:"stdClass":0:{}\' that you were trying to assign to setting \'workflow\' is invalid. Allowed values are: ezcWorkflow.', $e->getMessage() );
            return;
        }

        $this->fail( 'Expected an ezcBaseValueException to be thrown.' );
    }

    public function testProperties3()
    {
        $execution = new ezcWorkflowDatabaseExecution( $this->db );

        try
        {
            $foo = $execution->foo;
        }
        catch ( ezcBasePropertyNotFoundException $e )
        {
            $this->assertEquals( 'No such property name \'foo\'.', $e->getMessage() );
            return;
        }

        $this->fail( 'Expected an ezcBasePropertyNotFoundException to be thrown.' );
    }

    public function testProperties4()
    {
        $this->setUpStartEnd();

        $execution = new ezcWorkflowDatabaseExecution( $this->db );

        try
        {
            $execution->foo = null;
        }
        catch ( ezcBasePropertyNotFoundException $e )
        {
            $this->assertEquals( 'No such property name \'foo\'.', $e->getMessage() );
            return;
        }

        $this->fail( 'Expected an ezcBasePropertyNotFoundException to be thrown.' );
    }

    public function testProperties5()
    {
        $execution = new ezcWorkflowDatabaseExecution( $this->db );

        try
        {
            $execution->definitionStorage = new StdClass;
        }
        catch ( ezcBaseValueException $e )
        {
            $this->assertEquals( 'The value \'O:8:"stdClass":0:{}\' that you were trying to assign to setting \'definitionStorage\' is invalid. Allowed values are: ezcWorkflowDefinitionStorage.', $e->getMessage() );
            return;
        }

        $this->fail( 'Expected an ezcBaseValueException to be thrown.' );
    }

    public function testProperties6()
    {
        $execution = new ezcWorkflowDatabaseExecution( $this->db );
        $options   = new ezcWorkflowDatabaseOptions;

        $execution->options = $options;
        $this->assertSame( $options, $execution->options );

        try
        {
            $execution->options = new StdClass;
        }
        catch ( ezcBaseValueException $e )
        {
            $this->assertEquals( 'The value \'O:8:"stdClass":0:{}\' that you were trying to assign to setting \'options\' is invalid. Allowed values are: ezcWorkflowDatabaseOptions.', $e->getMessage() );
            return;
        }

        $this->fail( 'Expected an ezcBaseValueException to be thrown.' );
    }
}
?>
