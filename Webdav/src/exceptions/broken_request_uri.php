<?php
/**
 * File containing the ezcWebdavBrokenRequestUriException class
 *
 * @package Webdav
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * Exception thrown, when a request URI could not be handled by the default
 * path factory class. This may happen when the server either provides broken
 * environment variables, or the URL has been rewritten somehow. In this case
 * you need to implement your own request factory and tell the server class to
 * use it.
 *
 * <code>
 *  $server->options->pathFactory = 'myPathFactory';
 * </code>
 *
 * @package Webdav
 * @version //autogentag//
 */
class ezcWebdavBrokenRequestUriException extends ezcWebdavException
{
    /**
     * Initializes the exception with the given $uri and sets the exception
     * message from it.
     * 
     * @param string $uri
     */
    public function __construct( $uri )
    {
        parent::__construct( "URI '{$uri}' could not be handled by path factory." );
    }
}

?>
