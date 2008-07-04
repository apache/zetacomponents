<?php
/**
 * @package WorkflowSignalSlotTiein
 * @subpackage Tests
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

require_once 'Workflow/tests/case.php';
require_once 'Workflow/tests/execution.php';
require_once 'receiver.php';

/**
 * @package WorkflowSignalSlotTiein
 * @subpackage Tests
 */
class ezcWorkflowSignalSlotTieinPluginTest extends ezcWorkflowTestCase
{
    protected $execution;
    protected $signals;
    protected $receiver;

    public static function suite()
    {
        return new PHPUnit_Framework_TestSuite(
          'ezcWorkflowSignalSlotTieinPluginTest'
        );
    }

    protected function setUp()
    {
        parent::setUp();

        $this->execution = new ezcWorkflowTestExecution;

        $this->plugin = new ezcWorkflowSignalSlotPlugin;
        $this->execution->addPlugin( $this->plugin );

        $this->receiver = new ezcWorkflowSignalSlotTestReceiver;
        $this->signals = $this->plugin->signals;

        $this->signals->connect( 'afterExecutionStarted', array( $this->receiver, 'afterExecutionStarted' ) );
        $this->signals->connect( 'afterExecutionSuspended', array( $this->receiver, 'afterExecutionSuspended' ) );
        $this->signals->connect( 'afterExecutionResumed', array( $this->receiver, 'afterExecutionResumed' ) );
        $this->signals->connect( 'afterExecutionCancelled', array( $this->receiver, 'afterExecutionCancelled' ) );
        $this->signals->connect( 'afterExecutionEnded', array( $this->receiver, 'afterExecutionEnded' ) );
        $this->signals->connect( 'beforeNodeActivated', array( $this->receiver, 'beforeNodeActivated' ) );
        $this->signals->connect( 'afterNodeActivated', array( $this->receiver, 'afterNodeActivated' ) );
        $this->signals->connect( 'afterNodeExecuted', array( $this->receiver, 'afterNodeExecuted' ) );
        $this->signals->connect( 'afterThreadStarted', array( $this->receiver, 'afterThreadStarted' ) );
        $this->signals->connect( 'afterThreadEnded', array( $this->receiver, 'afterThreadEnded' ) );
        $this->signals->connect( 'beforeVariableSet', array( $this->receiver, 'beforeVariableSet' ) );
        $this->signals->connect( 'afterVariableSet', array( $this->receiver, 'afterVariableSet' ) );
        $this->signals->connect( 'beforeVariableUnset', array( $this->receiver, 'beforeVariableUnset' ) );
        $this->signals->connect( 'afterVariableUnset', array( $this->receiver, 'afterVariableUnset' ) );
    }

    public function testSignalsForStartEnd()
    {
        $this->setUpStartEnd();
        $this->execution->workflow = $this->workflow;
        $this->execution->start();

        $this->assertEquals( 1, $this->receiver->stack['afterExecutionStarted'] );
        $this->assertEquals( 0, $this->receiver->stack['afterExecutionSuspended'] );
        $this->assertEquals( 0, $this->receiver->stack['afterExecutionResumed'] );
        $this->assertEquals( 0, $this->receiver->stack['afterExecutionCancelled'] );
        $this->assertEquals( 1, $this->receiver->stack['afterExecutionEnded'] );
        $this->assertEquals( 2, $this->receiver->stack['beforeNodeActivated'] );
        $this->assertEquals( 2, $this->receiver->stack['afterNodeActivated'] );
        $this->assertEquals( 2, $this->receiver->stack['afterNodeExecuted'] );
        $this->assertEquals( 1, $this->receiver->stack['afterThreadStarted'] );
        $this->assertEquals( 1, $this->receiver->stack['afterThreadEnded'] );
        $this->assertEquals( 0, $this->receiver->stack['beforeVariableSet'] );
        $this->assertEquals( 0, $this->receiver->stack['afterVariableSet'] );
        $this->assertEquals( 0, $this->receiver->stack['beforeVariableUnset'] );
        $this->assertEquals( 0, $this->receiver->stack['afterVariableUnset'] );
    }

    public function testSignalsForStartEndVariableHandler()
    {
        $this->setUpStartEndVariableHandler();
        $this->execution->workflow = $this->workflow;
        $this->execution->start();

        $this->assertEquals( 1, $this->receiver->stack['afterExecutionStarted'] );
        $this->assertEquals( 0, $this->receiver->stack['afterExecutionSuspended'] );
        $this->assertEquals( 0, $this->receiver->stack['afterExecutionResumed'] );
        $this->assertEquals( 0, $this->receiver->stack['afterExecutionCancelled'] );
        $this->assertEquals( 1, $this->receiver->stack['afterExecutionEnded'] );
        $this->assertEquals( 2, $this->receiver->stack['beforeNodeActivated'] );
        $this->assertEquals( 2, $this->receiver->stack['afterNodeActivated'] );
        $this->assertEquals( 2, $this->receiver->stack['afterNodeExecuted'] );
        $this->assertEquals( 1, $this->receiver->stack['afterThreadStarted'] );
        $this->assertEquals( 1, $this->receiver->stack['afterThreadEnded'] );
        $this->assertEquals( 1, $this->receiver->stack['beforeVariableSet'] );
        $this->assertEquals( 1, $this->receiver->stack['afterVariableSet'] );
        $this->assertEquals( 0, $this->receiver->stack['beforeVariableUnset'] );
        $this->assertEquals( 0, $this->receiver->stack['afterVariableUnset'] );
    }

