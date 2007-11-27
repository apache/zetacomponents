<?php
/**
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package PersistentObject
 * @subpackage Tests
 */

require_once "data/persistent_test_object.php";
require_once "data/persistent_test_object_no_id.php";

/**
 * Tests the code manager.
 *
 * @package PersistentObject
 * @subpackage Tests
 */
class ezcPersistentSessionTest extends ezcTestCase
{
    private $session = null;
    private $hasTables = false;

    protected function setUp()
    {
        try
        {
            $db = ezcDbInstance::get();
        }
        catch ( Exception $e )
        {
            $this->markTestSkipped( 'There was no database configured' );
        }

        PersistentTestObject::setupTable();
        PersistentTestObject::insertCleanData();
//        PersistentTestObject::saveSqlSchemas();
        $this->session = new ezcPersistentSession( ezcDbInstance::get(),
                                                   new ezcPersistentCodeManager( dirname( __FILE__ ) . "/data/" ) );
    }

    protected function tearDown()
    {
        PersistentTestObject::cleanup();
    }

    public static function suite()
    {
        return new PHPUnit_Framework_TestSuite( 'ezcPersistentSessionTest' );
    }

    // loadIfExists
    // 
    public function testLoadIfExistsValid()
    {
        $object = $this->session->loadIfExists( 'PersistentTestObject', 1 );
        $this->assertEquals( 'PersistentTestObject', get_class( $object ) );
    }

    // class name is not a persistent object
    public function testLoadIfExistsInvalid()
    {
        $object = $this->session->loadIfExists( 'NoSuchClass', 1 );
        $this->assertEquals( null, $object );
    }

    // no such object id
    public function testLoadIfExistsNoSuchObject()
    {
        $object = $this->session->loadIfExists( 'PersistentTestObject', 999 );
        $this->assertEquals( null, $object );
    }

    // load

    // class name is not a persistent object
    public function testLoadValid()
    {
        $object = $this->session->load( 'PersistentTestObject', "1" );
        $this->assertEquals( 'PersistentTestObject', get_class( $object ) );
    }

    public function testLoadInvalid()
    {
        try
        {
            $object = $this->session->load( 'NoSuchClass', 1 );
            $this->fail( "load() called with invalid class. Did not get an exception" );
        }
        catch ( ezcPersistentDefinitionNotFoundException $e ) {}
    }

    // no such object id
    public function testLoadNoSuchObject()
    {
        try
        {
            $object = $this->session->load( 'PersistentTestObject', 999 );
            $this->fail( "load() called with invalid object id. Did not get an exception" );
        }
        catch ( ezcPersistentQueryException $e )
        {
            $this->assertEquals(
                "A query failed internally in Persistent Object: No object of class 'PersistentTestObject' with id '999'.",
                $e->getMessage()
            );
            return;
        }
    }

    // loadIntoObject
    
    public function testLoadIntoObjectValid()
    {
        $object = new PersistentTestObject();
        $object->varchar = 'Finland';
        $object->integer = 42;
        $object->decimal = 1.42;
        $object->text = "Finland has Nokia!";
        $this->session->save( $object );
        $this->assertEquals( 5, $object->id );

        $object2 = new PersistentTestObject();
        $this->session->loadIntoObject( $object2, 5 );
        $this->assertEquals( 'Finland', $object2->varchar );
        $this->assertEquals( 42, (int)$object2->integer );
        $this->assertEquals( 1.42, (float)$object2->decimal );
        $this->assertEquals( 'Finland has Nokia!', $object2->text );
    }

    // wrong class type
    public function testLoadIntoObjectInvalid()
    {
        try
        {
            $object = $this->session->loadIntoObject( new Exception(), 1 );
            $this->fail( "loadIntoObject() called with invalid class. Did not get an exception" );
        }
        catch ( ezcPersistentDefinitionNotFoundException $e )
        {
            return;    
        }
    }

    // no such object id
    public function testLoadIntoObjectNoSuchObject()
    {
        try
        {
            $object = $this->session->loadIntoObject( new PersistentTestObject(), 999 );
            $this->fail( "loadIntoObject() called with invalid class. Did not get an exception" );
        }
        catch ( ezcPersistentQueryException $e )
        {
            $this->assertEquals(
                "A query failed internally in Persistent Object: No object of class 'PersistentTestObject' with id '999'.",
                $e->getMessage()
            );
        }
    }

    // update
    
