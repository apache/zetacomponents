<?php
/**
 * ezcCacheStorageOptionsTest 
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
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 */

require_once 'wrappers/memcache_wrapper.php';

/**
 * Abstract base test class for ezcCacheStorageOptions tests.
 * 
 * @package Cache
 * @subpackage Tests
 */
class ezcCacheStorageOptionsTest extends ezcTestCase
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
