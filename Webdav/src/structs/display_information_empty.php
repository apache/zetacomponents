<?php
/**
 * File containing the ezcWebdavDisplayInformation struct.
 *
 * @package Webdav
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * Display information.
 *
 * Used by {@link ezcWebdavTransport} to transport information on displaying a
 * response to the browser.
 *
 * @version //autogentag//
 * @package Webdav
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
class ezcWebdavEmptyDisplayInformation extends ezcWebdavDisplayInformation
{
    
    /**
     * Creates a new struct.
     * 
     * @param ezcWebdavResponse $response 
     * @return void
     */
    public function __construct( ezcWebdavResponse $response )
    {
        $this->response = $response;
    }

    /**
     * Response object to extract headers from.
     * 
     * @var ezcWebdavResponse
     */
    public $response;
}

?>
