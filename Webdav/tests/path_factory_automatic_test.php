<?php
/**
 * Basic test cases for the path factory class.
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
 * Custom path factpory
 */
require_once 'classes/test_path_factory.php';

/**
 * Tests for ezcWebdavAutomaticPathFactory class.
 * 
 * @package Webdav
 * @subpackage Tests
 */
class ezcWebdavAutomaticPathFactoryTest extends ezcWebdavTestCase
{
	public static function suite()
	{
		return new PHPUnit_Framework_TestSuite( 'ezcWebdavAutomaticPathFactoryTest' );
	}

    public function testPathDispatchingWithoutScriptFileName()
    {
        $_SERVER['SCRIPT_FILENAME']     = null;
        $_SERVER['DOCUMENT_ROOT']       = '/var/www/webdav/htdocs/';
        $_SERVER['REQUEST_URI']         = '/webdav.php/collection/ressource';

        try
        {
            $factory = new ezcWebdavAutomaticPathFactory();
            $factory->parseUriToPath( $_SERVER['REQUEST_URI'] );

            $this->fail( 'ezcWebdavMissingServerVariableException expected.' );
        }
        catch ( ezcWebdavMissingServerVariableException $e ) {}
    }

    public function testPathDispatchingWithoutDocumentRoot()
    {
        $_SERVER['SCRIPT_FILENAME']     = '/var/www/webdav/htdocs/webdav.php';
        $_SERVER['DOCUMENT_ROOT']       = null;
        $_SERVER['REQUEST_URI']         = '/webdav.php/collection/ressource';

        try
        {
            $factory = new ezcWebdavAutomaticPathFactory();
            $factory->parseUriToPath( $_SERVER['REQUEST_URI'] );

            $this->fail( 'ezcWebdavMissingServerVariableException expected.' );
        }
        catch ( ezcWebdavMissingServerVariableException $e ) {}
    }

    public function testRootPathWithoutRewrite()
    {
        $_SERVER['SCRIPT_FILENAME']     = '/var/www/webdav/htdocs/webdav.php';
        $_SERVER['DOCUMENT_ROOT']       = '/var/www/webdav/htdocs/';
        $_SERVER['REQUEST_URI']         = '/webdav.php/collection/ressource';

        $factory = new ezcWebdavAutomaticPathFactory();
        $this->assertSame(
            '/collection/ressource',
            $factory->parseUriToPath( $_SERVER['REQUEST_URI'] )
        );
    }

    public function testRootPathWithoutRewriteDocrootMissingTrailingSlash()
    {
        $_SERVER['SCRIPT_FILENAME']     = '/var/www/webdav/htdocs/webdav.php';
        $_SERVER['DOCUMENT_ROOT']       = '/var/www/webdav/htdocs';
        $_SERVER['REQUEST_URI']         = '/webdav.php/collection/ressource';

        $factory = new ezcWebdavAutomaticPathFactory();
        $this->assertSame(
            '/collection/ressource',
            $factory->parseUriToPath( $_SERVER['REQUEST_URI'] )
        );
    }

    public function testRootPathWithoutRewriteWebdavRoot()
    {
        $_SERVER['SCRIPT_FILENAME']     = '/var/www/webdav/htdocs/webdav.php';
        $_SERVER['DOCUMENT_ROOT']       = '/var/www/webdav/htdocs/';
        $_SERVER['REQUEST_URI']         = '/webdav.php';

        $factory = new ezcWebdavAutomaticPathFactory();
        $this->assertSame(
            '/',
            $factory->parseUriToPath( $_SERVER['REQUEST_URI'] )
        );
    }

    public function testRootPathWithoutRewriteWebdavRootSlash()
    {
        $_SERVER['SCRIPT_FILENAME']     = '/var/www/webdav/htdocs/webdav.php';
        $_SERVER['DOCUMENT_ROOT']       = '/var/www/webdav/htdocs/';
        $_SERVER['REQUEST_URI']         = '/webdav.php/';

        $factory = new ezcWebdavAutomaticPathFactory();
        $this->assertSame(
            '/',
            $factory->parseUriToPath( $_SERVER['REQUEST_URI'] )
        );
    }

    public function testSubDirWithoutRewrite()
    {
        $_SERVER['SCRIPT_FILENAME']     = '/var/www/webdav/htdocs/path/to/webdav.php';
        $_SERVER['DOCUMENT_ROOT']       = '/var/www/webdav/htdocs/';
        $_SERVER['REQUEST_URI']         = '/path/to/webdav.php/collection/ressource';

        $factory = new ezcWebdavAutomaticPathFactory();
        $this->assertSame(
            '/collection/ressource',
            $factory->parseUriToPath( $_SERVER['REQUEST_URI'] )
        );
    }

    public function testSubDirWithoutRewriteDocrootMissingTrailingSlash()
    {
        $_SERVER['SCRIPT_FILENAME']     = '/var/www/webdav/htdocs/path/to/webdav.php';
        $_SERVER['DOCUMENT_ROOT']       = '/var/www/webdav/htdocs';
        $_SERVER['REQUEST_URI']         = '/path/to/webdav.php/collection/ressource';

        $factory = new ezcWebdavAutomaticPathFactory();
        $this->assertSame(
            '/collection/ressource',
            $factory->parseUriToPath( $_SERVER['REQUEST_URI'] )
        );
    }
    
    public function testSubDirWithoutRewriteWebdavRoot()
    {
        $_SERVER['SCRIPT_FILENAME']     = '/var/www/webdav/htdocs/path/to/webdav.php';
        $_SERVER['DOCUMENT_ROOT']       = '/var/www/webdav/htdocs/';
        $_SERVER['REQUEST_URI']         = '/path/to/webdav.php';

        $factory = new ezcWebdavAutomaticPathFactory();
        $this->assertSame(
            '/',
            $factory->parseUriToPath( $_SERVER['REQUEST_URI'] )
        );
    }

    public function testSubDirWithoutRewriteWebdavRootSlash()
    {
        $_SERVER['SCRIPT_FILENAME']     = '/var/www/webdav/htdocs/path/to/webdav.php';
        $_SERVER['DOCUMENT_ROOT']       = '/var/www/webdav/htdocs/';
        $_SERVER['REQUEST_URI']         = '/path/to/webdav.php/';

        $factory = new ezcWebdavAutomaticPathFactory();
        $this->assertSame(
            '/',
            $factory->parseUriToPath( $_SERVER['REQUEST_URI'] )
        );
    }

    public function testDispatchingWithRewrittenUri()
    {
        $_SERVER['SCRIPT_FILENAME']     = '/var/www/webdav/htdocs/path/to/webdav.php';
        $_SERVER['DOCUMENT_ROOT']       = '/var/www/webdav/htdocs/';
        $_SERVER['REQUEST_URI']         = '/path/to/webdav/collection/ressource';

        $factory = new ezcWebdavAutomaticPathFactory();
        $this->assertEquals(
            '/webdav/collection/ressource',
            $factory->parseUriToPath( $_SERVER['REQUEST_URI'] )
        );
    }
}
?>
