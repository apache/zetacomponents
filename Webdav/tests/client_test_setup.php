<?php

class ezcWebdavClientTestSetup
{
    protected static $mockClassSource = '
        class %sMock extends %s
        {
            /**
             * Retreives the body from a global variable.
             * 
             * @return void
             */
            protected function retreiveBody()
            {
                return $GLOBALS["EZC_WEBDAV_TRANSPORT_TEST_BODY"];
            }
        
            /**
             * Captures the response data in global variables.
             * 
             * @param ezcWebdavOutputResult $output 
             * @return void
             */
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
        $server->reset();
        
        foreach ( $server->transports as $id => $transportCfg )
        {
            // Prepare mock classes, if not done, yet
            if ( !class_exists( ( $mockClass = "{$transportCfg->transport}Mock" ) ) )
            {
                eval( sprintf( self::$mockClassSource, $transportCfg->transport, $transportCfg->transport ) );
            }

            // Mock all transports
            $server->transports[$id]->transport   = "{$transportCfg->transport}Mock";
            $server->transports[$id]->pathFactory = $pathFactory;
        }

        return $server;
    }
}

?>