    public function testUpdateValid()
    {
        $object = $this->session->loadIfExists( 'PersistentTestObject', 1 );
        $this->assertEquals( 'PersistentTestObject', get_class( $object ) );
        $object->varchar = 'Finland';
        $object->integer = 42;
        $object->decimal = 1.42;
        $object->text = "Finland has Nokia!";
        $this->session->update( $object );

        // check that we got the correct values
        $object2 = $this->session->loadIfExists( 'PersistentTestObject', 1 );
        $this->assertEquals( 'Finland', $object2->varchar );
        $this->assertEquals( 42, (int)$object2->integer );
        $this->assertEquals( 1.42, (float)$object2->decimal );
        $this->assertEquals( 'Finland has Nokia!', $object2->text );
    }

    // object is not a persistent object
    public function testUpdateInvalidObject()
    {
        try
        {
            $this->session->update( new Exception() );
            $this->fail( "Update of non-persistent object did not throw exception" );
        }
        catch ( ezcPersistentObjectException $e ) 
        {
        }
    }

    // object is a new persistent object
    public function testUpdateNotInDatabase()
    {
        try
        {
            $this->session->update( new PersistentTestObject() );
            $this->fail( "Update of object not in database did not fail." );
        }
        catch ( ezcPersistentObjectNotPersistentException $e ) {}
    }

    // save

    public function testSaveValid()
    {
        $object = new PersistentTestObject();
        $object->varchar = 'Finland';
        $object->integer = 42;
        $object->decimal = 1.42;
        $object->text = "Finland has Nokia!";
        $this->session->save( $object );

        $this->assertEquals( 5, $object->id );
        $object2 = $this->session->loadIfExists( 'PersistentTestObject', 5 );
        $this->assertEquals( 'Finland', $object2->varchar );
        $this->assertEquals( 42, (int)$object2->integer );
        $this->assertEquals( 1.42, (float)$object2->decimal );
        $this->assertEquals( 'Finland has Nokia!', $object2->text );
    }

    // object is not a persistent object
    public function testSaveInvalidObject()
    {
        try
        {
            $this->session->save( new Exception() );
            $this->fail( "Save of non-persistent object did not throw exception" );
        }
        catch ( ezcPersistentDefinitionNotFoundException $e ) {}
    }

    // the object is already persistent
    public function testSaveAlreadyInDatabase()
    {
        $object = new PersistentTestObject();
        $object->varchar = 'Finland';
        $object->integer = 42;
        $object->decimal = 1.42;
        $object->text = "Finland has Nokia!";
        $this->session->save( $object );

        try
        {
            $this->session->save( $object );
            $this->fail( "Save of object already saved did not fail." );
        }
        catch ( ezcPersistentObjectAlreadyPersistentException $e ) {};
    }

    public function testMissingIdProperty()
    {
        $object = new PersistentTestObjectNoId();
        $object->varchar = 'Finland';
        $object->integer = 42;
        $object->decimal = 1.42;
        $object->text = "Finland has Nokia!";
        try
        {
            $this->session->save( $object );
        }
        catch ( ezcPersistentDefinitionMissingIdPropertyException $e )
        {
            return;
        }
        $this->fail( "Exception not thrown on missing ID property." );
    }

    // Save or update

    public function testSaveOrUpdateSave()
    {
        $object = new PersistentTestObject();
        $object->varchar = 'Finland';
        $object->integer = 42;
        $object->decimal = 1.42;
        $object->text = "Finland has Nokia!";
        $this->session->saveOrUpdate( $object );

        $this->assertEquals( 5, $object->id );
        $object2 = $this->session->loadIfExists( 'PersistentTestObject', 5 );
        $this->assertEquals( 'Finland', $object2->varchar );
        $this->assertEquals( 42, (int)$object2->integer );
        $this->assertEquals( 1.42, (float)$object2->decimal );
        $this->assertEquals( 'Finland has Nokia!', $object2->text );
    }

    public function testSaveOrUpdateUpdate()
    {
        $object = $this->session->loadIfExists( 'PersistentTestObject', 1 );
        $this->assertEquals( 'PersistentTestObject', get_class( $object ) );
        $object->varchar = 'Finland';
        $object->integer = 42;
        $object->decimal = 1.42;
        $object->text = "Finland has Nokia!";
        $this->session->saveOrUpdate( $object );

        // check that we got the correct values
        $object2 = $this->session->loadIfExists( 'PersistentTestObject', 1 );
        $this->assertEquals( 'Finland', $object2->varchar );
        $this->assertEquals( 42, (int)$object2->integer );
        $this->assertEquals( 1.42, (float)$object2->decimal );
        $this->assertEquals( 'Finland has Nokia!', $object2->text );
    }

