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

        $backendBeforeFile = "{$testSetName}_backend_before.php";

        if ( !file_exists( $backendBeforeFile ) )
        {
            throw new RuntimeException( "Backend before file '$backendBeforeFile' not found." );
        }

        $test->backend = include $backendBeforeFile;

        /*
        $backendAfterFile = "{$testSetName}_backend_after.php";

        if ( !file_exists( $backendAfterFile ) )
        {
            throw new RuntimeException( "Backend after file '$backendAfterFile' not found." );
        }

        $test->backendAfter = include $backendAfterFile;
        */

        $tokenFile = "{$testSetName}_tokens.php";

        $test->server->auth->tokenAssignement = ( file_exists( $tokenFile ) ? require( $tokenFile ) : array() );
    }
}

?>
