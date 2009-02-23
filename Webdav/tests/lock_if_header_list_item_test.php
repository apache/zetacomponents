<?php
/**
 * File containing the ezcWebdavFileBackendOptionsTestCase class.
 * 
 * @package Webdav
 * @version //autogen//
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
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

        $tokens = array(
            new ezcWebdavLockIfHeaderCondition( 'some lock token' ),
            new ezcWebdavLockIfHeaderCondition( 'another lock token', true )
        );
        $eTags  = array(
            new ezcWebdavLockIfHeaderCondition( 'tag 1', true ),
            new ezcWebdavLockIfHeaderCondition( 'tag 2' )
        );
        $item   = new ezcWebdavLockIfHeaderListItem( $tokens, $eTags );

        $this->assertEquals(
            $tokens,
            $item->lockTokens
        );
        $this->assertEquals(
            $eTags,
            $item->eTags
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
        $this->assertFalse(
            isset( $item->negated )
        );
        $this->assertFalse(
            isset( $item->foo )
        );
    }
}

?>
