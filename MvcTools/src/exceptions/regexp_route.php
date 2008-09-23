<?php
/**
 * File containing the ezcMvcToolsBuildQueryException class.
 *
 * @package MvcTools
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * This exception is thrown when the prefix() method can't prefix the route's
 * pattern.
 *
 * @package MvcTools
 * @version //autogentag//
 */
class ezcMvcRegexpRouteException extends ezcMvcToolsException
{
    /**
     * Constructs an ezcMvcRegexpRouteException
     *
     * @param string $message
     */
    public function __construct( $message )
    {
        parent::__construct( $message );
    }
}
?>
