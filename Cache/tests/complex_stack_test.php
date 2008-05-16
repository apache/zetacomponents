<?php
/**
 * ezcCacheComplexStackTest 
 * 
 * @package Cache
 * @subpackage Tests
 * @version //autogen//
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

class ezcCacheComplexStackTestConfigurator implements ezcCacheStackConfigurator
{
    public static $storages  = array();

    public static $metaStorage;

    public static function configure( ezcCacheStack $stack )
    {
        foreach ( self::$storages as $storageConf )
        {
            $stack->pushStorage( $storageConf );
        }
        $stack->options->metaStorage = self::$metaStorage;
    }
}

/**
 * Complex "real live" tests for ezcCacheStack.
 *
 * Attention, this test runs continuous and does not reset its environment
 * after each test case.
 * 
 * @package Cache
 * @subpackage Tests
 */
class ezcCacheComplexCacheTest extends ezcTestCase
{
    protected static $stackInitialized = false;

    protected $testDataArray;

    protected function setup()
    {
        if ( !self::$stackInitialized )
        {
            if ( ezcBaseFeatures::hasExtensionSupport( 'apc' ) )
            {
                $memoryStorage = new ezcCacheStorageApcPlain();
            }
            else if ( ezcBaseFeatures::hasExtensionSupport( 'memcache' ) )
            {
                $memoryStorage = new ezcCacheStorageMemcachePlain( 'foo' );
            }
            else
            {
                $this->markTestSkipped( 'APC or Memcached needed to run this test.' );
            }
            // Start cleanly
            $memoryStorage->reset();

            $tmpDir = $this->createTempDir( __CLASS__ );
            $tmpDirEvalArray = "$tmpDir/plain";
            $tmpDirArray = "$tmpDir/array";

            mkdir( $tmpDirEvalArray );
            mkdir( $tmpDirArray );
            
            $fileStorageEvalArray = new ezcCacheStorageFileEvalArray( $tmpDirEvalArray );
            $fileStorageArray = new ezcCacheStorageFileArray( $tmpDirArray );

            ezcCacheComplexStackTestConfigurator::$storages = array(
                new ezcCacheStackStorageConfiguration(
                    'eval_array_storage',
                    $fileStorageEvalArray,
                    10,
                    .8
                ),
                new ezcCacheStackStorageConfiguration(
                    'array_storage',
                    $fileStorageArray,
                    8,
                    .5
                ),
                new ezcCacheStackStorageConfiguration(
                    'memory_storage',
                    $memoryStorage,
                    5,
                    .5
                ),
            );

            ezcCacheComplexStackTestConfigurator::$metaStorage = $fileStorageArray;
            
            ezcCacheManager::createCache(
                __CLASS__,
                null,
                'ezcCacheStack',
                new ezcCacheStackOptions(
                    array(
                        'configurator' => 'ezcCacheComplexStackTestConfigurator',
                        'replacementStrategy' => 'ezcCacheStackLfuReplacementStrategy',
                    )
                )
            );

            self::$stackInitialized = true;
        }

        $this->testDataArray = array(
             array( 'id_1', 'id_1_content', array( 'lang' => 'en', 'area' => 'news' ) ),
             array( 'id_2', 'id_2_content', array( 'lang' => 'en', 'area' => 'news' ) ),
             array( 'id_3', 'id_3_content', array( 'lang' => 'de', 'area' => 'news' ) ),
             array( 'id_4', 'id_4_content', array( 'lang' => 'no', 'area' => 'news' ) ),
             array( 'id_5', 'id_5_content', array( 'lang' => 'de', 'area' => 'news' ) ),
        );
    }

    public static function suite()
    {
        return new PHPUnit_Framework_TestSuite( __CLASS__ );
    }

    public function testEnvSetup()
    {
        $stack = ezcCacheManager::getCache( __CLASS__ );
        $data  = $this->testDataArray;

        // Assert basic config
        $this->assertEquals(
            $stack->getStorages(),
            array_reverse( ezcCacheComplexStackTestConfigurator::$storages )
        );
        $this->assertEquals(
            $stack->options,
            new ezcCacheStackOptions(
                array(
                    'configurator'        => 'ezcCacheComplexStackTestConfigurator',
                    'replacementStrategy' => 'ezcCacheStackLfuReplacementStrategy',
                    'metaStorage'         => ezcCacheComplexStackTestConfigurator::$metaStorage,
                    'bubbleUpOnRestore'   => false,
                )
            )
        );
    }

