<?php
/**
 * ezcCacheStackLruReplacementStrategyTest 
 * 
 * @package Cache
 * @subpackage Tests
 * @version //autogen//
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Test suite for ezcCacheManager class. 
 * 
 * @package Cache
 * @subpackage Tests
 */
class ezcCacheStackLruReplacementStrategyTest extends ezcTestCase
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

    public function testStoreNewMetaNewItemNoFree()
    {
        $conf = new ezcCacheStackStorageConfiguration(
            'fooid',
            new ezcCacheStorageFileArray(
                $this->createTempDir( __FUNCTION__ )
            ),
            5,
            0.5
        );
        $meta = new ezcCacheStackMetaData();

        ezcCacheStackLruReplacementStrategy::store(
            $conf,
            $meta,
            'barid',
            'baz content'
        );

        $this->assertEquals(
            'baz content',
            $conf->storage->restore( 'barid' ),
            'Data not stored correctly.'
        );

        $this->assertEquals(
            'ezcCacheStackLruReplacementStrategy',
            $meta->id,
            'Meta data ID incorrect.'
        );

        $this->assertGreaterThan(
            // Creation date of test case. Clock correct?
            1209503807,
            $meta->data['lru']['barid'],
            'Meta data entry not created correctly.'
        );

        $this->assertEquals( 
            array(
                'fooid' => true,
            ),
            $meta->data['storages']['barid']
        );
    }

    public function testStoreNoNewMetaNewItemNoFree()
    {
        $conf = new ezcCacheStackStorageConfiguration(
            'fooid',
            new ezcCacheStorageFileArray(
                $this->createTempDir( __FUNCTION__ )
            ),
            5,
            0.5
        );
        $meta = new ezcCacheStackMetaData();
        $meta->id = 'ezcCacheStackLruReplacementStrategy';
        $meta->data = array(
            'lru' => array(
                'someotherid' => 23,
            ),
            'storages' => array(
                'someotherid' => array(
                    'somecacheid' => true,
                ),
            ),
        );

        ezcCacheStackLruReplacementStrategy::store(
            $conf,
            $meta,
            'barid',
            'baz content'
        );

        $this->assertEquals(
            'baz content',
            $conf->storage->restore( 'barid' ),
            'Data not stored correctly.'
        );

        $this->assertGreaterThan(
            // Creation date of test case. Clock correct?
            1209503807,
            $meta->data['lru']['barid'],
            'Meta data entry not created correctly.'
        );

        $this->assertEquals(
            23,
            $meta->data['lru']['someotherid'],
            'Meta data entry not kept correctly.'
        );

        $this->assertEquals( 
            array(
                'someotherid' => array(
                    'somecacheid' => true,
                ),
                'barid' => array(
                    'fooid' => true,
                )
            ),
            $meta->data['storages']
        );
    }

    public function testStoreOldItemNoFree()
    {
        $conf = new ezcCacheStackStorageConfiguration(
            'fooid',
            new ezcCacheStorageFileArray(
                $this->createTempDir( __FUNCTION__ )
            ),
            5,
            0.5
        );
        $meta = new ezcCacheStackMetaData();
        $meta->id = 'ezcCacheStackLruReplacementStrategy';
        $meta->data = array(
            'lru' => array(
                'barid' => 23,
            ),
            'storages' => array(
                'barid' => array(
                    'fooid' => true,
                ),
            ),
        );
        $conf->storage->store( 'barid', 'bazcontent' );

        ezcCacheStackLruReplacementStrategy::store(
            $conf,
            $meta,
            'barid',
            'baz content'
        );

        $this->assertEquals(
            'baz content',
            $conf->storage->restore( 'barid' ),
            'Data not stored correctly.'
        );

        $this->assertEquals(
            'ezcCacheStackLruReplacementStrategy',
            $meta->id,
            'Meta data ID incorrect.'
        );

        $this->assertGreaterThan(
            // Creation date of test case. Clock correct?
            1209503807,
            $meta->data['lru']['barid'],
            'Meta data entry not created correctly.'
        );

        $this->assertEquals( 
            array(
                'fooid' => true,
            ),
            $meta->data['storages']['barid']
        );
    }
}
?>
