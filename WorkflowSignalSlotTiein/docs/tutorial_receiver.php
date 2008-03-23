<?php
class MyReceiver
{
    public function afterExecutionStarted( ezcWorkflowExecution $execution )
    {
    }

    public function afterExecutionSuspended( ezcWorkflowExecution $execution )
    {
    }

    public function afterExecutionResumed( ezcWorkflowExecution $execution )
    {
    }

    public function afterExecutionCancelled( ezcWorkflowExecution $execution )
    {
    }

    public function afterExecutionEnded( ezcWorkflowExecution $execution )
    {
    }

    public function beforeNodeActivated( ezcWorkflowExecution $execution, ezcWorkflowNode $node, ezcWorkflowSignalSlotReturnValue $return )
    {
    }

    public function afterNodeActivated( ezcWorkflowExecution $execution, ezcWorkflowNode $node )
    {
    }

    public function afterNodeExecuted( ezcWorkflowExecution $execution, ezcWorkflowNode $node )
    {
    }

    public function afterThreadStarted( ezcWorkflowExecution $execution, $threadId, $parentId, $numSiblings )
    {
    }

    public function afterThreadEnded( ezcWorkflowExecution $execution, $threadId )
    {
    }

    public function beforeVariableSet( ezcWorkflowExecution $execution, $variableName, $value, ezcWorkflowSignalSlotReturnValue $return )
    {
    }

    public function afterVariableSet( ezcWorkflowExecution $execution, $variableName, $value )
    {
    }

    public function beforeVariableUnset( ezcWorkflowExecution $execution, $variableName, ezcWorkflowSignalSlotReturnValue $return )
    {
    }

    public function afterVariableUnset( ezcWorkflowExecution $execution, $variableName )
    {
    }
}
?>
