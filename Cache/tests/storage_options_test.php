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
}
?>
