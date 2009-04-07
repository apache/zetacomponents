<?php
/**
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package PersistentObject
 * @subpackage Tests
 */

require_once 'persistent_session_test.php';

/**
 * Tests the load facilities of ezcPersistentSession.
 *
 * @package PersistentObject
 * @subpackage Tests
 */
class ezcPersistentSessionLoadTest extends ezcPersistentSessionTest
{
    public static function suite()
    {
        return new PHPUnit_Framework_TestSuite( __CLASS__ );
    }

    // loadIfExists

    public function testLoadIfExistsValid()
    {
        $object = $this->session->loadIfExists( 'PersistentTestObject', 1 );
        $this->assertEquals( 'PersistentTestObject', get_class( $object ) );
    }

    public function testLoadIfExistsInvalid()
    {
        $object = $this->session->loadIfExists( 'NoSuchClass', 1 );
        $this->assertEquals( null, $object );
    }

    public function testLoadIfExistsNoSuchObject()
    {
        $object = $this->session->loadIfExists( 'PersistentTestObject', 999 );
        $this->assertEquals( null, $object );
    }

    // load

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

    public function testConversionOnLoad()
    {
        $q = $this->session->createFindQuery( 'PersistentTestObjectConverter' );
        $q->where(
            $q->expr->eq( 
                $this->session->database->quoteIdentifier( 'type_varchar' ),
                $q->bindValue( 'Germany' )
            )
        );
        $arr = $this->session->find( $q, 'PersistentTestObjectConverter' );

        $this->assertEquals(
            1,
            count( $arr )
        );
        $this->assertNotNull(
            $arr[4]
        );

        $this->assertType(
            'DateTime',
            $arr[4]->integer
        );

        $this->assertEquals(
            '82443000',
            $arr[4]->integer->format( 'U' )
        );
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
}

?>
