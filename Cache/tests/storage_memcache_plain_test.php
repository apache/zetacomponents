<?php
/**
 * ezcCacheStorageMemcachePlainTest 
 * 
 * @package Cache
 * @subpackage Tests
 * @version //autogen//
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
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
    protected $data = array(
        1 => "Test 1 2 3 4 5 6 7 8\\\\",
        2 => 'La la la 02064 lololo',
        3 => 12345,
        4 => 12.3746,
    );

    protected function setUp()
    {
        if ( !ezcBaseFeatures::hasExtensionSupport( 'memcache' ) )
        {
            $this->markTestSkipped( "PHP must have Memcache support." );
        }

        if ( !ezcBaseFeatures::hasExtensionSupport( 'zlib' ) )
        {
            $this->markTestSkipped( "PHP must be compiled with --with-zlib." );
        }

        // Class name == <inheriting class> - "Test"
        $storageClass = ( $this->storageClass = substr( get_class( $this ), 0, strlen( get_class(  $this ) ) - 4 ) );
        $this->storage = new $storageClass( $this->createTempDir( 'ezcCacheTest' ), array( 'host' => 'localhost', 'port' => 11211, 'ttl' => 10 ) );
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

        foreach ( $this->data as $id => $dataArr ) 
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

        foreach ( $this->data as $id => $dataArr ) 
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
        $id = 'id/with/slashes/';
        $attributes = array( 'class' => 23 );
        foreach ( $this->data as $idSuffix => $data )
        {
            $this->storage->store( $id . $idSuffix, $data, $attributes );
        }

        foreach ( $this->data as $idSuffix => $data ) {
            $this->assertEquals(
                1,
                $this->storage->countDataItems( $id . $idSuffix ),
                "Data count for ID with slashes incorrect."
            );
        }
    }

    public function testStoreResource()
    {
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
        $this->storage->setOptions( array( 'ttl' => 10 ) );

        $this->storage->store( '1', 'data1' );

        // "8 <= " - for those cases where the current second changes after the storage
        $this->assertEquals( true, 8 <= $this->storage->getRemainingLifetime( '1' ) );

    }

    public function testGetRemainingLifetimeAttributes()
    {
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
        $storage->store( 'key', 'data' );
        $this->assertEquals( 'data', $storage->restore( 'key' ) );
    }

    public function testStorageMemcacheOptions()
    {
        $options = new ezcCacheStorageMemcacheOptions();

        $this->invalidPropertyTest( $options, 'ttl', 'wrong value', 'int > 0 or false' );
        $this->invalidPropertyTest( $options, 'port', 'wrong value', 'int' );
        $this->invalidPropertyTest( $options, 'compressed', 'wrong value', 'bool' );
        $this->invalidPropertyTest( $options, 'persistent', 'wrong value', 'bool' );
        $this->missingPropertyTest( $options, 'no_such_option' );

        $this->issetPropertyTest( $options, 'host', true );
        $this->issetPropertyTest( $options, 'ttl', true );
        $this->issetPropertyTest( $options, 'port', true );
        $this->issetPropertyTest( $options, 'compressed', true );
        $this->issetPropertyTest( $options, 'persistent', true );
        $this->issetPropertyTest( $options, 'no_such_option', false );
    }

    public static function suite()
	{
        return new PHPUnit_Framework_TestSuite( __CLASS__ );
	}
}
?>
