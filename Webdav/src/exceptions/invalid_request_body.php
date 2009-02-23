<?php
/**
 * File containing the ezcWebdavInvalidRequestBodyException class.
 * 
 * @package Webdav
 * @version //autogen//
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * Thrown if the request body received was invalid.
 * 
 * @package Webdav
 * @version //autogen//
 */
class ezcWebdavInvalidRequestBodyException extends ezcWebdavBadRequestException
{
    /**
     * Initializes the exception with the given $method and $reason and sets
     * the exception message from it.
     * 
     * @param mixed $method 
     * @param mixed $reason 
     * @return void
     */
    public function __construct( $method, $reason = null )
    {
        parent::__construct(
            "The HTTP request body received for HTTP method '$method' was invalid." . ( $reason !== null ? " Reason: $reason" : '' )
        );
    }
}

?>
