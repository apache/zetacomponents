<?php
/**
 * File containing the ezcTemplateFileNotWriteableException class
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
 * @copyright Copyright (C) 2005-2010 eZ Systems AS. All rights reserved.
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 */

/**
 * Exception for problems when writing to template files.
 *
 * @package Template
 * @version //autogen//
 */
class ezcTemplateFileNotWriteableException extends ezcTemplateException
{
    /**
     * Constructor
     *
     * @param string $stream    The stream path to the template file which could not be written.
     * @param string $type      The type of the file that could not be read.
     */
    public function __construct( $stream, $type = "requested template file" )
    {
        parent::__construct( "The {$type} '{$stream}' is not writeable." );
    }
}
?>
