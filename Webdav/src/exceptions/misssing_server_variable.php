<?php
/**
 * File containing the ezcWebdavMissingServerVariableException class
 *
 * @package Webdav
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
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
     * Constructor
     * 
     * @param string $name
     */
    public function __construct( $name )
    {
        parent::__construct( "Required server variable '{$name}' is not available. Please check your web server configuration." );
    }
}

?>
