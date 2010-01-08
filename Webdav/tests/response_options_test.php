<?php
/**
 * Basic test cases for the error response class.
 *
 * @package Webdav
 * @subpackage Tests
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2010 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Reqiuire base test
 */

/**
 * Tests for ezcWebdavErrorResonse class.
 * 
 * @package Webdav
 * @subpackage Tests
 */
class ezcWebdavOptionsResponseTest extends ezcTestCase
{
	public static function suite()
	{
		return new PHPUnit_Framework_TestSuite( 'ezcWebdavOptionsResponseTest' );
	}

    public function testResourceOptionsUnknownProperty()
    {
        $response = new ezcWebdavOptionsResponse();

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
        $response = new ezcWebdavOptionsResponse();

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
        $response = new ezcWebdavOptionsResponse();

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
        $response = new ezcWebdavOptionsResponse();

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

    public function testValidateHeadersSuccess()
    {
        $response = new ezcWebdavOptionsResponse();
        $response->setHeader( 'Server', 'Some/Server/Software' );

        $response->validateHeaders();
        $this->assertEquals(
            '1',
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
        $response = new ezcWebdavOptionsResponse();

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
