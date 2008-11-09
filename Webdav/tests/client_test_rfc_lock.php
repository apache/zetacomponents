<?php

require_once 'classes/transport_test_mock.php';
require_once 'classes/rfc_path_factory.php';
require_once 'client_test_rfc_lock_setup.php';

require_once 'client_test_suite.php';
require_once 'client_test.php';

class ezcWebdavClientRfcLockTest extends ezcWebdavClientTest
{
    protected function setupTestEnvironment()
    {
        $this->setupClass = 'ezcWebdavClientTestRfcLockSetup';
        $this->dataDir    = dirname( __FILE__ ) . '/clients/rfc_lock';
    }

    public static function suite()
    {
        return new ezcWebdavClientTestSuite( __CLASS__ );
    }

    protected function adjustResponse( array &$realResponse, array &$expectedResponse )
    {
        if ( isset( $expectedResponse['headers']['Lock-Token'] ) && isset( $realResponse['headers']['Lock-Token'] ) )
        {
            $expectedResponse['body'] = preg_replace(
                '(' . preg_quote( $expectedResponse['headers']['Lock-Token'] ) . ')',
                $realResponse['headers']['Lock-Token'],
                $expectedResponse['body']
            );
            $expectedResponse['headers']['Lock-Token'] = $realResponse['headers']['Lock-Token'];
        }
    }
}

?>
