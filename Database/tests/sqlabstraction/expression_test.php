<?php
/**
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package Database
 * @subpackage Tests
 */

/**
 * Testing the SQL expression abstraction layer.
 * This file tests that the methods actually produce correct output for the base
 * implementation regardless of how they methods are called. The _impl file tests
 * the same again, but with full SQL calls, only using one call type and on the database.
 *
 * @package Database
 * @subpackage Tests
 * @todo, test with null input values
 */
class ezcQueryExpressionTest extends ezcTestCase
{
    private $q;
    private $e;
    private $db;

    protected function setUp()
    {
        try {
            $this->db = ezcDbInstance::get();
        }
        catch ( Exception $e )
        {
            $this->markTestSkipped();
        }

        $this->q = $this->db->createSelectQuery();
        $this->e = $this->db->createExpression();
        $this->assertNotNull( $this->db, 'Database instance is not initialized.' );

        try
        {
            $this->db->exec( 'DROP TABLE query_test' );
        }
        catch ( Exception $e ) {} // eat

        // insert some data
        $this->db->exec( 'CREATE TABLE query_test ( id int, company VARCHAR(255), section VARCHAR(255), employees int )' );
        $this->db->exec( "INSERT INTO query_test VALUES ( 1, 'eZ systems', 'Norway', 20 )" );
        $this->db->exec( "INSERT INTO query_test VALUES ( 2, 'IBM', 'Norway', 500 )" );
        $this->db->exec( "INSERT INTO query_test VALUES ( 3, 'eZ systems', 'Ukraine', 10 )" );
        $this->db->exec( "INSERT INTO query_test VALUES ( 4, 'IBM', 'Germany', null )" );
    }

    protected function tearDown()
    {
        $this->db->exec( 'DROP TABLE query_test' );
    }

    public static function suite()
    {
        return new PHPUnit_Framework_TestSuite( 'ezcQueryExpressionTest' );
    }

    public function testLorNone()
    {
        try
        {
            $this->e->lOr();
            $this->fail( "Expected exception" );
        }
        catch( ezcQueryVariableParameterException $e ) {}
    }

    public function testlOrSingle()
    {
        $reference = 'true';
        $this->assertEquals( $reference, $this->e->lOr( 'true' ) );
    }

    public function testlOrMulti()
    {
        $reference = '( true OR false )';
        $this->assertEquals( $reference, $this->e->lOr( 'true', 'false' ) );
    }

    public function testlAndNone()
    {
        try
        {
            $this->e->lAnd();
            $this->fail( "Expected exception" );
        }
        catch( ezcQueryVariableParameterException $e ) {}
    }

    public function testlAndSingle()
    {
        $reference = 'true';
        $this->assertEquals( $reference, $this->e->lAnd( 'true' ) );
    }

    public function testlAndMulti()
    {
        $reference = '( true AND false )';
        $this->assertEquals( $reference, $this->e->lAnd( 'true', 'false' ) );
    }

    public function testNot()
    {
        $reference = 'NOT ( true )';
        $this->assertEquals( $reference, $this->e->not( 'true' ) );
    }

    public function testAddNone()
    {
        try
        {
            $this->e->add();
            $this->fail( "Expected exception" );
        }
        catch( ezcQueryVariableParameterException $e ) {}
    }

    public function testAddSingle()
    {
        $reference = '1';
        $this->assertEquals( $reference, (string)$this->e->add( 1 ) );
    }

    public function testlAddMulti()
    {
        $reference = '( 1 + 1 )';
        $this->assertEquals( $reference, $this->e->add( 1, 1 ) );
    }

    public function testSubtractNone()
    {
        try
        {
            $this->e->sub();
            $this->fail( "Expected exception" );
        }
        catch( ezcQueryVariableParameterException $e ) {}
    }

    public function testSubtractSingle()
    {
        $reference = '1';
        $this->assertEquals( $reference, (string)$this->e->sub( 1 ) );
    }

    public function testlSubtractMulti()
    {
        $reference = '( 1 - 1 )';
        $this->assertEquals( $reference, $this->e->sub( 1, 1 ) );
    }

    public function testMultiplyNone()
    {
        try
        {
            $this->e->mul();
            $this->fail( "Expected exception" );
        }
        catch( ezcQueryVariableParameterException $e ) {}
    }

    public function testMultiplySingle()
    {
        $reference = '1';
        $this->assertEquals( $reference, (string)$this->e->mul( 1 ) );
    }

