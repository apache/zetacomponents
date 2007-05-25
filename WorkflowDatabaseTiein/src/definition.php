<?php
/**
 * File containing the ezcWorkflowDatabaseDefinition class.
 *
 * @package WorkflowDatabaseTiein
 * @version //autogen//
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Workflow definition storage handler that saves and loads workflow
 * definitions to and from a database.
 *
 * @package WorkflowDatabaseTiein
 * @version //autogen//
 */
class ezcWorkflowDatabaseDefinition implements ezcWorkflowDefinition
{
    /** 
     * ezcDbHandler instance to be used.
     *
     * @var ezcDbHandler
     */
    protected $db;

    /**
     * Construct a new database definition handler.
     *
     * This constructor is a tie-in.
     *
     * @param ezcDbHandler $db
     */
    public function __construct( ezcDbHandler $db )
    {
        $this->db = $db;
    }

    /**
     * Load a workflow definition by ID.
     *
     * Providing the name of the workflow that is to be loaded as the
     * optional second parameter saves a database query.
     *
     * @param  integer $workflowId
     * @param  string  $workflowName
     * @param  integer $workflowVersion
     * @return ezcWorkflow
     * @throws ezcWorkflowDefinitionException
     * @throws ezcDbException
     */
    public function loadById( $workflowId, $workflowName = '', $workflowVersion = 0 )
    {
        // Query the database for the name and version of the workflow.
        if ( empty( $workflowName ) || $workflowVersion == 0 )
        {
            $query = $this->db->createSelectQuery();

            $query->select( 'workflow_name, workflow_version' )
                  ->from( 'workflow' )
                  ->where( $query->expr->eq( 'workflow_id',
                                              $query->bindValue( $workflowId ) ) );

            $stmt = $query->prepare();
            $stmt->execute();

            $result = $stmt->fetchAll( PDO::FETCH_ASSOC );

            if ( $result !== false && isset( $result[0] ) )
            {
                $workflowName    = $result[0]['workflow_name'];
                $workflowVersion = $result[0]['workflow_version'];
            }
            else
            {
                throw new ezcWorkflowDefinitionException(
                  'Could not load workflow definition.'
                );
            }
        }

        // Query the database for the nodes of the workflow to be loaded.
        $query = $this->db->createSelectQuery();

        $query->select( 'node_id, node_class, node_configuration' )
              ->from( 'node' )
              ->where( $query->expr->eq( 'workflow_id',
                                          $query->bindValue( $workflowId ) ) );

        $stmt = $query->prepare();
        $stmt->execute();

        $result = $stmt->fetchAll( PDO::FETCH_ASSOC );
        $nodes  = array();

        if ( $result !== false )
        {
            // Create node objects.
            foreach ( $result as $node )
            {
                $nodes[$node['node_id']] = new $node['node_class'](
                  ezcWorkflowDatabaseUtil::unserialize( $node['node_configuration'], '' )
                );

                $nodes[$node['node_id']]->setId( $node['node_id'] );

                if ( $node['node_class'] == 'ezcWorkflowNodeStart' )
                {
                    $startNode = $nodes[$node['node_id']];
                }

                else if ( $node['node_class'] == 'ezcWorkflowNodeEnd' &&
                          !isset( $defaultEndNode ) )
                {
                    $defaultEndNode = $nodes[$node['node_id']];
                }
            }

            // Connect node objects.
            $query = $this->db->createSelectQuery();

            $query->select( $query->alias( 'node_connection.incoming_node_id',
                                           'incoming_node_id' ) )
                  ->select( $query->alias( 'node_connection.outgoing_node_id',
                                           'outgoing_node_id' ) )
                  ->from( $query->innerJoin( 'node_connection',
                                             'node',
                                             'node_connection.incoming_node_id',
                                             'node.node_id' ) )
                  ->where( $query->expr->eq( 'node.workflow_id',
                                              $query->bindValue( $workflowId ) ) );

            $stmt = $query->prepare();
            $stmt->execute();

            $connections = $stmt->fetchAll( PDO::FETCH_ASSOC );

            if ( $connections !== false )
            {
                foreach ( $connections as $connection )
                {
                    $nodes[$connection['incoming_node_id']]->addOutNode(
                        $nodes[$connection['outgoing_node_id']]
                    );
                }
            }
            else
            {
                throw new ezcWorkflowDefinitionException(
                    'Could not load workflow definition.'
                );
            }

            // Create workflow object and add the node objects to it.
            $workflow = new ezcWorkflow( $workflowName, $startNode, $defaultEndNode );
            $workflow->definitionHandler = $this;
            $workflow->id = (int)$workflowId;
            $workflow->version = (int)$workflowVersion;

            // Query the database for the variable handlers.
            $query = $this->db->createSelectQuery();

            $query->select( 'variable, class' )
                  ->from( 'variable_handler' )
                  ->where( $query->expr->eq( 'workflow_id',
                                              $query->bindValue( $workflowId ) ) );

            $stmt = $query->prepare();
            $stmt->execute();

            $result = $stmt->fetchAll( PDO::FETCH_ASSOC );
            $nodes  = array();

            if ( $result !== false )
            {
                foreach ( $result as $variableHandler )
                {
                    $workflow->addVariableHandler(
                      $variableHandler['variable'],
                      $variableHandler['class']
                    );
                }
            }

            // Verify the loaded workflow.
            $workflow->verify();

            return $workflow;
        }
        else
        {
            throw new ezcWorkflowDefinitionException(
              'Could not load workflow definition.'
            );
        }
    }

