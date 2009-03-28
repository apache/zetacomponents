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
 * Tests the load facilities of ezcPersistentSession.
 *
 * @package PersistentObject
 * @subpackage Tests
 */
class ezcPersistentIdentitySessionFindTest extends ezcPersistentIdentitySessionTest
{
    public static function suite()
    {
        return new PHPUnit_Framework_TestSuite( __CLASS__ );
    }

    // find

    public function testFindNoResult()
    {
        $q = $this->idSession->createFindQuery( 'PersistentTestObject' );
        $q->where( $q->expr->eq( $this->idSession->database->quoteIdentifier( 'id' ), 999 ) );
        $objects = $this->idSession->find( $q, 'PersistentTestObject' );
        $this->assertEquals( 0, count( $objects ) );
    }

    public function testFindSingleResult()
    {
        $q = $this->idSession->createFindQuery( 'PersistentTestObject' );
        $q->where( $q->expr->eq( $this->idSession->database->quoteIdentifier( 'id' ), 1 ) );
        $objects = $this->idSession->find( $q, 'PersistentTestObject' );
        $this->assertEquals( 1, count( $objects ) );

        $first = $objects[0];

        $objects = $this->idSession->find( $q, 'PersistentTestObject' );
        $this->assertEquals( 1, count( $objects ) );

        $second = $objects[0];

        $this->assertSame( $first, $second );
    }

    public function testFindSingleResultRefetch()
    {
        $this->idSession->options->refetch = true;

        $q = $this->idSession->createFindQuery( 'PersistentTestObject' );
        $q->where( $q->expr->eq( $this->idSession->database->quoteIdentifier( 'id' ), 1 ) );
        $objects = $this->idSession->find( $q, 'PersistentTestObject' );
        $this->assertEquals( 1, count( $objects ) );

        $first = $objects[0];

        $objects = $this->idSession->find( $q, 'PersistentTestObject' );
        $this->assertEquals( 1, count( $objects ) );

        $second = $objects[0];

        $this->assertNotSame( $first, $second );
    }

    public function testFindMultipleResult()
    {
        $q = $this->idSession->createFindQuery( 'PersistentTestObject' );
        $q->where( $q->expr->gt( $this->idSession->database->quoteIdentifier( 'id' ), 2 ) );

        $first = $this->idSession->find( $q, 'PersistentTestObject' );
        $this->assertEquals( 2, count( $first ) );

        $second = $this->idSession->find( $q, 'PersistentTestObject' );
        $this->assertEquals( 2, count( $second ) );
        
        foreach ( $first as $id => $object )
        {
            $this->assertSame( $first[$id], $second[$id] );
        }
    }

    public function testFindMultipleResultRefetch()
    {
        $this->idSession->options->refetch = true;

        $q = $this->idSession->createFindQuery( 'PersistentTestObject' );
        $q->where( $q->expr->gt( $this->idSession->database->quoteIdentifier( 'id' ), 2 ) );

        $first = $this->idSession->find( $q, 'PersistentTestObject' );
        $this->assertEquals( 2, count( $first ) );

        $second = $this->idSession->find( $q, 'PersistentTestObject' );
        $this->assertEquals( 2, count( $second ) );
        
        foreach ( $first as $id => $object )
        {
            $this->assertNotSame( $first[$id], $second[$id] );
        }
    }

    public function testFindUsingAliases()
    {
        $q = $this->idSession->createFindQuery( 'PersistentTestObject' );
        $q->where( $q->expr->eq( 'varchar', $q->bindValue( 'Ukraine' ) ) );

        $first = $this->idSession->find( $q, 'PersistentTestObject' );
        $this->assertEquals( 1, count( $first ) );

        $second = $this->idSession->find( $q, 'PersistentTestObject' );
        $this->assertEquals( 1, count( $second ) );

        foreach ( $first as $id => $object )
        {
            $this->assertSame( $first[$id], $second[$id] );
        }
    }

    public function testFindUsingAliasesRefetch()
    {
        $this->idSession->options->refetch = true;

        $q = $this->idSession->createFindQuery( 'PersistentTestObject' );
        $q->where( $q->expr->eq( 'varchar', $q->bindValue( 'Ukraine' ) ) );

        $first = $this->idSession->find( $q, 'PersistentTestObject' );
        $this->assertEquals( 1, count( $first ) );

        $second = $this->idSession->find( $q, 'PersistentTestObject' );
        $this->assertEquals( 1, count( $second ) );

        foreach ( $first as $id => $object )
        {
            $this->assertNotSame( $first[$id], $second[$id] );
        }
    }

