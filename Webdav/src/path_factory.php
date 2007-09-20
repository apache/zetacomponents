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
 * Basic path factory.
 *
 * An object of this class is meant to be used in {@link
 * ezcWebdavTransportOptions} as the $pathFactory property. The instance of
 * {@link ezcWebdavTransport} utilizes the path factory to translate between
 * external pathes/URIs and internal path representations.
 *
 * This simple implementation of a path factory expects the base URI it should
 * be working on as the ctor parameter. It will translate all incoming URIs to
 * internal pathes and the other way round based on this basis URI.
 *
 * You may want to provide custome implementations for different mappings.
 *
 * @version //autogentag//
 * @package Webdav
 */
class ezcWebdavPathFactory
{
    /**
     * Result of parse_url() for the {@link $baseUri} submitted to the ctor.
     * 
     * @var array(string=>string)
     */
    protected $baseUriParts;
    
    /**
     * Creates a new path factory.
     * Creates a new object to parse URIs to local pathes. The URL given as a
     * parameter is used to strip URL/path parts from incoming URIs and add the
     * specific parts to outgoin ones.
     * 
     * @param string $baseUri 
     * @return void
     */
    public function __construct( $baseUri = '' )
    {
        $this->baseUriParts = parse_url( $baseUri );
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
        if ( substr( $requestPath, -1, 1 ) === '/' )
        {
            $requestPath = substr( $requestPath, 0, -1 );
        }
        return substr( $requestPath, isset( $this->baseUriParts['path'] ) ? strlen( $this->baseUriParts['path'] ) : 0 );
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
        return $this->baseUriParts['scheme'] 
             . '://' . $this->baseUriParts['host'] 
             . ( isset( $this->baseUriParts['user'] ) ? $this->baseUriParts['user'] : '' )
             . ( isset( $this->baseUriParts['pass'] ) ? ':' . $this->baseUriParts['pass'] : '' )
             . ( isset( $this->baseUriParts['user'] ) || isset( $this->baseUriParts['pass'] ) ? '@' : '' )
             . $this->baseUriParts['host']
             . $this->baseUriParts['path']
             . $path
             . ( isset( $this->baseUriParts['query'] ) ? '?' . $this->baseUriParts['query'] : '' )
             . ( isset( $this->baseUriParts['fragment'] ) ? '#' . $this->baseUriParts['fragment'] : '' );
    }
}

?>
