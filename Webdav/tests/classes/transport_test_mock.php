<?php

class ezcWebdavTransportTestMock extends ezcWebdavTransport
{
    protected function retreiveBody()
    {
        return isset( $GLOBALS['EZC_WEBDAV_TRANSPORT_TEST_BODY'] ) ? $GLOBALS['EZC_WEBDAV_TRANSPORT_TEST_BODY'] : '';
    }

    protected function sendResponse( ezcWebdavResponse $response, DOMDocument $dom = null )
    {
        $GLOBALS['EZC_WEBDAV_TRANSPORT_TEST_RESPONSE_HEADERS'][] = (string) $response;
        $GLOBALS['EZC_WEBDAV_TRANSPORT_TEST_RESPONSE_BODY'] = ( $dom !== null ? $dom->saveXML( $dom, LIBXML_NSCLEAN ) : null );
    }
}

?>