    // findIterator

    public function testFindIteratorNoResult()
    {
        $q = $this->idSession->createFindQuery( 'PersistentTestObject' );
        $q->where( $q->expr->eq( $this->idSession->database->quoteIdentifier( 'id' ), 999 ) );
        $it = $this->idSession->findIterator( $q, 'PersistentTestObject' );

        $this->assertEquals( null, $it->next() );
    }

    public function testFindIteratorSingleResult()
    {
        $q = $this->idSession->createFindQuery( 'PersistentTestObject' );
        $q->where( $q->expr->eq( $this->idSession->database->quoteIdentifier( 'id' ), 1 ) );

        $firstItr  = $this->idSession->findIterator( $q, 'PersistentTestObject' );
        $secondItr = $this->idSession->findIterator( $q, 'PersistentTestObject' );
        
        $this->assertIteratorsSame(
            $firstItr,
            $secondItr
        );
    }

    public function testFindIteratorSingleResultRefetch()
    {
        $this->idSession->options->refetch = true;

        $q = $this->idSession->createFindQuery( 'PersistentTestObject' );
        $q->where( $q->expr->eq( $this->idSession->database->quoteIdentifier( 'id' ), 1 ) );

        $firstItr  = $this->idSession->findIterator( $q, 'PersistentTestObject' );
        $secondItr = $this->idSession->findIterator( $q, 'PersistentTestObject' );
        
        $this->assertIteratorsNotSame(
            $firstItr,
            $secondItr
        );
    }

    public function testFindIteratorMultipleResult()
    {
        $q = $this->idSession->createFindQuery( 'PersistentTestObject' );
        $q->where( $q->expr->gt( $this->idSession->database->quoteIdentifier( 'id' ), 2 ) );

        $firstItr = $this->idSession->findIterator( $q, 'PersistentTestObject' );
        $secondItr = $this->idSession->findIterator( $q, 'PersistentTestObject' );
        
        $this->assertIteratorsSame(
            $firstItr,
            $secondItr
        );
    }

    public function testFindIteratorMultipleResultRefetch()
    {
        $this->idSession->options->refetch = true;

        $q = $this->idSession->createFindQuery( 'PersistentTestObject' );
        $q->where( $q->expr->gt( $this->idSession->database->quoteIdentifier( 'id' ), 2 ) );

        $firstItr = $this->idSession->findIterator( $q, 'PersistentTestObject' );
        $secondItr = $this->idSession->findIterator( $q, 'PersistentTestObject' );
        
        $this->assertIteratorsNotSame(
            $firstItr,
            $secondItr
        );
    }

    public function testFindWithoutClassNameSingleResult()
    {
        $q = $this->idSession->createFindQuery( 'PersistentTestObject' );
        $q->where( $q->expr->eq( $this->idSession->database->quoteIdentifier( 'id' ), 1 ) );

        $objects = $this->idSession->find( $q );
        $this->assertEquals( 1, count( $objects ) );

        $first = $objects[0];

        $objects = $this->idSession->find( $q );
        $this->assertEquals( 1, count( $objects ) );

        $second = $objects[0];

        $this->assertSame( $first, $second );
    }

    public function testFindWithoutClassNameSingleResultRefetch()
    {
        $this->idSession->options->refetch = true;

        $q = $this->idSession->createFindQuery( 'PersistentTestObject' );
        $q->where( $q->expr->eq( $this->idSession->database->quoteIdentifier( 'id' ), 1 ) );

        $objects = $this->idSession->find( $q );
        $this->assertEquals( 1, count( $objects ) );

        $first = $objects[0];

        $objects = $this->idSession->find( $q );
        $this->assertEquals( 1, count( $objects ) );

        $second = $objects[0];

        $this->assertNotSame( $first, $second );
    }

    public function testFindWithoutClassNameMultipleResult()
    {
        $q = $this->idSession->createFindQuery( 'PersistentTestObject' );
        $q->where( $q->expr->gt( $this->idSession->database->quoteIdentifier( 'id' ), 2 ) );
        $objects = $this->idSession->find( $q );
        $this->assertEquals( 2, count( $objects ) );

        $first = $this->idSession->find( $q, 'PersistentTestObject' );
        $this->assertEquals( 2, count( $first ) );

        $second = $this->idSession->find( $q, 'PersistentTestObject' );
        $this->assertEquals( 2, count( $second ) );
        
        foreach ( $first as $id => $object )
        {
            $this->assertSame( $first[$id], $second[$id] );
        }
    }

