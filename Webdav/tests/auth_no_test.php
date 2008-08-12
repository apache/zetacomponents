<?php
/**
 * Test case for the ezcWebdavNoAuth class.
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
 * Tests for ezcWebdavNoAuth class.
 * 
 * @package Webdav
 * @subpackage Tests
 */
class ezcWebdavNoAuthTest extends ezcWebdavTestCase
{
    public static function suite()
    {
		return new PHPUnit_Framework_TestSuite( __CLASS__ );
    }

    public function testAuthenticateEmpty()
    {
        $auth = new ezcWebdavNoAuth();

        $this->assertTrue(
            $auth->authenticate( '', '' )
        );
    }

    public function testAuthenticateEmptyPassword()
    {
        $auth = new ezcWebdavNoAuth();

        $this->assertTrue(
            $auth->authenticate( 'foo', '' )
        );
    }

    public function testAuthenticate()
    {
        $auth = new ezcWebdavNoAuth();

        $this->assertTrue(
            $auth->authenticate( 'foo', 'bar' )
        );
    }

    public function testAuthorizeDefaultAccess()
    {
        $auth = new ezcWebdavNoAuth();

        $this->assertTrue(
            $auth->authorize( 'foo', '/bar' )
        );
    }

    public function testAuthorizeReadAccess()
    {
        $auth = new ezcWebdavNoAuth();

        $this->assertTrue(
            $auth->authorize( 'foo', '/bar', ezcWebdavNoAuth::ACCESS_READ )
        );
    }

    public function testAuthorizeWriteAccess()
    {
        $auth = new ezcWebdavNoAuth();

        $this->assertTrue(
            $auth->authorize( 'foo', '/bar', ezcWebdavNoAuth::ACCESS_WRITE )
        );
    }
}

?>
