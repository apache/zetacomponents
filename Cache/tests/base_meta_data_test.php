<?php
/**
 * File containing test code for the Cache component.
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
 * @version //autogentag//
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 */


/**
 * Abstract base class for meta data tests.
 * 
 * @package Cache
 * @version //autogen//
 * @subpackage Test
 */
abstract class ezcCacheStackBaseMetaDataTest extends ezcTestCase
{
    protected $metaDataClass;

    public static function suite()
	{
		return new PHPUnit_Framework_TestSuite( __CLASS__ );
	}

    public function testCtor()
    {
        $meta = new $this->metaDataClass();

        $this->assertAttributeEquals(
            array(),
            'storageData',
            $meta
        );
        $this->assertAttributeEquals(
            array(),
            'replacementData',
            $meta
        );
    }

    public function testAddItemBase()
    {
        $meta = new $this->metaDataClass();

        $this->assertAttributeEquals(
            array(),
            'storageData',
            $meta
        );

        // Add first item to unknown storage
        $meta->addItem( 'storage_id_1', 'item_id_1' );

        $this->assertAttributeEquals(
            array(
                'storage_id_1' => array(
                    'item_id_1' => true,
                ),
            ),
            'storageData',
            $meta
        );

        // Add first item to second unknown storage
        $meta->addItem( 'storage_id_2', 'item_id_1' );

        $this->assertAttributeEquals(
            array(
                'storage_id_1' => array(
                    'item_id_1' => true,
                ),
                'storage_id_2' => array(
                    'item_id_1' => true,
                ),
            ),
            'storageData',
            $meta
        );

        // Add second item to known storag
        $meta->addItem( 'storage_id_2', 'item_id_2' );

        $this->assertAttributeEquals(
            array(
                'storage_id_1' => array(
                    'item_id_1' => true,
                ),
                'storage_id_2' => array(
                    'item_id_1' => true,
                    'item_id_2' => true,
                ),
            ),
            'storageData',
            $meta
        );

        // Add existing item without changes
        $meta->addItem( 'storage_id_1', 'item_id_1' );

        $this->assertAttributeEquals(
            array(
                'storage_id_1' => array(
                    'item_id_1' => true,
                ),
                'storage_id_2' => array(
                    'item_id_1' => true,
                    'item_id_2' => true,
                ),
            ),
            'storageData',
            $meta
        );
    }

    public function testRemoveItem()
    {
        $meta = new $this->metaDataClass();
        $meta->setState(
            array(
                'storageData' => array(
                    'storage_id_1' => array(
                        'item_id_1' => true,
                    ),
                    'storage_id_2' => array(
                        'item_id_1' => true,
                        'item_id_2' => true,
                    ),
                ),
                'replacementData' => array(
                    'item_id_1' => 1,
                    'item_id_2' => 2,
                )
            )
        );

        // Assert basis
        $this->assertAttributeEquals(
            array(
                'storage_id_1' => array(
                    'item_id_1' => true,
                ),
                'storage_id_2' => array(
                    'item_id_1' => true,
                    'item_id_2' => true,
                ),
            ),
            'storageData',
            $meta
        );
        $this->assertAttributeEquals(
            array(
                'item_id_1' => 1,
                'item_id_2' => 2,
            ),
            'replacementData',
            $meta
        );

        // Remove item with non empty storage afterwards
        $meta->removeItem( 'storage_id_2', 'item_id_1' );

        $this->assertAttributeEquals(
            array(
                'storage_id_1' => array(
                    'item_id_1' => true,
                ),
                'storage_id_2' => array(
                    'item_id_2' => true,
                ),
            ),
            'storageData',
            $meta
        );
        $this->assertAttributeEquals(
            array(
                'item_id_1' => 1,
                'item_id_2' => 2,
            ),
            'replacementData',
            $meta
        );

        // Remove item with empty storage afterwards
        $meta->removeItem( 'storage_id_2', 'item_id_2' );

        $this->assertAttributeEquals(
            array(
                'storage_id_1' => array(
                    'item_id_1' => true,
                ),
            ),
            'storageData',
            $meta
        );
        $this->assertAttributeEquals(
            array(
                'item_id_1' => 1,
            ),
            'replacementData',
            $meta
        );

        // Remove unknown item
        $meta->removeItem( 'storage_id_1', 'item_id_2' );

        $this->assertAttributeEquals(
            array(
                'storage_id_1' => array(
                    'item_id_1' => true,
                ),
            ),
            'storageData',
            $meta
        );
        $this->assertAttributeEquals(
            array(
                'item_id_1' => 1,
            ),
            'replacementData',
            $meta
        );

        // Remove from unknown storage
        $meta->removeItem( 'storage_id_2', 'item_id_1' );

        $this->assertAttributeEquals(
            array(
                'storage_id_1' => array(
                    'item_id_1' => true,
                ),
            ),
            'storageData',
            $meta
        );
        $this->assertAttributeEquals(
            array(
                'item_id_1' => 1,
            ),
            'replacementData',
            $meta
        );
    }

