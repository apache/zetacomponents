<?php
/**
 * File containing the ezcWebdavAnonymousAuth struct.
 *
 * @package Webdav
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * Struct representing an anonymous user.
 *
 * This struct is used to indicate a missing or non-parsable Authorization
 * header. The user must be handled as if he was not authenticated. The
 * $username is empty.
 * 
 * @package Webdav
 * @version //autogen//
 */
class ezcWebdavAnonymousAuth extends ezcWebdavAuth
{
    /**
     * Creates a new basic auth credential struct.
     * 
     * It is not possible to define a $username, since the anonymous user
     * always has the $username ''.
     */
    public function __construct()
    {
        parent::__construct( '' );
    }
}

?>
