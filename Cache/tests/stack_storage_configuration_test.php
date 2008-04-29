<?php
/**
 * ezcCacheStackStorageConfigurationTest 
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
class ezcCacheStackStorageConfigurationTest  extends ezcTestCase
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

    public function testCtorSuccess()
    {
        $storage = new ezcCacheStorageFilePlain( '.' );

        $config = new ezcCacheStackStorageConfiguration(
            'foo',
            $storage,
            1000,
            0.4
        );

        $this->assertAttributeEquals(
            array(
                'id'        => 'foo',
                'storage'   => $storage,
                'itemLimit' => 1000,
                'freeRate'  => 0.4
            ),
            'properties',
            $config
        );
    }

    public function testCtorFailure()
    {
        $storage = new ezcCacheStorageFilePlain( '.' );

        try
        {
            $config = new ezcCacheStackStorageConfiguration(
                '',
                $storage,
                1000,
                0.4
            );
            $this->fail( 'Exception not thrown on invalid ctor parameter.' );
        }
        catch ( ezcBaseValueException $e ) {}
        try
        {
            $config = new ezcCacheStackStorageConfiguration(
                true,
                $storage,
                1000,
                0.4
            );
            $this->fail( 'Exception not thrown on invalid ctor parameter.' );
        }
        catch ( ezcBaseValueException $e ) {}
        try
        {
            $config = new ezcCacheStackStorageConfiguration(
                'foo',
                $storage,
                -1000,
                0.4
            );
            $this->fail( 'Exception not thrown on invalid ctor parameter.' );
        }
        catch ( ezcBaseValueException $e ) {}
        try
        {
            $config = new ezcCacheStackStorageConfiguration(
                'foo',
                $storage,
                0,
                0.4
            );
            $this->fail( 'Exception not thrown on invalid ctor parameter.' );
        }
        catch ( ezcBaseValueException $e ) {}
        try
        {
            $config = new ezcCacheStackStorageConfiguration(
                'foo',
                $storage,
                true,
                0.4
            );
            $this->fail( 'Exception not thrown on invalid ctor parameter.' );
        }
        catch ( ezcBaseValueException $e ) {}
        try
        {
            $config = new ezcCacheStackStorageConfiguration(
                'foo',
                $storage,
                1000,
                0
            );
            $this->fail( 'Exception not thrown on invalid ctor parameter.' );
        }
        catch ( ezcBaseValueException $e ) {}
        try
        {
            $config = new ezcCacheStackStorageConfiguration(
                'foo',
                $storage,
                1000,
                1.1
            );
            $this->fail( 'Exception not thrown on invalid ctor parameter.' );
        }
        catch ( ezcBaseValueException $e ) {}
        try
        {
            $config = new ezcCacheStackStorageConfiguration(
                'foo',
                $storage,
                1000,
                true
            );
            $this->fail( 'Exception not thrown on invalid ctor parameter.' );
        }
        catch ( ezcBaseValueException $e ) {}
    }

    public function testGetAccessSuccess()
    {
        $storage = new ezcCacheStorageFilePlain( '.' );

        $config = new ezcCacheStackStorageConfiguration(
            'foo',
            $storage,
            1000,
            0.4
        );

        $this->assertSame(
            'foo',
            $config->id
        );
        $this->assertSame(
            $storage,
            $config->storage
        );
        $this->assertSame(
            1000,
            $config->itemLimit
        );
        $this->assertSame(
            0.4,
            $config->freeRate
        );
    }

    public function testGetAccessFailure()
    {
        $storage = new ezcCacheStorageFilePlain( '.' );

        $config = new ezcCacheStackStorageConfiguration(
            'foo',
            $storage,
            1000,
            0.4
        );
        
        try
        {
            echo $config->foo;
            $this->fail( 'Exception not thrown on get access to invalid property.' );
        }
        catch ( ezcBasePropertyNotFoundException $e ) {}
    }

    public function testSetAccessFailure()
    {
        $storage = new ezcCacheStorageFilePlain( '.' );

        $config = new ezcCacheStackStorageConfiguration(
            'foo',
            $storage,
            1000,
            0.4
        );

        try
        {
            $config->id = true;
            $this->fail( 'Exception not thrown on set access.' );
        }
        catch ( ezcBasePropertyPermissionException $e ) {}
        try
        {
            $config->storage = true;
            $this->fail( 'Exception not thrown on set access.' );
        }
        catch ( ezcBasePropertyPermissionException $e ) {}
        try
        {
            $config->itemLimit = true;
            $this->fail( 'Exception not thrown on set access.' );
        }
        catch ( ezcBasePropertyPermissionException $e ) {}
        try
        {
            $config->freeRate = true;
            $this->fail( 'Exception not thrown on set access.' );
        }
        catch ( ezcBasePropertyPermissionException $e ) {}
        
        try
        {
            $config->foo = true;
            $this->fail( 'Exception not thrown on set access to invalid property.' );
        }
        catch ( ezcBasePropertyNotFoundException $e ) {}
    }

    public function testIssetAccess()
    {
        $storage = new ezcCacheStorageFilePlain( '.' );

        $config = new ezcCacheStackStorageConfiguration(
            'foo',
            $storage,
            1000,
            0.4
        );

        $this->assertTrue( isset( $config->id ) );
        $this->assertTrue( isset( $config->storage ) );
        $this->assertTrue( isset( $config->itemLimit ) );
        $this->assertTrue( isset( $config->freeRate ) );

        $this->assertFalse( isset( $config->foo ) );
    }
}
?>