    public function testHasItem()
    {
        $meta = new $this->metaDataClass();
        $meta->setState(
            array(
                'storageData' => array(
                    'storage_id_1' => array(
                        'item_id_1' => true,
                    ),
                    'storage_id_2' => array(
                        'item_id_1' => true,
                        'item_id_2' => true,
                    ),
                ),
                'replacementData' => array(
                    'item_id_1' => 1,
                    'item_id_2' => 2,
                )
            )
        );
        
        // Known item in known storage
        $this->assertTrue(
            $meta->hasItem( 'storage_id_1', 'item_id_1' )
        );
        
        // Known item in unknown storage
        $this->assertFalse(
            $meta->hasItem( 'storage_id_3', 'item_id_1' )
        );
        
        // Unknown item in known storage
        $this->assertFalse(
            $meta->hasItem( 'storage_id_1', 'item_id_2' )
        );
        
        // Unknown item in unknown storage
        $this->assertFalse(
            $meta->hasItem( 'storage_id_3', 'item_id_3' )
        );
    }

    public function testReachedItemLimit()
    {
        $meta = new $this->metaDataClass();
        $meta->setState(
            array(
                'storageData' => array(
                    'storage_id_1' => array(
                        'item_id_1' => true,
                    ),
                    'storage_id_2' => array(
                        'item_id_1' => true,
                        'item_id_2' => true,
                    ),
                ),
                'replacementData' => array(
                    'item_id_1' => 1,
                    'item_id_2' => 2,
                )
            )
        );

        // Reached limit exactly
        $this->assertTrue(
            $meta->reachedItemLimit( 'storage_id_2', 2 )
        );

        // Over limit
        $this->assertTrue(
            $meta->reachedItemLimit( 'storage_id_2', 1 )
        );

        // Under limit
        $this->assertFalse(
            $meta->reachedItemLimit( 'storage_id_2', 3 )
        );

        // Unknown storage
        $this->assertFalse(
            $meta->reachedItemLimit( 'storage_id_3', 3 )
        );
    }

    public function testGetReplacementItems()
    {
        $meta = new $this->metaDataClass();
        $meta->setState(
            array(
                'storageData' => array(
                ),
                'replacementData' => array(
                    'item_id_1' => 4,
                    'item_id_2' => 3,
                    'item_id_5' => 2,
                    'item_id_3' => 8,
                    'item_id_4' => 5,
                )
            )
        );

        $sorted = array(
            'item_id_5' => 2,
            'item_id_2' => 3,
            'item_id_1' => 4,
            'item_id_4' => 5,
            'item_id_3' => 8,
        );
        
        // Returned array correctly sorted
        $this->assertEquals(
            $sorted,
            $meta->getReplacementItems()
        );

        // Attribute correctly sorted
        $this->assertAttributeEquals(
            $sorted,
            'replacementData',
            $meta
        );
    }

    public function testGetData()
    {
        $meta = new $this->metaDataClass();
        $data = array(
            'storageData' => array(
                'storage_id_1' => array(
                    'item_id_1' => true,
                ),
                'storage_id_2' => array(
                    'item_id_1' => true,
                    'item_id_2' => true,
                ),
            ),
            'replacementData' => array(
                'item_id_1' => 1,
                'item_id_2' => 2,
            )
        );

        $meta->setState(
            $data
        );
        $returnedData = $meta->getState();
        
        $this->assertEquals(
            $data['replacementData'],
            $returnedData['replacementData']
        );
        $this->assertEquals(
            $data['storageData'],
            $returnedData['storageData']
        );

    }

    public function testSetData()
    {
        $meta = new $this->metaDataClass();
        $data = array(
            'storageData' => array(
                'storage_id_1' => array(
                    'item_id_1' => true,
                ),
                'storage_id_2' => array(
                    'item_id_1' => true,
                    'item_id_2' => true,
                ),
            ),
            'replacementData' => array(
                'item_id_1' => 1,
                'item_id_2' => 2,
            )
        );

        $meta->setState(
            $data
        );
        
        $this->assertAttributeEquals(
            $data['replacementData'],
            'replacementData',
            $meta
        );
        $this->assertAttributeEquals(
            $data['storageData'],
            'storageData',
            $meta
        );
    }
}

?>
