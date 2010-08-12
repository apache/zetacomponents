<?php
/**
 * File containing the ezcConfigurationException class
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
 * Exception that is thrown if there were errors while parsing a file while the
 * parser was not in validation mode.
 *
 * @package Configuration
 * @version //autogen//
 */
class ezcConfigurationParseErrorException extends ezcConfigurationException
{
    /**
     * Constructs a new ezcConfigurationParseErrorException.
     *
     * @param string $fileName The name of the file with the parse error.
     * @param int    $lineNr
     * @param string $description
     * @return void
     */
    function __construct( $fileName, $lineNr, $description )
    {
        parent::__construct( "{$description} in '{$fileName}', line '{$lineNr}'." );
    }
}
?>
