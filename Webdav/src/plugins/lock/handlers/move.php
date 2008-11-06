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

        $violations = $this->tools->checkViolations(
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

        if ( $violations !== null )
        {
            // ezcWebdavMultiStatusResponse
            return $violations;
        }
        return $sourcePathCollector->getPaths();
    }

    /**
     * Handles responses to the MOVE request.
     * 
     * @param ezcWebdavResponse $response 
     * @return ezcWebdavResponse|null
     */
    public function generatedResponse( ezcWebdavResponse $response )
    {
        if ( !( $response instanceof ezcWebdavMoveResponse ) )
        {
            return null;
        }

        $backend = ezcWebdavServer::getInstance()->backend;

        // Backend successfully performed request, update with LOCK from parent

        $request    = $this->request;
        $source     = $request->requestUri;
        $dest       = $request->getHeader( 'Destination' );
        $destParent = dirname( $dest );
        $paths      = $this->sourcePaths;

        $lockDiscovery = $this->lockProperties->get( 'lockdiscovery' );
        if ( $lockDiscovery === null )
        {
            // Set an empty lock discovery to remove existing locks
            // @TODO: Affected lock must be properly removed here if we once
            // introduce shared locks.
            $lockDiscovery = new ezcWebdavLockDiscoveryProperty();
        }
        $lockInfo = $this->lockProperties->get( 'lockinfo', ezcWebdavLockPlugin::XML_NAMESPACE );
        if ( $lockInfo === null )
        {
            if ( count( $lockDiscovery->activeLock ) !== 0 )
            {
                throw new ezcWebdavInconsistencyException(
                    'Found <lockdiscovery> property but no <lockinfo> property.'
                );
            }
            $lockInfo = new ezcWebdavLockInfoProperty();
        }

        // Update lock info to subsequent paths
        foreach ( $lockInfo->tokenInfos as $tokenInfo )
        {
            if ( $tokenInfo->lockBase === null )
            {
                $tokenInfo->lockBase   = $destParent;
                $tokenInfo->lastAccess = null;
            }
        }

        foreach ( $paths as $path )
        {
            $newPath   = str_replace( $source, $dest, $path );
            $propPatchReq = new ezcWebdavPropPatchRequest( $newPath );
            $propPatchReq->updates->attach( $lockDiscovery, ezcWebdavPropPatchRequest::SET );
            $propPatchReq->updates->attach(
                $lockInfo,
                ( count( $lockInfo->tokenInfos ) !== 0 ? ezcWebdavPropPatchRequest::SET : ezcWebdavPropPatchRequest::REMOVE )
            );
            ezcWebdavLockTools::cloneRequestHeaders(
                $request,
                $propPatchReq
            );
            $propPatchReq->validateHeaders();

            $propPatchRes = $backend->propPatch( $propPatchReq );

            if ( !( $propPatchRes instanceof ezcWebdavPropPatchResponse ) )
            {
                throw new ezcWebdavInconsistencyException(
                    "Could not set lock on resource {$newPath}."
                );
            }
        }
       
        return null;
    }
}

?>
