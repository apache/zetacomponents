<?php

class ezcWebdavClientTestSetup
{
    protected static $mockClassSource = '
        class %sMock extends %s
        {
            protected function retreiveBody()
            {
                return $GLOBALS["EZC_WEBDAV_TRANSPORT_TEST_BODY"];
            }
        
            protected function sendResponse( ezcWebdavOutputResult $output )
            {
                $GLOBALS["EZC_WEBDAV_TRANSPORT_TEST_RESPONSE_STATUS"]  = $output->status;
                $GLOBALS["EZC_WEBDAV_TRANSPORT_TEST_RESPONSE_HEADERS"] = $output->headers;
                $GLOBALS["EZC_WEBDAV_TRANSPORT_TEST_RESPONSE_BODY"]    = $output->body;
            }
        }
    ';

    protected static function getServer( ezcWebdavPathFactory $pathFactory )
    {
        $server = ezcWebdavServer::getInstance();
        
        foreach ( $server->transports as $id => $transportCfg )
        {
            eval( sprintf( self::$mockClassSource, $transportCfg->transport, $transportCfg->transport ) );

            $server->transports[$id]->transport   = "{$transportCfg->transport}Mock";
            $server->transports[$id]->pathFactory = $pathFactory;
        }

        return $server;
    }
}

?>
