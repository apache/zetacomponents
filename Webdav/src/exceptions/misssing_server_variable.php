<?php
/**
 * File containing the ezcWebdavMissingServerVariableException class
 *
 * @package Webdav
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * Exception thrown, when a required server environment variable has not been
 * set by the webserver.
 *
 * @package Webdav
 * @version //autogentag//
 */
class ezcWebdavMissingServerVariableException extends ezcWebdavException
{
    /**
     * Initializes the exception with the given $name (the key of the $_SERVER
     * array) and sets the exception message from it.
     * 
     * @param string $name
     */
    public function __construct( $name )
    {
        parent::__construct( "Required server variable '{$name}' is not available. Please check your web server configuration." );
    }
}

?>
