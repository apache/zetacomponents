<?php
/**
 * File containing the ezcWebdavNoAuth class.
 *
 * @package Webdav
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Default authentication class, providing NO authentication.
 *
 * This class is a dummy to fulfull the WebDAV authentication mechanism by
 * default. In instance of this class will offer no authentication at all, but
 * return always true on each method call. It is used by default in {@link
 * ezcWebdavServer} to ensure backwards compatibility with the Webdav component
 * version 1.0.
 *
 * If you want to have real authentication and authorization for your WebDAV
 * server, you need to implement the {@link ezcWebdavAuth} interface on your
 * own, providing an adapter to your favorit authentication / authorization
 * backend.
 *
 * @version //autogentag//
 * @package Webdav
 */
class ezcWebdavNoAuth implements ezcWebdavAuth
{
    /**
     * Checks authentication for the given $user.
     *
     * This method returns boolean true in every case, indicating that any
     * $user / $password combination (including empty ones) is valid.
     * 
     * @param string $user 
     * @param string $password 
     * @return bool
     */
    public function authenticate( $user, $password )
    {
        return true;
    }

    /**
     * Checks authorization of the given $user to a given $path.
     *
     * This method returns boolean true in every case, indicating that any
     * $user has any kind of $access to the given $path.
     * 
     * @param string $user 
     * @param string $path 
     * @param int $access 
     * @return bool
     */
    public function authorize( $user, $path, $access = self::ACCESS_READ )
    {
        return true;
    }
}

?>