    public function testSignalsForStartInputEnd()
    {
        $this->setUpStartInputEnd();
        $this->execution->workflow = $this->workflow;
        $this->execution->setInputVariable( 'variable', 'value' );
        $this->execution->start();

        $this->assertEquals( 1, $this->receiver->stack['afterExecutionStarted'] );
        $this->assertEquals( 1, $this->receiver->stack['afterExecutionSuspended'] );
        $this->assertEquals( 1, $this->receiver->stack['afterExecutionResumed'] );
        $this->assertEquals( 0, $this->receiver->stack['afterExecutionCancelled'] );
        $this->assertEquals( 1, $this->receiver->stack['afterExecutionEnded'] );
        $this->assertEquals( 3, $this->receiver->stack['beforeNodeActivated'] );
        $this->assertEquals( 3, $this->receiver->stack['afterNodeActivated'] );
        $this->assertEquals( 3, $this->receiver->stack['afterNodeExecuted'] );
        $this->assertEquals( 1, $this->receiver->stack['afterThreadStarted'] );
        $this->assertEquals( 1, $this->receiver->stack['afterThreadEnded'] );
        $this->assertEquals( 3, $this->receiver->stack['beforeVariableSet'] );
        $this->assertEquals( 3, $this->receiver->stack['afterVariableSet'] );
        $this->assertEquals( 0, $this->receiver->stack['beforeVariableUnset'] );
        $this->assertEquals( 0, $this->receiver->stack['afterVariableUnset'] );
    }

    public function testSignalsForStartSetUnsetEnd()
    {
        $this->setUpStartSetUnsetEnd();
        $this->execution->workflow = $this->workflow;
        $this->execution->start();

        $this->assertEquals( 1, $this->receiver->stack['afterExecutionStarted'] );
        $this->assertEquals( 0, $this->receiver->stack['afterExecutionSuspended'] );
        $this->assertEquals( 0, $this->receiver->stack['afterExecutionResumed'] );
        $this->assertEquals( 0, $this->receiver->stack['afterExecutionCancelled'] );
        $this->assertEquals( 1, $this->receiver->stack['afterExecutionEnded'] );
        $this->assertEquals( 4, $this->receiver->stack['beforeNodeActivated'] );
        $this->assertEquals( 4, $this->receiver->stack['afterNodeActivated'] );
        $this->assertEquals( 4, $this->receiver->stack['afterNodeExecuted'] );
        $this->assertEquals( 1, $this->receiver->stack['afterThreadStarted'] );
        $this->assertEquals( 1, $this->receiver->stack['afterThreadEnded'] );
        $this->assertEquals( 1, $this->receiver->stack['beforeVariableSet'] );
        $this->assertEquals( 1, $this->receiver->stack['afterVariableSet'] );
        $this->assertEquals( 1, $this->receiver->stack['beforeVariableUnset'] );
        $this->assertEquals( 1, $this->receiver->stack['afterVariableUnset'] );
    }

    public function testSignalsForIncrementingLoop()
    {
        $this->setUpLoop( 'increment' );
        $this->execution->workflow = $this->workflow;
        $this->execution->start();

        $this->assertEquals( 1, $this->receiver->stack['afterExecutionStarted'] );
        $this->assertEquals( 0, $this->receiver->stack['afterExecutionSuspended'] );
        $this->assertEquals( 0, $this->receiver->stack['afterExecutionResumed'] );
        $this->assertEquals( 0, $this->receiver->stack['afterExecutionCancelled'] );
        $this->assertEquals( 1, $this->receiver->stack['afterExecutionEnded'] );
        $this->assertEquals( 22, $this->receiver->stack['beforeNodeActivated'] );
        $this->assertEquals( 22, $this->receiver->stack['afterNodeActivated'] );
        $this->assertEquals( 22, $this->receiver->stack['afterNodeExecuted'] );
        $this->assertEquals( 1, $this->receiver->stack['afterThreadStarted'] );
        $this->assertEquals( 1, $this->receiver->stack['afterThreadEnded'] );
        $this->assertEquals( 10, $this->receiver->stack['beforeVariableSet'] );
        $this->assertEquals( 10, $this->receiver->stack['afterVariableSet'] );
        $this->assertEquals( 0, $this->receiver->stack['beforeVariableUnset'] );
        $this->assertEquals( 0, $this->receiver->stack['afterVariableUnset'] );
    }

