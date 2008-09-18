<?php

require_once 'client_test_continuous_setup.php';

require_once 'classes/test_auth_ie.php';

class ezcWebdavClientTestContinuousSetupIeAuth extends ezcWebdavClientTestContinuousSetup
{
    public static function performSetup( ezcWebdavClientTest $test, $testSetName )
    {
        parent::performSetup( $test, $testSetName );
        $test->server->auth = new ezcWebdavTestAuthIe();
    }
}

?>
