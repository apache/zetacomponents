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
 * @copyright Copyright (C) 2005-2010 eZ Systems AS. All rights reserved.
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 * @version //autogentag//
 * @filesource
 * @package Debug
 * @subpackage Tests
 */

/**
 * Including the tests
 */

require_once "debug_delayed_init_test.php";
require_once "debug_test.php";
require_once "debug_message_test.php";
require_once "debug_options_test.php";
require_once "debug_timer_test.php";
require_once "writers/memory_writer_test.php";
require_once "formatters/html_formatter_test.php";
require_once "variable_dump_tool_test.php";
require_once "php_stacktrace_iterator_test.php";
require_once "xdebug_stacktrace_iterator_test.php";

/**
 * @package Debug
 * @subpackage Tests
 */
class ezcDebugSuite extends PHPUnit_Framework_TestSuite
{
	public function __construct()
	{
		parent::__construct();
        $this->setName( "Debug" );

		$this->addTest( ezcDebugDelayedInitTest::suite() );
		$this->addTest( ezcDebugMemoryWriterTest::suite() );
		$this->addTest( ezcDebugTimerTest::suite() );
		$this->addTest( ezcDebugTest::suite() );
		$this->addTest( ezcDebugMessageTest::suite() );
		$this->addTest( ezcDebugOptionsTest::suite() );
		$this->addTest( ezcDebugHtmlFormatterTest::suite() );
		$this->addTest( ezcDebugVariableDumpToolTest::suite() );
		$this->addTest( ezcDebugPhpStacktraceIteratorTest::suite() );
		$this->addTest( ezcDebugXdebugStacktraceIteratorTest::suite() );
	}

    public static function suite()
    {
        return new ezcDebugSuite();
    }
}
?>
