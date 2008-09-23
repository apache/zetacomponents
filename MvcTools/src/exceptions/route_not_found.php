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
 * This exception is thrown when no route matches the request.
 *
 * @package MvcTools
 * @version //autogentag//
 */
class ezcMvcRouteNotFoundException extends ezcMvcToolsException
{
    /**
     * Constructs an ezcMvcRouteNotFoundException
     *
     * @param ezcMvcRequest $request
     */
    public function __construct( ezcMvcRequest $request )
    {
        $id = $request->requestId != '' ? $request->requestId : $request->uri;
        $message = "No route was found that matched request ID '{$id}'.";
        parent::__construct( $message );
    }
}
?>
