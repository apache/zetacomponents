<?php

class ezcWebdavTransportTestMock extends ezcWebdavTransport
{
    protected function retreiveBody()
    {
        return $GLOBALS['EZC_WEBDAV_TRANSPORT_TEST_BODY'];
    }

    protected function sendResponse( array $output )
    {
        $GLOBALS['EZC_WEBDAV_TRANSPORT_TEST_RESPONSE_HEADERS'] = $output['headers'];
        $GLOBALS['EZC_WEBDAV_TRANSPORT_TEST_RESPONSE_BODY']    = $output['body'];
    }
}

?>
