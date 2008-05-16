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

    public function setUp()
    {
        $dbg = ezcDebug::getInstance();
        $dbg->reset();
        $dbg->setOutputFormatter( new TestReporter() );

        $dbg->getEventLog()->source   = 'DefaultSource';
        $dbg->getEventLog()->category = 'DefaultCategory';
        
        set_error_handler( array( 'ezcDebug', 'debugHandler' ) );
    }

    public function tearDown()
    {
        restore_error_handler();
    }
    
    public function testParseMessage()
    {
        trigger_error( '[Source, Category] 23: Message', E_USER_WARNING );

        $out = ezcDebug::getInstance()->generateOutput();

        $this->assertEquals(
            'Message',
            $out[0][0]->message
        );
        $this->assertEquals(
            23,
            $out[0][0]->verbosity
        );
        $this->assertEquals(
            'Category',
            $out[0][0]->category
        );
        $this->assertEquals(
            'Source',
            $out[0][0]->source
        );
    }

    public function testParseMessageNoMessage()
    {
        trigger_error( '[Source, Category] 23:', E_USER_WARNING );

        $out = ezcDebug::getInstance()->generateOutput();

        $this->assertEquals(
            false,
            $out[0][0]->message
        );
        $this->assertEquals(
            23,
            $out[0][0]->verbosity
        );
        $this->assertEquals(
            'Category',
            $out[0][0]->category
        );
        $this->assertEquals(
            'Source',
            $out[0][0]->source
        );
    }
    
    public function testParseMessageNoSource()
    {
        trigger_error( '[Category] 23: Message', E_USER_WARNING );

        $out = ezcDebug::getInstance()->generateOutput();

        $this->assertEquals(
            'Message',
            $out[0][0]->message
        );
        $this->assertEquals(
            23,
            $out[0][0]->verbosity
        );
        $this->assertEquals(
            'Category',
            $out[0][0]->category
        );
        $this->assertEquals(
            'DefaultSource',
            $out[0][0]->source
        );
    }
    
    public function testParseMessageNoCategoryNoSource()
    {
        trigger_error( '23: Message', E_USER_WARNING );

        $out = ezcDebug::getInstance()->generateOutput();
        
        $this->assertEquals(
            'Message',
            $out[0][0]->message
        );
        $this->assertEquals(
            23,
            $out[0][0]->verbosity
        );
        $this->assertEquals(
            'DefaultCategory',
            $out[0][0]->category
        );
        $this->assertEquals(
            'DefaultSource',
            $out[0][0]->source
        );
    }
    
    public function testParseMessageSeverityNotice()
    {
        trigger_error( '[Source, Category] 23: Message', E_USER_NOTICE );

        $out = ezcDebug::getInstance()->generateOutput();

        $this->assertEquals(
            'Message',
            $out[0][0]->message
        );
        $this->assertEquals(
            23,
            $out[0][0]->verbosity
        );
        $this->assertEquals(
            'Category',
            $out[0][0]->category
        );
        $this->assertEquals(
            'Source',
            $out[0][0]->source
        );
    }
    
    public function testParseMessageSeverityError()
    {
        trigger_error( '[Source, Category] 23: Message', E_USER_ERROR );

        $out = ezcDebug::getInstance()->generateOutput();

        $this->assertEquals(
            'Message',
            $out[0][0]->message
        );
        $this->assertEquals(
            23,
            $out[0][0]->verbosity
        );
        $this->assertEquals(
            'Category',
            $out[0][0]->category
        );
        $this->assertEquals(
            'Source',
            $out[0][0]->source
        );
    }
    
    public function testParseMessageUnknownSeverity()
    {
        trigger_error( '[Source, Category] 23: Message', 42 );

        $out = ezcDebug::getInstance()->generateOutput();

        $this->assertEquals(
            'Invalid error type specified',
            $out[0][0]->message
        );
        $this->assertEquals(
            false,
            $out[0][0]->verbosity
        );
        $this->assertEquals(
            'DefaultCategory',
            $out[0][0]->category
        );
        $this->assertEquals(
            'DefaultSource',
            $out[0][0]->source
        );
    }
}
?>