    public function testBasicStore()
    {
        $stack = ezcCacheManager::getCache( __CLASS__ );
        $data  = $this->testDataArray;

        // Basic store
        foreach ( $this->testDataArray as $dataRow )
        {
            $stack->store( $dataRow[0], $dataRow[1], $dataRow[2] );
        }

        // Assert basic store
        foreach ( $stack->getStorages() as $storageConf )
        {
            foreach ( $this->testDataArray as $dataRow )
            {
                $this->assertEquals(
                    $dataRow[1],
                    $storageConf->storage->restore( $dataRow[0], $dataRow[2] ),
                    "ID '{$dataRow[0]}' missing in storoage '{$storageConf->id}'."
                );
            }
        }
    }

    public function testBasicDelete()
    {
        $stack = ezcCacheManager::getCache( __CLASS__ );
        $data  = $this->testDataArray;

        // Basic delete
        $stack->delete( $data[2][0], $data[2][2] );

        // Assert basic delete
        foreach ( $stack->getStorages() as $storageConf )
        {
            $this->assertFalse(
                $storageConf->storage->restore( $data[2][0], $data[2][2] )
            );
        }
    }

    public function testAdvancedDelete()
    {
        $stack = ezcCacheManager::getCache( __CLASS__ );
        $data  = $this->testDataArray;

        // Advanced delete
        $stack->delete( null, array( 'lang' => 'en' ), true );

        // Assert advanced delete
        foreach ( $stack->getStorages() as $storageConf )
        {
            foreach ( $data as $rowId => $dataRow )
            {
                if ( $dataRow[2]['lang'] === 'en' || $rowId == 2 )
                {
                    $this->assertFalse(
                        $storageConf->storage->restore( $dataRow[0], $dataRow[2] ),
                        "Item with ID '{$dataRow[0]}' still available in storage {$storageConf->id}"
                    );
                }
                else
                {
                    $this->assertEquals(
                        $dataRow[1],
                        $storageConf->storage->restore( $dataRow[0], $dataRow[2] )
                    );
                }

            }
        }
    }

    public function testStoreSecondTime()
    {
        $stack = ezcCacheManager::getCache( __CLASS__ );
        $data  = $this->testDataArray;

        // Store all data again
        foreach ( $data as $dataRow )
        {
            $stack->store( $dataRow[0], $dataRow[1], $dataRow[2] );
        }
        
        $this->assertEquals(
            array(
                'replacementData' => 
                array (
                    'id_4' => 6,
                    'id_5' => 6,
                    'id_1' => 3,
                    'id_2' => 3,
                    'id_3' => 3,
                ),
                'storageData' => 
                array (
                    'memory_storage' => 
                    array (
                        'id_4' => true,
                        'id_5' => true,
                        'id_1' => true,
                        'id_2' => true,
                        'id_3' => true,
                    ),
                    'array_storage' => 
                    array (
                        'id_4' => true,
                        'id_5' => true,
                        'id_1' => true,
                        'id_2' => true,
                        'id_3' => true,
                    ),
                    'eval_array_storage' => 
                    array (
                        'id_4' => true,
                        'id_5' => true,
                        'id_1' => true,
                        'id_2' => true,
                        'id_3' => true,
                    ),
                )
            ),
            ezcCacheComplexStackTestConfigurator::$metaStorage->restoreMetaData()->getData(),
            'Assertion of current meta data failed'
        );
    }

    public function testRestores()
    {
        $stack = ezcCacheManager::getCache( __CLASS__ );
        $data  = $this->testDataArray;

        // Change some accesses
        $stack->restore( $data[0][0], $data[0][2] );
        $stack->restore( $data[0][0], $data[0][2] );
        $stack->restore( $data[0][0], $data[0][2] );
        $stack->restore( $data[0][0], $data[0][2] );
        $stack->restore( $data[2][0], $data[2][2] );

        $metaData = ezcCacheComplexStackTestConfigurator::$metaStorage->restoreMetaData()->getData();

        $this->assertEquals(
            array (
                'id_4' => 6,
                'id_5' => 6,
                'id_1' => 7,
                'id_2' => 3,
                'id_3' => 4,
            ),
            $metaData['replacementData']
        );
    }

