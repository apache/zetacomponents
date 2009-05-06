<?php
/**
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package PersistentObject
 * @subpackage Tests
 */

require_once 'test_case.php';

/**
 * Tests the save facilities of ezcPersistentSession.
 *
 * @package PersistentObject
 * @subpackage Tests
 */
class ezcPersistentSessionSaveTest extends ezcPersistentSessionTest
{
    public static function suite()
    {
        return new PHPUnit_Framework_TestSuite( __CLASS__ );
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

    public function testUpdateNotInDatabase()
    {
        try
        {
            $this->session->update( new PersistentTestObject() );
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

        $this->session->save( $obj );

        $q = $this->session->createFindQuery( 'PersistentTestObjectConverter' );
        $q->where(
            $q->expr->eq( 
                $this->session->database->quoteIdentifier( 'type_varchar' ),
                $q->bindValue( 'Foo Bar' )
            )
        );
        $arr = $this->session->find( $q, 'PersistentTestObjectConverter' );

        $this->assertEquals(
            1,
            count( $arr )
        );
        $this->assertTrue( isset( $arr[5] ) );

        $this->assertNull(
            $arr[5]->integer
        );

        $arr[5]->integer = new DateTime( '@327535200' );

        $this->session->update( $arr[5] );
        
        $q = $this->session->createFindQuery( 'PersistentTestObjectConverter' );
        $q->where(
            $q->expr->eq( 
                $this->session->database->quoteIdentifier( 'type_varchar' ),
                $q->bindValue( 'Foo Bar' )
            )
        );
        $arr = $this->session->find( $q, 'PersistentTestObjectConverter' );

        $this->assertEquals(
            1,
            count( $arr )
        );
        $this->assertTrue( isset( $arr[5] ) );

        $this->assertType(
            'DateTime',
            $arr[5]->integer
        );

        $this->assertEquals(
            '327535200',
            $arr[5]->integer->format( 'U' )
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

        $this->session->save( $obj );
        
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

        $this->session->save( $obj );

        $q = $this->session->createFindQuery( 'PersistentTestObjectConverter' );
        $q->where(
            $q->expr->eq( 
                $this->session->database->quoteIdentifier( 'type_varchar' ),
                $q->bindValue( 'Foo Bar' )
            )
        );
        $arr = $this->session->find( $q, 'PersistentTestObjectConverter' );

        $this->assertEquals(
            1,
            count( $arr )
        );
        $this->assertTrue( isset( $arr[5] ) );
        
        $this->assertType(
            'DateTime',
            $arr[5]->integer
        );

        $this->assertEquals(
            '327535200',
            $arr[5]->integer->format( 'U' )
        );

        $arr[5]->integer = null;

        $this->session->update( $arr[5] );
        
        $q = $this->session->createFindQuery( 'PersistentTestObjectConverter' );
        $q->where(
            $q->expr->eq( 
                $this->session->database->quoteIdentifier( 'type_varchar' ),
                $q->bindValue( 'Foo Bar' )
            )
        );
        $arr = $this->session->find( $q, 'PersistentTestObjectConverter' );

        $this->assertEquals(
            1,
            count( $arr )
        );
        $this->assertTrue( isset( $arr[5] ) );

        $this->assertNull(
            $arr[5]->integer
        );
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

    public function testSaveInvalidObject()
    {
        try
        {
            $this->session->save( new Exception() );
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

    public function testConversionOnSave()
    {
        $obj = new PersistentTestObjectConverter();

        $obj->varchar = 'Foo Bar';
        $obj->integer = new DateTime( '@327535200' );
        $obj->decimal = 23.42;
        $obj->text    = 'Foo Bar Baz';

        $this->session->save( $obj );

        $q = $this->session->createFindQuery( 'PersistentTestObjectConverter' );
        $q->where(
            $q->expr->eq( 
                $this->session->database->quoteIdentifier( 'type_varchar' ),
                $q->bindValue( 'Foo Bar' )
            )
        );
        $arr = $this->session->find( $q, 'PersistentTestObjectConverter' );

        $this->assertEquals(
            1,
            count( $arr )
        );
        $this->assertTrue( isset( $arr[5] ) );

        $this->assertType(
            'DateTime',
            $arr[5]->integer
        );

        $this->assertEquals(
            '327535200',
            $arr[5]->integer->format( 'U' )
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

        $this->session->save( $obj );

        $q = $this->session->createFindQuery( 'PersistentTestObjectConverter' );
        $q->where(
            $q->expr->eq( 
                $this->session->database->quoteIdentifier( 'type_varchar' ),
                $q->bindValue( 'Foo Bar' )
            )
        );
        $arr = $this->session->find( $q, 'PersistentTestObjectConverter' );

        $this->assertEquals(
            1,
            count( $arr )
        );
        $this->assertTrue( isset( $arr[5] ) );

        $this->assertNull(
            $arr[5]->integer
        );
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

    public function testSaveOrUpdateInvalidObject()
    {
        try
        {
            $this->session->saveOrUpdate( new Exception() );
            $this->fail( "SaveorUpdate of non-persistent object did not throw exception" );
        }
        catch ( ezcPersistentDefinitionNotFoundException $e ) {}
    }

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
    
    // misc
     
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
