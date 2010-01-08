<?php
/**
 * File containing the ezcWorkflowSignalSlotTestReceiver class.
 *
 * @package WorkflowSignalSlotTiein
 * @subpackage Tests
 * @version //autogen//
 * @copyright Copyright (C) 2005-2010 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * @package WorkflowSignalSlotTiein
 * @subpackage Tests
 * @version //autogen//
 */
class ezcWorkflowSignalSlotTestReceiver
{
    public $stack = array(
      'afterExecutionStarted' => 0,
      'afterExecutionSuspended' => 0,
      'afterExecutionResumed' => 0,
      'afterExecutionCancelled' => 0,
      'afterExecutionEnded' => 0,
      'beforeNodeActivated' => 0,
      'afterNodeActivated' => 0,
      'afterNodeExecuted' => 0,
      'afterThreadStarted' => 0,
      'afterThreadEnded' => 0,
      'beforeVariableSet' => 0,
      'afterVariableSet' => 0,
      'beforeVariableUnset' => 0,
      'afterVariableUnset' => 0
    );

    public function afterExecutionStarted( ezcWorkflowExecution $execution )
    {
        $this->stack['afterExecutionStarted']++;
    }

    public function afterExecutionSuspended( ezcWorkflowExecution $execution )
    {
        $this->stack['afterExecutionSuspended']++;
    }

    public function afterExecutionResumed( ezcWorkflowExecution $execution )
    {
        $this->stack['afterExecutionResumed']++;
    }

    public function afterExecutionCancelled( ezcWorkflowExecution $execution )
    {
        $this->stack['afterExecutionCancelled']++;
    }

    public function afterExecutionEnded( ezcWorkflowExecution $execution )
    {
        $this->stack['afterExecutionEnded']++;
    }

    public function beforeNodeActivated( ezcWorkflowExecution $execution, ezcWorkflowNode $node, ezcWorkflowSignalSlotReturnValue $return )
    {
        $this->stack['beforeNodeActivated']++;
    }

    public function afterNodeActivated( ezcWorkflowExecution $execution, ezcWorkflowNode $node )
    {
        $this->stack['afterNodeActivated']++;
    }

    public function afterNodeExecuted( ezcWorkflowExecution $execution, ezcWorkflowNode $node )
    {
        $this->stack['afterNodeExecuted']++;
    }

    public function afterThreadStarted( ezcWorkflowExecution $execution, $threadId, $parentId, $numSiblings )
    {
        $this->stack['afterThreadStarted']++;
    }

    public function afterThreadEnded( ezcWorkflowExecution $execution, $threadId )
    {
        $this->stack['afterThreadEnded']++;
    }

    public function beforeVariableSet( ezcWorkflowExecution $execution, $variableName, $value, ezcWorkflowSignalSlotReturnValue $return )
    {
        $this->stack['beforeVariableSet']++;
    }

    public function afterVariableSet( ezcWorkflowExecution $execution, $variableName, $value )
    {
        $this->stack['afterVariableSet']++;
    }

    public function beforeVariableUnset( ezcWorkflowExecution $execution, $variableName, ezcWorkflowSignalSlotReturnValue $return )
    {
        $this->stack['beforeVariableUnset']++;
    }

    public function afterVariableUnset( ezcWorkflowExecution $execution, $variableName )
    {
        $this->stack['afterVariableUnset']++;
    }
}
?>
