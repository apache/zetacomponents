<?php
/**
 * File containing the ezcDebugWriterMemory class.
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
 * @access private
 */

/**
 * This class implements a LogWriter. This writer will write all the log messages
 * it receives to an internal structure. The whole internal structure can be sent
 * to an formatter when the getLogEntries() method is called.
 *
 * @package Debug
 * @version //autogentag//
 * @access private
 */
class ezcDebugMemoryWriter implements ezcLogWriter
{
    /**
     * Internal structure to hold the log messages.
     *
     * @var array(ezcDebugStructure)
     */
    private $logData = array();

    /**
     * Resets the writer to its initial state.
     *
     * @return void
     */
    public function reset()
    {
        $this->logData = array();
    }

    /**
     * Writes a log entry to the internal memory structure.
     *
     * The writer can use the severity, source, and category to filter the
     * incoming messages and determine the location where the messages should
     * be written.
     *
     * $extraInfo may contain extra information that can be added to the log. For example:
     * line numbers, file names, usernames, etc.
     *
     * $severity can be one of:
     * <ul>
     * <li>{@link ezcDebug::DEBUG}</li>
     * <li>{@link ezcDebug::SUCCESS_AUDIT}</li>
     * <li>{@link ezcDebug::FAILED_AUDIT}</li>
     * <li>{@link ezcDebug::INFO}</li>
     * <li>{@link ezcDebug::NOTICE}</li>
     * <li>{@link ezcDebug::WARNING}</li>
     * <li>{@link ezcDebug::ERROR}</li>
     * <li>{@link ezcDebug::FATAL}</li>
     * </ul>.
     *
     * @param string $message
     * @param int $severity  ezcLog::* 
     * @param string $source
     * @param string $category
     * @param array(string=>string) $extraInfo
     */
    public function writeLogMessage( $message, $severity, $source, $category, $extraInfo = array() )
    {
        $log = new ezcDebugStructure();
        $log->message = $message;
        $log->severity = $severity;
        $log->source = $source;
        $log->category = $category;
        $log->datetime = time();

        if ( is_array( $extraInfo ) )
        {
            foreach ( $extraInfo as $key => $val )
            {
                $log->$key = $val;
            }
        }

        $this->logData[] = $log;
    }

    /**
     * Returns the log messages stored in memory.
     *
     * @return array(ezcDebugStructure)
     */
    public function getStructure()
    {
        return $this->logData;
    }
}
?>
