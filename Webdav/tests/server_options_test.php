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
 * Tests for ezcWebdavPathFactory class.
 * 
 * @package Webdav
 * @subpackage Tests
 */
class ezcWebdavServerOptionsTest extends ezcWebdavTestCase
{
	public static function suite()
	{
		return new PHPUnit_Framework_TestSuite( 'ezcWebdavServerOptionsTest' );
	}

    public function testServerOptionsInServer()
    {
        $server = new ezcWebdavServer();

        $this->assertEquals(
            $server->options,
            new ezcWebdavServerOptions(),
            'Expected initially unmodified server options class.'
        );

        $this->assertSame(
            $server->options->modSendfile,
            false,
            'Expected successfull access on option.'
        );

        try
        {
            // Read access
            $server->unknownProperty;
        }
        catch ( ezcBasePropertyNotFoundException $e )
        {
            return true;
        }

        $this->fail( 'Expected ezcBasePropertyNotFoundException.' );
    }

    public function testServerOptionsSetInServer()
    {
        $server = new ezcWebdavServer();

        $options = new ezcWebdavServerOptions();
        $options->modSendfile = true;

        $this->assertSame(
            $server->options->modSendfile,
            false,
            'Wrong initial value before changed option class.'
        );

        $server->options = $options;

        $this->assertSame(
            $server->options->modSendfile,
            true,
            'Expected modified value, because of changed option class.'
        );

        try
        {
            $server->unknownProperty = $options;
        }
        catch ( ezcBasePropertyNotFoundException $e )
        {
            return true;
        }

        $this->fail( 'Expected ezcBasePropertyNotFoundException.' );
    }

    public function testServerOptionsModSendfile()
    {
        $options = new ezcWebdavServerOptions();

        $this->assertSame(
            false,
            $options->modSendfile,
            'Wrong default value for property modSendfile in class ezcWebdavServerOptions.'
        );

        $options->modSendfile = true;
        $this->assertSame(
            true,
            $options->modSendfile,
            'Setting property value did not work for property modSendfile in class ezcWebdavServerOptions.'
        );

        try
        {
            $options->modSendfile = 42;
        }
        catch ( ezcBaseValueException $e )
        {
            return true;
        }

        $this->fail( 'Expected ezcBaseValueException.' );
    }

    public function testServerOptionsUnknownRead()
    {
        $options = new ezcWebdavServerOptions();

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

    public function testServerOptionsUnknownWrite()
    {
        $options = new ezcWebdavServerOptions();

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

    public function testServerOptionsPathFactory()
    {
        $options = new ezcWebdavServerOptions();

        $this->assertSame(
            'ezcWebdavPathFactory',
            $options->pathFactory,
            'Wrong default value for property pathFactory in class ezcWebdavServerOptions.'
        );

        $mockedPathFactory = $this->getMock( 'ezcWebdavPathFactory' );

        $options->pathFactory = get_class( $mockedPathFactory );
        $this->assertSame(
            get_class( $mockedPathFactory ),
            $options->pathFactory,
            'Setting property value did not work for property pathFactory in class ezcWebdavServerOptions.'
        );

        try
        {
            $options->pathFactory = 'ezcWebdavServerOptions';
        }
        catch ( ezcBaseValueException $e )
        {
            return true;
        }

        $this->fail( 'Expected ezcBaseValueException.' );
    }
}
?>
