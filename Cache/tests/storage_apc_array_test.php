<?php
/**
 * ezcCacheStorageFileApcArrayTest 
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
require_once 'wrappers/apc_array_wrapper.php';

/**
 * Test suite for ezcCacheStorageFileApcArray class. 
 * 
 * @package Cache
 * @subpackage Tests
 */
class ezcCacheStorageFileApcArrayTest extends ezcCacheStorageTest
{
    /**
     * Test data.
     *
     * @var array(string=>mixed)
     */
    protected $data = array(
        0 => array( 'a' ),
        1 => array( 1, 2, 3 ),
        2 => array( 'a', 1, 'b', 2, 'c', 3 ),
        3 => array(
            1, 2, 3, 
            array( 'a', 'b', 'c' ), 
            4, 5
        ),
        4 => array(
            array(
                array( 1 ), array( 2, 3 )
            ),
            1, 2, 3,
            array( 'a', 'b', 'c' ),
        ),
        5 => "Test 1 2 3 4 5 6 7 8\\\\",
        6 => 'La la la 02064 lololo',
        7 => true,
        // 8 => false, // 6 tests fail with this
        9 => 12345,
       10 => 12.3746,
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
        $storage = new ezcCacheStorageFileApcArrayWrapper( $this->getTempDir(), $options );

        foreach ( $this->data as $id => $dataArr ) 
        {
            $storage->store( $id, $dataArr );

            // Hack the cache to be outdated by 100 seconds
            $data = $storage->restore( $id );
            $registry = $storage->getRegistry();
            foreach ( $registry as $location => $dataObj )
            {
                if ( isset( $dataObj->data )
                     && $dataArr === $dataObj->data
                     && strpos( $location, $this->getTempDir() ) !== false )
                {
                    break;
                }
            }

            $registry[$location]->mtime = time() - 100;
            $storage->setRegistry( $registry );

            $data = $storage->restore( $id );
            $this->assertTrue( $data === false, "Restore data broken for ID <{$id}>." );
        }
    }

    // Override test from parent class
    public function testStoreRestoreOutdatedWithAttributes()
    {
        $options = array( 'ttl' => 10 );
        $storage = new ezcCacheStorageFileApcArrayWrapper( $this->getTempDir(), $options );

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
            foreach ( $registry as $location => $dataObj )
            {
                if ( isset( $dataObj->data )
                     && $dataArr === $dataObj->data
                     && strpos( $location, $this->getTempDir() ) !== false )
                {
                    break;
                }
            }

            $registry[$location]->mtime = time() - 100;
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
        $storage = new ezcCacheStorageFileApcArrayWrapper( $this->getTempDir(), $options );
        $storage->setBackend( $apcBackend );

        $id = 'id';
        try
        {
            $storage->store( $id, 'data' );
            $this->fail( "Expected exception was not thrown." );
        }
        catch ( ezcCacheApcException $e )
        {
            $this->assertEquals( "APC store failed.", $e->getMessage() );
        }
    }

    public function testStoreResource()
    {
        $resource = fopen( dirname( __FILE__ ) . DIRECTORY_SEPARATOR . 'wrappers' . DIRECTORY_SEPARATOR . 'apc_wrapper.php', 'r' );
        try
        {
            $this->storage->store( "key", $resource );
            fclose( $resource );
            $this->fail( "Expected exception was not thrown." );
        }
        catch ( ezcCacheInvalidDataException $e )
        {
            fclose( $resource );
            $this->assertEquals( "The given data was of type 'resource', which can not be stored. Expecting: 'simple, array'.", $e->getMessage() );
        }
    }

    public function testWrapperFetchDataUseApc()
    {
        $options = array( 'ttl' => 10 );
        $storage = new ezcCacheStorageFileApcArrayWrapper( $this->getTempDir(), $options );

        $data = 'data';
        $key = 'key';

        $storage->store( $key, $data );
        $storage->restore( $key );
        $registry = $storage->getRegistry();

        list( $identifier, $dataArr ) = each( $registry );

        $dataFetched = $storage->fetchData( $identifier, true );
        $this->assertEquals( $data, $dataFetched );
    }

    public function testWrapperPrepareDataUseApcResourceFail()
    {
        $resource = fopen( dirname( __FILE__ ) . DIRECTORY_SEPARATOR . 'wrappers' . DIRECTORY_SEPARATOR . 'apc_wrapper.php', 'r' );

        $options = array( 'ttl' => 10 );
        $storage = new ezcCacheStorageFileApcArrayWrapper( $this->getTempDir(), $options );

        try
        {
            $storage->prepareData( $resource, true );
            fclose( $resource );
            $this->fail( "Expected exception was not thrown." );
        }
        catch ( ezcCacheInvalidDataException $e )
        {
            fclose( $resource );
            $this->assertEquals( "The given data was of type 'resource', which can not be stored. Expecting: 'simple, array, object'.", $e->getMessage() );
        }
    }

    public function testWrapperCalcLifetimeNoApc()
    {
        $options = array( 'ttl' => 10 );
        $storage = new ezcCacheStorageFileApcArrayWrapper( $this->getTempDir(), $options );

        $data = 'data';
        $key = 'key';

        $filename = $this->getTempDir() . DIRECTORY_SEPARATOR . $storage->generateIdentifier( $key, array() );

        file_put_contents( $filename, $data );
        touch( $filename, time() - 10 );

        $lifetime = $storage->calcLifetime( $filename, false );

        // "8 <= " - for those cases where the current second changes during requests
        $this->assertEquals( true, 8 <= $lifetime );
    }

    public function testCacheManagerLocationEmpty()
    {
        $options = array( 'ttl' => 10 );
        ezcCacheManager::createCache( 'memory', null, 'ezcCacheStorageFileApcArray', $options );
        try
        {
            $storage = ezcCacheManager::getCache( 'memory' );
            $this->fail( "Expected exception was not thrown" );
        }
        catch ( ezcBaseFilePermissionException $e )
        {
            $this->assertEquals( "The file '/' can not be opened for writing. (Cache location is not a directory.)", $e->getMessage() );
        }
    }

    public function testStorageFileApcArrayOptions()
    {
        $options = new ezcCacheStorageFileApcArrayOptions();

        $this->invalidPropertyTest( $options, 'ttl', 'wrong value', 'int > 0 or false' );
        $this->invalidPropertyTest( $options, 'permissions', 'wrong value', 'int > 0 and <= 0777' );
        $this->invalidPropertyTest( $options, 'permissions', -1, 'int > 0 and <= 0777' );
        $this->invalidPropertyTest( $options, 'permissions', 07777, 'int > 0 and <= 0777' );
        $this->missingPropertyTest( $options, 'no_such_option' );

        // valid set
        $options->permissions = 0777;
    }

    public static function suite()
	{
		return new PHPUnit_Framework_TestSuite( __CLASS__ );
	}
}
?>
