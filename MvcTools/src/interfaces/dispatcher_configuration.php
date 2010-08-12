<?php
/**
 * File containing the ezcMvcDispatcherConfiguration class
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
 * Configure a dispatcher with an instance of an implementation of this
 * interface.
 *
 * You can use any dispatcher with the same configuration class.
 *
 * @package MvcTools
 * @version //autogentag//
 * @mainclass
 */
interface ezcMvcDispatcherConfiguration
{
    /**
     * Creates the request parser able to produce a relevant request object
     * for this session.
     *
     * @return ezcMvcRequestParser
     */
    public function createRequestParser();

    /**
     * Create the router able to instantiate a relevant controller for this
     * request.
     *
     * @param ezcMvcRequest $request
     *
     * @return ezcMvcRouter
     */
    public function createRouter( ezcMvcRequest $request );

    /**
     * Creates the view handler that is able to process the result.
     *
     * @param ezcMvcRoutingInformation $routeInfo
     * @param ezcMvcRequest $request
     * @param ezcMvcResult $result
     *
     * @return ezcMvcView
     */
    public function createView( ezcMvcRoutingInformation $routeInfo, ezcMvcRequest $request, ezcMvcResult $result );

    /**
     * Creates a response writer that uses the response and sends its
     * output.
     *
     * This method should be able to pick different response writers, but the
     * response writer itself will only know about the $response.
     *
     * @param ezcMvcRoutingInformation $routeInfo
     * @param ezcMvcRequest $request
     * @param ezcMvcResult $result
     * @param ezcMvcResponse $response
     *
     * @return ezcMvcResponseWriter
     */
    public function createResponseWriter( ezcMvcRoutingInformation $routeInfo, ezcMvcRequest $request, ezcMvcResult $result, ezcMvcResponse $response );

    /**
     * Create the default internal redirect object in case something goes
     * wrong in the views.
     *
     * @param ezcMvcRequest $request
     * @param ezcMvcResult  $result
     * @param Exception     $e
     *
     * @return ezcMvcRedirect
     */
    public function createFatalRedirectRequest( ezcMvcRequest $request, ezcMvcResult $result, Exception $e );

    /**
     * Runs all the pre-routing filters that are deemed necessary depending on
     * information in $request.
     *
     * The pre-routing filters could modify the request data so that a
     * different router can be chosen.
     *
     * @param ezcMvcRequest $request
     */
    public function runPreRoutingFilters( ezcMvcRequest $request );

    /**
     * Runs all the request filters that are deemed necessary depending on
     * information in $routeInfo and $request.
     *
     * This method can return an object of class ezcMvcInternalRedirect in case
     * the filters require this. A reason for this could be in case an
     * authentication filter requires authentication credentials to be passed
     * in through a login form. The method can also not return anything in case
     * no redirect is necessary.
     *
     * @param ezcMvcRoutingInformation $routeInfo
     * @param ezcMvcRequest $request
     *
     * @return ezcMvcInternalRedirect|null
     */
    public function runRequestFilters( ezcMvcRoutingInformation $routeInfo, ezcMvcRequest $request );

    /**
     * Runs all the request filters that are deemed necessary depending on
     * information in $routeInfo, $request and $result.
     *
     * @param ezcMvcRoutingInformation $routeInfo
     * @param ezcMvcRequest $request
     * @param ezcMvcResult $result
     */
    public function runResultFilters( ezcMvcRoutingInformation $routeInfo, ezcMvcRequest $request, ezcMvcResult $result );

    /**
     * Runs all the request filters that are deemed necessary depending on
     * information in $routeInfo, $request, $result and $response.
     *
     * @param ezcMvcRoutingInformation $routeInfo
     * @param ezcMvcRequest $request
     * @param ezcMvcResult  $result
     * @param ezcMvcResponse $response
     */
    public function runResponseFilters( ezcMvcRoutingInformation $routeInfo, ezcMvcRequest $request, ezcMvcResult $result, ezcMvcResponse $response );
}
?>