    public function testSignalsForDecrementingLoop()
    {
        $this->setUpLoop( 'decrement' );
        $this->execution->workflow = $this->workflow;
        $this->execution->start();

        $this->assertEquals( 1, $this->receiver->stack['afterExecutionStarted'] );
        $this->assertEquals( 0, $this->receiver->stack['afterExecutionSuspended'] );
        $this->assertEquals( 0, $this->receiver->stack['afterExecutionResumed'] );
        $this->assertEquals( 0, $this->receiver->stack['afterExecutionCancelled'] );
        $this->assertEquals( 1, $this->receiver->stack['afterExecutionEnded'] );
        $this->assertEquals( 22, $this->receiver->stack['beforeNodeActivated'] );
        $this->assertEquals( 22, $this->receiver->stack['afterNodeActivated'] );
        $this->assertEquals( 22, $this->receiver->stack['afterNodeExecuted'] );
        $this->assertEquals( 1, $this->receiver->stack['afterThreadStarted'] );
        $this->assertEquals( 1, $this->receiver->stack['afterThreadEnded'] );
        $this->assertEquals( 10, $this->receiver->stack['beforeVariableSet'] );
        $this->assertEquals( 10, $this->receiver->stack['afterVariableSet'] );
        $this->assertEquals( 0, $this->receiver->stack['beforeVariableUnset'] );
        $this->assertEquals( 0, $this->receiver->stack['afterVariableUnset'] );
    }

    public function testSignalsForSetAddSubMulDiv()
    {
        $this->setUpSetAddSubMulDiv();
        $this->execution->workflow = $this->workflow;
        $this->execution->start();

        $this->assertEquals( 1, $this->receiver->stack['afterExecutionStarted'] );
        $this->assertEquals( 0, $this->receiver->stack['afterExecutionSuspended'] );
        $this->assertEquals( 0, $this->receiver->stack['afterExecutionResumed'] );
        $this->assertEquals( 0, $this->receiver->stack['afterExecutionCancelled'] );
        $this->assertEquals( 1, $this->receiver->stack['afterExecutionEnded'] );
        $this->assertEquals( 7, $this->receiver->stack['beforeNodeActivated'] );
        $this->assertEquals( 7, $this->receiver->stack['afterNodeActivated'] );
        $this->assertEquals( 7, $this->receiver->stack['afterNodeExecuted'] );
        $this->assertEquals( 1, $this->receiver->stack['afterThreadStarted'] );
        $this->assertEquals( 1, $this->receiver->stack['afterThreadEnded'] );
        $this->assertEquals( 5, $this->receiver->stack['beforeVariableSet'] );
        $this->assertEquals( 5, $this->receiver->stack['afterVariableSet'] );
        $this->assertEquals( 0, $this->receiver->stack['beforeVariableUnset'] );
        $this->assertEquals( 0, $this->receiver->stack['afterVariableUnset'] );
    }

    public function testSignalsForAddVariables()
    {
        $this->setUpAddVariables();
        $this->execution->workflow = $this->workflow;
        $this->execution->start();

        $this->assertEquals( 1, $this->receiver->stack['afterExecutionStarted'] );
        $this->assertEquals( 0, $this->receiver->stack['afterExecutionSuspended'] );
        $this->assertEquals( 0, $this->receiver->stack['afterExecutionResumed'] );
        $this->assertEquals( 0, $this->receiver->stack['afterExecutionCancelled'] );
        $this->assertEquals( 1, $this->receiver->stack['afterExecutionEnded'] );
        $this->assertEquals( 4, $this->receiver->stack['beforeNodeActivated'] );
        $this->assertEquals( 4, $this->receiver->stack['afterNodeActivated'] );
        $this->assertEquals( 4, $this->receiver->stack['afterNodeExecuted'] );
        $this->assertEquals( 1, $this->receiver->stack['afterThreadStarted'] );
        $this->assertEquals( 1, $this->receiver->stack['afterThreadEnded'] );
        $this->assertEquals( 3, $this->receiver->stack['beforeVariableSet'] );
        $this->assertEquals( 3, $this->receiver->stack['afterVariableSet'] );
        $this->assertEquals( 0, $this->receiver->stack['beforeVariableUnset'] );
        $this->assertEquals( 0, $this->receiver->stack['afterVariableUnset'] );
    }

    public function testSignalsForVariableEqualsVariable()
    {
        $this->setUpVariableEqualsVariable();
        $this->execution->workflow = $this->workflow;
        $this->execution->start();

        $this->assertEquals( 1, $this->receiver->stack['afterExecutionStarted'] );
        $this->assertEquals( 0, $this->receiver->stack['afterExecutionSuspended'] );
        $this->assertEquals( 0, $this->receiver->stack['afterExecutionResumed'] );
        $this->assertEquals( 0, $this->receiver->stack['afterExecutionCancelled'] );
        $this->assertEquals( 1, $this->receiver->stack['afterExecutionEnded'] );
        $this->assertEquals( 6, $this->receiver->stack['beforeNodeActivated'] );
        $this->assertEquals( 6, $this->receiver->stack['afterNodeActivated'] );
        $this->assertEquals( 6, $this->receiver->stack['afterNodeExecuted'] );
        $this->assertEquals( 2, $this->receiver->stack['afterThreadStarted'] );
        $this->assertEquals( 2, $this->receiver->stack['afterThreadEnded'] );
        $this->assertEquals( 3, $this->receiver->stack['beforeVariableSet'] );
        $this->assertEquals( 3, $this->receiver->stack['afterVariableSet'] );
        $this->assertEquals( 0, $this->receiver->stack['beforeVariableUnset'] );
        $this->assertEquals( 0, $this->receiver->stack['afterVariableUnset'] );
    }