    /**
     * Load a workflow definition by name.
     *
     * @param  string  $workflowName
     * @param  integer $workflowVersion
     * @return ezcWorkflow
     * @throws ezcWorkflowDefinitionException
     * @throws ezcDbException
     */
    public function loadByName( $workflowName, $workflowVersion = 0 )
    {
        // Query the database for the workflow ID.
        $query = $this->db->createSelectQuery();

        // Load the current version of the workflow.
        if ( $workflowVersion == 0 )
        {
            $workflowVersion = $this->getCurrentVersionNumber( $workflowName );
        }

        // Query for the workflow_id.
        $query->select( 'workflow_id' )
              ->from( 'workflow' )
              ->where( $query->expr->eq( 'workflow_name',
                                          $query->bindValue( $workflowName ) ) )
              ->where( $query->expr->eq( 'workflow_version',
                                         $query->bindValue( $workflowVersion ) ) );

        $stmt = $query->prepare();
        $stmt->execute();

        $result = $stmt->fetchAll( PDO::FETCH_ASSOC );

        if ( $result !== false && isset( $result[0] ) )
        {
            return $this->loadById(
              $result[0]['workflow_id'],
              $workflowName,
              $workflowVersion
            );
        }
        else
        {
            throw new ezcWorkflowDefinitionException(
              'Could not load workflow definition.'
            );
        }
    }

    /**
     * Save a workflow definition to the database.
     *
     * @param  ezcWorkflow $workflow
     * @throws ezcWorkflowDefinitionException
     * @throws ezcDbException
     */
    public function save( ezcWorkflow $workflow )
    {
        // Verify the workflow.
        $workflow->verify();

        $this->db->beginTransaction();

        // Calculate new version number.
        $workflowVersion = $this->getCurrentVersionNumber( $workflow->name ) + 1;

        // Write workflow table row.
        $query = $this->db->createInsertQuery();

        $query->insertInto( 'workflow' )
              ->set( 'workflow_name', $query->bindValue( $workflow->name ) )
              ->set( 'workflow_version', $query->bindValue( $workflowVersion ) )
              ->set( 'workflow_created', $query->bindValue( time() ) );

        $statement = $query->prepare();
        $statement->execute();

        $workflow->definitionHandler = $this;
        $workflow->id = (int)$this->db->lastInsertId();
        $workflow->version = (int)$workflowVersion;

        // Write node table rows.
        foreach ( $workflow->nodes as $node )
        {
            $query = $this->db->createInsertQuery();

            $query->insertInto( 'node' )
                  ->set( 'workflow_id', $workflow->id )
                  ->set( 'node_class', $query->bindValue( get_class( $node ) ) )
                  ->set( 'node_configuration', $query->bindValue(
                    ezcWorkflowDatabaseUtil::serialize( $node->getConfiguration() ) )
                  );

            $statement = $query->prepare();
            $statement->execute();

            $node->setId( $this->db->lastInsertId() );
        }

        // Connect node table rows.
        foreach ( $workflow->nodes as $node )
        {
            foreach ( $node->getOutNodes() as $outNode )
            {
                $query = $this->db->createInsertQuery();

                $query->insertInto( 'node_connection' )
                      ->set( 'incoming_node_id', $query->bindValue( $node->getId() ) )
                      ->set( 'outgoing_node_id', $query->bindValue( $outNode->getId() ) );

                $statement = $query->prepare();
                $statement->execute();
            }
        }

        // Write variable handler rows.
        foreach ( $workflow->getVariableHandlers() as $variable => $class )
        {
            $query = $this->db->createInsertQuery();

            $query->insertInto( 'variable_handler' )
                  ->set( 'workflow_id', $query->bindValue( $workflow->id ) )
                  ->set( 'variable', $query->bindValue( $variable ) )
                  ->set( 'class', $query->bindValue( $class ) );

            $statement = $query->prepare();
            $statement->execute();
        }

        $this->db->commit();
    }

    /**
     * Returns the current version number for a given workflow name.
     *
     * @param  string $workflowName
     * @return integer
     * @throws ezcDbException
     */
    protected function getCurrentVersionNumber( $workflowName )
    {
        $query = $this->db->createSelectQuery();

        $query->select( $query->alias( $query->expr->max( 'workflow_version' ),
                                       'version' ) )
              ->from( 'workflow' )
              ->where( $query->expr->eq( 'workflow_name',
                                          $query->bindValue( $workflowName ) ) );

        $stmt = $query->prepare();
        $stmt->execute();

        $result = $stmt->fetchAll( PDO::FETCH_ASSOC );

        if ( $result !== false && isset( $result[0]['version'] ) && $result[0]['version'] !== null )
        {
            return $result[0]['version'];
        }
        else
        {
            return 0;
        }
    }
}
?>
