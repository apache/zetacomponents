<?php
/**
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package PersistentObject
 * @subpackage Tests
 */

require_once 'persistent_identity_session_test.php';

/**
 * Tests the save facilities of ezcPersistentSession.
 *
 * @package PersistentObject
 * @subpackage Tests
 */
class ezcPersistentIdentitySessionSaveTest extends ezcPersistentIdentitySessionTest
{
    public static function suite()
    {
        return new PHPUnit_Framework_TestSuite( __CLASS__ );
    }

    // update
    
    public function testUpdateValid()
    {
        $object = $this->idSession->loadIfExists( 'PersistentTestObject', 1 );
        $this->assertEquals( 'PersistentTestObject', get_class( $object ) );
        $object->varchar = 'Finland';
        $object->integer = 42;
        $object->decimal = 1.42;
        $object->text = "Finland has Nokia!";
        $this->idSession->update( $object );

        // check that we got the correct values
        $object2 = $this->idSession->loadIfExists( 'PersistentTestObject', 1 );

        $this->assertSame( $object, $object2 );
    }

    public function testUpdateInvalidObject()
    {
        try
        {
            $this->idSession->update( new Exception() );
            $this->fail( "Update of non-persistent object did not throw exception" );
        }
        catch ( ezcPersistentObjectException $e ) {}
    }

    public function testUpdateNotInDatabase()
    {
        try
        {
            $this->idSession->update( new PersistentTestObject() );
            $this->fail( "Update of object not in database did not fail." );
        }
        catch ( ezcPersistentObjectNotPersistentException $e ) {}
    }

    public function testConversionOnUpdate()
    {
        $obj = new PersistentTestObjectConverter();

        $obj->varchar = 'Foo Bar';
        // Leave null
        // $obj->integer = new DateTime( '@327535200' );
        $obj->decimal = 23.42;
        $obj->text    = 'Foo Bar Baz';

        $this->idSession->save( $obj );

        $q = $this->idSession->createFindQuery( 'PersistentTestObjectConverter' );
        $q->where(
            $q->expr->eq( 
                $this->idSession->database->quoteIdentifier( 'type_varchar' ),
                $q->bindValue( 'Foo Bar' )
            )
        );
        $arr = $this->idSession->find( $q, 'PersistentTestObjectConverter' );

        $this->assertEquals(
            1,
            count( $arr )
        );

        $this->assertNull(
            $arr[0]->integer
        );

        $arr[0]->integer = new DateTime( '@327535200' );

        $this->idSession->update( $arr[0] );
        
        $q = $this->idSession->createFindQuery( 'PersistentTestObjectConverter' );
        $q->where(
            $q->expr->eq( 
                $this->idSession->database->quoteIdentifier( 'type_varchar' ),
                $q->bindValue( 'Foo Bar' )
            )
        );
        $arr = $this->idSession->find( $q, 'PersistentTestObjectConverter' );

        $this->assertEquals(
            1,
            count( $arr )
        );

        $this->assertType(
            'DateTime',
            $arr[0]->integer
        );

        $this->assertEquals(
            '327535200',
            $arr[0]->integer->format( 'U' )
        );
    }

    public function testConversionNotBreaksState()
    {
        $date = new DateTime( '@327535200' );

        $obj = new PersistentTestObjectConverter();

        $obj->varchar = 'Foo Bar';
        $obj->integer = $date;
        $obj->decimal = 23.42;
        $obj->text    = 'Foo Bar Baz';

        $this->idSession->save( $obj );
        
        $this->assertSame(
            $date,
            $obj->integer
        );
    }
    
    public function testNoConversionOnUpdate()
    {
        $obj = new PersistentTestObjectConverter();

        $obj->varchar = 'Foo Bar';
        $obj->integer = new DateTime( '@327535200' );
        $obj->decimal = 23.42;
        $obj->text    = 'Foo Bar Baz';

        $this->idSession->save( $obj );

        $q = $this->idSession->createFindQuery( 'PersistentTestObjectConverter' );
        $q->where(
            $q->expr->eq( 
                $this->idSession->database->quoteIdentifier( 'type_varchar' ),
                $q->bindValue( 'Foo Bar' )
            )
        );
        $arr = $this->idSession->find( $q, 'PersistentTestObjectConverter' );

        $this->assertEquals(
            1,
            count( $arr )
        );

        $this->assertType(
            'DateTime',
            $arr[0]->integer
        );

        $this->assertEquals(
            '327535200',
            $arr[0]->integer->format( 'U' )
        );

        $arr[0]->integer = null;

        $this->idSession->update( $arr[0] );
        
        $q = $this->idSession->createFindQuery( 'PersistentTestObjectConverter' );
        $q->where(
            $q->expr->eq( 
                $this->idSession->database->quoteIdentifier( 'type_varchar' ),
                $q->bindValue( 'Foo Bar' )
            )
        );
        $arr = $this->idSession->find( $q, 'PersistentTestObjectConverter' );

        $this->assertEquals(
            1,
            count( $arr )
        );

        $this->assertNull(
            $arr[0]->integer
        );
    }

