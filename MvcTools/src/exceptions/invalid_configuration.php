<?php
/**
 * File containing the ezcMvcInvalidConfiguration eception
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
 * @package MvcTools
 * @version //autogen//
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 */

/**
 * Exception that is thrown if an invalid class is returned from any of the
 * configuration methods of the ezcMvcConfigurableDispatcher configuration.
 *
 * @package MvcTools
 * @version //autogen//
 */
class ezcMvcInvalidConfiguration extends ezcMvcToolsException
{
    /**
     * Constructs a new ezcMvcInvalidConfiguration exception for configuration $item
     *
     * @param string $item
     * @param mixed  $real
     * @param string $expected
     * @return void
     */
    function __construct( $item, $real, $expected )
    {
        $type = gettype( $real );
        if ( $type == 'object' )
        {
            $type = 'instance of class ' . get_class( $real );
        }
        parent::__construct( "The configuration returned an invalid object for '{$item}', {$expected} expected, but {$type} found." );
    }
}
?>