    public function testlMultiplyMulti()
    {
        $reference = '( 1 * 1 )';
        $this->assertEquals( $reference, $this->e->mul( 1, 1 ) );
    }

    public function testDivideNone()
    {
        try
        {
            $this->e->div();
            $this->fail( "Expected exception" );
        }
        catch( ezcQueryVariableParameterException $e ) {}
    }

    public function testDivideSingle()
    {
        $reference = '1';
        $this->assertEquals( $reference, (string)$this->e->div( 1 ) );
    }

    public function testlDivideMulti()
    {
        $reference = '( 1 / 1 )';
        $this->assertEquals( $reference, $this->e->div( 1, 1 ) );
    }

    public function testEq()
    {
        $reference = 'field1 = field2';
        $this->assertEquals( $reference, $this->e->eq( 'field1', 'field2' ) );
    }

    public function testNeq()
    {
        $reference = 'field1 <> field2';
        $this->assertEquals( $reference, $this->e->neq( 'field1', 'field2' ) );
    }

    public function testGt()
    {
        $reference = 'field1 > field2';
        $this->assertEquals( $reference, $this->e->gt( 'field1', 'field2' ) );
    }

    public function testGte()
    {
        $reference = 'field1 >= field2';
        $this->assertEquals( $reference, $this->e->gte( 'field1', 'field2' ) );
    }

    public function testLt()
    {
        $reference = 'field1 < field2';
        $this->assertEquals( $reference, $this->e->lt( 'field1', 'field2' ) );
    }

    public function testLte()
    {
        $reference = 'field1 <= field2';
        $this->assertEquals( $reference, $this->e->lte( 'field1', 'field2' ) );
    }

    public function testInNone()
    {
        try
        {
            $this->e->in( 'id' );
            $this->fail( "Expected exception" );
        }
        catch( ezcQueryVariableParameterException $e ) {}
    }

    public function testInSingle()
    {
        $reference = 'id IN ( 1 )';
        $this->assertEquals( $reference, $this->e->in( 'id', 1 ) );
    }

    public function testInMulti()
    {
        $reference = 'id IN ( 1, 2 )';
        $this->assertEquals( $reference, $this->e->in( 'id', 1, 2 ) );
    }

    public function testIsNull()
    {
        $reference = 'id IS NULL';
        $this->assertEquals( $reference, $this->e->isNull( 'id' ) );
    }

    public function testBetween()
    {
        $reference = 'id BETWEEN 10 AND 20';
        $this->assertEquals( $reference, $this->e->between( 'id', 10, 20 ) );
    }

    public function testLike()
    {
        $reference = 'column LIKE :data';
        $this->assertEquals( $reference, $this->e->like( 'column', ':data' ) );
    }

    public function testAvg()
    {
        $reference = 'AVG( name )';
        $this->assertEquals( $reference, $this->e->avg( 'name' ) );
    }

    public function testCount()
    {
        $reference = 'COUNT( name )';
        $this->assertEquals( $reference, $this->e->count( 'name' ) );
    }

    public function testMax()
    {
        $reference = 'MAX( name )';
        $this->assertEquals( $reference, $this->e->max( 'name' ) );
    }

    public function testMin()
    {
        $reference = 'MIN( name )';
        $this->assertEquals( $reference, $this->e->min( 'name' ) );
    }

    public function testSum()
    {
        $reference = 'SUM( name )';
        $this->assertEquals( $reference, $this->e->sum( 'name' ) );
    }

    public function testMd5()
    {
        $reference = 'MD5( name )';
        $this->assertEquals( $reference, $this->e->md5( 'name' ) );
    }

    public function testLength()
    {
        $reference = 'LENGTH( name )';
        $this->assertEquals( $reference, $this->e->length( 'name' ) );
    }

    public function testRound()
    {
        $reference = 'ROUND( name, 2 )';
        $this->assertEquals( $reference, $this->e->round( 'name', 2 ) );
    }

    public function testMod()
    {
        $reference = 'MOD( 10, 3 )';
        $this->assertEquals( $reference, $this->e->mod( 10, 3 ) );
    }

    public function testNow()
    {
        $reference = 'NOW()';
        $this->assertEquals( $reference, $this->e->now() );
    }

    public function testConcatNone()
    {
        try
        {
            $this->e->concat();
            $this->fail( "Expected exception" );
        }
        catch( ezcQueryVariableParameterException $e ) {}
    }

