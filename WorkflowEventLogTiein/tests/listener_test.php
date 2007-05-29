<?php
/**
 * @package WorkflowEventLogTiein
 * @subpackage Tests
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

require_once 'case.php';
require_once 'Workflow/tests/execution.php';

/**
 * @package WorkflowEventLogTiein
 * @subpackage Tests
 */
class ezcWorkflowEventLogTieinListenerTest extends WorkflowEventLogTieinTestCase
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
        $this->definition->save( $this->workflow );
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
        $this->definition->save( $this->workflow );
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
        $this->definition->save( $this->workflow );
        $this->execution->workflow = $this->workflow;
        $this->execution->setInputVariable( 'variable', 'value' );
        $this->execution->start();

        $this->assertEquals(
          $this->readExpected( 'StartInputEnd' ),
          $this->readActual()
        );
    }

    public function testLogStartSetUnsetEnd()
    {
        $this->setUpStartSetUnsetEnd();
        $this->definition->save( $this->workflow );
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
        $this->definition->save( $this->workflow );
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
        $this->definition->save( $this->workflow );
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
        $this->definition->save( $this->workflow );
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
        $this->definition->save( $this->workflow );
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
        $this->definition->save( $this->workflow );
        $this->execution->workflow = $this->workflow;
        $this->execution->start();

        $this->assertEquals(
          $this->readExpected( 'ParallelSplitSynchronization' ),
          $this->readActual()
        );
    }

    public function testLogExclusiveChoiceSimpleMerge()
    {
        $this->setUpExclusiveChoiceSimpleMerge();
        $this->definition->save( $this->workflow );
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
        $this->definition->save( $this->workflow );
        $this->execution->workflow = $this->workflow;
        $this->execution->setVariables( array( 'condition' => false ) );
        $this->execution->start();

        $this->assertEquals(
          $this->readExpected( 'ExclusiveChoiceSimpleMerge2' ),
          $this->readActual()
        );
    }

    public function testLogMultiChoiceSynchronizingMerge()
    {
        $this->setUpMultiChoice( 'SynchronizingMerge' );
        $this->definition->save( $this->workflow );
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
        $this->definition->save( $this->workflow );
        $this->execution->workflow = $this->workflow;
        $this->execution->start();

        $this->assertEquals(
          $this->readExpected( 'MultiChoiceDiscriminator' ),
          $this->readActual()
        );
    }

    public function testNonInteractiveSubWorkflow()
    {
        $this->setUpStartEnd();
        $this->definition->save( $this->workflow );
        $this->setUpWorkflowWithSubWorkflow( 'StartEnd' );
        $this->definition->save( $this->workflow );
        $this->execution->workflow = $this->workflow;
        $this->execution->start();

        $this->assertEquals(
          $this->readExpected( 'NonInteractiveSubWorkflow' ),
          $this->readActual()
        );
    }

    public function testInteractiveSubWorkflow()
    {
        $this->setUpStartInputEnd();
        $this->definition->save( $this->workflow );
        $this->setUpWorkflowWithSubWorkflow( 'StartInputEnd' );
        $this->definition->save( $this->workflow );
        $this->execution->workflow = $this->workflow;
        $this->execution->setInputVariableForSubWorkflow( 'variable', 'value' );
        $this->execution->start();

        $this->assertEquals(
          $this->readExpected( 'InteractiveSubWorkflow' ),
          $this->readActual()
        );
    }
}
?>
