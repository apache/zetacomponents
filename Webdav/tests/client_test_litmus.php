<?php

require_once 'classes/transport_test_mock.php';
require_once 'classes/rfc_path_factory.php';
require_once 'client_test_continuous_setup.php';

require_once 'client_test_suite.php';
require_once 'client_test.php';

class ezcWebdavClientLitmusTest extends ezcWebdavClientTest
{
    protected function setupTestEnvironment()
    {
        $this->setupClass = 'ezcWebdavClientTestContinuousSetup';
        $this->dataFile   = dirname( __FILE__ ) . '/clients/litmus.php';
    }

    public static function suite()
    {
        return new ezcWebdavClientTestSuite( __CLASS__ );
    }
}

?>
