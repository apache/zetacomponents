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
class ezcLogMessageTest extends ezcTestCase
{
    protected $tm;
    
    public static function suite()
    {
        return new PHPUnit_Framework_TestSuite("ezcLogMessageTest");
    }

    protected function setUp()
    {
        $this->tm = new TestMessages();
    }

    public function testObjectMother()
    {
        $this->assertEquals( "[Laverne, Female] This is all your fault Bernard.", $this->tm->getMessage(0, true, true) );
        $this->assertEquals( "[Female] This is all your fault Bernard.", $this->tm->getMessage(0, false, true) );
        $this->assertEquals( "[Laverne] This is all your fault Bernard.", $this->tm->getMessage(0, true, false) );
        $this->assertEquals( "This is all your fault Bernard.", $this->tm->getMessage(0, false, false) );
    }
    

    public function testMessageOnly()
    {
        $msg = new ezcLogMessage($this->tm->getMessage(0, false, false), E_USER_WARNING, false, false );

        $this->assertEquals( "This is all your fault Bernard.", $msg->message );
        $this->assertFalse( $msg->category, "Category should be false" );
        $this->assertFalse( $msg->source, "Source should be false" );
    }

    public function testCategory()
    {
        $msg = new ezcLogMessage($this->tm->getMessage(0, false, true), E_USER_WARNING, false, false );

        $this->assertEquals( "This is all your fault Bernard.", $msg->message );
        $this->assertEquals( "Female", $msg->category );
        $this->assertFalse( $msg->source, "Source should be false" );
    }

    public function testSourceAndCategory()
    {
        $msg = new ezcLogMessage($this->tm->getMessage(0, true, true), E_USER_WARNING, false, false );

        $this->assertEquals( "This is all your fault Bernard.", $msg->message );
        $this->assertEquals( "Laverne", $msg->source );
        $this->assertEquals( "Female", $msg->category );
    }

    public function testManyMessages()
    {
        $msg = new ezcLogMessage($this->tm->getMessage(1, true, true), E_USER_WARNING, false, false );

        $this->assertEquals( "Behold, children! The Chron-O-John!", $msg->message );
        $this->assertEquals( "Dr. Fred", $msg->source );
        $this->assertEquals( "Male", $msg->category );

        $msg = new ezcLogMessage($this->tm->getMessage(2, false, true), E_USER_WARNING, false, false );
        $this->assertEquals( "Doc, can't you just send Bernard?", $msg->message );
        $this->assertFalse( $msg->source, "No source expected" );
        $this->assertEquals( "Male", $msg->category );
    }

    public function testSeverities()
    {
        $msg = new ezcLogMessage($this->tm->getMessage(1, true, true), E_USER_WARNING, false, false );
        $this->assertEquals( ezcLog::WARNING, $msg->severity );

        $msg = new ezcLogMessage($this->tm->getMessage(1, true, true), E_USER_ERROR, false, false );
        $this->assertEquals( ezcLog::ERROR, $msg->severity );

        $msg = new ezcLogMessage($this->tm->getMessage(1, true, true), E_USER_NOTICE, false, false );
        $this->assertEquals( ezcLog::NOTICE, $msg->severity );
    }

    public function testProperties()
    {
        $msg = new ezcLogMessage( $this->tm->getMessage( 1, true, true ), E_USER_WARNING, false, false );
        try
        {
            $val = $msg->no_such_property;
            $this->fail( "Expected exception was not thrown" );
        }
        catch ( ezcBasePropertyNotFoundException $e )
        {
            $this->assertEquals( "No such property name 'no_such_property'.", $e->getMessage() );
        }
        try
        {
            $msg->no_such_property = "xxx";
            $this->fail( "Expected exception was not thrown" );
        }
        catch ( ezcBasePropertyNotFoundException $e )
        {
            $this->assertEquals( "No such property name 'no_such_property'.", $e->getMessage() );
        }
        $msg = new ezcLogMessage( $this->tm->getMessage( 1, true, true ), false, false, false );
        $this->assertEquals( false, $msg->severity );
    }

    public function testIsSet()
    {
        $msg = new ezcLogMessage( $this->tm->getMessage( 1, true, true ), E_USER_WARNING, false, false );
        $this->assertEquals( true, isset( $msg->message ) );
        $this->assertEquals( true, isset( $msg->source ) );
        $this->assertEquals( true, isset( $msg->category ) );
        $this->assertEquals( true, isset( $msg->severity ) );
        $this->assertEquals( false, isset( $msg->no_such_property ) );
    }

    // See issue #12907
    public function testSeverityEncapsulation()
    {
        $msg = new ezcLogMessage( '[my source, my category, debug ] James broke another component!', E_USER_NOTICE, false, false );
        $this->assertEquals( 'my source', $msg->source, 'Source should match the passed value' );
        $this->assertEquals( 'my category', $msg->category, 'Category should match the passed value' );
        $this->assertEquals( 'James broke another component!', $msg->message, 'Message should match the passed value' );
        $this->assertEquals( ezcLog::DEBUG, $msg->severity );
    }

    // See issue #12907
    public function testWrongSeverityEncapsulation()
    {
        try
        {
            $msg = new ezcLogMessage( '[my source, my category, unknown ] James broke another component!', E_USER_NOTICE, false, false );
            self::fail( "Expected exception not thrown." );
        }
        catch ( ezcLogWrongSeverityException $e )
        {
            self::assertEquals( "There is no severity named 'unknown'.", $e->getMessage() );
        }
    }

    public function testParseWithSpaces()
    {
        $msg = new ezcLogMessage( '[ my source, my category, debug ] James broke another component!', E_USER_NOTICE, false, false );
        $this->assertEquals( 'my source', $msg->source, 'Source should match the passed value' );

        $msg = new ezcLogMessage( '[ my source, my category, debug] James broke another component!', E_USER_NOTICE, false, false );
        $this->assertEquals( ezcLog::DEBUG, $msg->severity );
    }
}

class TestMessages
{
    /**
     * This method makes it easy to change the messages in the future. (Instead of changing every test.) 
     */
    public function getMessage($number = 0, $source = false, $category = false)
    {
        $msg = "";

        if ($source || $category)
        {
            $msg .= "[";

            if ( $source )               $msg .= $this->getSource($number);
            if ( $source && $category )  $msg .= ", ";
            if ( $category )             $msg .= $this->getCategory($number);

            $msg .= "] ";
        }
        
        switch ($number)
        {
            case 0: $msg .= "This is all your fault Bernard."; break;
            case 1: $msg .= "Behold, children! The Chron-O-John!"; break;
            case 2: $msg .= "Doc, can't you just send Bernard?"; break;
            case 3: $msg .= "No, you must all go to increase the odds that one of you will make it there alive."; break;
            case 4: $msg .= "Has any people even been hurt in this thing?"; break;
            case 5: $msg .= "Of course not! This is the first time, I never tried it on people."; break;
        }

        return $msg;
    }

    public function getSource($number)
    {
        switch ($number)
        {
            case 0: return "Laverne";
            case 1: return "Dr. Fred";
            case 2: return "Hoagie";
            case 3: return "Dr. Fred";
            case 4: return "Bernard";
            case 5: return "Dr. Fred";
        }
    }

    public function getCategory($number)
    {
        switch ($number)
        {
            case 0: return "Female";
            case 1: return "Male";
            case 2: return "Male";
            case 3: return "Male";
            case 4: return "Male";
            case 5: return "Male";
        }
    }
    
}
?>
