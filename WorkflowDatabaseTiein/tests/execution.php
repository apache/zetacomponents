<?php
/**
 * File containing the WorkflowDatabaseTieinTestExecution class.
 *
 * @package WorkflowDatabaseTiein
 * @version //autogen//
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

ezcTestRunner::addFileToFilter( __FILE__ );

/**
 * Workflow execution engine for testing workflows.
 *
 * @package WorkflowDatabaseTiein
 * @subpackage Tests
 * @version //autogen//
 */
class WorkflowDatabaseTestExecution extends ezcWorkflowDatabaseExecution
{
    /**
     * @var array
     */
    protected $inputVariables = array();

    /**
     * @var array
     */
    protected $inputVariablesForSubWorkflow = array();

    /**
     * Sets an input variable.
     *
     * @param  string $name
     * @param  mixed  $value
     */
    public function setInputVariable( $name, $value )
    {
        $this->inputVariables[$name] = $value;
    }

    /**
     * Sets an input variable for a sub workflow.
     *
     * @param  string $name
     * @param  mixed  $value
     */
    public function setInputVariableForSubWorkflow( $name, $value )
    {
        $this->inputVariablesForSubWorkflow[$name] = $value;
    }

    /**
     * Suspend workflow execution.
     */
    public function suspend()
    {
        parent::suspend();

        PHPUnit_Framework_Assert::assertFalse( $this->hasEnded() );
        PHPUnit_Framework_Assert::assertFalse( $this->isResumed() );
        PHPUnit_Framework_Assert::assertTrue( $this->isSuspended() );

        $inputData = array();

        foreach ( $this->inputVariables as $name => $value )
        {
            if ( isset( $this->waitingFor[$name] ) )
            {
                $inputData[$name] = $value;
            }
        }

        if ( empty( $inputData ) )
        {
            throw new ezcWorkflowExecutionException(
              'Workflow is waiting for input data that has not been mocked.'
            );
        }

        $this->resume( false, $inputData );
    }

    /**
     * Returns a new execution object for a sub workflow.
     *
     * @return ezcWorkflowExecution
     */
    protected function doGetSubExecution()
    {
        $execution = parent::doGetSubExecution();
        $execution = new WorkflowDatabaseTestExecution( $this->db );

        foreach ( $this->inputVariablesForSubWorkflow as $name => $value )
        {
            $execution->setInputVariable( $name, $value );
        }

        return $execution;
    }
}
?>
