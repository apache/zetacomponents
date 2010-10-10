<?php
/**
 * Test cases for the server authentication / authorization.
 *
 * Licensed to the Apache Software Foundation (ASF) under one
 * or more contributor license agreements.  See the NOTICE file
 * distributed with this work for additional information
 * regarding copyright ownership.  The ASF licenses this file
 * to you under the Apache License, Version 2.0 (the
 * "License"); you may not use this file except in compliance
 * with the License.  You may obtain a copy of the License at
 * 
 *   http://www.apache.org/licenses/LICENSE-2.0
 * 
 * Unless required by applicable law or agreed to in writing,
 * software distributed under the License is distributed on an
 * "AS IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS OF ANY
 * KIND, either express or implied.  See the License for the
 * specific language governing permissions and limitations
 * under the License.
 *
 * @package Webdav
 * @subpackage Tests
 * @version //autogentag//
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 */

/**
 * Reqiuire base test
 */

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
class ezcWebdavServerAuthTest extends ezcTestCase
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
        $numConfigs = count( $srv->configurations );
        for ( $i = $numConfigs - 1; $i >= 0; --$i )
        {
            unset( $srv->configurations[$i] );
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

        ezcWebdavTestTransportInjector::$requestBody = $input['body'];
        $_SERVER = array_merge( $this->serverBase, $input['server'] );

        $backend = $this->getBackend();
        
        ezcWebdavServer::getInstance()->handle( $backend );

        if ( isset( ezcWebdavTestTransportInjector::$responseHeaders['WWW-Authenticate'] ) )
        {
            // Replace nounce value with standard one, since this should not be predictable
            ezcWebdavTestTransportInjector::$responseHeaders['WWW-Authenticate']['digest'] = preg_replace(
                '(nonce="[^"]+")',
                'nonce="testnonce"',
                ezcWebdavTestTransportInjector::$responseHeaders['WWW-Authenticate']['digest']
            );
        }
        
        // Check for broken DateTime in PHP versions (timestamp time zone issue)
        if ( version_compare( PHP_VERSION, '5.2.6', '<' ) )
        {
            if ( $input['server']['REQUEST_METHOD'] === 'PROPFIND' )
            {
                // PROPFIND responses contain dates in XML
                $this->markTestSkipped( 'PHP DateTime broken in versions < 5.2.6' );
                return;
            }
            if ( isset( $output['headers']['ETag'] ) )
            {
                unset( $output['headers']['ETag'] );
                unset( ezcWebdavTestTransportInjector::$responseHeaders['ETag'] );
            }
        }


        $this->assertEquals(
            $output['status'],
            ezcWebdavTestTransportInjector::$responseStatus
        );
        $this->assertEquals(
            $output['headers'],
            ezcWebdavTestTransportInjector::$responseHeaders
        );
        $this->assertEquals(
            $output['body'],
            ezcWebdavTestTransportInjector::$responseBody
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
