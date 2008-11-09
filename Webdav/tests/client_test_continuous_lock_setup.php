<?php

require_once 'client_test_continuous_setup.php';

class ezcWebdavClientTestContinuousLockSetup extends ezcWebdavClientTestContinuousSetup
{
    protected static $tokenAssignement;

    public static function performSetup( ezcWebdavClientTest $test, $testSetName )
    {
        parent::performSetup( $test, $testSetName );

        if ( basename( dirname( $testSetName ) ) !== self::$lastTestSuite )
        {
            self::$tokenAssignement = array();
        }

        $test->server->pluginRegistry->registerPlugin(
            new ezcWebdavLockPluginConfiguration(
                new ezcWebdavLockPluginOptions(
                    array(
                        'backendLockTimeout' => 2000000,
                    )
                )
            )
        );
        $test->server->auth->tokenAssignement =& self::$tokenAssignement;
    }

    protected static function setupBackend()
    {
        return require dirname( __FILE__ ) . '/scripts/test_generator_backend.php';
    }
}

?>
