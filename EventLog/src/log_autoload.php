<?php
/**
 * Autoloader definition for the EventLog component.
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
 * @package EventLog
 */

return array(
    'ezcLogWriterException'        => 'EventLog/exceptions/writer_exception.php',
    'ezcLogWrongSeverityException' => 'EventLog/exceptions/wrong_severity.php',
    'ezcLogWriter'                 => 'EventLog/interfaces/writer.php',
    'ezcLogFileWriter'             => 'EventLog/writers/writer_file.php',
    'ezcLogMapper'                 => 'EventLog/interfaces/mapper.php',
    'ezcLog'                       => 'EventLog/log.php',
    'ezcLogContext'                => 'EventLog/context.php',
    'ezcLogEntry'                  => 'EventLog/structs/log_entry.php',
    'ezcLogFilter'                 => 'EventLog/structs/log_filter.php',
    'ezcLogFilterRule'             => 'EventLog/mapper/filter_rule.php',
    'ezcLogFilterSet'              => 'EventLog/mapper/filterset.php',
    'ezcLogMessage'                => 'EventLog/log_message.php',
    'ezcLogStackWriter'            => 'EventLog/writers/writer_stack.php',
    'ezcLogSyslogWriter'           => 'EventLog/writers/writer_syslog.php',
    'ezcLogUnixFileWriter'         => 'EventLog/writers/writer_unix_file.php',
);
?>
