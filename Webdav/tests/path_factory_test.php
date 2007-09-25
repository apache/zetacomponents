<?php
/**
 * Basic test cases for the path factory class.
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
 * Custom path factpory
 */
require_once 'classes/custom_path_factory.php';

/**
 * Tests for ezcWebdavPathFactory class.
 * 
 * @package Webdav
 * @subpackage Tests
 */
class ezcWebdavPathFactoryTest extends ezcWebdavTestCase
{
	public static function suite()
	{
		return new PHPUnit_Framework_TestSuite( 'ezcWebdavPathFactoryTest' );
	}

    public function testPathDispatchingWithoutBasePath()
    {
        $uri = '/collection/ressource';
        $fakePath = $uri;

        $factory = new ezcWebdavPathFactory( 'http://example.com' );

        $this->assertEquals(
            $fakePath,
            $factory->parseUriToPath( $uri )
        );
    }

    public function testPathDispatchingWithBasePath()
    {
        $uri = '/my/webdav/base/collection/ressource';
        $fakePath = '/collection/ressource';

        $factory = new ezcWebdavPathFactory( 'http://example.com/my/webdav/base' );

        $this->assertEquals(
            $fakePath,
            $factory->parseUriToPath( $uri )
        );
    }

    public function testPathDispatchingCollectionWithoutBasePath()
    {
        $uri = '/collection/another_coll/';
        $fakePath = '/collection/another_coll';

        $factory = new ezcWebdavPathFactory( 'http://example.com' );

        $this->assertEquals(
            $fakePath,
            $factory->parseUriToPath( $uri )
        );
    }

    public function testPathDispatchingCollectionWithBasePath()
    {
        $uri = '/my/webdav/base/collection/another_coll';
        $fakePath = '/collection/another_coll';

        $factory = new ezcWebdavPathFactory( 'http://example.com/my/webdav/base' );

        $this->assertEquals(
            $fakePath,
            $factory->parseUriToPath( $uri )
        );
    }
    
    public function testUriDispatchingWithoutBasePath()
    {
        $uri = 'http://example.com/collection/ressource';
        $fakePath = '/collection/ressource';

        $factory = new ezcWebdavPathFactory( 'http://example.com' );

        $this->assertEquals(
            $fakePath,
            $factory->parseUriToPath( $uri )
        );
    }

    public function testUriDispatchingWithBasePath()
    {
        $uri = 'http://example.com/my/webdav/base/collection/ressource';
        $fakePath = '/collection/ressource';

        $factory = new ezcWebdavPathFactory( 'http://example.com/my/webdav/base' );

        $this->assertEquals(
            $fakePath,
            $factory->parseUriToPath( $uri )
        );
    }

    public function testUriDispatchingCollectionWithoutBasePath()
    {
        $uri = 'http://example.com/collection/another_coll/';
        $fakePath = '/collection/another_coll';

        $factory = new ezcWebdavPathFactory( 'http://example.com' );

        $this->assertEquals(
            $fakePath,
            $factory->parseUriToPath( $uri )
        );
    }

    public function testUriDispatchingCollectionWithBasePath()
    {
        $uri = 'http://example.com/my/webdav/base/collection/another_coll';
        $fakePath = '/collection/another_coll';

        $factory = new ezcWebdavPathFactory( 'http://example.com/my/webdav/base' );

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

        $factory = new ezcWebdavPathFactory( 'http://example.com' );

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

        $factory = new ezcWebdavPathFactory( 'http://example.com/my/webdav/base' );

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
}
?>
