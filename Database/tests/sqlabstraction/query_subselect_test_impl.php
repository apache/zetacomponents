<?php
/**
 * @copyright Copyright (C) 2005-2010 eZ Systems AS. All rights reserved.
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
class ezcQuerySubSelectTestImpl extends ezcTestCase
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
        $this->db->exec( "INSERT INTO query_test2 VALUES ( 5, 'Intel', 'USA', 5000 )" );
    }

    protected function tearDown()
    {
        if ( $this->db === null ) return;

        $this->db->exec( 'DROP TABLE query_test' );
        $this->db->exec( 'DROP TABLE query_test2' );
    }

    public function testSubSelect()
    {
        $name = 'IBM';
        $name2 = 'company';
        $q = new ezcQuerySelect( ezcDbInstance::get() );
        $q->expr->setValuesQuoting( false );

        // subselect
        $q2 = $q->subSelect();

        // bind values
        $q2->select('company')
                ->from( 'query_test' )
                    ->where( $q2->expr->eq( 'company', "'IBM'" ), ' id > 2 ' );

        $q->select('*')->from( 'query_test' )
                        ->where( ' id >= 1 ', $q->expr->in( 'company', $q2->getQuery() ) )
                        ->orderBy( 'id' );
        
        $stmt = $q->prepare();
        $stmt->execute();

        $result = $stmt->fetchAll();
        $this->assertEquals( 'IBM', $result[0]['company'] );
        $this->assertEquals( 'Norway', $result[0]['section'] );
        $this->assertEquals( 'IBM', $result[1]['company'] );
        $this->assertEquals( 'Germany', $result[1]['section'] );
    }

    public function testInnerDistinctSubSelectBindParamMySQL()
    {
        $db = ezcDbInstance::get();
        if ( get_class( $db ) !== 'ezcDbHandlerMysql' ) 
        {
            $this->markTestSkipped( 'Test defined for MySQL handler class only.' );
        }
        $name = 'IBM';
        $name2 = 'company';
        $q = new ezcQuerySelect( ezcDbInstance::get() );

        // subselect
        $q2 = $q->subSelect();
        $q->expr->setValuesQuoting( false );

        // bind values
        $q2->selectDistinct( 'section' )
                ->from( 'query_test' )
                ->where( ' id = 1 OR id = 2 ');

        $q->selectDistinct( 'company' )
            ->from( 'query_test2' )
            ->where( $q->expr->in( 'section', $q2->getQuery() ) )
            ->orderBy( 'company', ezcQuerySelect::ASC );
        $stmt = $q->prepare();
        $stmt->execute();

        $result = $stmt->fetchAll();

        $this->assertEquals( 'eZ systems', $result[0]['company'] );
        $this->assertEquals( 'IBM', $result[1]['company'] );

        $this->assertSame( 2, count( $result ) );
    }

    public function testInnerDistinctSubSelectBindParamGeneric()
    {
        $db = ezcDbInstance::get();
        if ( get_class( $db ) === 'ezcDbHandlerMysql' ) 
        {
            $this->markTestSkipped( 'Test defined for non-MySQL handler class only.' );
        }
        $name = 'IBM';
        $name2 = 'company';
        $q = new ezcQuerySelect( ezcDbInstance::get() );

        // subselect
        $q2 = $q->subSelect();
        $q->expr->setValuesQuoting( false );

        // bind values
        $q2->selectDistinct( 'section' )
                ->from( 'query_test' )
                ->where( ' id = 1 OR id = 2 ');

        $q->selectDistinct( 'company' )
            ->from( 'query_test2' )
            ->where( $q->expr->in( 'section', $q2->getQuery() ) )
            ->orderBy( 'company', ezcQuerySelect::ASC );
        $stmt = $q->prepare();
        $stmt->execute();

        $result = $stmt->fetchAll();

        $this->assertEquals( 'eZ systems', $result[1]['company'] );
        $this->assertEquals( 'IBM', $result[0]['company'] );

        $this->assertSame( 2, count( $result ) );
    }

    public function testSubSelectBindParam()
    {
        $name = 'IBM';
        $name2 = 'company';
        $q = new ezcQuerySelect( ezcDbInstance::get() );

        // subselect
        $q2 = $q->subSelect();
        $q->expr->setValuesQuoting( false );

        // bind values
        $q2->select('company')
                ->from( 'query_test' )
                    ->where( $q2->expr->eq( 'company', $q2->bindParam( $name ) ), ' id > 2 ' );

        $q->select('*')->from( 'query_test' )
                        ->where( ' id >= 1 ', $q->expr->in( 'company', $q2->getQuery() ) )
                        ->orderBy( 'id' );

        $stmt = $q->prepare();
        $stmt->execute();

        $result = $stmt->fetchAll();
        $this->assertEquals( 'IBM', $result[0]['company'] );
        $this->assertEquals( 'Norway', $result[0]['section'] );
        $this->assertEquals( 'IBM', $result[1]['company'] );
        $this->assertEquals( 'Germany', $result[1]['section'] );
    }

    public function testSubSubSelect()
    {
        $name = 'IBM';
        $name2 = 'company';
        $q = new ezcQuerySelect( ezcDbInstance::get() );
        $q->expr->setValuesQuoting( false );

        // subselect
        $q2 = $q->subSelect();

        // sub subselect
        $q3 = $q2->subSelect();
        $q3->expr->setValuesQuoting( false );

        $q3->select('*')
            ->from( 'query_test2' )
                ->where( $q3->expr->in( 'company', 'IBM', 'eZ systems' ) );

        // bind values
        $q2->select('company')
                ->from( 'query_test' )
                    ->where( $q2->expr->eq( 'company', $q2->bindParam( $name ) ), ' id > 2 ' );

        $q->select('*')->from( 'query_test' )
                        ->where( ' id >= 1 ', $q->expr->in( 'company', $q2->getQuery() ) )
                        ->orderBy( 'id' );
        
        $stmt = $q->prepare();
        $stmt->execute();
        
        $result = $stmt->fetchAll();
        $this->assertEquals( 'IBM', $result[0]['company'] );
        $this->assertEquals( 'Norway', $result[0]['section'] );
        $this->assertEquals( 'IBM', $result[1]['company'] );
        $this->assertEquals( 'Germany', $result[1]['section'] );
    }

    public static function suite()
    {
        return new PHPUnit_Framework_TestSuite( 'ezcQuerySubSelectTestImpl' );
    }
}
?>
