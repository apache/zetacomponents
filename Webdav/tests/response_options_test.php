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
class ezcWebdavOptionsResponseTest extends ezcWebdavTestCase
{
	public static function suite()
	{
		return new PHPUnit_Framework_TestSuite( 'ezcWebdavOptionsResponseTest' );
	}

    public function testResourceOptionsUnknownProperty()
    {
        $response = new ezcWebdavOptionsResponse(
            new ezcWebdavResource(
                '/path',
                new ezcWebdavPropertyStorage()
            )
        );

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

    public function testResourceSetUnknownProperty()
    {
        $response = new ezcWebdavOptionsResponse(
            new ezcWebdavResource(
                '/path',
                new ezcWebdavPropertyStorage()
            )
        );

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

    public function testCollectionOptionsUnknownProperty()
    {
        $response = new ezcWebdavOptionsResponse(
            new ezcWebdavCollection(
                '/path',
                new ezcWebdavPropertyStorage(),
                array()
            )
        );

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

    public function testCollectionSetUnknownProperty()
    {
        $response = new ezcWebdavOptionsResponse(
            new ezcWebdavCollection(
                '/path',
                new ezcWebdavPropertyStorage(),
                array()
            )
        );

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

    public function testResourceSetPropertyResource()
    {
        $response = new ezcWebdavOptionsResponse(
            $resource = new ezcWebdavResource(
                '/path',
                new ezcWebdavPropertyStorage()
            )
        );

        $this->assertSame(
            $resource,
            $response->resource,
            'Wrong default value for property resource in class ezcWebdavOptionsResponse.'
        );

        try
        {
            $response->resource = 200;
        }
        catch ( ezcBaseValueException $e )
        {
            return true;
        }

        $this->fail( 'Expected ezcBaseValueException.' );
    }

    public function testValidateHeadersSuccess()
    {
        $response = new ezcWebdavOptionsResponse(
            $resource = new ezcWebdavResource(
                '/path',
                new ezcWebdavPropertyStorage()
            )
        );

        $response->validateHeaders();
        $this->assertEquals(
            '1, 2, 1#extended',
            $response->getHeader( 'DAV' )
        );

        $response->setHeader( 'DAV', '1, 1#extended' );

        $response->validateHeaders();
        $this->assertEquals(
            '1, 1#extended',
            $response->getHeader( 'DAV' )
        );

        $response->setHeader( 'DAV', '1   ,    2,1#extended' );

        $response->validateHeaders();
        $this->assertEquals(
            '1, 2, 1#extended',
            $response->getHeader( 'DAV' )
        );

        $response->setHeader( 'DAV', '1' );

        $response->validateHeaders();
        $this->assertEquals(
            '1',
            $response->getHeader( 'DAV' )
        );
    }

    public function testValidateHeadersFailure()
    {
        $response = new ezcWebdavOptionsResponse(
            $resource = new ezcWebdavResource(
                '/path',
                new ezcWebdavPropertyStorage()
            )
        );

        $response->setHeader( 'DAV', null );

        try
        {
            $response->validateHeaders();
            $this->fail( "Exception not thrown on missing header 'DAV'." );
        }
        catch ( ezcWebdavMissingHeaderException $e ) {}

        $response->setHeader( 'DAV', '1, 2#extended' );

        try
        {
            $response->validateHeaders();
            $this->fail( "Exception not thrown on invalid header 'DAV'." );
        }
        catch ( ezcWebdavInvalidHeaderException $e ) {}
    }

}
?>
