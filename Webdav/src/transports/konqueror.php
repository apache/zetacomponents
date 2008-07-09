<?php
/**
 * File containing the ezcWebdavKonquerorCompatibleTransport class.
 *
 * @package Webdav
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * Transport layer for the Konqueror web browser (KDE).
 *
 * @version //autogentag//
 * @package Webdav
 */
class ezcWebdavKonquerorCompatibleTransport extends ezcWebdavTransport
{
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
