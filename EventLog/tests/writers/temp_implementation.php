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
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 * @version //autogentag//
 * @filesource
 * @package EventLog
 * @subpackage Tests
 */

/**
 * Test file for ezcLogFileWriterTest.
 *
 * @package EventLog
 * @subpackage Tests
 */
class TempImplementation extends ezcLogFileWriter
{
    public function __construct($dir, $file = null, $maxSize = 204800, $maxFiles = 3 )
    {
        parent::__construct($dir, $file, $maxSize, $maxFiles);
    }

    public function writeLogMessage( $message, $type, $source, $category, $extraInfo = array() )
    {
        $res = print_r( array( "message" => $message, "type" => $type, "source" => $source, "category" => $category ), true );
        $this->write( $type, $source, $category, $res );
    }

    public function openFile( $fileName )
    {
        return parent::openFile( $fileName );
    }

}
?>
