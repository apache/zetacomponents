<?php
/**
 * File containing the ezcMvcRouteNotFoundException class.
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
 * @version //autogentag//
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 */

/**
 * This exception is thrown when no route matches the request.
 *
 * @package MvcTools
 * @version //autogentag//
 */
class ezcMvcRouteNotFoundException extends ezcMvcToolsException
{
    /**
     * Constructs an ezcMvcRouteNotFoundException
     *
     * @param ezcMvcRequest $request
     */
    public function __construct( ezcMvcRequest $request )
    {
        $id = $request->requestId != '' ? $request->requestId : $request->uri;
        $message = "No route was found that matched request ID '{$id}'.";
        parent::__construct( $message );
    }
}
?>
