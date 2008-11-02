<?php
/**
 * File containing the ezcWebdavLockLockRequestGenerator class.
 *
 * @package Webdav
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * Request generator used to generate PROPPATCH requests to realize the LOCK.
 *
 * @package Webdav
 * @version //autogen//
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
class ezcWebdavLockLockRequestGenerator implements ezcWebdavLockCheckObserver
{
    /**
     * Generated requests. 
     * 
     * @var array(ezcWebdavPropPatchRequest)
     */
    protected $requests = array();

    /**
     * Request that issued the lock. 
     * 
     * @var ezcWebdavLockRequest
     */
    protected $issuingRequest;

    /**
     * Active lock information part of lock response.
     * 
     * @var ezcWebdavLockDiscoveryPropertyActiveLock
     */
    protected $activeLock;

    /**
     * Creates a new request generator.
     *
     * The $request is the LOCK requst object, which was sent by the client.
     * The $activeLock part will be attached to the <lockdiscovery> property of
     * every affected resource.
     * 
     * @param ezcWebdavLockRequest $request 
     * @param string $lockToken
     */
    public function __construct(
        ezcWebdavLockRequest $request,
        ezcWebdavLockDiscoveryPropertyActiveLock $activeLock
    )
    {
        $this->issuingRequest = $request;
        $this->activeLock     = $activeLock;
    }

    /**
     * Notify the generator about a response.
     *
     * Notifies the request generator that a request should be generated w.r.t.
     * the given $response.
     * 
     * @param ezcWebdavPropFindResponse $propFind 
     * @return void
     */
    public function notify( ezcWebdavPropFindResponse $response )
    {
        $propPatch = new ezcWebdavPropPatchRequest( $response->node->path );

        // Overwrite properties, since only 1 lock is allowed at a time (currently)!

        $lockDiscoveryProp = new ezcWebdavLockDiscoveryProperty(
            new ArrayObject(
                array( clone $this->activeLock )
            )
        );
        
        $propPatch->updates->attach(
            $lockDiscoveryProp,
            ezcWebdavPropPatchRequest::SET
        );

        $lockInfoProperty = new ezcWebdavLockInfoProperty(
            new ArrayObject(
                new ezcWebdavLockTokenInfo(
                    $this->activeLock->token,
                    // Set $lockBase, if this resource is not the base
                    ( $this->issuingRequest->requestUri !== $response->node->path ? $requests->requestUri : null ),
                    // Set $lastAccess for the lock base (used for lock timeouts)
                    ( $this->issuingRequest->requestUri === $response->node->path ? new DateTime() : null )
                )
            )
        );

        $propPatch->updates->attach(
            $lockInfoProperty,
            ezcWebdavPropPatchRequest::SET
        );

        $this->requests[] = $propPatch;
    }

    /**
     * Returns all collected requests generated in the processor. 
     * 
     * @return array(ezcWebdavRequest)
     */
    public function getRequests()
    {
        return $this->requests;
    }
}

?>
