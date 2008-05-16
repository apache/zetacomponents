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

    public function testCreateMetaData()
    {
        $this->assertEquals(
            new ezcCacheStackLfuMetaData(),
            ezcCacheStackLfuReplacementStrategy::createMetaData()
        );
    }

    public function testInvalidMetaData()
    {
        $conf = new ezcCacheStackStorageConfiguration(
            'storage_id_1',
            new ezcCacheStorageFileArray(
                $this->createTempDir( __CLASS__ )
            ),
            5,
            0.5
        );
        $meta = new ezcCacheStackLruMetaData();

        try
        {
            ezcCacheStackLfuReplacementStrategy::store(
                $conf,
                $meta,
                'id_6',
                'id_6_content'
            );
            $this->fail( 'Exception not thrown on invalid meta data.' );
        }
        catch ( ezcCacheInvalidMetaDataException $e ) {}

        $this->removeTempDir();
    }

    public function testStoreNewMetaNewItemNoFree()
    {
        $conf = new ezcCacheStackStorageConfiguration(
            'storage_id_1',
            new ezcCacheStorageFileArray(
                $this->createTempDir( __CLASS__ )
            ),
            5,
            0.5
        );
        $meta = new ezcCacheStackLfuMetaData();

        ezcCacheStackLfuReplacementStrategy::store(
            $conf,
            $meta,
            'id_6',
            'id_6_content'
        );

        $metaData = $meta->getState();

        $this->assertEquals(
            'id_6_content',
            $conf->storage->restore( 'id_6' ),
            'Data not stored correctly.'
        );

        $this->assertEquals(
            // Creation date of test case. Clock correct?
            1,
            $metaData['replacementData']['id_6'],
            'Meta data entry not created correctly.'
        );

        $this->assertEquals( 
            array(
                'id_6' => true,
            ),
            $metaData['storageData']['storage_id_1']
        );
        $this->removeTempDir();
    }

    public function testStoreNoNewMetaNewItemNoFree()
    {
        $conf = new ezcCacheStackStorageConfiguration(
            'storage_id_1',
            new ezcCacheStorageFileArray(
                $this->createTempDir( __CLASS__ )
            ),
            5,
            0.5
        );
        $meta = new ezcCacheStackLfuMetaData();
        $meta->setState( array(
            'replacementData' => array(
                'id_1' => 23,
            ),
            'storageData' => array(
                'storage_id_42' => array(
                    'id_1' => true,
                ),
            ),
        ) );

        ezcCacheStackLfuReplacementStrategy::store(
            $conf,
            $meta,
            'id_6',
            'id_6_content'
        );

        $metaData = $meta->getState();

        $this->assertEquals(
            'id_6_content',
            $conf->storage->restore( 'id_6' ),
            'Data not stored correctly.'
        );

        $this->assertEquals(
            1,
            $metaData['replacementData']['id_6'],
            'Meta data entry not created correctly.'
        );

        $this->assertEquals(
            23,
            $metaData['replacementData']['id_1'],
            'Meta data entry not kept correctly.'
        );

        $this->assertEquals( 
            array(
                'storage_id_42' => array(
                    'id_1' => true,
                ),
                'storage_id_1' => array(
                    'id_6' => true,
                )
            ),
            $metaData['storageData']
        );
        $this->removeTempDir();
    }

    public function testStoreOldItemNoFree()
    {
        $conf = new ezcCacheStackStorageConfiguration(
            'storage_id_1',
            new ezcCacheStorageFileArray(
                $this->createTempDir( __CLASS__ )
            ),
            5,
            0.5
        );
        $meta = new ezcCacheStackLfuMetaData();
        $meta->setState( array(
            'replacementData' => array(
                'id_6' => 23,
            ),
            'storageData' => array(
                'storage_id_1' => array(
                    'id_6' => true,
                ),
            ),
        ) );

        $conf->storage->store( 'id_6', 'bazcontent' );

        ezcCacheStackLfuReplacementStrategy::store(
            $conf,
            $meta,
            'id_6',
            'id_6_content'
        );

        $metaData = $meta->getState();

        $this->assertEquals(
            'id_6_content',
            $conf->storage->restore( 'id_6' ),
            'Data not stored correctly.'
        );

        $this->assertEquals(
            24,
            $metaData['replacementData']['id_6'],
            'Meta data entry not created correctly.'
        );

        $this->assertEquals( 
            array(
                'storage_id_1' => array(
                    'id_6' => true,
                ),
            ),
            $metaData['storageData']
        );
        $this->removeTempDir();
    }

    public function testStoreNoNewMetaNewItemFreePurge()
    {
        // Prepare faked test data

        $tmpDir = $this->createTempDir( __CLASS__ );
        $conf = new ezcCacheStackStorageConfiguration(
            'storage_id_1',
            new ezcCacheStorageFileArray(
                $tmpDir,
                array( 'ttl' => 30 )
            ),
            5,
            0.5
        );
        
        $now = time();

        // Store max number of items
        $conf->storage->store( 'id_1', 'id_1_content' );
        $conf->storage->store( 'id_2', 'id_2_content' );
        $conf->storage->store( 'id_3', 'id_3_content' );
        $conf->storage->store( 'id_4', 'id_4_content' );
        $conf->storage->store( 'id_5', 'id_5_content' );

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

        $meta = new ezcCacheStackLfuMetaData();
        $meta->setState( array(
            'replacementData' => array(
                // Fake access times, not necessarily reflect file mtimes
                'id_1' => 10,
                'id_2' => 100,  // Expired
                'id_3' => 5,    // Expired
                'id_4' => 23,
                'id_5' => 42,   // Expired but kept, since available in other storage
            ),
            'storageData' => array(
                'storage_id_1' => array(
                    'id_1' => true,
                    'id_2' => true,
                    'id_3' => true,
                    'id_4' => true,
                    'id_5' => true,
                ),
                'storage_id_42' => array(
                    'id_1' => true,
                    'id_5' => true,
                ),
            ),
        ) );

        // Perform actual action

        ezcCacheStackLfuReplacementStrategy::store(
            $conf,
            $meta,
            'id_6',
            'id_6_content'
        );

        $metaData = $meta->getState();

        // Assert correct behaviour

        // Data has actually been stored
        $this->assertEquals(
            'id_6_content',
            $conf->storage->restore( 'id_6' ),
            'Data not stored correctly.'
        );

        // Time stamp has been stored correctly
        $this->assertEquals(
            1,
            $metaData['replacementData']['id_6'],
            'Meta data entry not created correctly.'
        );

        // Storage has been saved correctly
        $this->assertEquals( 
            array(
                'storage_id_1' => array(
                    'id_1' => true, // Old
                    'id_4' => true, // Old
                    'id_6' => true  // New
                ),
                'storage_id_42' => array(
                    'id_1' => true, // Old
                    'id_5' => true, // Old
                ),
            ),
            $metaData['storageData'],
            'Storage meta data not inserted correctly.'
        );

        // Remove stored item data from meta data again to comfortably assert
        // removal operations
        unset( $metaData['replacementData']['id_6'], $metaData['storageData']['barid'] );

        // LRU data correctly updated
        $this->assertEquals(
            // Note the sorting was not performed!
            array(
                'id_1' => 10,
                'id_4' => 23,
                'id_5' => 42,   // Expired but kept, since available in storage_id_42
            ),
            $metaData['replacementData'],
            'Meta data entries not correctly updated.'
        );

        // Make sure items have been deleted from disc
        $this->assertEquals(
            // id_1, id_5 and id_6
            3,
            count( glob( "$tmpDir/*" ) ),
            'Number of items on disc incorrect.'
        );

        // Restore existing items to check correct items exist
        $this->assertEquals(
            'id_1_content',
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
            'storage_id_1',
            new ezcCacheStorageFileArray(
                $tmpDir,
                array( 'ttl' => 30 )
            ),
            5,
            0.5
        );
        
        $now = time();

        // Store max number of items
        $conf->storage->store( 'id_1', 'id_1_content' );
        $conf->storage->store( 'id_2', 'id_2_content' );
        $conf->storage->store( 'id_3', 'id_3_content' );
        $conf->storage->store( 'id_4', 'id_4_content' );
        $conf->storage->store( 'id_5', 'id_5_content' );

        // None expired

        $meta = new ezcCacheStackLfuMetaData();
        $meta->setState( array(
            'replacementData' => array(
                // Fake access times, not necessarily reflect file mtimes
                'id_1' => 150,
                'id_2' => 23,   // Throwen out
                'id_3' => 42,   // Throwen out
                'id_4' => 100,
                'id_5' => 5,    // Throwen out but kept, since available in other storage
            ),
            'storageData' => array(
                'storage_id_1' => array(
                    'id_1' => true,
                    'id_2' => true,
                    'id_3' => true,
                    'id_4' => true,
                    'id_5' => true,
                ),
                'storage_id_42' => array(
                    'id_1' => true,
                    'id_5' => true,
                )
            ),
        ) );

        // Perform actual action

        ezcCacheStackLfuReplacementStrategy::store(
            $conf,
            $meta,
            'id_6',
            'id_6_content'
        );

        $metaData = $meta->getState();

        // Assert correct behaviour

        // Data has actually been stored
        $this->assertEquals(
            'id_6_content',
            $conf->storage->restore( 'id_6' ),
            'Data not stored correctly.'
        );

        // Time stamp has been stored correctly
        $this->assertEquals(
            1,
            $metaData['replacementData']['id_6'],
            'Meta data entry not created correctly.'
        );

        // Storage data updated correctly
        $this->assertEquals( 
            array(
                'storage_id_1' => array(
                    'id_1' => true,
                    'id_4' => true,
                    'id_6' => true,
                ),
                'storage_id_42' => array(
                    'id_1' => true,
                    'id_5' => true,
                )
            ),
            $metaData['storageData'],
            'Storage meta data not inserted correctly.'
        );

        // Remove stored item data from meta data again to comfortably assert
        // removal operations
        unset( $metaData['replacementData']['id_6'] );

        // LRU data correctly updated
        $this->assertEquals(
            // Note the sorting
            array(
                'id_5' => 5,    // Throwen out but kept, since available in other storage
                'id_4' => 100,
                'id_1' => 150,
            ),
            $metaData['replacementData'],
            'Meta data entries not correctly updated.'
        );

        // Make sure items have been deleted from disc
        $this->assertEquals(
            // id_1, id_4 and id_6
            3,
            count( glob( "$tmpDir/*" ) ),
            'Number of items on disc incorrect.'
        );

        // Restore existing items to check correct items exist
        $this->assertEquals(
            'id_1_content',
            $conf->storage->restore( 'id_1' ),
            'Data on disc incorrect.'
        );
        $this->assertEquals(
            'id_4_content',
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

    public function testStoreNoNewMetaNewItemFreePurgeWithAttributes()
    {
        // Prepare faked test data

        $tmpDir = $this->createTempDir( __CLASS__ );
        $conf = new ezcCacheStackStorageConfiguration(
            'storage_id_1',
            new ezcCacheStorageFileArray(
                $tmpDir,
                array( 'ttl' => 30 )
            ),
            5,
            0.5
        );
        
        $now = time();

        // Store max number of items
        $conf->storage->store( 'id_1', 'id_1_content', array( 'lang' => 'de', 'section' => 'news' ) );
        $conf->storage->store( 'id_2', 'id_2_content', array( 'lang' => 'en', 'section' => 'news' ) );
        $conf->storage->store( 'id_3', 'id_3_content', array( 'lang' => 'no', 'section' => 'news' ) );
        $conf->storage->store( 'id_4', 'id_4_content', array( 'lang' => 'en', 'section' => 'news' ) );
        $conf->storage->store( 'id_5', 'id_5_content', array( 'lang' => 'en', 'section' => 'news' ) );

        // Expire 3 items
        touch(
            $tmpDir . '/' . $conf->storage->generateIdentifier( 'id_2', array( 'lang' => 'en', 'section' => 'news' ) ),
            ( $now - 40 ),
            ( $now - 40 )
        );
        touch(
            $tmpDir . '/' . $conf->storage->generateIdentifier( 'id_3', array( 'lang' => 'no', 'section' => 'news' ) ),
            ( $now - 40 ),
            ( $now - 40 )
        );
        touch(
            $tmpDir . '/' . $conf->storage->generateIdentifier( 'id_5', array( 'lang' => 'en', 'section' => 'news' ) ),
            ( $now - 40 ),
            ( $now - 40 )
        );

        $meta = new ezcCacheStackLfuMetaData();
        $meta->setState( array(
            'replacementData' => array(
                // Fake access times, not necessarily reflect file mtimes
                'id_1' => 10,
                'id_2' => 100,  // Expired
                'id_3' => 5,    // Expired
                'id_4' => 23,
                'id_5' => 42,   // Expired but kept, since available in other storage
            ),
            'storageData' => array(
                'storage_id_1' => array(
                    'id_1' => true,
                    'id_2' => true,
                    'id_3' => true,
                    'id_4' => true,
                    'id_5' => true,
                ),
                'storage_id_42' => array(
                    'id_1' => true,
                    'id_5' => true,
                ),
            ),
        ) );

        // Perform actual action

        ezcCacheStackLfuReplacementStrategy::store(
            $conf,
            $meta,
            'id_6',
            'id_6_content',
            array( 'lang' => 'de', 'section' => 'news' )
        );

        $metaData = $meta->getState();

        // Assert correct behaviour

        // Data has actually been stored
        $this->assertEquals(
            'id_6_content',
            $conf->storage->restore( 'id_6', null, true ),
            'Data not stored correctly.'
        );

        // Time stamp has been stored correctly
        $this->assertEquals(
            1,
            $metaData['replacementData']['id_6'],
            'Meta data entry not created correctly.'
        );

        // Storage has been saved correctly
        $this->assertEquals( 
            array(
                'storage_id_1' => array(
                    'id_1' => true, // Old
                    'id_4' => true, // Old
                    'id_6' => true  // New
                ),
                'storage_id_42' => array(
                    'id_1' => true, // Old
                    'id_5' => true, // Old
                ),
            ),
            $metaData['storageData'],
            'Storage meta data not inserted correctly.'
        );

        // Remove stored item data from meta data again to comfortably assert
        // removal operations
        unset( $metaData['replacementData']['id_6'], $metaData['storageData']['barid'] );

        // LRU data correctly updated
        $this->assertEquals(
            // Note the sorting was not performed!
            array(
                'id_1' => 10,
                'id_4' => 23,
                'id_5' => 42,   // Expired but kept, since available in storage_id_42
            ),
            $metaData['replacementData'],
            'Meta data entries not correctly updated.'
        );

        // Make sure items have been deleted from disc
        $this->assertEquals(
            // id_1, id_5 and id_6
            3,
            count( glob( "$tmpDir/*" ) ),
            'Number of items on disc incorrect.'
        );

        // Restore existing items to check correct items exist
        $this->assertEquals(
            'id_1_content',
            $conf->storage->restore( 'id_1', null, true ),
            'Data on disc incorrect.'
        );
        $this->assertFalse(
            $conf->storage->restore( 'id_5', null, true ),
            'Data on disc incorrect.'
        );
        $this->removeTempDir();
    }

    public function testStoreNoNewMetaNewItemFreeDeleteWithAttributes()
    {
        // Prepare faked test data

        $tmpDir = $this->createTempDir( __CLASS__ );
        $conf = new ezcCacheStackStorageConfiguration(
            'storage_id_1',
            new ezcCacheStorageFileArray(
                $tmpDir,
                array( 'ttl' => 30 )
            ),
            5,
            0.5
        );
        
        $now = time();

        // Store max number of items
        $conf->storage->store( 'id_1', 'id_1_content', array( 'lang' => 'de', 'section' => 'news' ) );
        $conf->storage->store( 'id_2', 'id_2_content', array( 'lang' => 'en', 'section' => 'news' ) );
        $conf->storage->store( 'id_3', 'id_3_content', array( 'lang' => 'no', 'section' => 'news' ) );
        $conf->storage->store( 'id_4', 'id_4_content', array( 'lang' => 'en', 'section' => 'news' ) );
        $conf->storage->store( 'id_5', 'id_5_content', array( 'lang' => 'en', 'section' => 'news' ) );

        // None expired

        $meta = new ezcCacheStackLfuMetaData();
        $meta->setState( array(
            'replacementData' => array(
                // Fake access times, not necessarily reflect file mtimes
                'id_1' => 150,
                'id_2' => 23,   // Throwen out
                'id_3' => 42,   // Throwen out
                'id_4' => 100,
                'id_5' => 5,    // Throwen out but kept, since available in other storage
            ),
            'storageData' => array(
                'storage_id_1' => array(
                    'id_1' => true,
                    'id_2' => true,
                    'id_3' => true,
                    'id_4' => true,
                    'id_5' => true,
                ),
                'storage_id_42' => array(
                    'id_1' => true,
                    'id_5' => true,
                )
            ),
        ) );

        // Perform actual action

        ezcCacheStackLfuReplacementStrategy::store(
            $conf,
            $meta,
            'id_6',
            'id_6_content',
            array( 'lang' => 'de', 'section' => 'news' )
        );

        $metaData = $meta->getState();

        // Assert correct behaviour

        // Data has actually been stored
        $this->assertEquals(
            'id_6_content',
            $conf->storage->restore( 'id_6', null, true ),
            'Data not stored correctly.'
        );

        // Time stamp has been stored correctly
        $this->assertEquals(
            1,
            $metaData['replacementData']['id_6'],
            'Meta data entry not created correctly.'
        );

        // Storage data updated correctly
        $this->assertEquals( 
            array(
                'storage_id_1' => array(
                    'id_1' => true,
                    'id_4' => true,
                    'id_6' => true,
                ),
                'storage_id_42' => array(
                    'id_1' => true,
                    'id_5' => true,
                )
            ),
            $metaData['storageData'],
            'Storage meta data not inserted correctly.'
        );

        // Remove stored item data from meta data again to comfortably assert
        // removal operations
        unset( $metaData['replacementData']['id_6'] );

        // LRU data correctly updated
        $this->assertEquals(
            // Note the sorting
            array(
                'id_5' => 5,    // Throwen out but kept, since available in other storage
                'id_4' => 100,
                'id_1' => 150,
            ),
            $metaData['replacementData'],
            'Meta data entries not correctly updated.'
        );

        // Make sure items have been deleted from disc
        $this->assertEquals(
            // id_1, id_4 and id_6
            3,
            count( glob( "$tmpDir/*" ) ),
            'Number of items on disc incorrect.'
        );

        // Restore existing items to check correct items exist
        $this->assertEquals(
            'id_1_content',
            $conf->storage->restore( 'id_1', null, true ),
            'Data on disc incorrect.'
        );
        $this->assertEquals(
            'id_4_content',
            $conf->storage->restore( 'id_4', null, true ),
            'Data on disc incorrect.'
        );
        $this->assertFalse(
            // Deleted on disc, but still in meta data
            $conf->storage->restore( 'id_5', null, true ),
            'Data on disc incorrect.'
        );
        $this->removeTempDir();
    }

    public function testStoreNoNewMetaNewItemFreePurgeDelete()
    {
        // Prepare faked test data

        $tmpDir = $this->createTempDir( __CLASS__ );
        $conf = new ezcCacheStackStorageConfiguration(
            'storage_id_1',
            new ezcCacheStorageFileArray(
                $tmpDir,
                array( 'ttl' => 30 )
            ),
            5,
            0.5
        );
        
        $now = time();

        // Store max number of items
        $conf->storage->store( 'id_1', 'id_1_content' );
        $conf->storage->store( 'id_2', 'id_2_content' );
        $conf->storage->store( 'id_3', 'id_3_content' );
        $conf->storage->store( 'id_4', 'id_4_content' );
        $conf->storage->store( 'id_5', 'id_5_content' );

        // id_2 expired
        touch(
            $tmpDir . '/' . $conf->storage->generateIdentifier( 'id_2' ),
            ( $now - 40 ),
            ( $now - 40 )
        );

        $meta = new ezcCacheStackLfuMetaData();
        $meta->setState( array(
            'replacementData' => array(
                // Fake access times, not necessarily reflect file mtimes
                'id_1' => 150,
                'id_2' => 150,  // Expired
                'id_3' => 23,   // Throwen out
                'id_4' => 100,
                'id_5' => 42,   // Throwen out, but kept in meta data, since available in other storage
            ),
            'storageData' => array(
                'storage_id_1' => array(
                    'id_1' => true,
                    'id_2' => true,
                    'id_3' => true,
                    'id_4' => true,
                    'id_5' => true,
                ),
                'storage_id_42' => array(
                    'id_1' => true,
                    'id_5' => true,
                )
            ),
        ) );

        // Perform actual action

        ezcCacheStackLfuReplacementStrategy::store(
            $conf,
            $meta,
            'id_6',
            'id_6_content'
        );

        $metaData = $meta->getState();

        // Assert correct behaviour

        // Data has actually been stored
        $this->assertEquals(
            'id_6_content',
            $conf->storage->restore( 'id_6' ),
            'Data not stored correctly.'
        );

        // Time stamp has been stored correctly
        $this->assertEquals(
            1,
            $metaData['replacementData']['id_6'],
            'Meta data entry not created correctly.'
        );

        // Storage data updated correctly
        $this->assertEquals( 
            array(
                'storage_id_1' => array(
                    'id_1' => true,
                    'id_4' => true,
                    'id_6' => true,
                ),
                'storage_id_42' => array(
                    'id_1' => true,
                    'id_5' => true,
                )
            ),
            $metaData['storageData'],
            'Storage meta data not inserted correctly.'
        );

        // Remove stored item data from meta data again to comfortably assert
        // removal operations
        unset( $metaData['replacementData']['id_6'] );

        // LRU data correctly updated
        $this->assertEquals(
            // Note the sorting
            array(
                'id_5' => 42,   // Throwen out, but kept in meta data, since available in other storage
                'id_4' => 100,
                'id_1' => 150,
            ),
            $metaData['replacementData'],
            'Meta data entries not correctly updated.'
        );

        // Make sure items have been deleted from disc
        $this->assertEquals(
            // id_1, id_4 and id_6
            3,
            count( glob( "$tmpDir/*" ) ),
            'Number of items on disc incorrect.'
        );

        // Restore existing items to check correct items exist
        $this->assertEquals(
            'id_1_content',
            $conf->storage->restore( 'id_1' ),
            'Data on disc incorrect.'
        );
        $this->assertEquals(
            'id_4_content',
            $conf->storage->restore( 'id_4' ),
            'Data on disc incorrect.'
        );
        $this->assertFalse(
            $conf->storage->restore( 'id_5' ),
            'Data on disc incorrect.'
        );
        $this->removeTempDir();
    }

    // This test changes, sine the behaviour as it was tested here was incorrect
    public function testStoreNoNewMetaNewItemFreePurgeDeleteComplex()
    {
        // Prepare faked test data

        $tmpDir = $this->createTempDir( __CLASS__ );
        $conf = new ezcCacheStackStorageConfiguration(
            'storage_id_1',
            new ezcCacheStorageFileArray(
                $tmpDir,
                array( 'ttl' => 30 )
            ),
            5,
            0.5
        );
        
        $now = time();

        // Store max number of items
        $conf->storage->store( 'id_1', 'id_1_content' );
        $conf->storage->store( 'id_2', 'id_2_content' );
        $conf->storage->store( 'id_3', 'id_3_content' );
        $conf->storage->store( 'id_4', 'id_4_content' );
        // $conf->storage->store( 'id_5', 'id_5_content' );

        // id_2 expired
        touch(
            $tmpDir . '/' . $conf->storage->generateIdentifier( 'id_2' ),
            ( $now - 40 ),
            ( $now - 40 )
        );

        $meta = new ezcCacheStackLfuMetaData();
        $meta->setState( array(
            'replacementData' => array(
                // Fake access times, not necessarily reflect file mtimes
                'id_1' => 100,
                'id_2' => 150,  // Expired
                'id_3' => 23,
                'id_4' => 150,  
                'id_5' => 42,   // Kept, since not in actual storage
            ),
            'storageData' => array(
                'storage_id_1' => array(
                    'id_1' => true,
                    'id_2' => true,
                    'id_3' => true,
                    'id_4' => true,
                ),
                'storage_id_42' => array(
                    'id_5' => true,
                ),
            ),
        ) );

        // Perform actual action

        ezcCacheStackLfuReplacementStrategy::store(
            $conf,
            $meta,
            'id_6',
            'id_6_content'
        );

        $metaData = $meta->getState();

        // Assert correct behaviour

        // Data has actually been stored
        $this->assertEquals(
            'id_6_content',
            $conf->storage->restore( 'id_6' ),
            'Data not stored correctly.'
        );

        // Time stamp has been stored correctly
        $this->assertEquals(
            1,
            $metaData['replacementData']['id_6'],
            'Meta data entry not created correctly.'
        );

        // Storage has been saved correctly
        $this->assertEquals( 
            array(
                'storage_id_1' => array(
                    'id_1' => true,
                    'id_2' => true,
                    'id_3' => true,
                    'id_4' => true,
                    'id_6' => true,
                ),
                'storage_id_42' => array(
                    'id_5' => true,
                ),
            ),
            $metaData['storageData'],
            'Storage meta data not inserted correctly.'
        );

        // Remove stored item data from meta data again to comfortably assert
        // removal operations
        unset( $metaData['replacementData']['id_6'] );

        // LRU data correctly updated
        $this->assertEquals(
            // Note the sorting has not been performed!
            array(
                'id_1' => 100,
                'id_2' => 150,  // Expired
                'id_3' => 23,
                'id_4' => 150,  
                'id_5' => 42,   // Kept, since not in actual storage
            ),
            $metaData['replacementData'],
            'Meta data entries not correctly updated.'
        );

        // Make sure items have been deleted from disc
        $this->assertEquals(
            // All 4 previous + id_6
            5,
            count( glob( "$tmpDir/*" ) ),
            'Number of items on disc incorrect.'
        );

        $this->removeTempDir();
    }

    public function testRestoreSuccess()
    {
        // Prepare faked test data

        $tmpDir = $this->createTempDir( __CLASS__ );
        $conf = new ezcCacheStackStorageConfiguration(
            'storage_id_1',
            new ezcCacheStorageFileArray(
                $tmpDir,
                array( 'ttl' => 30 )
            ),
            5,
            0.5
        );
        
        $now = time();

        // Store max number of items
        $conf->storage->store( 'id_1', 'id_1_content' );
        
        $meta = new ezcCacheStackLfuMetaData();
        $meta->setState( array(
            'replacementData' => array(
                // Fake access times, not necessarily reflect file mtimes
                'id_1' => 23,
            ),
            'storageData' => array(
                'storage_id_1' => array(
                    'id_1' => true,
                ),
                'storage_id_42' => array(
                    'id_1'=> true,
                ),
            ),
        ) );

        // Perform actual action

        $item = ezcCacheStackLfuReplacementStrategy::restore(
            $conf,
            $meta,
            'id_1'
        );

        $metaData = $meta->getState();

        // Assert correct behavior

        // Item data correctly restored
        $this->assertEquals(
            'id_1_content',
            $item,
            'Item not restored correctly.'
        );

        // Meta data actualized correctly
        $this->assertEquals(
            24,
            $metaData['replacementData']['id_1']
        );
        
        // Storage data kept correctly
        $this->assertEquals(
            array(
                'storage_id_1' => array(
                    'id_1' => true,
                ),
                'storage_id_42' => array(
                    'id_1'=> true,
                ),
            ),
            $metaData['storageData'],
            'Storage data not correctly updated.'
        );
    }

    public function testRestoreFailureExpired()
    {
        // Prepare faked test data

        $tmpDir = $this->createTempDir( __CLASS__ );
        $conf = new ezcCacheStackStorageConfiguration(
            'storage_id_1',
            new ezcCacheStorageFileArray(
                $tmpDir,
                array( 'ttl' => 30 )
            ),
            5,
            0.5
        );
        
        $now = time();

        // Store max number of items
        $conf->storage->store( 'id_1', 'id_1_content' );
        
        // Expire
        touch(
            $tmpDir . '/' . $conf->storage->generateIdentifier( 'id_1' ),
            ( $now - 40 ),
            ( $now - 40 )
        );
        
        $meta = new ezcCacheStackLfuMetaData();
        $meta->setState( array(
            'replacementData' => array(
                // Fake access times, not necessarily reflect file mtimes
                'id_1' => 23,
            ),
            'storageData' => array(
                'storage_id_1' => array(
                    'id_1' => true,
                ),
                'storage_id_42' => array(
                    'id_1' => true,
                ),
            ),
        ) );

        // Perform actual action

        $item = ezcCacheStackLfuReplacementStrategy::restore(
            $conf,
            $meta,
            'id_1'
        );

        $metaData = $meta->getState();

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
            $metaData['replacementData']
        );
        
        // Storage data kept correctly
        $this->assertEquals(
            array(
                'storage_id_42' => array(
                    'id_1' => true,
                ),
            ),
            $metaData['storageData'],
            'Storage data not correctly updated.'
        );
    }

    public function testRestoreFailureNonexistent()
    {
        // Prepare faked test data

        $tmpDir = $this->createTempDir( __CLASS__ );
        $conf = new ezcCacheStackStorageConfiguration(
            'storage_id_1',
            new ezcCacheStorageFileArray(
                $tmpDir,
                array( 'ttl' => 30 )
            ),
            5,
            0.5
        );
        
        $meta = new ezcCacheStackLfuMetaData();
        $meta->setState( array(
            'replacementData' => array(),
            'storageData' => array(),
        ) );

        // Perform actual action

        $item = ezcCacheStackLfuReplacementStrategy::restore(
            $conf,
            $meta,
            'id_1'
        );

        $metaData = $meta->getState();

        // Assert correct behavior

        // Item data correctly restored
        $this->assertFalse(
            $item,
            'Item exists although expired.'
        );

        // Meta data actualized correctly
        $this->assertEquals(
            array(),
            $metaData['replacementData']
        );
        
        // Storage data kept correctly
        $this->assertEquals(
            array(),
            $metaData['storageData'],
            'Storage data not correctly updated.'
        );
    }

    public function testDeleteSuccess()
    {
        // Prepare faked test data

        $tmpDir = $this->createTempDir( __CLASS__ );
        $conf = new ezcCacheStackStorageConfiguration(
            'storage_id_1',
            new ezcCacheStorageFileArray(
                $tmpDir,
                array( 'ttl' => 30 )
            ),
            5,
            0.5
        );

        // Store max number of items
        $conf->storage->store( 'id_1', 'id_1_content' );
        
        // Cache location not empty
        $this->assertEquals(
            1,
            count( glob( "$tmpDir/*" ) ),
            'Cache location contains unknown items.'
        );
        
        $meta = new ezcCacheStackLfuMetaData();
        $meta->setState( array(
            'replacementData' => array(
                'id_1' => 42,
            ),
            'storageData' => array(
                'storage_id_1' => array(
                    'id_1' => true,
                ),
                'storage_id_42' => array(
                    'id_1' => true,
                ),
            ),
        ) );

        // Perform actual action

        $deletedItems = ezcCacheStackLfuReplacementStrategy::delete(
            $conf,
            $meta,
            'id_1'
        );

        $metaData = $meta->getState();

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
            $metaData['replacementData']
        );
        
        // Storage data kept correctly
        $this->assertEquals(
            array(
                'storage_id_42' => array(
                    'id_1' => true,
                ),
            ),
            $metaData['storageData'],
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
            'storage_id_1',
            new ezcCacheStorageFileArray(
                $tmpDir,
                array( 'ttl' => 30 )
            ),
            5,
            0.5
        );

        $meta = new ezcCacheStackLfuMetaData();
        $meta->setState( array(
            'replacementData' => array(
            ),
            'storageData' => array(
                'storage_id_42' => array(
                    'id_1' => true,
                ),
            ),
        ) );

        // Perform actual action

        $deletedItems = ezcCacheStackLfuReplacementStrategy::delete(
            $conf,
            $meta,
            'id_1'
        );

        $metaData = $meta->getState();

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
            $metaData['replacementData']
        );
        
        // Storage data kept correctly
        $this->assertEquals(
            array(
                'storage_id_42' => array(
                    'id_1' => true,
                ),
            ),
            $metaData['storageData'],
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
            'storage_id_1',
            new ezcCacheStorageFileArray(
                $tmpDir,
                array( 'ttl' => 30 )
            ),
            5,
            0.5
        );

        // Store max number of items
        $conf->storage->store( 'id_1', 'id_1_content', array( 'lang' => 'en' ) );
        $conf->storage->store( 'id_2', 'id_2_content' );
        $conf->storage->store( 'id_3', 'id_3_content', array( 'lang' => 'en' ) );
        
        // Cache location not empty
        $this->assertEquals(
            3,
            count( glob( "$tmpDir/*" ) ),
            'Cache location contains unknown items.'
        );
        
        $meta = new ezcCacheStackLfuMetaData();
        $meta->setState( array(
            'replacementData' => array(
                'id_1' => 23,
                'id_2' => 42,
                'id_3' => 5,
            ),
            'storageData' => array(
                'storage_id_1' => array(
                    'id_1' => true,
                    'id_2' => true,
                    'id_3' => true,
                ),
                'storage_id_42' => array(
                    'id_1' => true,
                ),
            ),
        ) );

        // Perform actual action

        $deletedItems = ezcCacheStackLfuReplacementStrategy::delete(
            $conf,
            $meta,
            null,
            array( 'lang' => 'en' ),
            true
        );

        $metaData = $meta->getState();

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
            $metaData['replacementData'],
            "Meta data not actualized correctly."
        );
        
        // Storage data kept correctly
        $this->assertEquals(
            array(
                'storage_id_1' => array(
                    'id_2' => true,
                ),
                'storage_id_42' => array(
                    'id_1' => true,
                ),
            ),
            $metaData['storageData'],
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
