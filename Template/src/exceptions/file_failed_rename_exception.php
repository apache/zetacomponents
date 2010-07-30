<?php
/**
 * File containing the ezcTemplateFileFailedRenameException class
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
 * Exception for problems when renaming template files.
 *
 * @package Template
 * @version //autogen//
 */
class ezcTemplateFileFailedRenameException extends ezcTemplateException
{

    /**
     * Initialises the exception with the original template file path and the new file path.
     *
     * @param string $from The original file path.
     * @param string $to The new file path.
     */
    public function __construct( $from, $to )
    {
        parent::__construct( "Renaming template file from '$from' to '$to' failed." );
    }
}
?>
