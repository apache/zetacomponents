<?php
/**
 * @copyright Copyright (C) 2005-2010 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package EventLog
 * @subpackage Tests
 */

/**
 * @package EventLog
 * @subpackage Tests
 */
class ezcLogTest extends ezcTestCase
{
    protected $log;

    public function __construct($string = "")
    {
        parent::__construct($string);

        // These instances yield for all these tests.
        // $this->log = ezcLog::getInstance();

        date_default_timezone_set("UTC");
   }

    public function __destruct()
    {
        // $this->removeTempDir();
    }

    protected function setUp()
    {
        set_error_handler(array( $this, "TestErrorHandler"));
        $this->log = ezcLog::getInstance();
        $this->log->reset();
        $this->createTempDir( "ezcLogTest_" );
    }

    protected function tearDown()
    {
        // $this->cleanTempDir();
        $this->removeTempDir();
        restore_error_handler();
    }

    public function TestErrorHandler($errno, $errstr, $errfile, $errline)
    {
        switch ($errno) 
        {
            case E_USER_ERROR:
            case E_USER_WARNING:
            case E_USER_NOTICE:    
                    ezcLog::LogHandler($errno, $errstr, $errfile, $errline); break;

            default:               
                    print( "$errstr in $errfile on line $errline\n" ); break;
       }
    }


    public function testSimpleMessage()
    {
        $this->log->getMapper()->appendRule( new ezcLogFilterRule( new ezcLogFilter(), $a = new ezcLogUnixFileWriter( $this->getTempDir(), "default.log" ), true ) );

        $this->log->log("Writing a simple message.", ezcLog::DEBUG, array( "source" => "ezComponents Log", "category" => "Testing", "file" => "myFile", "line" => "myLine") );

        clearstatcache();
        $this->assertTrue( file_exists( $this->getTempDir()."/default.log"), "Expected the file: ".$this->getTempDir()."/default.log" );
        $this->assertTrue( filesize( $this->getTempDir() . "/default.log" )  > 0, "default.log is still empty." );

        $regExp = "/(Jan|Feb|Mar|Apr|May|Jun|Jul|Aug|Sep|Oct|Nov|Dec) \d+ \d+:\d+:\d+ \[Debug\] \[ezComponents Log\] \[Testing\] Writing a simple message. \(file: myFile, line: myLine\)/";

        $this->assertRegExp( $regExp, file_get_contents( $this->getTempDir() . "/default.log") );
    }

    public function testMultipleWriters()
    {
        $this->log->getMapper()->appendRule( new ezcLogFilterRule(new ezcLogFilter(), $a = new ezcLogUnixFileWriter( $this->getTempDir(), "default.log" ), true ) );

        $filter = new ezcLogFilter();
        $filter->severity = ezcLog::DEBUG | ezcLog::INFO | ezcLog::WARNING | ezcLog::ERROR | ezcLog::FATAL;
        $a->setFile( $filter, "logging.log" );

        $filter->severity = ezcLog::SUCCESS_AUDIT | ezcLog::FAILED_AUDIT;
        $a->setFile( $filter, "auditing.log" );

        $this->log->log("Bernard, float over here so I can punch you.", ezcLog::DEBUG, array( "source" => "ezComponents Log", "category" => "Testing", "file" => "myFile", "line" => "myLine") );

        $this->assertFalse( filesize( $this->getTempDir() . "/default.log" )  > 0, "default.log should be empty." );
        $this->assertFalse( filesize( $this->getTempDir() . "/auditing.log" )  > 0, "auditing.log should be empty." );

        $regExp = "/(Jan|Feb|Mar|Apr|May|Jun|Jul|Aug|Sep|Oct|Nov|Dec) \d+ \d+:\d+:\d+ \[Debug\] \[ezComponents Log\] \[Testing\] Bernard, float over here so I can punch you. \(file: myFile, line: myLine\)/";

        $this->assertRegExp($regExp, file_get_contents( $this->getTempDir() . "/logging.log") );

        $this->log->log("To save the world, you have to push a few old ladies down the stairs", ezcLog::SUCCESS_AUDIT, array( "source" => "ezComponents Log", "category" => "Testing", "file" => "myFile", "line" => "myLine") );

        $regExp2 = "/(Jan|Feb|Mar|Apr|May|Jun|Jul|Aug|Sep|Oct|Nov|Dec) \d+ \d+:\d+:\d+ \[Success audit\] \[ezComponents Log\] \[Testing\] To save the world, you have to push a few old ladies down the stairs \(file: myFile, line: myLine\)/";
        $this->assertNotRegExp($regExp2, file_get_contents( $this->getTempDir() . "/logging.log") ); // Not in this log.
        $this->assertRegExp($regExp2, file_get_contents( $this->getTempDir() . "/auditing.log") );   // But in this one.
    }

