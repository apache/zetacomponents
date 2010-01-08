<?php
/**
 * File containing the ezcWebdavFileBackendOptionsTestCase class.
 * 
 * @package Webdav
 * @version //autogen//
 * @copyright Copyright (C) 2005-2010 eZ Systems AS. All rights reserved.
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
class ezcWebdavLockIfHeaderNoTagListTest extends ezcTestCase
{
    public static function suite()
    {
		return new PHPUnit_Framework_TestSuite( __CLASS__ );
    }

    public function testConstructor()
    {
        $item = array( new ezcWebdavLockIfHeaderListItem() );
        $list = new ezcWebdavLockIfHeaderNoTagList( $item );

        $this->assertAttributeEquals(
            $item,
            'items',
            $list
        );
    }

    public function testOffsetSetFailure()
    {
        $item = array( new ezcWebdavLockIfHeaderListItem() );
        $list = new ezcWebdavLockIfHeaderNoTagList( $item );

        try
        {
            $list['/some/path'] = 23;
            $this->fail( 'Exception not thrown on set access.' );
        }
        catch ( RuntimeException $e ) {}

        $this->assertAttributeSame(
            $item,
            'items',
            $list
        );
    }

    public function testOffsetGetSuccess()
    {
        $item = array( new ezcWebdavLockIfHeaderListItem() );
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
        $item = array( new ezcWebdavLockIfHeaderListItem() );
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
        $item = array( new ezcWebdavLockIfHeaderListItem() );
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
        $item = array( new ezcWebdavLockIfHeaderListItem() );
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
        $item = array( new ezcWebdavLockIfHeaderListItem() );
        $list = new ezcWebdavLockIfHeaderNoTagList( $item );

        try
        {
            unset( $list['/some/path'] );
            $this->fail( 'Exception not thrown on set access.' );
        }
        catch ( RuntimeException $e ) {}

        $this->assertAttributeSame(
            $item,
            'items',
            $list
        );
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

        $list = new ezcWebdavLockIfHeaderNoTagList(
            array( $item1, $item2, $item3 )
        );

        $this->assertEquals(
            array(
                0 => 'lock-token-1',
                1 => 'lock-token-2',
                2 => 'lock-token-3',
                4 => 'lock-token-4',
                5 => 'lock-token-5',
                6 => 'lock-token-6',
            ),
            $list->getLockTokens()
        );
    }
}

?>
