<?php
/**
 * ezcCacheStackLruReplacementStrategyTest 
 * 
 * @package Cache
 * @subpackage Tests
 * @version //autogen//
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Test suite for ezcCacheManager class. 
 * 
 * @package Cache
 * @subpackage Tests
 */
class ezcCacheStackLruReplacementStrategyTest extends ezcTestCase
{
    /**
     * suite 
     * 
     * @static
     * @access public
     */
    public static function suite()
    {
        return new PHPUnit_Framework_TestSuite( __CLASS__ );
    }

    public function testInvalidMetaData()
    {
        $conf = new ezcCacheStackStorageConfiguration(
            'fooid',
            new ezcCacheStorageFileArray(
                $this->createTempDir( __FUNCTION__ )
            ),
            5,
            0.5
        );
        $meta = new ezcCacheStackMetaData( 'someWeirdMetaData' );

        try
        {
            ezcCacheStackLruReplacementStrategy::store(
                $conf,
                $meta,
                'barid',
                'baz content'
            );
            $this->fail( 'Exception not thrown on invalid meta data.' );
        }
        catch ( ezcCacheInvalidMetaDataException $e ) {}

        $this->removeTempDir();
    }

    public function testStoreNewMetaNewItemNoFree()
    {
        $conf = new ezcCacheStackStorageConfiguration(
            'fooid',
            new ezcCacheStorageFileArray(
                $this->createTempDir( __FUNCTION__ )
            ),
            5,
            0.5
        );
        $meta = new ezcCacheStackMetaData();

        ezcCacheStackLruReplacementStrategy::store(
            $conf,
            $meta,
            'barid',
            'baz content'
        );

        $this->assertEquals(
            'baz content',
            $conf->storage->restore( 'barid' ),
            'Data not stored correctly.'
        );

        $this->assertEquals(
            'ezcCacheStackLruReplacementStrategy',
            $meta->id,
            'Meta data ID incorrect.'
        );

        $this->assertGreaterThan(
            // Creation date of test case. Clock correct?
            1209503807,
            $meta->data['lru']['barid'],
            'Meta data entry not created correctly.'
        );

        $this->assertEquals( 
            array(
                'fooid' => true,
            ),
            $meta->data['storages']['barid']
        );
        $this->removeTempDir();
    }

    public function testStoreNoNewMetaNewItemNoFree()
    {
        $conf = new ezcCacheStackStorageConfiguration(
            'fooid',
            new ezcCacheStorageFileArray(
                $this->createTempDir( __FUNCTION__ )
            ),
            5,
            0.5
        );
        $meta = new ezcCacheStackMetaData();
        $meta->id = 'ezcCacheStackLruReplacementStrategy';
        $meta->data = array(
            'lru' => array(
                'someotherid' => 23,
            ),
            'storages' => array(
                'someotherid' => array(
                    'somecacheid' => true,
                ),
            ),
        );

        ezcCacheStackLruReplacementStrategy::store(
            $conf,
            $meta,
            'barid',
            'baz content'
        );

        $this->assertEquals(
            'baz content',
            $conf->storage->restore( 'barid' ),
            'Data not stored correctly.'
        );

        $this->assertGreaterThan(
            // Creation date of test case. Clock correct?
            1209503807,
            $meta->data['lru']['barid'],
            'Meta data entry not created correctly.'
        );

        $this->assertEquals(
            23,
            $meta->data['lru']['someotherid'],
            'Meta data entry not kept correctly.'
        );

        $this->assertEquals( 
            array(
                'someotherid' => array(
                    'somecacheid' => true,
                ),
                'barid' => array(
                    'fooid' => true,
                )
            ),
            $meta->data['storages']
        );
        $this->removeTempDir();
    }

