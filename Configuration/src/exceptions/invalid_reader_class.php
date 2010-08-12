<?php
/**
 * File containing the ezcConfigurationIntalidReaderClassException class
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
 * @package Configuration
 * @version //autogen//
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 */

/**
 * Exception that is thrown if an invalid class is passed as INI reader to the manager.
 *
 * @package Configuration
 * @version //autogen//
 */
class ezcConfigurationInvalidReaderClassException extends ezcConfigurationException
{
    /**
     * Constructs a new ezcConfigurationInvalidReaderClassException for the $readerClass.
     *
     * @param string $readerClass
     * @return void
     */
    function __construct( $readerClass )
    {
        parent::__construct( "Class '{$readerClass}' does not exist, or does not implement the 'ezcConfigurationReader' interface." );
    }
}
?>
