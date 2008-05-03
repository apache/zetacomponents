<?php
/**
 * ezcCacheStackTest 
 * 
 * @package Cache
 * @subpackage Tests
 * @version //autogen//
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

class ezcCacheTestStackConfigurator implements ezcCacheStackConfigurator
{
    public static $options;

    public static $storageConf;

    public static function configure( ezcCacheStack $stack )
    {
        $stack->options = self::$options;
        $stack->pushStorage( self::$storageConf );
    }
}

/**
 * Test suite for ezcCacheStack class. 
 * 
 * @package Cache
 * @subpackage Tests
 */
class ezcCacheStackTest extends ezcTestCase
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

    public function testCtorNoConfigurator()
    {
        $options  = new ezcCacheStackOptions();
        $location = 'foo';

        $stack = new ezcCacheStack( 'foo' );

        $this->assertAttributeEquals(
            array(
                'location' => 'foo',
                'options'  => new ezcCacheStackOptions(),
            ),
            'properties',
            $stack
        );

        $stack = new ezcCacheStack( 'foo', $options );

        $properties = $this->getObjectAttribute( $stack, 'properties' );

        $this->assertEquals(
            'foo',
            $properties['location']
        );
        $this->assertSame(
            $options,
            $properties['options']
        );
    }

    public function testCtorWithConfigurator()
    {
        $configuredOptions = new ezcCacheStackOptions();
        ezcCacheTestStackConfigurator::$options     = $configuredOptions;
        ezcCacheTestStackConfigurator::$storageConf = new ezcCacheStackStorageConfiguration(
            '1',
            new ezcCacheStorageFileArray(
                $this->createTempDir( __FUNCTION__ )
            ),
            10,
            .4
        );

        $options  = new ezcCacheStackOptions();
        $location = 'foo';

        $options->configurator = 'ezcCacheTestStackConfigurator';

        $stack = new ezcCacheStack( $location, $options );

        $this->assertSame(
            $configuredOptions,
            $stack->options
        );
        $this->assertAttributeEquals(
            array(
                ezcCacheTestStackConfigurator::$storageConf,
            ),
            'storageStack',
            $stack
        );
        $this->removeTempDir();
    }

    public function testPushStorageSuccess()
    {
        $stack = new ezcCacheStack( 'foo' );

        $storageConf1 = new ezcCacheStackStorageConfiguration(
            'id_1',
            new ezcCacheStorageFileArray( '/tmp' ),
            10,
            .5
        );
        $storageConf2 = new ezcCacheStackStorageConfiguration(
            'id_2',
            new ezcCacheStorageFileArray( '/tmp' ),
            100,
            .9
        );

        $stack->pushStorage( $storageConf1 );
        $stack->pushStorage( $storageConf2 );

        $this->assertAttributeEquals(
            array(
                $storageConf2,
                $storageConf1,
            ),
            'storageStack',
            $stack
        );
        $this->assertAttributeEquals(
            array(
                $storageConf2->id => $storageConf2->storage,
                $storageConf1->id => $storageConf1->storage,
            ),
            'storageIdMap',
            $stack
        );
    }

    public function testPushStorageFailureId()
    {
        $stack = new ezcCacheStack( 'foo' );

        $storageConf1 = new ezcCacheStackStorageConfiguration(
            'id_1',
            new ezcCacheStorageFileArray( '/tmp' ),
            10,
            .5
        );
        $storageConf2 = new ezcCacheStackStorageConfiguration(
            'id_1',
            new ezcCacheStorageFileArray( '/tmp' ),
            100,
            .9
        );

        $stack->pushStorage( $storageConf1 );

        try
        {
            $stack->pushStorage( $storageConf2 );
            $this->fail( 'Exception not thrown on double taken ID.' );
        }
        catch ( ezcCacheStackIdAlreadyUsedException $e ) {}
    }

    public function testPushStorageFailureStorage()
    {
        $stack = new ezcCacheStack( 'foo' );

        $storageConf1 = new ezcCacheStackStorageConfiguration(
            'id_1',
            new ezcCacheStorageFileArray( '/tmp' ),
            10,
            .5
        );
        $storageConf2 = new ezcCacheStackStorageConfiguration(
            'id_2',
            $storageConf1->storage,
            100,
            .9
        );

        $stack->pushStorage( $storageConf1 );

        try
        {
            $stack->pushStorage( $storageConf2 );
            $this->fail( 'Exception not thrown on double taken ID.' );
        }
        catch ( ezcCacheStackStorageUsedTwiceException $e ) {}
    }

    public function testPopStorageSuccess()
    {
        $stack = new ezcCacheStack( 'foo' );

        $storageConf1 = new ezcCacheStackStorageConfiguration(
            'id_1',
            new ezcCacheStorageFileArray( '/tmp' ),
            10,
            .5
        );
        $storageConf2 = new ezcCacheStackStorageConfiguration(
            'id_2',
            new ezcCacheStorageFileArray( '/tmp' ),
            100,
            .9
        );

        $stack->pushStorage( $storageConf1 );
        $stack->pushStorage( $storageConf2 );

        $this->assertAttributeEquals(
            array(
                $storageConf2,
                $storageConf1,
            ),
            'storageStack',
            $stack
        );
        $this->assertAttributeEquals(
            array(
                $storageConf1->id => $storageConf1->storage,
                $storageConf2->id => $storageConf2->storage,
            ),
            'storageIdMap',
            $stack
        );

        $this->assertSame(
            $storageConf2,
            $stack->popStorage()
        );
        $this->assertAttributeEquals(
            array(
                $storageConf1,
            ),
            'storageStack',
            $stack
        );
        $this->assertAttributeEquals(
            array(
                $storageConf1->id => $storageConf1->storage,
            ),
            'storageIdMap',
            $stack
        );

        $this->assertSame(
            $storageConf1,
            $stack->popStorage()
        );
        $this->assertAttributeEquals(
            array(
            ),
            'storageStack',
            $stack
        );
        $this->assertAttributeEquals(
            array(
            ),
            'storageIdMap',
            $stack
        );
    }

    public function testPopStorageFailure()
    {
        $stack = new ezcCacheStack( 'foo' );
        
        try
        {
            $stack->popStorage();
            $this->fail( 'Exception not thrown on popStorage() on empty stack.' );
        }
        catch ( ezcCacheStackUnderflowException $e ) {}
    }

    public function testCountStorages()
    {
        $stack = new ezcCacheStack( 'foo' );

        $storageConf1 = new ezcCacheStackStorageConfiguration(
            'id_1',
            new ezcCacheStorageFileArray( '/tmp' ),
            10,
            .5
        );
        $storageConf2 = new ezcCacheStackStorageConfiguration(
            'id_2',
            new ezcCacheStorageFileArray( '/tmp' ),
            100,
            .9
        );

        $this->assertEquals(
            0,
            $stack->countStorages()
        );

        $stack->pushStorage( $storageConf1 );

        $this->assertEquals(
            1,
            $stack->countStorages()
        );

        $stack->pushStorage( $storageConf2 );

        $this->assertEquals(
            2,
            $stack->countStorages()
        );

        $stack->popStorage();

        $this->assertEquals(
            1,
            $stack->countStorages()
        );

        $stack->popStorage();

        $this->assertEquals(
            0,
            $stack->countStorages()
        );
    }

    public function testGetStackedStoraqes()
    {
        $stack = new ezcCacheStack( 'foo' );

        $storageConf1 = new ezcCacheStackStorageConfiguration(
            'id_1',
            new ezcCacheStorageFileArray( '/tmp' ),
            10,
            .5
        );
        $storageConf2 = new ezcCacheStackStorageConfiguration(
            'id_2',
            new ezcCacheStorageFileArray( '/tmp' ),
            100,
            .9
        );

        $this->assertEquals(
            array(),
            $stack->getStorages()
        );

        $stack->pushStorage( $storageConf1 );

        $this->assertEquals(
            array(
                $storageConf1
            ),
            $stack->getStorages()
        );

        $stack->pushStorage( $storageConf2 );

        $this->assertEquals(
            array(
                $storageConf2,
                $storageConf1,
            ),
            $stack->getStorages()
        );

        $stack->popStorage();

        $this->assertEquals(
            array(
                $storageConf1
            ),
            $stack->getStorages()
        );

        $stack->popStorage();

        $this->assertEquals(
            array(),
            $stack->getStorages()
        );
    }

    public function testReset()
    {
        $storage1 = $this->getMock(
            'ezcCacheStackableStorage',
            array( 'reset', 'purge' )
        );
        $storage1->expects( $this->once() )
                 ->method( 'reset' );
        $storage1->expects( $this->never() )
                 ->method( 'purge' );

        $storage2 = $this->getMock(
            'ezcCacheStackableStorage',
            array( 'reset', 'purge' )
        );
        $storage2->expects( $this->once() )
                 ->method( 'reset' );
        $storage2->expects( $this->never() )
                 ->method( 'purge' );

        $stack = new ezcCacheStack( 'foo' );
        $stack->pushStorage(
            new ezcCacheStackStorageConfiguration(
                'id_1',
                $storage1,
                10,
                .5
            )
        );
        $stack->pushStorage(
            new ezcCacheStackStorageConfiguration(
                'id_2',
                $storage2,
                10,
                .5
            )
        );

        $stack->reset();
    }

    public function testGetRemainingLifetimeFound()
    {
        $storage1 = $this->getMock(
            'ezcCacheStackableStorage',
            array( 'reset', 'purge', 'getRemainingLifetime' )
        );
        $storage1->expects( $this->once() )
                 ->method( 'getRemainingLifetime' )
                 ->with( 'foo', array() )
                 ->will( $this->returnValue( 23 ) );
        $storage2 = $this->getMock(
            'ezcCacheStackableStorage',
            array( 'reset', 'purge', 'getRemainingLifetime' )
        );
        $storage2->expects( $this->once() )
                 ->method( 'getRemainingLifetime' )
                 ->with( 'foo', array() )
                 ->will( $this->returnValue( 0 ) );
        
        $stack = new ezcCacheStack( 'foo' );
        $stack->pushStorage(
            new ezcCacheStackStorageConfiguration(
                'id_1',
                $storage1,
                10,
                .5
            )
        );
        $stack->pushStorage(
            new ezcCacheStackStorageConfiguration(
                'id_2',
                $storage2,
                10,
                .5
            )
        );

        $this->assertEquals(
            23,
            $stack->getRemainingLifetime( 'foo' )
        );
    }

    public function testGetRemainingLifetimeNotFound()
    {
        $storage1 = $this->getMock(
            'ezcCacheStackableStorage',
            array( 'reset', 'purge', 'getRemainingLifetime' )
        );
        $storage1->expects( $this->once() )
                 ->method( 'getRemainingLifetime' )
                 ->with( 'foo', array() )
                 ->will( $this->returnValue( 0 ) );
        
        $stack = new ezcCacheStack( 'foo' );
        $stack->pushStorage(
            new ezcCacheStackStorageConfiguration(
                'id_1',
                $storage1,
                10,
                .5
            )
        );

        $this->assertEquals(
            0,
            $stack->getRemainingLifetime( 'foo' )
        );

    }

    public function testCountDataItems()
    {
        $storage1 = $this->getMock(
            'ezcCacheStackableStorage',
            array( 'reset', 'purge', 'countDataItems' )
        );
        $storage1->expects( $this->once() )
                 ->method( 'countDataItems' )
                 ->with( 'foo', array() )
                 ->will( $this->returnValue( 2 ) );
        
        $storage2 = $this->getMock(
            'ezcCacheStackableStorage',
            array( 'reset', 'purge', 'countDataItems' )
        );
        $storage2->expects( $this->once() )
                 ->method( 'countDataItems' )
                 ->with( 'foo', array() )
                 ->will( $this->returnValue( 1 ) );
        
        $stack = new ezcCacheStack( 'foo' );
        $stack->pushStorage(
            new ezcCacheStackStorageConfiguration(
                'id_1',
                $storage1,
                10,
                .5
            )
        );
        $stack->pushStorage(
            new ezcCacheStackStorageConfiguration(
                'id_2',
                $storage2,
                100,
                .7
            )
        );

        $this->assertEquals(
            3,
            $stack->countDataItems( 'foo' )
        );

    }

    public function testDeleteById()
    {
        $storage1 = $this->getMock(
            'ezcCacheStackableStorage',
            array( 'reset', 'purge', 'delete' )
        );
        $storage1->expects( $this->once() )
                 ->method( 'delete' )
                 ->with( 'id_1', array() )
                 ->will(
            $this->returnValue(
                array( 'id_1' )
            )
        );
        
        $storage2 = $this->getMock(
            'ezcCacheStackableStorage',
            array( 'reset', 'purge', 'delete' )
        );
        $storage2->expects( $this->once() )
                 ->method( 'delete' )
                 ->with( 'id_1', array() )
                 ->will(
            $this->returnValue(
                array( 'id_1' )
            )
        );
        
        $stack                       = new ezcCacheStack( 'foo' );
        $stack->options->metaStorage = $this->getMetaStorageMock();

        $stack->pushStorage(
            new ezcCacheStackStorageConfiguration(
                'id_1',
                $storage1,
                10,
                .5
            )
        );
        $stack->pushStorage(
            new ezcCacheStackStorageConfiguration(
                'id_2',
                $storage2,
                100,
                .7
            )
        );

        $this->assertEquals(
            array( 'id_1' ),
            $stack->delete( 'id_1' )
        );

    }

    public function testDeleteByAttributes()
    {
        $metaData = new ezcCacheStackMetaData();

        $storage1 = $this->getMock(
            'ezcCacheStackableStorage',
            array( 'reset', 'purge', 'delete' )
        );
        $storage1->expects( $this->once() )
                 ->method( 'delete' )
                 ->with( null, array( 'lang' => 'de' ) )
                 ->will(
            $this->returnValue(
                array( 'id_1', 'id_3' )
            )
        );
        
        $storage2 = $this->getMock(
            'ezcCacheStorageFilePlain',
            array(),
            array( $this->createTempDir( __FUNCTION__ ) )
        );
        $storage2->expects( $this->once() )
                 ->method( 'delete' )
                 ->with( null, array( 'lang' => 'de' ) )
                 ->will(
            $this->returnValue(
                array( 'id_1', 'id_2', 'id_3' )
            )
        );
        // Meta storage behavior
        $storage2->expects( $this->once() )
                    ->method( 'lock' );
        $storage2->expects( $this->once() )
                    ->method( 'unlock' );
        $storage2->expects( $this->once() )
                    ->method('restoreMetaData' )
                    ->will(
            $this->returnValue(
                $metaData
            )
        );
        $storage2->expects( $this->once() )
                    ->method( 'storeMetaData' )
                    ->with( $metaData );
        
        $stack = new ezcCacheStack( 'foo' );

        $stack->pushStorage(
            new ezcCacheStackStorageConfiguration(
                'id_1',
                $storage1,
                10,
                .5
            )
        );
        $stack->pushStorage(
            new ezcCacheStackStorageConfiguration(
                'id_2',
                $storage2,
                100,
                .7
            )
        );

        $this->assertEquals(
            array(
                0 => 'id_1',
                1 => 'id_2',
                2 => 'id_3'
            ),
            $stack->delete( null, array( 'lang' => 'de' ) )
        );
    }

    public function testRestoreSuccessNoBubbleUp()
    {
        $storage1 = $this->getMock(
            'ezcCacheStackableStorage',
            array( 'reset', 'purge', 'restore' )
        );
        $storage1->expects( $this->once() )
                 ->method( 'restore' )
                 ->with( 'id_1', array() )
                 ->will(
            $this->returnValue(
                'id_1'
            )
        );
        
        $storage2 = $this->getMock(
            'ezcCacheStackableStorage',
            array( 'reset', 'purge', 'restore' )
        );
        $storage2->expects( $this->once() )
                 ->method( 'restore' )
                 ->with( 'id_1', array() )
                 ->will(
            $this->returnValue(
                false
            )
        );

        $stack                       = new ezcCacheStack( 'foo' );
        $stack->options->metaStorage = $this->getMetaStorageMock();

        $stack->pushStorage(
            new ezcCacheStackStorageConfiguration(
                'id_1',
                $storage1,
                10,
                .5
            )
        );
        $stack->pushStorage(
            new ezcCacheStackStorageConfiguration(
                'id_2',
                $storage2,
                100,
                .7
            )
        );

        $this->assertEquals(
            'id_1',
            $stack->restore( 'id_1' )
        );
    }

    public function testRestoreSuccessBubbleUp()
    {
        $storage1 = $this->getMock(
            'ezcCacheStackableStorage',
            array( 'reset', 'purge', 'restore' )
        );
        $storage1->expects( $this->never() )
                 ->method( 'restore' );
        $storage1->expects( $this->never() )
                 ->method( 'store' );
        
        $storage2 = $this->getMock(
            'ezcCacheStackableStorage',
            array( 'reset', 'purge', 'restore' )
        );
        $storage2->expects( $this->once() )
                 ->method( 'restore' )
                 ->with( 'id_1', array() )
                 ->will(
            $this->returnValue(
                'id_1'
            )
        );
        $storage2->expects( $this->never() )
                 ->method( 'store' );
        
        $storage3 = $this->getMock(
            'ezcCacheStackableStorage',
            array( 'reset', 'purge', 'restore', 'store' )
        );
        $storage3->expects( $this->once() )
                 ->method( 'restore' )
                 ->with( 'id_1', array() )
                 ->will(
            $this->returnValue(
                false
            )
        );
        $storage3->expects( $this->once() )
                 ->method( 'store' )
                 ->with( 'id_1', 'id_1', array() );

        $stack                             = new ezcCacheStack( 'foo' );
        $stack->options->metaStorage       = $this->getMetaStorageMock();
        $stack->options->bubbleUpOnRestore = true;

        $stack->pushStorage(
            new ezcCacheStackStorageConfiguration(
                'id_1',
                $storage1,
                10,
                .5
            )
        );
        $stack->pushStorage(
            new ezcCacheStackStorageConfiguration(
                'id_2',
                $storage2,
                100,
                .7
            )
        );
        $stack->pushStorage(
            new ezcCacheStackStorageConfiguration(
                'id_3',
                $storage3,
                5,
                .2
            )
        );

        $this->assertEquals(
            'id_1',
            $stack->restore( 'id_1' )
        );
    }

    public function testRestoreFailure()
    {
        $storage1 = $this->getMock(
            'ezcCacheStackableStorage',
            array( 'reset', 'purge', 'restore' )
        );
        $storage1->expects( $this->once() )
                 ->method( 'restore' )
                 ->with( 'id_1', array() )
                 ->will(
            $this->returnValue(
                false
            )
        );
        
        $storage2 = $this->getMock(
            'ezcCacheStackableStorage',
            array( 'reset', 'purge', 'restore' )
        );
        $storage2->expects( $this->once() )
                 ->method( 'restore' )
                 ->with( 'id_1', array() )
                 ->will(
            $this->returnValue(
                false
            )
        );

        $stack                       = new ezcCacheStack( 'foo' );
        $stack->options->metaStorage = $this->getMetaStorageMock();

        $stack->pushStorage(
            new ezcCacheStackStorageConfiguration(
                'id_1',
                $storage1,
                10,
                .5
            )
        );
        $stack->pushStorage(
            new ezcCacheStackStorageConfiguration(
                'id_2',
                $storage2,
                100,
                .7
            )
        );

        $this->assertFalse(
            $stack->restore( 'id_1' )
        );
    }

    public function testStore()
    {
        $storage1 = $this->getMock(
            'ezcCacheStackableStorage',
            array( 'reset', 'purge', 'store' )
        );
        $storage1->expects( $this->once() )
                 ->method( 'store' )
                 ->with( 'id_1', 'id_1_data', array( 'lang' => 'en' ) );
        
        $storage2 = $this->getMock(
            'ezcCacheStackableStorage',
            array( 'reset', 'purge', 'store' )
        );
        $storage2->expects( $this->once() )
                 ->method( 'store' )
                 ->with( 'id_1', 'id_1_data', array( 'lang' => 'en' ) );

        $stack                       = new ezcCacheStack( 'foo' );
        $stack->options->metaStorage = $this->getMetaStorageMock();

        $stack->pushStorage(
            new ezcCacheStackStorageConfiguration(
                'id_1',
                $storage1,
                10,
                .5
            )
        );
        $stack->pushStorage(
            new ezcCacheStackStorageConfiguration(
                'id_2',
                $storage2,
                100,
                .7
            )
        );

        $this->assertNull(
            $stack->store( 'id_1', 'id_1_data', array( 'lang' => 'en' ) )
        );
    }

    protected function getMetaStorageMock()
    {
        $metaData = new ezcCacheStackMetaData();
        $metaStorage = $this->getMock(
            'ezcCacheMetaDataStorage',
            array( 'lock', 'unlock', 'restoreMetaData', 'storeMetaData' )
        );
        $metaStorage->expects( $this->once() )
                    ->method( 'lock' );
        $metaStorage->expects( $this->once() )
                    ->method( 'unlock' );
        $metaStorage->expects( $this->once() )
                    ->method('restoreMetaData' )
                    ->will(
            $this->returnValue(
                $metaData
            )
        );
        $metaStorage->expects( $this->once() )
                    ->method( 'storeMetaData' )
                    ->with( $metaData );
        return $metaStorage;
    }
}
?>
