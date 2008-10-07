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
class ezcWebdavLockIfHeaderNoTagListTest extends ezcWebdavTestCase
{
    public static function suite()
    {
		return new PHPUnit_Framework_TestSuite( __CLASS__ );
    }

    public function testConstructor()
    {
        $item = new ezcWebdavLockIfHeaderListItem();
        $list = new ezcWebdavLockIfHeaderNoTagList( $item );

        $this->assertAttributeSame(
            $item,
            'item',
            $list
        );
    }

    public function testOffsetSetFailure()
    {
        $item = new ezcWebdavLockIfHeaderListItem();
        $list = new ezcWebdavLockIfHeaderNoTagList( $item );

        try
        {
            $list['/some/path'] = 23;
            $this->fail( 'Exception not thrown on set access.' );
        }
        catch ( RuntimeException $e ) {}

        $this->assertAttributeSame(
            $item,
            'item',
            $list
        );
    }

    public function testOffsetGetSuccess()
    {
        $item = new ezcWebdavLockIfHeaderListItem();
        $list = new ezcWebdavLockIfHeaderNoTagList( $item );
        
        $this->assertEquals(
            $item,
            $list['/some/path']
        );
        $this->assertEquals(
            $item,
            $list['/']
        );
    }

    public function testOffsetGetFailure()
    {
        $item = new ezcWebdavLockIfHeaderListItem();
        $list = new ezcWebdavLockIfHeaderNoTagList( $item );

        try
        {
            $list[''];
            $this->fail( 'Exception not thrown on invalid offset.' );
        }
        catch ( ezcBaseValueException $e ) {}

        try
        {
            $list[23];
            $this->fail( 'Exception not thrown on invalid offset.' );
        }
        catch ( ezcBaseValueException $e ) {}
    }

    public function testOffsetIssetSuccess()
    {
        $item = new ezcWebdavLockIfHeaderListItem();
        $list = new ezcWebdavLockIfHeaderNoTagList( $item );

        $this->assertTrue(
            isset( $list['/'] )
        );
        $this->assertTrue(
            isset( $list['/some/path'] )
        );
        $this->assertTrue(
            isset( $list['/none/existent'] )
        );
    }

    public function testOffsetIssetFailure()
    {
        $item = new ezcWebdavLockIfHeaderListItem();
        $list = new ezcWebdavLockIfHeaderNoTagList( $item );

        try
        {
            isset( $list[''] );
            $this->fail( 'Exception not thrown on invalid offset.' );
        }
        catch ( ezcBaseValueException $e ) {}

        try
        {
            isset( $list[23] );
            $this->fail( 'Exception not thrown on invalid value.' );
        }
        catch ( ezcBaseValueException $e ) {}
    }

    public function testOffsetUnsetFailure()
    {
        $item = new ezcWebdavLockIfHeaderListItem();
        $list = new ezcWebdavLockIfHeaderNoTagList( $item );

        try
        {
            unset( $list['/some/path'] );
            $this->fail( 'Exception not thrown on set access.' );
        }
        catch ( RuntimeException $e ) {}

        $this->assertAttributeSame(
            $item,
            'item',
            $list
        );
    }
}

?>
