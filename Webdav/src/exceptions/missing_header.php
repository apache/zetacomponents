<?php
/**
 * File containing the ezcWebdavMissingHeaderException class.
 *
 * @package Webdav
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Exception thrown when a request/response object misses an essential header essential.
 *
 * {@link ezcWebdavRequest::validateHeaders()} will throw this exception, if a
 * header, which is essential to the specific request, is not present. {@link
 * ezcWebdavTransport::sendResponse()} will throw this exception, if a non-XML
 * body should be sent and the header is not set.
 * 
 * @package Webdav
 * @version //autogen//
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @author  
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
class ezcWebdavMissingHeaderException extends ezcWebdavException
{
    /**
     * Creates a new exception.
     * 
     * @param string $headerName Name of the missing header.
     * @return void
     */
    public function __construct( $headerName )
    {
        parent::__construct( "The header '$headerName' is required by the request sent or the response to send but was not set." );
    }
}

?>
