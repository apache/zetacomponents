<?php
/**
 * File containing the ezcWebdavInvalidHeaderException class.
 *
 * @package Webdav
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Exception thrown when a request object misses a header essential to the request.
 * {@link ezcWebdavRequest::validateHeaders()} will throw this exception, if a
 * header, which is essential to the specific request, is not present.
 * 
 * @package Webdav
 * @version //autogen//
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @author  
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
class ezcWebdavInvalidHeaderException extends ezcWebdavException
{
    /**
     * Creates a new exception.
     * 
     * @param string $headerName    Name of the affected header.
     * @param string $value         Contained value.
     * @param string $expectedValue Expected values.
     * @return void
     */
    public function __construct( $headerName, $value, $expectedValue = null )
    {
        $msg = "The value '{$value}' for the header '{$headerName}' is invalid.";
        if ( $expectedValue !== null )
        {
            $msg .= " Allowed values are: " . $expectedValue . '.';
        }
        parent::__construct( $msg );
    }
}



?>
