<?php
/**
 * ezcCacheStackLruMetaData 
 * 
 * @package Cache
 * @subpackage Tests
 * @version //autogen//
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

require_once 'base_meta_data_test.php';

/**
 * Test suite for the ezcCacheStackLruMetaData class.
 * 
 * @package Cache
 * @subpackage Tests
 */
class ezcCacheStackLruMetaDataTest extends ezcCacheStackBaseMetaDataTest
{
    public static function suite()
	{
		return new PHPUnit_Framework_TestSuite( __CLASS__ );
	}

    public function setup()
    {
        $this->metaDataClass = 'ezcCacheStackLruMetaData';
    }

    public function testAddItem()
    {
        $meta = new $this->metaDataClass();

        $this->assertAttributeEquals(
            array(),
            'replacementData',
            $meta
        );

        $now = time();

        // Add first item to unknown storage
        $meta->addItem( 'storage_id_1', 'item_id_1' );

        $metaData = $meta->getState();
        $this->assertGreaterThanOrEqual(
            $now,
            $metaData['replacementData']['item_id_1']
        );

        $now = time();

        // Add first item to second unknown storage
        $meta->addItem( 'storage_id_2', 'item_id_1' );

        $metaData = $meta->getState();
        $this->assertGreaterThanOrEqual(
            $now,
            $metaData['replacementData']['item_id_1']
        );

        $now = time();

        // Add second item to known storag
        $meta->addItem( 'storage_id_2', 'item_id_2' );

        $metaData = $meta->getState();
        $this->assertGreaterThanOrEqual(
            $now,
            $metaData['replacementData']['item_id_2']
        );
        $this->assertLessThanOrEqual(
            $now,
            $metaData['replacementData']['item_id_1']
        );

        $now = time();

        // Add existing item
        $meta->addItem( 'storage_id_1', 'item_id_1' );

        $this->assertLessThanOrEqual(
            $now,
            $metaData['replacementData']['item_id_2']
        );
        $this->assertGreaterThanOrEqual(
            $now,
            $metaData['replacementData']['item_id_1']
        );
    }
}

?>
