<?php
/**
 * Interface defining controller classes.
 * 
 * Controllers process the client's request and returns variables usable by
 * the view-manager in an instance of an ezcMvcResult.
 * Controllers should not access request variables directly but should use the
 * passed ezcMvcRequest.
 * The process is done through the createResult() method, but is not limited
 * to use protected
 * nor private methods. The result of running a controller is an instance of
 * ezcMvcResult.
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
 * @mainclass
 */
interface ezcMvcController
{
    /**
     * Creates a new controller object
     *
     * @param ezcMvcRequest $request
     * @param array() $variables
     */
    public function __construct( ezcMvcRequest $request, array $variables );

    /**
     * Runs the controller to process the query and return variables usable
     * to render the view. 
     * 
     * @return ezcMvcResult|ezcMvcInternalRedirect
     */
    public function createResult();

    /**
     * Should be called at the start of the createResult() method to run
     * the request filters.
     */
    public function runRequestFilters();

    /**
     * Should be called at the end of the createResult() method to run
     * the result filters.
     */
    public function runResultFilters();
}
?>
