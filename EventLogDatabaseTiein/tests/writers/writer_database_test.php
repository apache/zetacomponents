<?php
/**
 * @copyright Copyright (C) 2005-2010 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package EventLogDatabaseTieIn
 * @subpackage Tests
 */

/**
 * @package EventLogDatabaseTieIn
 * @subpackage Tests
 */
class ezcLogDatabaseWriterTest extends ezcTestCase
{
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

        $this->command = array();
        $schema = ezcDbSchema::createFromFile( 'xml', dirname( __FILE__ ) . '/testfiles/log_db_schema.xml' );
        foreach ( $schema->convertToDDL( $this->db ) as $statement )
        {
            $this->command[] = $statement;
        }

        try
        {
            $this->db->exec( $this->command[0] );
        }
        catch ( Exception $e )
        {
        }

        try
        {
            $this->db->exec( $this->command[1] );
        }
        catch ( Exception $e )
        {
        }
        $this->assertNotNull( $this->db, 'Database instance is not initialized.' );
        $this->writer = new ezcLogDatabaseWriter( $this->db, "log" );
    }

    protected function tearDown()
    {
        try
        {
            $this->db->exec( $this->command[0] );
        }
        catch ( Exception $e )
        {
        }
    }

    public function testWriteNotDefault()
    {
        $writer = new ezcLogDatabaseWriter( $this->db, "logtable" );
        $log = ezcLog::getInstance();
        $log->getMapper()->appendRule( new ezcLogFilterRule( new ezcLogFilter, $writer, true ) );
        try
        {
            $log->log( 'Adding category', ezcLog::INFO, array( 'source' => 'mail' ) );
            $this->fail( 'Expected exception was not thrown' );
        }
        catch ( ezcLogWriterException $e )
        {
            if ( $this->db instanceof ezcDbHandlerPgsql )
            {
                $this->assertEquals( "SQLSTATE[42P01]: Undefined table: 7 ERROR:  relation \"logtable\" does not exist", $e->getMessage() );
            }
            if ( $this->db instanceof ezcDbHandlerMysql )
            {
                $this->assertRegexp( "/SQLSTATE\[42S02\]: Base table or view not found: 1146 Table '(.*)' doesn't exist/", $e->getMessage() );
            }
            if ( $this->db instanceof ezcDbHandlerSqlite )
            {
                $this->assertEquals( "SQLSTATE[HY000]: General error: 1 no such table: logtable", $e->getMessage() );
            }
            if ( $this->db instanceof ezcDbHandlerOracle )
            {
                $this->markTestIncomplete();
            }
        }
    }

    public function testWriteDefaultEntries()
    {
        $this->writer->writeLogMessage("Hello world", ezcLog::WARNING, "MySource", "MyCategory");

        $q = $this->db->createSelectQuery();
        $q->select( '*' )->from( 'log' );
        $stmt = $this->db->query( $q->getQuery() );
        $a = $stmt->fetch();

        $this->assertEquals("Hello world", $a["message"], "Message doesn't match");
        $this->assertEquals("MySource", $a["source"], "Source doesn't match");
        $this->assertEquals("MyCategory", $a["category"], "Category doesn't match");
        $this->assertEquals("Warning", $a["severity"], "Severity doesn't match");
        $this->assertNotEquals("0000-00-00 00:00:00", $a["time"], "Time is not set correctly");
    }

    public function testWriteExtraEntries()
    {
        $this->writer->writeLogMessage("Hello world", ezcLog::WARNING, "MySource", "MyCategory", array("file" => "/usr/share/dott/", "line" => 123) );

        $q = $this->db->createSelectQuery();
        $q->select( '*' )->from( 'log' );
        $stmt = $this->db->query( $q->getQuery() );
        $a = $stmt->fetch();

        $this->assertEquals("Hello world", $a["message"], "Message doesn't match");
        $this->assertEquals("MySource", $a["source"], "Source doesn't match");
        $this->assertEquals("MyCategory", $a["category"], "Category doesn't match");
        $this->assertEquals("Warning", $a["severity"], "Severity doesn't match");
        $this->assertEquals("123", $a["line"], "Line doesn't match");
        $this->assertEquals("/usr/share/dott/", $a["file"], "File doesn't match");
    }

    public function testConvertExtraEntries()
    {
        try
        {
            $this->writer->writeLogMessage("Hello world", ezcLog::WARNING, "MySource", "MyCategory", array( "myFileName" => "/usr/share/dott/", "LineNumbers" => 123) );
        } 
        catch (Exception $e) 
        {
            // At the time of writing, a PDO exception is thrown.
            // Maybe this changes in the future. And for this test it's not the subject of testing.
        }

        $this->writer->myFileName = "file";
        $this->writer->LineNumbers = "line";
        $this->writer->writeLogMessage("Hello world", ezcLog::WARNING, "MySource", "MyCategory", array( "myFileName" => "/usr/share/dott/", "LineNumbers" => 123) );
        
        $q = $this->db->createSelectQuery();
        $q->select( '*' )->from( 'log' );
        $stmt = $this->db->query( $q->getQuery() );
        $a = $stmt->fetch();

        $this->assertEquals("Hello world", $a["message"], "Message doesn't match");
        $this->assertEquals("MySource", $a["source"], "Source doesn't match");
        $this->assertEquals("MyCategory", $a["category"], "Category doesn't match");
        $this->assertEquals("Warning", $a["severity"], "Severity doesn't match");
        $this->assertEquals("123", $a["line"], "Line doesn't match");
        $this->assertEquals("/usr/share/dott/", $a["file"], "File doesn't match");
    }

    public function testGetColumnTranslations()
    {
        $columns = array("message" => "message", "datetime" =>"time", "severity" => "severity", "source" => "source", "category" => "category");
        $this->assertEquals( $columns, $this->writer->getColumnTranslations() );

        $this->writer->datetime = "bla";
        $this->writer->hello = "world";
        
        $columns["datetime"] = "bla";
        $columns["hello"] = "world";

        $this->assertEquals( $columns, $this->writer->getColumnTranslations() );
    }

    public function testAdditionalTables()
    {
        $command = array();
        $schema = ezcDbSchema::createFromFile( 'xml', dirname( __FILE__ ) . '/testfiles/audits_db_schema.xml' );
        foreach ( $schema->convertToDDL( $this->db ) as $statement )
        {
            $command[] = $statement;
        }

        try
        {
            $this->db->exec( $command[0] );
        }
        catch ( Exception $e)
        {
        }
        $this->db->exec( $command[1] );
 
        // Only the FAILED and SUCCESS audits from every type.
        $filter = new ezcLogFilter();
        $filter->severity = ezcLog::FAILED_AUDIT | ezcLog::SUCCESS_AUDIT;

        $this->writer->setTable( $filter, "audits" );
        $this->writer->writeLogMessage("Hoagie logged in.", ezcLog::SUCCESS_AUDIT, "administration interface", "security", array("name" => "Hoagie"));

        $q = $this->db->createSelectQuery();
        $q->select( '*' )->from( 'audits' );
        $stmt = $this->db->query( $q->getQuery() );
        $a = $stmt->fetch();

        $this->assertEquals("Hoagie logged in.", $a["message"], "Message doesn't match");
        $this->assertEquals("administration interface", $a["source"], "Source doesn't match");
        $this->assertEquals("security", $a["category"], "Category doesn't match");
        $this->assertEquals("Success audit", $a["severity"], "Severity doesn't match");
        $this->assertEquals("Hoagie", $a["name"], "Extra info doesn't match");

        try
        {
            $this->db->exec( $command[0] );
        }
        catch ( Exception $e)
        {
        }
    }

    public function testProperties()
    {
        $this->writer->table = 'logger';
        $this->assertEquals( 'logger', $this->writer->table );

        $this->writer->myFileName = "file";
        $this->assertEquals( "file", $this->writer->myFileName );

        try
        {
            $val = $this->writer->no_such_property;
        }
        catch ( ezcBasePropertyNotFoundException $e )
        {
            $this->assertEquals( "No such property name 'no_such_property'.", $e->getMessage() );
        }
    }

    public function testIsSet()
    {
        // test isset table name
        $this->assertEquals( false, isset( $this->writer->table ) );
        $this->writer->table = 'logger';
        $this->assertEquals( true, isset( $this->writer->table ) );

        // test isset default column names
        $this->assertEquals( true, isset( $this->writer->message ) );
        $this->assertEquals( true, isset( $this->writer->severity ) );
        $this->assertEquals( true, isset( $this->writer->source ) );
        $this->assertEquals( true, isset( $this->writer->category ) );
        $this->assertEquals( true, isset( $this->writer->datetime ) );

        // test isset additional column names
        $this->assertEquals( false, isset( $this->writer->myFileName ) );
        $this->writer->myFileName = "file";
        $this->assertEquals( true, isset( $this->writer->myFileName ) );
    }

    public static function suite()
    {
        return new PHPUnit_Framework_TestSuite("ezcLogDatabaseWriterTest");
    }
}
?>
