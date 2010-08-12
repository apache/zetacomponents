<?php
/**
 * File containing the ezcMvcRoutingInformation class
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
 * This struct contains information from the router that belongs to the matched
 * route.
 *
 * @package MvcTools
 * @version //autogentag//
 */
class ezcMvcRoutingInformation extends ezcBaseStruct
{
    /**
     * Contains the pattern of the matched route, to be used for view matching
     * and filter chain selection.
     *
     * @var string
     */
    public $matchedRoute;

    /**
     * Contains the class name of the controller that should be instantiated
     * for this route.
     *
     * @var string
     */
    public $controllerClass;

    /**
     * Contains the action that the controller should run.
     *
     * @var string
     */
    public $action;

    /**
     * Contains a backlink to the router, so that the dispatcher can pass this
     * on to the created controllers.
     *
     * @var ezcMvcRouter
     */
    public $router;

    /**
     * Constructs a new ezcMvcRoutingInformation.
     *
     * @param string $matchedRoute
     * @param string $controllerClass
     * @param string $action
     * @param ezcMvcRouter $router
     */
    public function __construct( $matchedRoute = '', $controllerClass = '', $action = '', ezcMvcRouter $router = null )
    {
        $this->matchedRoute = $matchedRoute;
        $this->controllerClass = $controllerClass;
        $this->action = $action;
        $this->router = $router;
    }

    /**
     * Returns a new instance of this class with the data specified by $array.
     *
     * $array contains all the data members of this class in the form:
     * array('member_name'=>value).
     *
     * __set_state makes this class exportable with var_export.
     * var_export() generates code, that calls this method when it
     * is parsed with PHP.
     *
     * @param array(string=>mixed) $array
     * @return ezcMvcRoutingInformation
     */
    static public function __set_state( array $array )
    {
        return new ezcMvcRoutingInformation( $array['matchedRoute'],
            $array['controllerClass'], $array['action'], $array['router'] );
    }
}
?>
