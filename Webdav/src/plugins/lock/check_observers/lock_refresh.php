<?php
/**
 * File containing the ezcWebdavLockRefreshRequestGenerator class.
 *
 * @package Webdav
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * Check observer that generates PROPPATCH requests to refresh locks.
 * 
 * @package Webdav
 * @version //autogen//
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
class ezcWebdavLockRefreshRequestGenerator implements ezcWebdavLockCheckObserver
{
    /**
     * Lock bases that have not been found, yet.
     *
     * Structure:
     * <code>
     * <?php
     *  array(
     *      '/some/lock/base' => true,
     *      '/anotther/lock/base' => true,
     *  );
     * ?>
     * </code>
     * 
     * @var array(string=>bool)
     */
    protected $notFoundLockBases = array();

    /**
     * All <lockinfo> properties of lock bases affected by the refresh.
     * 
     * @var array(string=>ezcWebdavLockInfoProperty)
     */
    protected $lockBaseProperties = array();

    /**
     * Contains <lockdiscovery> properties that need to ba updates.
     * 
     * @var array(string=>ezcWebdavLockDiscoveryProperty)
     */
    protected $lockDiscoveryProperties = array();

    /**
     * The If header containing the tokens to refresh. 
     * 
     * @var ezcWebdavLockIfHeaderList
     */
    protected $ifHeader;

    /**
     * The request that issued the lock refresh.
     * 
     * @var ezcWebdavLockIfHeaderList
     */
    protected $request;

    /**
     * Lock discovery property of the originally requested path. 
     * 
     * @var ezcWebdavLockDiscoveryProperty
     */
    protected $mainLockDiscoveryProperty;

    /**
     * New timeout to set for the lock. 
     * 
     * @var int|null
     */
    protected $timeout;

    /**
     * Creates a new observer for lock refreshs.
     *
     * This observer collects the base for all affected locks of a request and
     * creates PROPPATCH requests to update the affected locks.
     *
     * The PROPPATCH requests can be obtained after collecting, using the
     * {@link getRequests()} or can be send using the {@link sendRequests()}
     * method.
     * 
     * @param ezcWebdavRequest $request 
     * @param int $timeout 
     * @return void
     */
    public function __construct( ezcWebdavRequest $request, $timeout = null )
    {
        $this->request  = $request;
        $this->ifHeader = $request->getHeader( 'If' );
        $this->timeout  = $timeout;
    }

    /**
     * Notify the request generator about a checked resource. 
     * 
     * @param ezcWebdavPropFindResponse $response 
     * @return void
     */
    public function notify( ezcWebdavPropFindResponse $response )
    {
        $path = $response->node->path;

        // All lock tokens to affect
        $affectedTokens = array();
        foreach ( $this->ifHeader[$path] as $ifHeaderItem )
        {
            $affectedTokens += $ifHeaderItem->lockTokens;
        }
        $affectedTokens = array_unique( $affectedTokens );

        foreach ( $response->responses as $propStatResponse )
        {
            if ( $propStatResponse->status === ezcWebdavResponse::STATUS_200 )
            {
                // Update last access time for all affected lock tokens

                if ( $propStatResponse->storage->contains( 'lockinfo', ezcWebdavLockPlugin::XML_NAMESPACE ) )
                {
                    $lockInfoProp = $propStatResponse->storage->get(
                        'lockinfo',
                        ezcWebdavLockPlugin::XML_NAMESPACE
                    );

                    $newLockInfoProp = clone $lockInfoProp;

                    foreach ( $newLockInfoProp->tokenInfos as $tokenInfo )
                    {
                        // Skip locks that should not be refreshed
                        if ( !in_array( $tokenInfo->token, $affectedTokens ) )
                        {
                            continue;
                        }

                        if ( $tokenInfo->lockBase !== null )
                        {
                            // If lock base for this token was not seen, yet, notify it for update
                            if ( !isset( $this->lockBaseProperties[$tokenInfo->lockBase] ) )
                            {
                                $this->notFoundLockBases[$tokenInfo->lockBase] = true;
                            }
                        }
                        else
                        {
                            // Update access time
                            $tokenInfo->lastAccess = new ezcWebdavDateTime();
                            if ( !isset( $this->lockBaseProperties[$path] ) )
                            {
                                // Store for update
                                $this->lockBaseProperties[$path] = $newLockInfoProp;
                            }
                            // Found the lockbase now
                            unset( $this->notFoundLockBases[$path] );
                        }
                    }
                }

                // Update timeout value, if desired. Store main <lockdiscovery> property.

                if ( $propStatResponse->storage->contains( 'lockdiscovery' ) )
                {
                    $lockDiscoveryProp = $propStatResponse->storage->get( 'lockdiscovery' );
                    if ( $path === $this->request->requestUri )
                    {
                        $this->mainLockDiscoveryProperty = $lockDiscoveryProp;
                    }

                    if ( $this->timeout !== null )
                    {
                        $updated           = false;
                        $lockDiscoveryProp = clone $lockDiscoveryProp;
                        foreach ( $lockDiscoveryProp->activeLock as $activeLock )
                        {
                            if ( !in_array( (string) $activeLock->token, $affectedTokens ) )
                            {
                                continue;
                            }

                            if ( $activeLock->timeout !== $this->timeout )
                            {
                                $activeLock->timeout = $this->timeout;
                                $updated = true;
                            }
                        }
                        if ( $updated )
                        {
                            $this->lockDiscoveryProperties[$path] = $lockDiscoveryProp;
                        }
                    }
                }
            }
        }
    }

    /**
     * Returns the requests necessary to refresh the locks.
     * 
     * @return array(ezcWebdavRequest)
     */
    public function getRequests()
    {
        foreach ( $this->notFoundLockBases as $lockBase => $dummy )
        {
            $this->fetchLockBase( $lockBase );
        }

        if ( count( $this->notFoundLockBases ) )
        {
            throw new ezcWebdavInconsistencyException(
                'Some lock bases could not be determined.'
            );
        }

        return $this->generateRequests();
    }

    /**
     * Receives the main <lockdiscovery> property.
     *
     * Returs the desired <lockdiscovery> property.
     * 
     * @return ezcWebdavLockDiscoveryProperty
     */
    public function getMainLockDiscoveryProperty()
    {
        return $this->mainLockDiscoveryProperty;
    }

    /**
     * Sends the generated requests and performs the lock refresh.
     *
     * Returns an error response, if an error occurs.
     * 
     * @return ezcWebdavErrorResponse|null
     */
    public function sendRequests()
    {
        $backend = ezcWebdavServer::getInstance()->backend;
        
        $reqs = $this->getRequests();

        foreach ( $reqs as $propPatch )
        {
            $propPatch->validateHeaders();
            $res = $backend->propPatch( $propPatch );
            if ( !( $res instanceof ezcWebdavPropPatchResponse ) )
            {
                return $res;
            }
        }
        return null;
    }

    /**
     * Fetches a lock base at a given $path.
     *
     * This method fetches a lock base, in case we need to refresh a lock, of
     * which the base was not below the request uri. The method issues the
     * necessary PROPFOND request and hands the result over to {@link notify()}
     * again.
     * 
     * @param string $path 
     * @return void
     *
     * @throws ezcWebdavInconsistencyException
     *         in case no lock base is found in the given $path.
     */
    protected function fetchLockBase( $path )
    {
        $propFind = new ezcWebdavPropFindRequest( $path );
        $propFind->prop = new ezcWebdavBasicPropertyStorage();
        $propFind->prop->attach( new ezcWebdavLockInfoProperty() );
        ezcWebdavLockTools::cloneRequestHeaders( $this->request, $propFind );
        $propFind->validateHeaders();

        $response = ezcWebdavServer::getInstance()->backend->propFind(
            $propFind
        );

        if ( !( $response instanceof ezcWebdavMultistatusResponse ) )
        {
            throw new ezcWebdavInconsistencyException(
                "Could not find expected lock base at path '$path'."
            );
        }

        $this->notify( $response->responses[0] );
    }

    /**
     * Generates the requests to update the locks.
     *
     * This method generates a PROPPATCH request for each <lockinfo> property
     * in {@link $lockBaseProperties} and returns all of them in an array.
     * 
     * @return array(ezcWebdavPropPatchRequest)
     */
    protected function generateRequests()
    {
        $requests = array();
        foreach ( $this->lockBaseProperties as $path => $lockInfoProperty )
        {
            $propPatch = new ezcWebdavPropPatchRequest( $path );
            $propPatch->updates->attach(
                $lockInfoProperty,
                ezcWebdavPropPatchRequest::SET
            );
            if ( isset( $this->lockDiscoveryProperties[$path] ) )
            {
                $propPatch->updates->attach(
                    $this->lockDiscoveryProperties[$path],
                    ezcWebdavPropPatchRequest::SET
                );
            }
            ezcWebdavLockTools::cloneRequestHeaders( $this->request, $propPatch );

            $requests[] = $propPatch;
        }
        return $requests;
    }
}

?>
