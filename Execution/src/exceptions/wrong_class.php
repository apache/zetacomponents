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
 * @package Execution
 * @version //autogen//
 * @copyright Copyright (C) 2005-2010 eZ Systems AS. All rights reserved.
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 */

/**
 * Thrown when the passed classname does not represent a class that
 * implements the ezcExecutionErrorHandler interface.
 * 
 * @package Execution
 * @version //autogen//
 */
class ezcExecutionWrongClassException extends ezcExecutionException
{
    /**
     * Constructs a new ezcExecutionWrongClassException.
     *
     * @param string $callbackClassName
     * @return void
     */
    function __construct( $callbackClassName )
    {
        parent::__construct( "The class '{$callbackClassName}' does not implement the 'ezcExecutionErrorHandler' interface." );
    }
}
?>
