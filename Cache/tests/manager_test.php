<?php
/**
 * ezcCacheManagerTest 
 * 
 * @package Cache
 * @subpackage Tests
 * @version //autogen//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Test suite for ezcCacheManager class. 
 * 
 * @package Cache
 * @subpackage Tests
 */
class ezcCacheManagerTest extends ezcTestCase
{
    /**
     * data 
     * 
     * @var array
     * @access protected
     */
    protected $data = array(
        'ezcCacheStorageFilePlain',
        'ezcCacheStorageFileArray',
        'ezcCacheStorageFileEvalArray',
    );
    
    /**
     * Temp location for caches.
     * 
     * @var mixed
     */
    private $location;

    /**
     * suite 
     * 
     * @static
     * @access public
     */
    public static function suite()
    {
        return new PHPUnit_Framework_TestSuite( "ezcCacheManagerTest" );
    }

    public function testManagerCreateCache_Success()
    {
        foreach ( $this->data as $id => $class ) 
        {
            $location = $this->createTempDir($class);
            ezcCacheManager::createCache( $id, $location, $class );
            $realCache = ezcCacheManager::getCache( $id );
            $fakeCache = new $class( realpath( $location ) );
            $this->assertEquals( 
                $realCache,
                $fakeCache, 
                'Invalid object created from ezcCacheManager. Expected "' . get_class( $realCache )  . '", found "'. get_class( $fakeCache ) .'".'  
            );
            unset( $realCache ); unset( $fakeCache );
            $this->removeTempDir($location);
        }
        $this->assertTrue( true );
    }

    public function testManagerCreateCache_Failure()
    {
        $id = 0;
        // First try to create cache in invalid location.
        $caughtException = false;
        try 
        {
            $cache = ezcCacheManager::createCache( $id, '/fckgw', $this->data[$id] );
        }
        catch ( ezcBaseFileNotFoundException $e )
        {
            $caughtException = true;
        }
        if ( $caughtException === false )
        {
            $this->fail('Exception not thrown on invalid location <'.$location.'>.');
        }
        
        // Second try, allocate a cache succesfully
        $location = $this->createTempDir($this->data[$id]);
        $cache = ezcCacheManager::createCache( $id, $location, $this->data[$id] );
        
        // Use next cache class/location.
        $id++;
        $caughtException = false;
        try
        {
            // Use current ID with last IDs location
            ezcCacheManager::createCache( $id, $location, $this->data[$id]  );
        }
        catch ( ezcCacheUsedLocationException $e )
        {
            $caughtException = true;
        }
        if ( $caughtException === false )
        {
            $this->fail('Exception not thrown on used location <'.$location.'>.');
        }
        $this->removeTempDir($location);
        
        // Use next cache class/location.
        $id++;
        $caughtException = false;
        $location = $this->createTempDir($this->data[$id]);
        try
        {
            // Use current ID with non-existant cache class
            ezcCacheManager::createCache( $id, $location, 'Test' );
        }
        catch ( ezcCacheInvalidStorageClassException $e )
        {
            $caughtException = true;
        }
        if ( $caughtException === false )
        {
            $this->fail('Wrong exception thrown on invalid storage class <Test>.');
        }
        $this->removeTempDir($location);
    }

    /**
     * Success tests already included in testCreateCache_Success()
     */
    public function testGetCache_Failure()
    {
        try
        {
            $cache = ezcCacheManager::getCache( 'unknnown' );
        }
        catch ( ezcCacheInvalidIdException $e )
        {
            return;
        }
        $this->fail( 'ezcCacheInvalidIdException not thrown on invalid ID.' );
    }
}
?>
