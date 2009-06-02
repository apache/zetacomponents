<?php

require_once 'client_test_continuous_setup.php';

class ezcWebdavClientTestContinuousLockSetup extends ezcWebdavClientTestContinuousSetup
{
    protected $tokenAssignement = array();

    protected $tokenReplacement = array();

    public function performSetup( ezcWebdavClientTest $test, $testSetId )
    {
        parent::performSetup( $test, $testSetId );

        $test->server->pluginRegistry->registerPlugin(
            new ezcWebdavLockPluginConfiguration(
                new ezcWebdavLockPluginOptions(
                    array(
                        'backendLockTimeout' => 2000000,
                    )
                )
            )
        );
        $test->server->auth->tokenAssignement =& $this->tokenAssignement;
    }

    public function adjustRequest( array &$request )
    {
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
}

?>
