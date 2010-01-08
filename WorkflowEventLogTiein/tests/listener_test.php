<?php
/**
 * @package WorkflowEventLogTiein
 * @subpackage Tests
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2010 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

require_once 'case.php';
require_once 'Workflow/tests/execution.php';

/**
 * @package WorkflowEventLogTiein
 * @subpackage Tests
 */
class ezcWorkflowEventLogTieinListenerTest extends ezcWorkflowEventLogTieinTestCase
{
    protected $execution;

    public static function suite()
    {
        return new PHPUnit_Framework_TestSuite(
          'ezcWorkflowEventLogTieinListenerTest'
        );
    }

    public function testLogStartEnd()
    {
        $this->setUpStartEnd();
        $this->dbStorage->save( $this->workflow );
        $this->execution->workflow = $this->workflow;
        $this->execution->start();

        $this->assertEquals(
          $this->readExpected( 'StartEnd' ),
          $this->readActual()
        );
    }

    public function testLogStartEndVariableHandler()
    {
        $this->setUpStartEndVariableHandler();
        $this->dbStorage->save( $this->workflow );
        $this->execution->workflow = $this->workflow;
        $this->execution->start();

        $this->assertEquals(
          $this->readExpected( 'StartEndVariableHandler' ),
          $this->readActual()
        );
    }

    public function testLogStartInputEnd()
    {
        $this->setUpStartInputEnd();
        $this->dbStorage->save( $this->workflow );
        $this->execution->workflow = $this->workflow;
        $id = $this->execution->start();
        $this->setUpExecution( $id );
        $this->execution->resume( array( 'variable' => 'value' ) );

        $this->assertEquals(
          $this->readExpected( 'StartInputEnd' ),
          $this->readActual()
        );
    }

    public function testLogStartSetUnsetEnd()
    {
        $this->setUpStartSetUnsetEnd();
        $this->dbStorage->save( $this->workflow );
        $this->execution->workflow = $this->workflow;
        $this->execution->start();

        $this->assertEquals(
          $this->readExpected( 'StartSetUnsetEnd' ),
          $this->readActual()
        );
    }

    public function testLogIncrementingLoop()
    {
        $this->setUpLoop( 'increment' );
        $this->dbStorage->save( $this->workflow );
        $this->execution->workflow = $this->workflow;
        $this->execution->start();

        $this->assertEquals(
          $this->readExpected( 'IncrementingLoop' ),
          $this->readActual()
        );
    }

    public function testLogDecrementingLoop()
    {
        $this->setUpLoop( 'decrement' );
        $this->dbStorage->save( $this->workflow );
        $this->execution->workflow = $this->workflow;
        $this->execution->start();

        $this->assertEquals(
          $this->readExpected( 'DecrementingLoop' ),
          $this->readActual()
        );
    }

    public function testLogSetAddSubMulDiv()
    {
        $this->setUpSetAddSubMulDiv();
        $this->dbStorage->save( $this->workflow );
        $this->execution->workflow = $this->workflow;
        $this->execution->start();

        $this->assertEquals(
          $this->readExpected( 'SetAddSubMulDiv' ),
          $this->readActual()
        );
    }

    public function testLogAddVariables()
    {
        $this->setUpAddVariables();
        $this->dbStorage->save( $this->workflow );
        $this->execution->workflow = $this->workflow;
        $this->execution->start();

        $this->assertEquals(
          $this->readExpected( 'AddVariables' ),
          $this->readActual()
        );
    }

    public function testLogParallelSplitSynchronization()
    {
        $this->setUpParallelSplitSynchronization();
        $this->dbStorage->save( $this->workflow );
        $this->execution->workflow = $this->workflow;
        $this->execution->start();

        $this->assertEquals(
          $this->readExpected( 'ParallelSplitSynchronization' ),
          $this->readActual()
        );
    }

