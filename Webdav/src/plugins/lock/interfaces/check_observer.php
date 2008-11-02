<?php

/**
 * Interface that needs to be implemented by observers to lock checks.
 *
 * @package Webdav
 * @version //autogen//
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
interface ezcWebdavLockCheckObserver
{
    /**
     * Notify about a response.
     *
     * Notifies the observer that a the given $response was checked.
     * 
     * @param ezcWebdavPropFindResponse $propFind 
     * @return void
     */
    public function notify( ezcWebdavPropFindResponse $response );
}

?>