    /**
     * Implementation tests, these are run on a selectQuery object so we know
     * we have the correct expression type.
     */
    public function testlOrSingleImpl()
    {
        $this->q->select( '*' )->from( 'query_test' )
            ->where( $this->e->lOr( $this->e->eq( 1, 1 ) ) );
        $stmt = $this->db->query( $this->q->getQuery() );
        $rows = 0;
        foreach ( $stmt as $row )
        {
            $rows++;
        }
        $this->assertEquals( 4, $rows );
    }

    public function testlOrMultiImpl()
    {
        $this->q->select( '*' )->from( 'query_test' )
            ->where( $this->e->lOr( $this->e->eq( 1, 1 ), $this->e->eq( 1, 0 ) ) );
        $stmt = $this->db->query( $this->q->getQuery() );
        $rows = 0;
        foreach ( $stmt as $row )
        {
            $rows++;
        }
        $this->assertEquals( 4, $rows );
    }

    public function testlAndSingleImpl()
    {
        $this->q->select( '*' )->from( 'query_test' )
            ->where( $this->e->lAnd( $this->e->eq( 1, 1 ) ) );
        $stmt = $this->db->query( $this->q->getQuery() );
        $rows = 0;
        foreach ( $stmt as $row )
        {
            $rows++;
        }
        $this->assertEquals( 4, $rows );
    }

    public function testlAndMultiImpl()
    {
        $this->q->select( '*' )->from( 'query_test' )
            ->where( $this->e->lAnd( $this->e->eq( 1, 1 ), $this->e->eq( 1, 0 ) ) );
        $stmt = $this->db->query( $this->q->getQuery() );
        $rows = 0;
        foreach ( $stmt as $row )
        {
            $rows++;
        }
        $this->assertEquals( 0, $rows );
    }

    public function testNotImpl()
    {
        $this->q->select( '*' )->from( 'query_test' )
                ->where( $this->e->not( $this->e->lAnd( $this->e->eq( 1, 1 ) ) ) );
        $stmt = $this->db->query( $this->q->getQuery() );
        $rows = 0;
        foreach ( $stmt as $row )
        {
            $rows++;
        }
        $this->assertEquals( 0, $rows );
    }

    public function testAddImpl()
    {
        $this->q->select( $this->e->add( 2, 2 ) );
        $stmt = $this->q->prepare();
        $stmt->execute();
        $this->assertEquals( 4, (int)$stmt->fetchColumn( 0 ) );
    }

    public function testSubtractImpl()
    {
        $this->q->select( $this->e->sub( 2, 2 ) );
        $stmt = $this->q->prepare();
        $stmt->execute();
        $this->assertEquals( 0, (int)$stmt->fetchColumn( 0 ) );
    }

    public function testMultiplyImpl()
    {
        $this->q->select( $this->e->mul( 2, 3 ) );
        $stmt = $this->q->prepare();
        $stmt->execute();
        $this->assertEquals( 6, (int)$stmt->fetchColumn( 0 ) );
    }

    public function testDivideImpl()
    {
        $this->q->select( $this->e->div( 2, 2 ) );
        $stmt = $this->q->prepare();
        $stmt->execute();
        $this->assertEquals( 1, (int)$stmt->fetchColumn( 0 ) );
    }

    public function testEqImpl()
    {
        $this->q->select( '*' )->from( 'query_test' )
            ->where( $this->e->eq( 'id', 1  ) );
        $stmt = $this->db->query( $this->q->getQuery() );
        $rows = 0;
        foreach ( $stmt as $row )
        {
            $rows++;
        }
        $this->assertEquals( 1, $rows );
    }

    public function testNeqImpl()
    {
        $this->q->select( '*' )->from( 'query_test' )
            ->where( $this->e->neq( 'id', 1  ) );
        $stmt = $this->db->query( $this->q->getQuery() );
        $rows = 0;
        foreach ( $stmt as $row )
        {
            $rows++;
        }
        $this->assertEquals( 3, $rows );
    }

    public function testGtImpl()
    {
        $this->q->select( '*' )->from( 'query_test' )
            ->where( $this->e->gt( 'id', 1  ) );
        $stmt = $this->db->query( $this->q->getQuery() );
        $rows = 0;
        foreach ( $stmt as $row )
        {
            $rows++;
        }
        $this->assertEquals( 3, $rows );
    }