    public function testLogParallelSplitSynchronization2()
    {
        $this->setUpParallelSplitSynchronization2();
        $this->dbStorage->save( $this->workflow );
        $this->execution->workflow = $this->workflow;
        $this->execution->start();
        $this->execution->resume( array( 'foo' => 'bar' ) );
        $this->execution->resume( array( 'bar' => 'foo' ) );

        $this->assertEquals(
          $this->readExpected( 'ParallelSplitSynchronization2' ),
          $this->readActual()
        );
    }

    public function testLogExclusiveChoiceSimpleMerge()
    {
        $this->setUpExclusiveChoiceSimpleMerge();
        $this->dbStorage->save( $this->workflow );
        $this->execution->workflow = $this->workflow;
        $this->execution->setVariables( array( 'condition' => true ) );
        $this->execution->start();

        $this->assertEquals(
          $this->readExpected( 'ExclusiveChoiceSimpleMerge' ),
          $this->readActual()
        );
    }

    public function testLogExclusiveChoiceSimpleMerge2()
    {
        $this->setUpExclusiveChoiceSimpleMerge();
        $this->dbStorage->save( $this->workflow );
        $this->execution->workflow = $this->workflow;
        $this->execution->setVariables( array( 'condition' => false ) );
        $this->execution->start();

        $this->assertEquals(
          $this->readExpected( 'ExclusiveChoiceSimpleMerge2' ),
          $this->readActual()
        );
    }

    public function testLogExclusiveChoiceWithUnconditionalOutNodeSimpleMerge()
    {
        $this->setUpExclusiveChoiceWithUnconditionalOutNodeSimpleMerge();
        $this->dbStorage->save( $this->workflow );
        $this->execution->workflow = $this->workflow;
        $this->execution->setVariables( array( 'condition' => false ) );
        $this->execution->start();

        $this->assertEquals(
          $this->readExpected( 'ExclusiveChoiceWithUnconditionalOutNodeSimpleMerge' ),
          $this->readActual()
        );
    }

    public function testLogExclusiveChoiceWithUnconditionalOutNodeSimpleMerge2()
    {
        $this->setUpExclusiveChoiceWithUnconditionalOutNodeSimpleMerge();
        $this->dbStorage->save( $this->workflow );
        $this->execution->workflow = $this->workflow;
        $this->execution->setVariables( array( 'condition' => true ) );
        $this->execution->start();

        $this->assertEquals(
          $this->readExpected( 'ExclusiveChoiceWithUnconditionalOutNodeSimpleMerge2' ),
          $this->readActual()
        );
    }

    public function testLogNestedExclusiveChoiceSimpleMerge()
    {
        $this->setUpNestedExclusiveChoiceSimpleMerge();
        $this->dbStorage->save( $this->workflow );
        $this->execution->workflow = $this->workflow;
        $this->execution->start();

        $this->assertEquals(
          $this->readExpected( 'NestedExclusiveChoiceSimpleMerge' ),
          $this->readActual()
        );
    }

    public function testLogNestedExclusiveChoiceSimpleMerge2()
    {
        $this->setUpNestedExclusiveChoiceSimpleMerge( true, false );
        $this->dbStorage->save( $this->workflow );
        $this->execution->workflow = $this->workflow;
        $this->execution->start();

        $this->assertEquals(
          $this->readExpected( 'NestedExclusiveChoiceSimpleMerge2' ),
          $this->readActual()
        );
    }

    public function testLogNestedExclusiveChoiceSimpleMerge3()
    {
        $this->setUpNestedExclusiveChoiceSimpleMerge( false );
        $this->dbStorage->save( $this->workflow );
        $this->execution->workflow = $this->workflow;
        $this->execution->start();

        $this->assertEquals(
          $this->readExpected( 'NestedExclusiveChoiceSimpleMerge3' ),
          $this->readActual()
        );
    }

    public function testLogMultiChoiceSynchronizingMerge()
    {
        $this->setUpMultiChoice( 'SynchronizingMerge' );
        $this->dbStorage->save( $this->workflow );
        $this->execution->workflow = $this->workflow;
        $this->execution->start();

        $this->assertEquals(
          $this->readExpected( 'MultiChoiceSynchronizingMerge' ),
          $this->readActual()
        );
    }

