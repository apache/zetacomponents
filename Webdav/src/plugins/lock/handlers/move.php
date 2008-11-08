<?php
/**
 * File containing the ezcWebdavLockMoveRequestResponseHandler class.
 *
 * @package Webdav
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 *
 * @access private
 */
/**
 * Handler class for the MOVE request.
 * 
 * @package Webdav
 * @version //autogen//
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 *
 * @access private
 */
class ezcWebdavLockMoveRequestResponseHandler extends ezcWebdavLockCopyRequestResponseHandler
{
    /**
     * Returns all pathes in the move source.
     *
     * This method performs the necessary checks on the source to move. It
     * returns all paths that are to be moved. In case of any violation of the
     * checks, the method must hold and return an instance of
     * ezcWebdavErrorResponse instead of the desired paths.
     * 
     * @return array(string)|ezcWebdavErrorResponse
     */
    protected function getSourcePaths()
    {
        $sourcePathCollector = new ezcWebdavLockCheckPathCollector();

        $violation = $this->tools->checkViolations(
            // Source
            new ezcWebdavLockCheckInfo(
                $this->request->requestUri,
                ezcWebdavRequest::DEPTH_INFINITY,
                $this->request->getHeader( 'If' ),
                $this->request->getHeader( 'Authorization' ),
                ezcWebdavAuthorizer::ACCESS_WRITE,
                $sourcePathCollector,
                false // No lock-null allowed
            ),
            // Return on first violation
            true
        );

        if ( $violation !== null )
        {
            // ezcWebdavErrorResponse
            return $violation;
        }
        return $sourcePathCollector->getPaths();
    }
}

?>