    public function testReAttach()
    {
        $this->log->getMapper()->appendRule( new ezcLogFilterRule( new ezcLogFilter(), $writer = new ezcLogUnixFileWriter( $this->getTempDir() ), true) );

        $filter = new ezcLogFilter();
        $filter->severity = ezcLog::WARNING | ezcLog::ERROR;
        $writer->setFile( $filter, "logging.log" );

        $this->log->log( "HI", ezcLog::ERROR, array( "source" => "content", "category" => "templates") );
        $this->log->log( "HI", ezcLog::ERROR, array( "source" => "content", "category" => "templates") );
        $this->assertEquals(2, sizeof(file($this->getTempDir() . "/logging.log"))); 

        $filter->severity = ezcLog::FATAL;
        $writer->setFile( $filter, "logging.log" );

        $this->log->log( "HI", ezcLog::ERROR, array( "source" => "content", "category" => "templates") );
        $this->assertEquals(3, sizeof(file($this->getTempDir() . "/logging.log"))); 

    }
/*
    public function testLargeApplicationLog()
    {
        $this->log->reset();

        // Don't write to a default.log file.
        $this->log->getMapper()->appendRule( new ezcLogFilterRule( new ezcLogFilter(), $writer = new ezcLogUnixFileWriter( $this->getTempDir() ), true ) );

        // General logging
        $filter = new ezcLogFilter();
        $filter->severity = ezcLog::WARNING | ezcLog::ERROR | ezcLog::FATAL;

        $writer->setFile( $filter, "logging.log" );

        $filter->severity = ezcLog::ERROR | ezcLog::FATAL;
        $writer->setFile( $filter, "critical.log" );
        // Debug and Info messages are not kept.


        // We really want to know everything about the payments.
        $filter = new ezcLogFilter();
        $filter->source = array("Paynet");
        $writer->map( $filter, "paynet.log" );

        // But we are not interested in the debug and template messages.
        $filter->severity = ezcLog::DEBUG;
        $writer->unmap( $filter,  "paynet.log" );

        $filter->severity = 0;
        $filter->category = array("templates");
        $writer->unmap( $filter, "paynet.log" );

        
        // Keep a security log.
        $filter = new ezcLogFilter();
        $filter->severity = ezcLog::SUCCESS_AUDIT | ezcLog::FAILED_AUDIT;
        $filter->category = array("Login/Logoff");
        $writer->map( $filter, "security.log" );

        // Store everything except the Login/Logoff
        $filter = new ezcLogFilter();
        $filter->severity = ezcLog::SUCCESS_AUDIT | ezcLog::FAILED_AUDIT;

        $writer->map( $filter, "content_modifications.log" );
        $filter->category = array( "Login/Logoff");
        $writer->unmap( $filter, "content_modifications.log" ); 


        // The templates from the content module seems to have a problem, extra logging required:
        $filter = new ezcLogFilter();
        $filter->source = array("content");
        $filter->category = array("templates");
        $writer->map( $filter, "content_templates.log");


        $this->log->log( "Cannot read template: list_content.tpl", ezcLog::ERROR, array("source" => "content", "category" => "templates", "file" => __FILE__, "line" => __LINE__));

        $this->assertTrue(file_exists( $this->getTempDir() . "/logging.log"));
        $this->assertTrue(file_exists( $this->getTempDir() . "/critical.log"));
        $this->assertTrue(file_exists( $this->getTempDir() . "/content_templates.log"));

        $this->assertEquals(1, sizeof( file($this->getTempDir() . "/logging.log")) );
        $this->assertEquals(1, sizeof( file($this->getTempDir() . "/critical.log")) );
        $this->assertEquals(1, sizeof( file($this->getTempDir() . "/content_templates.log")) ); 

        $this->assertEquals(0, filesize($this->getTempDir() . "/paynet.log")); // No message should be written to this log.


        $this->log->log( "User signed in to the system", ezcLog::SUCCESS_AUDIT, array( "source" => "Authentication", "category" => "Login/Logoff") );

        $this->assertEquals(1, sizeof(file($this->getTempDir() . "/logging.log")));
        $this->assertEquals(1, sizeof(file($this->getTempDir() . "/critical.log")));
        $this->assertEquals(0, filesize($this->getTempDir() . "/paynet.log")); // No message should be written to this log.
        $this->assertEquals(1, sizeof(file($this->getTempDir() . "/content_templates.log"))); 
        $this->assertEquals(1, sizeof(file($this->getTempDir() . "/security.log"))); 
        $this->assertFalse( file_exists($this->getTempDir() . "/content_modifictions.log") ); 


        $this->log->log( "Using 42 Kilobytes of memory", ezcLog::INFO, array( "source" => "Paynet", "category" => "Security") );
        $this->assertEquals(1, sizeof(file($this->getTempDir() . "/paynet.log")));

        $this->log->log( "Using 42 Kilobytes of memory", ezcLog::INFO, array( "source" => "Paynet", "category" => "Security") );
        $this->assertEquals(2, sizeof(file($this->getTempDir() . "/paynet.log")));

        $this->log->log( "sysstat: 1 + 1 = 2", ezcLog::DEBUG,  array( "source" => "Paynet", "category" => "Security") );
        $this->assertEquals(2, sizeof(file($this->getTempDir() . "/paynet.log"))); // Nothing written.
    }
   */ 

//    public function testTriggerError()
//    {
//        $this->log->reset();
//        // $this->log->map(new ezcLogFilter(), $writer = new ezcLogUnixFileWriter( $this->getTempDir(), "default.log" ));
//        $this->log->getMapper()->appendRule( new ezcLogFilterRule(new ezcLogFilter(), $a = new ezcLogUnixFileWriter( $this->getTempDir(), "default.log" ), true ) );
//        trigger_error("Bernard, looking at all the quarters that fell out of the vending machine he broke with the crowbar.", E_USER_WARNING);
//
//        $regExp = "|\[Warning\] \[default\] \[default\] Bern.* \(file: .*/log_test.php, line: \d+\)|";
//        $this->assertRegExp($regExp, file_get_contents( $this->getTempDir() . "/default.log") );
//
//        ezcLog::getInstance()->source = "Hoagie";
//        ezcLog::getInstance()->category = "Male";
//        trigger_error("Bernard, looking at all the quarters that fell out of the vending machine he broke with the crowbar.", E_USER_WARNING);
//
//        $lines = file( $this->getTempDir() . "/default.log");
//
//        $this->assertNotRegExp($regExp, $lines[count($lines) - 1] );
//
//        $regExp = "|\[Warning\] \[Hoagie\] \[Male\] Bernard|"; 
//        $this->assertRegExp($regExp, $lines[count($lines) - 1] );
//    }

