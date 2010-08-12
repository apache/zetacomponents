<?php
/**
 * File containing the ezcWebdavFileBackendOptionsTestCase class.
 * 
 * Licensed to the Apache Software Foundation (ASF) under one
 * or more contributor license agreements.  See the NOTICE file
 * distributed with this work for additional information
 * regarding copyright ownership.  The ASF licenses this file
 * to you under the Apache License, Version 2.0 (the
 * "License"); you may not use this file except in compliance
 * with the License.  You may obtain a copy of the License at
 * 
 *   http://www.apache.org/licenses/LICENSE-2.0
 * 
 * Unless required by applicable law or agreed to in writing,
 * software distributed under the License is distributed on an
 * "AS IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS OF ANY
 * KIND, either express or implied.  See the License for the
 * specific language governing permissions and limitations
 * under the License.
 *
 * @package Webdav
 * @version //autogen//
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
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
class ezcWebdavLockIfHeaderListItemTest extends ezcTestCase
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
