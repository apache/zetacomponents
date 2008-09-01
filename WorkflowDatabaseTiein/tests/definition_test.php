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

    public function testSaveAndLoadStartEnd()
    {
        $this->setUpStartEnd();
        $this->definition->save( $this->workflow );
        $workflow = $this->definition->loadByName( 'StartEnd' );

        $this->assertEquals( $this->workflow, $workflow );
    }

    public function testSaveAndLoadStartEnd2()
    {
        $this->setUpStartEnd();
        $this->definition->save( $this->workflow );
        $workflow = $this->definition->loadByName( 'StartEnd' );

        $this->assertEquals( $this->workflow, $workflow );

        $this->definition->save( $workflow );
    }

    public function testSaveAndLoadStartEndVariableHandler()
    {
        $this->setUpStartEndVariableHandler();
        $this->definition->save( $this->workflow );
        $workflow = $this->definition->loadByName( 'StartEndVariableHandler' );

        $this->assertEquals( $this->workflow, $workflow );
    }

    public function testSaveAndLoadStartInputEnd()
    {
        $this->setUpStartInputEnd();
        $this->definition->save( $this->workflow );
        $workflow = $this->definition->loadByName( 'StartInputEnd' );

        $this->assertEquals( $this->workflow, $workflow );
    }

    public function testSaveAndLoadStartSetUnsetEnd()
    {
        $this->setUpStartSetUnsetEnd();
        $this->definition->save( $this->workflow );
        $workflow = $this->definition->loadByName( 'StartSetUnsetEnd' );

        $this->assertEquals( $this->workflow, $workflow );
    }

    public function testSaveAndLoadIncrementingLoop()
    {
        $this->setUpLoop( 'increment' );
        $this->definition->save( $this->workflow );
        $workflow = $this->definition->loadByName( 'IncrementingLoop' );

        $this->assertEquals( $this->workflow, $workflow, '', 0, 5 );
    }

    public function testSaveAndLoadDecrementingLoop()
    {
        $this->setUpLoop( 'decrement' );
        $this->definition->save( $this->workflow );
        $workflow = $this->definition->loadByName( 'DecrementingLoop' );

        $this->assertEquals( $this->workflow, $workflow, '', 0, 5 );
    }

    public function testSaveAndLoadSetAddSubMulDiv()
    {
        $this->setUpSetAddSubMulDiv();
        $this->definition->save( $this->workflow );
        $workflow = $this->definition->loadByName( 'SetAddSubMulDiv' );

        $this->assertEquals( $this->workflow, $workflow );
    }

    public function testSaveAndLoadParallelSplitSynchronization()
    {
        $this->setUpParallelSplitSynchronization();
        $this->definition->save( $this->workflow );
        $workflow = $this->definition->loadByName( 'ParallelSplitSynchronization' );

        $this->assertEquals( $this->workflow, $workflow, '', 0, 5 );
    }

    public function testSaveAndLoadExclusiveChoiceSimpleMerge()
    {
        $this->setUpExclusiveChoiceSimpleMerge();
        $this->definition->save( $this->workflow );
        $workflow = $this->definition->loadByName( 'ExclusiveChoiceSimpleMerge' );

        $this->assertEquals( $this->workflow, $workflow, '', 0, 5 );
    }

    public function testSaveAndLoadExclusiveChoiceWithElseSimpleMerge()
    {
        $this->setUpExclusiveChoiceWithElseSimpleMerge();
        $this->definition->save( $this->workflow );
        $workflow = $this->definition->loadByName( 'ExclusiveChoiceWithElseSimpleMerge' );

        $this->assertEquals( $this->workflow, $workflow, '', 0, 5 );
    }

    public function testSaveAndLoadWorkflowWithFinalActivitiesAfterCancellation()
    {
        $this->setUpWorkflowWithFinalActivitiesAfterCancellation();
        $this->definition->save( $this->workflow );
        $workflow = $this->definition->loadByName( 'WorkflowWithFinalActivitiesAfterCancellation' );

        $this->assertEquals( $this->workflow, $workflow );
    }

    /**
     * @expectedException ezcWorkflowDefinitionStorageException
     */
    public function testExceptionWhenLoadingNotExistingWorkflow()
    {
        $this->definition->loadById( 1 );
    }

    /**
     * @expectedException ezcWorkflowDefinitionStorageException
     */
    public function testExceptionWhenLoadingNotExistingWorkflow2()
    {
        $this->definition->loadByName( 'NotExisting' );
    }

    /**
     * @expectedException ezcWorkflowDefinitionStorageException
     */
    public function testExceptionWhenLoadingNotExistingWorkflowVersion()
    {
        $this->setUpStartEnd();
        $this->definition->save( $this->workflow );

        $workflow = $this->definition->loadByName( 'StartEnd', 2 );
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
            $this->definition->loadByName( 'NotValid' );
        }
        catch ( ezcWorkflowDefinitionStorageException $e )
        {
            $this->assertEquals( 'Could not load workflow definition.', $e->getMessage() );
        }
    }

    public function testProperties()
    {
        $this->assertTrue(isset($this->definition->options));
        $this->assertFalse(isset($this->definition->foo));
    }

    /**
     * @expectedException ezcBaseValueException
     */
    public function testProperties2()
    {
        $options = new ezcWorkflowDatabaseOptions;
        $this->definition->options = $options;

        $this->assertSame( $options, $this->definition->options );

        $this->definition->options = new StdClass;
    }

    /**
     * @expectedException ezcBasePropertyNotFoundException
     */
    public function testProperties3()
    {
        $foo = $this->definition->foo;
    }

    /**
     * @expectedException ezcBasePropertyNotFoundException
     */
    public function testProperties4()
    {
        $this->definition->foo = null;
    }
}
?>
