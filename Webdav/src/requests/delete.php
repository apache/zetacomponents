<?php
/**
 * File containing the ezcWebdavDeleteRequest class.
 *
 * @package Webdav
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * Abstract representation of a DELETE request.
 *
 * An instance of this class represents the WebDAV DELETE request.
 *
 * @version //autogentag//
 * @package Webdav
 */
class ezcWebdavDeleteRequest extends ezcWebdavRequest
{
    /**
     * Creates a new request object.
     *
     * Creates a new request object that refers to the given $requestUri, which
     * is a path understandable by the {@link ezcWebdavBackend}.
     * 
     * @param string $requestUri 
     * @return void
     */
    public function __construct( $requestUri )
    {
        parent::__construct( $requestUri );
        $this->pathsToAuthorize[$requestUri] = ezcWebdavAuth::ACCESS_WRITE;
    }
}

?>
