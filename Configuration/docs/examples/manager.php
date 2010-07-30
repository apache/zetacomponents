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
 * @package Configuration
 * @subpackage Examples
 */

require 'autoload.php';

// A small example which reads settings using the manager
// The manager will take care of caching (disk and memory).
//
// If something goes wrong (file reading or setting access) it will catch
// the exception and show the problem.

/**
 * Shows the settings by using the manager
 */
function showSettings()
{
    $title = ezcConfigurationManager::getInstance()->getSetting( 'settings', 'site', 'title' );

    print "Title is $title\n";

    list( $dbHost, $dbUser, $dbPassword ) =
        ezcConfigurationManager::getInstance()->getSettingsAsList( 'settings', 'db', array( 'host', 'user', 'password' ) );
    print "Connecting to database at '{$dbHost}' with user '{$dbUser}' and password '{$dbPassword}'.\n";

    if ( ezcConfigurationManager::getInstance()->hasSetting( 'settings', 'db', 'socket' ) )
    {
        print 'Socket: ' . ezcConfigurationManager::getInstance()->getSetting( 'settings', 'db', 'socket' ) . "\n";
    }
}

try
{
    // Start of program
    $man = ezcConfigurationManager::getInstance();
    $man->init( 'ezcConfigurationIniReader', dirname( __FILE__ ), array( 'useComments' => false ) );

    showSettings();
}
catch ( Exception $e )
{
    print "Caught exception while reading INI file\n";
    print $e->getMessage() . "(" . $e->getCode() . ")\n";
    print $e->getTraceAsString() . "\n";
}

?>
