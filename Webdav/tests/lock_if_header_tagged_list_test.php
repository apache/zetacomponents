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
class ezcWebdavLockIfHeaderTaggedListTest extends ezcWebdavTestCase
{
    public static function suite()
    {
		return new PHPUnit_Framework_TestSuite( __CLASS__ );
    }

    public function testConstructor()
    {
        $list = new ezcWebdavLockIfHeaderTaggedList();

        $this->assertAttributeEquals(
            array(),
            'items',
            $list
        );
    }

    public function testOffsetSetSuccess()
    {
        $list = new ezcWebdavLockIfHeaderTaggedList();

        $item1 = new ezcWebdavLockIfHeaderListItem();
        $item2 = new ezcWebdavLockIfHeaderListItem();

        $list['/some/path'] = $item1;
        $list['/'] = $item2;

        $this->assertAttributeEquals(
            array( '/some/path' => $item1, '/' => $item2 ),
            'items',
            $list
        );
    }

    public function testOffsetSetFailure()
    {
        $list = new ezcWebdavLockIfHeaderTaggedList();

        try
        {
            $list['/some/path'] = 23;
            $this->fail( 'Exception not thrown on invalid value.' );
        }
        catch ( ezcBaseValueException $e ) {}

        try
        {
            $list['/'] = new stdClass();
            $this->fail( 'Exception not thrown on invalid value.' );
        }
        catch ( ezcBaseValueException $e ) {}

        try
        {
            $list[''] = new ezcWebdavLockIfHeaderListItem();
            $this->fail( 'Exception not thrown on invalid offset.' );
        }
        catch ( ezcBaseValueException $e ) {}

        try
        {
            $list[23] = new ezcWebdavLockIfHeaderListItem();
            $this->fail( 'Exception not thrown on invalid offset.' );
        }
        catch ( ezcBaseValueException $e ) {}

        $this->assertAttributeEquals(
            array(),
            'items',
            $list
        );
    }

    public function testOffsetGetSuccess()
    {
        $list = new ezcWebdavLockIfHeaderTaggedList();

        $item1 = new ezcWebdavLockIfHeaderListItem();
        $item2 = new ezcWebdavLockIfHeaderListItem();

        $list['/some/path'] = $item1;
        $list['/'] = $item2;
        
        $this->assertEquals(
            $item1,
            $list['/some/path']
        );
        $this->assertEquals(
            $item2,
            $list['/']
        );
        $this->assertNull(
            $list['/non/existent']
        );
    }

    public function testOffsetGetFailure()
    {
        $list = new ezcWebdavLockIfHeaderTaggedList();

        try
        {
            $list[''];
            $this->fail( 'Exception not thrown on invalid offset.' );
        }
        catch ( ezcBaseValueException $e ) {}

        try
        {
            $list[23];
            $this->fail( 'Exception not thrown on invalid value.' );
        }
        catch ( ezcBaseValueException $e ) {}
    }

    public function testOffsetIssetSuccess()
    {
        $list = new ezcWebdavLockIfHeaderTaggedList();

        $item1 = new ezcWebdavLockIfHeaderListItem();
        $item2 = new ezcWebdavLockIfHeaderListItem();

        $list['/some/path'] = $item1;
        $list['/'] = $item2;

        $this->assertTrue(
            isset( $list['/'] )
        );
        $this->assertTrue(
            isset( $list['/some/path'] )
        );
        $this->assertFalse(
            isset( $list['/none/existent'] )
        );
    }

    public function testOffsetIssetFailure()
    {
        $list = new ezcWebdavLockIfHeaderTaggedList();

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

    public function testOffsetUnsetSuccess()
    {
        $list = new ezcWebdavLockIfHeaderTaggedList();

        $item1 = new ezcWebdavLockIfHeaderListItem();
        $item2 = new ezcWebdavLockIfHeaderListItem();

        $list['/some/path'] = $item1;
        $list['/'] = $item2;

        $this->assertTrue(
            isset( $list['/'] )
        );
        $this->assertTrue(
            isset( $list['/some/path'] )
        );
        $this->assertFalse(
            isset( $list['/none/existent'] )
        );

        unset( $list['/'] );
        unset( $list['/some/path'] );
        unset( $list['/none/existent'] );

        $this->assertFalse(
            isset( $list['/'] )
        );
        $this->assertFalse(
            isset( $list['/some/path'] )
        );
        $this->assertFalse(
            isset( $list['/none/existent'] )
        );
    }

    public function testOffsetUnsetFailure()
    {
        $list = new ezcWebdavLockIfHeaderTaggedList();

        try
        {
            unset( $list[''] );
            $this->fail( 'Exception not thrown on invalid offset.' );
        }
        catch ( ezcBaseValueException $e ) {}

        try
        {
            unset( $list[23] );
            $this->fail( 'Exception not thrown on invalid value.' );
        }
        catch ( ezcBaseValueException $e ) {}
    }
}

?>
