<?php
/**
 * @package WorkflowDatabaseTiein
 * @subpackage Tests
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

require_once 'case.php';

/**
 * @package WorkflowDatabaseTiein
 * @subpackage Tests
 */
class ezcWorkflowDatabaseTieinDefinitionTest extends ezcWorkflowDatabaseTieinTestCase
{
    public static function suite()
    {
        return new PHPUnit_Framework_TestSuite(
          'ezcWorkflowDatabaseTieinDefinitionTest'
        );
    }

    /**
     * @dataProvider workflowNameProvider
     */
    public function testSaveAndLoadWorkflow($workflowName)
    {
        $xmlWorkflow = $this->xmlStorage->loadByName( $workflowName );
        #$xmlWorkflow->reset();

        $this->dbStorage->save( $xmlWorkflow );
        $dbWorkflow = $this->dbStorage->loadByName( $workflowName );

        $this->assertEquals( $xmlWorkflow, $dbWorkflow );
    }

    public function testExceptionWhenLoadingNotExistingWorkflow()
    {
        try
        {
            $this->dbStorage->loadById( 1 );
        }
        catch ( ezcWorkflowDefinitionStorageException $e )
        {
            $this->assertEquals( 'Could not load workflow definition.', $e->getMessage() );
            return;
        }

        $this->fail( 'Expected an ezcWorkflowDefinitionStorageException to be thrown.' );
    }

    public function testExceptionWhenLoadingNotExistingWorkflow2()
    {
        try
        {
            $this->dbStorage->loadByName( 'NotExisting' );
        }
        catch ( ezcWorkflowDefinitionStorageException $e )
        {
            $this->assertEquals( 'Could not load workflow definition.', $e->getMessage() );
            return;
        }

        $this->fail( 'Expected an ezcWorkflowDefinitionStorageException to be thrown.' );
    }

    public function testExceptionWhenLoadingNotExistingWorkflowVersion()
    {
        $this->setUpStartEnd();
        $this->dbStorage->save( $this->workflow );

        try
        {
            $workflow = $this->dbStorage->loadByName( 'StartEnd', 2 );
        }
        catch ( ezcWorkflowDefinitionStorageException $e )
        {
            $this->assertEquals( 'Could not load workflow definition.', $e->getMessage() );
            return;
        }

        $this->fail( 'Expected an ezcWorkflowDefinitionStorageException to be thrown.' );
    }

    public function testExceptionWhenLoadingNotValidWorkflow()
    {
        $query = $this->db->createInsertQuery();
        $query->insertInto( $this->db->quoteIdentifier( 'workflow' ) )
              ->set( $this->db->quoteIdentifier( 'workflow_name' ), $query->bindValue( 'NotValid' ) )
              ->set( $this->db->quoteIdentifier( 'workflow_version' ), $query->bindValue( 1 ) )
              ->set( $this->db->quoteIdentifier( 'workflow_created' ), $query->bindValue( time() ) );

        $statement = $query->prepare();
        $statement->execute();

        $query = $this->db->createInsertQuery();
        $query->insertInto( $this->db->quoteIdentifier( 'node' ) )
              ->set( $this->db->quoteIdentifier( 'node_class' ), $query->bindValue( 'ezcWorkflowNodeStart' ) )
              ->set( $this->db->quoteIdentifier( 'node_configuration' ), $query->bindValue( '' ) )
              ->set( $this->db->quoteIdentifier( 'node_id' ), $query->bindValue( 1 ) )
              ->set( $this->db->quoteIdentifier( 'workflow_id' ), $query->bindValue( 1 ) );

        $statement = $query->prepare();
        $statement->execute();

        $query = $this->db->createInsertQuery();
        $query->insertInto( $this->db->quoteIdentifier( 'node_connection' ) )
              ->set( $this->db->quoteIdentifier( 'incoming_node_id' ), $query->bindValue( 1 ) )
              ->set( $this->db->quoteIdentifier( 'outgoing_node_id' ), $query->bindValue( 2 ) );

        $statement = $query->prepare();
        $statement->execute();

        try
        {
            $this->dbStorage->loadByName( 'NotValid' );
        }
        catch ( ezcWorkflowDefinitionStorageException $e )
        {
            $this->assertEquals( 'Could not load workflow definition.', $e->getMessage() );
            return;
        }

        $this->fail( 'Expected an ezcWorkflowDefinitionStorageException to be thrown.' );
    }

    public function testProperties()
    {
        $this->assertTrue(isset($this->dbStorage->options));
        $this->assertFalse(isset($this->dbStorage->foo));
    }

    public function testProperties2()
    {
        $options = new ezcWorkflowDatabaseOptions;
        $this->dbStorage->options = $options;

        $this->assertSame( $options, $this->dbStorage->options );

        try
        {
            $this->dbStorage->options = new StdClass;
        }
        catch ( ezcBaseValueException $e )
        {
            $this->assertEquals( 'The value \'O:8:"stdClass":0:{}\' that you were trying to assign to setting \'options\' is invalid. Allowed values are: ezcWorkflowDatabaseOptions.', $e->getMessage() );
            return;
        }

        $this->fail( 'Expected an ezcBaseValueException to be thrown.' );
    }

    public function testProperties3()
    {
        try
        {
            $foo = $this->dbStorage->foo;
        }
        catch ( ezcBasePropertyNotFoundException $e )
        {
            $this->assertEquals( 'No such property name \'foo\'.', $e->getMessage() );
            return;
        }

        $this->fail( 'Expected an ezcBasePropertyNotFoundException to be thrown.' );
    }

    public function testProperties4()
    {
        try
        {
            $this->dbStorage->foo = null;
        }
        catch ( ezcBasePropertyNotFoundException $e )
        {
            $this->assertEquals( 'No such property name \'foo\'.', $e->getMessage() );
            return;
        }

        $this->fail( 'Expected an ezcBasePropertyNotFoundException to be thrown.' );
    }
}
?>
