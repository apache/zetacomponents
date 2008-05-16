<?php
/**
 * ezcCacheStorageApcPlainTest 
 * 
 * @package Cache
 * @subpackage Tests
 * @version //autogen//
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Require parent test class. 
 */
require_once 'storage_test.php';
require_once 'wrappers/apc_wrapper.php';

/**
 * Test suite for ezcCacheStorageApc class. 
 * 
 * @package Cache
 * @subpackage Tests
 */
class ezcCacheStorageApcPlainTest extends ezcCacheStorageTest
{
    /**
     * Test data.
     *
     * @var array(string)
     */
    protected $testData = array(
        1 => "Test 1 2 3 4 5 6 7 8\\\\",
        2 => 'La la la 02064 lololo',
        3 => 12345,
        4 => 12.3746,
    );

    protected function setUp()
    {
        if ( !ezcBaseFeatures::hasExtensionSupport( 'apc' ) )
        {
            $this->markTestSkipped( "PHP must have APC support." );
        }

        // Class name == <inheriting class> - "Test"
        $storageClass = ( $this->storageClass = substr( get_class( $this ), 0, strlen( get_class(  $this ) ) - 4 ) );
        $this->storage = new $storageClass( $this->createTempDir( 'ezcCacheTest' ), array( 'ttl' => 10 ) );
    }

    // Override test from parent class
    public function testConstructorErrorLocationNotWriteable()
    {
        return true;
    }

    // Override test from parent class
    public function testStoreRestoreOutdatedWithoutAttributes()
    {
        $options = array( 'ttl' => 10 );
        $storage = new ezcCacheStorageApcWrapper( $this->getTempDir(), $options );
        $storage->reset();

        foreach ( $this->testData as $id => $dataArr ) 
        {
            $storage->store( $id, $dataArr );
            
            // Hack the cache to be outdated by 100 seconds
            $data = $storage->restore( $id );
            $registry = $storage->getRegistry();

            $location = $this->getTempDir() . DIRECTORY_SEPARATOR;
            list( $identifier, $dataObj ) = each( $registry[$location][$id] );
            $registry[$location][$id][$identifier]->time = time() - 100;
            $storage->setRegistry( $registry );

            $data = $storage->restore( $id );
            $this->assertTrue( $data === false, "Restore data broken for ID <{$id}>." );
        }

    }

    // Override test from parent class
    public function testStoreRestoreOutdatedWithAttributes()
    {
        $options = array( 'ttl' => 10 );
        $storage = new ezcCacheStorageApcWrapper( $this->getTempDir(), $options );
        $storage->reset();

        foreach ( $this->testData as $id => $dataArr ) 
        {
            $attributes = array(
                'name'      => 'test',
                'title'     => 'Test item',
                'date'      => time() . $id,
            );

            $storage->store( $id, $dataArr, $attributes );

            // Hack the cache to be outdated by 100 seconds
            $data = $storage->restore( $id, $attributes );
            $registry = $storage->getRegistry();

            $location = $this->getTempDir() . DIRECTORY_SEPARATOR;
            list( $identifier, $dataObj ) = each( $registry[$location][$id] );
            $registry[$location][$id][$identifier]->time = time() - 100;
            $storage->setRegistry( $registry );

            // Wait for cache to be outdated.
            $data = $storage->restore( $id, $attributes );
            $this->assertTrue( $data === false, "Restore data broken for ID <{$id}>." );
        }
    }

    public function testMockApcBackend()
    {
        $apcBackend = $this->getMock( 'ezcCacheApcBackend', array( 'store' ), array() );
        $apcBackend->expects( $this->any() )
                   ->method( 'store' )
                   ->will( $this->returnValue( false ) );

        $options = array( 'ttl' => 10 );
        $storage = new ezcCacheStorageApcWrapper( '.', $options );
        $storage->reset();
        $storage->setBackend( $apcBackend );

        $id = 'id';
        try
        {
            $storage->store( $id, 'data' );
            $this->fail( "Expected exception was not thrown." );
        }
        catch ( ezcCacheApcException $e )
        {
            $this->assertEquals( "Apc store failed.", $e->getMessage() );
        }
    }

    public function testStoreResource()
    {
        $resource = fopen( dirname( __FILE__ ) . DIRECTORY_SEPARATOR . 'wrappers' . DIRECTORY_SEPARATOR . 'apc_wrapper.php', 'r' );
        try
        {
            $this->storage->store( "key", $resource );
            $this->storage->reset();
            fclose( $resource );
            $this->fail( "Expected exception was not thrown." );
        }
        catch ( ezcCacheInvalidDataException $e )
        {
            fclose( $resource );
            $this->assertEquals( "The given data was of type 'resource', which can not be stored. Expecting: 'simple, array, object'.", $e->getMessage() );
        }
    }

