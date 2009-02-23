<?php
/**
 * ezcCacheStackLfuMetaData 
 * 
 * @package Cache
 * @subpackage Tests
 * @version //autogen//
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

require_once 'base_meta_data_test.php';

/**
 * Test suite for the ezcCacheStackLfuMetaData class.
 * 
 * @package Cache
 * @subpackage Tests
 */
class ezcCacheStackLfuMetaDataTest extends ezcCacheStackBaseMetaDataTest
{
    public static function suite()
	{
		return new PHPUnit_Framework_TestSuite( __CLASS__ );
	}

    public function setup()
    {
        $this->metaDataClass = 'ezcCacheStackLfuMetaData';
    }

    public function testAddItem()
    {
        $meta = new $this->metaDataClass();

        $this->assertAttributeEquals(
            array(),
            'replacementData',
            $meta
        );

        // Add first item to unknown storage
        $meta->addItem( 'storage_id_1', 'item_id_1' );

        $metaData = $meta->getState();
        $this->assertEquals(
            1,
            $metaData['replacementData']['item_id_1']
        );

        // Add first item to second unknown storage
        $meta->addItem( 'storage_id_2', 'item_id_1' );

        $metaData = $meta->getState();
        $this->assertEquals(
            2,
            $metaData['replacementData']['item_id_1']
        );

        // Add second item to known storag
        $meta->addItem( 'storage_id_2', 'item_id_2' );

        $metaData = $meta->getState();
        $this->assertEquals(
            1,
            $metaData['replacementData']['item_id_2']
        );
        $this->assertEquals(
            2,
            $metaData['replacementData']['item_id_1']
        );

        // Add existing item
        $meta->addItem( 'storage_id_1', 'item_id_1' );

        $metaData = $meta->getState();
        $this->assertEquals(
            1,
            $metaData['replacementData']['item_id_2']
        );
        $this->assertEquals(
            3,
            $metaData['replacementData']['item_id_1']
        );
    }
}

?>