    public function testStoreOldItemNoFree()
    {
        $conf = new ezcCacheStackStorageConfiguration(
            'fooid',
            new ezcCacheStorageFileArray(
                $this->createTempDir( __FUNCTION__ )
            ),
            5,
            0.5
        );
        $meta = new ezcCacheStackMetaData();
        $meta->id = 'ezcCacheStackLruReplacementStrategy';
        $meta->data = array(
            'lru' => array(
                'barid' => 23,
            ),
            'storages' => array(
                'barid' => array(
                    'fooid' => true,
                ),
            ),
        );
        $conf->storage->store( 'barid', 'bazcontent' );

        ezcCacheStackLruReplacementStrategy::store(
            $conf,
            $meta,
            'barid',
            'baz content'
        );

        $this->assertEquals(
            'baz content',
            $conf->storage->restore( 'barid' ),
            'Data not stored correctly.'
        );

        $this->assertEquals(
            'ezcCacheStackLruReplacementStrategy',
            $meta->id,
            'Meta data ID incorrect.'
        );

        $this->assertGreaterThan(
            // Creation date of test case. Clock correct?
            1209503807,
            $meta->data['lru']['barid'],
            'Meta data entry not created correctly.'
        );

        $this->assertEquals( 
            array(
                'fooid' => true,
            ),
            $meta->data['storages']['barid']
        );
        $this->removeTempDir();
    }

    public function testStoreNoNewMetaNewItemFreePurge()
    {
        // Prepare faked test data

        $tmpDir = $this->createTempDir( __FUNCTION__ );
        $conf = new ezcCacheStackStorageConfiguration(
            'fooid',
            new ezcCacheStorageFileArray(
                $tmpDir,
                array( 'ttl' => 30 )
            ),
            5,
            0.5
        );
        
        $now = time();

        // Store max number of items
        $conf->storage->store( 'id_1', 'id_1' );
        $conf->storage->store( 'id_2', 'id_2' );
        $conf->storage->store( 'id_3', 'id_3' );
        $conf->storage->store( 'id_4', 'id_4' );
        $conf->storage->store( 'id_5', 'id_5' );

        // Expire 3 items
        touch(
            $tmpDir . '/' . $conf->storage->generateIdentifier( 'id_2' ),
            ( $now - 40 ),
            ( $now - 40 )
        );
        touch(
            $tmpDir . '/' . $conf->storage->generateIdentifier( 'id_3' ),
            ( $now - 40 ),
            ( $now - 40 )
        );
        touch(
            $tmpDir . '/' . $conf->storage->generateIdentifier( 'id_4' ),
            ( $now - 40 ),
            ( $now - 40 )
        );

        $meta = new ezcCacheStackMetaData();
        $meta->id = 'ezcCacheStackLruReplacementStrategy';
        $meta->data = array(
            'lru' => array(
                // Fake access times, not necessarily reflect file mtimes
                'id_1' => ( $now - 10 ),
                'id_2' => ( $now - 40 ), // Expired
                'id_3' => ( $now - 40 ), // Expired
                'id_4' => ( $now - 40 ), // Expired
                'id_5' => ( $now - 13 ), 
            ),
            'storages' => array(
                'id_1' => array(
                    'fooid' => true,
                    'barid' => true,
                ),
                'id_2' => array(
                    'fooid' => true,
                ),
                'id_3' => array(
                    'fooid' => true,
                ),
                'id_4' => array(
                    'fooid' => true,
                ),
                'id_5' => array(
                    'fooid' => true,
                    'barid' => true,
                ),
            ),
        );

        // Perform actual action

        ezcCacheStackLruReplacementStrategy::store(
            $conf,
            $meta,
            'barid',
            'baz content'
        );

        // Assert correct behaviour

        // Data has actually been stored
        $this->assertEquals(
            'baz content',
            $conf->storage->restore( 'barid' ),
            'Data not stored correctly.'
        );

        // Time stamp has been stored correctly
        $this->assertGreaterThanOrEqual(
            $now,
            $meta->data['lru']['barid'],
            'Meta data entry not created correctly.'
        );

        // Storage has been saved correctly
        $this->assertEquals( 
            array(
                'fooid' => true,
            ),
            $meta->data['storages']['barid'],
            'Storage meta data not inserted correctly.'
        );

        // Remove stored item data from meta data again to comfortably assert
        // removal operations
        unset( $meta->data['lru']['barid'], $meta->data['storages']['barid'] );

        // LRU data correctly updated
        $this->assertEquals(
            // Note the sorting was not performed!
            array(
                'id_1' => ( $now - 10 ),
                'id_5' => ( $now - 13 ),
            ),
            $meta->data['lru'],
            'Meta data entries not correctly updated.'
        );

        // Storage data correctly updated
        $this->assertEquals(
            array(
                'id_1' => array(
                    'fooid' => true,
                    'barid' => true,
                ),
                'id_5' => array(
                    'fooid' => true,
                    'barid' => true,
                ),
            ),
            $meta->data['storages'],
            'Storage data not correctly updated.'
        );

        // Make sure items have been deleted from disc
        $this->assertEquals(
            // id_1, id_5 and barid
            3,
            count( glob( "$tmpDir/*" ) ),
            'Number of items on disc incorrect.'
        );

        // Restore existing items to check correct items exist
        $this->assertEquals(
            'id_1',
            $conf->storage->restore( 'id_1' ),
            'Data on disc incorrect.'
        );
        $this->assertEquals(
            'id_5',
            $conf->storage->restore( 'id_5' ),
            'Data on disc incorrect.'
        );
        $this->removeTempDir();
    }

