<?php
/**
 * File containing the microsoft compliant transport mecanism.
 *
 * @package Webdav
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * Transport layer for Microsoft clients with RFC incompatible handling.
 *
 * Clients seen, which need this:
 *  - Microsoft Data Access Internet Publishing Provider Cache Manager
 *  - Microsoft Data Access Internet Publishing Provider DAV 1.1
 *  - Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1)
 *
 * Still not working:
 *  - Microsoft-WebDAV-MiniRedir/5.1.2600
 *
 * Seen, but unknown:
 *  - Mozilla/2.0 (compatible; MS FrontPage 4.0)
 *  - MSFrontPage/4.0
 *
 * @version //autogentag//
 * @package Webdav
 */
class ezcWebdavMicrosoftCompatibleTransport extends ezcWebdavTransport
{
    /**
     * Finally send out the response.
     *
     * Microsoft clients require an additional header here, so that we send
     * this and dispatch back to the original method.
     *
     * @param ezcWebdavOutputResult $output
     * @return void
     */
    protected function sendResponse( ezcWebdavOutputResult $output )
    {
        // Add MS specific header
        $output->header['MS-Author-Via'] = 'DAV';

        parent::sendResponse( $output );

        // MS IE7 requires a newline after the XML.
        echo "\n";
    }

    /**
     * Parses the PROPFIND request and returns a request object.
     *
     * Microsoft clients may send an empty request, so that we guess, that they
     * meant an allprop request, fill the body struct accordingly and then
     * dispatch to the original method.
     * 
     * @param string $path 
     * @param string $body 
     * @return ezcWebdavPropFindRequest
     */
    protected function parsePropFindRequest( $path, $body )
    {
        // Empty request seem to actually mean an allprop request.
        if ( empty( $body ) )
        {
            $body = '<?xml version="1.0" encoding="utf-8" ?>
<D:propfind xmlns:D="DAV:">
  <D:allprop/>
</D:propfind>';
        }

        return parent::parsePropFindRequest( $path, $body );
    }
}

