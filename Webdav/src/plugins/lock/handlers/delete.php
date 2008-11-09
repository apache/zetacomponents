<?php
/**
 * File containing the ezcWebdavLockDeleteRequestResponseHandler class.
 *
 * @package Webdav
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 *
 * @access private
 */
/**
 * Handler class for the DELETE request.
 * 
 * @package Webdav
 * @version //autogen//
 *
 * @access private
 */
class ezcWebdavLockDeleteRequestResponseHandler extends ezcWebdavLockRequestResponseHandler
{
    /**
     * Handles DELETE requests.
     *
     * @param ezcWebdavDeleteRequest $request 
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

        $violation = $this->tools->checkViolations(
            new ezcWebdavLockCheckInfo(
                $request->requestUri,
                ezcWebdavRequest::DEPTH_INFINITY,
                $request->getHeader( 'If' ),
                $request->getHeader( 'Authorization' ),
                ezcWebdavAuthorizer::ACCESS_WRITE,
                $targetLockRefresher
            ),
            true
        );

        // Lock refresh must occur no matter if the request succeeds
        if ( $targetLockRefresher !== null )
        {
            $targetLockRefresher->sendRequests();
        }

        if ( $violation !== null )
        {
            // ezcWebdavErrorResponse
            return $violation;
        }
    }

    /**
     * Handles responses to the DELTE request.
     * 
     * @param ezcWebdavResponse $response 
     * @return ezcWebdavResponse|null
     */
    public function generatedResponse( ezcWebdavResponse $response )
    {
    }
}

?>
