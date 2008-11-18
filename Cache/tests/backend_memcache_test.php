<?php
/**
 * ezcCacheMemcacheBackendTest 
 * 
 * @package Cache
 * @subpackage Tests
 * @version //autogen//
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Test suite for ezcCacheStorageMemcachePlain class. 
 * 
 * @package Cache
 * @subpackage Tests
 */
class ezcCacheMemcacheBackendTest extends ezcTestCase
{
    protected $memcacheBackend;

    public static function suite()
	{
        return new PHPUnit_Framework_TestSuite( __CLASS__ );
	}

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
        $testMemcache->close();

        $this->memcacheBackend = new ezcCacheMemcacheBackend();
    }

    protected function tearDown()
    {
        $this->memcacheBackend->reset();
        unset( $this->memcacheBackend );
    }

    protected function getInvalidKey()
    {
        return str_pad( '', ( ezcCacheMemcacheBackend::MAX_KEY_LENGTH + 1 ), 'a' );
    }
    
    protected function getValidKey()
    {
        return str_pad( '', ezcCacheMemcacheBackend::MAX_KEY_LENGTH, 'a' );
    }

    public function testStoreValidKey()
    {
        $key = $this->getValidKey();

        $this->memcacheBackend->store(
            $key,
            'some data'
        );

        $this->assertEquals(
            'some data',
            $this->memcacheBackend->fetch( $key )
        );
    }

    public function testStoreFailInvalidKey()
    {
        try
        {
            $this->memcacheBackend->store(
                $this->getInvalidKey(),
                'some data'
            );
        }
        catch ( ezcCacheInvalidKeyException $e )
        {
            return;
        }
        $this->fail( 'Exception not thrown on invalid cache key.' );
    }

    public function testFetchFailInvalidKey()
    {
        try
        {
            $this->memcacheBackend->fetch(
                $this->getInvalidKey()
            );
        }
        catch ( ezcCacheInvalidKeyException $e )
        {
            return;
        }
        $this->fail( 'Exception not thrown on invalid cache key.' );
    }

    public function testFetchValidKey()
    {
        $res = $this->memcacheBackend->fetch(
            $this->getValidKey()
        );

        $this->assertFalse( $res );
    }

    public function testDeleteFailInvalidKey()
    {
        try
        {
            $this->memcacheBackend->delete(
                $this->getInvalidKey()
            );
        }
        catch ( ezcCacheInvalidKeyException $e )
        {
            return;
        }
        $this->fail( 'Exception not thrown on invalid cache key.' );
    }

    public function testDeleteValidKey()
    {
        $this->memcacheBackend->delete(
            $this->getValidKey()
        );
    }

    public function testAcquireLockValidKey()
    {
        $key = $this->getValidKey();
        
        $this->memcacheBackend->acquireLock( $key, 1000, 10000 );
    }

    public function testReleaseLockFailInvalidKey()
    {
        try
        {
            $this->memcacheBackend->releaseLock(
                $this->getInvalidKey()
            );
        }
        catch ( ezcCacheInvalidKeyException $e )
        {
            return;
        }
        $this->fail( 'Exception not thrown on invalid cache key.' );
    }

    public function testReleaseLockValidKey()
    {
        $this->memcacheBackend->releaseLock(
            $this->getValidKey()
        );
    }
}
?>
