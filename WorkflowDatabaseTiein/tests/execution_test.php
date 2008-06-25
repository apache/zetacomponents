<?php
/**
 * @package WorkflowDatabaseTiein
 * @subpackage Tests
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
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
        $this->definition->save( $this->workflow );

        $execution = new ezcWorkflowDatabaseExecution( $this->db );
        $execution->workflow = $this->workflow;

        $id = $execution->start();
        $this->assertNotNull( $id );
        $this->assertFalse( $execution->hasEnded() );
        $this->assertFalse( $execution->isResumed() );
        $this->assertTrue( $execution->isSuspended() );

        $execution = new ezcWorkflowDatabaseExecution( $this->db, $id );
        $execution->resume( array( 'variable' => 'value' ) );
        $this->assertTrue( $execution->hasEnded() );
        $this->assertFalse( $execution->isResumed() );
        $this->assertFalse( $execution->isSuspended() );
    }

    public function testStartInputEndClone()
    {
        $this->setUpStartInputEnd();
        $this->definition->save( $this->workflow );

        $execution = new ezcWorkflowDatabaseExecution( $this->db );
        $execution->workflow = $this->workflow;

        $id = $execution->start();
        $this->assertNotNull( $id );
        $this->assertFalse( $execution->hasEnded() );
        $this->assertFalse( $execution->isResumed() );
        $this->assertTrue( $execution->isSuspended() );

        $execution = new ezcWorkflowDatabaseExecution( $this->db, $id );
        $execution->resume( array( 'variable' => 'value' ) );
        $this->assertTrue( $execution->hasEnded() );
        $this->assertFalse( $execution->isResumed() );
        $this->assertFalse( $execution->isSuspended() );

        $execution = new ezcWorkflowDatabaseExecution( $this->db );
        $execution->workflow = clone $this->workflow;

        $id = $execution->start();
        $this->assertNotNull( $id );
        $this->assertFalse( $execution->hasEnded() );
        $this->assertFalse( $execution->isResumed() );
        $this->assertTrue( $execution->isSuspended() );

        $execution = new ezcWorkflowDatabaseExecution( $this->db, $id );
        $execution->resume( array( 'variable' => 'value' ) );
        $this->assertTrue( $execution->hasEnded() );
        $this->assertFalse( $execution->isResumed() );
        $this->assertFalse( $execution->isSuspended() );
    }

    public function testParallelSplitSynchronization()
    {
        $this->setUpParallelSplitSynchronization2();
        $this->definition->save( $this->workflow );

        $execution = new ezcWorkflowDatabaseExecution( $this->db );
        $execution->workflow = $this->workflow;

        $id = $execution->start();
        $this->assertNotNull( $id );
        $this->assertFalse( $execution->hasEnded() );
        $this->assertFalse( $execution->isResumed() );
        $this->assertTrue( $execution->isSuspended() );

        $execution = new ezcWorkflowDatabaseExecution( $this->db, $id );
        $execution->resume( array( 'foo' => 'bar' ) );
        $this->assertFalse( $execution->hasEnded() );
        $this->assertFalse( $execution->isResumed() );
        $this->assertTrue( $execution->isSuspended() );

        $execution = new ezcWorkflowDatabaseExecution( $this->db, $id );
        $execution->resume( array( 'bar' => 'foo' ) );
        $this->assertTrue( $execution->hasEnded() );
        $this->assertFalse( $execution->isResumed() );
        $this->assertFalse( $execution->isSuspended() );
    }

    public function testNonInteractiveSubWorkflow()
    {
        $this->setUpStartEnd();
        $this->definition->save( $this->workflow );

        $this->setUpWorkflowWithSubWorkflow( 'StartEnd' );
        $this->definition->save( $this->workflow );

        $execution = new ezcWorkflowDatabaseExecution( $this->db );
        $execution->workflow = $this->workflow;

        $id = $execution->start();
        $this->assertNull( $id );
        $this->assertTrue( $execution->hasEnded() );
        $this->assertFalse( $execution->isResumed() );
        $this->assertFalse( $execution->isSuspended() );
    }

    public function testInteractiveSubWorkflow()
    {
        $this->setUpStartInputEnd();
        $this->definition->save( $this->workflow );

        $this->setUpWorkflowWithSubWorkflow( 'StartInputEnd' );
        $this->definition->save( $this->workflow );

        $execution = new ezcWorkflowDatabaseExecution( $this->db );
        $execution->workflow = $this->workflow;

        $id = $execution->start();
        $this->assertNotNull( $id );
        $this->assertFalse( $execution->hasEnded() );
        $this->assertFalse( $execution->isResumed() );
        $this->assertTrue( $execution->isSuspended() );

        $execution = new ezcWorkflowDatabaseExecution( $this->db, $id );
        $execution->resume( array( 'variable' => 'value' ) );
        $this->assertTrue( $execution->hasEnded() );
        $this->assertFalse( $execution->isResumed() );
        $this->assertFalse( $execution->isSuspended() );
    }

    public function testNotExistingExecutionThrowsException()
    {
        try
        {
            $execution = new ezcWorkflowDatabaseExecution( $this->db, 1 );
        }
        catch ( ezcWorkflowExecutionException $e )
        {
            return;
        }

        $this->fail();
    }
}
?>
