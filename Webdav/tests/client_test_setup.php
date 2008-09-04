<?php

require_once 'classes/test_auth.php';

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
            protected function retrieveBody()
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
        
        foreach ( $server->configurations as $id => $cfg )
        {
            // Prepare mock classes, if not done, yet
            if ( !class_exists( ( $mockClass = "{$cfg->transportClass}Mock" ) ) )
            {
                eval( sprintf( self::$mockClassSource, $cfg->transportClass, $cfg->transportClass ) );
            }

            // Mock all transports
            $server->configurations[$id]->transportClass = "{$cfg->transportClass}Mock";
            $server->configurations[$id]->pathFactory    = $pathFactory;
        }
        
        $server->auth = new ezcWebdavTestAuth();

        return $server;
    }
}

?>
