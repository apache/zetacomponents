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
 * Testing the SQL expression abstraction layer for INSERT queries.
 *
 * @package Database
 * @subpackage Tests
 */
class ezcQueryUpdateTest extends ezcTestCase
{
    private $q;

    public function setUp()
    {
        try {
            $db = ezcDbInstance::get();
        }
        catch ( Exception $e )
        {
            $this->markTestSkipped();
        }

        $this->assertNotNull( $db, 'Database instance is not initialized.' );

        $this->q = new ezcQueryUpdate( $db );
        try
        {
            $db->exec( 'DROP TABLE query_test' );
        }
        catch ( Exception $e ) {} // eat

        // insert some data
        $db->exec( 'CREATE TABLE query_test ( id int, company VARCHAR(255), section VARCHAR(255), employees int )' );

    }

    public function tearDown()
    {
        $db = ezcDbInstance::get();
        $db->exec( 'DROP TABLE query_test' );
    }

    public function testSingle()
    {
        $reference = "UPDATE legends SET Gretzky = 99";
        $this->q->update( 'legends' )
            ->set( 'Gretzky', '99' );
        $this->assertEquals( $reference, $this->q->getQuery() );
    }

    public function testMulti()
    {
        $reference = "UPDATE legends SET Gretzky = 99, Lindros = 88";
        $this->q->update( 'legends' )
            ->set( 'Gretzky', '99' )
            ->set( 'Lindros', '88' );
        $this->assertEquals( $reference, $this->q->getQuery() );
    }

    public function testWithWhere()
    {
        $reference = "UPDATE legends SET Gretzky = 99, Lindros = 88 WHERE Gretzky = Lindros";
        $this->q->update( 'legends' )
            ->set( 'Gretzky', '99' )
            ->set( 'Lindros', '88' )
            ->where( $this->q->expr->eq( 'Gretzky', 'Lindros' ) );
        $this->assertEquals( $reference, $this->q->getQuery() );
    }

    public function testWithSeveralWhere()
    {
        $reference = "UPDATE legends SET Gretzky = 99, Lindros = 88 WHERE Gretzky = Lindros AND 1 = 1";
        $this->q->update( 'legends' )
            ->set( 'Gretzky', '99' )
            ->set( 'Lindros', '88' )
            ->where( $this->q->expr->eq( 'Gretzky', 'Lindros' ) )
            ->where( $this->q->expr->eq( 1, 1 ) );
        $this->assertEquals( $reference, $this->q->getQuery() );
    }

    public function testInvalidWhereCall()
    {
        try
        {
            $this->q->update( 'legends' )
                ->set( 'Gretzky', '99' )
                ->set( 'Lindros', '88' )
                ->where();
        }
        catch ( ezcQueryException $e )
        {
            return;
        }
        $this->fail( "Got no exception when an exception was expected" );
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
        $this->fail( "Update query with no table did not fail!" );
    }

    public function testNoValues()
    {
        try
        {
            $this->q->update( 'MyTable' );
            $this->q->getQuery();
        }
        catch ( Exception $e )
        { 
            return;
        }
        $this->fail( "Update query with no values did not fail!" );
    }

    // test on a real database.
    public function testOnDatabaseWithoutWhere()
    {
        $q = new ezcQueryInsert( ezcDbInstance::get() );
        // insert some data we can update
        $q->insertInto( 'query_test' )
            ->set( 'id', 1 )
            ->set( 'company', $q->bindValue( 'eZ systems' ) )
            ->set( 'section', $q->bindValue( 'Norway' ) )
            ->set( 'employees', 20 );
        $stmt = $q->prepare();
        $stmt->execute();

        $this->q->update( 'query_test' )
            ->set( 'employees', 50 );
        $stmt = $this->q->prepare();
        $stmt->execute();

        // check that it was actually correctly updated
        $db = ezcDbInstance::get();
        $q = $db->createSelectQuery(); // get select query
        $q->select( '*' )->from( 'query_test' )
            ->where( $q->expr->eq( 'id', 1 ) );
        $stmt = $q->prepare();
        $stmt->execute();
        $result = $stmt->fetchAll();
        $this->assertEquals( 50, (int)$result[0][3] );
    }

    public function testOnDatabaseWithWhere()
    {
        $q = new ezcQueryInsert( ezcDbInstance::get() );
        $company = 'eZ systems';
        $section = 'Norway';
        // insert some data we can update
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

        $this->q->update( 'query_test' )
            ->set( 'employees', 50 )
            ->where( $this->q->expr->eq( 'id', 1 ) );
        $stmt = $this->q->prepare();
        $stmt->execute();

        // check that entry 1 was updated correctly
        // but not two
        $db = ezcDbInstance::get();
        $q = $db->createSelectQuery(); // get select query
        $q->select( '*' )->from( 'query_test' )->orderBy( 'company' );
        $stmt = $q->prepare();
        $stmt->execute();
        $result = $stmt->fetchAll();
        $this->assertEquals( 50, (int)$result[0][3] );
        $this->assertEquals( 70, (int)$result[1][3] );
    }

    public static function suite()
    {
        return new ezcTestSuite( 'ezcQueryUpdateTest' );
    }
}
?>
