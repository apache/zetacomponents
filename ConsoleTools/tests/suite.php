<?php
/**
 * ezcConsoleToolsSuite
 * 
 * @package ConsoleTools
 * @subpackage Tests
 * @version //autogentag//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Require test suite for ezcConsoleOutput class.
 */
require_once 'output_test.php';
/**
 * Require test suite for ezcConsoleOutputFormat class.
 */
require_once 'output_format_test.php';
/**
 * Require test suite for ezcConsoleOutputFormats class.
 */
require_once 'output_formats_test.php';
/**
 * Require test suite for ezcConsoleOutputOptions class.
 */
require_once 'output_options_test.php';
/**
 * Require test suite for ezcConsoleInput class.
 */
require_once 'input_test.php';
/**
 * Require test suite for ezcConsoleTable class.
 */
require_once 'table_test.php';
/**
 * Require test suite for ezcConsoleTable class.
 */
require_once 'table_row_test.php';
/**
 * Require test suite for ezcConsoleTable class.
 */
require_once 'table_cell_test.php';
/**
 * Require test suite for ezcConsoleProgressbar class.
 */
require_once 'progressbar_test.php';
/**
 * Require test suite for ezcConsoleStatusbar class.
 */
require_once 'statusbar_test.php';
/**
 * Require test suite for ezcConsoleProgressMonitor class.
 */
require_once 'progressmonitor_test.php';
    
/**
 * Test suite for ConsoleTools package.
 * 
 * @package ConsoleTools
 * @subpackage Tests
 */
class ezcConsoleToolsSuite extends ezcTestSuite
{
	public function __construct()
	{
		parent::__construct();
        $this->setName( "ConsoleTools" );

		$this->addTest( ezcConsoleToolsOutputTest::suite() );
		$this->addTest( ezcConsoleToolsOutputFormatTest::suite() );
		$this->addTest( ezcConsoleToolsOutputFormatsTest::suite() );
		$this->addTest( ezcConsoleToolsOutputOptionsTest::suite() );
		$this->addTest( ezcConsoleToolsInputTest::suite() );
		$this->addTest( ezcConsoleToolsTableCellTest::suite() );
		$this->addTest( ezcConsoleToolsTableRowTest::suite() );
		$this->addTest( ezcConsoleToolsTableTest::suite() );
		$this->addTest( ezcConsoleToolsProgressbarTest::suite() );
		$this->addTest( ezcConsoleToolsStatusbarTest::suite() );
		$this->addTest( ezcConsoleToolsProgressMonitorTest::suite() );
	}

    public static function suite()
    {
        return new ezcConsoleToolsSuite( "ezcConsoleToolsSuite" );
    }
}
?>