    public function testSignalsForParallelSplitSynchronization()
    {
        $this->setUpParallelSplitSynchronization();
        $this->execution->workflow = $this->workflow;
        $this->execution->start();

        $this->assertEquals( 1, $this->receiver->stack['afterExecutionStarted'] );
        $this->assertEquals( 0, $this->receiver->stack['afterExecutionSuspended'] );
        $this->assertEquals( 0, $this->receiver->stack['afterExecutionResumed'] );
        $this->assertEquals( 0, $this->receiver->stack['afterExecutionCancelled'] );
        $this->assertEquals( 1, $this->receiver->stack['afterExecutionEnded'] );
        $this->assertEquals( 7, $this->receiver->stack['beforeNodeActivated'] );
        $this->assertEquals( 7, $this->receiver->stack['afterNodeActivated'] );
        $this->assertEquals( 7, $this->receiver->stack['afterNodeExecuted'] );
        $this->assertEquals( 4, $this->receiver->stack['afterThreadStarted'] );
        $this->assertEquals( 4, $this->receiver->stack['afterThreadEnded'] );
        $this->assertEquals( 0, $this->receiver->stack['beforeVariableSet'] );
        $this->assertEquals( 0, $this->receiver->stack['afterVariableSet'] );
        $this->assertEquals( 0, $this->receiver->stack['beforeVariableUnset'] );
        $this->assertEquals( 0, $this->receiver->stack['afterVariableUnset'] );
    }

    public function testSignalsForParallelSplitSynchronization2()
    {
        $this->setUpParallelSplitSynchronization2();
        $this->execution->workflow = $this->workflow;
        $this->execution->setVariables( array( 'foo' => 'bar', 'bar' => 'foo' ) );
        $this->execution->start();

        $this->assertEquals( 1, $this->receiver->stack['afterExecutionStarted'] );
        $this->assertEquals( 0, $this->receiver->stack['afterExecutionSuspended'] );
        $this->assertEquals( 0, $this->receiver->stack['afterExecutionResumed'] );
        $this->assertEquals( 0, $this->receiver->stack['afterExecutionCancelled'] );
        $this->assertEquals( 1, $this->receiver->stack['afterExecutionEnded'] );
        $this->assertEquals( 6, $this->receiver->stack['beforeNodeActivated'] );
        $this->assertEquals( 6, $this->receiver->stack['afterNodeActivated'] );
        $this->assertEquals( 6, $this->receiver->stack['afterNodeExecuted'] );
        $this->assertEquals( 3, $this->receiver->stack['afterThreadStarted'] );
        $this->assertEquals( 3, $this->receiver->stack['afterThreadEnded'] );
        $this->assertEquals( 2, $this->receiver->stack['beforeVariableSet'] );
        $this->assertEquals( 2, $this->receiver->stack['afterVariableSet'] );
        $this->assertEquals( 0, $this->receiver->stack['beforeVariableUnset'] );
        $this->assertEquals( 0, $this->receiver->stack['afterVariableUnset'] );
    }

    public function testSignalsForExclusiveChoiceSimpleMerge()
    {
        $this->setUpExclusiveChoiceSimpleMerge();
        $this->execution->workflow = $this->workflow;
        $this->execution->setVariables( array( 'condition' => true ) );
        $this->execution->start();

        $this->assertEquals( 1, $this->receiver->stack['afterExecutionStarted'] );
        $this->assertEquals( 0, $this->receiver->stack['afterExecutionSuspended'] );
        $this->assertEquals( 0, $this->receiver->stack['afterExecutionResumed'] );
        $this->assertEquals( 0, $this->receiver->stack['afterExecutionCancelled'] );
        $this->assertEquals( 1, $this->receiver->stack['afterExecutionEnded'] );
        $this->assertEquals( 5, $this->receiver->stack['beforeNodeActivated'] );
        $this->assertEquals( 5, $this->receiver->stack['afterNodeActivated'] );
        $this->assertEquals( 5, $this->receiver->stack['afterNodeExecuted'] );
        $this->assertEquals( 2, $this->receiver->stack['afterThreadStarted'] );
        $this->assertEquals( 2, $this->receiver->stack['afterThreadEnded'] );
        $this->assertEquals( 1, $this->receiver->stack['beforeVariableSet'] );
        $this->assertEquals( 1, $this->receiver->stack['afterVariableSet'] );
        $this->assertEquals( 0, $this->receiver->stack['beforeVariableUnset'] );
        $this->assertEquals( 0, $this->receiver->stack['afterVariableUnset'] );
    }

