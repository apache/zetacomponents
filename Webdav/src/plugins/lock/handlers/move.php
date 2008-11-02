<?php
/**
 * File containing the ezcWebdavLockUnlockRequestResponseHandler class.
 *
 * @package Webdav
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 *
 * @access private
 */
/**
 * Handler class for the UNLOCK request.
 * 
 * @package Webdav
 * @version //autogen//
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 *
 * @access private
 */
class ezcWebdavLockMoveRequestResponseHandler extends ezcWebdavLockRequestResponseHandler
{
    /**
     * Information to be transferred between request and response handling. 
     * 
     * @var array
     */
    protected $handlingInfo;

    /**
     * Handles MOVE requests.
     *
     * @param ezcWebdavUnlockRequest $request 
     * @return ezcWebdavResponse
     */
    public function receivedRequest( ezcWebdavRequest $request )
    {
        $backend = ezcWebdavServer::getInstance()->backend;

        $this->handlingInfo = array();

        $destination = $request->getHeader( 'Destination' );
        $destParent  = dirname( $destination );
        $ifHeader    = $request->getHeader( 'If' );
        $authHeader  = $request->getHeader( 'Authorization' );

        // Check violations and collect info for response handling

        $sourcePathCollector = new ezcWebdavLockCheckPathCollector();

        $destinationPropertyCollector = new ezcWebdavLockCheckPropertyCollector();
        $destinationLockRefresher = new ezcWebdavLockRefreshRequestGenerator(
            $request
        );
        $multiObserver = new ezcWebdavLockMultipleCheckObserver();
        $multiObserver->attach( $destinationPropertyCollector );
        $multiObserver->attach( $destinationLockRefresher );

        $violations = $this->tools->checkViolations(
            array(
                // Source
                new ezcWebdavLockCheckInfo(
                    $request->requestUri,
                    ezcWebdavRequest::DEPTH_INFINITY,
                    $ifHeader,
                    $authHeader,
                    ezcWebdavAuthorizer::ACCESS_WRITE,
                    $sourcePathCollector,
                    false // No lock-null allowed
                ),
                // Destination (maybe overwritten, maybe not, but we must not
                // care)
                new ezcWebdavLockCheckInfo(
                    $destination,
                    ezcWebdavRequest::DEPTH_INFINITY,
                    $ifHeader,
                    $authHeader,
                    ezcWebdavAuthorizer::ACCESS_WRITE,
                    null,
                    false // No lock-null allowed
                ),
                // Destination parent dir
                // We also get the lock property from here and refresh the
                // locks on it
                new ezcWebdavLockCheckInfo(
                    $destParent,
                    ezcWebdavRequest::DEPTH_ZERO,
                    $ifHeader,
                    $authHeader,
                    ezcWebdavAuthorizer::ACCESS_WRITE,
                    $multiObserver,
                    false // No lock-null allowed
                ),
            ),
            // Return on first violation
            true
        );

        if ( $violations !== null )
        {
            return new ezcWebdavMultistatusResponse( $violations );
        }

        // Perform lock refresh (most occur no matter if request succeeds)
        $destinationLockRefresher->sendRequests();

        // Store infos for use on correct moving

        
        $destParentProps = $destinationPropertyCollector->getProperties(
                $destParent
        );

        // Consistency check
        if ( $destParentProps->contains( 'lockdiscovery' )
             ^ $destParentProps->contains( 'lockinfo', ezcWebdavLockPlugin::XML_NAMESPACE )
           )
        {
            throw new ezcWebdavInconsistencyException(
                "Resource '{$request->requestUri}' has inconsisten lock properties."
            );
        }

        $this->handlingInfo['props'] = $destParentProps;

        $this->handlingInfo['request']   = $request;
        $this->handlingInfo['destPaths'] = $sourcePathCollector->getPaths();

        // Backend now handles the request
        // return null;
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

        $request = $this->handlingInfo['request'];
        $source  = $request->requestUri;
        $dest    = $request->getHeader( 'Destination' );
        $paths   = $this->handlingInfo['destPaths'];

        $lockDiscovery = $this->handlingInfo['props']->get( 'lockdiscovery' );
        if ( $lockDiscovery === null )
        {
            // Nothing to do
            return;
        }
        $lockInfo = $this->handlingInfo['props']->get( 'lockinfo', ezcWebdavLockPlugin::XML_NAMESPACE );
        if ( $lockInfo === null )
        {
            throw new ezcWebdavInconsistencyException(
                'Found <lockdiscovery> property but no <lockinfo> property.'
            );
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
            $propPatch = new ezcWebdavPropPatchRequest( $newPath );
            $propPatch->storage->attach( $lockDiscovery );
            $propPatch->storage->attach( $lockInfo );
            $propPatch->setHeader( 'Authorization', $request->getHeader( 'Authorization' ) );

            $propPatchRes = $backend->propPatch( $propPatch );

            if ( !( $propPatchRes instanceof ezcWebdavPropPatchResponse ) )
            {
                throw new ezcWebdavInconsistencyException(
                    "Could not set lock on resource {$newPath}."
                );
            }
        }
       
        // return null;
    }
}

?>
