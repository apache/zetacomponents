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
class ezcPersistentSessionDeleteTest extends ezcPersistentSessionTest
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

    public function testDeleteInvalid()
    {
        try
        {
            $this->session->delete( new Exception() );
            $this->fail( "Deleting a non persistent object did not throw exception." );
        }
        catch ( ezcPersistentDefinitionNotFoundException $e ) {}
    }

    public function testDeleteNotPersistent()
    {
        try
        {
            $this->session->delete( new PersistentTestObject() );
            $this->fail( "Deleting an object that is not yet persistent did not throw exception." );
        }
        catch ( ezcPersistentObjectNotPersistentException $e ) {}
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
}

?>
