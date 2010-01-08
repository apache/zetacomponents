<?php
/**
 * @copyright Copyright (C) 2005-2010 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package EventLog
 * @subpackage Tests
 */

require_once 'temp_implementation.php';
require_once 'temp_implementation2.php';

/**
 * @package EventLog
 * @subpackage Tests
 */
class ezcLogFileWriterTest extends ezcTestCase
{
    protected $logFile;
    protected $writer;
    protected $tempDir;

    protected function setUp()
    {
        $this->tempDir = $this->createTempDir( "ezcLogTest_" );
        $this->logFile = "default.log";
        
        $this->writer = new TempImplementation($this->getTempDir(), $this->logFile);
    }

    protected function tearDown()
    {
        $this->removeTempDir();
    }
    
    // This test was used to check for bug #9603, and it is commented out because
    // the code throws warnings for fwrite() and fclose()
    public function testWriteNotDefault()
    {
        $log = ezcLog::getInstance();
        $writer = new TempImplementation2($this->getTempDir(), 'broken.log');
        try
        {
            $writer->writeLogMessage( 'xxx', 'c', 'd', '' );
            // $log->log( null, ezcLog::INFO, array() );
            $this->fail( 'Expected exception was not thrown' );
        }
        catch ( ezcLogWriterException $e )
        {
            self::assertSame( "An error occurred while writing to 'broken.log'.", $e->getMessage() );
        }
    }

    // Check if can be written to the temporary file.
    public function testSelf()
    {
        $this->assertTrue( file_exists( $this->getTempDir() ) ); 

        $file = $this->getTempDir() . "/" . $this->logFile;
        $fh = fopen ($file, "w+");
        $this->assertEquals( 11, fwrite( $fh, "Hello world" ) );
        fclose($fh);

        $fh = fopen ($file, "r");
        $this->assertEquals( "Hello world", fread( $fh, 1024 ) );
        fclose($fh);
    }

    public function testWriteSimpleLogMessage()
    {
        $m = array("message" => "Alien alert", "type" => "critical", "source" => "UFO report", "category" => "fake warning" );
        $this->writer->writeLogMessage( $m["message"], $m["type"], $m["source"], $m["category"]);
        $this->assertEquals(print_r( $m, true ), file_get_contents( $this->getTempDir() ."/".$this->logFile ) ); 
    }

    public function testWriterFiles()
    {
        // All messages with eventType 1 or 2, are written to unimportant.log.
        $filter = new ezcLogFilter();
        $filter->severity = 1 | 2;

        $this->writer->setFile ( $filter, "unimportant.log" );
        $filter->severity = 4;
        $this->writer->setFile ( $filter, "semi-important.log" );
        $filter->severity = 8 | 16;
        $this->writer->setFile ( $filter, "really-important.log" );

        $msg = array("message" => "Power will shut down in 5 minutes.",
                     "type" => 8,
                     "source" => "System",
                     "category" => "User mistake");


        $this->writer->writeLogMessage($msg["message"], $msg["type"], $msg["source"], $msg["category"]);

        $this->assertEquals(print_r( $msg, true ), file_get_contents( $this->getTempDir() . "/really-important.log") );
        $this->assertEquals("", file_get_contents( $this->getTempDir() . "/unimportant.log") );
        $this->assertEquals("", file_get_contents( $this->getTempDir() . "/semi-important.log") );
        $this->assertEquals("", file_get_contents( $this->getTempDir() ."/". $this->logFile) );

        $msg["type"] = 2;
        $this->writer->writeLogMessage($msg["message"], $msg["type"], $msg["source"], $msg["category"]);

        $this->assertEquals(print_r( $msg, true ), file_get_contents( $this->getTempDir() . "/unimportant.log") );
        $this->assertEquals("", file_get_contents( $this->getTempDir() . "/semi-important.log") );
        $this->assertEquals("", file_get_contents( $this->getTempDir() ."/". $this->logFile) );

        $msg["type"] = 32;
        $this->writer->writeLogMessage($msg["message"], $msg["type"], $msg["source"], $msg["category"]);
        $this->assertEquals(print_r( $msg, true ), file_get_contents( $this->getTempDir() . "/" . $this->logFile) );
    }

    public function testCantOpenFileForWriting()
    {
        try 
        {
            $filter = new ezcLogFilter();
            $filter->severity = 1;
            touch( $this->tempDir . "/read-only.log" );
            chmod( $this->tempDir . "/read-only.log", 0444 );
            $this->writer->setFile($filter, "read-only.log" );
            $this->fail("Should raise a ezcLogFileException"); 
        } 
        catch ( ezcBaseFilePermissionException $e ) 
        {
            self::assertEquals( "The file '{$this->tempDir}/read-only.log' can not be opened for writing.", $e->getMessage() );
        }
    }

    public function testCantCreateFile()
    {
        try 
        {
            $filter = new ezcLogFilter();
            $filter->severity = 1;
            chmod( $this->tempDir, 0555 );
            $this->writer->setFile($filter, "read-only.log" );
            chmod( $this->tempDir, 0777 );
            $this->fail("Should raise a ezcLogFileException"); 
        } 
        catch ( Exception $e ) 
        {
            chmod( $this->tempDir, 0777 );
            self::assertEquals( "The file '{$this->tempDir}' can not be opened for writing.", $e->getMessage() );
        }
    }
    
