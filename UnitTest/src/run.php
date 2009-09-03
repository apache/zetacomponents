#!/usr/bin/env php
<?php
/**
 * File contaning the execution script for the eZ Components test runner.
 *
 * @package UnitTest
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

require_once 'PHPUnit/Runner/Version.php';
require_once 'PHPUnit/Util/Filter.php';

$version = PHPUnit_Runner_Version::id();

if ( version_compare( $version, '3.4.0RC2' ) == -1 && $version !== '@package_version@' )
{
    die( "PHPUnit 3.4.0 (or later) is required to run this test suite.\n" );
}

PHPUnit_Util_Filter::addFileToFilter( __FILE__, 'PHPUNIT' );

require_once 'bootstrap.php';

$runner = new ezcTestNewRunner;
$runner->run($_SERVER['argv']);
?>
