<?php
/**
 * File containing the ezcReflectionCallToUndefinedMethodException class
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
 * @package Reflection
 * @version //autogen//
 * @copyright Copyright (C) 2005-2010 eZ Systems AS. All rights reserved.
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 */

/**
 * Exception that is thrown if an invalid class is passed as callback class for
 * delayed object configuration.
 *
 * @package Reflection
 * @version //autogen//
 */
class ezcReflectionCallToUndefinedMethodException extends ezcBaseException
{
    /**
     * Constructs a new ezcReflectionCallToUndefinedMethodException.
     *
     * @param string $class
     * @param string $method
     * @return void
     */
    function __construct( $class, $method )
    {
        // TODO One could obtain a stacktrace and report file and line of the invocation
        parent::__construct( "Call to undefined method '{$class}::{$method}'." );
    }
}
