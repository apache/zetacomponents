<?php
/**
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
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
class ezcLogSyslogWriterTest extends ezcTestCase
{
    protected $writer;
    protected $stderr;

    protected function setUp()
    {
        $this->writer = new ezcLogSyslogWriter( "ezctest", LOG_PID|LOG_ODELAY );
    }

    protected function tearDown()
    {
        closelog();
    }

    // External test. Runs through the tests below and returns the syslog output.
    public function testExternalTest()
    {
        $dataDir = dirname( __FILE__ ) . "/data";
        $phpPath = isset( $_SERVER["_"] ) ? $_SERVER["_"] : "/bin/env php";
        $scriptFile = "{$dataDir}/syslog_tests.php";
        $desc = array(
            0 => array( "pipe", "r" ),  // stdin
            1 => array( "pipe", "w" ),  // stdout
            2 => array( "pipe", "w" )   // stderr
        );
        $proc = proc_open("'{$phpPath}' '{$scriptFile}'", $desc, $pipes );

        fclose( $pipes[0] );
        fclose( $pipes[1] );

        $ret = '';

        while (!feof( $pipes[2] ) )
        {
            $ret .= fgets( $pipes[2] );
        }
        $strings = explode( "\n", $ret );
        // check each of the strings for correctness
        $regExp = "/ezctest\S*: \[Debug\] \[Donny\] \[quotes\] I was bowling. \(movie: The Big Lebowski\)/";
        $this->assertRegExp( $regExp, $strings[0] );

        $regExp = "/ezctest\S*: \[Debug\] \[Lebowski\] \[quotes\] The dude abides./";
        $this->assertRegExp( $regExp, $strings[1] );

        $regExp = "/ezctest\S*: \[Success audit\] \[Maude\] \[quotes\] Don't be fatuous, Jeffrey./";
        $this->assertRegExp( $regExp, $strings[2] );

        $regExp = "/ezctest\S*: \[Failed audit\] \[Lebowski\] \[quotes\] Also, my rug was stolen./";
        $this->assertRegExp( $regExp, $strings[3] );

        $regExp = "/ezctest\S*: \[Info\] \[Lebowski\] \[quotes\] Obviously you're not a golfer./";
        $this->assertRegExp( $regExp, $strings[4] );

        $regExp = "/ezctest\S*: \[Notice\] \[Walter\] \[quotes\] Forget it, Donny, you're out of your element!/";
        $this->assertRegExp( $regExp, $strings[5] );


        $regExp = "/ezctest\S*: \[Failed audit\] \[Walter\] \[quotes\] Donny you're out of your element! Dude, the Chinaman is not the issue here!/";
        $this->assertRegExp( $regExp, $strings[6] );

        $regExp = "/ezctest\S*: \[Fatal\] \[The stranger\] \[quotes\] Ok, Dude. Have it your way./";
        $this->assertRegExp( $regExp, $strings[7] );
    }


    /**
     * These tests are the same as the ones run in the testExternalTests()
     *
     * They are run to check for any errors, and for code coverage. If you add a new test
     * add it to syslog_tests.php as well. If you change any tests.. change it there as well.
     */
    public function testExtras()
    {
        $this->writer->writeLogMessage( "I was bowling.", ezcLog::DEBUG, "Donny", "quotes",
                                        array( "movie" => "The Big Lebowski" ) );
    }

    public function testDebug()
    {
        $this->writer->writeLogMessage( "The dude abides.", ezcLog::DEBUG, "Lebowski", "quotes" );
    }

    public function testSuccessAudit()
    {
        $this->writer->writeLogMessage( "Don't be fatuous, Jeffrey.", ezcLog::SUCCESS_AUDIT, "Maude", "quotes" );
    }

    public function testFailAudit()
    {
        $this->writer->writeLogMessage( "Also, my rug was stolen.", ezcLog::FAILED_AUDIT, "Lebowski", "quotes" );
    }

    public function testInfo()
    {
        $this->writer->writeLogMessage( "Obviously you're not a golfer.", ezcLog::INFO, "Lebowski", "quotes" );
    }

    public function testNotice()
    {
        $this->writer->writeLogMessage( "Forget it, Donny, you're out of your element!",
                                        ezcLog::NOTICE, "Walter", "quotes" );
    }

    public function testWarning()
    {
        $this->writer->writeLogMessage( "Donny you're out of your element! Dude, the Chinaman is not the issue here!",
                                        ezcLog::FAILED_AUDIT, "Walter", "quotes" );
    }

    public function testFatal()
    {
        $this->writer->writeLogMessage( "Ok, Dude. Have it your way.", ezcLog::FATAL, "The stranger", "quotes" );
    }

    public static function suite()
	{
		return new PHPUnit_Framework_TestSuite("ezcLogSyslogWriterTest");
	}
}

?>