    public function testFreeInMemoryStorage()
    {
        $stack = ezcCacheManager::getCache( __CLASS__ );
        $data  = $this->testDataArray;

        // Free in 'memory_storage'
        xdebug_start_trace( 'trace' );
        $stack->store( 'id_6', 'id_6_contente' );
        xdebug_stop_trace();

        $metaData = ezcCacheComplexStackTestConfigurator::$metaStorage->restoreMetaData()->getData();
        $this->assertEquals(
            array (
                'replacementData' => 
                array (
                    'id_2' => 3,
                    'id_3' => 4,
                    'id_5' => 6,
                    'id_4' => 6,
                    'id_1' => 7,
                    'id_6' => 3,
                ),
                'storageData' => 
                array (
                    'memory_storage' => 
                    array (
                        'id_4' => true,
                        'id_1' => true,
                        'id_6' => true,
                    ),
                    'array_storage' => 
                    array (
                        'id_4' => true,
                        'id_5' => true,
                        'id_1' => true,
                        'id_2' => true,
                        'id_3' => true,
                        'id_6' => true,
                    ),
                    'eval_array_storage' => 
                    array (
                        'id_4' => true,
                        'id_5' => true,
                        'id_1' => true,
                        'id_2' => true,
                        'id_3' => true,
                        'id_6' => true,
                    ),
                ),
            ),
            $metaData
        );
    }

    public function testRestores2()
    {
        $stack = ezcCacheManager::getCache( __CLASS__ );
        $data  = $this->testDataArray;
        
        // Change some usage stats
        $stack->restore( $data[1][0], $data[1][2] );
        $stack->restore( $data[1][0], $data[1][2] );
        $stack->restore( $data[1][0], $data[1][2] );
        $stack->restore( 'id_6' );
        $stack->restore( 'id_6' );
        $stack->restore( 'id_6' );
        $stack->restore( 'id_6' );
        $stack->restore( 'id_6' );
        $stack->restore( 'id_6' );
                    
        $metaData = ezcCacheComplexStackTestConfigurator::$metaStorage->restoreMetaData()->getData();
        $this->assertEquals(
            array (
                'replacementData' => 
                array (
                    'id_2' => 6,
                    'id_3' => 4,
                    'id_5' => 6,
                    'id_4' => 6,
                    'id_1' => 7,
                    'id_6' => 9,
                ),
                'storageData' => 
                array (
                    'memory_storage' => 
                    array (
                        'id_4' => true,
                        'id_1' => true,
                        'id_6' => true,
                        // 'id_2' => true,
                    ),
                    'array_storage' => 
                    array (
                        'id_4' => true,
                        'id_5' => true,
                        'id_1' => true,
                        'id_2' => true,
                        'id_3' => true,
                        'id_6' => true,
                    ),
                    'eval_array_storage' => 
                    array (
                        'id_4' => true,
                        'id_5' => true,
                        'id_1' => true,
                        'id_2' => true,
                        'id_3' => true,
                        'id_6' => true,
                    ),
                ),
            ),
            $metaData
        );
    }

    public function testFreeInArrayStorage()
    {
        $stack = ezcCacheManager::getCache( __CLASS__ );
        $data  = $this->testDataArray;

        // Free 'array_storage'

        $stack->store( 'id_7', 'id_7_content' );
        // Should net get purged directly again
        $stack->restore( 'id_7' );
        $stack->restore( 'id_7' );
        $stack->restore( 'id_7' );
        $stack->restore( 'id_7' );
        $stack->restore( 'id_7' );

        $stack->store( 'id_8', 'id_8_content' );
        // Should net get purged directly again
        $stack->restore( 'id_8' );
        $stack->restore( 'id_8' );
        $stack->restore( 'id_8' );
        $stack->restore( 'id_8' );
        $stack->restore( 'id_8' );

        $stack->store( 'id_9', 'id_9_content', array( 'lang' => 'no', 'section' => 'articles' ) );
        // Should net get purged directly again
        $stack->restore( 'id_9', null, true );
        $stack->restore( 'id_9', null, true );
        $stack->restore( 'id_9', null, true );
        $stack->restore( 'id_9', null, true );

        $metaData = ezcCacheComplexStackTestConfigurator::$metaStorage->restoreMetaData()->getData();
        $this->assertEquals(
            array (
                'replacementData' => 
                array (
                    'id_9' => 7, // Was 3 before got restored
                    'id_3' => 4,
                    'id_5' => 6,
                    'id_4' => 6,
                    'id_2' => 6,
                    'id_1' => 7,
                    'id_8' => 8,
                    'id_7' => 8,
                    'id_6' => 9,
                ),
                'storageData' => 
                array (
                    'memory_storage' => 
                    array (
                        'id_6' => true,
                        'id_8' => true,
                        'id_9' => true,
                    ),
                    'array_storage' => 
                    array (
                        'id_1' => true,
                        'id_6' => true,
                        'id_7' => true,
                        'id_8' => true,
                        'id_9' => true,
                    ),
                    'eval_array_storage' => 
                    array (
                        'id_4' => true,
                        'id_5' => true,
                        'id_1' => true,
                        'id_2' => true,
                        'id_3' => true,
                        'id_6' => true,
                        'id_7' => true,
                        'id_8' => true,
                        'id_9' => true,
                    ),
                ),
            ),
            $metaData
        );
    }

