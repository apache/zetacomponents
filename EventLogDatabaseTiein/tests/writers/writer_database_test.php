<?php

class ezcLogDatabaseWriterTest extends ezcTestCase
{
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

        $this->writer = new ezcLogDatabaseWriter( $db, "log");

        $this->assertNotNull( $db, 'Database instance is not initialized.' );

        try
        {
            $db->exec( "DROP TABLE `log`" );
        }
        catch ( Exception $e)
        {
        }

        $db->exec("CREATE TABLE `log` ( `id` INT NOT NULL AUTO_INCREMENT , `time` DATETIME NOT NULL ,".
                  "`message` VARCHAR( 255 ) NOT NULL , `severity` VARCHAR( 40 ) NOT NULL , `source` VARCHAR( 100 ) NOT NULL ,".
                  "`category` VARCHAR( 100 ) NOT NULL , `file` VARCHAR( 100 ) NOT NULL , `line` INT NOT NULL , PRIMARY KEY ( `id` ))");
    }

    protected function tearDown()
    {
        $db = ezcDbInstance::get();
        $db->exec("DROP TABLE `log`");
    }


    public function testWriteDefaultEntries()
    {
        $this->writer->writeLogMessage("Hello world", ezcLog::WARNING, "MySource", "MyCategory");

        $db = ezcDbInstance::get();
        $a = $db->query("SELECT * FROM `log`")->fetch();

        $this->assertEquals("Hello world", $a["message"], "Message doesn't match");
        $this->assertEquals("MySource", $a["source"], "Source doesn't match");
        $this->assertEquals("MyCategory", $a["category"], "Category doesn't match");
        $this->assertEquals("Warning", $a["severity"], "Severity doesn't match");
        $this->assertNotEquals("0000-00-00 00:00:00", $a["time"], "Time is not set correctly");
    }

    public function testWriteExtraEntries()
    {
        $this->writer->writeLogMessage("Hello world", ezcLog::WARNING, "MySource", "MyCategory", array("file" => "/usr/share/dott/", "line" => 123) );

        $db = ezcDbInstance::get();
        $a = $db->query("SELECT * FROM `log`")->fetch();

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
        
        $db = ezcDbInstance::get();
        $a = $db->query("SELECT * FROM `log`")->fetch();

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
        $db = ezcDbInstance::get();
      
        try
        {
            $db->exec("DROP TABLE `audits`");
        }
        catch ( Exception $e)
        {
        }
        $db->exec("CREATE TABLE `audits` ( `id` INT NOT NULL AUTO_INCREMENT , `time` DATETIME NOT NULL ,".
                  "`message` VARCHAR( 255 ) NOT NULL , `severity` VARCHAR( 40 ) NOT NULL , `source` VARCHAR( 100 ) NOT NULL ,".
                  "`category` VARCHAR( 100 ) NOT NULL , `name` VARCHAR( 100 ) NOT NULL, PRIMARY KEY ( `id` ))");
 
        // Only the FAILED and SUCCESS audits from every type.
        $filter = new ezcLogFilter();
        $filter->severity = ezcLog::FAILED_AUDIT | ezcLog::SUCCESS_AUDIT;

        $this->writer->setTable( $filter, "audits" );
        $this->writer->writeLogMessage("Hoagie logged in.", ezcLog::SUCCESS_AUDIT, "administration interface", "security", array("name" => "Hoagie"));

        $a = $db->query("SELECT * FROM `audits`")->fetch();

        $this->assertEquals("Hoagie logged in.", $a["message"], "Message doesn't match");
        $this->assertEquals("administration interface", $a["source"], "Source doesn't match");
        $this->assertEquals("security", $a["category"], "Category doesn't match");
        $this->assertEquals("Success audit", $a["severity"], "Severity doesn't match");
        $this->assertEquals("Hoagie", $a["name"], "Extra info doesn't match");

        $db->exec("DROP TABLE `audits`");
    }


    public static function suite()
    {
        return new PHPUnit_Framework_TestSuite("ezcLogDatabaseWriterTest");
    }
}



?>
