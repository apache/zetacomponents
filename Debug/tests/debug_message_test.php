<?php
/**
 *
 * Licensed to the Apache Software Foundation (ASF) under one
 * or more contributor license agreements.  See the NOTICE file
 * distributed with this work for additional information
 * regarding copyright ownership.  The ASF licenses this file
 * to you under the Apache License, Version 2.0 (the
 * "License"); you may not use this file except in compliance
 * with the License.  You may obtain a copy of the License at
 * 
 *   http://www.apache.org/licenses/LICENSE-2.0
 * 
 * Unless required by applicable law or agreed to in writing,
 * software distributed under the License is distributed on an
 * "AS IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS OF ANY
 * KIND, either express or implied.  See the License for the
 * specific language governing permissions and limitations
 * under the License.
 *
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 * @version //autogentag//
 * @filesource
 * @package Debug
 * @subpackage Tests
 */

require_once 'test_classes.php';

function testDebugMessageErrorHandler( $errno, $errstr, $errfile, $errline )
{
    ezcDebug::debugHandler( $errno, $errstr, $errfile, $errline );
    return true;
}

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
        
        set_error_handler( 'testDebugMessageErrorHandler' );
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