    public function testBubbleUp()
    {
        $stack = ezcCacheManager::getCache( __CLASS__ );
        $data  = $this->testDataArray;
        
        // Bubble up now
        $stack->options->bubbleUpOnRestore = true;

        // Bubble up item id_1 from 2nd level to 1st level
        $this->assertEquals(
            $data[0][1],
            $stack->restore( $data[0][0], $data[0][2] )
        );

        $metaData = ezcCacheComplexStackTestConfigurator::$metaStorage->restoreMetaData()->getData();
        $this->assertTrue(
            $metaData['storageData']['memory_storage']['id_1']
        );
        $this->assertEquals(
            $data[0][1],
            ezcCacheComplexStackTestConfigurator::$storages[2]->storage->restore(
                $data[0][0], $data[0][2]
            )
        );
        $this->assertTrue(
            $metaData['storageData']['array_storage']['id_1']
        );
       
        // Bubble up from 3rd level to 1st and 2nd level
        $this->assertEquals(
            $data[2][1],
            $stack->restore( $data[2][0], $data[2][2] )
        );

        $metaData = ezcCacheComplexStackTestConfigurator::$metaStorage->restoreMetaData()->getData();
        $this->assertTrue(
            $metaData['storageData']['memory_storage']['id_3']
        );
        $this->assertTrue(
            $metaData['storageData']['array_storage']['id_3']
        );

        $metaData = ezcCacheComplexStackTestConfigurator::$metaStorage->restoreMetaData()->getData();
        $this->assertEquals(
            array (
                'replacementData' => 
                array (
                    'id_9' => 7,
                    'id_3' => 7,
                    'id_5' => 6,
                    'id_4' => 6,
                    'id_2' => 6,
                    'id_1' => 9,
                    'id_8' => 8,
                    'id_7' => 8,
                    'id_6' => 9,
                ),
                'storageData' => 
                array (
                    'memory_storage' => 
                    array (
                        'id_6' => true,
                        'id_8' => true,
                        'id_9' => true,
                        'id_1' => true,
                        'id_3' => true,
                    ),
                    'array_storage' => 
                    array (
                        'id_1' => true,
                        'id_6' => true,
                        'id_7' => true,
                        'id_8' => true,
                        'id_9' => true,
                        'id_3' => true,
                    ),
                    'eval_array_storage' => 
                    array (
                        'id_4' => true,
                        'id_5' => true,
                        'id_1' => true,
                        'id_2' => true,
                        'id_3' => true,
                        'id_6' => true,
                        'id_7' => true,
                        'id_8' => true,
                        'id_9' => true,
                    ),
                ),
            ),
            $metaData
        );
    }

    public function testNoBubbleUpAgain()
    {
        $stack = ezcCacheManager::getCache( __CLASS__ );
        $data  = $this->testDataArray;

        // Stop bubbling up again
        $stack->options->bubbleUpOnRestore = false;

        // Restore item id_2 from 3rd level without bubbling
        $this->assertEquals(
            $data[1][1],
            $stack->restore( $data[1][0], $data[1][2] )
        );
        // Restore item id_7 from 2nd level without bubbling
        $this->assertEquals(
            'id_7_content',
            $stack->restore( 'id_7' )
        );
        
        $metaData = ezcCacheComplexStackTestConfigurator::$metaStorage->restoreMetaData()->getData();
        $this->assertEquals(
            array (
                'replacementData' => 
                array (
                    'id_9' => 7,
                    'id_3' => 7,
                    'id_5' => 6,
                    'id_4' => 6,
                    'id_2' => 7,
                    'id_1' => 9,
                    'id_8' => 8,
                    'id_7' => 9,
                    'id_6' => 9,
                ),
                'storageData' => 
                array (
                    'memory_storage' => 
                    array (
                        'id_6' => true,
                        'id_8' => true,
                        'id_9' => true,
                        'id_1' => true,
                        'id_3' => true,
                    ),
                    'array_storage' => 
                    array (
                        'id_1' => true,
                        'id_6' => true,
                        'id_7' => true,
                        'id_8' => true,
                        'id_9' => true,
                        'id_3' => true,
                    ),
                    'eval_array_storage' => 
                    array (
                        'id_4' => true,
                        'id_5' => true,
                        'id_1' => true,
                        'id_2' => true,
                        'id_3' => true,
                        'id_6' => true,
                        'id_7' => true,
                        'id_8' => true,
                        'id_9' => true,
                    ),
                ),
            ),
            $metaData
        );
    }
}

?>
