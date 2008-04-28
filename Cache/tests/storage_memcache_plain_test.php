<?php
/**
 * ezcCacheStorageMemcachePlainTest 
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
require_once 'wrappers/memcache_wrapper.php';

/**
 * Test suite for ezcCacheStorageMemcachePlain class. 
 * 
 * @package Cache
 * @subpackage Tests
 */
class ezcCacheStorageMemcachePlainTest extends ezcCacheStorageTest
{
    /**
     * Test data.
     *
     * @var array(string)
     */
    protected $testData;

    protected function setUp()
    {
        if ( !ezcBaseFeatures::hasExtensionSupport( 'memcache' ) )
        {
            $this->markTestSkipped( 'PHP must have Memcache support.' );
        }

        if ( !ezcBaseFeatures::hasExtensionSupport( 'zlib' ) )
        {
            $this->markTestSkipped( 'PHP must be compiled with --with-zlib.' );
        }
        
        $testMemcache = new Memcache();
        if ( @$testMemcache->connect( 'localhost', 11211 ) === false )
        {
            $this->markTestSkipped( 'No Memcache server running on port 11211 found.' );
        }

        // Class name == <inheriting class> - "Test"
        $storageClass = ( $this->storageClass = substr( get_class( $this ), 0, strlen( get_class(  $this ) ) - 4 ) );
        $this->storage = new $storageClass( $this->createTempDir( 'ezcCacheTest' ), array( 'host' => 'localhost', 'port' => 11211, 'ttl' => 10 ) );
        $this->testData = array(
                    1 => "Test 1 2 3 4 5 6 7 8\\\\",
                    2 => 'La la la 02064 lololo',
                    3 => 12345,
                    4 => 12.3746,
                );
    }

    // Override test from parent class
    public function testConstructorErrorLocationNotWriteable()
    {
        return true;
    }

