<?php

require_once 'client_test_setup.php';
require_once 'classes/client_test_lock_auth.php';

class ezcWebdavClientTestLockPluginSetup extends ezcWebdavClientTestSetup
{
    public static function performSetup( ezcWebdavClientTest $test, $testSetName )
    {
        $test->server = self::getServer(
            new ezcWebdavBasicPathFactory( 'http://example.com' )
        );
        $test->server->pluginRegistry->registerPlugin(
            new ezcWebdavLockPluginConfiguration(
                new ezcWebdavLockPluginOptions(
                    array( 'lockTimeout' => 604800 )
                )
            )
        );
        $test->server->auth = new ezcWebdavClientTestRfcLockAuth();

        $backendFile = "{$testSetName}_backend.php";

        if ( !file_exists( $backendFile ) )
        {
            throw new RuntimeException( "Backend file '$backendFile' not found." );
        }

        $test->backend = include $backendFile;

        $tokenFile = "{$testSetName}_tokens.php";

        $test->server->auth->tokenAssignement = ( file_exists( $tokenFile ) ? require( $tokenFile ) : array() );
    }
}

?>
