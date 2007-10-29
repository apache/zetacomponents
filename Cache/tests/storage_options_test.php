<?php
/**
 * ezcCacheStorageOptionsTest 
 * 
 * @package Cache
 * @subpackage Tests
 * @version //autogen//
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

require_once 'Cache/tests/test.php';
require_once 'wrappers/memcache_wrapper.php';

/**
 * Abstract base test class for ezcCacheStorageOptions tests.
 * 
 * @package Cache
 * @subpackage Tests
 */
class ezcCacheStorageOptionsTest extends ezcCacheTest
{
	public static function suite()
	{
		return new PHPUnit_Framework_TestSuite( "ezcCacheStorageOptionsTest" );
	}

    /**
     * testConstructorNew
     * 
     * @access public
     */
    public function testConstructor()
    {
        $fake = new ezcCacheStorageOptions(
            array( 
                "ttl" => 86400,
                "extension" => ".cache",
            )
        );
        $this->assertEquals( 
            $fake,
            new ezcCacheStorageOptions(),
            'Default values incorrect for ezcCacheStorageOptions.'
        );
    }

    public function testNewAccess()
    {
        $opt = new ezcCacheStorageOptions();

        $this->assertEquals( $opt->ttl, 86400 );
        $this->assertEquals( $opt->extension, ".cache" );

        $this->assertEquals( $opt["ttl"], 86400 );
        $this->assertEquals( $opt["extension"], ".cache" );
    }

    public function testGetAccessSuccess()
    {
        $opt = new ezcCacheStorageOptions();

        $this->assertEquals( $opt->ttl, 86400 );
        $this->assertEquals( $opt->extension, ".cache" );
    }

    public function testGetAccessFailure()
    {
        $opt = new ezcCacheStorageOptions();
        
        try
        {
            echo $opt->permissions;
        }
        catch ( ezcBasePropertyNotFoundException $e )
        {
            return;
        }
        $this->fail( "ezcBasePropertyNotFoundException not thrown on access to invalid property permissions." );
    }

    public function testSetAccessSuccess()
    {
        $opt = new ezcCacheStorageOptions();

        $opt->ttl = false;
        $opt->ttl = 23;
        $opt->extension = ".foo";

        $this->assertEquals( $opt->ttl, 23 );
        $this->assertEquals( $opt->extension, ".foo" );
    }

    public function testSetAccessFailure()
    {
        $opt = new ezcCacheStorageOptions();
        
        $this->genericSetFailureTest( $opt, "ttl", "foo" );
        $this->genericSetFailureTest( $opt, "ttl", true );
        $this->genericSetFailureTest( $opt, "extension", 23 );
        $this->genericSetFailureTest( $opt, "extension", true );

        try
        {
            $opt->permissions = 0777;
        }
        catch ( ezcBasePropertyNotFoundException $e )
        {
            return;
        }
        $this->fail( "ezcBasePropertyNotFoundException not thrown on set access to invalid property permissions." );
    }

    public function testIssetAccess()
    {
        $opt = new ezcCacheStorageOptions();
        
        $this->assertTrue( isset( $opt->ttl ) );
        $this->assertTrue( isset( $opt->extension ) );
        $this->assertFalse( isset( $opt->permissions ) );
        $this->assertFalse( isset( $opt->foo ) );
    }

    public function testStorageProperties()
    {
        if ( !ezcBaseFeatures::hasExtensionSupport( 'memcache' ) )
        {
            $this->markTestSkipped( "PHP must have Memcache support." );
        }

        $storage = new ezcCacheStorageMemcacheWrapper( '.', array( 'host' => 'localhost', 'port' => 11211, 'ttl' => 10 ) );

        $this->invalidPropertyTest( $storage, 'options', 'wrong value', 'instance of ezcCacheStorageOptions' );
        $this->missingPropertyTest( $storage, 'no_such_property' );
        $this->issetPropertyTest( $storage, 'options', true );
        $this->issetPropertyTest( $storage, 'no_such_property', false );
    }

    public function testStorageOptions()
    {
        if ( !ezcBaseFeatures::hasExtensionSupport( 'memcache' ) )
        {
            $this->markTestSkipped( "PHP must have Memcache support." );
        }

        $options = new ezcCacheStorageOptions();
        $storage = new ezcCacheStorageMemcacheWrapper( '.', array( 'host' => 'localhost', 'port' => 11211, 'ttl' => 10 ) );

        $storage->setOptions( $options );
        $this->assertEquals( $options, $storage->getOptions() );

        $storage->options = $options;
        $this->assertEquals( $options, $storage->getOptions() );

        $options = new stdClass();
        try
        {
            $storage->setOptions( $options );
            $this->fail( "Expected exception was not thrown." );
        }
        catch ( ezcBaseValueException $e )
        {
            $this->assertEquals( "The value 'O:8:\"stdClass\":0:{}' that you were trying to assign to setting 'options' is invalid. Allowed values are: instance of ezcCacheStorageOptions.", $e->getMessage() );
        }
    }

    protected function genericSetFailureTest( $obj, $property, $value )
    {
        try
        {
            $obj->$property = $value;
        }
        catch ( ezcBaseValueException $e )
        {
            return;
        }
        $this->fail( "ezcBaseValueException not thrown on invalid value '$value' for " . get_class( $obj ) . "->$property." );
    }

}
?>
