<?php
/**
 * ezcCacheStorageFileArrayTest 
 * 
 * @package Cache
 * @subpackage Tests
 * @version //autogen//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Require parent test class. 
 */
require_once 'storage_test.php';

/**
 * Test suite for ezcStorageFileArray class. 
 * 
 * @package Cache
 * @subpackage Tests
 */
class ezcCacheStorageFileArrayTest extends ezcCacheStorageTest
{
	public static function suite()
	{
		return new ezcTestSuite( "ezcCacheStorageFileArrayTest" );
	}
}
?>
