<?php
/**
 * File containing the ezcWebdavLockOptionsRequestResponseHandler class.
 *
 * @package Webdav
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 *
 * @access private
 */
/**
 * Handler class for the OPTIONS request.
 * 
 * @package Webdav
 * @version //autogen//
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 *
 * @access private
 */
class ezcWebdavLockOptionsRequestResponseHandler extends ezcWebdavLockRequestResponseHandler
{
    /**
     * If this handler requires the backend to get locked. 
     * 
     * @var bool
     */
    public $needsBackendLock = false;

    /**
     * Handles OPTIONS requests.
     *
     * @param ezcWebdavUnlockRequest $request 
     * @return ezcWebdavResponse
     */
    public function receivedRequest( ezcWebdavRequest $request )
    {
        return null;
    }

    /**
     * Handles responses to the OPTIONS request.
     * 
     * @param ezcWebdavResponse $response 
     * @return ezcWebdavResponse|null
     */
    public function generatedResponse( ezcWebdavResponse $response )
    {
        if ( $response instanceof ezcWebdavOptionsResponse )
        {
            $response->setHeader(
                'DAV',
                ezcWebdavOptionsResponse::VERSION_ONE . ',' . ezcWebdavOptionsResponse::VERSION_TWO 
            );
            $allowHeader = $response->getHeader( 'Allow' );
            $allowHeader .= ', LOCK, UNLOCK';
            $response->setHeader( 'Allow', $allowHeader );
        }
    }
}

?>
