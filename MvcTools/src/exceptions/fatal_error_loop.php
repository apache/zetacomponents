<?php
/**
 * File containing the ezcMvcFatalErrorLoopException class.
 *
 * @package MvcTools
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * This exception is thrown when a fatal error request generates another fatal
 * error request.
 *
 * @package MvcTools
 * @version //autogentag//
 */
class ezcMvcFatalErrorLoopException extends ezcMvcToolsException
{
    /**
     * Constructs an ezcMvcFatalErrorLoopException
     *
     * @param ezcMvcRequest $request
     */
    public function __construct( ezcMvcRequest $request )
    {
        $id = "\"{$request->host}\", \"{$request->uri}\" ({$request->requestId})";
        parent::__construct( "The request {$id} results in an infinite fatal error loop." );
    }
}
?>
