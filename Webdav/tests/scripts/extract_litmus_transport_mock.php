<?php
/**
 * transport_mock.php in web envirionment. Renam accordingly.
 * 
 * @see extract_litmus.php
 * @package Webdav
 * @subpackage Tests
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

class tsWebdavTransportMock extends ezcWebdavTransport
{

    protected function retreiveBody()
    {
        $body = parent::retreiveBody();
        $GLOBALS['TS_REQUEST_BODY'] = $body;
        return $body;
    }

    protected function parseHeaders( array $headerNames )
    {
        $headers = parent::parseHeaders( $headerNames );
        $GLOBALS['TS_REQUEST_HEADERS'] = $headers;
        return $headers;
    }

    protected function sendResponse( ezcWebdavDisplayInformation $info )
    {
        $GLOBALS['TS_RESPONSE_INFO'] = $info;
        ob_start();
        parent::sendResponse( $info );
        $GLOBALS['TS_RESPONSE_BODY'] = ob_get_contents();
        ob_flush();
        $GLOBALS['TS_RESPONSE_HEADERS'] = $info->response->getHeaders();
    }
}

?>
