<?php
/**
 * ezcCacheStorageFilePlainTest
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
 * Require parent test class. 
 */
require_once 'storage_test.php';

/**
 * Test suite for ezcStorageFilePlain class. 
 * 
 * @package Cache
 * @subpackage Tests
 */
class ezcCacheStorageFilePlainTest extends ezcCacheStorageTest
{
    /**
     * data 
     * 
     * @var array
     * @access protected
     */
    protected $testData = array(
        1 => "Test 1 2 3 4 5 6 7 8\\\\",
        2 => 'La la la 02064 lololo',
        3 => 12345,
        4 => 12.3746,
    );

    public function testGetRemainingLifetimeId()
    {
        $this->storage->setOptions( array( 'ttl' => 10 ) );

        $this->storage->store( '1', 'data1' );

        $this->assertEquals( true, 8 < $this->storage->getRemainingLifetime( '1' ) );

    }

    public function testGetRemainingLifetimeAttributes()
    {
        $this->storage->setOptions( array( 'ttl' => 10 ) );

        $this->storage->store( '1', 'data1', array( 'type' => 'simple' ) );
        $this->storage->store( '2', 'data2', array( 'type' => 'simple' ) );

        $this->assertEquals( true, 8 < $this->storage->getRemainingLifetime( null, array( 'type' => 'simple' ) ) );

    }

    public function testGetRemainingLifetimeNoMatch()
    {
        $this->storage->setOptions( array( 'ttl' => 10 ) );

        $this->assertEquals( 0, $this->storage->getRemainingLifetime( 'no_such_id' ) );

    }

    public function testMetaDataSuccess()
    {
        $temp = $this->createTempDir( __CLASS__ );

        $meta = new ezcCacheStackLruMetaData();
        $meta->setState(
            array(
                'replacementData' => array(
                    'id_1' => 23,
                    'id_2' => 42,
                ),
                'storageData' => array(
                    'storage_id_1' => array(
                        'id_1' => true,
                        'id_2' => true,
                    ),
                    'storage_id_2' => array(
                        'id_2' => true,
                    ),
                ),
            )
        );

        $storage = new ezcCacheStorageFilePlain( $temp );

        $this->assertFalse(
            file_exists( $storage->getLocation() . $storage->options->metaDataFile ),
            'Meta data file existed before the storage was created.'
        );

        $storage->storeMetaData( $meta );

        $this->assertTrue(
            file_exists( $storage->getLocation() . $storage->options->metaDataFile ),
            'Meta data file existed before the storage was created.'
        );

        $restoredMeta = $storage->restoreMetaData();

        $this->assertEquals(
            $meta,
            $restoredMeta,
            'Meta data not restored correctly.'
        );

        $this->assertTrue(
            file_exists( $storage->getLocation() . $storage->options->metaDataFile ),
            'Meta data does not exist anymore after restoring.'
        );
    }

    public function testMetaDataFailure()
    {
        $temp = $this->createTempDir( __CLASS__ );

        $storage = new ezcCacheStorageFilePlain( $temp );

        $this->assertFalse(
            file_exists( $storage->getLocation() . $storage->options->metaDataFile ),
            'Meta data file existed before the storage was created.'
        );

        $restoredMeta = $storage->restoreMetaData();

        $this->assertNull(
            $restoredMeta,
            'Meta data not restored correctly.'
        );

        $this->assertFalse(
            file_exists( $storage->getLocation() . $storage->options->metaDataFile ),
            'Meta data file existed before the storage was created.'
        );
    }

    public static function suite()
	{
		return new PHPUnit_Framework_TestSuite( "ezcCacheStorageFilePlainTest" );
	}
}
?>
