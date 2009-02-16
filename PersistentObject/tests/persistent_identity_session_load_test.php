<?php
/**
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package PersistentObject
 * @subpackage Tests
 */

require_once 'persistent_identity_session_test.php';

/**
 * Tests the load facilities of ezcPersistentSession.
 *
 * @package PersistentObject
 * @subpackage Tests
 */
class ezcPersistentSessionIdentityLoadTest extends ezcPersistentIdentitySessionTest
{
    public static function suite()
    {
        return new PHPUnit_Framework_TestSuite( __CLASS__ );
    }


    // loadIfExists

    public function testLoadIfExistsValid()
    {
        $first = $this->idSession->loadIfExists( 'PersistentTestObject', 1 );
        $this->assertEquals( 'PersistentTestObject', get_class( $first ) );

        $second = $this->idSession->loadIfExists( 'PersistentTestObject', 1 );
        $this->assertEquals( 'PersistentTestObject', get_class( $first ) );

        // Test identity
        $this->assertSame(
            $first,
            $second,
            'Object identity different on second load.'
        );
    }

    public function testLoadIfExistsInvalid()
    {
        $object = $this->idSession->loadIfExists( 'NoSuchClass', 1 );
        $this->assertEquals( null, $object );
    }

    public function testLoadIfExistsNoSuchObject()
    {
        $object = $this->idSession->loadIfExists( 'PersistentTestObject', 999 );
        $this->assertEquals( null, $object );
    }

    // load

    public function testLoadValid()
    {
        $first = $this->idSession->load( 'PersistentTestObject', "1" );
        $this->assertEquals( 'PersistentTestObject', get_class( $first ) );

        $second = $this->idSession->load( 'PersistentTestObject', "1" );
        $this->assertEquals( 'PersistentTestObject', get_class( $second ) );

        // Test identity
        $this->assertSame(
            $first,
            $second,
            'Object identity different on second load.'
        );
    }

    public function testLoadInvalid()
    {
        try
        {
            $object = $this->idSession->load( 'NoSuchClass', 1 );
            $this->fail( "load() called with invalid class. Did not get an exception" );
        }
        catch ( ezcPersistentDefinitionNotFoundException $e ) {}
    }

    public function testLoadNoSuchObject()
    {
        try
        {
            $object = $this->idSession->load( 'PersistentTestObject', 999 );
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
    
    public function testLoadIntoObjectOnceSuccess()
    {
        $object = new PersistentTestObject();
        $this->idSession->loadIntoObject( $object, 1 );

        $this->assertEquals( 'Sweden', $object->varchar );
        $this->assertEquals( 9006405, (int)$object->integer );
        $this->assertEquals( 449.96, (float)$object->decimal );
        $this->assertEquals( 'Sweden has nice girls!', $object->text );
    }
    
    public function testLoadIntoObjectTwiceFailure()
    {
        $first = new PersistentTestObject();
        $this->idSession->loadIntoObject( $first, 1 );

        $this->assertEquals( 'Sweden', $first->varchar );
        $this->assertEquals( 9006405, (int)$first->integer );
        $this->assertEquals( 449.96, (float)$first->decimal );
        $this->assertEquals( 'Sweden has nice girls!', $first->text );

        $second = new PersistentTestObject();
        try
        {
            $this->idSession->loadIntoObject( $second, 1 );
            $this->fail( 'Exception not thrown on load into object of existing instance.' );
        }
        catch ( ezcPersistentIdentityAlreadyExistsException $e ) {}
    }

    public function testLoadIntoObjectInvalid()
    {
        try
        {
            $object = $this->idSession->loadIntoObject( new Exception(), 1 );
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
            $object = $this->idSession->loadIntoObject( new PersistentTestObject(), 999 );
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
        $first  = $this->idSession->load( 'PersistentTestObject', 1 );
        $second = $this->idSession->load( 'PersistentTestObject', 1 );

        $this->assertSame( $first, $second );

        $first->integer = 23;

        $this->assertEquals( 23, $second->integer );

        $this->idSession->refresh( $first );

        $this->assertSame( $first, $second );

        $this->assertEquals( 9006405, (int)$first->integer );
        $this->assertEquals( 9006405, (int)$second->integer );
    }

    public function testRefreshInvalid()
    {
        try
        {
            $this->idSession->refresh( new Exception() );
        }
        catch ( ezcPersistentDefinitionNotFoundException $e ) 
        {
            return;
        }
        $this->fail( "refresh of non-persistent object did not throw exception" );
    }

    public function testRefreshNotPersistent()
    {
        try
        {
            $this->idSession->refresh( new PersistentTestObject() );
        }
        catch ( ezcPersistentObjectNotPersistentException $e )
        {
            return;
        }
        $this->fail( "refresh of non-persistent object did not throw exception" );
    }
}

?>
