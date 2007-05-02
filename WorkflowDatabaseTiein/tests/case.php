<?php
/**
 * @package WorkflowDatabaseTiein
 * @subpackage Tests
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

ezcTestRunner::addFileToFilter( __FILE__ );

require_once 'Workflow/tests/case.php';

/**
 * @package WorkflowDatabaseTiein
 * @subpackage Tests
 */
abstract class ezcWorkflowDatabaseTieinTestCase extends ezcWorkflowTestCase
{
    protected $db;
    protected $definition;

    protected function setUp()
    {
        parent::setUp();

        try
        {
            $this->db = ezcDbInstance::get();

            $this->cleanupTables( $this->db );

            $schema = ezcDbSchema::createFromFile(
              'array',
              dirname( __FILE__ ) . '/workflow.dba'
            );

            $schema->writeToDb( $this->db );
        }
        catch ( Exception $e )
        {
            $this->markTestSkipped( 'No test database has been configured.' );
        }

        $this->definition = new ezcWorkflowDatabaseDefinition( $this->db );
    }

    protected function tearDown()
    {
        if ( $this->db !== null )
        {
            $this->cleanupTables();
        }

        $this->db = null;
        $this->definition = null;
    }

    protected function cleanupTables()
    {
        $this->db->exec( 'DROP TABLE IF EXISTS workflow;' );
        $this->db->exec( 'DROP TABLE IF EXISTS node;' );
        $this->db->exec( 'DROP TABLE IF EXISTS node_connection;' );
        $this->db->exec( 'DROP TABLE IF EXISTS execution_data_handler;' );
        $this->db->exec( 'DROP TABLE IF EXISTS execution;' );
        $this->db->exec( 'DROP TABLE IF EXISTS execution_state;' );
    }
}
?>
