<?php
/**
 * File containing the abstract ezcWebdavLockIfHeaderList class.
 *
 * @package Webdav
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 *
 * @access private
 */
/**
 * Abstract base class for list classes that represent the HTTP If header.
 * 
 * @package Webdav
 * @version //autogen//
 *
 * @access private
 */
abstract class ezcWebdavLockIfHeaderList implements ArrayAccess
{
    /**
     * Returns all lock tokens submitted in the header.
     * 
     * @return array(string)
     */
    abstract public function getLockTokens();
}

?>
