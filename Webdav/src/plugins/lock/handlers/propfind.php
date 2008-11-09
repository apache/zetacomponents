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
     * The original request. 
     * 
     * @var ezcWebdavPropFindRequest
     */
    protected $request;

    /**
     * If the original request explicitly requested <lockinfo>. 
     * 
     * @var bool
     */
    protected $hadLockInfo = false;

    /**
     * Handles PROPFIND requests.
     *
     * @param ezcWebdavUnlockRequest $request 
     * @return ezcWebdavResponse
     */
    public function receivedRequest( ezcWebdavRequest $request )
    {
        $this->request = $request;

        // Make sure internal <lockinfo> prop is selected, although the client
        // won't see it. We just need it to check for lock-null resources

        if ( $request->prop !== null )
        {
            if ( $request->prop->contains( 'lockinfo', ezcWebdavLockPlugin::XML_NAMESPACE ) )
            {
                $this->hadLockInfo = true;
            }
            else
            {
                $request->prop->attach( new ezcWebdavLockInfoProperty() );
            }
        }
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

        $request     = $this->request;
        $requestProp = $request->prop;

        $needsSupportedLockProp = ( 
            $request->allProp
            || $request->propName
            || ( is_object( $requestProp )
                 && $requestProp->contains( 'supportedlock' )
            )
        );
        $supportedLockEmpty = $request->propName;

        $needsLockDiscoveryProp = (
            $request->allProp
            || $request->propName
            || ( is_object( $requestProp )
                 && $requestProp->contains( 'lockdiscovery' )
            )
        );
        $lockDiscoveryEmpty = $request->propName;

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

            if ( $status200Storage === null
                 && ( $needsSupportedLockProp || $needsLockDiscoveryProp )
            )
            {
                // Create new response, since no 200 was found
                $status200Storage       = new ezcWebdavBasicPropertyStorage();
                $propStats              = $propFindRes->responses;
                $propStats[]            = new ezcWebdavPropStatResponse(
                    $status200Storage
                );
                $propFindRes->responses = $propStats;
            }

            // Add <supportedlock> if necessary
            if ( $needsSupportedLockProp )
            {
                $supportedLock = new ezcWebdavSupportedLockProperty();
                if ( !$supportedLockEmpty )
                {
                    // @TODO: Make tool method.
                    $supportedLock->lockEntries->append(
                        new ezcWebdavSupportedLockPropertyLockentry(
                            ezcWebdavLockRequest::TYPE_WRITE,
                            ezcWebdavLockRequest::SCOPE_EXCLUSIVE
                        )
                    );
                }
                $status200Storage->attach( $supportedLock );
            }

            // Add <lockdiscovery> is necessary
            if ( $needsLockDiscoveryProp && !$status200Storage->contains( 'lockdiscovery' ) )
            {
                $lockDiscovery = new ezcWebdavLockDiscoveryProperty();
                $status200Storage->attach( $lockDiscovery );
            }

            if ( $status404Storage !== null )
            {
                // Remove properties from 404 storage since they are now in
                // 200, if requested
                $status404Storage->detach( 'supportedlock' );
                $status404Storage->detach( 'lockdiscovery' );
            }

            $lockInfoProp = null;

            // Check for internal properties
            if ( $status404Storage !== null
                 && $status404Storage->contains( 'lockinfo', ezcWebdavLockPlugin::XML_NAMESPACE )
                 && !$this->hadLockInfo
               )
            {
                // Sanely remove 404
                $status404Storage->detach( 'lockinfo', ezcWebdavLockPlugin::XML_NAMESPACE );
            }

            if ( $status200Storage !== null
                 && $status200Storage->contains( 'lockinfo', ezcWebdavLockPlugin::XML_NAMESPACE )
               )
            {
                $lockInfoProp = $status200Storage->get( 'lockinfo', ezcWebdavLockPlugin::XML_NAMESPACE );

                $status200Storage->detach( 'lockinfo', ezcWebdavLockPlugin::XML_NAMESPACE );

                // Was this requested by the plugin or by the client?
                if ( $this->hadLockInfo )
                {
                    // Status 404 available?
                    if ( $status404Storage === null )
                    {
                        $status404Storage       = new ezcWebdavBasicPropertyStorage();
                        $propStats              = $propFindRes->responses;
                        $propStats[]            = new ezcWebdavPropStatResponse(
                            $status404Storage,
                            ezcWebdavResponse::STATUS_404
                        );
                        $propFindRes->responses = $propStats;
                    }
                    $status404Storage->attach( new ezcWebdavLockInfoProperty() );
                }
            }

            // Check for lock-null resources
            if ( $lockInfoProp !== null && $lockInfoProp->null )
            {
                // Lock null must have most properties empty
                if ( $status200Storage->contains( 'getcontentlanguage' ) )
                {
                    $status200Storage->detach( 'getcontentlanguage' );
                    $status200Storage->attch( new ezcWebdavGetContentLanguageProperty() );
                }
                if ( $status200Storage->contains( 'getcontentlength' ) )
                {
                    $status200Storage->detach( 'getcontentlength' );
                    $status200Storage->attch( new ezcWebdavGetContentLengthProperty() );
                }
                if ( $status200Storage->contains( 'getcontenttype' ) )
                {
                    $status200Storage->detach( 'getcontenttype' );
                    $status200Storage->attch( new ezcWebdavGetContentTypeProperty() );
                }
                if ( $status200Storage->contains( 'getcontentetag' ) )
                {
                    $status200Storage->detach( 'getetag' );
                    $status200Storage->attch( new ezcWebdavGetEtagProperty() );
                }
                if ( $status200Storage->contains( 'getlastmodified' ) )
                {
                    $status200Storage->detach( 'getlastmodified' );
                    $status200Storage->attch( new ezcWebdavGetContentLastModifiedProperty() );
                }
                if ( $status200Storage->contains( 'resourcetype' ) )
                {
                    $status200Storage->detach( 'resourcetype' );
                    $status200Storage->attch( new ezcWebdavGetContentResourceTypeProperty() );
                }
            }
        }
    }
}

?>
