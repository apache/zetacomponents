<?php
/**
 * File containing the ezcMvcToolsNoRoutesException class.
 *
 * @package MvcTools
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * This exception is thrown when the createRoutes() method does not return any routes.
 *
 * @package MvcTools
 * @version //autogentag//
 */
class ezcMvcNoRoutesException extends ezcMvcToolsException
{
    /**
     * Constructs an ezcMvcNoRoutesException
     */
    public function __construct()
    {
        parent::__construct( "No routes are defined in the router." );
    }
}
?>
