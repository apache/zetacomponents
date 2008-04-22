<?php
/**
 * ezcCacheStorageTest 
 * 
 * @package Cache
 * @subpackage Tests
 * @version //autogen//
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

include_once( 'Cache/tests/test.php' );

/**
 * Abstract base test class for ezcCacheStorage tests.
 * 
 * @package Cache
 * @subpackage Tests
 */
abstract class ezcCacheStorageTest extends ezcCacheTest
{
    /**
     * storageClass 
     * 
     * @var mixed
     * @access protected
     */
    protected $storageClass;
    
    /**
     * storage; 
     * 
     * @var mixed
     * @access protected
     */
    protected $storage;

    /**
     * location; 
     * 
     * @var mixed
     * @access protected
     */
    protected $location;

    /**
     * data 
     * 
     * @var array
     * @access protected
     */
    protected $testData = array(
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
        8 => false,
        9 => 12345,
       10 => 12.3746,
    );

    protected function setUp()
    {
        // Class name == <inheriting class> - "Test"
        $storageClass = ( $this->storageClass = substr( get_class( $this ), 0, strlen( get_class(  $this ) ) - 4 ) );
        if ( preg_match( '(File)', $storageClass ) > 0 )
        {
            $this->storage = new $storageClass( $this->createTempDir( 'ezcCacheTest' ) );
        }
        else
        {
            $this->storage = new $storageClass();
        }
    }

    protected function tearDown()
    {
        $this->removeTempDir();
    }

    /**
     * testStoreSuccessWithoutAttributes 
     * 
     * @access public
     */
    public function testStoreSuccessWithoutAttributes()
    {
        foreach ( $this->testData as $id => $dataArr ) 
        {
            $this->storage->store( $id, $dataArr );
            $this->assertEquals( $this->storage->countDataItems( $id ), 1, 'Storage file does not exist for ID: <' . $id . '>.' );
        }
    }

    /**
     * testStoreSuccessWithAttributes 
     * 
     * @access public
     */
    public function testStoreSuccessWithAttributes()
    {
        foreach ( $this->testData as $id => $dataArr ) 
        {
            $attributes = array(
                'name'      => 'test',
                'title'     => 'Test item',
                'date'      => time().$id,
            );
            $this->storage->store( $id, $dataArr, $attributes );
            $this->assertEquals( $this->storage->countDataItems( $id, $attributes ), 1, 'Storage file does not exist for ID: <' . $id . '>.' );
        }
    }

    /**
     * testConstructorErrorLocationNotExists 
     * 
     * @access public
     */
    public function testConstructorErrorLocationNotExists() 
    {
        // Produce "Location not available" exception.
        $nonExistingPath = $this->getTempDir().'/DoesNotExist123/';
        try
        {
            $cache = new ezcCacheStorageFileArray( $nonExistingPath );
            $this->fail( 'Exception "Location not available" not thrown.' );
        }
        catch ( ezcBaseFileNotFoundException $e )
        {
            return;
        }
        $this->fail( 'Exception "Location not available" not thrown.' );
    }

    /**
     * testConstructorErrorLocationNotWriteable 
     * 
     * @access public
     */
    public function testConstructorErrorLocationNotWriteable()
    {
        // If running as root you can always write, so this test should be skipped when running as root.
        if ( !ezcBaseFeatures::hasFunction("posix_getuid") || posix_getuid() == 0 )
        {
            return;
        }
        // Produce "Location not writeable" exception
        if ( ( $oldMode = fileperms( $this->getTempDir() ) ) === false ) 
        {
            throw new Exception( 'Could not determine old file permissions for location <' . $this->getTempDir() . '>.' );
        }
        if ( chmod( $this->getTempDir(), 0000 ) === false ) 
        {
            throw new Exception( 'Could not change permissions for location <' . $this->getTempDir() . '> to 0000.' );
        }
        $exceptionThrown = false;
        try 
        {
            $cache = new $this->storageClass( $this->getTempDir() );
        }
        catch ( ezcBaseFilePermissionException $e ) 
        {
            $exceptionThrown = true;
        }
        if ( chmod( $this->getTempDir(), $oldMode ) === false ) 
        {
            throw new Exception( 'Could not change permissions for location <' . $this->getTempDir() . '> to '.$oldMode.'.' );
        }
        if ( $exceptionThrown === false)
        {
            $this->fail( 'Exception "Location not writeable" not thrown.' );
        } 
    }

    /**
     * testStoreRestoreSuccessWithoutAttributes 
     * 
     * @access public
     */
    public function testStoreRestoreSuccessWithoutAttributes()
    {
        foreach ( $this->testData as $id => $dataArr ) 
        {
            $this->storage->store( $id, $dataArr );
            $data = $this->storage->restore( $id );
            $this->assertTrue( $data == $dataArr, "Restore data broken for ID <{$id}>." );
        }
    }

