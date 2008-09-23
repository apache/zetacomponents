<?php
/**
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package MvcTools
 */

/**
 * The interface that should be implemented by all request parsers.
 *
 * A request parser takes the raw request - protocol dependent - and creates an
 * abstract ezcMvcRequest object of this.
 *
 * @package MvcTools
 * @version //autogentag//
 */
abstract class ezcMvcRequestParser
{
    /**
     * Contains the request struct
     *
     * @var ezcMvcRequest
     */
    protected $request;

    /**
     * Reads the raw request data with what ever means necessary and
     * constructs an ezcMvcRequest object.
     *
     * @return ezcMvcRequest
     */
    abstract public function createRequest();
}
?>
