<?php
/**
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package Debug
 * @subpackage Tests
 */

require_once 'test_classes.php';

/**
 * @package Debug
 * @subpackage Tests
 */
class ezcDebugTimerTest extends ezcTestCase
{
    public static function suite( )
    {
        return new PHPUnit_Framework_TestSuite( __CLASS__ );
    }

    public function testStartStop( )
    {
        $timer = new ezcDebugTimer( );

        $point1 = microtime( true );
        $this->assertTrue(
            $timer->startTimer( "Ray", "host" )
        );

        $point2 = microtime( true );
        $this->assertTrue(
            $timer->stopTimer( "Ray" )
        );
        
        $point3 = microtime( true );
        
        $structure = $timer->getTimeData( );
        
        $this->assertEquals( 1, count( $structure ) );
        $this->assertEquals( "Ray", $structure[0]->name );
        $this->assertEquals( "host", $structure[0]->group );

        $this->assertTrue(
            $structure[0]->startTime >= $point1 && $structure[0]->startTime <= $point2
        );
        $this->assertTrue(
            $structure[0]->stopTime >= $point2 && $structure[0]->stopTime <= $point3
        );
        $this->assertTrue(
            $structure[0]->elapsedTime <= $point3 - $point1
        );
    }

    public function testStartStopNoName( )
    {
        $timer = new ezcDebugTimer( );

        $this->assertTrue(
            $timer->startTimer( "Ray", "Local", "host" )
        );
        $this->assertTrue(
            $timer->stopTimer()
        );

        $structure = $timer->getTimeData( );
        $this->assertEquals( 1, count( $structure ));
    }

    public function testSwitchTimer( )
    {
        $timer = new ezcDebugTimer( );

        $point1 = microtime( true );
        $this->assertTrue(
            $timer->startTimer( "Ray",  "host" )
        );
        
        $point2 = microtime( true );
        $this->assertTrue(
            $timer->switchTimer( "Blaap", "Ray" )
        );
        
        $point3 = microtime( true );
        $this->assertTrue(
            $timer->stopTimer( "Blaap" )
        );
        
        $point4 = microtime( true );
 
        $structure = $timer->getTimeData( );
        $this->assertEquals( 1, count( $structure ));
        $this->assertEquals( "Ray", $structure[0]->name );
        $this->assertEquals( "host", $structure[0]->group );

        $this->assertEquals( 1, count( $structure[0]->switchTime ));
        $this->assertEquals( "Blaap", $structure[0]->switchTime[0]->name );

        $this->assertTrue(
            $structure[0]->startTime >= $point1 && $structure[0]->startTime <= $point2
        );
        $this->assertTrue(
            $structure[0]->switchTime[0]->time >= $point2 && $structure[0]->switchTime[0]->time <= $point3
        );
        $this->assertTrue(
            $structure[0]->stopTime >= $point3 && $structure[0]->stopTime <= $point4
        );
    }

    public function testSwitchTwoTimer( )
    {
        $timer = new ezcDebugTimer( );
        $this->assertTrue(
            $timer->startTimer( "Ray", "Local", "host" )
        );
        $this->assertTrue(
            $timer->switchTimer( "Blaap", "Ray" )
        );
        $this->assertTrue(
            $timer->switchTimer( "hehe", "Blaap" )
        );
        $this->assertTrue(
            $timer->stopTimer( "hehe" )
        );

        $structure = $timer->getTimeData( );
        $this->assertEquals( 2, count( $structure[0]->switchTime ));
    }

    public function testSwitchTimerNoOld()
    {
        $timer = new ezcDebugTimer();

        $timer->startTimer( 'foo', 'foogroup' );

        $this->assertTrue(
            $timer->switchTimer( 'bar' )
        );
    }

    public function testMultipleRunningTimers( )
    {
        $timer = new ezcDebugTimer( );
        $timer->startTimer( "Ray", "Local", "host" );
        $timer->startTimer( "Ray2", "Local", "host" );
        $timer->startTimer( "Ray3", "Local", "bla" );

        $this->assertEquals( false, $timer->stopTimer( "hehe" ));

        $timer->stopTimer( "Ray2" );
        $timer->stopTimer( "Ray3" );
        $timer->stopTimer( "Ray" );

        $structure = $timer->getTimeData( );
        $this->assertEquals( 3, count( $structure ));

        // Expected order?
        $this->assertEquals( "Ray2", $structure[0]->name );
        $this->assertEquals( "Ray3", $structure[1]->name );
        $this->assertEquals( "Ray",  $structure[2]->name );
    }

    public function testComfortableStructure( )
    {
        $struct = $this->getTimeData( );
    }

    protected function getTimeData( )
    {
        $time = new ezcDebugTimer( );
        $time->startTimer( "Script", "html_reporter_test", "script" );


        if ( true != false ) $i_do_something = false;

        $time->startTimer( "Timing module", "content", "module" );

        if ( true != false ) $i_do_something = true;

        $this->mySQLFunction( $time );
        $this->mySQLFunction( $time );
        $this->mySQLFunction( $time );
        
        $time->stopTimer( "Timing module" );

        $time->stopTimer( "Script" );

        return $time->getTimeData( );
    }

    public function testGetAccessFailure()
    {
        $time = new ezcDebugTimer();
        try
        {
            echo $time->foo;
            $this->fail( 'ezcBasePropertyNotFoundException not thrown' );
        }
        catch ( ezcBasePropertyNotFoundException $e ) {}
    }

    public function testSetAccessFailure()
    {
        $time = new ezcDebugTimer();
        try
        {
            $time->foo = 23;
            $this->fail( 'ezcBasePropertyNotFoundException not thrown' );
        }
        catch ( ezcBasePropertyNotFoundException $e ) {}
    }

    public function testStartTimerTwiceFailure()
    {
        $time = new ezcDebugTimer();

        // Same group
        $this->assertTrue(
            $time->startTimer( 'foo', 'foogroup' )
        );
        $this->assertFalse(
            $time->startTimer( 'foo', 'foogroup' )
        );
        
        // Different group
        $this->assertTrue(
            $time->startTimer( 'bar', 'bargroup1' )
        );
        $this->assertFalse(
            $time->startTimer( 'bar', 'bargroup2' )
        );
    }

    public function testSwitchTimerNoneRunningFailure()
    {
        $time = new ezcDebugTimer();
        
        $this->assertFalse(
            $time->switchTimer( 'foo' )
        );
    }

    public function testSwitchTimerMultipleRunningNoOldNameFailure()
    {
        $time = new ezcDebugTimer();

        $time->startTimer( 'foo', 'foogroup' );
        $time->startTimer( 'bar', 'bargroup' );

        $this->assertFalse(
            $time->switchTimer( 'baz' )
        );
    }

    public function testSwitchTimerNochSuchOldTimerFailure()
    {
        $time = new ezcDebugTimer();

        $time->startTimer( 'foo', 'foogroup' );

        $this->assertFalse(
            $time->switchTimer( 'bar', 'baz' )
        );
    }

    protected function mySQLFunction( &$time )
    {
        $time->startTimer( "my query", "html_reporter_test" , "query" );

        // My query.. 

        $time->stopTimer( "my query" );
    }

  
}
?>
