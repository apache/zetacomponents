<?php

class ezcDebugTest extends ezcTestCase
{
    private $dbg;
    public function setUp()
    {
        $this->dbg = ezcDebug::getInstance();
        $this->dbg->reset();
        $this->dbg->setOutputFormatter( new TestReporter() );

        set_error_handler(array( $this, "TestDebugHandler"));
    }

    // For trigger_error tests.
    public function TestDebugHandler($errno, $errstr, $errfile, $errline)
    {
        switch ($errno) 
        {
            case E_USER_ERROR:
            case E_USER_WARNING:
            case E_USER_NOTICE:    
                    ezcDebug::debugHandler($errno, $errstr, $errfile, $errline); break;

            default:               
                    print( "$errstr in $errfile on line $errline\n" ); break;
       }
    }



    // Messages are already tested in DebugMemoryWriterTest.
    // Quick test if the basics work.
    public function testSimpleMessage()
    {
        $dbg = $this->dbg;
        $dbg->log("Running testSimpleMessage", 0, array("source" => "src", "category" => "cat") );
        
        $struct = $dbg->generateOutput();
        $this->assertEquals(1, count( $struct[0] ) );
        $this->assertEquals("Running testSimpleMessage",  $struct[0][0]->message );
    }

    public function testMultipleMessages()
    {
        $dbg = $this->dbg;

        $dbg->log("msg1", 0, array("source" => "src", "category" => "cat") );
        $dbg->log("msg2", 0, array("source" => "src", "category" => "cat") );
        $dbg->log("msg3", 1, array("source" => "src", "category" => "cat") );

        $struct = $dbg->generateOutput();
        $this->assertEquals(3, count( $struct[0] ) );
        $this->assertEquals("msg1",  $struct[0][0]->message );
        $this->assertEquals("msg2",  $struct[0][1]->message );
        $this->assertEquals("msg3",  $struct[0][2]->message );
    }

    // Timer is already tested in DebugTimerTest.
    // Quick test if the basics work.
    public function testTimers()
    {
        $dbg = $this->dbg;
        $dbg->startTimer("a", "c");
        $dbg->stopTimer("a");

        $struct = $dbg->generateOutput();
        $this->assertEquals(1, count( $struct[1] ) );
        $this->assertEquals("a",  $struct[1][0]->name );
        $this->assertEquals("c",  $struct[1][0]->group );
    }

    public function testDefaultTimers()
    {
        $dbg = $this->dbg;
        $dbg->startTimer("a");
        $dbg->stopTimer("a");

        $struct = $dbg->generateOutput();

/*
        $this->assertEquals(1, count( $struct[1] ) );
        $this->assertEquals("a",  $struct[1][0]->name );
        $this->assertEquals("c",  $struct[1][0]->group );
        */
    }



    public function testDefaultSourceAndCategory()
    {
        $dbg = $this->dbg;
        $dbg->log("bla", 1);

        $struct = $dbg->generateOutput();
        $this->assertEquals(1, count( $struct[0] ) );
        $this->assertEquals("default",  $struct[0][0]->category );

        // Changing the default source from the log.
        $dbg->getEventLog()->source = "bla"; 
        //ezcLog::getInstance()->source ="bla";

        $dbg->log("bla", 1);
        $struct = $dbg->generateOutput();
        $this->assertEquals(2, count( $struct[0] ) );
        $this->assertEquals("bla",  $struct[0][1]->source );
    }
    

    public function testIndependentFromEventLog()
    {
        $dbg = $this->dbg;
        $dbg->log("bla", 1);
        
        ezcLog::getInstance()->setMapper( new MyFakeMapper() );

        $struct = $dbg->generateOutput();
        $this->assertEquals(1, count( $struct[0] ) );
        $this->assertEquals("default",  $struct[0][0]->category );

        $dbg->log("bla", 1);
        $struct = $dbg->generateOutput();
        $this->assertEquals(2, count( $struct[0] ) );
    }
 
  /*  
    public function testTriggerError()
    {
        $dbg = $this->dbg;
        trigger_error("[Aap, Noot] 2: Bernard, looking at all the quarters that fell out of the vending machine he broke with the crowbar.");

        $struct = $dbg->generateOutput();

        var_dump ($struct);
    }
    */
/*    
    public function testTriggerError()
    {
        $debug = ezcDebug::getInstance();
        $debug->setOutputFormatter( new ezcDebugHtmlFormatter() );
        $debug->log("The system is going to reboot NOW.", 3 );

        $out = $debug->generateOutput();
        echo ($out);
    }
    */
 

    public static function suite()
    {
        return new ezcTestSuite("ezcDebugTest");
    }
}


class TestReporter implements ezcDebugOutputFormatter
{
	public function generateOutput( array $timerData, array $writerData)
	{
        return array( $timerData, $writerData );
	}
}

class MyFakeMapper implements ezcLogMapper
{
    public function get( $sev, $src, $cat )
    {
        return null;
    }

}

?>
