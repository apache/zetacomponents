<?php

/**
 * Interface that needs to be implemented by request generators for the lock plugin.
 *
 * @package Webdav
 * @version //autogen//
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
interface ezcWebdavLockRequestGenerator
{
    /**
     * Notify the generator about a response.
     *
     * Notifies the request generator that a request should be generated w.r.t.
     * the given $response.
     * 
     * @param ezcWebdavPropFindResponse $propFind 
     * @return void
     */
    public function notify( ezcWebdavPropFindResponse $response );

    /**
     * Returns all collected requests generated in the processor. 
     * 
     * @return array(ezcWebdavRequest)
     */
    public function getRequests();
}

?>
