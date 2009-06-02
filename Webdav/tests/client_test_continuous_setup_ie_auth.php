<?php

require_once 'client_test_continuous_setup.php';

require_once 'classes/test_auth_ie.php';

class ezcWebdavClientTestContinuousSetupIeAuth extends ezcWebdavClientTestContinuousSetup
{
    public function performSetup( ezcWebdavClientTest $test, $testSetId )
    {
        parent::performSetup( $test, $testSetId );
        $test->server->auth = new ezcWebdavTestAuthIe();
    }
}

?>
