<?php
/**
 * File containing the ezcTemplateInvalidCompiledFileException class
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
 * @package Template
 * @version //autogen//
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 */

/**
 * Exception for missing invalid compiled files.
 *
 * @package Template
 * @version //autogen//
 */
class ezcTemplateInvalidCompiledFileException extends ezcTemplateException
{
    /**
     * Initialises the exception with the location object $location which
     * contains the locator which is missing.
     *
     * @param string $identifier The unique identifier for the compiled file.
     * @param string $path The path to the compiled file.
     */
    public function __construct( $identifier, $path )
    {
        if ( !file_exists( $path ) )
        {
            parent::__construct( "The compiled template file '{$path}' does not exist." );
        }
        elseif ( !is_readable( $path ) )
        {
            parent::__construct( "The compiled template file '{$path}' cannot be read." );
        }
    }
}
?>
