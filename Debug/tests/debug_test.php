<?php
/**
 * @copyright Copyright (C) 2005-2010 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package Debug
 * @subpackage Tests
 */

require_once 'test_classes.php';

function testErrorHandler( $errno, $errstr, $errfile, $errline )
{
    ezcDebug::debugHandler( $errno, $errstr, $errfile, $errline );
    return true;
}

/**
 * @package Debug
 * @subpackage Tests
 */
class ezcDebugTest extends ezcTestCase
{
    private $dbg;

    protected function setUp()
    {
        $this->dbg = ezcDebug::getInstance();
        $this->dbg->reset();
        $this->dbg->setOutputFormatter( new TestReporter() );
    }

    protected function tearDown()
    {
        restore_error_handler();
    }

    public function testGetAccessSuccess()
    {
        $this->assertEquals(
            new ezcDebugOptions(),
            $this->dbg->options,
            'Property $options does not have proper default value.'
        );
    }

    public function testGetAccessFailures()
    {
        try
        {
            echo $this->dbg->foobar;
            $this->fail( 'Exception not thrown on get access to unknown property $foobar.' );
        }
        catch ( ezcBasePropertyNotFoundException $e )
        {}
    }

    public function testSetAccessSuccess()
    {
        $this->assertSetProperty(
            $this->dbg,
            'options',
            array( new ezcDebugOptions(), )
        );
    }

    public function testSetAccessFailure()
    {
        $this->assertSetPropertyFails(
            $this->dbg,
            'options',
            array( null, true, 23, 23.42, 'foobar', array(), new stdClass )
        );

        try
        {
            $this->dbg->foo = 23;
            $this->fail( 'ezcBasePropertyNotFoundException not throwen on set access to non-existent property.' );
        }
        catch ( ezcBasePropertyNotFoundException $e ) {}
    }

    public function testIssetAccessSuccess()
    {
        $this->assertTrue(
            isset( $this->dbg->options ),
            'Property $options does not seem to be set.'
        );
    }

    public function testIssetAccessFailure()
    {
        $this->assertFalse(
            isset( $this->dbg->foobar ),
            'Property $foobar seems to be set.'
        );
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
    
    public function testTimersSwitch()
    {
        $dbg = $this->dbg;
        $dbg->startTimer("a", "c");
        $dbg->switchTimer( "b", "a" );
        $dbg->stopTimer("b");

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

        $this->assertEquals(1, count( $struct[1] ) );
        $this->assertEquals("a",  $struct[1][0]->name );
        $this->assertEquals("",  $struct[1][0]->group );
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

    public function testLogStackTrace()
    {
        $dbg = $this->dbg;
        $dbg->log( "bla", 1, array(), true );
        
        ezcLog::getInstance()->setMapper( new MyFakeMapper() );

        $struct = $dbg->generateOutput();

        $this->assertType(
            'ezcDebugStacktraceIterator',
            $struct[0][0]->stackTrace
        );
    }

    public function testDebugErrorHandler()
    {
        $beforeTime = time();

        set_error_handler( 'testErrorHandler' );
        trigger_error( '[Paynet, templates] Cannot load template', E_USER_WARNING );
        restore_error_handler();

        $afterTime = time();

        $struct = $this->dbg->generateOutput();
        
        // Local spefics
        $this->assertGreaterThanOrEqual(
            $beforeTime,
            $struct[0][0]->datetime
        );
        $this->assertLessThanOrEqual(
            $afterTime,
            $struct[0][0]->datetime
        );

        // Unify results
        $struct[0][0]->datetime = null;

        $fakeStruct = array( 
            array(
                new ezcDebugStructure(),
            ),
            array()
        );
        $fakeStruct[0][0]->message   = 'Cannot load template';
        $fakeStruct[0][0]->severity  = 1;
        $fakeStruct[0][0]->source    = 'Paynet';
        $fakeStruct[0][0]->category  = 'templates';
        $fakeStruct[0][0]->datetime  = null;
        $fakeStruct[0][0]->verbosity = false;
        $fakeStruct[0][0]->file      = __FILE__;
        $fakeStruct[0][0]->line      = 221;

        $this->assertEquals(
            $fakeStruct,
            $struct
        );
    }

    public function testDebugStructureToString()
    {
        $struct            = new ezcDebugStructure();
        $struct->message   = 'Cannot load template';
        $struct->severity  = 1;
        $struct->source    = 'Paynet';
        $struct->category  = 'templates';
        $struct->datetime  = time();
        $struct->verbosity = false;
        $struct->file      = __FILE__;
        $struct->line      = 232;

        $fakeRes = <<<EOT
message => {$struct->message}
severity => {$struct->severity}
source => {$struct->source}
category => {$struct->category}
datetime => {$struct->datetime}
verbosity => {$struct->verbosity}
file => {$struct->file}
line => {$struct->line}

EOT;

        $this->assertEquals(
            $fakeRes,
            $struct->toString()
        );
    }
 
    public static function suite()
    {
        return new PHPUnit_Framework_TestSuite("ezcDebugTest");
    }
}
?>
