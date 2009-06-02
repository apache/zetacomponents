<?php

require_once 'classes/transport_test_mock.php';
require_once 'classes/rfc_path_factory.php';
require_once 'client_test_lockplugin_setup.php';

require_once 'client_test_suite.php';
require_once 'client_test.php';

class ezcWebdavClientLockPluginTest extends ezcWebdavClientTest
{
    private static $tokenReplacements = array();

    protected function setupTestEnvironment()
    {
        $this->setupClass = 'ezcWebdavClientTestLockPluginSetup';
        $this->dataFile   = dirname( __FILE__ ) . '/clients/lockplugin.php';
    }

    public static function suite()
    {
        return new ezcWebdavClientTestSuite( __CLASS__ );
    }

    protected function runTestSet( $testSetName )
    {
        parent::runTestSet( $testSetName );
        
        $assertionFile = "{$testSetName}_assertions.php";

        if ( file_exists( $assertionFile ) )
        {
            $assertionObject = include $assertionFile;
            $assertionReflection = new ReflectionObject( $assertionObject );

            foreach ( $assertionReflection->getMethods() as $assertionMethod )
            {
                $assertionMethod->invoke(
                    $assertionObject,
                    $this->backend
                );
            }
        }
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
