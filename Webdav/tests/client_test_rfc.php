<?php

require_once 'classes/transport_test_mock.php';

require_once 'client_test_suite.php';
require_once 'client_test.php';

class ezcWebdavClientRfcTest extends ezcWebdavClientTest
{
    protected function setupTestEnvironment()
    {
        $this->transportClass = 'ezcWebdavTransportTestMock';
        $this->dataDir        = dirname( __FILE__ ) . '/clients/rfc';
    }

    public static function suite()
    {
        return new ezcWebdavClientTestSuite( __CLASS__ );
    }
}

?>
