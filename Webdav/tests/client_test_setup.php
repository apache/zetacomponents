<?php

require_once 'classes/test_auth.php';

abstract class ezcWebdavClientTestSetup
{
    protected $mockClassSource = '
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

    abstract public function performSetup( ezcWebdavClientTest $test, $testSetId );

    public function adjustRequest( array &$request )
    {
    }

    public function adjustResponse( array &$actualResponse, array &$expectedResponse )
    {
        // Unify server generated nounce
        if ( isset( $expectedResponse['headers']['WWW-Authenticate']['digest'] )
             && isset( $actualResponse['headers']['WWW-Authenticate']['digest'] ) )
        {
            preg_match(
                '(nonce="[a-zA-Z0-9]+")',
                $actualResponse['headers']['WWW-Authenticate']['digest'],
                $matches
            );
            $expectedResponse['headers']['WWW-Authenticate']['digest'] = preg_replace(
                '(nonce="([a-zA-Z0-9]+)")',
                $matches[0],
                $expectedResponse['headers']['WWW-Authenticate']['digest']
            );
        }
    }

    protected function getServer( ezcWebdavPathFactory $pathFactory )
    {
        $server = ezcWebdavServer::getInstance();
        $server->reset();
        
        foreach ( $server->configurations as $id => $cfg )
        {
            // Prepare mock classes, if not done, yet
            if ( !class_exists( ( $mockClass = "{$cfg->transportClass}Mock" ) ) )
            {
                eval( sprintf( $this->mockClassSource, $cfg->transportClass, $cfg->transportClass ) );
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
