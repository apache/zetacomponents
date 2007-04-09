<?php
/**
 * ezcConsoleToolsSuite
 * 
 * @package ConsoleTools
 * @subpackage Tests
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
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
 * Require test suite for ezcConsoleOption class.
 */
require_once 'option_test.php';
/**
 * Require test suite for ezcConsoleOptionRule class.
 */
require_once 'option_rule_test.php';
/**
 * Require test suite for ezcConsoleTable class.
 */
require_once 'table_test.php';
/**
 * Require test suite for ezcConsoleTableOptions class.
 */
require_once 'table_options_test.php';
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
 * Require test suite for ezcConsoleProgressbar class.
 */
require_once 'progressbar_options_test.php';
/**
 * Require test suite for ezcConsoleStatusbar class.
 */
require_once 'statusbar_test.php';
/**
 * Require test suite for ezcConsoleStatusbarOptions class.
 */
require_once 'statusbar_options_test.php';
/**
 * Require test suite for ezcConsoleProgressMonitor class.
 */
require_once 'progressmonitor_test.php';
/**
 * Require test suite for ezcConsoleProgressMonitor class.
 */
require_once 'progressmonitor_options_test.php';

/**
 * Require test suite for ezcConsoleQuestionDialog class. 
 */
require_once 'question_dialog_test.php';

/**
 * Require test suite for ezcConsoleQuestionDialogCollectionValidator class. 
 */
require_once 'question_dialog_collection_validator_test.php';
    
/**
 * Test suite for ConsoleTools package.
 * 
 * @package ConsoleTools
 * @subpackage Tests
 */
class ezcConsoleToolsSuite extends PHPUnit_Framework_TestSuite
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
		$this->addTest( ezcConsoleToolsOptionTest::suite() );
		$this->addTest( ezcConsoleToolsOptionRuleTest::suite() );
		$this->addTest( ezcConsoleToolsTableCellTest::suite() );
		$this->addTest( ezcConsoleToolsTableRowTest::suite() );
		$this->addTest( ezcConsoleToolsTableTest::suite() );
		$this->addTest( ezcConsoleToolsTableOptionsTest::suite() );
		$this->addTest( ezcConsoleToolsProgressbarTest::suite() );
		$this->addTest( ezcConsoleToolsProgressbarOptionsTest::suite() );
		$this->addTest( ezcConsoleToolsStatusbarTest::suite() );
		$this->addTest( ezcConsoleToolsStatusbarOptionsTest::suite() );
		$this->addTest( ezcConsoleToolsProgressMonitorTest::suite() );
		$this->addTest( ezcConsoleToolsProgressMonitorOptionsTest::suite() );
		$this->addTest( ezcConsoleToolsQuestionDialogTest::suite() );
		$this->addTest( ezcConsoleQuestionDialogCollectionValidatorTest::suite() );
	}

    public static function suite()
    {
        return new ezcConsoleToolsSuite( "ezcConsoleToolsSuite" );
    }
}
?>
