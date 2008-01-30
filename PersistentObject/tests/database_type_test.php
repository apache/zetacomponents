<?php
/**
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package PersistentObject
 * @subpackage Tests
 */

require_once dirname( __FILE__ ) . "/data/database_type_test_object.php";

/**
 * Tests ezcPersistentManyToManyRelation class.
 *
 * @package PersistentObject
 * @subpackage Tests
 */
class ezcPersistentDatabaseTypeTest extends ezcTestCase
{

    private $session;

    public static function suite()
    {
        return new PHPUnit_Framework_TestSuite( __CLASS__ );
    }

    public function setup()
    {
        try
        {
            $this->db = ezcDbInstance::get();
        }
        catch ( Exception $e )
        {
            $this->markTestSkipped( 'There was no database configured' );
        }
        DatabaseTypeTestObject::setupTables();
        DatabaseTypeTestObject::insertData();
        $this->session = new ezcPersistentSession(
            ezcDbInstance::get(),
            new ezcPersistentCodeManager( dirname( __FILE__ ) . "/data/" )
        );
    }

    public function teardown()
    {
        // DatabaseTypeTestObject::cleanup();
    }

    public function testLoadCorrectMysqlSqlite()
    {
        if ( $this->session->database->getName() !== 'mysql' && $this->session->database->getName() !== 'sqlite' )
        {
            $this->markTestSkipped( 'Will only be run with MySQL and SQLite.' );
        }
        $obj = $this->session->load( 'DatabaseTypeTestObject', 1 );

        $this->assertSame(
            '1',
            $obj->id
        );
        $this->assertSame(
            '23',
            $obj->int
        );
        $this->assertSame(
            'Non binary string',
            $obj->str
        );
        $this->assertSame(
            "Binary \x00 string",
            $obj->lob
        );
    }

    public function testLoadCorrectPostgres()
    {
        if ( $this->session->database->getName() !== 'pgsql' )
        {
            $this->markTestSkipped( 'Will only be run with PostgreSQL.' );
        }
        $obj = $this->session->load( 'DatabaseTypeTestObject', 1 );

        $this->assertSame(
            '1',
            $obj->id
        );
        $this->assertSame(
            '23',
            $obj->int
        );
        $this->assertSame(
            'Non binary string',
            $obj->str
        );
        $this->assertTrue(
            is_resource( $obj->lob ),
            'Postgre did not return a resource for a BLOB field.'
        );
    }

    public function testLoadIncorrectMysqlSqlite()
    {
        if ( $this->session->database->getName() !== 'mysql' && $this->session->database->getName() !== 'sqlite' )
        {
            $this->markTestSkipped( 'Will only be run with MySQL and SQLite.' );
        }
        $obj = $this->session->load( 'DatabaseTypeTestObject', 2 );

        $this->assertEquals(
            '2',
            $obj->id
        );
        $this->assertEquals(
            '0',
            $obj->bool
        );
        $this->assertEquals(
            '-42',
            $obj->int
        );
        // Works in MySQL and SQLite with non-blobs, too
        $this->assertEquals(
            "Binary \x00 string",
            $obj->str,
            'Binary string not returned completly from text field.'
        );
        $this->assertEquals(
            "Binary \x00 string",
            $obj->lob,
            'Binary string not returned completly from BLOB field.'
        );
    }

    public function testLoadIncorrectPostgres()
    {
        if ( $this->session->database->getName() !== 'pgsql' )
        {
            $this->markTestSkipped( 'Will only be run with PostgreSQL.' );
        }
        $obj = $this->session->load( 'DatabaseTypeTestObject', 2 );

        $this->assertSame(
            2,
            $obj->id
        );
        $this->assertSame(
            false,
            $obj->bool
        );
        $this->assertSame(
            '-42',
            $obj->int
        );
        // String is cut after the null char
        $this->assertSame(
            "Binary ",
            $obj->str,
            'Binary string not cut at null-char in Postgres text field.'
        );
        $this->assertTrue(
            is_resource( $obj->lob ),
            'Postgre did not return a resource for a BLOB field.'
        );
    }
}

?>
