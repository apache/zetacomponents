<?php
/**
 * File containing the ezcWebdavLockPluginOptionsTest class.
 * 
 * @package Webdav
 * @version //autogen//
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @subpackage Test
 */


/**
 * Test case for the ezcWebdavLockPluginOptions class.
 * 
 * @package Webdav
 * @version //autogen//
 * @subpackage Test
 */
class ezcWebdavLockPluginOptionsTest extends ezcTestCase
{
    public static function suite()
    {
		return new PHPUnit_Framework_TestSuite( __CLASS__ );
    }

    public function testConstructorSuccess()
    {
        $opt = new ezcWebdavLockPluginOptions();

        $this->assertAttributeEquals(
            array(
                'lockTimeout'         => 900,
                'backendLockTimeout'  => 10000000,
                'backendLockWaitTime' => 10000,
            ),
            'properties',
            $opt
        );

        $opt = new ezcWebdavLockPluginOptions(
            array(
                'lockTimeout'         => 123,
                'backendLockTimeout'  => 123456,
                'backendLockWaitTime' => 1234,
            )
        );

        $this->assertAttributeEquals(
            array(
                'lockTimeout'         => 123,
                'backendLockTimeout'  => 123456,
                'backendLockWaitTime' => 1234,
            ),
            'properties',
            $opt
        );
    }

    public function testSetAccessSuccess()
    {
        $opt = new ezcWebdavLockPluginOptions();

        $this->assertSetProperty(
            $opt,
            'lockTimeout',
            array( 1, 23, 42, 100000, 2147483647 )
        );
        $this->assertSetProperty(
            $opt,
            'backendLockTimeout',
            array( 1, 23, 42, 100000, 2147483647 )
        );
        $this->assertSetProperty(
            $opt,
            'backendLockWaitTime',
            array( 1, 23, 42, 100000, 2147483647 )
        );
    }

    public function testSetAccessFailure()
    {
        $opt = new ezcWebdavLockPluginOptions();

        $this->assertSetPropertyFails(
            $opt,
            'lockTimeout',
            array( 0, -42, true, false, 'foo', 23.42, array(), new stdClass() )
        );
        $this->assertSetPropertyFails(
            $opt,
            'backendLockTimeout',
            array( 0, -42, true, false, 'foo', 23.42, array(), new stdClass() )
        );
        $this->assertSetPropertyFails(
            $opt,
            'backendLockWaitTime',
            array( 0, -42, true, false, 'foo', 23.42, array(), new stdClass() )
        );
    }

    public function testGetAccessFailure()
    {
        $opt = new ezcWebdavLockPluginOptions();

        try
        {
            echo $opt->foo;
            $this->fail( 'Exception not thrown on get access to non-existent property.' );
        }
        catch( ezcBasePropertyNotFoundException $e ) {}
    }

    public function testIssetAccess()
    {
        $opt = new ezcWebdavLockPluginOptions();

        $this->assertTrue(
            isset( $opt->lockTimeout )
        );
        $this->assertTrue(
            isset( $opt->backendLockTimeout )
        );
        $this->assertTrue(
            isset( $opt->backendLockWaitTime )
        );
        $this->assertFalse(
            isset( $opt->foo )
        );
    }
}

?>
