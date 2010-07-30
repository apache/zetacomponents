<?php
/**
 * ezcConsoleToolsSuite
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
 * @package ConsoleTools
 * @subpackage Tests
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2010 eZ Systems AS. All rights reserved.
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 */

/**
 * String too, used by several other classes in this component. 
 */
require_once 'string_tools_test.php';

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
 * Require test suite for ezcConsoleArgument class. 
 */
require_once 'argument_test.php';
/**
 * Require test suite for ezcConsoleArguments class. 
 */
require_once 'arguments_test.php';

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
 * Require test suite for ezcConsoleDialogOptions class. 
 */
require_once 'dialog_options_test.php';
/**
 * Require test suite for ezcConsoleQuestionDialog class. 
 */
require_once 'question_dialog_test.php';
/**
 * Require test suite for ezcConsoleQuestionDialogOptions class. 
 */
require_once 'question_dialog_options_test.php';
/**
 * Require test suite for ezcConsoleQuestionDialogCollectionValidator class. 
 */
require_once 'question_dialog_mapping_validator_test.php';
/**
 * Require test suite for ezcConsoleQuestionDialogMappingValidator class. 
 */
require_once 'question_dialog_collection_validator_test.php';
/**
 * Require test suite for ezcConsoleQuestionDialogTypeValidator class. 
 */
require_once 'question_dialog_type_validator_test.php';
/**
 * Require test suite for ezcConsoleQuestionDialogRegexValidator class. 
 */
require_once 'question_dialog_regex_validator_test.php';
/**
 * Require test suite for ezcConsoleMenuDialog class. 
 */
require_once 'menu_dialog_test.php';
/**
 * Require test suite for ezcConsoleMenuDialogOptions class. 
 */
require_once 'menu_dialog_options_test.php';
/**
 * Require test suite for ezcConsoleMenuDialogDefaultValidator class. 
 */
require_once 'menu_dialog_default_validator_test.php';
    
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

		$this->addTest( ezcConsoleStringToolsTest::suite() );
        
		$this->addTest( ezcConsoleOutputTest::suite() );
		$this->addTest( ezcConsoleOutputFormatTest::suite() );
		$this->addTest( ezcConsoleOutputFormatsTest::suite() );
		$this->addTest( ezcConsoleOutputOptionsTest::suite() );

		$this->addTest( ezcConsoleInputTest::suite() );
		$this->addTest( ezcConsoleOptionTest::suite() );
		$this->addTest( ezcConsoleOptionRuleTest::suite() );
		$this->addTest( ezcConsoleArgumentTest::suite() );
		$this->addTest( ezcConsoleArgumentsTest::suite() );

		$this->addTest( ezcConsoleTableCellTest::suite() );
		$this->addTest( ezcConsoleTableRowTest::suite() );
		$this->addTest( ezcConsoleTableTest::suite() );
		$this->addTest( ezcConsoleTableOptionsTest::suite() );

		$this->addTest( ezcConsoleProgressbarTest::suite() );
		$this->addTest( ezcConsoleProgressbarOptionsTest::suite() );

		$this->addTest( ezcConsoleStatusbarTest::suite() );
		$this->addTest( ezcConsoleStatusbarOptionsTest::suite() );

		$this->addTest( ezcConsoleProgressMonitorTest::suite() );
		$this->addTest( ezcConsoleProgressMonitorOptionsTest::suite() );

		$this->addTest( ezcConsoleQuestionDialogTest::suite() );
		$this->addTest( ezcConsoleDialogOptionsTest::suite() );
		$this->addTest( ezcConsoleQuestionDialogOptionsTest::suite() );
		$this->addTest( ezcConsoleQuestionDialogCollectionValidatorTest::suite() );
		$this->addTest( ezcConsoleQuestionDialogMappingValidatorTest::suite() );
		$this->addTest( ezcConsoleQuestionDialogTypeValidatorTest::suite() );
		$this->addTest( ezcConsoleQuestionDialogRegexValidatorTest::suite() );
		$this->addTest( ezcConsoleMenuDialogTest::suite() );
		$this->addTest( ezcConsoleMenuDialogOptionsTest::suite() );
		$this->addTest( ezcConsoleMenuDialogDefaultValidatorTest::suite() );
	}

    public static function suite()
    {
        return new ezcConsoleToolsSuite( "ezcConsoleToolsSuite" );
    }
}
?>
