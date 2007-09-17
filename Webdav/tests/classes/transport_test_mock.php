<?php

class ezcWebdavTransportTestMock extends ezcWebdavTransport
{
    protected function retreiveBody()
    {
        return isset( $GLOBALS['EZC_WEBDAV_TRANSPORT_TEST_BODY'] ) ? $GLOBALS['EZC_WEBDAV_TRANSPORT_TEST_BODY'] : '';
    }
}

?>