    public function testSignalsForExclusiveChoiceWithElseSimpleMerge()
    {
        $this->setUpExclusiveChoiceWithElseSimpleMerge();
        $this->execution->workflow = $this->workflow;
        $this->execution->setVariables( array( 'condition' => true ) );
        $this->execution->start();

        $this->assertEquals( 1, $this->receiver->stack['afterExecutionStarted'] );
        $this->assertEquals( 0, $this->receiver->stack['afterExecutionSuspended'] );
        $this->assertEquals( 0, $this->receiver->stack['afterExecutionResumed'] );
        $this->assertEquals( 0, $this->receiver->stack['afterExecutionCancelled'] );
        $this->assertEquals( 1, $this->receiver->stack['afterExecutionEnded'] );
        $this->assertEquals( 5, $this->receiver->stack['beforeNodeActivated'] );
        $this->assertEquals( 5, $this->receiver->stack['afterNodeActivated'] );
        $this->assertEquals( 5, $this->receiver->stack['afterNodeExecuted'] );
        $this->assertEquals( 2, $this->receiver->stack['afterThreadStarted'] );
        $this->assertEquals( 2, $this->receiver->stack['afterThreadEnded'] );
        $this->assertEquals( 2, $this->receiver->stack['beforeVariableSet'] );
        $this->assertEquals( 2, $this->receiver->stack['afterVariableSet'] );
        $this->assertEquals( 0, $this->receiver->stack['beforeVariableUnset'] );
        $this->assertEquals( 0, $this->receiver->stack['afterVariableUnset'] );
    }

    public function testSignalsForExclusiveChoiceWithUnconditionalOutNodeSimpleMerge()
    {
        $this->setUpExclusiveChoiceWithUnconditionalOutNodeSimpleMerge();
        $this->execution->workflow = $this->workflow;
        $this->execution->setVariables( array( 'condition' => false ) );
        $this->execution->start();

        $this->assertEquals( 1, $this->receiver->stack['afterExecutionStarted'] );
        $this->assertEquals( 0, $this->receiver->stack['afterExecutionSuspended'] );
        $this->assertEquals( 0, $this->receiver->stack['afterExecutionResumed'] );
        $this->assertEquals( 0, $this->receiver->stack['afterExecutionCancelled'] );
        $this->assertEquals( 1, $this->receiver->stack['afterExecutionEnded'] );
        $this->assertEquals( 6, $this->receiver->stack['beforeNodeActivated'] );
        $this->assertEquals( 6, $this->receiver->stack['afterNodeActivated'] );
        $this->assertEquals( 6, $this->receiver->stack['afterNodeExecuted'] );
        $this->assertEquals( 3, $this->receiver->stack['afterThreadStarted'] );
        $this->assertEquals( 2, $this->receiver->stack['afterThreadEnded'] );
        $this->assertEquals( 3, $this->receiver->stack['beforeVariableSet'] );
        $this->assertEquals( 3, $this->receiver->stack['afterVariableSet'] );
        $this->assertEquals( 0, $this->receiver->stack['beforeVariableUnset'] );
        $this->assertEquals( 0, $this->receiver->stack['afterVariableUnset'] );
    }

    public function testSignalsForNestedExclusiveChoiceSimpleMerge()
    {
        $this->setUpNestedExclusiveChoiceSimpleMerge();
        $this->execution->workflow = $this->workflow;
        $this->execution->start();

        $this->assertEquals( 1, $this->receiver->stack['afterExecutionStarted'] );
        $this->assertEquals( 0, $this->receiver->stack['afterExecutionSuspended'] );
        $this->assertEquals( 0, $this->receiver->stack['afterExecutionResumed'] );
        $this->assertEquals( 0, $this->receiver->stack['afterExecutionCancelled'] );
        $this->assertEquals( 1, $this->receiver->stack['afterExecutionEnded'] );
        $this->assertEquals( 9, $this->receiver->stack['beforeNodeActivated'] );
        $this->assertEquals( 9, $this->receiver->stack['afterNodeActivated'] );
        $this->assertEquals( 9, $this->receiver->stack['afterNodeExecuted'] );
        $this->assertEquals( 3, $this->receiver->stack['afterThreadStarted'] );
        $this->assertEquals( 3, $this->receiver->stack['afterThreadEnded'] );
        $this->assertEquals( 3, $this->receiver->stack['beforeVariableSet'] );
        $this->assertEquals( 3, $this->receiver->stack['afterVariableSet'] );
        $this->assertEquals( 0, $this->receiver->stack['beforeVariableUnset'] );
        $this->assertEquals( 0, $this->receiver->stack['afterVariableUnset'] );
    }

