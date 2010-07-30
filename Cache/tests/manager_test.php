<?php
/**
 * ezcCacheManagerTest 
 * 
 * Licensed to the Apache Software Foundation (ASF) under one
 * or more contributor license agreements.  See the NOTICE file
 * distributed with this work for additional information
 * regarding copyright ownership.  The ASF licenses this file
 * to you under the Apache License, Version 2.0 (the
 * "License"); you may not use this file except in compliance
 * with the License.  You may obtain a copy of the License at
 * 
 *   http://www.apache.org/licenses/LICENSE-2.0
 * 
 * Unless required by applicable law or agreed to in writing,
 * software distributed under the License is distributed on an
 * "AS IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS OF ANY
 * KIND, either express or implied.  See the License for the
 * specific language governing permissions and limitations
 * under the License.
 *
 * @package Cache
 * @subpackage Tests
 * @version //autogen//
 * @copyright Copyright (C) 2005-2010 eZ Systems AS. All rights reserved.
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
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
            $this->fail('Exception not thrown on invalid location </fckgw>.');
        }
        catch ( ezcBaseFileNotFoundException $e )
        {
            $this->assertEquals(
               "The cache location file '/fckgw' could not be found. (Does not exist or is no directory.)",
               $e->getMessage()
            );
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
        testDelayedInitCacheManager::$tmpDir = $this->createTempDir( __CLASS__ );
        ezcBaseInit::setCallback( 'ezcInitCacheManager', 'testDelayedInitCacheManager' );
        $cache = ezcCacheManager::getCache( 'simple' );
        self::assertSame( '.cache', $cache->options->extension );
    }
}
?>
