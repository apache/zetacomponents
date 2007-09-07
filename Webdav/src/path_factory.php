<?php
/**
 * File containing the basic webdav path factory class
 *
 * @package Webdav
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * This class is meant to calculate the path of the requested item from the
 * backend based on the given path by the webdav client. The resulting path
 * string is absolute to the root of the backend repository.
 *
 * This class is necessary to calculate the correct path when a server uses
 * rewrite rules for mapping directories to one or more webdav implementations.
 * The basic class uses pathinfo to parse the requested file / collection.
 *
 * Request: /path/to/webdav.php/path/to/file
 * Result:  /path/to/file
 *
 * You may want to provide custome implementations for different mappings.
 *
 * @properties ezcWebdavBackend $backend
 *             Data backend used to serve the request.
 *
 * @version //autogentag//
 * @package Webdav
 */
class ezcWebdavPathFactory
{
    /**
     * Parses a given path into a path object representing a file or collection
     * in the backend.
     *
     * This method is not only called for the initial requested path, but also
     * for every ressource in the request body.
     *
     * The optional parameter base is required to calculate a proper absolute
     * path when a relative path was given. The base path should always already
     * be a valid absolute repository path.
     *
     * @param string $requestPath
     * @return string
     */
    public static function parsePath( $requestPath, $base = null )
    {
        // @TODO: Implement
    }
}

?>
