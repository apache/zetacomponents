<?php
/**
 * ezcCacheStackOptionsTest 
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
 * @package Cache
 * @subpackage Tests
 * @version //autogen//
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 */

/**
 * Configurator class. 
 */
require_once 'stack_test_configurator.php';

/**
 * Test suite for the ezcCacheStackOptions class.
 * 
 * @package Cache
 * @subpackage Tests
 */
class ezcCacheStackOptionsTest extends ezcTestCase
{
    public static function suite()
	{
		return new PHPUnit_Framework_TestSuite( __CLASS__ );
	}

    public function testCtorDefaultSuccess()
    {
        $opts = new ezcCacheStackOptions();
        $this->assertAttributeEquals(
            array(
                'configurator'        => null,
                'metaStorage'         => null,
                'replacementStrategy' => 'ezcCacheStackLruReplacementStrategy',
                'bubbleUpOnRestore'   => false,
            ),
            'properties',
            $opts,
            'Default options incorrect.'
        );
    }

    public function testCtorNonDefaultSuccess()
    {
        $optArray = array(
            'configurator'        => 'ezcCacheStackTestConfigurator',
            // @TODO: Should be a valid storage object.
            'metaStorage'         => null,
            'replacementStrategy' => 'ezcCacheStackLfuReplacementStrategy',
            'bubbleUpOnRestore'   => true,
        );
        $opts = new ezcCacheStackOptions( $optArray );
        $this->assertAttributeEquals(
            $optArray,
            'properties',
            $opts,
            'Options set via ctor incorrect.'
        );
    }

    public function testSetSuccess()
    {
        $metaDataStorage = $this->getMock( 'ezcCacheStackMetaDataStorage' );

        $opts = new ezcCacheStackOptions();
        $this->assertSetProperty(
            $opts,
            'configurator',
            array( 'ezcCacheStackTestConfigurator', null )
        );

        $this->assertSetProperty(
            $opts,
            'metaStorage',
            array( $metaDataStorage )
        );
        $this->assertSetProperty(
            $opts,
            'replacementStrategy',
            array( 'ezcCacheStackLfuReplacementStrategy', 'ezcCacheStackLruReplacementStrategy' )
        );
        $this->assertSetProperty(
            $opts,
            'bubbleUpOnRestore',
            array( true, false )
        );
    }

    public function testSetFailure()
    {
        $nonMetaDataStorage = $this->getMock(
            'ezcCacheStorage',
            array(
                'validateLocation',
                'store',
                'restore',
                'delete',
                'countDataItems',
                'getRemainingLifetime'
            ),
            array(),
            '',
            false
        );

        $opts = new ezcCacheStackOptions();
        $this->assertSetPropertyFails(
            $opts,
            'configurator',
            array( true, false, 23, 42.23, 'Foo', array(), 'stdClass', new stdClass() )
        );
        $this->assertSetPropertyFails(
            $opts,
            'metaStorage',
            array( true, false, 23, 42.23, 'Foo', array(), 'stdClass', new stdClass(), $nonMetaDataStorage )
        );
        $this->assertSetPropertyFails(
            $opts,
            'replacementStrategy',
            array( null, true, false, 23, 42.23, 'Foo', array(), 'stdClass', new stdClass() )
        );
        $this->assertSetPropertyFails(
            $opts,
            'bubbleUpOnRestore',
            array( null, 23, 42.23, 'Foo', array(), 'stdClass', new stdClass() )
        );

        try
        {
            $opts->fooBar = 23;
            $ths->fail( 'Exception not thrown on access to unknown option.' );
        }
        catch ( ezcBasePropertyNotFoundException $e ) {}
    }

    public function testGetSuccess()
    {
        $opts = new ezcCacheStackOptions();
        $this->assertEquals( null, $opts->configurator );
        $this->assertEquals( null, $opts->metaStorage );
        $this->assertEquals( 'ezcCacheStackLruReplacementStrategy', $opts->replacementStrategy );
        $this->assertEquals( false, $opts->bubbleUpOnRestore );
    }

    public function testGetFailure()
    {
        $opts = new ezcCacheStackOptions();
        try
        {
            echo $opts->fooBar;
            $ths->fail( 'Exception not thrown on access to unknown option.' );
        }
        catch ( ezcBasePropertyNotFoundException $e ) {}
    }
}

?>
