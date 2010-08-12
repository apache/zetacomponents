<?php
/**
 * File containing the ezcWorkflowSignalSlotTestReceiver class.
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
 * @package WorkflowSignalSlotTiein
 * @subpackage Tests
 * @version //autogen//
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
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
