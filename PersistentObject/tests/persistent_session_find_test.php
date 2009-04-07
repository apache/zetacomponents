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
class ezcPersistentSessionFindTest extends ezcPersistentSessionTest
{
    public static function suite()
    {
        return new PHPUnit_Framework_TestSuite( __CLASS__ );
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
        $this->assertTrue(
            isset( $objects[3] ) && isset( $objects[4] )
        );

        // check that the data is correct
        $this->assertEquals( 'Ukraine', $objects[3]->varchar );
        $this->assertEquals( 47732079, (int)$objects[3]->integer );
        $this->assertEquals( 603.70, (float)$objects[3]->decimal );
        $this->assertEquals( 'Ukraine has a long coastline to the black see.', $objects[3]->text );

        $this->assertEquals( 'Germany', $objects[4]->varchar );
        $this->assertEquals( 82443000, (int)$objects[4]->integer );
        $this->assertEquals( 357.02, (float)$objects[4]->decimal );
        $this->assertEquals( 'Home of the lederhosen!.', $objects[4]->text );
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

    public function testFindUsingAliases()
    {
        $q = $this->session->createFindQuery( 'PersistentTestObject' );
        $q->where( $q->expr->eq( 'varchar', $q->bindValue( 'Ukraine' ) ) );
        $objects = $this->session->find( $q, 'PersistentTestObject' );
        $this->assertEquals( 1, count( $objects ) );

        // check that the data is correct
        $this->assertEquals( 'Ukraine', $objects[3]->varchar );
        $this->assertEquals( 47732079, (int)$objects[3]->integer );
        $this->assertEquals( 603.70, (float)$objects[3]->decimal );
        $this->assertEquals( 'Ukraine has a long coastline to the black see.', $objects[3]->text );
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

    public function testFindIteratorMultipleResultObjectNotChanged()
    {
        $q = $this->session->createFindQuery( 'PersistentTestObject' );
        $q->where( $q->expr->gt( $this->session->database->quoteIdentifier( 'id' ), 2 ) );

        $it = $this->session->findIterator( $q, 'PersistentTestObject' );

        $lastObject = null;
        foreach ( $it as $object )
        {
            if ( $lastObject !== null )
            {
                $this->assertNotSame( $lastObject, $object );
            }
            $lastObject = $object;
        }
    }

    public function testFindWithoutClassNameSingleResult()
    {
        $q = $this->session->createFindQuery( 'PersistentTestObject' );
        $q->where( $q->expr->eq( $this->session->database->quoteIdentifier( 'id' ), 1 ) );
        $objects = $this->session->find( $q );
        $this->assertEquals( 1, count( $objects ) );
    }

    public function testFindWithoutClassNameMultipleResult()
    {
        $q = $this->session->createFindQuery( 'PersistentTestObject' );
        $q->where( $q->expr->gt( $this->session->database->quoteIdentifier( 'id' ), 2 ) );
        $objects = $this->session->find( $q );
        $this->assertEquals( 2, count( $objects ) );
        $this->assertTrue( isset( $objects[3] ) && isset( $objects[4] ) );

        // check that the data is correct
        $this->assertEquals( 'Ukraine', $objects[3]->varchar );
        $this->assertEquals( 47732079, (int)$objects[3]->integer );
        $this->assertEquals( 603.70, (float)$objects[3]->decimal );
        $this->assertEquals( 'Ukraine has a long coastline to the black see.', $objects[3]->text );

        $this->assertEquals( 'Germany', $objects[4]->varchar );
        $this->assertEquals( 82443000, (int)$objects[4]->integer );
        $this->assertEquals( 357.02, (float)$objects[4]->decimal );
        $this->assertEquals( 'Home of the lederhosen!.', $objects[4]->text );
    }

    public function testFindIteratorWithoutClassNameSingleResult()
    {
        $q = $this->session->createFindQuery( 'PersistentTestObject' );
        $q->where( $q->expr->eq( $this->session->database->quoteIdentifier( 'id' ), 1 ) );
        $it = $this->session->findIterator( $q );
        $i = 0;
        foreach ( $it as $object )
        {
            ++$i;
        }
        $this->assertEquals( 1, $i );
    }

    public function testFindIteratorWithoutClassNameMultipleResult()
    {
        $q = $this->session->createFindQuery( 'PersistentTestObject' );
        $q->where( $q->expr->gt( $this->session->database->quoteIdentifier( 'id' ), 2 ) );
        $objects = $this->session->find( $q );
        $this->assertEquals( 2, count( $objects ) );

        $it = $this->session->findIterator( $q );
        $i = 0;
        foreach ( $it as $object )
        {
            ++$i;
        }
        $this->assertEquals( 2, $i );
    }
}

?>