    // object is not a persistent object
    public function testSaveOrUpdateInvalidObject()
    {
        try
        {
            $this->session->saveOrUpdate( new Exception() );
            $this->fail( "SaveorUpdate of non-persistent object did not throw exception" );
        }
        catch ( ezcPersistentDefinitionNotFoundException $e ) {}
    }

    // refresh

    public function testRefreshValid()
    {
        $object = new PersistentTestObject();
        $object->varchar = 'Finland';
        $object->integer = 42;
        $object->decimal = 1.42;
        $object->text = "Finland has Nokia!";
        $this->session->save( $object );

        $object->integer = 101;
        $this->session->refresh( $object );
        $this->assertEquals( 42, (int)$object->integer );
    }

    public function testRefreshInvalid()
    {
        try
        {
            $this->session->refresh( new Exception() );
            $this->fail( "refresh of non-persistent object did not throw exception" );
        }
        catch ( ezcPersistentDefinitionNotFoundException $e ) {}
    }

    public function testRefreshNotPersistent()
    {
        try
        {
            $this->session->refresh( new PersistentTestObject() );
            $this->fail( "refresh of non-persistent object did not throw exception" );
        }
        catch ( ezcPersistentObjectNotPersistentException $e ) {}
    }

    // delete

    public function testDeleteValid()
    {
        $object = new PersistentTestObject();
        $object->varchar = 'Finland';
        $object->integer = 42;
        $object->decimal = 1.42;
        $object->text = "Finland has Nokia!";
        $this->session->save( $object );
        $this->assertEquals( 5, $object->id );

        $this->session->delete( $object );
        try
        {
            $this->session->load( 'PersistentTestObject', 5 );
            $this->fail( "Fetching a deleted object did not throw exception." );
        }
        catch ( ezcPersistentQueryException $e ) 
        {
            $this->assertEquals(
                "A query failed internally in Persistent Object: No object of class 'PersistentTestObject' with id '5'.",
                $e->getMessage()
            );
        }
    }

    // not persistent class
    public function testDeleteInvalid()
    {
        try
        {
            $this->session->delete( new Exception() );
            $this->fail( "Deleting a non persistent object did not throw exception." );
        }
        catch ( ezcPersistentDefinitionNotFoundException $e ) {}
    }

    // deleting an object that is not persistent yet
    public function testDeleteNotPersistent()
    {
        try
        {
            $this->session->delete( new PersistentTestObject() );
            $this->fail( "Deleting an object that is not yet persistent did not throw exception." );
        }
        catch ( ezcPersistentObjectNotPersistentException $e ) {}
    }

    // find

    public function testFindNoResult()
    {
        $q = $this->session->createFindQuery( 'PersistentTestObject' );
        $q->where( $q->expr->eq( $this->session->database->quoteIdentifier( 'id' ), 999 ) );
        $objects = $this->session->find( $q, 'PersistentTestObject' );
        $this->assertEquals( 0, count( $objects ) );
    }

    public function testFindSingleResult()
    {
        $q = $this->session->createFindQuery( 'PersistentTestObject' );
        $q->where( $q->expr->eq( $this->session->database->quoteIdentifier( 'id' ), 1 ) );
        $objects = $this->session->find( $q, 'PersistentTestObject' );
        $this->assertEquals( 1, count( $objects ) );
    }

    public function testFindMultipleResult()
    {
        $q = $this->session->createFindQuery( 'PersistentTestObject' );
        $q->where( $q->expr->gt( $this->session->database->quoteIdentifier( 'id' ), 2 ) );
        $objects = $this->session->find( $q, 'PersistentTestObject' );
        $this->assertEquals( 2, count( $objects ) );

        // check that the data is correct
        $this->assertEquals( 'Ukraine', $objects[0]->varchar );
        $this->assertEquals( 47732079, (int)$objects[0]->integer );
        $this->assertEquals( 603.70, (float)$objects[0]->decimal );
        $this->assertEquals( 'Ukraine has a long coastline to the black see.', $objects[0]->text );

        $this->assertEquals( 'Germany', $objects[1]->varchar );
        $this->assertEquals( 82443000, (int)$objects[1]->integer );
        $this->assertEquals( 357.02, (float)$objects[1]->decimal );
        $this->assertEquals( 'Home of the lederhosen!.', $objects[1]->text );
    }

    // findIterator

