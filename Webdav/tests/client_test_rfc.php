<?php

require_once 'classes/transport_test_mock.php';
require_once 'classes/rfc_path_factory.php';
require_once 'client_test_rfc_setup.php';

require_once 'client_test_suite.php';
require_once 'client_test.php';

class ezcWebdavClientRfcTest extends ezcWebdavClientTest
{
    protected function setupTestEnvironment()
    {
        $this->setupClass = 'ezcWebdavClientTestRfcSetup';
        $this->dataFile   = dirname( __FILE__ ) . '/clients/rfc.php';
    }

    public static function suite()
    {
        return new ezcWebdavClientTestSuite( __CLASS__ );
    }

    protected function adjustRequest( array &$request )
    {
        $serverBase = array(
            'DOCUMENT_ROOT'   => '/var/www/localhost/htdocs',
            'HTTP_USER_AGENT' => 'RFC compliant',
            'SCRIPT_FILENAME' => '/var/www/localhost/htdocs',
            'SERVER_NAME'     => 'webdav',
        );

        $request['server'] = array_merge( $serverBase, $request['server'] );
    }
}

?>
