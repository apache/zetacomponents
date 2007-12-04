<?php
/**
 * File containing the ezcWebdavHeadersNotValidatedException class.
 *
 * @package Webdav
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
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
     * Constructor
     * 
     * @param string $header
     */
    public function __construct( $header )
    {
        parent::__construct( "Header '{$header}' requested, before request headers have been validated." );
    }
}

?>
