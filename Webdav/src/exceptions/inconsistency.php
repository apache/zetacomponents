<?php
/**
 * File containing the ezcWebdavInconsistencyException class.
 * 
 * @package Webdav
 * @version //autogen//
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * Exception thrown, whenever an operation failed that should not have failed.
 *
 * The Webdav component (and especially the lock plugin) depends on a fine
 * grained structure in the backend. The code contains many sanity checks to
 * ensure, that this structure is valid. In case an inconsistency is detected,
 * an exception of type {@link ezcWebdavInconsistencyException} ist thrown.
 *
 * If you receive such an exception, you should check (and maybe reset) your
 * backend data. If it happens more often, you might have discovered a bug in
 * the Webdav component.
 * 
 * @package Webdav
 * @version //autogen//
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
class ezcWebdavInconsistencyException extends ezcWebdavException
{
}

?>