    public function testGteImpl()
    {
        $this->q->select( '*' )->from( 'query_test' )
            ->where( $this->e->gte( 'id', 1  ) );
        $stmt = $this->db->query( $this->q->getQuery() );
        $rows = 0;
        foreach ( $stmt as $row )
        {
            $rows++;
        }
        $this->assertEquals( 4, $rows );
    }

    public function testLtImpl()
    {
        $this->q->select( '*' )->from( 'query_test' )
            ->where( $this->e->lt( 'id', 4  ) );
        $stmt = $this->db->query( $this->q->getQuery() );
        $rows = 0;
        foreach ( $stmt as $row )
        {
            $rows++;
        }
        $this->assertEquals( 3, $rows );
    }

    public function testLteImpl()
    {
        $this->q->select( '*' )->from( 'query_test' )
            ->where( $this->e->lte( 'id', 4  ) );
        $stmt = $this->db->query( $this->q->getQuery() );
        $rows = 0;
        foreach ( $stmt as $row )
        {
            $rows++;
        }
        $this->assertEquals( 4, $rows );
    }

    public function testInSingleImpl()
    {
        $this->q->select( '*' )->from( 'query_test' )
            ->where( $this->e->in( 'id', 1 ) );
        $stmt = $this->db->query( $this->q->getQuery() );
        $rows = 0;
        foreach ( $stmt as $row )
        {
            $rows++;
        }
        $this->assertEquals( 1, $rows );
    }

    public function testInMultiImpl()
    {
        $this->q->select( '*' )->from( 'query_test' )
            ->where( $this->e->in( 'id', 1 , 3 ) );
        $stmt = $this->db->query( $this->q->getQuery() );
        $rows = 0;
        foreach ( $stmt as $row )
        {
            $rows++;
        }
        $this->assertEquals( 2, $rows );
    }

    public function testIsNullImpl()
    {
        $this->q->select( '*' )->from( 'query_test' )
            ->where( $this->e->isNull( 'employees' ) );
        $stmt = $this->db->query( $this->q->getQuery() );
        $rows = 0;
        foreach ( $stmt as $row )
        {
            $rows++;
        }
        $this->assertEquals( 1, $rows );
    }

    public function testBetweenImpl()
    {
        $this->q->select( '*' )->from( 'query_test' )
            ->where( $this->e->between( 'id', 1 , 3 ) );
        $stmt = $this->db->query( $this->q->getQuery() );
        $rows = 0;
        foreach ( $stmt as $row )
        {
            $rows++;
        }
        $this->assertEquals( 3, $rows );
    }

    public function testLikeImpl()
    {
        $pattern = 'eZ%';
        $this->q->select( '*' )->from( 'query_test' )
            ->where( $this->e->like( 'company', $this->q->bindParam( $pattern ) ) );
        $stmt = $this->q->prepare();
        $stmt->execute();
        $rows = 0;
        foreach ( $stmt as $row )
        {
            $rows++;
        }
        $this->assertEquals( 2, $rows );
    }

    public function testAvgImpl()
    {
        $company = 'eZ systems';
        $this->q->select( 'company',
                          $this->e->avg( 'employees' ) )
            ->from( 'query_test' )
            ->where( $this->e->eq( 'company', $this->q->bindParam( $company ) ) )
            ->groupBy( 'company' );
        $stmt = $this->q->prepare();
        $stmt->execute();

        $this->assertEquals( 15, (int)$stmt->fetchColumn( 1 ) );
    }

    public function testCountImpl()
    {
        $this->q->select( $this->e->count( '*' ) )->from( 'query_test' )
                ->where( $this->e->eq( 'employees', 20 ) );
        $stmt = $this->db->query( $this->q->getQuery() );

        $this->assertEquals( 1, (int)$stmt->fetchColumn( 0 ) );
    }

    public function testMaxImpl()
    {
        $company = 'eZ systems';
        $this->q->select( 'company',
                          $this->e->max( 'employees' ) )
            ->from( 'query_test' )
            ->where( $this->e->eq( 'company', $this->q->bindParam( $company ) ) )
            ->groupBy( 'company' );
        $stmt = $this->q->prepare();
        $stmt->execute();

        $this->assertEquals( 20, (int)$stmt->fetchColumn( 1 ) );
    }

