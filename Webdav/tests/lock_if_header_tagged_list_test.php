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
class ezcWebdavLockIfHeaderTaggedListTest extends ezcTestCase
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

        $item1 = array( new ezcWebdavLockIfHeaderListItem() );
        $item2 = array( new ezcWebdavLockIfHeaderListItem() );

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

        $item1 = array( new ezcWebdavLockIfHeaderListItem() );
        $item2 = array( new ezcWebdavLockIfHeaderListItem() );

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
        $this->assertEquals(
            array(),
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

        $item1 = array( new ezcWebdavLockIfHeaderListItem() );
        $item2 = array( new ezcWebdavLockIfHeaderListItem() );

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

        $item1 = array( new ezcWebdavLockIfHeaderListItem() );
        $item2 = array( new ezcWebdavLockIfHeaderListItem() );

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

    public function testGetLockTokens()
    {
        $item1 = new ezcWebdavLockIfHeaderListItem(
            array(
                new ezcWebdavLockIfHeaderCondition( 'lock-token-1' ),
                new ezcWebdavLockIfHeaderCondition( 'lock-token-2', true ),
                new ezcWebdavLockIfHeaderCondition( 'lock-token-3' ),
            ),
            array(
                new ezcWebdavLockIfHeaderCondition( 'etag-1', true ),
                new ezcWebdavLockIfHeaderCondition( 'etag-2', true ),
                new ezcWebdavLockIfHeaderCondition( 'etag-3' ),
            )
        );
        $item2 = new ezcWebdavLockIfHeaderListItem(
            array(
                new ezcWebdavLockIfHeaderCondition( 'lock-token-1' ),
                new ezcWebdavLockIfHeaderCondition( 'lock-token-4' ),
            ),
            array(
                new ezcWebdavLockIfHeaderCondition( 'etag-1' ),
                new ezcWebdavLockIfHeaderCondition( 'etag-4', true ),
                new ezcWebdavLockIfHeaderCondition( 'etag-5' ),
            )
        );
        $item3 = new ezcWebdavLockIfHeaderListItem(
            array(
                new ezcWebdavLockIfHeaderCondition( 'lock-token-5', true ),
                new ezcWebdavLockIfHeaderCondition( 'lock-token-6', true ),
            ),
            array()
        );

        $list = new ezcWebdavLockIfHeaderTaggedList();

        $list['/'] = array( $item2 );
        $list['/some/path'] = array( $item1, $item3 );
        $list['/other/path'] = array( $item3, $item2 );

        $this->assertEquals(
            array(
                0 => 'lock-token-1',
                1 => 'lock-token-4',
                3 => 'lock-token-2',
                4 => 'lock-token-3',
                5 => 'lock-token-5',
                6 => 'lock-token-6',
            ),
            $list->getLockTokens()
        );
    }
}

?>