    public function testLogMultiChoiceDiscriminator()
    {
        $this->setUpMultiChoice( 'Discriminator' );
        $this->dbStorage->save( $this->workflow );
        $this->execution->workflow = $this->workflow;
        $this->execution->start();

        $this->assertEquals(
          $this->readExpected( 'MultiChoiceDiscriminator' ),
          $this->readActual()
        );
    }

    public function testLogNonInteractiveSubWorkflow()
    {
        $this->setUpStartEnd();
        $this->dbStorage->save( $this->workflow );
        $this->setUpWorkflowWithSubWorkflow( 'StartEnd' );
        $this->dbStorage->save( $this->workflow );
        $this->execution->workflow = $this->workflow;
        $this->execution->start();

        $this->assertEquals(
          $this->readExpected( 'NonInteractiveSubWorkflow' ),
          $this->readActual()
        );
    }

    public function testLogInteractiveSubWorkflow()
    {
        $this->setUpStartInputEnd();
        $this->dbStorage->save( $this->workflow );
        $this->setUpWorkflowWithSubWorkflow( 'StartInputEnd' );
        $this->dbStorage->save( $this->workflow );
        $this->execution->workflow = $this->workflow;
        $id = $this->execution->start();
        $this->setUpExecution( $id );
        $this->execution->resume( array( 'variable' => 'value' ) );

        $this->assertEquals(
          $this->readExpected( 'InteractiveSubWorkflow' ),
          $this->readActual()
        );
    }

    public function testLogWorkflowWithSubWorkflowAndVariablePassing()
    {
        $definition = new ezcWorkflowDefinitionStorageXml(
          dirname( dirname( dirname( __FILE__ ) ) ) . DIRECTORY_SEPARATOR . 'Workflow' . DIRECTORY_SEPARATOR . 'tests' . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR
        );

        $workflow = $definition->loadByName( 'IncrementVariable' );
        $this->dbStorage->save( $workflow );

        $this->setUpWorkflowWithSubWorkflowAndVariablePassing();
        $this->dbStorage->save( $this->workflow );
        $this->execution->workflow = $this->workflow;
        $this->execution->start();

        $this->assertEquals(
          $this->readExpected( 'WorkflowWithSubWorkflowAndVariablePassing' ),
          $this->readActual()
        );
    }

    public function testLogWorkflowWithCancelCaseSubWorkflow()
    {
        $this->setUpCancelCase( 'last' );
        $this->dbStorage->save( $this->workflow );
        $this->setUpWorkflowWithSubWorkflow( 'ParallelSplitActionActionCancelCaseSynchronization' );
        $this->dbStorage->save( $this->workflow );
        $this->execution->workflow = $this->workflow;
        $this->execution->start();

        $this->assertEquals(
          $this->readExpected( 'WorkflowWithCancelCaseSubWorkflow' ),
          $this->readActual()
        );
    }

    public function testLogNestedLoops()
    {
        $this->setUpNestedLoops();
        $this->dbStorage->save( $this->workflow );
        $this->execution->workflow = $this->workflow;
        $this->execution->start();

        $this->assertEquals(
          $this->readExpected( 'NestedLoops' ),
          $this->readActual()
        );
    }

    public function testLogParallelSplitCancelCaseActionActionSynchronization()
    {
        $this->setUpCancelCase( 'first' );
        $this->dbStorage->save( $this->workflow );
        $this->execution->workflow = $this->workflow;
        $this->execution->start();

        $this->assertEquals(
          $this->readExpected( 'ParallelSplitCancelCaseActionActionSynchronization' ),
          $this->readActual()
        );
    }

    public function testLogParallelSplitActionActionCancelCaseSynchronization()
    {
        $this->setUpCancelCase( 'last' );
        $this->dbStorage->save( $this->workflow );
        $this->execution->workflow = $this->workflow;
        $this->execution->start();

        $this->assertEquals(
          $this->readExpected( 'ParallelSplitActionActionCancelCaseSynchronization' ),
          $this->readActual()
        );
    }
}
?>
