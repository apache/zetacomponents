<?php
/**
 * File containing the ezcLogUnixFileWriter class.
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
 * Writes the log messages to a file in a format that is frequently used on the Unix operating system.
 *
 * @package EventLog
 * @version //autogentag//
 * @mainclass
 */
class ezcLogUnixFileWriter extends ezcLogFileWriter
{
    /**
     * Write the logEntries to a file.
     *
     * Each line in the log file represents a log message. The log
     * messages have the following style:
     * <pre>
     * MMM dd HH:mm:ss [Severity] [Source] [Category] Message (ExtraInfo)
     * </pre>
     *
     * With:
     * - MMM: The 3 letter abbreviation of the month.
     * - dd: The day of the month.
     * - HH: The hour.
     * - mm: The minutes.
     * - ss: The seconds.
     *
     * Example:
     * <pre>
     * Jan 24 15:32:56 [Debug] [Paynet] [Shop] Connecting to the paynet server (file: paynet_server.php, line: 224).
     * Jan 24 15:33:01 [Debug] [Paynet] [Shop] Connected with the server (file: paynet_server.php, line: 710).
     * </pre>
     *
     * This method will be called by the {@link ezcLog} class.  The $eventSource and $eventCategory are either given
     * in the {@link ezcLog::log()} method or are the defaults from the {@link ezcLog} class.
     *
     * @param string $message
     * @param int $eventType
     * @param string $eventSource
     * @param string $eventCategory
     * @param array(string=>string) $extraInfo
     */
    public function writeLogMessage( $message, $eventType, $eventSource, $eventCategory, $extraInfo = array() )
    {
        $extra = "";

        if ( sizeof( $extraInfo ) > 0 )
        {
            $extra =  " (" . $this->implodeWithKey( ", ", ": ", $extraInfo ) . ")";
        }

        if ( $eventCategory == false )
        {
            $eventCategory = "";
        }
        $logMsg = date( "M d H:i:s" ) .
            " [".ezcLog::translateSeverityName( $eventType ) .
            "] ".
            ( $eventSource == "" ? "" : "[$eventSource] ") .
            ( $eventCategory == "" ? "" : "[$eventCategory] " ).
            "{$message}{$extra}\n";

        $this->write( $eventType, $eventSource, $eventCategory, $logMsg );
    }

    /**
     * Returns a string from the hash $data.
     *
     * The string $splitEntry specifies the string that will be inserted between the pairs.
     * The string $splitKeyVal specifies the string that will be inserted in each pair.
     *
     * Example:
     * <code>
     * $this->implodeWithKey( ", ", ": ", array( "Car" => "red", "Curtains" => "blue" );
     * </code>
     *
     * Will create the following string:
     * <pre>
     * Car: red, Curtains: blue
     * </pre>
     *
     * @param string $splitEntry
     * @param string $splitKeyVal
     * @param array(mixed=>mixed) $data
     * @return string
     */
    protected function implodeWithKey( $splitEntry, $splitKeyVal, $data)
    {
        $total = "";
        if ( is_array( $data ) )
        {
            foreach ( $data as $key => $val )
            {
                $total .=  $splitEntry . $key . $splitKeyVal . $val;
            }
        }

        return substr( $total, strlen( $splitEntry ) );
    }
}
?>
