<?php
/**
 * File containing the class representing a PUT response from the webdav
 * server.
 *
 * @package Webdav
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * Class representing a response on a PUT request.
 *
 * @version //autogentag//
 * @package Webdav
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
class ezcWebdavPutResponse extends ezcWebdavResponse
{
    /**
     * Construct put response.
     * 
     * @return void
     */
    public function __construct()
    {
        parent::__construct( ezcWebdavResponse::STATUS_201 );
    }
}

?>
