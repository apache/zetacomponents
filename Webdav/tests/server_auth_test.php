<?php
/**
 * Test cases for the server authentication / authorization.
 *
 * @package Webdav
 * @subpackage Tests
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Reqiuire base test
 */
require_once 'test_case.php';

/**
 * Additional transport for testing. 
 */
require_once 'classes/transport_test_mock.php';

/**
 * Custom auth class. 
 */
require_once 'classes/test_auth.php';

/**
 * Tests for ezcWebdavServer class.
 * 
 * @package Webdav
 * @subpackage Tests
 */
class ezcWebdavServerAuthTest extends ezcWebdavTestCase
{
    private $serverBase = array(
        'DOCUMENT_ROOT'   => '/var/www/localhost/htdocs',
        'HTTP_USER_AGENT' => 'RFC compliant',
        'SCRIPT_FILENAME' => '/var/www/localhost/htdocs',
        'SERVER_NAME'     => 'webdav',
    );

	public static function suite()
	{
		return new PHPUnit_Framework_TestSuite( __CLASS__ );
	}

    public function setUp()
    {
        $srv = ezcWebdavServer::getInstance();
        $srv->reset();

        // Unset all configurations
        foreach ( $srv->configurations as $conf  )
        {
            unset( $srv->configurations[0] );
        }

        $srv->configurations[0] = new ezcWebdavServerConfiguration(
            '(.*)',  // Fits every request
            'ezcWebdavTransportTestMock'
        );
        $srv->configurations[0]->pathFactory = new ezcWebdavBasicPathFactory( 'http://webdav' );

        $srv->auth = new ezcWebdavTestAuth();
    }

    /**
     * testAuthentication 
     * 
     * @param mixed $input 
     * @param mixed $output 
     * @return void
     *
     * @dataProvider provideTestData
     */
    public function testAuthentication( $input, $output )
    {
        static $num = 0;
        $num++;

        $GLOBALS['EZC_WEBDAV_TRANSPORT_TEST_BODY'] = $input['body'];
        $_SERVER = array_merge( $this->serverBase, $input['server'] );

        $backend = $this->getBackend();
        
        ezcWebdavServer::getInstance()->handle( $backend );

        if ( isset( $GLOBALS['EZC_WEBDAV_TRANSPORT_TEST_RESPONSE_HEADERS']['WWW-Authenticate'] ) )
        {
            // Replace nounce value with standard one, since this should not be predictable
            $GLOBALS['EZC_WEBDAV_TRANSPORT_TEST_RESPONSE_HEADERS']['WWW-Authenticate']['digest'] = preg_replace(
                '(nonce="[^"]+")',
                'nonce="testnonce"',
                $GLOBALS['EZC_WEBDAV_TRANSPORT_TEST_RESPONSE_HEADERS']['WWW-Authenticate']['digest']
            );
        }

        $this->assertEquals(
            $output['status'],
            $GLOBALS['EZC_WEBDAV_TRANSPORT_TEST_RESPONSE_STATUS']
        );
        $this->assertEquals(
            $output['headers'],
            $GLOBALS['EZC_WEBDAV_TRANSPORT_TEST_RESPONSE_HEADERS']
        );
        $this->assertEquals(
            $output['body'],
            $GLOBALS['EZC_WEBDAV_TRANSPORT_TEST_RESPONSE_BODY']
        );
    }

    public static function provideTestData()
    {
        $dataFiles = glob( dirname( __FILE__ ) . '/data/auth/*.php' );

        $data = array();
        foreach ( $dataFiles as $dataFile )
        {
            $data[$dataFile] = require $dataFile;
        }

        return $data;
    }

    private function getBackend()
    {
        $backend = new ezcWebdavMemoryBackend();

        $backend->addContents(
            array(
                'a' => array(
                    'a1' => array(
                        'a11' => 'a11',
                        'a12' => 'a12',
                    ),
                    'a2' => 'a2',
                ),
                'b' => array(
                    'b1' => array(
                        'b11' => 'b11',
                        'b12' => 'b12',
                    ),
                    'b2' => 'b2',
                ),
                'c' => array(
                    'c1' => array(
                        'c11' => 'c11',
                        'c12' => 'c12',
                    ),
                    'c2' => 'c2',
                ),
            )
        );

        return $backend;
    }
}
?>
