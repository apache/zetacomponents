<?php
/**
 * File containing the ezcWorkflowDatabaseExecution class.
 *
 * @category Workflow
 * @package WorkflowDatabaseTiein
 * @version //autogen//
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
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
     * @param int $executionId
     */
    public function __construct ( ezcDbHandler $db, $executionId = null )
    {
        $this->db = $db;
        $this->properties['definitionStorage'] = new ezcWorkflowDatabaseDefinitionStorage( $db );

        if ( is_int( $executionId ) )
        {
            $this->loadExecution( $executionId );
        }
    }

    /**
     * Start workflow execution.
     *
     * @param  int $parentId
     * @throws ezcDbException
     */
    protected function doStart( $parentId )
    {
        $this->db->beginTransaction();

        $query = $this->db->createInsertQuery();

        $query->insertInto( $this->db->quoteIdentifier( 'execution' ) )
              ->set( $this->db->quoteIdentifier( 'workflow_id' ), $query->bindValue( (int)$this->workflow->id ) )
              ->set( $this->db->quoteIdentifier( 'execution_parent' ), $query->bindValue( (int)$parentId ) )
              ->set( $this->db->quoteIdentifier( 'execution_started' ), $query->bindValue( time() ) )
              ->set( $this->db->quoteIdentifier( 'execution_variables' ), $query->bindValue( ezcWorkflowDatabaseUtil::serialize( $this->variables ) ) )
              ->set( $this->db->quoteIdentifier( 'execution_waiting_for' ), $query->bindValue( ezcWorkflowDatabaseUtil::serialize( $this->waitingFor ) ) )
              ->set( $this->db->quoteIdentifier( 'execution_threads' ), $query->bindValue( ezcWorkflowDatabaseUtil::serialize( $this->threads ) ) )
              ->set( $this->db->quoteIdentifier( 'execution_next_thread_id' ), $query->bindValue( (int)$this->nextThreadId ) );

        $statement = $query->prepare();
        $statement->execute();

        $this->id = (int)$this->db->lastInsertId( 'execution_execution_id_seq' );
    }

    /**
     * Suspend workflow execution.
     *
     * @throws ezcDbException
     */
    protected function doSuspend()
    {
        $query = $this->db->createUpdateQuery();

        $query->update( $this->db->quoteIdentifier( 'execution' ) )
              ->where( $query->expr->eq( $this->db->quoteIdentifier( 'execution_id' ), $query->bindValue( (int)$this->id ) ) )
              ->set( $this->db->quoteIdentifier( 'execution_variables' ), $query->bindValue( ezcWorkflowDatabaseUtil::serialize( $this->variables ) ) )
              ->set( $this->db->quoteIdentifier( 'execution_waiting_for' ), $query->bindValue( ezcWorkflowDatabaseUtil::serialize( $this->waitingFor ) ) )
              ->set( $this->db->quoteIdentifier( 'execution_threads' ), $query->bindValue( ezcWorkflowDatabaseUtil::serialize( $this->threads ) ) )
              ->set( $this->db->quoteIdentifier( 'execution_next_thread_id' ), $query->bindValue( (int)$this->nextThreadId ) );

        $statement = $query->prepare();
        $statement->execute();

        foreach ( $this->activatedNodes as $node )
        {
            $query = $this->db->createInsertQuery();

            $query->insertInto( $this->db->quoteIdentifier( 'execution_state' ) )
                  ->set( $this->db->quoteIdentifier( 'execution_id' ), $query->bindValue( (int)$this->id ) )
                  ->set( $this->db->quoteIdentifier( 'node_id' ), $query->bindValue( (int)$node->getId() ) )
                  ->set( $this->db->quoteIdentifier( 'node_state' ), $query->bindValue( ezcWorkflowDatabaseUtil::serialize( $node->getState() ) ) )
                  ->set( $this->db->quoteIdentifier( 'node_activated_from' ), $query->bindValue( ezcWorkflowDatabaseUtil::serialize( $node->getActivatedFrom() ) ) )
                  ->set( $this->db->quoteIdentifier( 'node_thread_id' ), $query->bindValue( (int)$node->getThreadId() ) );

            $statement = $query->prepare();
            $statement->execute();
        }

        $this->db->commit();
    }

    /**
     * Resume workflow execution.
     *
     * @throws ezcDbException
     */
    protected function doResume()
    {
        $this->db->beginTransaction();
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

        if ( !$this->isCancelled() )
        {
            $this->db->commit();
        }
    }

    /**
     * Returns a new execution object for a sub workflow.
     *
     * @param  int $id
     * @return ezcWorkflowExecution
     */
    protected function doGetSubExecution( $id = null )
    {
        return new ezcWorkflowDatabaseExecution( $this->db, $id );
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
        $query->deleteFrom( $this->db->quoteIdentifier( $tableName ) );

        $id = $query->expr->eq( $this->db->quoteIdentifier( 'execution_id' ), $query->bindValue( (int)$this->id ) );

        if ( $tableName == 'execution' )
        {
            $parent = $query->expr->eq( $this->db->quoteIdentifier( 'execution_parent' ), $query->bindValue( (int)$this->id ) );
            $query->where( $query->expr->lOr( $id, $parent ) );
        }
        else
        {
            $query->where( $id );
        }

        $statement = $query->prepare();
        $statement->execute();
    }

    /**
     * Load execution state.
     *
     * @param int $executionId  ID of the execution to load.
     * @throws ezcWorkflowExecutionException
     */
    protected function loadExecution( $executionId )
    {
        $query = $this->db->createSelectQuery();

        $query->select( $this->db->quoteIdentifier( 'workflow_id' ) )
              ->select( $this->db->quoteIdentifier( 'execution_variables' ) )
              ->select( $this->db->quoteIdentifier( 'execution_threads' ) )
              ->select( $this->db->quoteIdentifier( 'execution_next_thread_id' ) )
              ->select( $this->db->quoteIdentifier( 'execution_waiting_for' ) )
              ->from( $this->db->quoteIdentifier( 'execution' ) )
              ->where( $query->expr->eq( $this->db->quoteIdentifier( 'execution_id' ),
                                          $query->bindValue( (int)$executionId ) ) );

        $stmt = $query->prepare();
        $stmt->execute();

        $result = $stmt->fetchAll( PDO::FETCH_ASSOC );

        if ( $result === false || empty( $result ) )
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

        $workflowId     = $result[0]['workflow_id'];
        $this->workflow = $this->properties['definitionStorage']->loadById( $workflowId );

        $query = $this->db->createSelectQuery();

        $query->select( $this->db->quoteIdentifier( 'node_id' ) )
              ->select( $this->db->quoteIdentifier( 'node_state' ) )
              ->select( $this->db->quoteIdentifier( 'node_activated_from' ) )
              ->select( $this->db->quoteIdentifier( 'node_thread_id' ) )
              ->from( $this->db->quoteIdentifier( 'execution_state' ) )
              ->where( $query->expr->eq( $this->db->quoteIdentifier( 'execution_id' ),
                                          $query->bindValue( (int)$executionId ) ) );

        $stmt = $query->prepare();
        $stmt->execute();

        $result         = $stmt->fetchAll( PDO::FETCH_ASSOC );
        $activatedNodes = array();

        foreach ( $result as $row )
        {
            $activatedNodes[$row['node_id']] = array(
              'state' => $row['node_state'],
              'activated_from' => $row['node_activated_from'],
              'thread_id' => $row['node_thread_id']
            );
        }

        foreach ( $this->workflow->nodes as $node )
        {
            $nodeId = $node->getId();

            if ( isset( $activatedNodes[$nodeId] ) )
            {
                $node->setActivationState( ezcWorkflowNode::WAITING_FOR_EXECUTION );
                $node->setThreadId( $activatedNodes[$nodeId]['thread_id'] );
                $node->setState( ezcWorkflowDatabaseUtil::unserialize( $activatedNodes[$nodeId]['state'], null ) );
                $node->setActivatedFrom( ezcWorkflowDatabaseUtil::unserialize( $activatedNodes[$nodeId]['activated_from'] ) );

                $this->activate( $node, false );
            }
        }

        $this->loaded = true;
    }
}
?>
