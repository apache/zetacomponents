<?php
/**
 * File containing the ezcArchiveEntryPrefixException class.
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
 * An exception for an invalid prefix of a file entry.
 *
 * @package Archive
 * @version //autogentag//
 */
class ezcArchiveEntryPrefixException extends ezcArchiveException
{
    /**
     * Constructs a new entry prefix exception for the specified file entry.
     *
     * @param string $prefix
     * @param string $fileName
     */
    public function __construct( $prefix, $fileName )
    {
        parent::__construct( "The prefix '{$prefix}' from the file entry '{$fileName}' is invalid." );
    }
}
?>
