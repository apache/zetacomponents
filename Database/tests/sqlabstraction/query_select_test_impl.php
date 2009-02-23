<?php
/**
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package Database
 * @subpackage Tests
 */

/**
 * Testing the SQL abstraction layer.
 * These tests are performed on a real database and tests that
 * the implementations return the correct result.
 *
 * @package Database
 * @subpackage Tests
 * @todo, test with null input values
 */
class ezcQuerySelectTestImpl extends ezcTestCase
{
    private $q;
    private $e;
    private $db;

    protected function setUp()
    {
        try
        {
            $this->db = ezcDbInstance::get();
        }
        catch ( Exception $e )
        {
            $this->markTestSkipped();
        }

        $this->q = $this->db->createSelectQuery();
        $this->e = $this->q->expr;
        $this->assertNotNull( $this->db, 'Database instance is not initialized.' );

        try 
        {
            $this->db->exec( 'DROP TABLE query_test' );
            $this->db->exec( 'DROP TABLE query_test2' );
        }
        catch ( Exception $e ) {} // eat

        // insert some data
        $this->db->exec( 'CREATE TABLE query_test ( id int, company VARCHAR(255), section VARCHAR(255), employees int NULL )' );
        $this->db->exec( "INSERT INTO query_test VALUES ( 1, 'eZ systems', 'Norway', 20 )" );
        $this->db->exec( "INSERT INTO query_test VALUES ( 2, 'IBM', 'Norway', 500 )" );
        $this->db->exec( "INSERT INTO query_test VALUES ( 3, 'eZ systems', 'Ukraine', 10 )" );
        $this->db->exec( "INSERT INTO query_test VALUES ( 4, 'IBM', 'Germany', null )" );
        
        // insert some data
        $this->db->exec( 'CREATE TABLE query_test2 ( id int, company VARCHAR(255), section VARCHAR(255), employees int NULL )' );
        $this->db->exec( "INSERT INTO query_test2 VALUES ( 1, 'eZ systems', 'Norway', 20 )" );
        $this->db->exec( "INSERT INTO query_test2 VALUES ( 2, 'IBM', 'Norway', 500 )" );
        $this->db->exec( "INSERT INTO query_test2 VALUES ( 3, 'eZ systems', 'Ukraine', 10 )" );
        $this->db->exec( "INSERT INTO query_test2 VALUES ( 4, 'IBM', 'Germany', null )" );
    }

    protected function tearDown()
    {
        $this->db->exec( 'DROP TABLE query_test' );
        $this->db->exec( 'DROP TABLE query_test2' );
    }

    public function testBindString()
    {
        $section = 'Norway';
        $this->q->select( 'COUNT(*)' )->from( 'query_test' )
                ->where(
                $this->e->eq( 'section', $this->q->bindParam( $section ) ) );
        $stmt = $this->q->prepare();
        $stmt->execute();
        $this->assertEquals( 2, (int)$stmt->fetchColumn( 0 ) );

        // set another value for section and try again.
        $section = 'Ukraine';
        $stmt->execute();
        $this->assertEquals( 1, (int)$stmt->fetchColumn( 0 ) );
    }

    public function testBindInteger()
    {
        $num = 0;
        $this->q->select( 'COUNT(*)' )->from( 'query_test' )
                ->where(
                $this->e->gt( 'employees', $this->q->bindParam( $num ) ) );
        $stmt = $this->q->prepare();
        $stmt->execute();
        $this->assertEquals( 3, (int)$stmt->fetchColumn( 0 ) );

        // set another value for section and try again.
        $num = 20;
        $stmt->execute();
        $this->assertEquals( 1, (int)$stmt->fetchColumn( 0 ) );
    }

    public function testBuildFrom()
    {
        $this->q->select( 'COUNT(*)' )->from( 'query_test' );
        $stmt = $this->db->query( $this->q->getQuery() );
        $this->assertEquals( 4, (int)$stmt->fetchColumn( 0 ) );
    }

