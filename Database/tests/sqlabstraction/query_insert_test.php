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
 * Testing the SQL expression abstraction layer for INSERT queries.
 *
 * @package Database
 * @subpackage Tests
 */
class ezcQueryInsertTest extends ezcTestCase
{
    private $q;

    protected function setUp()
    {
        try
        {
            $db = ezcDbInstance::get();
        }
        catch ( Exception $e )
        {
            $this->markTestSkipped();
        }

        $this->q = new ezcQueryInsert( $db );
        try
        {
            $db->exec( 'DROP TABLE query_test' );
        }
        catch ( Exception $e ) {} // eat

        // insert some data
        $db->exec( 'CREATE TABLE query_test ( id int, company VARCHAR(255), section VARCHAR(255), employees int )' );

    }

    protected function tearDown()
    {
        $db = ezcDbInstance::get();
        $db->exec( 'DROP TABLE query_test' );
    }

    public function testSingle()
    {
        $reference = "INSERT INTO legends ( Gretzky ) VALUES ( 99 )";
        $this->q->insertInto( 'legends' )
            ->set( 'Gretzky', '99' );
        $this->assertEquals( $reference, $this->q->getQuery() );
    }

    public function testMulti()
    {
        $reference = "INSERT INTO legends ( Gretzky, Lindros ) VALUES ( 99, 88 )";
        $this->q->insertInto( 'legends' )
            ->set( 'Gretzky', '99' )
            ->set( 'Lindros', '88' );
        $this->assertEquals( $reference, $this->q->getQuery() );
    }

    public function testNoTable()
    {
        try
        {
            $this->q->set( 'Gretzky', '99' )->set( 'Lindros', '88' );
            $this->q->getQuery();
        }
        catch ( Exception $e )
        {
            return;
        }
        $this->fail( "Insert query with no table did not fail!" );
    }

    public function testNoValues()
    {
        try
        {
            $this->q->insertInto( 'MyTable' );
            $this->q->getQuery();
        }
        catch ( Exception $e )
        {
            return;
        }
        $this->fail( "Insert query with no values did not fail!" );
    }

    // test on a real database.
    public function testOnDatabase()
    {
        $q = $this->q;
        $q->insertInto( 'query_test' )
            ->set( 'id', 1 )
            ->set( 'company', $q->bindValue( 'eZ systems' ) )
            ->set( 'section', $q->bindValue( 'Norway' ) )
            ->set( 'employees', 20 );
        $stmt = $q->prepare();
        $stmt->execute();

        // check that it was actually correctly set
        $db = ezcDbInstance::get();
        $q = $db->createSelectQuery(); // get select query
        $q->select( '*' )->from( 'query_test' )
            ->where( $q->expr->eq( 'id', 1 ) );
        $stmt = $q->prepare();
        $stmt->execute();
        $result = $stmt->fetchAll();
        $this->assertEquals( 1, (int)$result[0][0] );
        $this->assertEquals( 'eZ systems', $result[0][1] );
    }

    // test several inserts on a real database.
    public function testSeveralInsertsOnDatabase()
    {
        $q = $this->q;
        $company = 'eZ systems';
        $section = 'Norway';
        $q->insertInto( 'query_test' )
            ->set( 'id', 1 )
            ->set( 'company', $q->bindParam( $company ) )
            ->set( 'section', $q->bindParam( $section ) )
            ->set( 'employees', 20 );
        $stmt = $q->prepare();
        $stmt->execute();

        $q->insertInto( 'query_test' );
        $q->set( 'id', 2 );
        $q->set( 'employees', 70 );
        $company = 'trolltech';
        $section = 'Norway';
        $stmt = $q->prepare();
        $stmt->execute();

        // check that it was actually correctly set
        $db = ezcDbInstance::get();
        $q = $db->createSelectQuery(); // get select query
        $q->select( '*' )->from( 'query_test' )
            ->where( $q->expr->eq( 'id', 1 ) );
        $stmt = $q->prepare();
        $stmt->execute();
        $result = $stmt->fetchAll();
        $this->assertEquals( 1, (int)$result[0][0] );
        $this->assertEquals( 'eZ systems', $result[0][1] );

        // check that it was actually correctly set
        $db = ezcDbInstance::get();
        $q = $db->createSelectQuery(); // get select query
        $q->select( '*' )->from( 'query_test' )
            ->where( $q->expr->eq( 'id', 2 ) );
        $stmt = $q->prepare();
        $stmt->execute();
        $result = $stmt->fetchAll();
        $this->assertEquals( 2, (int)$result[0][0] );
        $this->assertEquals( 'trolltech', $result[0][1] );

    }

