<?php
/**
 * File containing the ezcWebdavLockTimeoutException class.
 * 
 * @package Webdav
 * @version //autogen//
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Exception thrown if the acquiring of a backend lock times out.
 * 
 * @package Webdav
 * @version //autogen//
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
class ezcWebdavLockTimeoutException extends ezcWebdavException
{
    /**
     * Creates a new lock timeout exception.
     * 
     * @return void
     */
    public function __construct()
    {
        parent::__construct( 'Backend locking timed out.' );
    }
}

?>
