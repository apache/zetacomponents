<?php
/**
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license BSD {@link http://ez.no/licenses/bsd}
 * @version //autogentag//
 * @filesource
 * @package Database
 * @subpackage Tests
 */

/**
 * Testing the JOIN functionality in the SQL abstraction layer.
 * These tests are performed on a real database and tests that
 * the implementations return the correct result.
 *
 * @package Database
 * @subpackage Tests
 */
class ezcQuerySelectJoinTestImpl extends ezcTestCase
{
    private $q;
    private $e;
    private $db;
    public function setUp()
    {

        $this->db = ezcDbInstance::get();
        $this->q = $this->db->createSelectQuery();
        $this->e = $this->q->expr;
        $this->assertNotNull( $this->db, 'Database instance is not initialized.' );

        try
        {
            $this->db->exec( 'DROP TABLE employees' );
        }
        catch ( Exception $e ) {} // eat
        try
        {
            $this->db->exec( 'DROP TABLE orders' );
        }
        catch ( Exception $e ) {} // eat

        // insert some data
        $this->db->exec( 'CREATE TABLE employees ( id int, name VARCHAR(255) )' );
        $this->db->exec( "INSERT INTO employees VALUES ( 1, 'Raymond Bosman' )" );
        $this->db->exec( "INSERT INTO employees VALUES ( 2, 'Derick Rethans' )" );
        $this->db->exec( "INSERT INTO employees VALUES ( 3, 'Jan Borsodi' )" );
        $this->db->exec( "INSERT INTO employees VALUES ( 4, 'Frederik Holljen' )" );

        $this->db->exec( 'CREATE TABLE orders ( id int, product VARCHAR(255), employee_id int )' );
        $this->db->exec( "INSERT INTO orders VALUES ( 1001, 'Glass', 1 )" );
        $this->db->exec( "INSERT INTO orders VALUES ( 1002, 'Table', 3 )" );
        $this->db->exec( "INSERT INTO orders VALUES ( 1003, 'CPU', 3 )" );
        $this->db->exec( "INSERT INTO orders VALUES ( 1004, 'Cat', 5 )" );
    }

    public function tearDown()
    {
        $this->db->exec( 'DROP TABLE employees' );
        $this->db->exec( 'DROP TABLE orders' );
    }

    public function testNormal()
    {
        $this->q->select( 'employees.name', 'orders.product' )->from( 'employees', 'orders' )
                ->where( $this->e->eq( 'employees.id', 'orders.employee_id' ) );
        $stmt = $this->db->query( $this->q->getQuery() );
        $rows = 0;
        foreach ( $stmt as $row )
        {
            $rows++;
        }
        $this->assertEquals( 3, $rows );
    }

    public function testInnerJoin()
    {
        $this->q->select( 'employees.name', 'orders.product' )
                 ->from( $this->q->innerJoin( 'employees', 'orders', 'employees.id', 'orders.employee_id' ) );
        $stmt = $this->db->query( $this->q->getQuery() );
        $rows = 0;
        foreach ( $stmt as $row )
        {
            $rows++;
        }
        $this->assertEquals( 3, $rows );
    }

    public function testLeftJoin()
    {
        $this->q->select( 'employees.name', 'orders.product' )
                 ->from( $this->q->leftJoin( 'employees', 'orders', 'employees.id', 'orders.employee_id' ) );
        $stmt = $this->db->query( $this->q->getQuery() );
        $rows = 0;
        foreach ( $stmt as $row )
        {
            $rows++;
        }
        $this->assertEquals( 5, $rows );
    }

    public function testRightJoin()
    {
        $this->q->select( 'employees.name', 'orders.product' )
                 ->from( $this->q->rightJoin( 'employees', 'orders', 'employees.id', 'orders.employee_id' ) );
        $stmt = $this->db->query( $this->q->getQuery() );
        $rows = 0;
        foreach ( $stmt as $row )
        {
            $rows++;
        }
        $this->assertEquals( 4, $rows );
    }

    public static function suite()
    {
        return new ezcTestSuite( 'ezcQuerySelectJoinTestImpl' );
    }
}
?>
