<?php
/**
 * File containing the class to store header information.
 *
 * @package Webdav
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * Struct-like class to store header information.
 * Used in {@link ezcWebdavRequest} and {@link ezcWebdavResponse}.
 * 
 * @package Webdav
 * @version //autogen//
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
class ezcWebdavHeaderStorage extends ArrayObject
{
    /**
     * Creates a new header storage.
     * 
     * @return void
     */
    public function __construct()
    {
        $headerContainer = array();
        parent::__construct( $headerContainer );
    }
}

?>
