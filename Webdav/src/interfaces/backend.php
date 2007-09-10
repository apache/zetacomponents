<?php
/**
 * File containing the basic webdav backend class
 *
 * @package Webdav
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * Base interface for all webdav backends serving the actual data.
 *
 * The backend is meant to be exxtended by an implementation for your data
 * storage. It enforces the base features required for each backend and should
 * be extended by further indeterfaces for other access methods, like:
 *
 *  - {@link ezcWebdavBackendPut}
 *  - {@link ezcWebdavBackendChange}
 *  - {@link ezcWebdavBackendMakeCollection}
 *  - {@link ezcWebdavBackendLock}
 *
 * @version //autogentag//
 * @package Webdav
 */
abstract class ezcWebdavBackend
{
    /**
     * Backend has native support for gzip compression.
     */
    const COMPRESSION_GZIP      = 1;

    /**
     * Backend has native support for bzip2 compression.
     */
    const COMPRESSION_BZIP2     = 2;

    /**
     * Backend performs locking itself - no handling by server is required.
     */
    const CUSTOM_LOCK           = 4;

    /**
     * Backend has native support for partial requests.
     */
    const PARTIAL               = 8;

    /**
     * Backend has native support for multipart requests.
     */
    const MULTIPART             = 16;

    /**
     * Return bitmap of additional features supported by the backend referenced
     * by constants from the basic ezcWebdavBackend class.
     * 
     * @return int
     */
    public function getFeatures()
    {
        return 0;
    }

    /**
     * Required method to serve GET requests.
     *
     * The method receives a {@link ezcWebdavGetRequest} object containing all
     * relevant information obout the clients request and should either return
     * an error by returning an {@link ezcWebdavErrorResponse} object, or any
     * other {@link ezcWebdavResponse} objects.
     * 
     * @param ezcWebdavGetRequest $request The received request.
     * @return ezcWebdavResponse A response to the received request.
     */
    abstract public function get( ezcWebdavGetRequest $request );

    /**
     * Required method to serve HEAD requests.
     *
     * The method receives a {@link ezcWebdavHeadRequest} object containing all
     * relevant information obout the clients request and should either return
     * an error by returning an {@link ezcWebdavErrorResponse} object, or any other
     * {@link ezcWebdavResponse} objects.
     * 
     * @param ezcWebdavGetRequest $request The received request.
     * @return ezcWebdavResponse A response to the received request.
     */
    abstract public function head( ezcWebdavHeadRequest $request );

    /**
     * Required method to serve PROPFIND requests.
     * 
     * The method receives a {@link ezcWebdavPropFindRequest} object containing all
     * relevant information obout the clients request and should either return
     * an error by returning an {@link ezcWebdavErrorResponse} object, or any
     * other {@link ezcWebdavResponse} objects.
     *
     * The {@link ezcWebdavPropFindRequest} object contains a definition to
     * find one or more properties of a given file or collection.
     *
     * @param ezcWebdavPropFindRequest $request The received request.
     * @return ezcWebdavResponse A response to the received request.
     */
    abstract public function propFind( ezcWebdavPropFindRequest $request );

    /**
     * Required method to serve PROPPATCH requests.
     * 
     * The method receives a {@link ezcWebdavPropPatchRequest} object containing all
     * relevant information obout the clients request and should either return
     * an error by returning an {@link ezcWebdavErrorResponse} object, or any
     * other {@link ezcWebdavResponse} objects.
     *
     * @param ezcWebdavPropPatchRequest $request The received request.
     * @return ezcWebdavResponse A response to the received request.
     */
    abstract public function propPatch( ezcWebdavPropPatchRequest $request );
}

?>