    public function testGetRemainingLifetimeId()
    {
        $this->storage->setOptions( array( 'ttl' => 10 ) );

        $this->storage->store( '1', 'data1' );

        // "8 <= " - for those cases where the current second changes after the storage
        $this->assertEquals( true, 8 <= $this->storage->getRemainingLifetime( '1' ) );

    }

    public function testGetRemainingLifetimeAttributes()
    {
        $this->storage->reset();
        $this->storage->setOptions( array( 'ttl' => 10 ) );

        $this->storage->store( '1', 'data1', array( 'type' => 'simple' ) );
        $this->storage->store( '2', 'data2', array( 'type' => 'simple' ) );

        // "8 <= " - for those cases where the current second changes after the storage
        $this->assertEquals( true, 8 <= $this->storage->getRemainingLifetime( null, array( 'type' => 'simple' ) ) );

    }

    public function testGetRemainingLifetimeNoMatch()
    {
        $this->storage->setOptions( array( 'ttl' => 10 ) );

        $this->assertEquals( 0, $this->storage->getRemainingLifetime( 'no_such_id' ) );

    }

    public function testCacheManagerLocationEmpty()
    {
        $options = array( 'ttl' => 10 );
        ezcCacheManager::createCache( 'cache', null, 'ezcCacheStorageApcPlain', $options );
        $storage = ezcCacheManager::getCache( 'cache' );
        $storage->reset();
        $storage->store( 'key', 'data' );
        $this->assertEquals( 'data', $storage->restore( 'key' ) );
    }

    public function testStorageApcOptions()
    {
        $options = new ezcCacheStorageApcOptions();

        $this->assertTrue( isset( $options->ttl ) );
        $this->assertTrue( isset( $options->lockWaitTime ) );
        $this->assertTrue( isset( $options->maxLockTime ) );
        $this->assertTrue( isset( $options->lockKey ) );
        $this->assertTrue( isset( $options->metaDataKey ) );

        $this->assertEquals( $options->ttl, 86400 );
        
        $this->assertFalse( isset( $options->foo ), 'Exception not thrown on invalid property.' );

        $this->assertSetPropertyFails(
            $options,
            'ttl',
            array( true, 42.23, array(), new stdClass(), '', 'foo' )
        );
        $this->assertSetPropertyFails(
            $options,
            'lockWaitTime',
            array( true, false, -23, 42.23, array(), new stdClass(), '', 'foo' )
        );
        $this->assertSetPropertyFails(
            $options,
            'maxLockTime',
            array( true, false, -23, 42.23, array(), new stdClass(), '', 'foo' )
        );
        $this->assertSetPropertyFails(
            $options,
            'lockKey',
            array( true, false, 42, -23, 42.23, array(), new stdClass(), '' )
        );
        $this->assertSetPropertyFails(
            $options,
            'metaDataKey',
            array( true, false, 42, -23, 42.23, array(), new stdClass(), '' )
        );

        $this->assertSetProperty( $options, 'ttl', array( 1, 1000 ) );
        $this->assertSetProperty( $options, 'lockWaitTime', array( 1, 10 ) );
        $this->assertSetProperty( $options, 'maxLockTime', array( 1, 10 ) );
        $this->assertSetProperty( $options, 'lockKey', array( 'foo' ) );
        $this->assertSetProperty( $options, 'metaDataKey', array( 'foo' ) );

        try
        {
            $options->foo = 23;
            $this->fail( 'Exception not thrown on set for unknown property.' );
        }
        catch ( ezcBasePropertyNotFoundException $e ) {}
        try
        {
            echo $options->foo;
            $this->fail( 'Exception not thrown on get for unknown property.' );
        }
        catch ( ezcBasePropertyNotFoundException $e ) {}
    }
    
    public function testStorageOptions()
    {
        $storageOptions = new ezcCacheStorageOptions();
        $storageApcOptions = new ezcCacheStorageApcOptions();
        $arrayOptions = array();

        $storage = new ezcCacheStorageApcPlain(
            '.',
            array()
        );
        $storage->reset();

        $storage->setOptions( $storageApcOptions );
        $this->assertEquals( $storageApcOptions, $storage->getOptions() );

        $storage->options = $storageApcOptions;
        $this->assertEquals( $storageApcOptions, $storage->getOptions() );
        
        $storage->setOptions( $storageOptions );
        $this->assertEquals( $storageApcOptions, $storage->getOptions() );

        $storage->options = $storageOptions;
        $this->assertEquals( $storageApcOptions, $storage->getOptions() );
        
        $storage->setOptions( $arrayOptions );
        $this->assertEquals( $storageApcOptions, $storage->getOptions() );

        $storage->options = $arrayOptions;
        $this->assertEquals( $storageApcOptions, $storage->getOptions() );

        $options = new stdClass();
        try
        {
            $storage->setOptions( $options );
            $this->fail( "Expected exception was not thrown." );
        }
        catch ( ezcBaseValueException $e )
        {
            $this->assertEquals(
                "The value 'O:8:\"stdClass\":0:{}' that you were trying to "
                    . "assign to setting 'options' is invalid. Allowed values "
                    . "are: instance of ezcCacheStorageApcOptions.",
                $e->getMessage()
            );
        }
    }
    
