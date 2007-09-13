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
class ezcWebdavGetResponseTest extends ezcWebdavTestCase
{
	public static function suite()
	{
		return new PHPUnit_Framework_TestSuite( 'ezcWebdavGetResponseTest' );
	}

    public function testResourceGetUnknownProperty()
    {
        $response = new ezcWebdavGetResourceResponse(
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
        $response = new ezcWebdavGetResourceResponse(
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

    public function testCollectionGetUnknownProperty()
    {
        $response = new ezcWebdavGetCollectionResponse(
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
        $response = new ezcWebdavGetCollectionResponse(
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
        $response = new ezcWebdavGetResourceResponse(
            $resource = new ezcWebdavResource(
                '/path',
                new ezcWebdavPropertyStorage()
            )
        );

        $this->assertSame(
            $resource,
            $response->resource,
            'Wrong default value for property resource in class ezcWebdavGetResourceResponse.'
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

    public function testCollectionSetPropertyCollection()
    {
        $response = new ezcWebdavGetCollectionResponse(
            $collection = new ezcWebdavCollection(
                '/path',
                new ezcWebdavPropertyStorage()
            )
        );

        $this->assertSame(
            $collection,
            $response->collection,
            'Wrong default value for property collection in class ezcWebdavGetCollectionResponse.'
        );

        try
        {
            $response->collection = 200;
        }
        catch ( ezcBaseValueException $e )
        {
            return true;
        }

        $this->fail( 'Expected ezcBaseValueException.' );
    }
}
?>
