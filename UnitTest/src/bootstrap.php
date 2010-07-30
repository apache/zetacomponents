<?php
/**
 * File contaning the bootstrap script for the eZ Components test runner.
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
require_once 'PHPUnit/Util/Filter.php';

PHPUnit_Util_Filter::addFileToFilter( __FILE__, 'PHPUNIT' );

// All errors must be reported
$currentErrorLevel = error_reporting();
if ( $currentErrorLevel != ( E_ALL | E_STRICT ) )
{
    echo "Your error reporting setting is not E_ALL | E_STRICT, please change\nthis in your php.ini.\n";
    die();
}

ini_set( 'include_path', getcwd(). PATH_SEPARATOR . dirname( __FILE__ ) . '/../..' . PATH_SEPARATOR . ini_get( 'include_path' ) );

require_once 'Base/src/base.php';

function __autoload( $className )
{
    if ( strpos( $className, '_' ) !== false )
    {
        $file = str_replace( '_', '/', $className ) . '.php';
        @$val = require_once( $file );
        return $val === true;
    }
    ezcBase::autoload( $className );
}
?>