    public function testBuildFromWhere()
    {
        $this->q->select( 'COUNT(*)' )->from( 'query_test' )
                ->where( $this->e->eq( 'employees', 20 ) );
        $stmt = $this->db->query( $this->q->getQuery() );
        $this->assertEquals( 1, (int)$stmt->fetchColumn( 0 ) );
    }

    public function testBuildFromWhereGroup()
    {
        $this->q->select( 'COUNT(*)' )->from( 'query_test' )
                ->where( $this->e->eq( 1, 1 ) )
                ->groupBy( 'Company' );
        $stmt = $this->db->query( $this->q->getQuery() );
        $this->assertEquals( 2, (int)$stmt->fetchColumn( 0 ) );
    }

    public function testBuildFromWhereGroupOrder()
    {
        $this->q->select( 'company', 'SUM(employees)' )->from( 'query_test' )
                ->where( $this->e->eq( 1, 1 ) )
                ->groupBy( 'company' )
                ->orderBy( 'company', ezcQuerySelect::DESC );
        $stmt = $this->db->query( $this->q->getQuery() );
        $rows = 0;
        foreach ( $stmt as $row )
        {
            $rows++;
        }
        $this->assertEquals( 2, $rows );
    }

    public function testBuildFromWhereGroupOrderLimit()
    {
        $this->q->select( 'company', 'SUM(employees)' )->from( 'query_test' )
                ->where( $this->e->eq( 1, 1 ) )
                ->groupBy( 'company' )
                ->orderBy( 'company', ezcQuerySelect::DESC )
                ->limit( 1 );
        $stmt = $this->db->query( $this->q->getQuery() );
        $rows = 0;
        foreach ( $stmt as $row )
        {
            $rows++;
        }
        $this->assertEquals( 1, $rows );
    }

    // bug #9466
    public function testBuildFromWhereGroupOrderLimit2()
    {
        $stmt = $this->q->select( 'company', 'SUM(employees)' )->from( 'query_test' )
                ->where( $this->e->eq( 1, 1 ) )
                ->groupBy( 'company' )
                ->orderBy( 'company', ezcQuerySelect::DESC )
                ->limit( 1 )
                ->prepare();
        $stmt->execute();
        $rows = 0;
        foreach ( $stmt as $row )
        {
            $rows++;
        }
        $this->assertEquals( 1, $rows );
    }

    public function testBuildFromWhereOrderLimit()
    {
        $this->q->select( '*' )->from( 'query_test' )
                ->where( $this->e->eq( 1, 1 ) )
                ->orderBy( 'id', ezcQuerySelect::DESC )
                ->limit( 1 );
        $stmt = $this->db->query( $this->q->getQuery() );
        $rows = 0;
        foreach ( $stmt as $row )
        {
            $rows++;
        }
        $this->assertEquals( 1, $rows );
    }

    public function testBuildFromWhereGroupLimit()
    {
        $this->q->select( 'company', 'SUM(employees)' )->from( 'query_test' )
                ->where( $this->e->eq( 1, 1 ) )
                ->groupBy( 'company' )
                ->limit( 1 );
        $stmt = $this->db->query( $this->q->getQuery() );
        $rows = 0;
        foreach ( $stmt as $row )
        {
            $rows++;
        }
        $this->assertEquals( 1, $rows );
    }

    public function testBuildFromWhereGroupHaving()
    {
       $this->q->select( 'company', 'SUM(employees)' )->from( 'query_test' )
            ->where( $this->e->eq( 1, 1 ) )
            ->groupBy( 'company' )
            ->having( $this->e->gt( 'SUM(employees)', 100 ) );

        $stmt = $this->db->query( $this->q->getQuery() );
        $rows = 0;
        foreach ( $stmt as $row )
        {
            $rows++;
        }

        $this->assertEquals( 1, $rows );
    }