    public function testSignalsForMultiChoiceSynchronizingMerge()
    {
        $this->setUpMultiChoice( 'SynchronizingMerge' );
        $this->execution->workflow = $this->workflow;
        $this->execution->start();

        $this->assertEquals( 1, $this->receiver->stack['afterExecutionStarted'] );
        $this->assertEquals( 0, $this->receiver->stack['afterExecutionSuspended'] );
        $this->assertEquals( 0, $this->receiver->stack['afterExecutionResumed'] );
        $this->assertEquals( 0, $this->receiver->stack['afterExecutionCancelled'] );
        $this->assertEquals( 1, $this->receiver->stack['afterExecutionEnded'] );
        $this->assertEquals( 8, $this->receiver->stack['beforeNodeActivated'] );
        $this->assertEquals( 8, $this->receiver->stack['afterNodeActivated'] );
        $this->assertEquals( 8, $this->receiver->stack['afterNodeExecuted'] );
        $this->assertEquals( 4, $this->receiver->stack['afterThreadStarted'] );
        $this->assertEquals( 4, $this->receiver->stack['afterThreadEnded'] );
        $this->assertEquals( 2, $this->receiver->stack['beforeVariableSet'] );
        $this->assertEquals( 2, $this->receiver->stack['afterVariableSet'] );
        $this->assertEquals( 0, $this->receiver->stack['beforeVariableUnset'] );
        $this->assertEquals( 0, $this->receiver->stack['afterVariableUnset'] );
    }

    public function testSignalsForMultiChoiceDiscriminator()
    {
        $this->setUpMultiChoice( 'Discriminator' );
        $this->execution->workflow = $this->workflow;
        $this->execution->start();

        $this->assertEquals( 1, $this->receiver->stack['afterExecutionStarted'] );
        $this->assertEquals( 0, $this->receiver->stack['afterExecutionSuspended'] );
        $this->assertEquals( 0, $this->receiver->stack['afterExecutionResumed'] );
        $this->assertEquals( 0, $this->receiver->stack['afterExecutionCancelled'] );
        $this->assertEquals( 1, $this->receiver->stack['afterExecutionEnded'] );
        $this->assertEquals( 8, $this->receiver->stack['beforeNodeActivated'] );
        $this->assertEquals( 8, $this->receiver->stack['afterNodeActivated'] );
        $this->assertEquals( 8, $this->receiver->stack['afterNodeExecuted'] );
        $this->assertEquals( 4, $this->receiver->stack['afterThreadStarted'] );
        $this->assertEquals( 4, $this->receiver->stack['afterThreadEnded'] );
        $this->assertEquals( 2, $this->receiver->stack['beforeVariableSet'] );
        $this->assertEquals( 2, $this->receiver->stack['afterVariableSet'] );
        $this->assertEquals( 0, $this->receiver->stack['beforeVariableUnset'] );
        $this->assertEquals( 0, $this->receiver->stack['afterVariableUnset'] );
    }

    public function testSignalsForNonInteractiveSubWorkflow()
    {
        $this->setUpWorkflowWithSubWorkflow( 'StartEnd' );
        $this->execution->definitionStorage = $this->definition;
        $this->execution->workflow = $this->workflow;
        $this->execution->start();

        $this->assertEquals( 2, $this->receiver->stack['afterExecutionStarted'] );
        $this->assertEquals( 0, $this->receiver->stack['afterExecutionSuspended'] );
        $this->assertEquals( 0, $this->receiver->stack['afterExecutionResumed'] );
        $this->assertEquals( 0, $this->receiver->stack['afterExecutionCancelled'] );
        $this->assertEquals( 2, $this->receiver->stack['afterExecutionEnded'] );
        $this->assertEquals( 5, $this->receiver->stack['beforeNodeActivated'] );
        $this->assertEquals( 5, $this->receiver->stack['afterNodeActivated'] );
        $this->assertEquals( 5, $this->receiver->stack['afterNodeExecuted'] );
        $this->assertEquals( 2, $this->receiver->stack['afterThreadStarted'] );
        $this->assertEquals( 2, $this->receiver->stack['afterThreadEnded'] );
        $this->assertEquals( 0, $this->receiver->stack['beforeVariableSet'] );
        $this->assertEquals( 0, $this->receiver->stack['afterVariableSet'] );
        $this->assertEquals( 0, $this->receiver->stack['beforeVariableUnset'] );
        $this->assertEquals( 0, $this->receiver->stack['afterVariableUnset'] );
    }

    public function testSignalsForInteractiveSubWorkflow()
    {
        $this->setUpWorkflowWithSubWorkflow( 'StartInputEnd' );
        $this->execution->definitionStorage = $this->definition;
        $this->execution->workflow = $this->workflow;
        $this->execution->setInputVariableForSubWorkflow( 'variable', 'value' );
        $this->execution->start();

        $this->assertEquals( 2, $this->receiver->stack['afterExecutionStarted'] );
        $this->assertEquals( 1, $this->receiver->stack['afterExecutionSuspended'] );
        $this->assertEquals( 1, $this->receiver->stack['afterExecutionResumed'] );
        $this->assertEquals( 0, $this->receiver->stack['afterExecutionCancelled'] );
        $this->assertEquals( 2, $this->receiver->stack['afterExecutionEnded'] );
        $this->assertEquals( 6, $this->receiver->stack['beforeNodeActivated'] );
        $this->assertEquals( 6, $this->receiver->stack['afterNodeActivated'] );
        $this->assertEquals( 6, $this->receiver->stack['afterNodeExecuted'] );
        $this->assertEquals( 2, $this->receiver->stack['afterThreadStarted'] );
        $this->assertEquals( 2, $this->receiver->stack['afterThreadEnded'] );
        $this->assertEquals( 3, $this->receiver->stack['beforeVariableSet'] );
        $this->assertEquals( 3, $this->receiver->stack['afterVariableSet'] );
        $this->assertEquals( 0, $this->receiver->stack['beforeVariableUnset'] );
        $this->assertEquals( 0, $this->receiver->stack['afterVariableUnset'] );
    }

