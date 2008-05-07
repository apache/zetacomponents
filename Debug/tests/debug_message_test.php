<?php
/**
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
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
class ezcDebugMessageTest extends ezcTestCase
{
    public static function suite()
    {
        return new PHPUnit_Framework_TestSuite( __CLASS__ );
    }
    
    public function testParseMessage()
    {
        $msg = new ezcDebugMessage(
            '[Source, Category] 23: Message',
            E_USER_WARNING,
            'DefaultSource',
            'DefaultCategory'
        );

        $this->assertEquals(
            'Message',
            $msg->message
        );
        $this->assertEquals(
            23,
            $msg->verbosity
        );
        $this->assertEquals(
            'Category',
            $msg->category
        );
        $this->assertEquals(
            'Source',
            $msg->source
        );
        $this->assertEquals(
            ezcLog::WARNING,
            $msg->severity
        );
    }

    public function testParseMessageNoMessage()
    {
        $msg = new ezcDebugMessage(
            '[Source, Category] 23:',
            E_USER_WARNING,
            'DefaultSource',
            'DefaultCategory'
        );

        $this->assertEquals(
            false,
            $msg->message
        );
        $this->assertEquals(
            23,
            $msg->verbosity
        );
        $this->assertEquals(
            'Category',
            $msg->category
        );
        $this->assertEquals(
            'Source',
            $msg->source
        );
        $this->assertEquals(
            ezcLog::WARNING,
            $msg->severity
        );
    }
    
    public function testParseMessageNoSource()
    {
        $msg = new ezcDebugMessage(
            '[Category] 23: Message',
            E_USER_WARNING,
            'DefaultSource',
            'DefaultCategory'
        );

        $this->assertEquals(
            'Message',
            $msg->message
        );
        $this->assertEquals(
            23,
            $msg->verbosity
        );
        $this->assertEquals(
            'Category',
            $msg->category
        );
        $this->assertEquals(
            'DefaultSource',
            $msg->source
        );
        $this->assertEquals(
            ezcLog::WARNING,
            $msg->severity
        );
    }
    
    public function testParseMessageNoCategoryNoSource()
    {
        $msg = new ezcDebugMessage(
            '23: Message',
            E_USER_WARNING,
            'DefaultSource',
            'DefaultCategory'
        );
        
        $this->assertEquals(
            'Message',
            $msg->message
        );
        $this->assertEquals(
            23,
            $msg->verbosity
        );
        $this->assertEquals(
            'DefaultCategory',
            $msg->category
        );
        $this->assertEquals(
            'DefaultSource',
            $msg->source
        );
        $this->assertEquals(
            ezcLog::WARNING,
            $msg->severity
        );
    }
    
    public function testParseMessageSeverityNotice()
    {
        $msg = new ezcDebugMessage(
            '[Source, Category] 23: Message',
            E_USER_NOTICE,
            'DefaultSource',
            'DefaultCategory'
        );

        $this->assertEquals(
            'Message',
            $msg->message
        );
        $this->assertEquals(
            23,
            $msg->verbosity
        );
        $this->assertEquals(
            'Category',
            $msg->category
        );
        $this->assertEquals(
            'Source',
            $msg->source
        );
        $this->assertEquals(
            ezcLog::NOTICE,
            $msg->severity
        );
    }
    
    public function testParseMessageSeverityError()
    {
        $msg = new ezcDebugMessage(
            '[Source, Category] 23: Message',
            E_USER_ERROR,
            'DefaultSource',
            'DefaultCategory'
        );

        $this->assertEquals(
            'Message',
            $msg->message
        );
        $this->assertEquals(
            23,
            $msg->verbosity
        );
        $this->assertEquals(
            'Category',
            $msg->category
        );
        $this->assertEquals(
            'Source',
            $msg->source
        );
        $this->assertEquals(
            ezcLog::ERROR,
            $msg->severity
        );
    }
    
    public function testParseMessageUnknownSeverity()
    {
        $msg = new ezcDebugMessage(
            '[Source, Category] 23: Message',
            42,
            'DefaultSource',
            'DefaultCategory'
        );

        $this->assertEquals(
            'Message',
            $msg->message
        );
        $this->assertEquals(
            23,
            $msg->verbosity
        );
        $this->assertEquals(
            'Category',
            $msg->category
        );
        $this->assertEquals(
            'Source',
            $msg->source
        );
        $this->assertEquals(
            false,
            $msg->severity
        );
    }
}
?>