    // save

    public function testSaveValid()
    {
        $object          = new PersistentTestObject();
        $object->varchar = 'Finland';
        $object->integer = 42;
        $object->decimal = 1.42;
        $object->text    = "Finland has Nokia!";

        $this->idSession->save( $object );

        $this->assertEquals( 5, $object->id );

        $object2 = $this->idSession->loadIfExists( 'PersistentTestObject', 5 );

        $this->assertSame( $object, $object2 );
    }

    public function testSaveInvalidObject()
    {
        try
        {
            $this->idSession->save( new Exception() );
            $this->fail( "Save of non-persistent object did not throw exception" );
        }
        catch ( ezcPersistentDefinitionNotFoundException $e ) {}
    }

    public function testSaveAlreadyInDatabase()
    {
        $object = new PersistentTestObject();
        $object->varchar = 'Finland';
        $object->integer = 42;
        $object->decimal = 1.42;
        $object->text = "Finland has Nokia!";
        $this->idSession->save( $object );

        try
        {
            $this->idSession->save( $object );
            $this->fail( "Save of object already saved did not fail." );
        }
        catch ( ezcPersistentObjectAlreadyPersistentException $e ) {};
    }

    public function testMissingIdProperty()
    {
        $object          = new PersistentTestObjectNoId();
        $object->varchar = 'Finland';
        $object->integer = 42;
        $object->decimal = 1.42;
        $object->text    = "Finland has Nokia!";

        try
        {
            $this->idSession->save( $object );
        }
        catch ( ezcPersistentDefinitionMissingIdPropertyException $e )
        {
            return;
        }
        $this->fail( "Exception not thrown on missing ID property." );
    }

    public function testConversionOnSave()
    {
        $obj = new PersistentTestObjectConverter();

        $obj->varchar = 'Foo Bar';
        $obj->integer = new DateTime( '@327535200' );
        $obj->decimal = 23.42;
        $obj->text    = 'Foo Bar Baz';

        $this->idSession->save( $obj );

        $q = $this->idSession->createFindQuery( 'PersistentTestObjectConverter' );
        $q->where(
            $q->expr->eq( 
                $this->idSession->database->quoteIdentifier( 'type_varchar' ),
                $q->bindValue( 'Foo Bar' )
            )
        );
        $arr = $this->idSession->find( $q, 'PersistentTestObjectConverter' );

        $this->assertEquals(
            1,
            count( $arr )
        );

        $this->assertType(
            'DateTime',
            $arr[0]->integer
        );

        $this->assertEquals(
            '327535200',
            $arr[0]->integer->format( 'U' )
        );
    }

    public function testNoConversionOnSave()
    {
        $obj = new PersistentTestObjectConverter();

        $obj->varchar = 'Foo Bar';
        // Leave null
        // $obj->integer = new DateTime( '@327535200' );
        $obj->decimal = 23.42;
        $obj->text    = 'Foo Bar Baz';

        $this->idSession->save( $obj );

        $q = $this->idSession->createFindQuery( 'PersistentTestObjectConverter' );
        $q->where(
            $q->expr->eq( 
                $this->idSession->database->quoteIdentifier( 'type_varchar' ),
                $q->bindValue( 'Foo Bar' )
            )
        );
        $arr = $this->idSession->find( $q, 'PersistentTestObjectConverter' );

        $this->assertEquals(
            1,
            count( $arr )
        );

        $this->assertNull(
            $arr[0]->integer
        );
    }

    // Save or update

    public function testSaveOrUpdateSave()
    {
        $object          = new PersistentTestObject();
        $object->varchar = 'Finland';
        $object->integer = 42;
        $object->decimal = 1.42;
        $object->text    = "Finland has Nokia!";

        $this->idSession->saveOrUpdate( $object );

        $this->assertEquals( 5, $object->id );

        $object2 = $this->idSession->loadIfExists( 'PersistentTestObject', 5 );

        $this->assertSame( $object, $object2 );
    }

    public function testSaveOrUpdateUpdate()
    {
        $object = $this->idSession->loadIfExists( 'PersistentTestObject', 1 );
        $this->assertEquals( 'PersistentTestObject', get_class( $object ) );

        $object->varchar = 'Finland';
        $object->integer = 42;
        $object->decimal = 1.42;
        $object->text    = "Finland has Nokia!";

        $this->idSession->saveOrUpdate( $object );

        $object2 = $this->idSession->loadIfExists( 'PersistentTestObject', 1 );

        $this->assertSame( $object, $object2 );
    }

    public function testSaveOrUpdateInvalidObject()
    {
        try
        {
            $this->idSession->saveOrUpdate( new Exception() );
            $this->fail( "SaveorUpdate of non-persistent object did not throw exception" );
        }
        catch ( ezcPersistentDefinitionNotFoundException $e ) {}
    }
}

?>
