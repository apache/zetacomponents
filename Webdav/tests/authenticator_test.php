<?php
/**
 * Test case for the ezcWebdavAuthenticator class.
 *
 * @package Webdav
 * @subpackage Tests
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Reqiuire base test
 */

require_once 'Webdav/tests/classes/test_auth.php';

/**
 * Tests for ezcWebdavAuthenticator class.
 * 
 * @package Webdav
 * @subpackage Tests
 */
class ezcWebdavAuthenticatorTest extends ezcTestCase
{
    private $oldServer;

    public static function suite()
    {
		return new PHPUnit_Framework_TestSuite( __CLASS__ );
    }

    public function testAnonymousAuth()
    {
        $auth = new ezcWebdavTestAuth();
        
        $this->assertEquals(
            true,
            $auth->authenticateAnonymous( new ezcWebdavAnonymousAuth() )
        );
    }
    
    /**
     * testBasicAuth 
     * 
     * @param ezcWebdavBasicAuth $data 
     * @param mixed $result 
     * @return void
     *
     * @dataProvider provideBasicAuthSets
     */
    public function testBasicAuth( ezcWebdavBasicAuth $data, $result )
    {
        $auth = new ezcWebdavTestAuth();
        
        $this->assertEquals(
            $result,
            $auth->authenticateBasic( $data )
        );
    }

    /**
     * testDigestAuth 
     * 
     * @param ezcWebdavDigestAuth $data 
     * @param mixed $result 
     * @return void
     *
     * @dataProvider provideDigestAuthSets
     */
    public function testDigestAuth( ezcWebdavDigestAuth $data, $result )
    {
        $auth = new ezcWebdavTestAuth();
        
        $this->assertEquals(
            $result,
            $auth->authenticateDigest( $data )
        );
    }

    public static function provideBasicAuthSets()
    {
        return array(
            array( new ezcWebdavBasicAuth( 'foo', 'bar' ), true ),
            array( new ezcWebdavBasicAuth( 'some', 'thing' ), true ),
            array( new ezcWebdavBasicAuth( '23', '42' ), true ),
            array( new ezcWebdavBasicAuth( 'in', 'valid' ), false ),
        );
    }

    public static function provideDigestAuthSets()
    {
        return array(
            array(
                new ezcWebdavDigestAuth(
                    'GET',
                    'Mufasa',
                    'testrealm@host.com',
                    'dcd98b7102dd2f0e8b11d0f600bfb0c093',
                    '/dir/index.html',
                    '6629fae49393a05397450978507c4ef1',
                    'MD5',
                    'auth',
                    '00000001',
                    '0a4f113b',
                    '5ccc069c403ebaf9f0171e9517f40e41'
                ),
                true,
            ),
        );
    }


}



?>
