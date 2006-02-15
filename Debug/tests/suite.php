<?php
require_once( "debug_test.php");
require_once( "debug_timer_test.php");
require_once( "writers/memory_writer_test.php");
require_once( "formatters/html_formatter_test.php");
    
class ezcDebugSuite extends ezcTestSuite
{
	public function __construct()
	{
		parent::__construct();
        $this->setName("Debug");
        
		$this->addTest( ezcDebugMemoryWriterTest::suite() );
		$this->addTest( ezcDebugTimerTest::suite() );
		$this->addTest( ezcDebugTest::suite() );
		$this->addTest( ezcDebugHtmlFormatterTest::suite() );
	}

    public static function suite()
    {
        return new ezcDebugSuite();
    }
}

?>
