<?php
/**
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
 * @package WorkflowDatabaseTiein
 * @subpackage Tests
 * @version //autogentag//
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
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
    public function testSaveAndLoadWorkflow( $workflowName )
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
