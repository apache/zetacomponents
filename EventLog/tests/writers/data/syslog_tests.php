<?php
/**
 * File containing test code for the EventLog component.
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
 * @package EventLog
 * @version //autogentag//
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 */

require dirname( __FILE__ ) . '/../../../../Base/src/base.php';
function __autoload( $className )
{
    ezcBase::autoload( $className );
}

$writer = new ezcLogSyslogWriter( "ezctest", LOG_PERROR|LOG_PID|LOG_ODELAY );

// extras
$writer->writeLogMessage( "I was bowling.", ezcLog::DEBUG, "Donny", "quotes",
                                array( "movie" => "The Big Lebowski" ) );

// debug
$writer->writeLogMessage( "The dude abides.", ezcLog::DEBUG, "Lebowski", "quotes" );

// success audit
$writer->writeLogMessage( "Don't be fatuous, Jeffrey.", ezcLog::SUCCESS_AUDIT, "Maude", "quotes" );

// fail audit
$writer->writeLogMessage( "Also, my rug was stolen.", ezcLog::FAILED_AUDIT, "Lebowski", "quotes" );

// info
$writer->writeLogMessage( "Obviously you're not a golfer.", ezcLog::INFO, "Lebowski", "quotes" );

// notice
$writer->writeLogMessage( "Forget it, Donny, you're out of your element!",
                          ezcLog::NOTICE, "Walter", "quotes" );

// warning
$writer->writeLogMessage( "Donny you're out of your element! Dude, the Chinaman is not the issue here!",
                          ezcLog::FAILED_AUDIT, "Walter", "quotes" );

// fatal
$writer->writeLogMessage( "Ok, Dude. Have it your way.", ezcLog::FATAL, "The stranger", "quotes" );

?>