    public function testMinImpl()
    {
        $company = 'eZ systems';
        $this->q->select( 'company',
                          $this->e->min( 'employees' ) )
            ->from( 'query_test' )
            ->where( $this->e->eq( 'company', $this->q->bindParam( $company ) ) )
            ->groupBy( 'company' );
        $stmt = $this->q->prepare();
        $stmt->execute();

        $this->assertEquals( 10, (int)$stmt->fetchColumn( 1 ) );
    }

    public function testSumImpl()
    {
        $company = 'eZ systems';
        $this->q->select( 'company',
                          $this->e->sum( 'employees' ) )
            ->from( 'query_test' )
            ->where( $this->e->eq( 'company', $this->q->bindParam( $company ) ) )
            ->groupBy( 'company' );
        $stmt = $this->q->prepare();
        $stmt->execute();

        $this->assertEquals( 30, (int)$stmt->fetchColumn( 1 ) );
    }

    public function testMd5Impl()
    {
        $company = 'eZ systems';
        $this->q->select( 'company',
                          $this->e->md5( $this->e->round( $this->e->avg( 'employees' ), 0 ) ) )
            ->from( 'query_test' )
            ->where( $this->e->eq( 'company', $this->q->bindParam( $company ) ) )
            ->groupBy( 'company' );
        $stmt = $this->q->prepare();
        $stmt->execute();

        $this->assertEquals( '9bf31c7ff062936a96d3c8bd1f8f2ff3',
                             $stmt->fetchColumn( 1 ) );
    }

    public function testLengthImpl()
    {
        $q = $this->q;
        $var = 'four';
        $q->select( $q->expr->length( $q->bindParam( $var ) ) );
        $stmt = $this->q->prepare();
        $stmt->execute();

        $this->assertEquals( 4, (int)$stmt->fetchColumn( 0 ) );
    }

    public function testRoundImpl()
    {
        $q = $this->q;
        $q->select( $q->expr->round( '10.123', 2 ) );
        $stmt = $this->q->prepare();
        $stmt->execute();
        $this->assertEquals( '10.12', $stmt->fetchColumn( 0 ) );
    }

    public function testModImpl()
    {
        $q = $this->q;
        $q->select( $q->expr->mod( 3, 2 ) );
        $stmt = $this->q->prepare();
        $stmt->execute();
        $this->assertEquals( 1, (int)$stmt->fetchColumn( 0 ) );
    }

    public function testNowImpl()
    {
        $q = $this->q;
        $q->select( $q->expr->gt( $q->expr->now(), 0 ) ); // if it fails now() did not work
        $stmt = $this->q->prepare();
        $stmt->execute();
    }

    public function testSubstringImpl()
    {
        $q = $this->q;
        $q->select( $q->expr->subString( 'company', 4 ) )->from( 'query_test' )->where( $q->expr->eq( 'id', 1 ) );
        $stmt = $this->q->prepare();
        $stmt->execute();
        $this->assertEquals( 'systems', $stmt->fetchColumn( 0 ) );
    }

    public function testConcatSingleImpl()
    {
        $q = $this->q;
        $q->select( $q->expr->concat( 'company' ) )->from( 'query_test' )->where( $q->expr->eq( 'id', 1 ) );
        $stmt = $this->q->prepare();
        $stmt->execute();
        $this->assertEquals( 'eZ systems', $stmt->fetchColumn( 0 ) );
    }

    public function testConcatMultiImpl()
    {
        $str = ' rocks!';
        $q = $this->q;
        $q->select( $q->expr->concat( 'company', $q->bindParam( $str ) ) )->from( 'query_test' )
            ->where( $q->expr->eq( 'id', 1 ) );
        $stmt = $this->q->prepare();
        $stmt->execute();
        $this->assertEquals( 'eZ systems rocks!', $stmt->fetchColumn( 0 ) );
    }

    /**
     * Repeat of the implementation tests, but now testing with alias functionality.
     */
// Not tested since it requires boolean field
//    public function testNotImplWithAlias()
//    {
//        $this->q->setAliases( array( 'identifier' => 'id' ) );
//        $this->q->select( '*' )->from( 'query_test' )
//                ->where( $this->e->not( 'identifier' ) );
//        $stmt = $this->db->query( $this->q->getQuery() );
//        $rows = 0;
//        foreach ( $stmt as $row )
//        {
//            $rows++;
//        }
//        $this->assertEquals( 0, $rows );
//    }

