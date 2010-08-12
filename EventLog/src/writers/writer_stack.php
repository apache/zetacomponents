<?php
/**
 * File containing the ezcLogStackWriter class.
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

/**
 * The ezcLogStackWriter class stores all received log messages in memory.
 *
 * The main purpose is to get all received log message at once, for example to
 * output them in the webpage.
 *
 * @package EventLog
 * @version //autogentag//
 */
class ezcLogStackWriter implements ezcLogWriter, IteratorAggregate
{
    /**
     * Stores all entries received by this writer.
     *
     * @var array(int=>ezcLogEntry)
     */
    protected $entries = array();

    /**
     * Writes the message $message to the log.
     *
     * The writer can use the severity, source, and category to filter the
     * incoming messages and determine the location where the messages should
     * be written.
     *
     * The array $optional contains extra information that can be added to the
     * log. For example: line numbers, file names, usernames, etc.
     *
     * @throws ezcLogWriterException
     *         If the log writer was unable to write the log message
     *
     * @param string $message
     * @param int $severity
     *        ezcLog::DEBUG, ezcLog::SUCCESS_AUDIT, ezcLog::FAILED_AUDIT,
     *        ezcLog::INFO, ezcLog::NOTICE, ezcLog::WARNING, ezcLog::ERROR or
     *        ezcLog::FATAL.
     * @param string $source
     * @param string $category
     * @param array(string=>string) $optional
     */
    public function writeLogMessage( $message, $severity, $source, $category, $optional = array() )
    {
        $this->entries[] = new ezcLogEntry( $message, $severity, $source, $category, $optional );
    }

    /**
     * Implements IteratorAggreagate, returns iterator for all entries.
     *
     * @see entries
     * @return ArrayObject
     */
    public function getIterator()
    {
        return new ArrayObject( $this->entries );
    }
}
?>