    public function testResetSuccess()
    {
        $options = array( 'ttl' => 10 );
        $storage = new ezcCacheStorageApcWrapper( '.', $options );
        $storage->reset();

        $data = array( 
            'ID',
            'Some/Dir/ID',
            'Some/other/Dir/ID/1',
            'Some/other/Dir/ID/2',
            'Some/other/Dir/ID/3',
        );
        foreach ( $data as $id ) 
        {
            $storage->store( $id, $id );
        }

        $this->assertEquals(
            5,
            $storage->countDataItems()
        );

        $storage->reset();

        $this->assertEquals(
            0,
            $storage->countDataItems()
        );
    }

    public function testDeleteReturnIds()
    {
        $storage = new ezcCacheStorageApcWrapper(
            '.',
            array( 'ttl' => 100 )
        );
        $storage->reset();

        $data = array( 
            'ID',
            'Some/Dir/ID',
            'Some/other/Dir/ID/1',
            'Some/other/Dir/ID/2',
            'Some/other/Dir/ID/3',
        );

        $attributes = array(
            'lang' => 'en',
        );

        foreach ( $data as $id ) 
        {
            $storage->store( $id, $id, $attributes );
        }

        $deleted = $storage->delete( 'Some/other/Dir/ID/3', $attributes, true );
        
        $this->assertEquals(
            array( 'Some/other/Dir/ID/3' ),
            $deleted,
            'Deleted IDs not returned correctly.'
        );

        $deleted = $storage->delete( null, $attributes, true );

        $this->assertEquals(
            array( 
                'ID',
                'Some/Dir/ID',
                'Some/other/Dir/ID/1',
                'Some/other/Dir/ID/2',
            ),
            $deleted,
            'Deleted IDs not returned correctly.'
        );
    }

    public function testPurgeNoLimit()
    {
        $storage = new ezcCacheStorageApcWrapper(
            '.',
            array( 'ttl' => 1 )
        );
        $storage->reset();

        $data = array( 
            'ID',
            'Some/Dir/ID',
            'Some/other/Dir/ID/1',
            'Some/other/Dir/ID/2',
            'Some/other/Dir/ID/3',
        );

        foreach ( $data as $id ) 
        {
            $storage->store( $id, $id );
        }

        // Outdate
        usleep( 1000002 );

        $purgedIds = $storage->purge();

        $this->assertEquals(
            $data,
            $purgedIds,
            'Purged IDs not returned correctly.'
        );
    }

    public function testPurgeLimit()
    {
        $storage = new ezcCacheStorageApcWrapper(
            '.',
            array( 'ttl' => 1 )
        );
        $storage->reset();

        $data = array( 
            'ID',
            'Some/Dir/ID',
            'Some/other/Dir/ID/1',
            'Some/other/Dir/ID/2',
            'Some/other/Dir/ID/3',
        );

        foreach ( $data as $id ) 
        {
            $storage->store( $id, $id );
        }

        // Outdate
        usleep( 1000002 );

        $purgedIds = $storage->purge( 3 );

        $this->assertEquals(
            array( 
                'ID',
                'Some/Dir/ID',
                'Some/other/Dir/ID/1',
            ),
            $purgedIds,
            'Purged IDs not returned correctly.'
        );
    }

    public function testLockSimple()
    {
        $storage = new ezcCacheStorageApcWrapper(
            '.',
            array( 'ttl' => 1 )
        );
        $storage->reset();

        $lockKey = urlencode( $storage->getLocation() ) . '_'
            . $storage->options->lockKey;

        $this->assertFalse(
            apc_fetch( $lockKey ),
            'Lock key exists.'
        );

        $this->assertFalse(
            $this->getObjectAttribute( $storage, 'lock' ),
            'Lock stat not correctly initialized'
        );

        $storage->lock();

        $this->assertNotEquals(
            false,
            apc_fetch( $lockKey ),
            'Lock key not created correctly.'
        );

        $this->assertTrue(
            $this->getObjectAttribute( $storage, 'lock' ),
            'Lock stat not correctly switched.'
        );

        $storage->unlock();

        $this->assertFalse(
            apc_fetch( $lockKey ),
            'Lock key exists.'
        );

        $this->assertFalse(
            $this->getObjectAttribute( $storage, 'lock' ),
            'Lock stat not correctly initialized'
        );
    }

