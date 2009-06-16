<?php
/**
 * Basic test cases for the path factory class.
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

/**
 * Custom path factpory
 */
require_once 'classes/test_path_factory.php';

/**
 * Tests for ezcWebdavBasicPathFactory class.
 * 
 * @package Webdav
 * @subpackage Tests
 */
class ezcWebdavBasicPathFactoryTest extends ezcTestCase
{
	public static function suite()
	{
		return new PHPUnit_Framework_TestSuite( 'ezcWebdavBasicPathFactoryTest' );
	}

    public function testPathDispatchingWithoutBasePath()
    {
        $uri = '/collection/ressource';
        $fakePath = $uri;

        $factory = new ezcWebdavBasicPathFactory( 'http://example.com' );

        $this->assertEquals(
            $fakePath,
            $factory->parseUriToPath( $uri )
        );
    }

    public function testPathDispatchingWithBasePath()
    {
        $uri = '/my/webdav/base/collection/ressource';
        $fakePath = '/collection/ressource';

        $factory = new ezcWebdavBasicPathFactory( 'http://example.com/my/webdav/base' );

        $this->assertEquals(
            $fakePath,
            $factory->parseUriToPath( $uri )
        );
    }

    public function testPathDispatchingCollectionWithoutBasePath()
    {
        $uri = '/collection/another_coll/';
        $fakePath = '/collection/another_coll';

        $factory = new ezcWebdavBasicPathFactory( 'http://example.com' );

        $this->assertEquals(
            $fakePath,
            $factory->parseUriToPath( $uri )
        );
    }

    public function testPathDispatchingCollectionWithBasePath()
    {
        $uri = '/my/webdav/base/collection/another_coll';
        $fakePath = '/collection/another_coll';

        $factory = new ezcWebdavBasicPathFactory( 'http://example.com/my/webdav/base' );

        $this->assertEquals(
            $fakePath,
            $factory->parseUriToPath( $uri )
        );
    }
    
    public function testUriDispatchingWithoutBasePath()
    {
        $uri = 'http://example.com/collection/ressource';
        $fakePath = '/collection/ressource';

        $factory = new ezcWebdavBasicPathFactory( 'http://example.com' );

        $this->assertEquals(
            $fakePath,
            $factory->parseUriToPath( $uri )
        );
    }

    public function testUriDispatchingWithBasePath()
    {
        $uri = 'http://example.com/my/webdav/base/collection/ressource';
        $fakePath = '/collection/ressource';

        $factory = new ezcWebdavBasicPathFactory( 'http://example.com/my/webdav/base' );

        $this->assertEquals(
            $fakePath,
            $factory->parseUriToPath( $uri )
        );
    }

    public function testUriDispatchingCollectionWithoutBasePath()
    {
        $uri = 'http://example.com/collection/another_coll/';
        $fakePath = '/collection/another_coll';

        $factory = new ezcWebdavBasicPathFactory( 'http://example.com' );

        $this->assertEquals(
            $fakePath,
            $factory->parseUriToPath( $uri )
        );
    }

    public function testUriDispatchingCollectionWithBasePath()
    {
        $uri = 'http://example.com/my/webdav/base/collection/another_coll';
        $fakePath = '/collection/another_coll';

        $factory = new ezcWebdavBasicPathFactory( 'http://example.com/my/webdav/base' );

        $this->assertEquals(
            $fakePath,
            $factory->parseUriToPath( $uri )
        );
    }

    public function testUriDispatchingCollectionWithoutBasePathRestore()
    {
        $uri      = 'http://example.com/collection/another_coll/';
        $fakePath = '/collection/another_coll';
        $fakeUri  = $uri;

        $factory = new ezcWebdavBasicPathFactory( 'http://example.com' );

        $this->assertEquals(
            $fakePath,
            $factory->parseUriToPath( $uri ),
            'Parsing of URI failed.'
        );
        $this->assertEquals(
            $fakeUri,
            $factory->generateUriFromPath( $fakePath ),
            'Restoring of URI failed'
        );
    }

    public function testUriDispatchingCollectionWithBaseUriRestore()
    {
        $uri      = 'http://example.com/my/webdav/base/collection/another_coll/';
        $fakePath = '/collection/another_coll';
        $fakeUri  = $uri;

        $factory = new ezcWebdavBasicPathFactory( 'http://example.com/my/webdav/base' );

        $this->assertEquals(
            $fakePath,
            $factory->parseUriToPath( $uri ),
            'Parsing of URI failed.'
        );
        $this->assertEquals(
            $fakeUri,
            $factory->generateUriFromPath( $fakePath ),
            'Restoring of URI failed'
        );
    }

    // Issue #13389
    public function testCtorFailureUriWithoutScheme()
    {   
        try
        {
            $pathFactory = new ezcWebdavBasicPathFactory(
                '/some/path/without/uri'
            );
            $this->fail(
                'Exception not thrown on creation of basic path factory with invalid URI.'
            );
        }
        catch ( ezcWebdavBrokenBaseUriException $e ) {}
    }

    // Issue #13389
    public function testCtorFailureUriWithoutHost()
    {   
        try
        {
            $pathFactory = new ezcWebdavBasicPathFactory(
                'http:///some'
            );
            $this->fail(
                'Exception not thrown on creation of basic path factory with invalid URI.'
            );
        }
        catch ( ezcWebdavBrokenBaseUriException $e ) {}
    }

    // Issue #13389
    public function testCtorFailureBrokenUri()
    {   
        try
        {
            $pathFactory = new ezcWebdavBasicPathFactory(
                'http//some/foo/bar'
            );
            $this->fail(
                'Exception not thrown on creation of basic path factory with invalid URI.'
            );
        }
        catch ( ezcWebdavBrokenBaseUriException $e ) {}
    }

    public function testDispatchingWithBaseUriSlash()
    {
        $pathFactory = new ezcWebdavBasicPathFactory(
            'http://example.com/some/dir/'
        );

        $this->assertEquals(
            '/foo/bar',
            $pathFactory->parseUriToPath(
                'http://example.com/some/dir/foo/bar'
            )
        );
    }
}
?>