    public function testFindWithoutClassNameMultipleResultRefetch()
    {
        $this->idSession->options->refetch = true;

        $q = $this->idSession->createFindQuery( 'PersistentTestObject' );
        $q->where( $q->expr->gt( $this->idSession->database->quoteIdentifier( 'id' ), 2 ) );
        $objects = $this->idSession->find( $q );
        $this->assertEquals( 2, count( $objects ) );

        $first = $this->idSession->find( $q, 'PersistentTestObject' );
        $this->assertEquals( 2, count( $first ) );

        $second = $this->idSession->find( $q, 'PersistentTestObject' );
        $this->assertEquals( 2, count( $second ) );
        
        foreach ( $first as $id => $object )
        {
            $this->assertNotSame( $first[$id], $second[$id] );
        }
    }

    public function testFindIteratorWithoutClassNameSingleResult()
    {
        $q = $this->idSession->createFindQuery( 'PersistentTestObject' );
        $q->where( $q->expr->eq( $this->idSession->database->quoteIdentifier( 'id' ), 1 ) );

        $firstItr  = $this->idSession->findIterator( $q );
        $secondItr = $this->idSession->findIterator( $q );
        
        $this->assertIteratorsSame(
            $firstItr,
            $secondItr
        );
    }

    public function testFindIteratorWithoutClassNameSingleResultRefetch()
    {
        $this->idSession->options->refetch = true;

        $q = $this->idSession->createFindQuery( 'PersistentTestObject' );
        $q->where( $q->expr->eq( $this->idSession->database->quoteIdentifier( 'id' ), 1 ) );

        $firstItr  = $this->idSession->findIterator( $q );
        $secondItr = $this->idSession->findIterator( $q );
        
        $this->assertIteratorsNotSame(
            $firstItr,
            $secondItr
        );
    }

    public function testFindIteratorWithoutClassNameMultipleResult()
    {
        $q = $this->idSession->createFindQuery( 'PersistentTestObject' );
        $q->where( $q->expr->gt( $this->idSession->database->quoteIdentifier( 'id' ), 2 ) );

        $firstItr = $this->idSession->findIterator( $q );
        $secondItr = $this->idSession->findIterator( $q );
        
        $this->assertIteratorsSame(
            $firstItr,
            $secondItr
        );
    }

    public function testFindIteratorWithoutClassNameMultipleResultRefetch()
    {
        $this->idSession->options->refetch = true;

        $q = $this->idSession->createFindQuery( 'PersistentTestObject' );
        $q->where( $q->expr->gt( $this->idSession->database->quoteIdentifier( 'id' ), 2 ) );

        $firstItr = $this->idSession->findIterator( $q );
        $secondItr = $this->idSession->findIterator( $q );
        
        $this->assertIteratorsNotSame(
            $firstItr,
            $secondItr
        );
    }

    protected function assertIteratorsSame( Iterator $expected, Iterator $actual, $message = null )
    {
        $expected->rewind();
        $actual->rewind();

        while ( $expected->valid() && $actual->valid() )
        {
            $this->assertEquals(
                $expected->key(),
                $actual->key(),
                'Keys are not identical.' . ( $message !== null ? ' ' . $message : '' )
            );
            $this->assertSame(
                $expected->current(),
                $actual->current(),
                'Values are not identical.' . ( $message !== null ? ' ' . $message : '' )
            );

            $expected->next();
            $actual->next();
        }
        
        $this->assertFalse(
            $expected->valid(),
            'Expected iterator not finished.' . ( $message !== null ? ' ' . $message : '' ) 
        );
        $this->assertFalse(
            $actual->valid(),
            'Actual iterator not finished.' . ( $message !== null ? ' ' . $message : '' ) 
        );
    }

    protected function assertIteratorsNotSame( Iterator $expected, Iterator $actual, $message = null )
    {
        $expected->rewind();
        $actual->rewind();

        while ( $expected->valid() && $actual->valid() )
        {
            $this->assertEquals(
                $expected->key(),
                $actual->key(),
                'Keys are not identical.' . ( $message !== null ? ' ' . $message : '' )
            );
            $this->assertNotSame(
                $expected->current(),
                $actual->current(),
                'Values are not identical.' . ( $message !== null ? ' ' . $message : '' )
            );

            $expected->next();
            $actual->next();
        }
        
        $this->assertFalse(
            $expected->valid(),
            'Expected iterator not finished.' . ( $message !== null ? ' ' . $message : '' ) 
        );
        $this->assertFalse(
            $actual->valid(),
            'Actual iterator not finished.' . ( $message !== null ? ' ' . $message : '' ) 
        );
    }
}

?>