    public function testAddImplWithAlias()
    {
        $this->q->setAliases( array( 'identifier' => 'id' ) );
        $this->q->select( $this->q->expr->add( 'identifier', 2 ) )->from( 'query_test' )->where( $this->q->expr->eq( 'id', 2 ) );;
        $stmt = $this->q->prepare();
        $stmt->execute();
        $this->assertEquals( 4, (int)$stmt->fetchColumn( 0 ) );
    }

    public function testSubtractImplWithAlias()
    {
        $this->q->setAliases( array( 'identifier' => 'id' ) );
        $this->q->select( $this->q->expr->sub( 'identifier', 2 ) )->from( 'query_test' )->where( $this->q->expr->eq( 'id', 4 ) );;
        $stmt = $this->q->prepare();
        $stmt->execute();
        $this->assertEquals( 2, (int)$stmt->fetchColumn( 0 ) );
    }

    public function testMultiplyImplWithAlias()
    {
        $this->q->setAliases( array( 'identifier' => 'id' ) );
        $this->q->select( $this->q->expr->mul( 'identifier', 2 ) )->from( 'query_test' )->where( $this->q->expr->eq( 'id', 2 ) );;
        $stmt = $this->q->prepare();
        $stmt->execute();
        $this->assertEquals( 4, (int)$stmt->fetchColumn( 0 ) );
    }

    public function testDivideImplWithAlias()
    {
        $this->q->setAliases( array( 'identifier' => 'id' ) );
        $this->q->select( $this->q->expr->div( 'identifier', 2 ) )->from( 'query_test' )->where( $this->q->expr->eq( 'id', 4 ) );;
        $stmt = $this->q->prepare();
        $stmt->execute();
        $this->assertEquals( 2, (int)$stmt->fetchColumn( 0 ) );
    }

    public function testEqImplWithAlias()
    {
        $this->q->setAliases( array( 'identifier' => 'id' ) );
        $this->q->select( '*' )->from( 'query_test' )
            ->where( $this->q->expr->eq( 'identifier', 'identifier'  ) );
        $stmt = $this->db->query( $this->q->getQuery() );
        $rows = 0;
        foreach ( $stmt as $row )
        {
            $rows++;
        }
        $this->assertEquals( 4, $rows );
    }



    public function testNeqImplWithAlias()
    {
        $this->q->setAliases( array( 'identifier' => 'id' ) );
        $this->q->select( '*' )->from( 'query_test' )
            ->where( $this->q->expr->neq( 'id', 1  ) );
        $stmt = $this->db->query( $this->q->getQuery() );
        $rows = 0;
        foreach ( $stmt as $row )
        {
            $rows++;
        }
        $this->assertEquals( 3, $rows );
    }

    public function testGtImplWithAlias()
    {
        $this->q->setAliases( array( 'identifier' => 'id' ) );
        $this->q->select( '*' )->from( 'query_test' )
            ->where( $this->q->expr->gt( 'identifier', 'identifier'  ) );
        $stmt = $this->db->query( $this->q->getQuery() );
        $rows = 0;
        foreach ( $stmt as $row )
        {
            $rows++;
        }
        $this->assertEquals( 0, $rows );
    }

    public function testGteImplWithAlias()
    {
        $this->q->setAliases( array( 'identifier' => 'id' ) );
        $this->q->select( '*' )->from( 'query_test' )
            ->where( $this->q->expr->gte( 'identifier', 'identifier'  ) );
        $stmt = $this->db->query( $this->q->getQuery() );
        $rows = 0;
        foreach ( $stmt as $row )
        {
            $rows++;
        }
        $this->assertEquals( 4, $rows );
    }

    public function testLtImplWithAlias()
    {
        $this->q->setAliases( array( 'identifier' => 'id' ) );
        $this->q->select( '*' )->from( 'query_test' )
            ->where( $this->q->expr->lt( 'identifier', 'identifier'  ) );
        $stmt = $this->db->query( $this->q->getQuery() );
        $rows = 0;
        foreach ( $stmt as $row )
        {
            $rows++;
        }
        $this->assertEquals( 0, $rows );
    }

    public function testLteImplWithAlias()
    {
        $this->q->setAliases( array( 'identifier' => 'id' ) );
        $this->q->select( '*' )->from( 'query_test' )
            ->where( $this->q->expr->lte( 'identifier', 'identifier'  ) );
        $stmt = $this->db->query( $this->q->getQuery() );
        $rows = 0;
        foreach ( $stmt as $row )
        {
            $rows++;
        }
        $this->assertEquals( 4, $rows );
    }

