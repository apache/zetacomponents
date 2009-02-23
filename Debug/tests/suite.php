<?php
/**
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
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
