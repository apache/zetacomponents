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
                return ezcWebdavTestTransportInjector::$requestBody;
            }
        
            /**
             * Captures the response data in global variables.
             * 
             * @param ezcWebdavOutputResult $output 
             * @return void
             */
            protected function sendResponse( ezcWebdavOutputResult $output )
            {
                ezcWebdavTestTransportInjector::$responseStatus  = $output->status;
                ezcWebdavTestTransportInjector::$responseHeaders = $output->headers;
                ezcWebdavTestTransportInjector::$responseBody    = $output->body;
            }
        }
    ';

    abstract public function performSetup( ezcWebdavClientTest $test, $testSetId );

    public function adjustRequest( array &$request )
    {
        $serverBase = array(
            'DOCUMENT_ROOT'   => '/var/www/localhost/htdocs',
            'HTTP_USER_AGENT' => 'RFC compliant',
            'SCRIPT_FILENAME' => '/var/www/localhost/htdocs',
            'SERVER_NAME'     => 'webdav',
        );

        $request['server'] = array_merge( $serverBase, $request['server'] );
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

    public function assertCustomAssertions( ezcWebdavClientTest $testCase )
    {
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
