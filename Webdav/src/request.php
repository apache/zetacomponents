<?php
/**
 * File containing the class representing a request to the webdav server.
 *
 * @package Webdav
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * Struct containing all relevant information about a webdav request, so that it;
 * can be handler properly by the server and the webdav backend. Will be
 * extended by specialized request classes which represent the several webdav
 * request types.
 *
 * @version //autogentag//
 * @package Webdav
 */
class ezcWebdavRequest
{
    /**
     * Constants for request types.
     */
    const GET       = 1;
    const HEAD      = 2;
    const PUT       = 4;
    const PROPFIND  = 8;
    const PROPPATCH = 16;
    const DELETE    = 32;
    const COPY      = 64;
    const MOVE      = 128;
    const MKCOL     = 256;

    /**
     * Optional property containing the name of the requesting client
     * 
     * @var string
     */
    public $clientName = false;

    /**
     * Optional property containing the remote IP address of the client
     * 
     * @var string
     */
    public $remoteAddress = false;

    // ...
}

?>
