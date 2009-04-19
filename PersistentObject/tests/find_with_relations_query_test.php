<?php
/**
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @package PersistentObject
 * @subpackage Tests
 */

require_once 'find_query_test.php';

/**
 * Tests the ezcPersistentFindQuery class.
 *
 * @package PersistentObject
 * @subpackage Tests
 */
class ezcPersistentFindWithRelationsQueryTest extends ezcPersistentFindQueryTest
{
    public static function suite()
    {
        return new PHPUnit_Framework_TestSuite( __CLASS__ );
    }

    public function testRelationsInCtor()
    {
        $q = new ezcQuerySelect( $this->db );
        $relations = array(
            'bars' => new ezcPersistentRelationFindDefinition( 'BarClass' ),
        );

        $findQuery = new ezcPersistentFindWithRelationsQuery( $q, 'FooClass', $relations );

        $this->assertSame( $relations, $findQuery->relations );
    }

    public function testSetOwnPropertiesFailure()
    {
        parent::testSetOwnPropertiesFailure();
        $findQuery = $this->createFindQuery();
        
        $this->assertSetPropertyFails(
            $findQuery,
            'relations',
            array( 23, 42.23, true, array(), new stdClass() )
        );
        $this->assertSetPropertyFails(
            $findQuery,
            'restrictedRelations',
            array( 23, 42.23, true, array(), 'foo' )
        );
    }

    public function testGetOwnPropertiesSuccess()
    {
        parent::testGetOwnPropertiesSuccess();

        $findQuery = $this->createFindQuery();

        $relations = array(
            'bars' => new ezcPersistentRelationFindDefinition( 'BarClass' ),
        );

        $this->assertEquals( $relations, $findQuery->relations );
        $this->assertEquals( array(), $findQuery->restrictedRelations );
    }

    public function testIssetOwnPropertiesSuccess()
    {
        parent::testGetOwnPropertiesSuccess();

        $findQuery = $this->createFindQuery();

        $this->assertTrue( isset( $findQuery->relations ) );
        $this->assertTrue( isset( $findQuery->restrictedRelations ) );
    }

    public function testFluentInterface()
    {
        $q = $this->createFindQuery();

        try
        {
            $q->select( 'foo' );
            $this->fail( 'Exception not thrown on call to forbidden metho select().' );
        }
        catch ( RuntimeException $e ) {}

        $q2 = $q->where(
            $q->expr->eq(
                'foo',
                $q->bindValue( 23 )
            )
        );

        $this->assertSame( $q, $q2 );
    }

    public function testRegisterWhereConditionSimple()
    {
        $q = $this->createFindQuery();

        $q->where(
            $q->expr->eq( 'bars_id', $q->bindValue( 23 ) )
        );
        
        $this->assertEquals(
            array( 'bars' => true ),
            $q->restrictedRelations
        );
    }

    public function testRegisterWhereConditionComplex()
    {
        $q = $this->createFindQuery();

        $q->where(
            $q->expr->gte( 'foo', 42 ),
            $q->expr->eq( 'bars_id', $q->bindValue( 23 ) )
        );
        
        $this->assertEquals(
            array( 'bars' => true ),
            $q->restrictedRelations
        );
    }

    protected function createFindQuery()
    {
        $q   = new ezcQuerySelect( $this->db );
        $cn  = 'myCustomClassName';
        $rel = array(
            'bars' => new ezcPersistentRelationFindDefinition( 'BarClass' ),
        );

        return new ezcPersistentFindWithRelationsQuery( $q, $cn, $rel );
    }
}

?>