    public function testInMultiImplWithAlias()
    {
        $this->q->setAliases( array( 'identifier' => 'id' ) );
        $this->q->select( '*' )->from( 'query_test' )
            ->where( $this->q->expr->in( 'identifier', 1 , 'identifier' ) );
        $stmt = $this->db->query( $this->q->getQuery() );
        $rows = 0;
        foreach ( $stmt as $row )
        {
            $rows++;
        }
        $this->assertEquals( 4, $rows );
    }

    public function testIsNullImplWithAlias()
    {
        $this->q->setAliases( array( 'identifier' => 'id' ) );
        $this->q->select( '*' )->from( 'query_test' )
            ->where( $this->q->expr->isNull( 'identifier' ) );
        $stmt = $this->db->query( $this->q->getQuery() );
        $rows = 0;
        foreach ( $stmt as $row )
        {
            $rows++;
        }
        $this->assertEquals( 0, $rows );
    }

    public function testBetweenImplWithAlias()
    {
        $this->q->setAliases( array( 'identifier' => 'id' ) );
        $this->q->select( '*' )->from( 'query_test' )
            ->where( $this->q->expr->between( 'identifier', 'identifier' , 'identifier' ) );
        $stmt = $this->db->query( $this->q->getQuery() );
        $rows = 0;
        foreach ( $stmt as $row )
        {
            $rows++;
        }
        $this->assertEquals( 4, $rows );
    }

    public function testLikeImplWithAlias()
    {
        $this->q->setAliases( array( 'identifier' => 'id', 'text' => 'company' ) );
        $pattern = 'eZ%';
        $this->q->select( '*' )->from( 'query_test' )
            ->where( $this->q->expr->like( 'text', $this->q->bindParam( $pattern ) ) );
        $stmt = $this->q->prepare();
        $stmt->execute();
        $rows = 0;
        foreach ( $stmt as $row )
        {
            $rows++;
        }
        $this->assertEquals( 2, $rows );
    }

    public function testAvgImplWithAlias()
    {
        $this->q->setAliases( array( 'text' => 'company', 'empl' => 'employees' ) );
        $company = 'eZ systems';
        $this->q->select( 'text',
                          $this->q->expr->avg( 'empl' ) )
            ->from( 'query_test' )
            ->where( $this->q->expr->eq( 'text', $this->q->bindParam( $company ) ) )
            ->groupBy( 'text' );
        $stmt = $this->q->prepare();
        $stmt->execute();

        $this->assertEquals( 15, (int)$stmt->fetchColumn( 1 ) );
    }

    public function testCountImplWithAlias()
    {
        $this->q->setAliases( array( 'text' => 'company', 'empl' => 'employees' ) );
        $this->q->select( $this->q->expr->count( 'text' ) )->from( 'query_test' )
                ->where( $this->q->expr->eq( 'employees', 20 ) );
        $stmt = $this->db->query( $this->q->getQuery() );

        $this->assertEquals( 1, (int)$stmt->fetchColumn( 0 ) );
    }

    public function testMaxImplWithAlias()
    {
        $this->q->setAliases( array( 'text' => 'company', 'empl' => 'employees' ) );
        $company = 'eZ systems';
        $this->q->select( 'company',
                          $this->q->expr->max( 'empl' ) )
            ->from( 'query_test' )
            ->where( $this->q->expr->eq( 'text', $this->q->bindParam( $company ) ) )
            ->groupBy( 'text' );
        $stmt = $this->q->prepare();
        $stmt->execute();

        $this->assertEquals( 20, (int)$stmt->fetchColumn( 1 ) );
    }

    public function testMinImplWithAlias()
    {
        $this->q->setAliases( array( 'text' => 'company', 'empl' => 'employees' ) );
        $company = 'eZ systems';
        $this->q->select( 'text',
                          $this->q->expr->min( 'empl' ) )
            ->from( 'query_test' )
            ->where( $this->q->expr->eq( 'text', $this->q->bindParam( $company ) ) )
            ->groupBy( 'text' );
        $stmt = $this->q->prepare();
        $stmt->execute();

        $this->assertEquals( 10, (int)$stmt->fetchColumn( 1 ) );
    }

    public function testSumImplWithAlias()
    {
        $this->q->setAliases( array( 'text' => 'company', 'empl' => 'employees' ) );
        $company = 'eZ systems';
        $this->q->select( 'text',
                          $this->q->expr->sum( 'empl' ) )
            ->from( 'query_test' )
            ->where( $this->q->expr->eq( 'text', $this->q->bindParam( $company ) ) )
            ->groupBy( 'text' );
        $stmt = $this->q->prepare();
        $stmt->execute();

        $this->assertEquals( 30, (int)$stmt->fetchColumn( 1 ) );
    }

