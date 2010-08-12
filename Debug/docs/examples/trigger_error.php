<?php
/**
 * This example demonstrates how the Debugger and Log can be used in
 * combination with the trigger_error.
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
 * @package Debug
 * @version //autogentag//
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 */

/**
 * Callback function for the trigger_error function.
 */
function errorHandler( $code, $msg, $file, $line )
{
    if ( /*debug = */ true && $code == E_USER_NOTICE )
    {
        // ezcDebug is auto_included, therefore when debug is disabled this class is not loaded at all.

        // Func: START_TIMER, STOP_TIMER, or LOG.
        // Msg: Message without the 'encoded parameters'.
        // source: Paynet, example, etc.
        // category: Template, SQL, etc.

        $dm = new ezcDebugMessage( $msg );
        $dm->setDefaultSource( "Paynet" );

        if ( $dm->isLog()) 
        {
            ezcDebug::getInstance()->log( $dm->message, $dm->verbosity, $dm->source, 
                                          $dm->category, array( "file" => $file, "line" => $line ) );
        }
        else if ( $parsedMsg->isStartTimer() )
        {
            $ezcDebug->getInstance()->startTimer( $dm->name, $dm->source, $dm->category );
        }
        else if ( $dm->isStopTimer() )
        {
            $ezcDebug->getInstance()->stopTimer( $dm->name );
        }
    }
    else
    {
        // E_USER_WARNING, E_USER_ERROR
        $m = new ezcMessage( $msg );
        $m->setDefaultSource( "Paynet" );

        // Severity is translated: E_USER_WARNING => WARNING, E_USER_ERROR => ERROR.
        ezcLog::getInstance()->log( $m->message, $m->severity, $m->source, $m->category, 
                                    array( "file" => $file, "line" => $line ) );
    }
}

// Set the errorHandler.
set_error_handler( "errorHandler" );

////////////// Possible Debug Log messages: // ////////////////////////////////

// [ Log, source, category ] Verbosity: Msg
trigger_error( "[Log, Paynet, Templates ] 1: Loading header template." );

// [ source, category ] Verbosity: Msg
trigger_error( "[Paynet, Templates ] 2: Loading main template." );

// [ category ] Verbosity: Msg
// Source is specified in the error_handler
trigger_error( "[ SQL ] 1: Last query: $query" );

// [ category ] Verbosity: Msg
// Use the default verbosity
trigger_error( "[ SQL ] Last query: $query" );

// Default category and verbosity
trigger_error( "5 + 5 = 10" );

// Timers:
// [Timer_start, Src, Group] name 
trigger_error( "[ TIMER_START, Paynet, template_timers ] Loading header template." );

// [Timer_start, Group/Category] name 
trigger_error( "[ TIMER_START, sql_timers ] Start_transaction" );

// [Timer_stop] name 
trigger_error( "[ TIMER_STOP ] Start_transaction" );

trigger_error( "[ TIMER_STOP ] Loading header template." );



////////////// Log messages: // ////////////////////////////////

// Warnings and Errors are the same as Debug, except for the severity:
// [ Src, Category ] msg
trigger_error( "[paynet, template] Couldn't load the template: Header", E_USER_WARNING ); 

// Example error:
trigger_error( "[template] Couldn't produce any output", E_USER_ERROR ); 


////////////// Audit trails: // ////////////////////////////////

ezcLog::getInstance()->log( "Added new user: $user", ezcLog::SUCCES_AUDIT, "paynet", "users" );

ezcLog::getInstance()->log( "Couldn't delete user: $user", ezcLog::FAILED_AUDIT, "paynet", "users" );



////////////// Print debug output: // ////////////////////////////////

print ( ezcDebug::getInstance()->getOutput() );
?>
