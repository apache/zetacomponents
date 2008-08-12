<?php
/**
 * File containing the ezcWebdavAuth interface.
 *
 * @package Webdav
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Interface for authentication/authorization mechanisms.
 *
 * This interface must be implemented by classes that provide authentication
 * and authorization for the WebDAV server. The method {@link authenticate()}
 * will be called by {@link ezcWebdavServer} on each request and submit the
 * user name and password provided through HTTP-Auth. For each path that is to
 * be accessed by the request, the {@link authorize()} method will be called,
 * including the user name. If multiple pathes in a common subtree are
 * affected, only the highest level common path will be requested for
 * authorization (e.g. requests that affect a subtree recursively).
 *
 * 2 class constants are used to determine the type of access that the request
 * requires. {@link ezcWebdavAuth::ACCESS_READ} indicates that the request will
 * only read data, while {@link ezcWebdavAuth::ACCESS_WRITE} indicates that
 * reading and writing will happen.
 *
 * In combination with the lock plugin, the extended version of this interface
 * {@link ezcWebdavLockAuth} must be used instead of this basic interface.
 *
 * An instance of a class implementing the auth interface can be used in {@link
 * ezcWebdavServer->auth} to provide authentication for the WebDAV server.
 *
 * @version //autogentag//
 * @package Webdav
 */
interface ezcWebdavAuth
{
    /**
     * User desires read access. 
     */
    const ACCESS_READ = 1;

    /**
     * User desires write access. 
     */
    const ACCESS_WRITE = 2;

    /**
     * Checks authentication for the given $user.
     *
     * This method checks the given $user / $password credentials. Returns true
     * if the $user was succesfully recognized and the $password is valid for
     * him, false otherwise.
     * 
     * @param string $user 
     * @param string $password 
     * @return bool
     */
    public function authenticate( $user, $password );

    /**
     * Checks authorization of the given $user to a given $path.
     *
     * This method checks if the given $user has the permission $access to the
     * resource identified by $path. The $path is the result of a translation
     * by the servers {@link ezcWebdavPathFactory} from the request URI.
     *
     * The $access parameter can be one of
     * <ul>
     *    <li>{@link ezcWebdavAuth::ACCESS_WRITE}</li>
     *    <li>{@link ezcWebdavAuth::ACCESS_READ}</li>
     * </ul>
     * 
     * @param string $user 
     * @param string $path 
     * @param int $access 
     * @return bool
     */
    public function authorize( $user, $path, $access = self::ACCESS_READ );
}

?>