    public function testStoreNoNewMetaNewItemFreeDelete()
    {
        // Prepare faked test data

        $tmpDir = $this->createTempDir( __FUNCTION__ );
        $conf = new ezcCacheStackStorageConfiguration(
            'fooid',
            new ezcCacheStorageFileArray(
                $tmpDir,
                array( 'ttl' => 30 )
            ),
            5,
            0.5
        );
        
        $now = time();

        // Store max number of items
        $conf->storage->store( 'id_1', 'id_1' );
        $conf->storage->store( 'id_2', 'id_2' );
        $conf->storage->store( 'id_3', 'id_3' );
        $conf->storage->store( 'id_4', 'id_4' );
        $conf->storage->store( 'id_5', 'id_5' );

        // None expired

        $meta = new ezcCacheStackMetaData();
        $meta->id = 'ezcCacheStackLruReplacementStrategy';
        $meta->data = array(
            'lru' => array(
                // Fake access times, not necessarily reflect file mtimes
                'id_1' => ( $now - 10 ),
                'id_2' => ( $now - 15 ), // Throwen out
                'id_3' => ( $now - 12 ), // Throwen out
                'id_4' => ( $now -  9 ),
                'id_5' => ( $now - 13 ), // Throwen out
            ),
            'storages' => array(
                'id_1' => array(
                    'fooid' => true,
                    'barid' => true,
                ),
                'id_2' => array(
                    'fooid' => true,
                ),
                'id_3' => array(
                    'fooid' => true,
                ),
                'id_4' => array(
                    'fooid' => true,
                ),
                'id_5' => array(
                    'fooid' => true,
                    'barid' => true,
                ),
            ),
        );

        // Perform actual action

        ezcCacheStackLruReplacementStrategy::store(
            $conf,
            $meta,
            'barid',
            'baz content'
        );

        // Assert correct behaviour

        // Data has actually been stored
        $this->assertEquals(
            'baz content',
            $conf->storage->restore( 'barid' ),
            'Data not stored correctly.'
        );

        // Time stamp has been stored correctly
        $this->assertGreaterThanOrEqual(
            $now,
            $meta->data['lru']['barid'],
            'Meta data entry not created correctly.'
        );

        // Storage has been saved correctly
        $this->assertEquals( 
            array(
                'fooid' => true,
            ),
            $meta->data['storages']['barid'],
            'Storage meta data not inserted correctly.'
        );

        // Remove stored item data from meta data again to comfortably assert
        // removal operations
        unset( $meta->data['lru']['barid'], $meta->data['storages']['barid'] );

        // LRU data correctly updated
        $this->assertEquals(
            // Note the sorting
            array(
                'id_4' => ( $now -  9 ),
                'id_1' => ( $now - 10 ),
            ),
            $meta->data['lru'],
            'Meta data entries not correctly updated.'
        );

        // Storage data correctly updated
        $this->assertEquals(
            array(
                'id_1' => array(
                    'fooid' => true,
                    'barid' => true,
                ),
                'id_4' => array(
                    'fooid' => true,
                ),
                'id_5' => array(
                    'barid' => true,
                ),
            ),
            $meta->data['storages'],
            'Storage data not correctly updated.'
        );

        // Make sure items have been deleted from disc
        $this->assertEquals(
            // id_1, id_4 and barid
            3,
            count( glob( "$tmpDir/*" ) ),
            'Number of items on disc incorrect.'
        );

        // Restore existing items to check correct items exist
        $this->assertEquals(
            'id_1',
            $conf->storage->restore( 'id_1' ),
            'Data on disc incorrect.'
        );
        $this->assertEquals(
            'id_4',
            $conf->storage->restore( 'id_4' ),
            'Data on disc incorrect.'
        );
        $this->removeTempDir();
    }

