<?php
/**
 * ezcCacheStackLfuReplacementStrategyTest 
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
class ezcCacheStackLfuReplacementStrategyTest extends ezcTestCase
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
                $this->createTempDir( __CLASS__ )
            ),
            5,
            0.5
        );
        $meta = new ezcCacheStackMetaData( 'someWeirdMetaData' );

        try
        {
            ezcCacheStackLfuReplacementStrategy::store(
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
                $this->createTempDir( __CLASS__ )
            ),
            5,
            0.5
        );
        $meta = new ezcCacheStackMetaData();

        ezcCacheStackLfuReplacementStrategy::store(
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
            'ezcCacheStackLfuReplacementStrategy',
            $meta->id,
            'Meta data ID incorrect.'
        );

        $this->assertEquals(
            // Creation date of test case. Clock correct?
            1,
            $meta->data['lfu']['barid'],
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
                $this->createTempDir( __CLASS__ )
            ),
            5,
            0.5
        );
        $meta = new ezcCacheStackMetaData();
        $meta->id = 'ezcCacheStackLfuReplacementStrategy';
        $meta->data = array(
            'lfu' => array(
                'someotherid' => 23,
            ),
            'storages' => array(
                'someotherid' => array(
                    'somecacheid' => true,
                ),
            ),
        );

        ezcCacheStackLfuReplacementStrategy::store(
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
            1,
            $meta->data['lfu']['barid'],
            'Meta data entry not created correctly.'
        );

        $this->assertEquals(
            23,
            $meta->data['lfu']['someotherid'],
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
                $this->createTempDir( __CLASS__ )
            ),
            5,
            0.5
        );
        $meta = new ezcCacheStackMetaData();
        $meta->id = 'ezcCacheStackLfuReplacementStrategy';
        $meta->data = array(
            'lfu' => array(
                'barid' => 23,
            ),
            'storages' => array(
                'barid' => array(
                    'fooid' => true,
                ),
            ),
        );
        $conf->storage->store( 'barid', 'bazcontent' );

        ezcCacheStackLfuReplacementStrategy::store(
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
            'ezcCacheStackLfuReplacementStrategy',
            $meta->id,
            'Meta data ID incorrect.'
        );

        $this->assertEquals(
            24,
            $meta->data['lfu']['barid'],
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

        $tmpDir = $this->createTempDir( __CLASS__ );
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
            $tmpDir . '/' . $conf->storage->generateIdentifier( 'id_5' ),
            ( $now - 40 ),
            ( $now - 40 )
        );

        $meta = new ezcCacheStackMetaData();
        $meta->id = 'ezcCacheStackLfuReplacementStrategy';
        $meta->data = array(
            'lfu' => array(
                // Fake access times, not necessarily reflect file mtimes
                'id_1' => 10,
                'id_2' => 100,  // Expired
                'id_3' => 5,    // Expired
                'id_4' => 23,
                'id_5' => 42,   // Expired but kept, since available in other storage
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

        ezcCacheStackLfuReplacementStrategy::store(
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
        $this->assertEquals(
            1,
            $meta->data['lfu']['barid'],
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
        unset( $meta->data['lfu']['barid'], $meta->data['storages']['barid'] );

        // LRU data correctly updated
        $this->assertEquals(
            // Note the sorting was not performed!
            array(
                'id_1' => 10,
                'id_4' => 23,
                'id_5' => 42,   // Expired but kept, since available in other storage
            ),
            $meta->data['lfu'],
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
        $this->assertFalse(
            $conf->storage->restore( 'id_5' ),
            'Data on disc incorrect.'
        );
        $this->removeTempDir();
    }

    public function testStoreNoNewMetaNewItemFreeDelete()
    {
        // Prepare faked test data

        $tmpDir = $this->createTempDir( __CLASS__ );
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
        $meta->id = 'ezcCacheStackLfuReplacementStrategy';
        $meta->data = array(
            'lfu' => array(
                // Fake access times, not necessarily reflect file mtimes
                'id_1' => 150,
                'id_2' => 23,   // Throwen out
                'id_3' => 42,   // Throwen out
                'id_4' => 100,
                'id_5' => 5,    // Throwen out but kept, since available in other storage
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

        ezcCacheStackLfuReplacementStrategy::store(
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
        $this->assertEquals(
            1,
            $meta->data['lfu']['barid'],
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
        unset( $meta->data['lfu']['barid'], $meta->data['storages']['barid'] );

        // LRU data correctly updated
        $this->assertEquals(
            // Note the sorting
            array(
                'id_5' => 5,    // Throwen out but kept, since available in other storage
                'id_4' => 100,
                'id_1' => 150,
            ),
            $meta->data['lfu'],
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
        $this->assertFalse(
            // Deleted on disc, but still in meta data
            $conf->storage->restore( 'id_5' ),
            'Data on disc incorrect.'
        );
        $this->removeTempDir();
    }

    public function testStoreNoNewMetaNewItemFreePurgeDelete()
    {
        // Prepare faked test data

        $tmpDir = $this->createTempDir( __CLASS__ );
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
        $meta->id = 'ezcCacheStackLfuReplacementStrategy';
        $meta->data = array(
            'lfu' => array(
                // Fake access times, not necessarily reflect file mtimes
                'id_1' => 150,
                'id_2' => 150,  // Expired
                'id_3' => 23,   // Throwen out
                'id_4' => 100,
                'id_5' => 42,   // Throwen out, but kept in meta data, since available in other storage
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

        ezcCacheStackLfuReplacementStrategy::store(
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
        $this->assertEquals(
            1,
            $meta->data['lfu']['barid'],
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
        unset( $meta->data['lfu']['barid'], $meta->data['storages']['barid'] );

        // LRU data correctly updated
        $this->assertEquals(
            // Note the sorting
            array(
                'id_5' => 42,   // Throwen out, but kept in meta data, since available in other storage
                'id_4' => 100,
                'id_1' => 150,
            ),
            $meta->data['lfu'],
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
        $this->assertFalse(
            $conf->storage->restore( 'id_5' ),
            'Data on disc incorrect.'
        );
        $this->removeTempDir();
    }

    public function testStoreNoNewMetaNewItemFreePurgeDeleteComplex()
    {
        // Prepare faked test data

        $tmpDir = $this->createTempDir( __CLASS__ );
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
        // $conf->storage->store( 'id_5', 'id_5' );

        // id_2 expired
        touch(
            $tmpDir . '/' . $conf->storage->generateIdentifier( 'id_2' ),
            ( $now - 40 ),
            ( $now - 40 )
        );

        $meta = new ezcCacheStackMetaData();
        $meta->id = 'ezcCacheStackLfuReplacementStrategy';
        $meta->data = array(
            'lfu' => array(
                // Fake access times, not necessarily reflect file mtimes
                'id_1' => 100,  // Throwen out instead of id_5
                'id_2' => 150,  // Expired
                'id_3' => 23,   // Throwen out
                'id_4' => 150,  
                'id_5' => 42,   // Kept, since not in actual storage
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
                    'barid' => true,
                ),
            ),
        );

        // Perform actual action

        ezcCacheStackLfuReplacementStrategy::store(
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
        $this->assertEquals(
            1,
            $meta->data['lfu']['barid'],
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
        unset( $meta->data['lfu']['barid'], $meta->data['storages']['barid'] );

        // LRU data correctly updated
        $this->assertEquals(
            // Note the sorting
            array(
                'id_1' => 100,  // Throwen out instead of id_5
                'id_4' => 150,  
                'id_5' => 42,   // Kept, since not in actual storage
            ),
            $meta->data['lfu'],
            'Meta data entries not correctly updated.'
        );

        // Storage data correctly updated
        $this->assertEquals(
            array(
                'id_1' => array(
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
            // id_4 and barid
            2,
            count( glob( "$tmpDir/*" ) ),
            'Number of items on disc incorrect.'
        );

        // Restore existing items to check correct items exist
        $this->assertFalse(
            $conf->storage->restore( 'id_1' ),
            'Data on disc incorrect.'
        );
        $this->assertEquals(
            'id_4',
            $conf->storage->restore( 'id_4' ),
            'Data on disc incorrect.'
        );
        $this->assertFalse(
            $conf->storage->restore( 'id_5' ),
            'Data on disc incorrect.'
        );
        $this->removeTempDir();
    }

    public function testRestoreSuccess()
    {
        // Prepare faked test data

        $tmpDir = $this->createTempDir( __CLASS__ );
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
        $meta->id = 'ezcCacheStackLfuReplacementStrategy';
        $meta->data = array(
            'lfu' => array(
                // Fake access times, not necessarily reflect file mtimes
                'id_1' => 23,
            ),
            'storages' => array(
                'id_1' => array(
                    'fooid' => true,
                    'barid' => true,
                ),
            ),
        );

        // Perform actual action

        $item = ezcCacheStackLfuReplacementStrategy::restore(
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
        $this->assertEquals(
            24,
            $meta->data['lfu']['id_1']
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

        $tmpDir = $this->createTempDir( __CLASS__ );
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
        $meta->id = 'ezcCacheStackLfuReplacementStrategy';
        $meta->data = array(
            'lfu' => array(
                // Fake access times, not necessarily reflect file mtimes
                'id_1' => 23,
            ),
            'storages' => array(
                'id_1' => array(
                    'fooid' => true,
                    'barid' => true,
                ),
            ),
        );

        // Perform actual action

        $item = ezcCacheStackLfuReplacementStrategy::restore(
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
            array(
                'id_1' => 23, // Kept since available in other storage
            ),
            $meta->data['lfu']
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

        $tmpDir = $this->createTempDir( __CLASS__ );
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
        $meta->id = 'ezcCacheStackLfuReplacementStrategy';
        $meta->data = array(
            'lfu' => array(),
            'storages' => array(),
        );

        // Perform actual action

        $item = ezcCacheStackLfuReplacementStrategy::restore(
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
            $meta->data['lfu']
        );
        
        // Storage data kept correctly
        $this->assertEquals(
            array(),
            $meta->data['storages'],
            'Storage data not correctly updated.'
        );
    }

    public function testDeleteSuccess()
    {
        // Prepare faked test data

        $tmpDir = $this->createTempDir( __CLASS__ );
        $conf = new ezcCacheStackStorageConfiguration(
            'fooid',
            new ezcCacheStorageFileArray(
                $tmpDir,
                array( 'ttl' => 30 )
            ),
            5,
            0.5
        );

        // Store max number of items
        $conf->storage->store( 'id_1', 'id_1' );
        
        // Cache location not empty
        $this->assertEquals(
            1,
            count( glob( "$tmpDir/*" ) ),
            'Cache location contains unknown items.'
        );
        
        $meta = new ezcCacheStackMetaData();
        $meta->id = 'ezcCacheStackLfuReplacementStrategy';
        $meta->data = array(
            'lfu' => array(
                'id_1' => 42,
            ),
            'storages' => array(
                'id_1' => array(
                    'fooid' => true,
                    'barid' => true,
                ),
            ),
        );

        // Perform actual action

        $deletedItems = ezcCacheStackLfuReplacementStrategy::delete(
            $conf,
            $meta,
            'id_1'
        );

        // Assert correct behavior

        // Item data correctly restored
        $this->assertEquals(
            array( 'id_1' ),
            $deletedItems,
            'Item not indicated to be delted.'
        );

        // Meta data actualized correctly
        $this->assertEquals(
            array(
                'id_1' => 42, // Kept since available in other storage
            ),
            $meta->data['lfu']
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
        
        // Cache location empty
        $this->assertEquals(
            0,
            count( glob( "$tmpDir/*" ) ),
            'Cache location contains unknown items.'
        );
    }

    // Tests how inconsistent meta data affects the stack
    public function testDeleteNonexistent()
    {
        // Prepare faked test data

        $tmpDir = $this->createTempDir( __CLASS__ );
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
        $meta->id = 'ezcCacheStackLfuReplacementStrategy';
        $meta->data = array(
            'lfu' => array(
            ),
            'storages' => array(
                'id_1' => array(
                    'barid' => true,
                ),
            ),
        );

        // Perform actual action

        $deletedItems = ezcCacheStackLfuReplacementStrategy::delete(
            $conf,
            $meta,
            'id_1'
        );

        // Assert correct behavior

        // Item data correctly restored
        $this->assertEquals(
            array(),
            $deletedItems,
            'Item not indicated to be delted.'
        );

        // Meta data actualized correctly
        $this->assertEquals(
            array(),
            $meta->data['lfu']
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

        // Cache location empty
        $this->assertEquals(
            0,
            count( glob( "$tmpDir/*" ) ),
            'Cache location contains unknown items.'
        );
    }

    public function testRestoreDeleteSuccessSearch()
    {
        // Prepare faked test data

        $tmpDir = $this->createTempDir( __CLASS__ );
        $conf = new ezcCacheStackStorageConfiguration(
            'fooid',
            new ezcCacheStorageFileArray(
                $tmpDir,
                array( 'ttl' => 30 )
            ),
            5,
            0.5
        );

        // Store max number of items
        $conf->storage->store( 'id_1', 'id_1', array( 'lang' => 'en' ) );
        $conf->storage->store( 'id_2', 'id_2' );
        $conf->storage->store( 'id_3', 'id_3', array( 'lang' => 'en' ) );
        
        // Cache location not empty
        $this->assertEquals(
            3,
            count( glob( "$tmpDir/*" ) ),
            'Cache location contains unknown items.'
        );
        
        $meta = new ezcCacheStackMetaData();
        $meta->id = 'ezcCacheStackLfuReplacementStrategy';
        $meta->data = array(
            'lfu' => array(
                'id_1' => 23,
                'id_2' => 42,
                'id_3' => 5,
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
            ),
        );

        // Perform actual action

        $deletedItems = ezcCacheStackLfuReplacementStrategy::delete(
            $conf,
            $meta,
            null,
            array( 'lang' => 'en' ),
            true
        );

        // Assert correct behavior

        // Item data correctly restored
        $this->assertEquals(
            array( 'id_1', 'id_3' ),
            $deletedItems,
            'Item not indicated to be delted.'
        );

        // Meta data actualized correctly
        $this->assertEquals(
            array(
                'id_1' => 23, // Kept since available in other storage
                'id_2' => 42,
            ),
            $meta->data['lfu'],
            "Meta data not actualized correctly."
        );
        
        // Storage data kept correctly
        $this->assertEquals(
            array(
                'id_1' => array(
                    'barid' => true,
                ),
                'id_2' => array(
                    'fooid' => true,
                ),
            ),
            $meta->data['storages'],
            'Storage data not correctly updated.'
        );
        
        // Cache location empty
        $this->assertEquals(
            1,
            count( glob( "$tmpDir/*" ) ),
            'Cache location contains incorrect number of items.'
        );
    }
}
?>
