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
        if ( $base !== null )
        {
            return self::handleRelativePath( $requestPath, $base );
        }
        else
        {
            return self::handleRequestUri( $requestPath );
        }
    }

    /**
     * Handle request URI and determine requested Webdav path using the server
     * variables containing the script file name and the document root.
     * 
     * @param string $requestPath 
     * @return string
     */
    protected static function handleRequestUri( $requestPath )
    {
        // Get Docroot and ensure proper definition
        if ( !isset( $_SERVER['DOCUMENT_ROOT'] ) )
        {
            throw new ezcWebdavMissingServerVariableException( 'DOCUMENT_ROOT' );
        }

        // Ensure trailing slash in doc root.
        $docRoot = $_SERVER['DOCUMENT_ROOT'];
        if ( $docRoot[strlen( $docRoot ) - 1] !== '/' )
        {
            $docRoot .= '/';
        }

        // Get script filename
        if ( !isset( $_SERVER['SCRIPT_FILENAME'] ) )
        {
            throw new ezcWebdavMissingServerVariableException( 'SCRIPT_FILENAME' );
        }

        $scriptFileName = $_SERVER['SCRIPT_FILENAME'];

        // Get script path absolute to doc root
        $serverFile = '/' . str_replace(
            $docRoot, '', $scriptFileName
        );

        // Check for proper request path
        if ( strpos( $requestPath, $serverFile ) !== 0 )
        {
            // Request URI should always start with server file, othwise there
            // is some rewriting in place, which cannot be handled using this
            // path factory
            throw new ezcWebdavBrokenRequestUriException( $requestPath );

        }

        // Get ressource.
        $ressource = substr( $requestPath, strlen( $serverFile ) );

        // Ressource may be empty for requests on webdav root
        if ( empty( $ressource ) )
        {
            $ressource = '/';
        }

        return $ressource;
    }
}

?>