    public function testStoreNoNewMetaNewItemFreePurgeDelete()
    {
        // Prepare faked test data

        $tmpDir = $this->createTempDir( __FUNCTION__ );
        $conf = new ezcCacheStackStorageConfiguration(
            'fooid',
            new ezcCacheStorageFileArray(
                $tmpDir,
                array( 'ttl' => 30 )
            ),
            5,
            0.5
        );
        
        $now = time();

        // Store max number of items
        $conf->storage->store( 'id_1', 'id_1' );
        $conf->storage->store( 'id_2', 'id_2' );
        $conf->storage->store( 'id_3', 'id_3' );
        $conf->storage->store( 'id_4', 'id_4' );
        $conf->storage->store( 'id_5', 'id_5' );

        // id_2 expired
        touch(
            $tmpDir . '/' . $conf->storage->generateIdentifier( 'id_2' ),
            ( $now - 40 ),
            ( $now - 40 )
        );

        $meta = new ezcCacheStackMetaData();
        $meta->id = 'ezcCacheStackLruReplacementStrategy';
        $meta->data = array(
            'lru' => array(
                // Fake access times, not necessarily reflect file mtimes
                'id_1' => ( $now - 10 ),
                'id_2' => ( $now - 40 ), // Expired
                'id_3' => ( $now - 12 ), // Throwen out
                'id_4' => ( $now -  9 ),
                'id_5' => ( $now - 13 ), // Throwen out
            ),
            'storages' => array(
                'id_1' => array(
                    'fooid' => true,
                    'barid' => true,
                ),
                'id_2' => array(
                    'fooid' => true,
                ),
                'id_3' => array(
                    'fooid' => true,
                ),
                'id_4' => array(
                    'fooid' => true,
                ),
                'id_5' => array(
                    'fooid' => true,
                    'barid' => true,
                ),
            ),
        );

        // Perform actual action

        ezcCacheStackLruReplacementStrategy::store(
            $conf,
            $meta,
            'barid',
            'baz content'
        );

        // Assert correct behaviour

        // Data has actually been stored
        $this->assertEquals(
            'baz content',
            $conf->storage->restore( 'barid' ),
            'Data not stored correctly.'
        );

        // Time stamp has been stored correctly
        $this->assertGreaterThanOrEqual(
            $now,
            $meta->data['lru']['barid'],
            'Meta data entry not created correctly.'
        );

        // Storage has been saved correctly
        $this->assertEquals( 
            array(
                'fooid' => true,
            ),
            $meta->data['storages']['barid'],
            'Storage meta data not inserted correctly.'
        );

        // Remove stored item data from meta data again to comfortably assert
        // removal operations
        unset( $meta->data['lru']['barid'], $meta->data['storages']['barid'] );

        // LRU data correctly updated
        $this->assertEquals(
            // Note the sorting
            array(
                'id_4' => ( $now -  9 ),
                'id_1' => ( $now - 10 ),
            ),
            $meta->data['lru'],
            'Meta data entries not correctly updated.'
        );

        // Storage data correctly updated
        $this->assertEquals(
            array(
                'id_1' => array(
                    'fooid' => true,
                    'barid' => true,
                ),
                'id_4' => array(
                    'fooid' => true,
                ),
                'id_5' => array(
                    'barid' => true,
                ),
            ),
            $meta->data['storages'],
            'Storage data not correctly updated.'
        );

        // Make sure items have been deleted from disc
        $this->assertEquals(
            // id_1, id_4 and barid
            3,
            count( glob( "$tmpDir/*" ) ),
            'Number of items on disc incorrect.'
        );

        // Restore existing items to check correct items exist
        $this->assertEquals(
            'id_1',
            $conf->storage->restore( 'id_1' ),
            'Data on disc incorrect.'
        );
        $this->assertEquals(
            'id_4',
            $conf->storage->restore( 'id_4' ),
            'Data on disc incorrect.'
        );
        $this->removeTempDir();
    }