    /*

    public function testLogFilter()
    {
        $filter = new ezcLogFilter();
        $writer = new ezcLogUnixFileWriter( $this->getTempDir(), "default.log" );

        $this->log->map($filter, $writer);
    }

    public function testLogDatabase()
    {
        try
        {
            $db = ezcDbInstance::get();
        }
        catch ( Exception $e )
        {
            $this->markTestSkipped();
        }

        try
        {
            $db->exec("DROP TABLE `audits`");
        }
        catch (Exception $e)
        {
        }
        $db->exec("CREATE TABLE `audits` ( `id` INT NOT NULL AUTO_INCREMENT , `time` DATETIME NOT NULL ,".
                  "`message` VARCHAR( 255 ) NOT NULL , `severity` VARCHAR( 40 ) NOT NULL , `source` VARCHAR( 100 ) NOT NULL ,".
                  "`category` VARCHAR( 100 ) NOT NULL , `name` VARCHAR( 100 ) NOT NULL, PRIMARY KEY ( `id` ))");
 
        $filter = new ezcLogFilter();
        $filter->severity = ezcLog::SUCCESS_AUDIT | ezcLog::FAILED_AUDIT;

        $this->log->reset();
        // Setup the default database writer.
        $this->log->map($filter, $dbWriter = new ezcLogDatabaseWriter($db, "audits"));

        $this->log->log("Hoagie logged in.", ezcLog::SUCCESS_AUDIT, array( "source" => "administration interface", "category" => "security", "name" => "Hoagie") );

        $a = $db->query("SELECT * FROM `audits`")->fetch();

        $this->assertEquals("Hoagie logged in.", $a["message"], "Message doesn't match");
        $this->assertEquals("administration interface", $a["source"], "Source doesn't match");
        $this->assertEquals("security", $a["category"], "Category doesn't match");
        $this->assertEquals("Success audit", $a["severity"], "Severity doesn't match");
        $this->assertEquals("Hoagie", $a["name"], "Extra info doesn't match");

        $db->exec("DROP TABLE `audits`");
    }

    public function testLogDatabaseAndFile()
    {
        try
        {
            $db = ezcDbInstance::get();
        }
        catch ( Exception $e )
        {
            $this->markTestSkipped();
        }

        try
        {
            $db->exec("DROP TABLE `audits`");
        }
        catch ( Exception $e )
        {
        }
        $db->exec("CREATE TABLE `audits` ( `id` INT NOT NULL AUTO_INCREMENT , `time` DATETIME NOT NULL ,".
                  "`message` VARCHAR( 255 ) NOT NULL , `severity` VARCHAR( 40 ) NOT NULL , `source` VARCHAR( 100 ) NOT NULL ,".
                  "`category` VARCHAR( 100 ) NOT NULL , `name` VARCHAR( 100 ) NOT NULL, PRIMARY KEY ( `id` ))");
 
        $filter = new ezcLogFilter();
        $filter->severity = ezcLog::SUCCESS_AUDIT | ezcLog::FAILED_AUDIT;

        $this->log->reset();
        // Setup the default database writer.
        $this->log->map($filter, $dbWriter = new ezcLogDatabaseWriter($db, "audits"));
        $filter->severity = ezcLog::DEBUG | ezcLog::INFO | ezcLog::NOTICE | ezcLog::WARNING | ezcLog::ERROR | ezcLog::FATAL;

        $this->log->map($filter, $fileWriter = new ezcLogUnixFileWriter( $this->getTempDir(), "default.log" ) );

        $this->log->log("Hoagie logged in.", ezcLog::SUCCESS_AUDIT, array( "source" => "administration interface", "category" => "security", "name" => "Hoagie") );

        $a = $db->query("SELECT * FROM `audits`")->fetch();

        $this->assertEquals("Hoagie logged in.", $a["message"], "Message doesn't match");
        $this->assertEquals("administration interface", $a["source"], "Source doesn't match");
        $this->assertEquals("security", $a["category"], "Category doesn't match");
        $this->assertEquals("Success audit", $a["severity"], "Severity doesn't match");
        $this->assertEquals("Hoagie", $a["name"], "Extra info doesn't match");

        $this->log->log("Error", ezcLog::ERROR, array( "source" => "administration interface", "category" => "security", "line" => "100", "file" => "bla") );
        $lines = file( $this->getTempDir() . "/default.log");

        $this->assertRegExp("/Error/", $lines[0]);
        $this->assertRegExp("/administration interface/", $lines[0]);
        $this->assertRegExp("/security/", $lines[0]);
        $this->assertRegExp("/line/", $lines[0]);
        $this->assertRegExp("/100/", $lines[0]);
        $this->assertRegExp("/file/", $lines[0]);
        $this->assertRegExp("/bla/", $lines[0]);

        $db->exec("DROP TABLE `audits`");
    }
    */

