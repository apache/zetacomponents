<?php
/**
 * File containing the ezcWorkflowDatabaseExecution class.
 *
 * @package WorkflowDatabaseTiein
 * @version //autogen//
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Workflow executer that suspends and resumes workflow
 * execution states to and from a database.
 *
 * @package WorkflowDatabaseTiein
 * @version //autogen//
 */
class ezcWorkflowDatabaseExecution extends ezcWorkflowExecution
{
    /**
     * ezcDbHandler instance to be used.
     *
     * @var ezcDbHandler
     */
    protected $db;

    /**
     * Flag that indicates whether the execution has been loaded.
     *
     * @var boolean
     */
    protected $loaded = false;

    /**
     * Construct a new database execution.
     *
     * This constructor is a tie-in.
     *
     * @param ezcDbHandler $db
     * @param integer $executionId
     */
    public function __construct ( ezcDbHandler $db, $executionId = null )
    {
        $this->db = $db;

        if ( is_int( $executionId ) )
        {
            $this->loadExecution( $executionId );
        }
    }

    /**
     * Start workflow execution.
     *
     * @param  integer $parentId
     * @throws ezcDbException
     */
    protected function doStart( $parentId )
    {
        $this->db->beginTransaction();

        $query = $this->db->createInsertQuery();

        $query->insertInto( 'execution' )
              ->set( 'workflow_id',       $query->bindValue( $this->workflow->getId() ) )
              ->set( 'execution_parent',  $query->bindValue( $parentId ) )
              ->set( 'execution_started', $query->bindValue( time() ) );

        $statement = $query->prepare();
        $statement->execute();

        $this->id = $this->db->lastInsertId();
    }

    /**
     * Suspend workflow execution.
     *
     * @throws ezcDbException
     */
    protected function doSuspend()
    {
        $query = $this->db->createUpdateQuery();

        $query->update( 'execution' )
              ->where( $query->expr->eq( 'execution_id', $query->bindValue( $this->id ) ) )
              ->set( 'execution_variables', $query->bindValue( ezcWorkflowDatabaseUtil::serialize( $this->variables ) ) )
              ->set( 'execution_waiting_for', $query->bindValue( ezcWorkflowDatabaseUtil::serialize( $this->waitingFor ) ) )
              ->set( 'execution_threads', $query->bindValue( ezcWorkflowDatabaseUtil::serialize( $this->threads ) ) )
              ->set( 'execution_next_thread_id', $query->bindValue( $this->nextThreadId ) );

        $statement = $query->prepare();
        $statement->execute();

        foreach ( $this->activatedNodes as $node )
        {
            $query = $this->db->createInsertQuery();

            $query->insertInto( 'execution_state' )
                  ->set( 'execution_id',        $query->bindValue( $this->id ) )
                  ->set( 'node_id',             $query->bindValue( $node->getId() ) )
                  ->set( 'node_state',          $query->bindValue( ezcWorkflowDatabaseUtil::serialize( $node->getState() ) ) )
                  ->set( 'node_activated_from', $query->bindValue( ezcWorkflowDatabaseUtil::serialize( $node->getActivatedFrom() ) ) )
                  ->set( 'node_thread_id',      $query->bindValue( $node->getThreadId() ) );

            $statement = $query->prepare();
            $statement->execute();
        }

        $this->db->commit();
    }

    /**
     * Resume workflow execution.
     *
     * @param integer $executionId  ID of the execution to resume.
     * @throws ezcDbException
     */
    protected function doResume( $executionId )
    {
        $this->db->beginTransaction();

        if ( !$this->loaded )
        {
            $this->loadExecution( $executionId );
        }

        $this->cleanupTable( 'execution_state' );
    }

    /**
     * End workflow execution.
     *
     * @throws ezcDbException
     */
    protected function doEnd()
    {
        $this->cleanupTable( 'execution' );
        $this->cleanupTable( 'execution_state' );

        $this->db->commit();
    }

    /**
     * Returns a new execution object for a sub workflow.
     *
     * @param  integer $id
     * @return ezcWorkflowExecution
     */
    protected function doGetSubExecution( $id = NULL )
    {
        $execution = new ezcWorkflowDatabaseExecution( $this->db );

        if ( $id !== NULL )
        {
            $execution->resume( $id );
        }

        return $execution;
    }

    /**
     * Cleanup execution / execution_state tables.
     *
     * @param  string $tableName
     * @throws ezcDbException
     */
    protected function cleanupTable( $tableName )
    {
        $query = $this->db->createDeleteQuery();

        $query->deleteFrom( $tableName )
              ->where( $query->expr->eq( 'execution_id', $query->bindValue( $this->id ) ) );

        $statement = $query->prepare();
        $statement->execute();
    }

    /**
     * Load execution state.
     *
     * @param integer $executionId  ID of the execution to load.
     * @throws ezcWorkflowExecutionException
     */
    protected function loadExecution( $executionId )
    {
        $query = $this->db->createSelectQuery();

        $query->select( 'workflow_id, execution_variables, execution_threads,
                         execution_next_thread_id, execution_waiting_for' )
              ->from( 'execution' )
              ->where( $query->expr->eq( 'execution_id',
                                          $query->bindValue( $executionId ) ) );

        $stmt = $query->prepare();
        $stmt->execute();

        $result = $stmt->fetchAll( PDO::FETCH_ASSOC );

        if ( $result === false )
        {
            throw new ezcWorkflowExecutionException(
              'Could not load execution state.'
            );
        }

        $this->id = $executionId;
        $this->nextThreadId = $result[0]['execution_next_thread_id'];

        $this->threads = ezcWorkflowDatabaseUtil::unserialize( $result[0]['execution_threads'] );
        $this->variables = ezcWorkflowDatabaseUtil::unserialize( $result[0]['execution_variables'] );
        $this->waitingFor = ezcWorkflowDatabaseUtil::unserialize( $result[0]['execution_waiting_for'] );

        $definition = new ezcWorkflowDatabaseDefinition( $this->db );

        $workflowId     = $result[0]['workflow_id'];
        $this->workflow = $definition->loadById( $workflowId );

        $query = $this->db->createSelectQuery();

        $query->select( 'node_id, node_state, node_activated_from, node_thread_id' )
              ->from( 'execution_state' )
              ->where( $query->expr->eq( 'execution_id',
                                          $query->bindValue( $executionId ) ) );

        $stmt = $query->prepare();
        $stmt->execute();

        $result = $stmt->fetchAll( PDO::FETCH_ASSOC );

        $activatedNodes = array();

        if ( $result !== false )
        {
            foreach ( $result as $row )
            {
                $activatedNodes[$row['node_id']] = array(
                  'state' => $row['node_state'],
                  'activated_from' => $row['node_activated_from'],
                  'thread_id' => $row['node_thread_id']
                );
            }
        }
        else
        {
            throw new ezcWorkflowExecutionException(
              'Could not load execution state.'
            );
        }

        foreach ( $this->workflow->getNodes() as $node )
        {
            $nodeId = $node->getId();

            if ( isset( $activatedNodes[$nodeId] ) )
            {
                $this->activate( $node );

                $node->setActivationState( ezcWorkflowNode::WAITING_FOR_EXECUTION );
                $node->setThreadId( $activatedNodes[$nodeId]['thread_id'] );
                $node->setState( ezcWorkflowDatabaseUtil::unserialize( $activatedNodes[$nodeId]['state'], null ) );
                $node->setActivatedFrom( ezcWorkflowDatabaseUtil::unserialize( $activatedNodes[$nodeId]['activated_from'] ) );
            }
        }

        $this->loaded = true;
    }
}
?>
