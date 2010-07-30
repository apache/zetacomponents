<?php
/**
 * Configure a dispatcher with an instance of an implementation of this
 * interface.
 *
 * You can use any dispatcher with the same configuration class.
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
 */
interface ezcMvcDispatcherConfiguration
{
    /**
     * Creates the request parser able to produce a revelant request object
     * for this session.
     *
     * @return ezcMvcRequestParser
     */
    public function createRequestParser();

    /**
     * Create the router able to instanciate a revelant controller for this
     * request.
     * 
     * @return ezcMvcRouter
     */
    public function createRouter( ezcMvcRequest $request );

    /**
     * Creates the view handler that is able to process the result.
     *
     * @return ezcMvcViewHandler
     */
    public function createView( ezcMvcRequest $request, ezcMvcResult $result );

    /**
     * Creates a response writer that uses the response and sends its
     * output.
     *
     * @return ezcMvcResponseWriter
     */
    public function createResponseWriter( ezcMvcRequest $request, ezcMvcResult $result, ezcMvcResponse $response );

    /**
     * Create the default internal redirect object in case something goes
     * wrong in the views.
     *
     * @return ezcMvcInternalRedirect
     */
    public function createFatalRedirectRequest( Exception $e );
}
?>
