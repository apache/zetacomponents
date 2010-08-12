<?php
/**
 * Basic test cases for the path factory class.
 *
 * Licensed to the Apache Software Foundation (ASF) under one
 * or more contributor license agreements.  See the NOTICE file
 * distributed with this work for additional information
 * regarding copyright ownership.  The ASF licenses this file
 * to you under the Apache License, Version 2.0 (the
 * "License"); you may not use this file except in compliance
 * with the License.  You may obtain a copy of the License at
 * 
 *   http://www.apache.org/licenses/LICENSE-2.0
 * 
 * Unless required by applicable law or agreed to in writing,
 * software distributed under the License is distributed on an
 * "AS IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS OF ANY
 * KIND, either express or implied.  See the License for the
 * specific language governing permissions and limitations
 * under the License.
 *
 * @package Webdav
 * @subpackage Tests
 * @version //autogentag//
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 */

/**
 * Reqiuire base test
 */

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
class ezcWebdavAutomaticPathFactoryTest extends ezcTestCase
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

    public function testGenerateHttpUriNoRewrite()
    {
        $_SERVER['SCRIPT_FILENAME'] = '/var/www/webdav/htdocs/path/to/webdav.php';
        $_SERVER['DOCUMENT_ROOT']   = '/var/www/webdav/htdocs/';
        $_SERVER['REQUEST_URI']     = '/path/to/webdav.php/collection/ressource';
        $_SERVER['HTTPS']           = 'off';
        $_SERVER['SERVER_NAME']     = 'webdav';
        $_SERVER['SERVER_PORT']     = '80';

        $factory = new ezcWebdavAutomaticPathFactory();
        $this->assertSame(
            'http://webdav/path/to/webdav.php/collection/ressource',
            $factory->generateUriFromPath( '/collection/ressource' )
        );
    }

    public function testGenerateHttpsUriNoRewrite()
    {
        $_SERVER['SCRIPT_FILENAME'] = '/var/www/webdav/htdocs/path/to/webdav.php';
        $_SERVER['DOCUMENT_ROOT']   = '/var/www/webdav/htdocs/';
        $_SERVER['REQUEST_URI']     = '/path/to/webdav.php/collection/ressource';
        $_SERVER['HTTPS']           = 'on';
        $_SERVER['SERVER_NAME']     = 'webdav';
        $_SERVER['SERVER_PORT']     = '443';

        $factory = new ezcWebdavAutomaticPathFactory();
        $this->assertSame(
            'https://webdav/path/to/webdav.php/collection/ressource',
            $factory->generateUriFromPath( '/collection/ressource' )
        );
    }
}
?>