    public function testSignalsForWorkflowWithCancelCaseSubWorkflow()
    {
        $this->setUpWorkflowWithSubWorkflow( 'ParallelSplitActionActionCancelCaseSynchronization' );
        $this->execution->definitionStorage = $this->definition;
        $this->execution->workflow = $this->workflow;
        $this->execution->start();

        $this->assertEquals( 2, $this->receiver->stack['afterExecutionStarted'] );
        $this->assertEquals( 0, $this->receiver->stack['afterExecutionSuspended'] );
        $this->assertEquals( 0, $this->receiver->stack['afterExecutionResumed'] );
        $this->assertEquals( 2, $this->receiver->stack['afterExecutionCancelled'] );
        $this->assertEquals( 0, $this->receiver->stack['afterExecutionEnded'] );
        $this->assertEquals( 7, $this->receiver->stack['beforeNodeActivated'] );
        $this->assertEquals( 7, $this->receiver->stack['afterNodeActivated'] );
        $this->assertEquals( 5, $this->receiver->stack['afterNodeExecuted'] );
        $this->assertEquals( 5, $this->receiver->stack['afterThreadStarted'] );
        $this->assertEquals( 0, $this->receiver->stack['afterThreadEnded'] );
        $this->assertEquals( 0, $this->receiver->stack['beforeVariableSet'] );
        $this->assertEquals( 0, $this->receiver->stack['afterVariableSet'] );
        $this->assertEquals( 0, $this->receiver->stack['beforeVariableUnset'] );
        $this->assertEquals( 0, $this->receiver->stack['afterVariableUnset'] );
    }

    public function testSignalsForNestedLoops()
    {
        $this->setUpNestedLoops();
        $this->execution->workflow = $this->workflow;
        $this->execution->start();

        $this->assertEquals( 1, $this->receiver->stack['afterExecutionStarted'] );
        $this->assertEquals( 0, $this->receiver->stack['afterExecutionSuspended'] );
        $this->assertEquals( 0, $this->receiver->stack['afterExecutionResumed'] );
        $this->assertEquals( 0, $this->receiver->stack['afterExecutionCancelled'] );
        $this->assertEquals( 1, $this->receiver->stack['afterExecutionEnded'] );
        $this->assertEquals( 10, $this->receiver->stack['beforeNodeActivated'] );
        $this->assertEquals( 10, $this->receiver->stack['afterNodeActivated'] );
        $this->assertEquals( 10, $this->receiver->stack['afterNodeExecuted'] );
        $this->assertEquals( 1, $this->receiver->stack['afterThreadStarted'] );
        $this->assertEquals( 1, $this->receiver->stack['afterThreadEnded'] );
        $this->assertEquals( 4, $this->receiver->stack['beforeVariableSet'] );
        $this->assertEquals( 4, $this->receiver->stack['afterVariableSet'] );
        $this->assertEquals( 0, $this->receiver->stack['beforeVariableUnset'] );
        $this->assertEquals( 0, $this->receiver->stack['afterVariableUnset'] );
    }

    public function testSignalsForWorkflowWithSubWorkflowAndVariablePassing()
    {
        $this->setUpWorkflowWithSubWorkflowAndVariablePassing();
        $this->execution->definitionStorage = $this->definition;
        $this->execution->workflow = $this->workflow;
        $this->execution->start();

        $this->assertEquals( 2, $this->receiver->stack['afterExecutionStarted'] );
        $this->assertEquals( 0, $this->receiver->stack['afterExecutionSuspended'] );
        $this->assertEquals( 0, $this->receiver->stack['afterExecutionResumed'] );
        $this->assertEquals( 0, $this->receiver->stack['afterExecutionCancelled'] );
        $this->assertEquals( 2, $this->receiver->stack['afterExecutionEnded'] );
        $this->assertEquals( 7, $this->receiver->stack['beforeNodeActivated'] );
        $this->assertEquals( 7, $this->receiver->stack['afterNodeActivated'] );
        $this->assertEquals( 7, $this->receiver->stack['afterNodeExecuted'] );
        $this->assertEquals( 2, $this->receiver->stack['afterThreadStarted'] );
        $this->assertEquals( 2, $this->receiver->stack['afterThreadEnded'] );
        $this->assertEquals( 4, $this->receiver->stack['beforeVariableSet'] );
        $this->assertEquals( 4, $this->receiver->stack['afterVariableSet'] );
        $this->assertEquals( 0, $this->receiver->stack['beforeVariableUnset'] );
        $this->assertEquals( 0, $this->receiver->stack['afterVariableUnset'] );
    }

