<?php
/**
 * File containing the ezcWebdavInvalidRequestBodyException class.
 * 
 * @package Webdav
 * @version //autogen//
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Thrown if the request body received was invalid.
 * 
 * @package Webdav
 * @version //autogen//
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
class ezcWebdavInvalidRequestBodyException extends ezcWebdavBadRequestException
{
    public function __construct( $method, $reason = null )
    {
        parent::__construct(
            "The HTTP request body received for HTTP metho '$method' was invalid." . ( $reason !== null ? " Reason: $reason" : '' )
        );
    }
}

?>