    /**
     * testStoreRestoreSuccessWithAttributes 
     * 
     * @access public
     */
    public function testStoreRestoreSuccessWithAttributes()
    {
        foreach ( $this->testData as $id => $dataArr ) 
        {
            $attributes = array(
                'name'      => 'test',
                'title'     => 'Test item',
                'date'      => time().$id,
            );
            $this->storage->store( $id, $dataArr, $attributes );
            $data = $this->storage->restore( $id, $attributes );
            $this->assertTrue( $data == $dataArr, "Restore data broken for ID <{$id}>." );
        }
    }

    /**
     * testStoreRestoreOutdatedWithoutAttributes 
     * 
     * @access public
     */
    public function testStoreRestoreOutdatedWithoutAttributes()
    {
        // Test with 10 seconds lifetime
        $this->storage->setOptions( array( 'ttl' => 10 ) );
        foreach ( $this->testData as $id => $dataArr ) 
        {
        
            $filename = $this->storage->getLocation() . $this->storage->generateIdentifier( $id );

            $this->storage->store( $id, $dataArr );
            // Faking the m/a-time to be 100 seconds in the past
            touch( $filename, ( time()  - 100 ), ( time()  - 100 ) );
            
            // Wait for cache to be outdated.
            $data = $this->storage->restore( $id );
            $this->assertTrue( $data === false, "Restore data broken for ID <{$id}>." );
        }
    }

    /**
     * testStoreRestoreOutdatedWithAttributes 
     * 
     * @access public
     */
    public function testStoreRestoreOutdatedWithAttributes()
    {
        // Test with 10 seconds lifetime
        $this->storage->setOptions( array( 'ttl' => 10 ) );
        
        foreach ( $this->testData as $id => $dataArr ) 
        {
            $attributes = array(
                'name'      => 'test',
                'title'     => 'Test item',
                'date'      => time().$id,
            );
            
            $filename = $this->storage->getLocation() . $this->storage->generateIdentifier( $id, $attributes );
            
            $this->storage->store( $id, $dataArr, $attributes );
            // Faking the m/a-time to be 100 seconds in the past
            touch( $filename, ( time() - 100 ), ( time() - 100 ) );
           
            $data = $this->storage->restore( $id, $attributes );
            $this->assertTrue( $data === false, "Restore data broken for ID <{$id}>." );
        }
    }

    /**
     * testStoreDeleteSuccessWithoutAttributes 
     * 
     * @access public
     */
    public function testStoreDeleteSuccessWithoutAttributes()
    {
        foreach ( $this->testData as $id => $dataArr ) 
        {
            $this->storage->store( $id, $dataArr );
            $this->storage->delete( $id );
            $data = $this->storage->restore( $id );
            $this->assertTrue( $data == false, "Data not deleted for ID <{$id}>." );
        }
    }

    /**
     * testStoreDeleteSuccessWithAttributes 
     * 
     * @access public
     */
    public function testStoreDeleteSuccessWithAttributes()
    {
        foreach ( $this->testData as $id => $dataArr ) 
        {
            $attributes = array(
                'name'      => 'test',
                'title'     => 'Test item',
                'date'      => time().$id,
            );
            $this->storage->store( $id, $dataArr, $attributes );
            $this->storage->delete( $id, $attributes );
            $data = $this->storage->restore( $id );
            $this->assertTrue( $data == false, "Data not deleted for ID <{$id}>." );
        }
    }

    /**
     * testStoreDeleteSuccessOnlyAttributes 
     * 
     * @access public
     */
    public function testStoreDeleteSuccessOnlyAttributes()
    {
        $attributes = array(
            'name'      => 'test',
            'title'     => 'Test item',
            'date'      => time(),
        );
        foreach ( $this->testData as $id => $dataArr ) 
        {
            $this->storage->store( $id, $dataArr, $attributes );
        }
        $this->storage->delete( null, $attributes );
        foreach ( $this->testData as $id => $dataArr ) 
        {
            $data = $this->storage->restore( $id );
            $this->assertTrue( $data == false, "Data not deleted for ID <{$id}>." );
        }
    }

    /**
     * testStoreHasDataSuccessWithoutAttributes 
     * 
     * @access public
     */
    public function testStoreHasDataSuccessWithoutAttributes()
    {
        foreach ( $this->testData as $id => $dataArr ) 
        {
            $this->storage->store( $id, $dataArr );
            $this->assertTrue( $this->storage->countDataItems( $id ) == 1, "countDataItems cannot find data for ID <{$id}>." );
        }
    }

    /**
     * testStoreHasDataSuccessWithAttributes 
     * 
     * @access public
     */
    public function testStoreHasDataSuccessWithAttributes()
    {
        foreach ( $this->testData as $id => $dataArr ) 
        {
            $attributes = array(
                'name'      => 'test',
                'title'     => 'Test item',
                'date'      => time().$id,
            );
            $this->storage->store( $id, $dataArr, $attributes );
            $this->assertTrue( $this->storage->countDataItems( $id, $attributes ) == 1, "countDataItems cannot find data for ID <{$id}>." );
        }
    }

