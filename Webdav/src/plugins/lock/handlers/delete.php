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
 * Handler class for the PROPFIND request.
 * 
 * @package Webdav
 * @version //autogen//
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 *
 * @access private
 */
class ezcWebdavLockDeleteRequestResponseHandler extends ezcWebdavLockRequestResponseHandler
{
    /**
     * Handles MOVE requests.
     *
     * @param ezcWebdavUnlockRequest $request 
     * @return ezcWebdavResponse
     */
    public function receivedRequest( ezcWebdavRequest $request )
    {
        $violations = $this->tools->checkViolations(
            new ezcWebdavLockCheckInfo(
                $request->requestUri,
                ezcWebdavRequest::DEPTH_INFINITY,
                $request->getHeader( 'If' ),
                $request->getHeader( 'Authorization' ),
                ezcWebdavAuthorizer::ACCESS_WRITE,
                null
                // @TODO: We allow deleting null resources. Correct?
            ),
            true
        );

        if ( $violations !== null )
        {
            return $violations;
        }
    }

    /**
     * Handles responses to the MOVE request.
     * 
     * @param ezcWebdavResponse $response 
     * @return ezcWebdavResponse|null
     */
    public function generatedResponse( ezcWebdavResponse $response )
    {
    }
}

?>