    public function testFindIteratorNoResult()
    {
        $q = $this->session->createFindQuery( 'PersistentTestObject' );
        $q->where( $q->expr->eq( $this->session->database->quoteIdentifier( 'id' ), 999 ) );
        $it = $this->session->findIterator( $q, 'PersistentTestObject' );
        $this->assertEquals( null, $it->next() );
    }

    public function testFindIteratorSingleResult()
    {
        $q = $this->session->createFindQuery( 'PersistentTestObject' );
        $q->where( $q->expr->eq( $this->session->database->quoteIdentifier( 'id' ), 1 ) );
        $it = $this->session->findIterator( $q, 'PersistentTestObject' );
        $i = 0;
        foreach ( $it as $object )
        {
            ++$i;
        }
        $this->assertEquals( 1, $i );
    }

    public function testFindIteratorMultipleResult()
    {
        $q = $this->session->createFindQuery( 'PersistentTestObject' );
        $q->where( $q->expr->gt( $this->session->database->quoteIdentifier( 'id' ), 2 ) );
        $objects = $this->session->find( $q, 'PersistentTestObject' );
        $this->assertEquals( 2, count( $objects ) );

        $it = $this->session->findIterator( $q, 'PersistentTestObject' );
        $i = 0;
        foreach ( $it as $object )
        {
            ++$i;
        }
        $this->assertEquals( 2, $i );
    }

    //  deleteFromQuery

    public function testDeleteFromQuery()
    {
        $q = $this->session->createDeleteQuery( 'PersistentTestObject' );
        $q->where( $q->expr->neq( 'integer', 0 ) );
        $this->session->deleteFromQuery( $q );

        $q = $this->session->createFindQuery( 'PersistentTestObject' );
        $objects = $this->session->find( $q, 'PersistentTestObject' );
        $this->assertEquals( 0, count( $objects ) );
    }

    public function testDeleteFromQueryFail()
    {
        $q = $this->session->createDeleteQuery( 'PersistentTestObject' );
        $q->where( $q->expr->neq( 'foobar', 0 ) );
        
        try
        {
            $this->session->deleteFromQuery( $q );
            $this->fail( "ezcPersistentQueryException not thrown on invalid query." );
        }
        catch ( ezcPersistentQueryException $e )
        {
            $this->assertEquals(
                "A query failed internally in Persistent Object",
                substr( $e->getMessage(), 0, 46 )
            );
        }
    }

    // public funciton testDeleteFrom with forced error

    // updateFromQuery

    public function testUpdateFromQuery()
    {
        $q = $this->session->createUpdateQuery( 'PersistentTestObject' );
        $q->set( 'integer', 50 );
        $this->session->updateFromQuery( $q );

        // check that each value got 'integer' set to 50
        $q = $this->session->createFindQuery( 'PersistentTestObject' );
        $it = $this->session->findIterator( $q, 'PersistentTestObject' );
        foreach ( $it as $object )
        {
            $this->assertEquals( 50, (int)$object->integer );
        }
    }

    // public funciton testDeleteFrom with forced error

    // Test aliases

    public function testFindUsingAliases()
    {
        $q = $this->session->createFindQuery( 'PersistentTestObject' );
        $q->where( $q->expr->eq( 'varchar', $q->bindValue( 'Ukraine' ) ) );
        $objects = $this->session->find( $q, 'PersistentTestObject' );
        $this->assertEquals( 1, count( $objects ) );

        // check that the data is correct
        $this->assertEquals( 'Ukraine', $objects[0]->varchar );
        $this->assertEquals( 47732079, (int)$objects[0]->integer );
        $this->assertEquals( 603.70, (float)$objects[0]->decimal );
        $this->assertEquals( 'Ukraine has a long coastline to the black see.', $objects[0]->text );
    }

    public function testDatabaseProperty()
    {
        $db = ezcDbInstance::get();
        $session = new ezcPersistentSession( $db,
                                             new ezcPersistentCodeManager( dirname( __FILE__ ) . "/data/" ) );
        $this->assertSame( $db, $session->database );
        try
        {
            $session->database = $db;
            $this->fail( "Did not get exception when expected" );
        }
        catch ( ezcBasePropertyPermissionException $e )
        {
        }
    }

    public function testDefinitionManagerProperty()
    {
        $db = ezcDbInstance::get();
        $manager = new ezcPersistentCodeManager( dirname( __FILE__ ) . "/data/" );
        $session = new ezcPersistentSession( $db, $manager );
        $this->assertSame( $manager, $session->definitionManager );
        try
        {
            $session->definitionManager = $manager;
            $this->fail( "Did not get exception when expected" );
        }
        catch ( ezcBasePropertyPermissionException $e )
        {
        }
    }

