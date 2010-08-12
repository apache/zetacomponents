<?php
/**
 * Autoloader definition for the Debug component.
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
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 * @version //autogentag//
 * @filesource
 * @package Debug
 */

return array(
    'ezcDebugException'                      => 'Debug/exceptions/exception.php',
    'ezcDebugOperationNotPermittedException' => 'Debug/exceptions/operation_not_permitted.php',
    'ezcDebugOutputFormatter'                => 'Debug/interfaces/formatter.php',
    'ezcDebugStacktraceIterator'             => 'Debug/interfaces/stacktrace_iterator.php',
    'ezcDebug'                               => 'Debug/debug.php',
    'ezcDebugHtmlFormatter'                  => 'Debug/formatters/html_formatter.php',
    'ezcDebugMemoryWriter'                   => 'Debug/writers/memory_writer.php',
    'ezcDebugOptions'                        => 'Debug/options.php',
    'ezcDebugPhpStacktraceIterator'          => 'Debug/stacktrace/php_iterator.php',
    'ezcDebugStructure'                      => 'Debug/structs/debug_structure.php',
    'ezcDebugSwitchTimerStruct'              => 'Debug/structs/switch_timer.php',
    'ezcDebugTimer'                          => 'Debug/debug_timer.php',
    'ezcDebugTimerStruct'                    => 'Debug/structs/timer.php',
    'ezcDebugVariableDumpTool'               => 'Debug/tools/dump.php',
    'ezcDebugXdebugStacktraceIterator'       => 'Debug/stacktrace/xdebug_iterator.php',
);
?>