    public function testRestoreSuccess()
    {
        // Prepare faked test data

        $tmpDir = $this->createTempDir( __FUNCTION__ );
        $conf = new ezcCacheStackStorageConfiguration(
            'fooid',
            new ezcCacheStorageFileArray(
                $tmpDir,
                array( 'ttl' => 30 )
            ),
            5,
            0.5
        );
        
        $now = time();

        // Store max number of items
        $conf->storage->store( 'id_1', 'id_1' );
        
        $meta = new ezcCacheStackMetaData();
        $meta->id = 'ezcCacheStackLruReplacementStrategy';
        $meta->data = array(
            'lru' => array(
                // Fake access times, not necessarily reflect file mtimes
                'id_1' => ( $now - 10 ),
            ),
            'storages' => array(
                'id_1' => array(
                    'fooid' => true,
                    'barid' => true,
                ),
            ),
        );

        // Perform actual action

        $item = ezcCacheStackLruReplacementStrategy::restore(
            $conf,
            $meta,
            'id_1'
        );

        // Assert correct behavior

        // Item data correctly restored
        $this->assertEquals(
            'id_1',
            $item,
            'Item not restored correctly.'
        );

        // Meta data actualized correctly
        $this->assertGreaterThan(
            ( $now - 10 ),
            $meta->data['lru']['id_1']
        );
        
        // Storage data kept correctly
        $this->assertEquals(
            array(
                'id_1' => array(
                    'fooid' => true,
                    'barid' => true,
                ),
            ),
            $meta->data['storages'],
            'Storage data not correctly updated.'
        );
    }

    public function testRestoreFailureExpired()
    {
        // Prepare faked test data

        $tmpDir = $this->createTempDir( __FUNCTION__ );
        $conf = new ezcCacheStackStorageConfiguration(
            'fooid',
            new ezcCacheStorageFileArray(
                $tmpDir,
                array( 'ttl' => 30 )
            ),
            5,
            0.5
        );
        
        $now = time();

        // Store max number of items
        $conf->storage->store( 'id_1', 'id_1' );
        
        // Expire
        touch(
            $tmpDir . '/' . $conf->storage->generateIdentifier( 'id_1' ),
            ( $now - 40 ),
            ( $now - 40 )
        );
        
        $meta = new ezcCacheStackMetaData();
        $meta->id = 'ezcCacheStackLruReplacementStrategy';
        $meta->data = array(
            'lru' => array(
                // Fake access times, not necessarily reflect file mtimes
                'id_1' => ( $now - 40 ),
            ),
            'storages' => array(
                'id_1' => array(
                    'fooid' => true,
                    'barid' => true,
                ),
            ),
        );

        // Perform actual action

        $item = ezcCacheStackLruReplacementStrategy::restore(
            $conf,
            $meta,
            'id_1'
        );

        // Assert correct behavior

        // Item data correctly restored
        $this->assertFalse(
            $item,
            'Item exists although expired.'
        );

        // Meta data actualized correctly
        $this->assertEquals(
            array(),
            $meta->data['lru']
        );
        
        // Storage data kept correctly
        $this->assertEquals(
            array(
                'id_1' => array(
                    'barid' => true,
                ),
            ),
            $meta->data['storages'],
            'Storage data not correctly updated.'
        );
    }

    public function testRestoreFailureNonexistent()
    {
        // Prepare faked test data

        $tmpDir = $this->createTempDir( __FUNCTION__ );
        $conf = new ezcCacheStackStorageConfiguration(
            'fooid',
            new ezcCacheStorageFileArray(
                $tmpDir,
                array( 'ttl' => 30 )
            ),
            5,
            0.5
        );
        
        $meta = new ezcCacheStackMetaData();
        $meta->id = 'ezcCacheStackLruReplacementStrategy';
        $meta->data = array(
            'lru' => array(),
            'storages' => array(),
        );

        // Perform actual action

        $item = ezcCacheStackLruReplacementStrategy::restore(
            $conf,
            $meta,
            'id_1'
        );

        // Assert correct behavior

        // Item data correctly restored
        $this->assertFalse(
            $item,
            'Item exists although expired.'
        );

        // Meta data actualized correctly
        $this->assertEquals(
            array(),
            $meta->data['lru']
        );
        
        // Storage data kept correctly
        $this->assertEquals(
            array(),
            $meta->data['storages'],
            'Storage data not correctly updated.'
        );
    }
}
?>
