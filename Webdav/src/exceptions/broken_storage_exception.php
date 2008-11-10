<?php
/**
 * File containing the ezcWebdavFileBackendBrokenStorageException class.
 *
 * @package Webdav
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * Exception thrown if a stored property storage could not be parsed.
 *
 * In rare cases it may happen, that the properties stored by {@link
 * ezcWebdavFileBackend} get broken (HD failure, bug,...). If the file backend
 * cannot parse the storage anymore, this exception is thrown.
 * 
 * @package Webdav
 * @version //autogen//
 */
class ezcWebdavFileBackendBrokenStorageException extends ezcWebdavException
{
}

?>