    public function testSeveralInsertsWithValueBind()
    {
        $q = $this->q;
        $company = 'eZ systems';
        $section = 'Norway';
        $q->insertInto( 'query_test' )
            ->set( 'id', 1 )
            ->set( 'company', $q->bindValue( $company ) )
            ->set( 'section', $q->bindValue( $section ) )
            ->set( 'employees', 20 );
        $stmt = $q->prepare();
        $stmt->execute();

        $q->insertInto( 'query_test' );
        $q->set( 'id', 2 );
        $q->set( 'employees', 70 );
        $company = 'trolltech'; // This should be ignored
        $section = 'Norway';
        $stmt = $q->prepare();
        $stmt->execute();

        // check that it was actually correctly set
        $db = ezcDbInstance::get();
        $q = $db->createSelectQuery(); // get select query
        $q->select( '*' )->from( 'query_test' )
            ->where( $q->expr->eq( 'id', 1 ) );
        $stmt = $q->prepare();
        $stmt->execute();
        $result = $stmt->fetchAll();
        $this->assertEquals( 1, (int)$result[0][0] );
        $this->assertEquals( 'eZ systems', $result[0][1] );

        // check that it was actually correctly set
        $db = ezcDbInstance::get();
        $q = $db->createSelectQuery(); // get select query
        $q->select( '*' )->from( 'query_test' )
            ->where( $q->expr->eq( 'id', 2 ) );
        $stmt = $q->prepare();
        $stmt->execute();
        $result = $stmt->fetchAll();
        $this->assertEquals( 2, (int)$result[0][0] );
        $this->assertEquals( 'eZ systems', $result[0][1] );
    }

    public function testInsertsWithSequence()
    {
        $q = $this->q;
        $db = ezcDbInstance::get();
        $company = "eZ systems";
        $section1 = "Norway";
        $section2 = "Ukraine";

        if ( $db->getName() == 'mysql' || $db->getName() == 'sqlite' || $db->getName() == 'mssql')
        {
            return;  // no need to test it in MySQL, SQLite and MSSQL as they have autoincrement
        }

        if ( $db->getName() == 'oracle' )
        {
            $db->exec( "CREATE SEQUENCE query_test_id_seq start with 1 increment by 1 nomaxvalue" );
        }
        else if ( $db->getName() == 'pgsql' ) 
        {
            $db->exec( "CREATE SEQUENCE query_test_id_seq START 1" );
        }

        // row 1
        $q->insertInto( 'query_test' )
            ->set( 'id', 'nextval(\'query_test_id_seq\')' )
            ->set( 'company', $q->bindParam( $company ) )
            ->set( 'section', $q->bindParam( $section1 ) )
            ->set( 'employees', 20 );

        $stmt = $q->prepare();
        $stmt->execute();

        // row 2
        $q->insertInto( 'query_test' )
            ->set( 'id', 'nextval(\'query_test_id_seq\')' )
            ->set( 'company',  $q->bindParam( $company ) )
            ->set( 'section',  $q->bindParam( $section2 ) )
            ->set( 'employees', 10 );
        $stmt = $q->prepare();
        $stmt->execute();
        
        // check that it was actually correctly set
        $q = $db->createSelectQuery(); // get select query
        $q->select( '*' )->from( 'query_test' )->where( $q->expr->eq( 'id', 2 ) );
        $stmt = $q->prepare();
        $stmt->execute();
        $result = $stmt->fetchAll();
        $this->assertEquals( 2, (int)$result[0][0] );
        $this->assertEquals( 'eZ systems', $result[0][1] );
        $this->assertEquals( 'Ukraine', $result[0][2] );
        $this->assertEquals( 10, $result[0][3] );

        if ( $db->getName() == 'oracle' || $db->getName() == 'pgsql' )
        {
            $db->exec( "DROP SEQUENCE query_test_id_seq" );
        }
    }

    public static function suite()
    {
        return new PHPUnit_Framework_TestSuite( 'ezcQueryInsertTest' );
    }
}
?>
