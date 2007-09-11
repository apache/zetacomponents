<?php
/**
 * Basic test cases for the error response class.
 *
 * @package Webdav
 * @subpackage Tests
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Reqiuire base test
 */
require_once 'test_case.php';

/**
 * Tests for ezcWebdavErrorResonse class.
 * 
 * @package Webdav
 * @subpackage Tests
 */
class ezcWebdavErrorResonseTest extends ezcWebdavTestCase
{
	public static function suite()
	{
		return new PHPUnit_Framework_TestSuite( 'ezcWebdavErrorResonseTest' );
	}

    public function testGetUnknownProperty()
    {
        $response = new ezcWebdavErrorResponse( ezcWebdavErrorResponse::STATUS_404 );

        try
        {
            // Read access
            $response->unknownProperty;
        }
        catch ( ezcBasePropertyNotFoundException $e )
        {
            return true;
        }

        $this->fail( 'Expected ezcBasePropertyNotFoundException.' );
    }

    public function testSetUnknownProperty()
    {
        $response = new ezcWebdavErrorResponse( ezcWebdavErrorResponse::STATUS_404 );

        try
        {
            $response->unknownProperty = 42;
        }
        catch ( ezcBasePropertyNotFoundException $e )
        {
            return true;
        }

        $this->fail( 'Expected ezcBasePropertyNotFoundException.' );
    }

    public function testErrorResponseOptionStatus()
    {
        $response = new ezcWebdavErrorResponse( ezcWebdavErrorResponse::STATUS_404 );

        $this->assertSame(
            ezcWebdavErrorResponse::STATUS_404,
            $response->status,
            'Wrong default value for property type in class ezcWebdavErrorResponse.'
        );

        try
        {
            $response->status = 200;
        }
        catch ( ezcBaseValueException $e )
        {
            return true;
        }

        $this->fail( 'Expected ezcBaseValueException.' );
    }

    public function testErrorResponseOptionRequestUri()
    {
        $response = new ezcWebdavErrorResponse( ezcWebdavErrorResponse::STATUS_404, '/requested' );

        $this->assertSame(
            '/requested',
            $response->requestUri,
            'Wrong default value for property requestUri in class ezcWebdavErrorResponse.'
        );

        $response->requestUri = '/foo';
        $this->assertSame(
            '/foo',
            $response->requestUri,
            'Setting property value did not work for property requestUri in class ezcWebdavErrorResponse.'
        );

        try
        {
            $response->requestUri = false;
        }
        catch ( ezcBaseValueException $e )
        {
            return true;
        }

        $this->fail( 'Expected ezcBaseValueException.' );
    }

    public function testErrorResponseToString()
    {
        $response = new ezcWebdavErrorResponse( ezcWebdavErrorResponse::STATUS_404, '/requested' );

        $this->assertSame(
            'HTTP/1.1 404 Not Found',
            (string) $response
        );
    }
}
?>
