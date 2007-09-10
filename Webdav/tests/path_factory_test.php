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

    public function testPathDispatchingWithoutScriptFileName()
    {
        $_SERVER['SCRIPT_FILENAME']     = null;
        $_SERVER['DOCUMENT_ROOT']       = '/var/www/webdav/htdocs/';
        $_SERVER['REQUEST_URI']         = '/webdav.php/collection/ressource';

        try
        {
            ezcWebdavPathFactory::parsePath( $_SERVER['REQUEST_URI'] );
        }
        catch ( ezcWebdavMissingServerVariableException $e )
        {
            return true;
        }

        $this->fail( 'ezcWebdavMissingServerVariableException expected.' );
    }

    public function testPathDispatchingWithoutDocumentRoot()
    {
        $_SERVER['SCRIPT_FILENAME']     = '/var/www/webdav/htdocs/webdav.php';
        $_SERVER['DOCUMENT_ROOT']       = null;
        $_SERVER['REQUEST_URI']         = '/webdav.php/collection/ressource';

        try
        {
            ezcWebdavPathFactory::parsePath( $_SERVER['REQUEST_URI'] );
        }
        catch ( ezcWebdavMissingServerVariableException $e )
        {
            return true;
        }

        $this->fail( 'ezcWebdavMissingServerVariableException expected.' );
    }

    public function testRootPathWithoutRewrite()
    {
        $_SERVER['SCRIPT_FILENAME']     = '/var/www/webdav/htdocs/webdav.php';
        $_SERVER['DOCUMENT_ROOT']       = '/var/www/webdav/htdocs/';
        $_SERVER['REQUEST_URI']         = '/webdav.php/collection/ressource';

        $this->assertSame(
            ezcWebdavPathFactory::parsePath( $_SERVER['REQUEST_URI'] ),
            '/collection/ressource'
        );
    }

    public function testRootPathWithoutRewriteDocrootMissingTrailingSlash()
    {
        $_SERVER['SCRIPT_FILENAME']     = '/var/www/webdav/htdocs/webdav.php';
        $_SERVER['DOCUMENT_ROOT']       = '/var/www/webdav/htdocs';
        $_SERVER['REQUEST_URI']         = '/webdav.php/collection/ressource';

        $this->assertSame(
            ezcWebdavPathFactory::parsePath( $_SERVER['REQUEST_URI'] ),
            '/collection/ressource'
        );
    }

    public function testRootPathWithoutRewriteWebdavRoot()
    {
        $_SERVER['SCRIPT_FILENAME']     = '/var/www/webdav/htdocs/webdav.php';
        $_SERVER['DOCUMENT_ROOT']       = '/var/www/webdav/htdocs/';
        $_SERVER['REQUEST_URI']         = '/webdav.php';

        $this->assertSame(
            ezcWebdavPathFactory::parsePath( $_SERVER['REQUEST_URI'] ),
            '/'
        );
    }

    public function testRootPathWithoutRewriteWebdavRootSlash()
    {
        $_SERVER['SCRIPT_FILENAME']     = '/var/www/webdav/htdocs/webdav.php';
        $_SERVER['DOCUMENT_ROOT']       = '/var/www/webdav/htdocs/';
        $_SERVER['REQUEST_URI']         = '/webdav.php/';

        $this->assertSame(
            ezcWebdavPathFactory::parsePath( $_SERVER['REQUEST_URI'] ),
            '/'
        );
    }

    public function testSubDirWithoutRewrite()
    {
        $_SERVER['SCRIPT_FILENAME']     = '/var/www/webdav/htdocs/path/to/webdav.php';
        $_SERVER['DOCUMENT_ROOT']       = '/var/www/webdav/htdocs/';
        $_SERVER['REQUEST_URI']         = '/path/to/webdav.php/collection/ressource';

        $this->assertSame(
            ezcWebdavPathFactory::parsePath( $_SERVER['REQUEST_URI'] ),
            '/collection/ressource'
        );
    }

    public function testSubDirWithoutRewriteDocrootMissingTrailingSlash()
    {
        $_SERVER['SCRIPT_FILENAME']     = '/var/www/webdav/htdocs/path/to/webdav.php';
        $_SERVER['DOCUMENT_ROOT']       = '/var/www/webdav/htdocs';
        $_SERVER['REQUEST_URI']         = '/path/to/webdav.php/collection/ressource';

        $this->assertSame(
            ezcWebdavPathFactory::parsePath( $_SERVER['REQUEST_URI'] ),
            '/collection/ressource'
        );
    }
    
    public function testSubDirWithoutRewriteWebdavRoot()
    {
        $_SERVER['SCRIPT_FILENAME']     = '/var/www/webdav/htdocs/path/to/webdav.php';
        $_SERVER['DOCUMENT_ROOT']       = '/var/www/webdav/htdocs/';
        $_SERVER['REQUEST_URI']         = '/path/to/webdav.php';

        $this->assertSame(
            ezcWebdavPathFactory::parsePath( $_SERVER['REQUEST_URI'] ),
            '/'
        );
    }

    public function testSubDirWithoutRewriteWebdavRootSlash()
    {
        $_SERVER['SCRIPT_FILENAME']     = '/var/www/webdav/htdocs/path/to/webdav.php';
        $_SERVER['DOCUMENT_ROOT']       = '/var/www/webdav/htdocs/';
        $_SERVER['REQUEST_URI']         = '/path/to/webdav.php/';

        $this->assertSame(
            ezcWebdavPathFactory::parsePath( $_SERVER['REQUEST_URI'] ),
            '/'
        );
    }

    public function testDispatchingWithRewrittenUri()
    {
        $_SERVER['SCRIPT_FILENAME']     = '/var/www/webdav/htdocs/path/to/webdav.php';
        $_SERVER['DOCUMENT_ROOT']       = '/var/www/webdav/htdocs/';
        $_SERVER['REQUEST_URI']         = '/path/to/webdav/collection/ressource';

        try
        {
            ezcWebdavPathFactory::parsePath( $_SERVER['REQUEST_URI'] );
        }
        catch ( ezcWebdavBrokenRequestUriException $e )
        {
            return true;
        }

        $this->fail( 'ezcWebdavBrokenRequestUriException expected.' );
    }

    public function testPathFactoryInServer()
    {
        $_SERVER['SCRIPT_FILENAME']     = '/var/www/webdav/htdocs/path/to/webdav.php';
        $_SERVER['DOCUMENT_ROOT']       = '/var/www/webdav/htdocs/';
        $_SERVER['REQUEST_URI']         = '/path/to/webdav.php/';

        $server = new ezcWebdavServer();

        $this->assertSame(
            $server->getParsedPath( $_SERVER['REQUEST_URI'] ),
            '/'
        );
    }

    public function testModifiedPathFactoryInServer()
    {
        $_SERVER['SCRIPT_FILENAME']     = '/var/www/webdav/htdocs/path/to/webdav.php';
        $_SERVER['DOCUMENT_ROOT']       = '/var/www/webdav/htdocs/';
        $_SERVER['REQUEST_URI']         = '/path/to/webdav.php/';

        $server = new ezcWebdavServer();

        $server->options->pathFactory = 'myTestPathFactory';

        $this->assertSame(
            $server->getParsedPath( $_SERVER['REQUEST_URI'] ),
            'This is only a test.'
        );
    }
}
?>