    public function testException()
    {
        try
        {
            $db = ezcDbInstance::get();
        }
        catch ( Exception $e )
        {
            $this->markTestSkipped( 'There is no database configured.' );
        }

        $this->log->reset();
        $this->log->getMapper()->appendRule( new ezcLogFilterRule(  new ezcLogFilter, $writer = new ezcLogDatabaseWriter( $db,  "log" ), true ) );

        try
        {
            $this->log->log( "msg", ezcLog::WARNING, array( "source" => "src", "category" => "cat" ) );
        } 
        catch ( ezcLogWriterException $e )
        {
            return;
        }
        $this->fail("Expected an ezcLogWriterException.");
    }

    public function testDisableExceptions()
    {
        try
        {
            $db = ezcDbInstance::get();
        }
        catch ( Exception $e )
        {
            $this->markTestSkipped( 'There is no database configured.' );
        }

        $this->log->reset();
        $this->log->getMapper()->appendRule( new ezcLogFilterRule( new ezcLogFilter, $writer = new ezcLogDatabaseWriter( $db, "log" ), true ) );
        $this->log->throwWriterExceptions( false );

        try
        {
            $this->log->log( "msg", ezcLog::WARNING, array( "source" => "src", "category" => "cat" ) );
        } 
        catch ( ezcLogWriterException $e )
        {
            $this->fail( "Didn't expect an ezcLogWriterException." );
        }
        // re-enable writer exceptions
        $this->log->throwWriterExceptions( true );
    }

