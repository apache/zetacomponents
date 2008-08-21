<?php
/**
 * File containing the ezcWebdavAuthorizer interface.
 *
 * @package Webdav
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Interface for classes providing authorization.
 *
 * This interface must be implemented by classes the provide authorization to
 * an {@link ezcWebdavBackend}. A back end will call the {@link authorize()}
 * method for each path that is affected by request.
 *
 * @version //autogentag//
 * @package Webdav
 */
interface ezcWebdavAuthorizer
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
     * Checks authorization of the given $user to a given $path.
     *
     * This method checks if the given $user has the permission $access to the
     * resource identified by $path. The $path is the result of a translation
     * by the servers {@link ezcWebdavPathFactory} from the request URI.
     *
     * The $access parameter can be one of
     * <ul>
     *    <li>{@link ezcWebdavAuthorizer::ACCESS_WRITE}</li>
     *    <li>{@link ezcWebdavAuthorizer::ACCESS_READ}</li>
     * </ul>
     *
     * The implementation of this method must only check the given $path, but
     * MUST not check deeper pathes, since the back end will issue dedicated
     * calls for such paths.
     * 
     * @param string $user 
     * @param string $path 
     * @param int $access 
     * @return bool
     */
    public function authorize( $user, $path, $access = self::ACCESS_READ );
}

?>
