<?php
/**
 * Basic test cases for the server class.
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
 * Tests for ezcWebdavServer class.
 * 
 * @package Webdav
 * @subpackage Tests
 */
class ezcWebdavBasicServerTest extends ezcWebdavTestCase
{
	public static function suite()
	{
		return new PHPUnit_Framework_TestSuite( 'ezcWebdavBasicServerTest' );
	}

    public function testDefaultHandlerWithUnknowClient()
    {
        $_SERVER['HTTP_USER_AGENT'] = 'ezcUnknownClient';

        $webdav = new ezcWebdavServer();
        $webdav->handle();

        $this->assertEquals(
            $this->readAttribute( $webdav, 'transport' ),
            new ezcWebdavTransport(),
            'Fallback to ezcWebdavTransport expected.'
        );
    }

    public function testAddMockedTransport()
    {
        $_SERVER['HTTP_USER_AGENT'] = 'ezcMockedClient';

        $mockedTransport = $this->getMock( 'ezcWebdavTransport' );

        $webdav = new ezcWebdavServer();

        $count = count( $this->readAttribute( $webdav, 'transportHandlers' ) );
        $webdav->registerTransportHandler( 
            '(^ezcMockedClient$)', 
            get_class( $mockedTransport )
        );

        $this->assertEquals(
            $count + 1,
            count( $this->readAttribute( $webdav, 'transportHandlers' ) ),
            'Expected increased count of transport handlers.'
        );

        $transportHandlers = $this->readAttribute( $webdav, 'transportHandlers' );
        $this->assertEquals(
            reset( $transportHandlers ),
            get_class( $mockedTransport ),
            'Expected mocked transport handler to be first in list.'
        );

        $webdav->handle();

        $this->assertEquals(
            $this->readAttribute( $webdav, 'transport' ),
            $mockedTransport,
            'Mocked transport handler expected.'
        );
    }

    public function testRemoveTransport()
    {
        $_SERVER['HTTP_USER_AGENT'] = 'ezcUnknownClient';

        $webdav = new ezcWebdavServer();

        $count = count( $this->readAttribute( $webdav, 'transportHandlers' ) );
        $webdav->unregisterTransportHandler( 
            '(.*)'
        );

        $this->assertEquals(
            $count - 1,
            count( $this->readAttribute( $webdav, 'transportHandlers' ) ),
            'Expected decreased count of transport handlers.'
        );
    }

    public function testExceptionForUnhandledClient()
    {
        $_SERVER['HTTP_USER_AGENT'] = 'ezcUnknownClient';

        $webdav = new ezcWebdavServer();

        $webdav->unregisterTransportHandler( 
            '(.*)'
        );

        try
        {
            $webdav->handle();
        }
        catch ( ezcWebdavNotTransportHandlerException $e )
        {
            $this->assertEquals(
                $e->getMessage(),
                "Could not find any ezcWebdavTransport for the client 'ezcUnknownClient'."
            );

            return true;
        }

        $this->fail( 'Expected ezcWebdavNotTransportHandlerException.' );
    }
}
?>