    /*
    public function testDetach()
    {
        try
        {
            $db = ezcDbInstance::get();
        }
        catch ( Exception $e )
        {
            $this->markTestSkipped();
        }

        try
        {
            $db->exec("DROP TABLE `audits`");
        }
        catch ( Exception $e )
        {
        }
        $db->exec("CREATE TABLE `audits` ( `id` INT NOT NULL AUTO_INCREMENT , `time` DATETIME NOT NULL ,".
                  "`message` VARCHAR( 255 ) NOT NULL , `severity` VARCHAR( 40 ) NOT NULL , `source` VARCHAR( 100 ) NOT NULL ,".
                  "`category` VARCHAR( 100 ) NOT NULL , `name` VARCHAR( 100 ) NOT NULL, PRIMARY KEY ( `id` ))");
 
        $filter = new ezcLogFilter();
        $filter->severity = ezcLog::SUCCESS_AUDIT | ezcLog::FAILED_AUDIT;

        $this->log->reset();
        // Setup the default database writer.

        // HERE is the test:
        $this->log->map($filter, $dbWriter = new ezcLogDatabaseWriter( $db, "audits"));
        $this->log->map(new ezcLogFilter, $fileWriter = new ezcLogUnixFileWriter( $this->getTempDir(), "default.log" ) );
        $this->log->unmap($filter, $fileWriter);
        // //////////

        $this->log->log("Hoagie logged in.", ezcLog::SUCCESS_AUDIT, array( "source" => "administration interface",  "category" => "security", "name" => "Hoagie"));

        $a = $db->query("SELECT * FROM `audits`")->fetch();

        $this->assertEquals("Hoagie logged in.", $a["message"], "Message doesn't match");
        $this->assertEquals("administration interface", $a["source"], "Source doesn't match");
        $this->assertEquals("security", $a["category"], "Category doesn't match");
        $this->assertEquals("Success audit", $a["severity"], "Severity doesn't match");
        $this->assertEquals("Hoagie", $a["name"], "Extra info doesn't match");

        $this->log->log("Error", ezcLog::ERROR, array( "source" => "administration interface", "category" => "security", "line" => "100", "file" => "bla" ));
        $lines = file( $this->getTempDir() . "/default.log");

        $this->assertRegExp("/Error/", $lines[0]);
        $this->assertRegExp("/administration interface/", $lines[0]);
        $this->assertRegExp("/security/", $lines[0]);
        $this->assertRegExp("/line/", $lines[0]);
        $this->assertRegExp("/100/", $lines[0]);
        $this->assertRegExp("/file/", $lines[0]);
        $this->assertRegExp("/bla/", $lines[0]);

        $db->exec("DROP TABLE `audits`");
    }

    */

