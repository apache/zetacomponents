<?php
/**
 * File containing the ezcWebdavFileBackendOptionsTestCase class.
 * 
 * @package Webdav
 * @version //autogen//
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @subpackage Test
 */

require_once dirname( __FILE__ ) . '/property_test.php';

/**
 * Test case for the ezcWebdavFileBackendOptions class.
 * 
 * @package Webdav
 * @version //autogen//
 * @subpackage Test
 */
class ezcWebdavLockIfHeaderListItemTest extends ezcWebdavTestCase
{
    public static function suite()
    {
		return new PHPUnit_Framework_TestSuite( __CLASS__ );
    }

    public function testConstructor()
    {
        $item = new ezcWebdavLockIfHeaderListItem();

        $this->assertEquals(
            array(),
            $item->lockTokens
        );
        $this->assertEquals(
            array(),
            $item->eTags
        );
        $this->assertFalse(
            $item->negated
        );

        $tokens = array( 'some lock token', 'another lock token' );
        $eTags  = array( 'tag 1', 'tag 2' );
        $item   = new ezcWebdavLockIfHeaderListItem( $tokens, $eTags, true );

        $this->assertEquals(
            $tokens,
            $item->lockTokens
        );
        $this->assertEquals(
            $eTags,
            $item->eTags
        );
        $this->assertTrue(
            $item->negated
        );
    }

    public function testSetAccessFailure()
    {
        $item = new ezcWebdavLockIfHeaderListItem();

        try
        {
            $item->lockTokens = array();
            $this->fail( 'Exception not thrown on set access to property $lockTokens.' );
        }
        catch ( ezcBasePropertyPermissionException $e ) {}

        try
        {
            $item->eTags = array();
            $this->fail( 'Exception not thrown on set access to property $eTags.' );
        }
        catch ( ezcBasePropertyPermissionException $e ) {}

        try
        {
            $item->negated = true;
            $this->fail( 'Exception not thrown on set access to property $negated.' );
        }
        catch ( ezcBasePropertyPermissionException $e ) {}

        try
        {
            $item->foo = 23;
            $this->fail( 'Exception not thrown on set access to property $foo.' );
        }
        catch ( ezcBasePropertyNotFoundException $e ) {}
    }

    public function testIssetAccess()
    {
        $item = new ezcWebdavLockIfHeaderListItem();
        
        $this->assertTrue(
            isset( $item->lockTokens )
        );
        $this->assertTrue(
            isset( $item->eTags )
        );
        $this->assertTrue(
            isset( $item->negated )
        );
        $this->assertFalse(
            isset( $item->foo )
        );
    }
}

?>
