<?php
/**
 * File containing the ezcMvcRoute class
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
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 * @version //autogentag//
 * @filesource
 * @package MvcTools
 */

/**
 * The interface that should be implemented by the different route types.
 * Each route is responsible for checking whether it matches data in the
 * $request. It also need to support to prefix itself with a route-type
 * dependent prefix string.
 *
 * @package MvcTools
 * @version //autogentag//
 */
interface ezcMvcRoute
{
    /**
     * Returns routing information if the route matched, or null in case the
     * route did not match.
     *
     * @param ezcMvcRequest $request
     * @return null|ezcMvcRoutingInformation
     */
    public function matches( ezcMvcRequest $request );

    /**
     * Adds a prefix to the route.
     *
     * @param mixed $prefix Prefix to add, for example: '/blog'
     */
    public function prefix( $prefix );
}
?>
