<?php
/**
 * File containing the ezcMvcRouter class
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
 * The abstract router that you need to inherit from to supply your routes.
 *
 * @package MvcTools
 * @version //autogentag//
 * @mainclass
 */
abstract class ezcMvcRouter
{
    /**
     * Contains all the user defined routes.
     *
     * @var array(ezcMvcRoute)
     */
    protected $routes = array();

    /**
     * Contains the request object
     *
     * @var ezcMvcRequest
     */
    protected $request;

    /**
     * Creates a new router object
     *
     * @param ezcMvcRequest $request
     */
    public function __construct( ezcMvcRequest $request )
    {
        $this->request = $request;
    }

    /**
     * User implemented method that should provide all the routes.
     *
     * It should return an array of objects that implement the ezcMvcRoute
     * interface. This could be objects of the ezcMvcRegexpRoute class for
     * example.
     *
     * @return array(ezcMvcRoute)
     */
    abstract public function createRoutes();

    /**
     * Returns routing information, including a controller classname from the set of routes.
     *
     * This method is run by the dispatcher to obtain a controller. It uses the
     * user implemented createRoutes() method from the inherited class to fetch the
     * routes. It then loops over these routes in order - the first one that
     * matches the request returns the routing information. The loop stops as
     * soon as a route has matched. In case none of the routes matched
     * with the request data an exception is thrown.
     *
     * @throws ezcMvcNoRoutesException when there are no routes defined.
     * @throws ezcBaseValueException when one of the returned routes was not
     *         actually an object implementing the ezcMvcRoute interface.
     * @throws ezcMvcRouteNotFoundException when no routes matched the request URI.
     * @return ezcMvcRoutingInformation
     */
    public function getRoutingInformation()
    {
        $routes = $this->createRoutes();

        if ( ezcBase::inDevMode() && ( !is_array( $routes ) || !count( $routes ) ) )
        {
            throw new ezcMvcNoRoutesException();
        }

        foreach ( $routes as $route )
        {
            if ( ezcBase::inDevMode() && !$route instanceof ezcMvcRoute )
            {
                throw new ezcBaseValueException( 'route', $route, 'instance of ezcMvcRoute' );
            }

            $routingInformation = $route->matches( $this->request );
            if ( $routingInformation !== null )
            {
                // Add the router to the routing information struct, so that
                // can be passed to the controllers for reversed route
                // generation.
                $routingInformation->router = $this;

                return $routingInformation;
            }
        }

        throw new ezcMvcRouteNotFoundException( $this->request );
    }

    /**
     * Loops over all the given routes and adds the prefix $prefix to them
     *
     * The methods loops over all the routes in the $routes variables and calls
     * the prefix() method on the route with the $prefix. The $prefix should be
     * a prefix that the route understands.
     *
     * @throws ezcMvcRegexpRouteException if the prefix can not be prepended to
     *         one or more of the patterns in the routes.
     * @param mixed              $prefix
     * @param array(ezcMvcRoute) $routes
     */
    static public function prefix( $prefix, $routes )
    {
        foreach ( $routes as $route )
        {
            $route->prefix( $prefix );
        }
        return $routes;
    }

    /**
     * Generates an URL back out of a route, including possible arguments
     *
     * @param mixed $routeName
     * @param array $arguments
     */
    public function generateUrl( $routeName, array $arguments = null )
    {
        $routes = $this->createRoutes();
        if ( !isset( $routes[$routeName] ) )
        {
            throw new ezcMvcNamedRouteNotFoundException( $routeName );
        }
        if ( $routes[$routeName] instanceof ezcMvcReversibleRoute )
        {
            return $routes[$routeName]->generateUrl( $arguments );
        }
        else
        {
            throw new ezcMvcNamedRouteNotReversableException( $routeName, get_class( $routes[$routeName] ) );
        }
    }
}
?>
