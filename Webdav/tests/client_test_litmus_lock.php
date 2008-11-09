<?php

require_once 'classes/transport_test_mock.php';
require_once 'classes/rfc_path_factory.php';
require_once 'client_test_continuous_lock_setup.php';

require_once 'client_test_suite.php';
require_once 'client_test.php';

class ezcWebdavClientLitmusLockTest extends ezcWebdavClientTest
{
    private static $tokenReplacements = array();

    protected function setupTestEnvironment()
    {
        $this->setupClass = 'ezcWebdavClientTestContinuousLockSetup';
        $this->dataDir    = dirname( __FILE__ ) . '/clients/litmus_lock';
    }

    public static function suite()
    {
        return new ezcWebdavClientTestSuite( __CLASS__ );
    }

    protected function adjustRequest( array &$request )
    {
        foreach ( self::$tokenReplacements as $from => $to )
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

    protected function adjustResponse( array &$realResponse, array &$expectedResponse )
    {
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
            
            self::$tokenReplacements[$toReplace]       = $replaceWith;
            $expectedResponse['headers']['Lock-Token'] = $realResponse['headers']['Lock-Token'];
        }

        foreach ( self::$tokenReplacements as $from => $to )
        {
            $expectedResponse['body'] = preg_replace(
                '(' . preg_quote( $from ) . ')',
                $to,
                $expectedResponse['body']
            );
        }
    }
}

?>