    public function testDefaultProperties()
    {
        // Setting up the log.
        $this->log->source = "MySource";
        $this->log->category = "MyCategory";

        $dir = $this->getTempDir();
        $file = "default.log";
        $this->log->getMapper()->appendRule( new ezcLogFilterRule(  new ezcLogFilter, $writer = new ezcLogUnixFileWriter( $dir, $file ), true ) );

        $this->log->log("Error", ezcLog::ERROR );

        $str = file_get_contents( "$dir/$file" );

        // We should have a file with the categories: MySource and MyDirectory.
        $this->assertTrue( strstr( $str,  "MySource" ) !== false );
        $this->assertTrue( strstr( $str,  "MyCategory" ) !== false );
    }
    
    public function testAutoAttributes()
    {
        $dir = $this->getTempDir();
        $file = "default.log";

        $log = ezcLog::getInstance();
        $writer = new ezcLogUnixFileWriter( "$dir", "$file" );
        $log->getmapper()->appendRule( new ezcLogFilterRule( new ezcLogFilter, $writer, true ) );

        $username = "John Doe";
        $service = "Paynet Terminal";

        // Add automatically the username to the log message, when the log message is either a SUCCESS_AUDIT or a FAILED_AUDIT.
        $log->setSeverityAttributes( ezcLog::SUCCESS_AUDIT | ezcLog::FAILED_AUDIT, array( "username" => $username ) );

        // Same can be done with the source of the log message.
        $log->setSourceAttributes( array( "Payment" ), array( "service" => $service ) );

        // Writing some log messages.
        $log->log( "Authentication failed", ezcLog::FAILED_AUDIT, array( "source" => "security", "category" => "login/logoff" ) );

        $log->source = "Payment"; 
        $log->log( "Connecting with the server.", ezcLog::DEBUG, array( "category" => "external connections" ) );

        $log->log( "Payed with creditcard.", ezcLog::SUCCESS_AUDIT, array( "category" => "shop" ) );

        $lines = file( "$dir/$file" );

        $this->assertRegExp("/username: John Doe/", $lines[0]);

        $this->assertRegExp("/service: Paynet Terminal/", $lines[1]);

        $this->assertRegExp("/username: John Doe/", $lines[2]);
        $this->assertRegExp("/service: Paynet Terminal/", $lines[2]);
    }

    public function testOtherSeverities()
    {
        $dir = $this->getTempDir();
        $file = "default.log";

        $log = ezcLog::getInstance();
        $writer = new ezcLogUnixFileWriter( "$dir", "$file" );
        $log->getMapper()->appendRule( new ezcLogFilterRule( new ezcLogFilter, $writer, true ) );

        $username = "John Doe";
        $service = "Paynet Terminal";
        // Add automatically the username to the log message, when the log message is FATAL.
        $log->setSeverityAttributes( ezcLog::FATAL, array( "username" => $username ) );
        $log->log( "Hackers have breached the security!", ezcLog::FATAL, array( "source" => "security", "category" => "login" ) );
        $log->log( "Something unknown happened...", false, array( "source" => "security", "category" => "login" ) );

        $lines = file( "$dir/$file" );
        $this->assertRegExp("/username: John Doe/", $lines[0]);
    }

    public function testProperties()
    {
        $log = ezcLog::getInstance();
        $log->source = "Payment";
        $log->category = "Corporate";
        $this->assertEquals( "Payment", $log->source );
        $this->assertEquals( "Corporate", $log->category );
        try
        {
            $val = $log->no_such_property;
            $this->fail( "Expected exception was not thrown" );
        }
        catch ( ezcBasePropertyNotFoundException $e )
        {
            $this->assertEquals( "No such property name 'no_such_property'.", $e->getMessage() );
        }
        try
        {
            $log->no_such_property = "xxx";;
            $this->fail( "Expected exception was not thrown" );
        }
        catch ( ezcBasePropertyNotFoundException $e )
        {
            $this->assertEquals( "No such property name 'no_such_property'.", $e->getMessage() );
        }
    }

    public function testIsSet()
    {
        $log = ezcLog::getInstance();
        $this->assertEquals( true, isset( $log->source ) );
        $this->assertEquals( true, isset( $log->category ) );
        $this->assertEquals( false, isset( $log->no_such_property ) );
    }

    public static function suite()
    {
         return new PHPUnit_Framework_TestSuite("ezcLogTest");
    }
}
?>
