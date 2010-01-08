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
 * Tests for ezcWebdavLockResponse class.
 * 
 * @package Webdav
 * @subpackage Tests
 */
class ezcWebdavLockResponseTest extends ezcTestCase
{
	public static function suite()
	{
		return new PHPUnit_Framework_TestSuite( 'ezcWebdavLockResponseTest' );
	}

    public function testGetUnknownProperty()
    {
        $lockDiscovery = new ezcWebdavLockDiscoveryProperty();
        $response      = new ezcWebdavLockResponse( $lockDiscovery );

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

    public function testSetUnknownProperty()
    {
        $lockDiscovery = new ezcWebdavLockDiscoveryProperty();
        $response      = new ezcWebdavLockResponse( $lockDiscovery );

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

    public function testLockResponsePropertyLockDiscovery()
    {
        $lockDiscovery = new ezcWebdavLockDiscoveryProperty();
        $response      = new ezcWebdavLockResponse( $lockDiscovery );

        $this->assertSame(
            $lockDiscovery,
            $response->lockDiscovery,
            'Wrong default value for property type in class ezcWebdavLockResponse.'
        );

        try
        {
            $response->lockDiscovery = 34650;
        }
        catch ( ezcBaseValueException $e )
        {
            return true;
        }

        $this->fail( 'Expected ezcBaseValueException.' );
    }

    public function testLockResponseConstructor()
    {
        $lockDiscovery = new ezcWebdavLockDiscoveryProperty();
        $response      = new ezcWebdavLockResponse( $lockDiscovery, 'some lock token' );

        $response->setHeader( 'Server', 'Some server' );
        $response->validateHeaders();

        $this->assertEquals(
            'some lock token',
            $response->getHeader( 'Lock-Token' )
        );
    }

    public function testLockResponseToString()
    {
        $lockDiscovery = new ezcWebdavLockDiscoveryProperty();
        $response      = new ezcWebdavLockResponse( $lockDiscovery, 'some lock token' );

        $this->assertSame(
            'HTTP/1.1 200 OK',
            (string) $response
        );
    }
}
?>
