<?php
/**
 * File containing the ezcWebdavPathFactory interface.
 *
 * @package Webdav
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * Basic path factory interface.
 *
 * An object that implements this interface is meant to be used in {@link
 * ezcWebdavTransportOptions} as the $pathFactory property. The instance of
 * {@link ezcWebdavTransport} utilizes the path factory to translate between
 * external pathes/URIs and internal path representations.
 *
 * You may want to provide custome implementations for different mappings.
 *
 * @see ezcWebdavBasicPathFactory
 * @see ezcWebdavAutomaticPathFactory
 *
 * @version //autogentag//
 * @package Webdav
 */
interface ezcWebdavPathFactory
{
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
    public function parseUriToPath( $uri );

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
    public function generateUriFromPath( $path );
}

?>
