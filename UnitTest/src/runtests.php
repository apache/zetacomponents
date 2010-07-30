#!/usr/bin/env php
<?php
/**
 * File contaning the execution script for the eZ Components test runner.
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
 * @package UnitTest
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2010 eZ Systems AS. All rights reserved.
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 */

require_once 'PHPUnit/Runner/Version.php';
require_once 'PHPUnit/Util/Filter.php';

$version = PHPUnit_Runner_Version::id();

if ( version_compare( $version, '3.4.0' ) == -1 && $version !== '@package_version@' )
{
    die( "PHPUnit 3.4.0 (or later) is required to run this test suite.\n" );
}

PHPUnit_Util_Filter::addFileToFilter( __FILE__, 'PHPUNIT' );

require_once 'bootstrap.php';

$runner = new ezcTestRunner;
$runner->run($_SERVER['argv']);
?>
