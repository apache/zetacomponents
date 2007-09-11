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
        new ezcWebdavErrorResponse( 404 );
        
        $options = new ezcWebdavErrorResponse( ezcWebdavErrorResponse::STATUS_404 );

        try
        {
            // Read access
            $options->unknownProperty;
        }
        catch ( ezcBasePropertyNotFoundException $e )
        {
            return true;
        }

        $this->fail( 'Expected ezcBasePropertyNotFoundException.' );
    }

    public function testSetUnknownProperty()
    {
        $options = new ezcWebdavErrorResponse( ezcWebdavErrorResponse::STATUS_404 );

        try
        {
            $options->unknownProperty = 42;
        }
        catch ( ezcBasePropertyNotFoundException $e )
        {
            return true;
        }

        $this->fail( 'Expected ezcBasePropertyNotFoundException.' );
    }

    public function testErrorResponseOptionStatus()
    {
        $options = new ezcWebdavErrorResponse( ezcWebdavErrorResponse::STATUS_404 );

        $this->assertSame(
            ezcWebdavErrorResponse::STATUS_404,
            $options->status,
            'Wrong default value for property type in class ezcWebdavErrorResponse.'
        );

        try
        {
            $options->status = 200;
        }
        catch ( ezcBaseValueException $e )
        {
            return true;
        }

        $this->fail( 'Expected ezcBaseValueException.' );
    }

    public function testErrorResponseOptionRequestUri()
    {
        $options = new ezcWebdavErrorResponse(ezcWebdavErrorResponse::STATUS_404, '/requested' );

        $this->assertSame(
            '/requested',
            $options->requestUri,
            'Wrong default value for property requestUri in class ezcWebdavErrorResponse.'
        );

        $options->requestUri = '/foo';
        $this->assertSame(
            '/foo',
            $options->requestUri,
            'Setting property value did not work for property requestUri in class ezcWebdavErrorResponse.'
        );

        try
        {
            $options->requestUri = false;
        }
        catch ( ezcBaseValueException $e )
        {
            return true;
        }

        $this->fail( 'Expected ezcBaseValueException.' );
    }

    public function testErrorResponseToString()
    {
        $options = new ezcWebdavErrorResponse(ezcWebdavErrorResponse::STATUS_404, '/requested' );

        $this->assertSame(
            'HTTP/1.1 404 Not Found',
            (string) $options
        );
    }
}
?>
