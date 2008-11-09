<?php
/**
 * File containing the ezcWebdavLockPropPatchRequestResponseHandler class.
 *
 * @package Webdav
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 *
 * @access private
 */
/**
 * Handler class for the PROPPATCH request.
 * 
 * @package Webdav
 * @version //autogen//
 *
 * @access private
 */
class ezcWebdavLockPropPatchRequestResponseHandler extends ezcWebdavLockRequestResponseHandler
{
    /**
     * Handles PROPPATCH requests.
     *
     * @param ezcWebdavPropPatchRequest $request 
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
                ezcWebdavRequest::DEPTH_ZERO,
                $request->getHeader( 'If' ),
                $request->getHeader( 'Authorization' ),
                ezcWebdavAuthorizer::ACCESS_WRITE,
                $targetLockRefresher,
                false
            ),
            true
        );

        if ( $violation !== null )
        {
            // ezcWebdavErrorResponse
            return $violation;
        }

        // Lock refresh must occur no matter if the request succeeds
        if ( $targetLockRefresher !== null )
        {
            $targetLockRefresher->sendRequests();
        }

        if ( $request->updates->contains( 'lockdiscovery' ) )
        {
            return new ezcWebdavMultistatusResponse(
                new ezcWebdavErrorResponse(
                    ezcWebdavResponse::STATUS_409,
                    $request->requestUri,
                    "Property 'lockdiscovery' is readonly."
                )
            );
        }
        if ( $request->updates->contains( 'lockinfo', ezcWebdavLockPlugin::XML_NAMESPACE ) )
        {
            return new ezcWebdavMultistatusResponse(
                new ezcWebdavErrorResponse(
                    ezcWebdavResponse::STATUS_409,
                    $request->requestUri,
                    "Property 'lockinfo' is readonly."
                )
            );
        }
    }

    /**
     * Handles responses to the PROPPATCH request.
     * 
     * @param ezcWebdavResponse $response 
     * @return ezcWebdavResponse|null
     */
    public function generatedResponse( ezcWebdavResponse $response )
    {
    }
}

?>