    public function testLockTimeout()
    {
        // Init 2 storages on same Memcache
        $opts = array(
            'ttl'         => 1,
            'maxLockTime' => 1
        );
        $storage = new ezcCacheStorageApcWrapper(
            '.',
            $opts
        );
        $storage->reset();
        $secondStorage = new ezcCacheStorageApcWrapper(
            '.',
            $opts
        );
        $secondStorage->reset();
        
        $lockKey = urlencode( $storage->getLocation() ) . '_'
            . $storage->options->lockKey;

        // Assert initial state
        $this->assertFalse(
            apc_fetch( $lockKey ),
            'Lock key exists.'
        );
        $this->assertFalse(
            $this->getObjectAttribute( $storage, 'lock' ),
            'Lock state not correctly initialized'
        );
        $this->assertFalse(
            $this->getObjectAttribute( $secondStorage, 'lock' ),
            'Lock state not correctly initialized in second storage'
        );

        $lockTime = time();
        // Perform lock
        $storage->lock();

        // Assert locked state
        $this->assertNotEquals(
            false,
            ( $oldLock = apc_fetch( $lockKey ) ),
            'Lock key not created correctly.'
        );
        $this->assertTrue(
            $this->getObjectAttribute( $storage, 'lock' ),
            'Lock stat not correctly switched.'
        );
        $this->assertFalse(
            $this->getObjectAttribute( $secondStorage, 'lock' ),
            'Lock state not correctly initialized in second storage'
        );

        // Should kill lock file after 1 sec
        $secondStorage->lock();

        // Assert that kill did not occur earlier
        $this->assertGreaterThanOrEqual(
            1,
            ( time() - $lockTime ),
            'Lock did not last for 1 sec.'
        );

        // Assert that lock key exists again
        $this->assertNotEquals(
            false,
            apc_fetch( $lockKey ),
            'Lock key not created correctly.'
        );
        // Assert that the new lock is not the same as the old one
        $this->assertGreaterThan(
            $oldLock,
            apc_fetch( $lockKey ),
            'Lock key not created correctly.'
        );
        // First storage does not note that its lock disappeared
        $this->assertTrue(
            $this->getObjectAttribute( $storage, 'lock' ),
            'Lock state switched unexpectedly.'
        );
        // Second storage now has the lock
        $this->assertTrue(
            $this->getObjectAttribute( $secondStorage, 'lock' ),
            'Lock state not correctly initialized in second storage'
        );

        $secondStorage->unlock();

        $this->assertFalse(
            apc_fetch( $lockKey ),
            'Lock key not created correctly.'
        );
        // First storage does not note that its lock disappeared and was not unlocked
        $this->assertTrue(
            $this->getObjectAttribute( $storage, 'lock' ),
            'Lock state switched unexpectedly.'
        );
        // Second storage released the lock
        $this->assertFalse(
            $this->getObjectAttribute( $secondStorage, 'lock' ),
            'Lock state not correctly initialized in second storage'
        );
    }

    public function testMetaDataSuccess()
    {
        $opts = array(
            'ttl'         => 1,
        );
        $storage = new ezcCacheStorageApcWrapper(
            '.',
            $opts
        );
        $storage->reset();
        
        $metaDataKey = urlencode( $storage->getLocation() ) . '_'
            . $storage->options->metaDataKey;

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

        $this->assertFalse(
            apc_fetch( $metaDataKey ),
            'Meta data key existed before the storage was created.'
        );

        $storage->storeMetaData( $meta );

        $this->assertEquals(
            $meta,
            apc_fetch( $metaDataKey )->var,
            'Meta data file existed before the storage was created.'
        );

        $restoredMeta = $storage->restoreMetaData();

        $this->assertEquals(
            $meta,
            $restoredMeta,
            'Meta data not restored correctly.'
        );

        $this->assertEquals(
            $meta,
            apc_fetch( $metaDataKey )->var,
            'Meta data file existed before the storage was created.'
        );
    }

    public function testMetaDataFailure()
    {
        $opts = array(
            'ttl'         => 1,
        );
        $storage = new ezcCacheStorageApcWrapper(
            '.',
            $opts
        );
        $storage->reset();

        $metaDataKey = urlencode( $storage->getLocation() ) . '_'
            . $storage->options->metaDataKey;

        $this->assertFalse(
            apc_fetch( $metaDataKey ),
            'Meta data file existed before the storage was created.'
        );

        $restoredMeta = $storage->restoreMetaData();

        $this->assertNull(
            $restoredMeta,
            'Meta data not restored correctly.'
        );

        $this->assertFalse(
            apc_fetch( $metaDataKey ),
            'Meta data file existed before the storage was created.'
        );
    }

    public static function suite()
	{
		return new PHPUnit_Framework_TestSuite( __CLASS__ );
	}
}
?>
