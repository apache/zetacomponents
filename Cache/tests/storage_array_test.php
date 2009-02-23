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
		return new PHPUnit_Framework_TestSuite( "ezcCacheStorageFileArrayTest" );
	}
}
?>