    public function testBuildFromWhereGroupHavingMulti()
    {
       $this->q->select( 'company', 'SUM(employees)' )->from( 'query_test' )
            ->where( $this->e->eq( 1, 1 ) )
            ->groupBy( 'company' )
            ->having( $this->e->gte( 'SUM(employees)', 10 ) )
            ->having( $this->e->lte( 'SUM(employees)', 500 ) );

        $stmt = $this->db->query( $this->q->getQuery() );
        $rows = 0;
        foreach ( $stmt as $row )
        {
            $rows++;
        }

        $this->assertEquals( 2, $rows );
    }

    public function testBuildFromWhereGroupHavingBind()
    {
       $this->q->select( 'company', 'SUM(employees)' )->from( 'query_test' )
            ->where( $this->e->eq( 1, 1 ) )
            ->groupBy( 'company' )
            ->having( $this->e->eq( 'company', $this->q->bindValue( 'eZ systems' ) ) );

        $stmt = $this->q->prepare();
        $stmt->execute();
        $rows = 0;
        foreach ( $stmt as $row )
        {
            $rows++;
        }

        $this->assertEquals( 1, $rows );
    }

    public function testBuildFromWhereOrderLimitOffset()
    {
        $this->q->select( '*' )->from( 'query_test' )
                ->where( $this->e->eq( 1, 1 ) )
                ->orderBy( 'id', ezcQuerySelect::DESC )
                ->limit( 1 );
        $stmt = $this->db->query( $this->q->getQuery() );
        $result = $stmt->fetchAll();
        $this->assertEquals( 1, count( $result ) );
        $this->assertEquals( 'IBM', $result[0]['company'] );
        $this->assertEquals( 'Germany', $result[0]['section'] );
    }


    public function testBuildFromLimit()
    {
        $this->q->select( '*' )->from( 'query_test' )
                ->where( $this->e->eq( 1, 1 ) )
                ->limit( 1 );
        $stmt = $this->db->query( $this->q->getQuery() );
        $rows = 0;
        foreach ( $stmt as $row )
        {
            $rows++;
        }
        $this->assertEquals( 1, $rows );
    }

    public function testBuildFromDistinct()
    {
        $this->q->selectDistinct( 'section' )
                ->from( 'query_test' );

        $stmt = $this->db->query( $this->q->getQuery() );
        $rows = 0;
        foreach ( $stmt as $row )
        {
            $rows++;
        }
        $this->assertEquals( 3, $rows );
    }

    // LOGIC TESTS
    public function testSelectNone()
    {
        try
        {
            $this->q->select( );
            $this->fail( "Expected exception" );
        }
        catch ( ezcQueryVariableParameterException $e ) {}
    }

    public function testSelectMultiInOne()
    {
        $this->q->select( 'id', 'company' )->from( 'query_test' );
        $stmt = $this->db->query( $this->q->getQuery() );
        $this->assertEquals( 2, $stmt->columnCount() );
    }

    public function testSelectMultiInMulti()
    {
        $this->q->select( 'id' )->from( 'query_test' )->select( 'company' );
        $stmt = $this->db->query( $this->q->getQuery() );
        $this->assertEquals( 2, $stmt->columnCount() );
    }

    public function testSelectMultiWithAliasInOne()
    {
        $this->q->setAliases( array( 'identifier' => 'id', 'text' => 'company' ) );
        $this->q->select( 'identifier', 'text' )->from( 'query_test' );
        $stmt = $this->db->query( $this->q->getQuery() );
        $this->assertEquals( 2, $stmt->columnCount() );
    }

    public function testSelectMultiWithAliasInMulti()
    {
        $this->q->setAliases( array( 'identifier' => 'id', 'text' => 'company' ) );
        $this->q->select( 'identifier')->select( 'text' )->from( 'query_test' );
        $stmt = $this->db->query( $this->q->getQuery() );
        $this->assertEquals( 2, $stmt->columnCount() );
    }


