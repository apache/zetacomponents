<?php
/**
 * File containing the ezcTemplateNoOutputContextException class
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
 * Exception for for missing output contexts in classes.
 *
 * @package Template
 * @version //autogen//
 */
class ezcTemplateNoOutputContextException extends ezcTemplateException
{
    /**
     * Initialises the exception with the location object $location which
     * contains the locator which is missing.
     *
     * @param string $class The name of the class which is missing the context.
     * @param string $property The name of the property which is missing the contex.
     */
    public function __construct( $class, $property )
    {
        parent::__construct( "The class '{$class}' and property '{$property}' does not contain a template output context which is required." );
    }
}
?>
