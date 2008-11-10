<?php
/**
 * File containing the ezcWebdavLockPropFindRequestResponseHandler class.
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
 *
 * @access private
 */
class ezcWebdavLockPropFindRequestResponseHandler extends ezcWebdavLockRequestResponseHandler
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
     * Dummy method, does not do anything. 
     * 
     * @param ezcWebdavRequest $request 
     */
    public function receivedRequest( ezcWebdavRequest $request )
    {
        return null;
    }

    /**
     * Handles responses to the PROPFIND request.
     * 
     * @param ezcWebdavResponse $response 
     * @return ezcWebdavResponse|null
     */
    public function generatedResponse( ezcWebdavResponse $response )
    {
        if ( !( $response instanceof ezcWebdavMultistatusResponse ) )
        {
            return;
        }

        // Cleanup and enhance all PROPSTAT responses

        foreach ( $response->responses as $propFindRes )
        {
            $status200Storage = null;
            $status404Storage = null;

            // Collect property storages
            foreach ( $propFindRes->responses as $propStatResponse )
            {
                if ( $propStatResponse->status === ezcWebdavResponse::STATUS_200 )
                {
                    $status200Storage = $propStatResponse->storage;
                }
                if ( $propStatResponse->status === ezcWebdavResponse::STATUS_404 )
                {
                    $status404Storage = $propStatResponse->storage;
                }
            }

            if ( $status404Storage !== null && $status404Storage->contains( 'lockdiscovery' ) )
            {
                if ( $status200Storage === null )
                {
                    $status200Storage = new ezcWebdavBasicPropertyStorage();
                    $responses        = $propFindRes->responses;
                    $responses[]      = new ezcWebdavPropStatResponse(
                        $status200Storage
                    );
                    $propFindRes->responses = $responses;
                }
                $status200Storage->attach(
                    $status404Storage->get( 'lockdiscovery' )
                );
                $status404Storage->detach( 'lockdiscovery' );
            }

            if ( count( $status404Storage ) === 0 )
            {
                $responses = $propFindRes->responses;
                foreach ( $responses as $id => $propStatRes )
                {
                    if ( $propStatRes->status === ezcWebdavResponse::STATUS_404 )
                    {
                        unset( $responses[$id] );
                    }
                }
                $propFindRes->responses = $responses;
            }

        }
    }
}

?>
