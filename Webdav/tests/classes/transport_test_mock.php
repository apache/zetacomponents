<?php

require_once dirname( __FILE__ ) . '/transport_injector.php';

class ezcWebdavTransportTestMock extends ezcWebdavTransport
{
    protected function retrieveBody()
    {
        return ezcWebdavTestTransportInjector::$requestBody;
    }

    protected function sendResponse( ezcWebdavOutputResult $output )
    {
        ezcWebdavTestTransportInjector::$responseStatus  = $output->status;
        ezcWebdavTestTransportInjector::$responseHeaders = $output->headers;
        ezcWebdavTestTransportInjector::$responseBody    = $output->body;
    }
}

?>
