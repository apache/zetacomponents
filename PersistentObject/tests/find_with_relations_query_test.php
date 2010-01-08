<?php
/**
 * @copyright Copyright (C) 2005-2010 eZ Systems AS. All rights reserved.
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
            'isRestricted',
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

        $this->assertFalse( $findQuery->isRestricted );
        $this->assertEquals( $relations, $findQuery->relations );
    }

    public function testIssetOwnPropertiesSuccess()
    {
        parent::testGetOwnPropertiesSuccess();

        $findQuery = $this->createFindQuery();

        $this->assertTrue( isset( $findQuery->isRestricted ) );
        $this->assertTrue( isset( $findQuery->relations ) );
    }

    public function testFluentInterface()
    {
        $q = $this->createFindQuery();

        try
        {
            $q->select( 'foo' );
            $this->fail( 'Exception not thrown on call to forbidden method select().' );
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
        
        $this->assertTrue(
            $q->isRestricted
        );
    }

    public function testRegisterWhereConditionComplex()
    {
        $q = $this->createFindQuery();

        $q->where(
            $q->expr->gte( 'foo', 42 ),
            $q->expr->eq( 'bars_id', $q->bindValue( 23 ) )
        );
        
        $this->assertTrue(
            $q->isRestricted
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
