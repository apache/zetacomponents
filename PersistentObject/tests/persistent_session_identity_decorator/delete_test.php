<?php
/**
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package PersistentObject
 * @subpackage Tests
 */

require_once 'test_case.php';

/**
 * Tests the load facilities of ezcPersistentSession.
 *
 * @package PersistentObject
 * @subpackage Tests
 */
class ezcPersistentSessionIdentityDecoratorDeleteTest extends ezcPersistentSessionIdentityDecoratorTest
{
    public static function suite()
    {
        return new PHPUnit_Framework_TestSuite( __CLASS__ );
    }
    
    // delete

    public function testDeleteValid()
    {
        $object = new PersistentTestObject();
        $object->varchar = 'Finland';
        $object->integer = 42;
        $object->decimal = 1.42;
        $object->text = "Finland has Nokia!";
        
        $this->idSession->save( $object );
        
        $this->assertEquals( 5, $object->id );
    
        $this->assertSame(
            $object,
            $this->idMap->getIdentity( 'PersistentTestObject', 5 )
        );

        $this->idSession->delete( $object );

        $this->assertNull(
            $this->idMap->getIdentity( 'PersistentTestObject', 5 )
        );

        try
        {
            $this->idSession->load( 'PersistentTestObject', 5 );
            $this->fail( "Fetching a deleted object did not throw exception." );
        }
        catch ( ezcPersistentQueryException $e ) 
        {
            $this->assertEquals(
                "A query failed internally in Persistent Object: No object of class 'PersistentTestObject' with id '5'.",
                $e->getMessage()
            );
        }

        $this->assertNull(
            $this->idMap->getIdentity( 'PersistentTestObject', 5 )
        );
    }

    public function testDeleteInvalid()
    {
        try
        {
            $this->idSession->delete( new Exception() );
            $this->fail( "Deleting a non persistent object did not throw exception." );
        }
        catch ( ezcPersistentDefinitionNotFoundException $e ) {}
    }

    public function testDeleteNotPersistent()
    {
        try
        {
            $this->idSession->delete( new PersistentTestObject() );
            $this->fail( "Deleting an object that is not yet persistent did not throw exception." );
        }
        catch ( ezcPersistentObjectNotPersistentException $e ) {}
    }
    
    public function testNoTablePrefixingInDeleteQuery()
    {
        $q = $this->idSession->createDeleteQuery( 'PersistentTestObject' );
        $q->where(
            $q->expr->eq( 'integer', $q->bindValue( 50 ) )
        );
        $sql = $q->getQuery();
        
        $this->assertFalse(
            strpos(
                $sql,
                $this->idSession->database->quoteIdentifier( 'PO_test' ) . '.' . $this->idSession->database->quoteIdentifier( 'type_integer' )
            )
        );
    }
    
    //  deleteFromQuery

    public function testDeleteFromQuery()
    {
        $q = $this->idSession->createDeleteQuery( 'PersistentTestObject' );
        $q->where( $q->expr->neq( 'integer', 0 ) );
        $this->idSession->deleteFromQuery( $q );

        $q = $this->idSession->createFindQuery( 'PersistentTestObject' );
        $objects = $this->idSession->find( $q, 'PersistentTestObject' );
        $this->assertEquals( 0, count( $objects ) );
    }

    public function testDeleteFromQueryFail()
    {
        $q = $this->idSession->createDeleteQuery( 'PersistentTestObject' );
        $q->where( $q->expr->neq( 'foobar', 0 ) );
        
        try
        {
            $this->idSession->deleteFromQuery( $q );
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

    public function testDeleteFromQueryResetIdMap()
    {
        $o1 = $this->idSession->load( 'PersistentTestObject', 1 );
        $o2 = $this->idSession->load( 'PersistentTestObject', 2 );

        $this->assertNotNull(
            $this->idMap->getIdentity( 'PersistentTestObject', 1 )
        );
        $this->assertNotNull(
            $this->idMap->getIdentity( 'PersistentTestObject', 2 )
        );

        $q = $this->idSession->createDeleteQuery( 'PersistentTestObject' );
        $q->where( $q->expr->neq( 'integer', 1 ) );
        $this->idSession->deleteFromQuery( $q );

        // ID map has been reset
        $this->assertNull(
            $this->idMap->getIdentity( 'PersistentTestObject', 1 )
        );
        $this->assertNull(
            $this->idMap->getIdentity( 'PersistentTestObject', 2 )
        );
    }
}

?>
