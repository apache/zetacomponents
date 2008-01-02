<?php
/**
 * ezcCacheManagerTest 
 * 
 * @package Cache
 * @subpackage Tests
 * @version //autogen//
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

require_once 'test_classes.php';

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
    protected $data = array();
    
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

    public function __construct()
    {
        $this->data = array(
                        'ezcCacheStorageFilePlain',
                        'ezcCacheStorageFileArray',
                        'ezcCacheStorageFileEvalArray',
                        'ezcCacheStorageApcPlain',
                        'ezcCacheStorageFileApcArray'
                        );
    }

    public function testManagerCreateCache_Success()
    {
        foreach ( $this->data as $id => $class ) 
        {
            $location = $this->createTempDir($class);
            ezcCacheManager::createCache( $id, $location, $class );

            try
            {
                $realCache = ezcCacheManager::getCache( $id );
                $fakeCache = new $class( realpath( $location ) );
                $this->assertEquals( 
                    $realCache,
                    $fakeCache, 
                    'Invalid object created from ezcCacheManager. Expected "' . get_class( $realCache )  . '", found "'. get_class( $fakeCache ) .'".'  
                );
                unset( $realCache ); unset( $fakeCache );
            }
            catch ( ezcBaseExtensionNotFoundException $e )
            {
            }

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

    public function testCreateCacheFailUnreadable()
    {
        $temp = $this->createTempDir( __CLASS__ );
        $location = $temp . DIRECTORY_SEPARATOR . 'subpath';
        mkdir( $location );
        chmod( $location, 0 );
        try
        {
            ezcCacheManager::createCache( 'unreadable', $location, 'ezcCacheStorageFilePlain' );
            $this->fail( "Expected exception was not thrown." );
        }
        catch ( ezcBaseFilePermissionException $e )
        {
            $this->assertEquals( true, strpos( $e->getMessage(), "Cache location is not readable" ) !== false );
        }

        chmod( $location, 0777 );
        $this->removeTempDir( $temp );
    }

    public function testCreateCacheFailUnwritable()
    {
        $temp = $this->createTempDir( __CLASS__ );
        $location = $temp . DIRECTORY_SEPARATOR . 'subpath';
        mkdir( $location );
        chmod( $location, 0444 );
        try
        {
            ezcCacheManager::createCache( 'unwritable', $location, 'ezcCacheStorageFilePlain' );
            $this->fail( "Expected exception was not thrown." );
        }
        catch ( ezcBaseFilePermissionException $e )
        {
            $this->assertEquals( true, strpos( $e->getMessage(), "Cache location is not writeable" ) !== false );
        }

        chmod( $location, 0777 );
        $this->removeTempDir( $temp );
    }

    public function testGetCacheDelayedInit1()
    {
        try
        {
            $cache = ezcCacheManager::getCache( 'simple' );
            self::fail( 'Expected exception not thrown.' );
        }
        catch ( ezcCacheInvalidIdException $e )
        {
            self::assertSame( "No cache or cache configuration known with ID 'simple'.", $e->getMessage() );
        }
    }

    public function testGetCacheDelayedInit2()
    {
        ezcBaseInit::setCallback( 'ezcInitCacheManager', 'testDelayedInitCacheManager' );
        $cache = ezcCacheManager::getCache( 'simple' );
        self::assertSame( '.cache', $cache->options->extension );
    }
}
?>