    public function testMd5ImplWithAlias()
    {
        $this->q->setAliases( array( 'text' => 'company', 'empl' => 'employees' ) );
        $company = 'eZ systems';
        $this->q->select( 'text',
                          $this->q->expr->md5( $this->q->expr->round( $this->q->expr->avg( 'empl' ), 0 ) ) )
            ->from( 'query_test' )
            ->where( $this->q->expr->eq( 'text', $this->q->bindParam( $company ) ) )
            ->groupBy( 'text' );
        $stmt = $this->q->prepare();
        $stmt->execute();

        $this->assertEquals( '9bf31c7ff062936a96d3c8bd1f8f2ff3',
                             $stmt->fetchColumn( 1 ) );
    }

    public function testLengthImplWithAlias()
    {
        $this->q->setAliases( array( 'text' => 'company', 'empl' => 'employees' ) );
        $q = $this->q;
        $var = 'four';
        $q->select( $q->expr->length( 'text'  ) )->from( 'query_test' )->where( $q->expr->eq( 'id', 2 ) );
        $stmt = $this->q->prepare();
        $stmt->execute();

        $this->assertEquals( 3, (int)$stmt->fetchColumn( 0 ) );
    }

    public function testRoundImplWithAlias()
    {
        $this->q->setAliases( array( 'text' => 'company', 'empl' => 'employees' ) );
        $q = $this->q;
        $q->select( $q->expr->round( 'empl', 2 ) )->from( 'query_test' )->where( $q->expr->eq( 'id', 2 ) );
        $stmt = $this->q->prepare();
        $stmt->execute();
        $this->assertEquals( '500.00', $stmt->fetchColumn( 0 ) );
    }

    public function testModImplWithAlias()
    {
        $this->q->setAliases( array( 'text' => 'company', 'empl' => 'employees' ) );
        $q = $this->q;
        $q->select( $q->expr->mod( 'employees', 'employees' ) )->from( 'query_test' );
        $stmt = $this->q->prepare();
        $stmt->execute();
        $this->assertEquals( 0, (int)$stmt->fetchColumn( 0 ) );
    }

    public function testSubstringImplWithAlias()
    {
        $this->q->setAliases( array( 'text' => 'company', 'empl' => 'employees' ) );
        $q = $this->q;
        $q->select( $q->expr->subString( 'text', 4 ) )->from( 'query_test' )->where( $q->expr->eq( 'id', 1 ) );
        $stmt = $this->q->prepare();
        $stmt->execute();
        $this->assertEquals( 'systems', $stmt->fetchColumn( 0 ) );
    }

    public function testConcatSingleImplWithAlias()
    {
        $this->q->setAliases( array( 'text' => 'company', 'empl' => 'employees' ) );
        $q = $this->q;
        $q->select( $q->expr->concat( 'text' ) )->from( 'query_test' )->where( $q->expr->eq( 'id', 1 ) );
        $stmt = $this->q->prepare();
        $stmt->execute();
        $this->assertEquals( 'eZ systems', $stmt->fetchColumn( 0 ) );
    }

    public function testConcatMultiImplWithAlias()
    {
        $this->q->setAliases( array( 'text' => 'company', 'empl' => 'employees' ) );
        $str = ' rocks!';
        $q = $this->q;
        $q->select( $q->expr->concat( 'text', $q->bindParam( $str ) ) )->from( 'query_test' )
            ->where( $q->expr->eq( 'id', 1 ) );
        $stmt = $this->q->prepare();
        $stmt->execute();
        $this->assertEquals( 'eZ systems rocks!', $stmt->fetchColumn( 0 ) );
    }

    public function testBug9159TableAndColumnAlias()
    {
        $reference = 'SELECT * FROM table1, table2 WHERE table1.column < table2.id';
        
        $this->q->setAliases( array( 't_alias' => 'table1', 'c_alias' => 'column' ) );
        
        $this->q->select( '*' )
        ->from( 't_alias', 'table2' )
        ->where( $this->q->expr->lt('t_alias.c_alias', 'table2.id' ) );
        
        $this->assertEquals( $reference, $this->q->getQuery() );
    }

}
?>
