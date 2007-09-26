<?php

require_once 'classes/transport_test_mock.php';
require_once 'client_test_backend_continuous.php';

require_once 'client_test_suite.php';
require_once 'client_test.php';

class ezcWebdavClientNautilusTest extends ezcWebdavClientTest
{
    protected function setupTestEnvironment()
    {
        $this->setupClass = 'ezcWebdavClientTestBackendContinuous';
        $this->dataDir    = dirname( __FILE__ ) . '/clients/nautilus';
    }

    public static function suite()
    {
        return new ezcWebdavClientTestSuite( __CLASS__ );
    }
}

?>
