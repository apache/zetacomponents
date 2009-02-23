<?php
/**
 * File containing the ezcWebdavKonquerorCompatibleTransport class.
 *
 * @package Webdav
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * Transport layer for the Konqueror web browser (KDE).
 *
 * This transport class adjust the behavior of the Webdav component to work
 * with the KDE browser Konqueror.
 *
 * Tested with:
 *
 * - Konqueror 3.5.7
 * - Konqueror 3.5.9 (does not perform PUT requests, bug in client)
 *
 * @version //autogentag//
 * @package Webdav
 */
class ezcWebdavKonquerorCompatibleTransport extends ezcWebdavTransport
{
    /**
     * Decodes the URLs in href attributes of PROPFIND responses.
     *
     * Konqueror does not use the <displayname> property (which is also URL
     * encoded), but the <href> tag of the response to determine the displayed
     * resource names. It expects the content to be un-encoded.
     *
     * This method calls the parent method and replaces the content of all
     * <href> elements in the DOM tree.
     * 
     * @param ezcWebdavPropFindResponse $response 
     * @return ezcWebdavXmlDisplayInformation
     */
    protected function processPropFindResponse( ezcWebdavPropFindResponse $response )
    {
        $xmlDisplayInfo = parent::processPropFindResponse( $response );
        $hrefElements = $xmlDisplayInfo->body->getElementsByTagName( 'href' );

        foreach ( $hrefElements as $href )
        {
            $href->nodeValue = urldecode( $href->nodeValue );
        }
        return $xmlDisplayInfo;
    }
}
?>
