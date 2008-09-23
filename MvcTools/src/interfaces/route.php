<?php
/**
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
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
     * @param ezcMvcRequest $request Request to test.
     * @return null|ezcMvcRoutingInformation
     */
    public function matches( ezcMvcRequest $request );

    /**
     * Adds a prefix to the route.
     * 
     * @param mixed $prefix Prefix to add, for example: '/blog'
     * @return void
     */
    public function prefix( $prefix );
}
?>