    /**
     * testStoreHasDataSuccessOnlyAttributes 
     * 
     * @access public
     */
    public function testStoreHasDataSuccessOnlyAttributes()
    {
        foreach ( $this->testData as $id => $dataArr ) 
        {
            $attributes = array(
                'name'      => 'test',
                'title'     => 'Test item',
                'date'      => time().$id,
            );
            $this->storage->store( $id, $dataArr, $attributes );
            $this->assertTrue( $this->storage->countDataItems( null, $attributes ) == 1, "countDataItems cannot find data for ID <{$id}>." );
        }
    }

    public function testStoreHasDataSuccessMultipleAttributes()
    {
        $attributes = array(
            'name'      => 'test',
            'title'     => 'Test item',
        );
        foreach ( $this->testData as $id => $dataArr ) 
        {
            $this->storage->store( $id, $dataArr, $attributes );
        }
        $this->assertTrue( $this->storage->countDataItems( null, $attributes ) == count( $this->testData ), 'HasData found wrong count of data for attributes: <' . $this->storage->countDataItems() . '>.' );
    }

    public function testCountDataItemsNoIdSubdirs()
    {
        $id = 'id/with/slashes/';
        $attributes = array( 'class' => 23 );
        foreach ( $this->testData as $idSuffix => $data)
        {
            $this->storage->store( $id . $idSuffix, $data, $attributes );
        }

        $this->assertEquals(
            sizeof( $this->testData ),
            $this->storage->countDataItems( null, $attributes ),
            "Data count for ID with slashes incorrect."
        );

    }
    
    public function testCountDataItemsIdSubdirs()
    {
        $id = 'id/with/slashes/';
        $attributes = array( 'class' => 23 );
        foreach ( $this->testData as $idSuffix => $data)
        {
            $this->storage->store( $id . $idSuffix, $data, $attributes );
        }

        foreach ( $this->testData as $idSuffix => $data) {
            $this->assertEquals(
                1,
                $this->storage->countDataItems( $id . $idSuffix, $attributes ),
                "Data count for ID with slashes incorrect."
            );
        }
    }
    
    public function testCountDataItemsIdNoAttributesSubdirs()
    {
        $id = 'id/with/slashes/';
        $attributes = array( 'class' => 23 );
        foreach ( $this->testData as $idSuffix => $data)
        {
            $this->storage->store( $id . $idSuffix, $data, $attributes );
        }

        foreach ( $this->testData as $idSuffix => $data) {
            $this->assertEquals(
                1,
                $this->storage->countDataItems( $id . $idSuffix ),
                "Data count for ID with slashes incorrect."
            );
        }
    }

    public function testStoreRestoreNoAttributesSearch()
    {
        foreach ( $this->testData as $id => $dataArr ) 
        {
            $this->storage->store( $id, $dataArr );
            $data = $this->storage->restore( $id, array(), true );
            $this->assertTrue( $data == $dataArr, "Restore data broken for ID <{$id}>." );
        }
    }

    public function testStoreRestoreWithAttributesSearch()
    {
        foreach ( $this->testData as $id => $dataArr ) 
        {
            $attributes = array(
                'name'      => 'test',
                'title'     => 'Test item',
                'date'      => time().$id,
            );
            $this->storage->store( $id, $dataArr, $attributes );
            $data = $this->storage->restore( $id, $attributes, true );
            $this->assertTrue( $data == $dataArr, "Restore data broken for ID <{$id}>." );
        }
    }

    public function testStoreRestoreWithAttributesSearchNoAttributes()
    {
        foreach ( $this->testData as $id => $dataArr ) 
        {
            $attributes = array(
                'name'      => 'test',
                'title'     => 'Test item',
                'date'      => time().$id,
            );
            $this->storage->store( $id, $dataArr, $attributes );
            $data = $this->storage->restore( $id, array(), true );
            $this->assertTrue( $data == $dataArr, "Restore data broken for ID <{$id}>." );
        }
    }

    public function testStoreRestoreWithAttributesSearchNoId()
    {
        foreach ( $this->testData as $id => $dataArr ) 
        {
            $attributes = array(
                'name'      => 'test',
                'title'     => 'Test item',
                'date'      => time().$id,
            );
            $this->storage->store( $id, $dataArr, $attributes );
            $data = $this->storage->restore( null, $attributes, true );
            $this->assertTrue( $data == $dataArr, "Restore data broken for ID <{$id}>." );
        }
    }

    public function testStoreRestoreWithAttributesSearchNoAttributesNoId()
    {
        $count = 0;
        foreach ( $this->testData as $id => $dataArr ) 
        {
            $attributes = array(
                'name'      => 'test',
                'title'     => 'Test item',
                'date'      => time().$id,
            );
            $this->storage->store( $id, $dataArr, $attributes );
            $data = $this->storage->restore( null, array(), true );
            if ( $count === 0 )
            {
                $this->assertTrue( $data == $dataArr, "Restore data broken for ID <{$id}>." );
            }
            else
            {
                // There are more elements found during search, so false is returned
                $this->assertTrue( $data == false, "Restore data broken for ID <{$id}>." );
            }
            $count++;
        }
    }
}
?>
