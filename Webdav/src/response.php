<?php
/**
 * File containing the class representing a response from the webdav server.
 *
 * @package Webdav
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * Struct containing all relevant information about a webdav response, so that
 * it can be handled properly by transport mechanism. Will be extended by more
 * specific responses.
 *
 * @version //autogentag//
 * @package Webdav
 */
class ezcWebdavResponse
{
    /**
     * Optional property containing the name of the requesting client
     * 
     * @var string
     */
    public $serverName = 'ezcWebdavServer';
    // ...
}

?>
