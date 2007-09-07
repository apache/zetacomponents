<?php
/**
 * File containing a webdav backend to serve a directory tree with the webdav
 * server.
 *
 * @package Webdav
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * Backend serving a directory tree as a webdav backend.
 *
 * @property bool $followSymLinks
 *           Optionally the backend will follow symbolic links to directories
 *           outsite of the give base path.
 *           
 *
 * @version //autogentag//
 * @package Webdav
 */
class ezcWebdavFileBackend
    extends
        ezcWebdavBackend
    implements
        ezcWebdavBackendPut,
        ezcWebdavBackendChange,
        ezcWebdavBackendMakeCollection
{
    /**
     * Array with properties of the file backend.
     * 
     * @var array
     */
    protected $properties;

    /**
     * Construct backend from a given path.
     * 
     * @param string $path 
     * @return void
     */
    public function __construct( $path )
    {
        $this->properties['followSymLinks']     = false;

        // @TODO: Implement
    }

    // @TODO: Implement methods required by interfaces...
}

?>