    public function testSignalsForParallelSplitCancelCaseActionActionSynchronization()
    {
        $this->setUpCancelCase( 'first' );
        $this->execution->workflow = $this->workflow;
        $this->execution->start();

        $this->assertEquals( 1, $this->receiver->stack['afterExecutionStarted'] );
        $this->assertEquals( 0, $this->receiver->stack['afterExecutionSuspended'] );
        $this->assertEquals( 0, $this->receiver->stack['afterExecutionResumed'] );
        $this->assertEquals( 1, $this->receiver->stack['afterExecutionCancelled'] );
        $this->assertEquals( 0, $this->receiver->stack['afterExecutionEnded'] );
        $this->assertEquals( 3, $this->receiver->stack['beforeNodeActivated'] );
        $this->assertEquals( 3, $this->receiver->stack['afterNodeActivated'] );
        $this->assertEquals( 3, $this->receiver->stack['afterNodeExecuted'] );
        $this->assertEquals( 2, $this->receiver->stack['afterThreadStarted'] );
        $this->assertEquals( 0, $this->receiver->stack['afterThreadEnded'] );
        $this->assertEquals( 0, $this->receiver->stack['beforeVariableSet'] );
        $this->assertEquals( 0, $this->receiver->stack['afterVariableSet'] );
        $this->assertEquals( 0, $this->receiver->stack['beforeVariableUnset'] );
        $this->assertEquals( 0, $this->receiver->stack['afterVariableUnset'] );
    }

    public function testSignalsForParallelSplitActionActionCancelCaseSynchronization()
    {
        $this->setUpCancelCase( 'last' );
        $this->execution->workflow = $this->workflow;
        $this->execution->start();

        $this->assertEquals( 1, $this->receiver->stack['afterExecutionStarted'] );
        $this->assertEquals( 0, $this->receiver->stack['afterExecutionSuspended'] );
        $this->assertEquals( 0, $this->receiver->stack['afterExecutionResumed'] );
        $this->assertEquals( 1, $this->receiver->stack['afterExecutionCancelled'] );
        $this->assertEquals( 0, $this->receiver->stack['afterExecutionEnded'] );
        $this->assertEquals( 5, $this->receiver->stack['beforeNodeActivated'] );
        $this->assertEquals( 5, $this->receiver->stack['afterNodeActivated'] );
        $this->assertEquals( 3, $this->receiver->stack['afterNodeExecuted'] );
        $this->assertEquals( 4, $this->receiver->stack['afterThreadStarted'] );
        $this->assertEquals( 0, $this->receiver->stack['afterThreadEnded'] );
        $this->assertEquals( 0, $this->receiver->stack['beforeVariableSet'] );
        $this->assertEquals( 0, $this->receiver->stack['afterVariableSet'] );
        $this->assertEquals( 0, $this->receiver->stack['beforeVariableUnset'] );
        $this->assertEquals( 0, $this->receiver->stack['afterVariableUnset'] );
    }

    public function testOptions()
    {
        $this->assertTrue( isset( $this->plugin->options['afterExecutionStarted'] ) );
        $this->assertFalse( isset( $this->plugin->foo ) );
        $this->assertEquals( 'afterExecutionStarted', $this->plugin->options['afterExecutionStarted'] );

        $this->plugin->options['afterExecutionStarted'] = 'myAfterExecutionStarted';
        $this->assertEquals( 'myAfterExecutionStarted', $this->plugin->options['afterExecutionStarted'] );
    }

    /**
     * @expectedException ezcBaseValueException
     */
    public function testOptions2()
    {
        $this->plugin->options['afterExecutionStarted'] = null;
    }

    public function testOptions3()
    {
        $options = new ezcWorkflowSignalSlotPluginOptions;
        $this->plugin->options = $options;

        $this->assertSame($options, $this->plugin->options);
    }

    /**
     * @expectedException ezcBaseValueException
     */
    public function testOptions4()
    {
        $this->plugin->options = null;
    }

    /**
     * @expectedException ezcBasePropertyNotFoundException
     */
    public function testOptions5()
    {
        $this->plugin->options['foo'] = null;
    }

    /**
     * @expectedException ezcBaseValueException
     */
    public function testOptions6()
    {
        $this->plugin->signals = null;
    }

    public function testOptions7()
    {
        $signals = new ezcSignalCollection;
        $this->plugin->signals = $signals;

        $this->assertSame($signals, $this->plugin->signals);
    }

    /**
     * @expectedException ezcBasePropertyNotFoundException
     */
    public function testProperties()
    {
        $foo = $this->plugin->foo;
    }

    /**
     * @expectedException ezcBasePropertyNotFoundException
     */
    public function testProperties2()
    {
        $this->plugin->foo = 'foo';
    }
}
?>
