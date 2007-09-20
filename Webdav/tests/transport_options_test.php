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
class ezcWebdavTransportOptionsTest extends ezcWebdavTestCase
{
	public static function suite()
	{
		return new PHPUnit_Framework_TestSuite( 'ezcWebdavTransportOptionsTest' );
	}

    public function testTransportOptionsInServer()
    {
        $transport = new ezcWebdavTransport();

        $this->assertEquals(
            $transport->options,
            new ezcWebdavTransportOptions(),
            'Expected initially unmodified server options class.'
        );

        try
        {
            $transport->options->unknownProperty;
            $this->fail( 'Expected ezcBasePropertyNotFoundException.' );
        }
        catch ( ezcBasePropertyNotFoundException $e ) {}
    }

    public function testTransportOptionsSetInServer()
    {
        $transport = new ezcWebdavTransport();

        $options = new ezcWebdavTransportOptions();
        $transport->options = $options;

        $this->assertEquals(
            $transport->options->pathFactory,
            new ezcWebdavPathFactory()
        );

        $transport->options->pathFactory = new ezcWebdavAutomaticPathFactory();

        $this->assertEquals(
            $transport->options->pathFactory,
            new ezcWebdavAutomaticPathFactory()
        );

        try
        {
            $transport->unknownProperty = $options;
        }
        catch ( ezcBasePropertyNotFoundException $e )
        {
            return true;
        }

        $this->fail( 'Expected ezcBasePropertyNotFoundException.' );
    }

    public function testTransportOptionsUnknownRead()
    {
        $options = new ezcWebdavTransportOptions();

        try
        {
            $options->unknownProperty;
            $this->fail( 'Expected ezcBasePropertyNotFoundException.' );
        }
        catch ( ezcBasePropertyNotFoundException $e ) {}
    }

    public function testTransportOptionsUnknownWrite()
    {
        $options = new ezcWebdavTransportOptions();

        try
        {
            $options->unknownProperty = 42;
            $this->fail( 'Expected ezcBasePropertyNotFoundException.' );
        }
        catch ( ezcBasePropertyNotFoundException $e ) {}
    }

    public function testTransportOptionsPathFactory()
    {
        $options = new ezcWebdavTransportOptions();

        $this->assertEquals(
            new ezcWebdavPathFactory(),
            $options->pathFactory
        );

        $mockedPathFactory = $this->getMock( 'ezcWebdavPathFactory' );

        $options->pathFactory = $mockedPathFactory;
        $this->assertSame(
            $mockedPathFactory,
            $options->pathFactory
        );

        try
        {
            $options->pathFactory = 'ezcWebdavTransportOptions';
            $this->fail( 'Expected ezcBaseValueException.' );
        }
        catch ( ezcBaseValueException $e ) {}

    }
}
?>
