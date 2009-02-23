<?php
/**
 * File containing the ezcWebdavHeadersNotValidatedException class.
 *
 * @package Webdav
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * Exception thrown when a request header is requested, but the request headers
 * has not been validated.
 *
 * @package Webdav
 * @version //autogentag//
 */
class ezcWebdavHeadersNotValidatedException extends ezcWebdavException
{
    /**
     * Initializes the exception with the given $header and sets the exception
     * message from it.
     * 
     * @param string $header
     */
    public function __construct( $header )
    {
        parent::__construct( "Header '{$header}' requested, before request headers have been validated." );
    }
}

?>
