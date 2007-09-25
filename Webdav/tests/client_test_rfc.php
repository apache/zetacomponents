<?php

require_once 'classes/transport_test_mock.php';
require_once 'classes/rfc_path_factory.php';
require_once 'client_test_rfc_backend.php';

require_once 'client_test_suite.php';
require_once 'client_test.php';

class ezcWebdavClientRfcTest extends ezcWebdavClientTest
{
    protected function setupTestEnvironment()
    {
        $this->setupClass = 'ezcWebdavClientRfcTestBackend';
        $this->dataDir    = dirname( __FILE__ ) . '/clients/rfc';
    }

    public static function suite()
    {
        return new ezcWebdavClientTestSuite( __CLASS__ );
    }
}

?>
