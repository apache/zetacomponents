<?php
require_once( "log_test.php");
require_once( "log_message_test.php");
require_once( "mapper/filterset_test.php");
require_once( "context_test.php");
require_once( "writers/writer_file_test.php");
require_once( "writers/writer_unix_file_test.php");
    
class ezcEventLogSuite extends PHPUnit_Framework_TestSuite
{
    public function __construct()
    {
        parent::__construct();
        $this->setName("EventLog");
        
        $this->addTest( ezcLogFilterSetTest::suite() );
        $this->addTest( ezcLogContextTest::suite() );
        $this->addTest( ezcLogFileWriterTest::suite() );
        $this->addTest( ezcLogUnixFileWriterTest::suite() );
        $this->addTest( ezcLogMessageTest::suite() );
        $this->addTest( ezcLogTest::suite() );

    }

    public static function suite()
    {
        return new ezcEventLogSuite();
    }
}


?>
