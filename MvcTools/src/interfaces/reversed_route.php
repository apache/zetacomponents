<?php
/**
 * This file contains the ezcMvcReversibleRoute interface.
 *
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package MvcTools
 */

/**
 * The interface that should be implemented by the different route types
 * that allow Url generation from the route definition.
 *
 * @package MvcTools
 * @version //autogentag//
 */
interface ezcMvcReversibleRoute
{
    /**
     * Generates an URL back out of a route, including possible arguments
     *
     * @param array $arguments
     */
    public function generateUrl( array $arguments = null );
}
?>
