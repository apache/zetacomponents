<?php

require_once 'client_test_setup.php';
require_once 'classes/client_test_lock_auth.php';

class ezcWebdavClientTestLockPluginSetup extends ezcWebdavClientTestSetup
{
    protected $testDataDir;

    protected $tokenReplacement = array();

    protected $tokenAssignement = array();

    public function performSetup( ezcWebdavClientTest $test, $testSetId )
    {
        $this->testDataDir = dirname( __FILE__ ) . '/lock_plugin';

        $test->server = $this->getServer(
            new ezcWebdavBasicPathFactory( 'http://example.com' )
        );
        $test->server->pluginRegistry->registerPlugin(
            new ezcWebdavLockPluginConfiguration(
                new ezcWebdavLockPluginOptions(
                    array(
                        'lockTimeout'        => 604800,
                        'backendLockTimeout' => 2000000,
                    )
                )
            )
        );
        $test->server->auth = new ezcWebdavClientTestRfcLockAuth();
        $test->server->auth->credentials['foo'] = 'bar';

        $test->backend = $this->getBackend( $testSetId );

        $test->server->auth->tokenAssignement = $this->getTokenAssignement(
            $testSetId
        );
    }

    public function adjustRequest( array &$request )
    {
        parent::adjustRequest( $request );
        foreach ( $this->tokenReplacement as $from => $to )
        {
            if ( isset( $request['server']['HTTP_IF'] ) )
            {
                $request['server']['HTTP_IF'] = preg_replace(
                    '(' . preg_quote( $from ) . ')',
                    $to,
                    $request['server']['HTTP_IF']
                );
            }
            if ( isset( $request['server']['HTTP_LOCK_TOKEN'] ) )
            {
                $request['server']['HTTP_LOCK_TOKEN'] = preg_replace(
                    '(' . preg_quote( $from ) . ')',
                    $to,
                    $request['server']['HTTP_LOCK_TOKEN']
                );
            }
        }
    }

    public function adjustResponse( array &$realResponse, array &$expectedResponse )
    {
        parent::adjustResponse( $realResponse, $expectedResponse );
        if ( isset( $realResponse['headers']['Lock-Token'] ) && !isset( $expectedResponse['headers']['Lock-Token'] ) )
        {
            throw new RuntimeException( 'Real response had Lock-Token, expected not!' );
        }
        if ( !isset( $realResponse['headers']['Lock-Token'] ) && isset( $expectedResponse['headers']['Lock-Token'] ) )
        {
            throw new RuntimeException( 'Expected response had Lock-Token, real not!' );
        }
        

        if ( isset( $realResponse['headers']['Lock-Token'] ) )
        {
            $toReplace   = $expectedResponse['headers']['Lock-Token'];
            $replaceWith = $realResponse['headers']['Lock-Token'];
            
            $this->tokenReplacement[$toReplace]       = $replaceWith;
            $expectedResponse['headers']['Lock-Token'] = $realResponse['headers']['Lock-Token'];
        }

        foreach ( $this->tokenReplacement as $from => $to )
        {
            $expectedResponse['body'] = preg_replace(
                '(' . preg_quote( $from ) . ')',
                $to,
                $expectedResponse['body']
            );
        }

        // Unify last access dates
        $realResponse['body'] = preg_replace(
            '([0-9]{4}-[0-9]{2}-[0-9]{2}[0-9T:+]+)',
            '2008-11-09T22:14:18+00:00',
            $realResponse['body']
        );
        $expectedResponse['body'] = preg_replace(
            '([0-9]{4}-[0-9]{2}-[0-9]{2}[0-9T:+]+)',
            '2008-11-09T22:14:18+00:00',
            $expectedResponse['body']
        );
    }


    protected function getBackend( $testSetId )
    {
        return require $this->getDataFile( $testSetId, 'backend.php' );
    }

    protected function getTokenAssignement( $testSetId )
    {
        try
        {
            return require $this->getDataFile( $testSetId, 'tokens.php' );
        }
        catch ( RuntimeException $e )
        {
            return array();
        }
    }

    protected function getDataFile( $testSetId, $suffix )
    {
        $glob = sprintf(
            '%s/%03s_*_%s',
            $this->testDataDir,
            $testSetId,
            $suffix
        );

        $potentialDataFiles = glob( $glob );

        if ( $potentialDataFiles === array() )
        {
            throw new RuntimeException(
                sprintf(
                    'No data file found with test ID %s and suffix "%s".',
                    $testSetId,
                    $suffix
                )
            );
        }

        return $potentialDataFiles[0];
    }
}

?>
