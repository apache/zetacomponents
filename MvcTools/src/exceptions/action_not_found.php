<?php
/**
 * File containing the ezcMvcActionNotFoundException class
 *
 * @package MvcTools
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * This exception is thrown when no action method exists for a route.
 *
 * @package MvcTools
 * @version //autogentag//
 */
class ezcMvcActionNotFoundException extends ezcMvcToolsException
{
    /**
     * Constructs an ezcMvcActionNotFoundException
     *
     * @param string $action
     */
    public function __construct( $action )
    {
        $message = "The action '{$action}' does not exist.";
        parent::__construct( $message );
    }
}
?>