    // Overloading

    public function testGetAccessFailure()
    {
        $db = ezcDbInstance::get();
        $manager = new ezcPersistentCodeManager( dirname( __FILE__ ) . "/data/" );
        $session = new ezcPersistentSession( $db, $manager );

        try
        {
            $foo = $session->non_existent;
        }
        catch ( ezcBasePropertyNotFoundException $e )
        {
            return;
        }
        $this->fail( "Exception not thrown on get access to non existent property." );
    }
    
    public function testSetAccessFailure()
    {
        $db = ezcDbInstance::get();
        $manager = new ezcPersistentCodeManager( dirname( __FILE__ ) . "/data/" );
        $session = new ezcPersistentSession( $db, $manager );

        try
        {
            $session->database = null;
            $this->fail( "Exception not thrown on set access to ezcPersistentSession->database." );
        }
        catch ( ezcBasePropertyPermissionException $e )
        {
            return;
        }

        try
        {
            $session->definitionManager = null;
            $this->fail( "Exception not thrown on set access to ezcPersistentSession->definitionManager." );
        }
        catch ( ezcBasePropertyPermissionException $e )
        {
            return;
        }

        try
        {
            $session->non_existent = null;
            $this->fail( "Exception not thrown on set access to non existent property." );
        }
        catch ( ezcBasePropertyPermissionException $e )
        {
            return;
        }
    }

    // Struct tests

    // http://ez.no/bugs/view/9189
    // http://ez.no/bugs/view/9187
    public function testPersistentObjectDefinitionStruct()
    {
        $property = new ezcPersistentObjectProperty(
            "test column",
            "test property",
            ezcPersistentObjectProperty::PHP_TYPE_INT
        );

        $generator = new ezcPersistentGeneratorDefinition(
            "test class",
            array( "param" => 123 )
        );

        $idProperty = new ezcPersistentObjectIdProperty(
            "test column",
            "test property",
            null,
            $generator
        );

        $def = new ezcPersistentObjectDefinition(
            "test table",
            "test class",
            array( 'test' => $property ),
            array(),
            $idProperty
        );

        $res = ezcPersistentObjectDefinition::__set_state(array(
           'table' => 'test table',
           'class' => 'test class',
           'idProperty' => 
          ezcPersistentObjectIdProperty::__set_state(array(
             'columnName' => 'test column',
             'propertyName' => 'test property',
             'visibility' => NULL,
             'generator' => 
            ezcPersistentGeneratorDefinition::__set_state(array(
               'class' => 'test class',
               'params' => 
              array (
                'param' => 123,
              ),
            )),
          )),
           'properties' => 
          array (
            'test' => 
            ezcPersistentObjectProperty::__set_state(array(
               'columnName' => 'test column',
               'propertyName' => 'test property',
               'propertyType' => 2,
            )),
          ),
           'columns' => 
          array (
          ),
           'relations' => 
          array (
          ),
        ));
        
        $this->assertEquals( $res, $def, "ezcPersistentObjectDefinition not deserialized correctly." );
    }
    
    public function testTablePrefixingInFindQuery()
    {
        $q = $this->session->createFindQuery( 'PersistentTestObject' );
        $q->where(
            $q->expr->eq( 'integer', $q->bindValue( 50 ) )
        );
        $sql = $q->getQuery();
        
        $this->assertNotEquals(
            false,
            strpos(
                $sql,
                $this->session->database->quoteIdentifier( 'PO_test' ) . '.' . $this->session->database->quoteIdentifier( 'type_integer' )
            )
        );
    }
    
    public function testNoTablePrefixingInDeleteQuery()
    {
        $q = $this->session->createDeleteQuery( 'PersistentTestObject' );
        $q->where(
            $q->expr->eq( 'integer', $q->bindValue( 50 ) )
        );
        $sql = $q->getQuery();
        
        $this->assertFalse(
            strpos(
                $sql,
                $this->session->database->quoteIdentifier( 'PO_test' ) . '.' . $this->session->database->quoteIdentifier( 'type_integer' )
            )
        );
    }
    
    public function testNoTablePrefixingInUpdateQuery()
    {
        $q = $this->session->createUpdateQuery( 'PersistentTestObject' );
        $q->set( 'integer', 50 );
        $sql = $q->getQuery();
        
        $this->assertFalse(
            strpos(
                $sql,
                $this->session->database->quoteIdentifier( 'PO_test' ) . '.' . $this->session->database->quoteIdentifier( 'type_integer' )
            )
        );
    }
}

?>
