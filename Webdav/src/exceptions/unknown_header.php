<?php
/**
 * File containing the ezcWebdavUnknownHeaderException class.
 *
 * @package Webdav
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Exception thrown if a header to parse is unknown.
 * There seems to be no way to determine headers by their original name in PHP,
 * but only through the keys HTTP_* in $_SERVER. Therefore, the header must be
 * known by {@ezcWebdavTransport->parseHeaders()} to get assigned properly.
 * 
 * @package Webdav
 * @version //autogen//
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
class ezcWebdavUnknownHeaderException extends ezcWebdavException
{
    /**
     * Creates a new exception.
     * 
     * @param string $headerName    Name of the affected header.
     * @param string $value         Contained value.
     * @param string $expectedValue Expected values.
     * @return void
     */
    public function __construct( $headerName )
    {
        parent::__construct( "The header '$headerName' has no equivalent in the header map." );
    }
}



?>