    public function testLogRotate()
    {
        $this->writer = new TempImplementation($this->getTempDir(), $this->logFile, 20);

        $msg = array("message" => "1234567890123456789012345",
                     "type" => 1,
                     "source" => "s",
                     "category" => "c");

        $this->writer->writeLogMessage( $msg["message"], $msg["type"], $msg["source"], $msg["category"]);

        unset($this->writer);
        $this->writer = new TempImplementation($this->getTempDir(), $this->logFile, 20);
        
        $msg2 = array("message" => "abcdefghijklmnopqrstuvwxyz",
                     "type" => 1,
                     "source" => "s",
                     "category" => "c");

        $this->writer->writeLogMessage( $msg2["message"], $msg2["type"], $msg2["source"], $msg2["category"]);

        $this->assertTrue(file_exists( $this->getTempDir() ."/default.log"), "Log rotation messes up the default log file." );
        $this->assertTrue(file_exists( $this->getTempDir() ."/default.log.1"), "Expected that the log files rotate." );

        $this->assertEquals(print_r($msg2, true), file_get_contents( $this->getTempDir() . "/default.log") );
        $this->assertEquals(print_r($msg, true), file_get_contents( $this->getTempDir() . "/default.log.1") );
    }

    public function testLogRotateDisabled()
    {
        $msg = array("message" => "1234567890123456789012345",
                     "type" => 1,
                     "source" => "s",
                     "category" => "c");

        for ( $i = 0; $i < 50000; $i++ )
        {
            $this->writer = new TempImplementation($this->getTempDir(), $this->logFile, false);

            $this->writer->writeLogMessage( $msg["message"], $msg["type"], $msg["source"], $msg["category"]);
            clearstatcache();
        }
        $this->assertTrue(file_exists( $this->getTempDir() ."/default.log"), "Log rotation messes up the default log file." );
        $this->assertFalse(file_exists( $this->getTempDir() ."/default.log.1"), "Expected that the log files don't rotate." );
    }

    public function testMaxLogFiles()
    {
        $msg = array("message" => "1234567890",
                     "type" => 1,
                     "source" => "s",
                     "category" => "c");

        // default.log 
        unset($this->writer);
        $this->writer = new TempImplementation($this->getTempDir(), $this->logFile, 10, 3);
        $this->writer->writeLogMessage( $msg["message"], $msg["type"], $msg["source"], $msg["category"]);

        // default.log and default.log.1
        unset($this->writer);
        $this->writer = new TempImplementation($this->getTempDir(), $this->logFile, 10, 3);
        $this->writer->writeLogMessage( $msg["message"], $msg["type"], $msg["source"], $msg["category"]);

        // default.log, default.log.1 and default.log.2
        unset($this->writer);
        $this->writer = new TempImplementation($this->getTempDir(), $this->logFile, 10, 3);
        $this->writer->writeLogMessage( $msg["message"], $msg["type"], $msg["source"], $msg["category"]);

        $this->assertTrue( file_exists( $this->getTempDir() . "/default.log") ); 
        $this->assertTrue( file_exists( $this->getTempDir() . "/default.log.1") ); 
        $this->assertTrue( file_exists( $this->getTempDir() . "/default.log.2") ); 
        $this->assertFalse( file_exists( $this->getTempDir() ."/default.log.3") ); 

        // default.log, default.log.1 and default.log.2
        unset($this->writer);
        $this->writer = new TempImplementation($this->getTempDir(), $this->logFile);
        $this->writer->writeLogMessage( $msg["message"], $msg["type"], $msg["source"], $msg["category"]);
        $this->assertTrue( file_exists( $this->getTempDir() ."/default.log") ); 
        $this->assertTrue( file_exists( $this->getTempDir() ."/default.log.1") ); 
        $this->assertTrue( file_exists( $this->getTempDir() ."/default.log.2") ); 
        $this->assertFalse( file_exists( $this->getTempDir() ."/default.log.3") ); 
    }

    public function testNoDefault()
    {
        // file_exists doesn't work when a file is created and thereafter removed.
        $this->assertEquals( "", file_get_contents($this->getTempDir() ."/default.log") ); 

        $msg[0] = "12345678901";

        $this->writer = new TempImplementation($this->getTempDir());
        $this->writer->writeLogMessage( $msg, "a", "b", "" );
        $this->assertEquals( "", file_get_contents($this->getTempDir() ."/default.log") ); 
    }

    public function testReopenWriter()
    {
        $this->createTempDir( "ezcLogTest_" );
        $this->logFile = "default.log";
        
        $this->writer = new TempImplementation($this->getTempDir(), $this->logFile);
        $this->writer->writeLogMessage("msg1", "a", "b", "" );

        // Reopen the writer. 
        $this->writer = new TempImplementation($this->getTempDir(), $this->logFile);
        $this->writer->writeLogMessage( "msg2", "c", "d", "");

        $m = print_r( array( "message" => "msg1", "type" => "a", "source" => "b", "category" => "" ), true );
        $m .= print_r( array( "message" => "msg2", "type" => "c", "source" => "d", "category" => "" ), true );
        $this->assertEquals( $m, file_get_contents( $this->getTempDir() ."/". $this->logFile ) );
    }


    public static function suite()
    {
        return new PHPUnit_Framework_TestSuite("ezcLogFileWriterTest");
    }
}
?>
