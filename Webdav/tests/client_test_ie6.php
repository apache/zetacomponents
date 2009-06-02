<?php

require_once 'classes/transport_test_mock.php';
require_once 'client_test_continuous_setup.php';

require_once 'client_test_suite.php';
require_once 'client_test.php';

class ezcWebdavClientIE6Test extends ezcWebdavClientTest
{
    protected function setupTestEnvironment()
    {
        $this->setupClass = 'ezcWebdavClientTestContinuousSetup';
        $this->dataFile   = dirname( __FILE__ ) . '/clients/ie6.php';
    }

    public static function suite()
    {
        return new ezcWebdavClientTestSuite( __CLASS__ );
    }
}

?>
