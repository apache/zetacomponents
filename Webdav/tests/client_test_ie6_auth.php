<?php

require_once 'classes/transport_test_mock.php';
require_once 'client_test_continuous_setup_ie_auth.php';

require_once 'client_test_suite.php';
require_once 'client_test.php';

class ezcWebdavClientIE6AuthTest extends ezcWebdavClientTest
{
    protected function setupTestEnvironment()
    {
        $this->setupClass = 'ezcWebdavClientTestContinuousSetupIeAuth';
        $this->dataFile   = dirname( __FILE__ ) . '/clients/ie6_auth.php';
    }

    public static function suite()
    {
        return new ezcWebdavClientTestSuite( __CLASS__ );
    }
}

?>
