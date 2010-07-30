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

// A small example which reads an INI file and reads out some settings
// It uses the array reader/writer to cache the INI file.
//
// If something goes wrong (file reading or setting access) it will catch
// the exception and show the problem.

try
{
    $ini = new ezcConfigurationArrayReader( dirname( __FILE__ ) . '/settings.php' );
    if ( !$ini->configExists() )
    {
        print "Cache does not exist, generating\n";
        // Cache is not present so we read the original file
        $ini = new ezcConfigurationIniReader( dirname( __FILE__ ) . '/settings.ini' );
        $conf = $ini->load();
        // Write back the cache
        $cache = new ezcConfigurationArrayWriter( dirname( __FILE__ ) . '/settings.php', $conf );
        $cache->save();
    }
    else
    {
        print "Reading from cache\n";
        $conf = $ini->load();
    }

    $title = $conf->getSetting( 'site', 'title' );

    print "Title is $title\n";
}
catch ( Exception $e )
{
    print "Caught exception while reading INI file\n";
    print $e->getMessage() . "(" . $e->getCode() . ")\n";
    print $e->getTraceAsString() . "\n";
}

?>
