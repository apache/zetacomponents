<?php
/**
 * File containing the ezcWebdavLockGetRequestResponseHandler class.
 *
 * @package Webdav
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 *
 * @access private
 */
/**
 * Handler class for the GET request.
 * 
 * @package Webdav
 * @version //autogen//
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 *
 * @access private
 */
class ezcWebdavLockGetRequestResponseHandler extends ezcWebdavLockRequestResponseHandler
{
    /**
     * If this handler requires the backend to get locked. 
     *
     * Even if the backend changes while the response is processed, this does
     * not really matter.
     * 
     * @var bool
     */
    public $needsBackendLock = false;

    /**
     * Handles GET requests.
     *
     * @param ezcWebdavUnlockRequest $request 
     * @return ezcWebdavResponse
     */
    public function receivedRequest( ezcWebdavRequest $request )
    {
        $ifHeader = $request->getHeader( 'If' );

        $targetLockRefresher = null;
        if ( $ifHeader !== null )
        {
            $targetLockRefresher = new ezcWebdavLockRefreshRequestGenerator(
                $request
            );
        }

        $isLockNull = $this->tools->isLockNullResource(
            new ezcWebdavLockCheckInfo(
                $request->requestUri,
                ezcWebdavRequest::DEPTH_INFINITY,
                $request->getHeader( 'If' ),
                $request->getHeader( 'Authorization' ),
                ezcWebdavAuthorizer::ACCESS_READ,
                $targetLockRefresher,
                false
            ),
            true
        );

        // Lock refresh must occur no matter if the request succeeds
        if ( $targetLockRefresher !== null )
        {
            $targetLockRefresher->sendRequests();
        }

        if ( $isLockNull )
        {
            return new ezcWebdavErrorResponse(
                ezcWebdavResponse::STATUS_404,
                $request->requestUri,
                'Resource is a lock null resource.'
            );
        }
        return null;
    }

    /**
     * Handles responses to the GET request.
     *
     * Unused, since the GET request only has preconditions that need to be
     * fulfilled.
     * 
     * @param ezcWebdavResponse $response 
     * @return ezcWebdavResponse|null
     */
    public function generatedResponse( ezcWebdavResponse $response )
    {
    }
}

?>
