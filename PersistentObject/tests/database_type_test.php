<?php
/**
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package PersistentObject
 * @subpackage Tests
 */

require_once dirname( __FILE__ ) . "/data/database_type_test_object.php";

/**
 * Tests for database type support.
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
        if ( $this->session->database->getName() === 'mysql' || $this->session->database->getName() === 'sqlite' )
        {
            $this->markTestSkipped( 'Will only be run with databases other than MySQL and SQLite.' );
        }
        $obj = $this->session->load( 'DatabaseTypeTestObject', 1 );

        $this->assertEquals(
            '1',
            $obj->id
        );
        $this->assertSame(
            23,
            $obj->int
        );
        $this->assertSame(
            'Non binary string',
            $obj->str
        );
        $this->assertTrue(
            is_resource( $obj->lob ),
            'Database did not return a resource for a BLOB field.'
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

    public function testLoadIncorrectNonMysqlSqlite()
    {
        if ( $this->session->database->getName() === 'mysql' || $this->session->database->getName() === 'sqlite' )
        {
            $this->markTestSkipped( 'Will only be run with databases other than MySQL and SQLite.' );
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
            -42,
            $obj->int
        );
        // String is cut after the null char
        $this->assertSame(
            "Binary ",
            $obj->str,
            'Binary string not cut at null-char in text field.'
        );
        $this->assertTrue(
            is_resource( $obj->lob ),
            'Database did not return a resource for a BLOB field.'
        );
        // Extract blob content
        for ( $blobContent = ""; !feof( $obj->lob ); $blobContent .= fgets( $obj->lob ) ) {}
        $this->assertEquals(
            "Binary \x00 string",
            $blobContent
        );
    }

    public function testSaveCorrectMysqlSqlite()
    {
        if ( $this->session->database->getName() !== 'mysql' && $this->session->database->getName() !== 'sqlite' )
        {
            $this->markTestSkipped( 'Will only be run with MySQL and SQLite.' );
        }
        $obj = new DatabaseTypeTestObject();
        $obj->bool = true;
        $obj->int  = 4223;
        $obj->str  = "I'm a very sad non-binary string.";
        $obj->lob  = "I'm a funny \0 binary \x00 string.";

        $this->session->save( $obj );

        $this->assertEquals(
            3,
            $obj->id
        );

        // Refresh object from database
        $this->session->refresh( $obj );
        
        $this->assertEquals(
            3,
            $obj->id
        );
        $this->assertEquals(
            4223,
            $obj->int
        );
        $this->assertEquals(
            "I'm a very sad non-binary string.",
            $obj->str
        );
        $this->assertEquals(
            "I'm a funny \0 binary \x00 string.",
            $obj->lob
        );
    }

    public function testSaveCorrectNonMysqlSqlite()
    {
        if ( $this->session->database->getName() === 'mysql' || $this->session->database->getName() === 'sqlite' )
        {
            $this->markTestSkipped( 'Will only be run with databases other than MySQL and SQLite.' );
        }
        $obj = new DatabaseTypeTestObject();
        $obj->bool = true;
        $obj->int  = 4223;
        $obj->str  = "I'm a very sad non-binary string.";
        $obj->lob  = "I'm a funny \0 binary \x00 string.";

        $this->session->save( $obj );

        $this->assertEquals(
            3,
            $obj->id
        );

        // Refresh object from database
        $this->session->refresh( $obj );
        
        $this->assertEquals(
            3,
            $obj->id
        );
        $this->assertEquals(
            4223,
            $obj->int
        );
        $this->assertEquals(
            "I'm a very sad non-binary string.",
            $obj->str
        );
        $this->assertTrue(
            is_resource( $obj->lob ),
            'Database did not return a resource for a BLOB field.'
        );
        // Extract blob content
        for ( $blobContent = ""; !feof( $obj->lob ); $blobContent .= fgets( $obj->lob ) ) {}
        $this->assertEquals(
            "I'm a funny \0 binary \x00 string.",
            $blobContent
        );
    }

    public function testSaveIncorrectMysqlSqlite()
    {
        if ( $this->session->database->getName() !== 'mysql' && $this->session->database->getName() !== 'sqlite' )
        {
            $this->markTestSkipped( 'Will only be run with MySQL and SQLite.' );
        }
        $obj = new DatabaseTypeTestObject();
        $obj->bool = true;
        $obj->int  = 4223;
        // Store binary string to string field
        $obj->str  = "I'm a funny \0 binary \x00 string.";
        $obj->lob  = "I'm a funny \0 binary \x00 string.";

        $this->session->save( $obj );

        $this->assertEquals(
            3,
            $obj->id
        );

        // Refresh object from database
        $this->session->refresh( $obj );
        
        $this->assertEquals(
            3,
            $obj->id
        );
        $this->assertEquals(
            4223,
            $obj->int
        );
        $this->assertEquals(
            "I'm a funny \0 binary \x00 string.",
            $obj->str
        );
        $this->assertEquals(
            "I'm a funny \0 binary \x00 string.",
            $obj->lob
        );
    }

    public function testSaveIncorrectNonMysqlSqlite()
    {
        if ( $this->session->database->getName() === 'mysql' || $this->session->database->getName() === 'sqlite' )
        {
            $this->markTestSkipped( 'Will only be run with databases other than MySQL and SQLite.' );
        }
        $obj = new DatabaseTypeTestObject();
        $obj->bool = true;
        $obj->int  = 4223;
        // Store binary string to string field
        $obj->str  = "I'm a funny \0 binary \x00 string.";
        $obj->lob  = "I'm a funny \0 binary \x00 string.";

        $this->session->save( $obj );

        $this->assertEquals(
            3,
            $obj->id
        );

        // Refresh object from database
        $this->session->refresh( $obj );
        
        $this->assertEquals(
            3,
            $obj->id
        );
        $this->assertEquals(
            4223,
            $obj->int
        );
        $this->assertEquals(
            "I'm a funny ",
            $obj->str
        );
        $this->assertTrue(
            is_resource( $obj->lob ),
            'Database did not return a resource for a BLOB field.'
        );
        // Extract blob content
        for ( $blobContent = ""; !feof( $obj->lob ); $blobContent .= fgets( $obj->lob ) ) {}
        $this->assertEquals(
            "I'm a funny \0 binary \x00 string.",
            $blobContent
        );
    }
    
    public function testFindCorrectMysqlSqlite()
    {
        if ( $this->session->database->getName() !== 'mysql' && $this->session->database->getName() !== 'sqlite' )
        {
            $this->markTestSkipped( 'Will only be run with MySQL and SQLite.' );
        }
        $q = $this->session->createFindQuery( 'DatabaseTypeTestObject' );
        $q->where(
            $q->expr->eq(
                'lob',
                $q->bindValue( "Binary \x00 string", null, PDO::PARAM_LOB )
            )
        );
        $objs = $this->session->find( $q, 'DatabaseTypeTestObject' );
        $obj  = $objs[0];

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
        $this->assertEquals(
            "Binary \x00 string",
            $obj->lob,
            'Binary string not returned completly from BLOB field.'
        );
    }
    
    public function testFindCorrectNonMysqlSqlite()
    {
        if ( $this->session->database->getName() === 'mysql' || $this->session->database->getName() === 'sqlite' )
        {
            $this->markTestSkipped( 'Will only be run with databases other than MySQL and SQLite.' );
        }
        $q = $this->session->createFindQuery( 'DatabaseTypeTestObject' );
        $q->where(
            $q->expr->eq(
                'lob',
                $q->bindValue( "Binary \x00 string", null, PDO::PARAM_LOB )
            )
        );
        $objs = $this->session->find( $q, 'DatabaseTypeTestObject' );
        $obj  = $objs[0];

        $this->assertEquals(
            '1',
            $obj->id
        );
        $this->assertSame(
            23,
            $obj->int
        );
        $this->assertSame(
            'Non binary string',
            $obj->str
        );
        $this->assertTrue(
            is_resource( $obj->lob ),
            'Database did not return a resource for a BLOB field.'
        );
        // Extract blob content
        for ( $blobContent = ""; !feof( $obj->lob ); $blobContent .= fgets( $obj->lob ) ) {}
        $this->assertEquals(
            "Binary \x00 string",
            $blobContent
        );
    }
}

?>