    // Override test from parent class
    public function testStoreRestoreOutdatedWithoutAttributes()
    {
        $options = array( 'host' => 'localhost', 'port' => 11211, 'ttl' => 10 );
        $storage = new ezcCacheStorageMemcacheWrapper( $this->getTempDir(), $options );
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
        $options = array( 'host' => 'localhost', 'port' => 11211, 'ttl' => 10 );
        $storage = new ezcCacheStorageMemcacheWrapper( $this->getTempDir(), $options );
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

    // Override test from parent class
    public function testCountDataItemsIdNoAttributesSubdirs()
    {
        $this->storage->reset();
        $id = 'id/with/slashes/';
        $attributes = array( 'class' => 23 );
        foreach ( $this->testData as $idSuffix => $data )
        {
            $this->storage->store( $id . $idSuffix, $data, $attributes );
        }

        foreach ( $this->testData as $idSuffix => $data ) {
            $this->assertEquals(
                1,
                $this->storage->countDataItems( $id . $idSuffix ),
                "Data count for ID with slashes incorrect."
            );
        }
    }

    public function testStoreResource()
    {
        $this->storage->reset();
        $resource = fopen( dirname( __FILE__ ) . DIRECTORY_SEPARATOR . 'wrappers' . DIRECTORY_SEPARATOR . 'memcache_wrapper.php', 'r' );
        try
        {
            $this->storage->store( "key", $resource );
            fclose( $resource );
            $this->fail( "Expected exception was not thrown." );
        }
        catch ( ezcCacheInvalidDataException $e )
        {
            fclose( $resource );
            $this->assertEquals( "The given data was of type 'resource', which can not be stored. Expecting: 'simple, array, object'.", $e->getMessage() );
        }
    }

    public function testMemcacheUnknownHost()
    {
        try
        {
            $memcache = new ezcCacheStorageMemcachePlain( '.', array( 'host' => 'unknown_host', 'port' => 11211, 'ttl' => 10 ) );
            $this->fail( "Expected exception was not thrown." );
        }
        catch ( ezcCacheMemcacheException $e )
        {
            $this->assertEquals( "Could not connect to Memcache.", $e->getMessage() );
        }

    }

    public function testBackendPersistentUnknownHost()
    {
        try
        {
            $memcache = new ezcCacheMemcacheBackend( array( 'host' => 'unknown_host', 'port' => 11211, 'ttl' => 10, 'persistent' => true ) );
            $this->fail( "Expected exception was not thrown." );
        }
        catch ( ezcCacheMemcacheException $e )
        {
            $this->assertEquals( "Could not connect to Memcache using a persistent connection.", $e->getMessage() );
        }
    }

    public function testBackendPersistentConnectionThenDestruct()
    {
        $storage = new ezcCacheMemcacheBackend( array( 'host' => 'localhost', 'port' => 11211, 'ttl' => 10, 'persistent' => true ) );;
        $storage->__destruct();
    }

    public function testGetRemainingLifetimeId()
    {
        $this->storage->reset();
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
        $options = array( 'host' => 'localhost', 'port' => 11211, 'ttl' => 10 );
        ezcCacheManager::createCache( 'cache', null, 'ezcCacheStorageMemcachePlain', $options );
        $storage = ezcCacheManager::getCache( 'cache' );
        $storage->reset();
        $storage->store( 'key', 'data' );
        $this->assertEquals( 'data', $storage->restore( 'key' ) );
    }

    public function testStorageMemcacheOptions()
    {
        $options = new ezcCacheStorageMemcacheOptions();
        
        $this->assertTrue( isset( $options->host ) );
        $this->assertTrue( isset( $options->ttl ) );
        $this->assertTrue( isset( $options->port ) );
        $this->assertTrue( isset( $options->compressed ) );
        $this->assertTrue( isset( $options->persistent ) );
        $this->assertFalse( isset( $options->foo ), 'Exception not thrown on invalid property.' );

        $this->assertSetPropertyFails( $options, 'host', array( true, false, 23, 42.23, array(), new stdClass(), '' ) );
        $this->assertSetPropertyFails( $options, 'ttl', array( true, 42.23, array(), new stdClass(), '', 'foo' ) );
        $this->assertSetPropertyFails( $options, 'port', array( true, false, -23, 42.23, array(), new stdClass(), '', 'foo' ) );
        $this->assertSetPropertyFails( $options, 'compressed', array( 42, -23, 42.23, array(), new stdClass(), '', 'foo' ) );
        $this->assertSetPropertyFails( $options, 'persistent', array( 42, -23, 42.23, array(), new stdClass(), '', 'foo' ) );
        
        $this->assertSetProperty( $options, 'host', array( 'localhost', '192.168.0.14' ) );
        $this->assertSetProperty( $options, 'ttl', array( 1, 1000 ) );
        $this->assertSetProperty( $options, 'port', array( 1, 23 ) );
        $this->assertSetProperty( $options, 'compressed', array( true, false ) );
        $this->assertSetProperty( $options, 'persistent', array( true, false ) );
    }

    public function testCacheBackendSingleConnection()
    {
        $options = array( 'host' => 'localhost', 'port' => 11211, 'ttl' => 10 );

        ezcCacheManager::createCache( 'cache-a', null, 'ezcCacheStorageMemcachePlain', $options );
        ezcCacheManager::createCache( 'cache-b', null, 'ezcCacheStorageMemcachePlain', $options );

        $storageA = ezcCacheManager::getCache( 'cache-a' );
        $storageA->reset();
        $storageB = ezcCacheManager::getCache( 'cache-b' );
        $storageA->reset();

        $backendA = $this->getObjectAttribute( $storageA, 'backend' );
        $backendB = $this->getObjectAttribute( $storageB, 'backend' );

        $memcacheA = $this->getObjectAttribute( $backendA, 'memcache' );
        $memcacheB = $this->getObjectAttribute( $backendB, 'memcache' );

        $this->assertSame( $memcacheA, $memcacheB );

        unset( $storageA );
        unset( $storageA );
    }

    public function testStorageProperties()
    {
        $storage = new ezcCacheStorageMemcachePlain( '.', array( 'host' => 'localhost', 'port' => 11211, 'ttl' => 10 ) );
        $storage->reset();

        $this->assertTrue( isset( $storage->options ) );
        $this->assertType(
            'ezcCacheStorageMemcacheOptions',
            $storage->options
        );

        $this->assertSetProperty(
            $storage,
            'options',
            array( new ezcCacheStorageMemcacheOptions() )
        );
        $this->assertSetPropertyFails(
            $storage,
            'options',
            array( 'foo', 23, 42.23, true, false, new stdClass() )
        );

        $this->assertFalse( isset( $storage->foo ) );
        try
        {
            $storage->foo = 23;
            $this->fail( 'Exception not thrown on set for invalid property.' );
        }
        catch ( ezcBasePropertyNotFoundException $e ) {}
        try
        {
            echo $storage->foo;
            $this->fail( 'Exception not thrown on get for invalid property.' );
        }
        catch ( ezcBasePropertyNotFoundException $e ) {}
    }

    public function testStorageOptions()
    {
        $storageOptions = new ezcCacheStorageOptions();
        $storageMemcacheOptions = new ezcCacheStorageMemcacheOptions();
        $arrayOptions = array();

        $storage = new ezcCacheStorageMemcacheWrapper(
            '.',
            array( 'host' => 'localhost', 'port' => 11211, 'ttl' => 10 )
        );
        $storage->reset();

        $storage->setOptions( $storageMemcacheOptions );
        $this->assertEquals( $storageMemcacheOptions, $storage->getOptions() );

        $storage->options = $storageMemcacheOptions;
        $this->assertEquals( $storageMemcacheOptions, $storage->getOptions() );
        
        $storage->setOptions( $storageOptions );
        $this->assertEquals( $storageMemcacheOptions, $storage->getOptions() );

        $storage->options = $storageOptions;
        $this->assertEquals( $storageMemcacheOptions, $storage->getOptions() );
        
        $storage->setOptions( $arrayOptions );
        $this->assertEquals( $storageMemcacheOptions, $storage->getOptions() );

        $storage->options = $arrayOptions;
        $this->assertEquals( $storageMemcacheOptions, $storage->getOptions() );

        $options = new stdClass();
        try
        {
            $storage->setOptions( $options );
            $this->fail( "Expected exception was not thrown." );
        }
        catch ( ezcBaseValueException $e )
        {
            $this->assertEquals( "The value 'O:8:\"stdClass\":0:{}' that you were trying to assign to setting 'options' is invalid. Allowed values are: instance of ezcCacheStorageMemcacheOptions.", $e->getMessage() );
        }
    }
    
    public function testResetSuccess()
    {
        $storage = new ezcCacheStorageMemcacheWrapper(
            '.',
            array( 'host' => 'localhost', 'port' => 11211, 'ttl' => 10 )
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
        $storage = new ezcCacheStorageMemcacheWrapper(
            '.',
            array( 'host' => 'localhost', 'port' => 11211, 'ttl' => 100 )
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

        // @TODO: Should be deleted by ID only, too.
        $deleted = $storage->delete( 'Some/other/Dir/ID/3', $attributes );
        
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
        $storage = new ezcCacheStorageMemcacheWrapper(
            '.',
            array( 'host' => 'localhost', 'port' => 11211, 'ttl' => 1 )
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
        $storage = new ezcCacheStorageMemcacheWrapper(
            '.',
            array( 'host' => 'localhost', 'port' => 11211, 'ttl' => 1 )
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

    public static function suite()
	{
        return new PHPUnit_Framework_TestSuite( __CLASS__ );
	}
}
?>
