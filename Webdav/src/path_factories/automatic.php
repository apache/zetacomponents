<?php
/**
 * File containing the ezcWebdavAutomaticPathFactory class.
 *
 * @package Webdav
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * Path factory that automatically detects local settings.
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
 * @version //autogentag//
 * @package Webdav
 */
class ezcWebdavAutomaticPathFactory implements ezcWebdavPathFactory
{
    /**
     * Base path on the server.
     *
     * Auto-detected during __construct().
     * 
     * @var string
     */
    protected $serverFile;

    /**
     * Creates a new path factory.
     * 
     * Creates a new path factory to be used in ezcWebdavTransportOptions. This
     * path factory automatically detects information from the running
     * webserver and tries to automatically determine the suitable values.
     *
     * A locally understandable path MUST NOT contain a trailing slash, but
     * MUST always contain a starting slash. For the root URI the path "/" MUST
     * be used.
     *
     * @return void
     */
    public function __construct()
    {
        // Get Docroot and ensure proper definition
        if ( !isset( $_SERVER['DOCUMENT_ROOT'] ) )
        {
            throw new ezcWebdavMissingServerVariableException( 'DOCUMENT_ROOT' );
        }

        // Ensure trailing slash in doc root.
        $docRoot = $_SERVER['DOCUMENT_ROOT'];
        if ( substr( $docRoot, -1, 1 ) !== '/' )
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
        $this->serverFile = '/' . str_replace(
            $docRoot, '', $scriptFileName
        );
    }

    /**
     * Parses the given URI to a locally understandable path.
     *
     * This method retrieves a URI (either full qualified or relative) and
     * translates it into a local path, which can be understood by the WebDAV
     * elements.
     *
     * @param string $uri
     * @return string
     */
    public function parseUriToPath( $uri )
    {
        $requestPath = parse_url( $uri, PHP_URL_PATH );

        // Check for proper request path
        if ( strpos( $requestPath, $this->serverFile ) !== 0 )
        {
            // Request URI should always start with server file, othwise there
            // is some rewriting in place, which cannot be handled using this
            // path factory
            throw new ezcWebdavBrokenRequestUriException( $requestPath );
        }

        // Get ressource.
        $path = substr( $requestPath, strlen( $this->serverFile ) );
        return ( is_string( $path ) ? $path : '' );
    }

    /**
     * Generates a URI from a local path.
     *
     * This method receives a local $path string, representing a node in the
     * local WebDAV store and translates it into a full qualified URI to be
     * used as external reference.
     * 
     * @param string $path 
     * @return string
     */
    public function generateUriFromPath( $path )
    {
        return 'http://' . $_SERVER['SERVER_NAME'] 
             . ( $_SERVER['SERVER_PORT'] == 80 ? '' : ':' . $_SERVER['SERVER_PORT'] )
             . $this->serverFile
             . $path;
    }
}

?>
