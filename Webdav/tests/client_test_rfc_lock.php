<?php

require_once 'classes/transport_test_mock.php';
require_once 'classes/rfc_path_factory.php';
require_once 'client_test_rfc_lock_setup.php';

require_once 'client_test_suite.php';
require_once 'client_test.php';

class ezcWebdavClientRfcLockTest extends ezcWebdavClientTest
{
    private static $tokenReplacements = array();

    protected function setupTestEnvironment()
    {
        $this->setupClass = 'ezcWebdavClientTestRfcLockSetup';
        $this->dataFile   = dirname( __FILE__ ) . '/clients/rfc_lock.php';
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

        foreach ( self::$tokenReplacements as $from => $to )
        {
            if ( isset( $request['server']['HTTP_IF'] ) )
            {
                $request['server']['HTTP_IF'] = preg_replace(
                    '(' . preg_quote( $from ) . ')',
                    $to,
                    $request['server']['HTTP_IF']
                );
            }
            if ( isset( $request['server']['HTTP_LOCK_TOKEN'] ) )
            {
                $request['server']['HTTP_LOCK_TOKEN'] = preg_replace(
                    '(' . preg_quote( $from ) . ')',
                    $to,
                    $request['server']['HTTP_LOCK_TOKEN']
                );
            }
        }
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

        // Unify last access dates
        $realResponse['body'] = preg_replace(
            '([0-9]{4}-[0-9]{2}-[0-9]{2}[0-9T:+]+)',
            '2008-11-09T22:14:18+00:00',
            $realResponse['body']
        );
        $expectedResponse['body'] = preg_replace(
            '([0-9]{4}-[0-9]{2}-[0-9]{2}[0-9T:+]+)',
            '2008-11-09T22:14:18+00:00',
            $expectedResponse['body']
        );
    }
}

?>
