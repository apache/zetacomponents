<?php
/**
 * File contaning the execution script for the eZ Components test runner.
 *
 * @package UnitTest
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
require_once 'PHPUnit/Util/Filter.php';

PHPUnit_Util_Filter::addFileToFilter( __FILE__, 'PHPUNIT' );

require_once 'bootstrap.php';

ezcTestRunner::main();
?>
