<?php
/**
 * File containing the ezcArchiveChecksumException class.
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
 * @package Archive
 * @version //autogentag//
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 */

/**
 * Exception will be thrown when the checksum of the file is invalid.
 *
 * @package Archive
 * @version //autogentag//
 */
class ezcArchiveChecksumException extends ezcArchiveException
{
    /**
     * Constructs a new checksum exception for the specified file.
     *
     * @param string $file
     */
    public function __construct( $file )
    {
        parent::__construct( "The checksum of the file '{$file}' is invalid." );
    }
}
?>