    public function testAliAs()
    {
        $this->q->select( $this->q->aliAs( 'id', 'other' ) )->from( 'query_test' );
        $stmt = $this->db->query( $this->q->getQuery() );
        $result = $stmt->fetchAll();
        if ( !isset( $result[0]['other'] ) ) 
        {
            $this->fail( 'Fail test testAliAs' );
        }
    }

    public function testAliAsWithAlias()
    {
        $this->q->setAliases( array( 'identifier' => 'id', 'text' => 'company' ) );
        $this->q->select( $this->q->aliAs( 'identifier', 'other' ) )->from( 'query_test' );
        $stmt = $this->db->query( $this->q->getQuery() );
        $result = $stmt->fetchAll();
        if ( !isset( $result[0]['other'] ) ) 
        {
            $this->fail( 'Test fail testAliAsWithAlias' );
        }
    }

    public function testMultipleFromInOne()
    {
        $this->q->select( 'query_test.id', 'query_test2.company' )->from( 'query_test', 'query_test2');
        $stmt = $this->db->query( $this->q->getQuery() );
        $this->assertEquals( 2, $stmt->columnCount() );
    }

    public function testMultipleFromInMulti()
    {
        $this->q->select( 'query_test.id', 'query_test2.company' )->from( 'query_test')->from( 'query_test2' );
        $stmt = $this->db->query( $this->q->getQuery() );
        $this->assertEquals( 2, $stmt->columnCount() );
    }

    public function testEmptyFrom()
    {
        try
        {
            $this->q->select( 'd' )->from();
            $this->fail( "Expected exception" );
        }
        catch ( ezcQueryVariableParameterException $e ) {}
    }

    public function testWhereMultiInOne()
    {
        $this->q->select( '*' )->from( 'query_test' )
            ->where( $this->e->eq( 1, 1 ), $this->e->eq( 1, 0 ) );
        $stmt = $this->db->query( $this->q->getQuery() );
        $rows = 0;
        foreach ( $stmt as $row )
        {
            $rows++;
        }
        $this->assertEquals( 0, $rows );
    }

    public function testWhereMultiInMulti()
    {
        $this->q->select( '*' )->from( 'query_test' )
            ->where( $this->e->eq( 1, 1 ))->where( $this->e->eq( 1, 0 ) );
        $stmt = $this->db->query( $this->q->getQuery() );
        $rows = 0;
        foreach ( $stmt as $row )
        {
            $rows++;
        }
        $this->assertEquals( 0, $rows );
    }

    public function testEmptyWhere()
    {
        try
        {
            $this->q->select( 'd' )->from('d')->where();
            $this->fail( "Expected exception" );
        }
        catch ( ezcQueryVariableParameterException $e ) {}
    }

    public function testEmptyGroupBy()
    {
        try
        {
            $this->q->select( 'd' )->from('d')->groupBy();
            $this->fail( "Expected exception" );
        }
        catch ( ezcQueryVariableParameterException $e ) {}
    }

    public function testReset()
    {
        $this->q->select( 'company', 'SUM(employees)' )->from( 'query_test' )
                ->where( $this->e->eq( 1, 1 ) )
                ->groupBy( 'company' )
                ->orderBy( 'company', ezcQuerySelect::DESC )
                ->limit( 1 );
        $queryString = $this->q->getQuery();
        $this->q->reset();

        $this->q->select( 'company', 'SUM(employees)' )->from( 'query_test' )
                ->where( $this->e->eq( 1, 1 ) )
                ->groupBy( 'company' )
                ->orderBy( 'company', ezcQuerySelect::DESC )
                ->limit( 1 );
        $this->assertEquals( $queryString, $this->q->getQuery() );
    }

    public static function suite()
    {
        return new PHPUnit_Framework_TestSuite( 'ezcQuerySelectTestImpl' );
    }
}
?>
