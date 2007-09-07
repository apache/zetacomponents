<?php
/**
 * File containing the supportedlock property lockentry class.
 *
 * @package Webdav
 * @version //autogenlastmodified//
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * Objects of this class are used in the ezcWebdavSupportedlockProperty class.
 *
 * @property int $locktype
 *           Constant indicating read or write lock.
 * @property int $lockscope
 *           Constant indicating exclusive or shared lock.
 *
 * @version //autogenlastmodified//
 * @package Webdav
 */
class ezcWebdavSupportedlockPropertyLockentry extends ezcWebdavProperty
{
    const TYPE_READ       = 1;
    const TYPE_WRITE      = 2;
                       
    const SCOPE_EXCLUSIVE = 1;
    const SCOPE_SHARED    = 2;

    // To be implemented.
}


?>
