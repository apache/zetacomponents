<?php
/**
 * ezcCacheStorageFileArrayTest 
 * 
 * @package Cache
 * @subpackage Tests
 * @version //autogen//
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Require parent test class. 
 */
require_once 'storage_test.php';
require_once 'classes/exportable.php';

/**
 * Test suite for ezcStorageFileArray class. 
 * 
 * @package Cache
 * @subpackage Tests
 */
class ezcCacheStorageFileObjectTest extends ezcCacheStorageTest
{
	public static function suite()
	{
		return new PHPUnit_Framework_TestSuite( __CLASS__ );
	}

    public function testStoreObjectSuccess()
    {
        $originalObj = new ezcCacheTestExportable( 'foo', 23, 42.23 );
        $this->storage->store( 23, $originalObj );
        $restoredObj = $this->storage->restore( 23 );

        $this->assertEquals( $originalObj, $restoredObj );
    }

    public function testStoreObjectFailure()
    {
        $originalObj = new stdClass();
        try
        {
            $this->storage->store( 23, $originalObj );
            $this->fail( "ezcCacheInvalidDataException not thrown on attempt to store stdClass." );
        }
        catch ( ezcCacheInvalidDataException $e ) {}
    }
}
?>
