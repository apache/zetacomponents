<?php
/**
 * ezcCacheStorageFilePlainTest
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
 * Test suite for ezcStorageFilePlain class. 
 * 
 * @package Cache
 * @subpackage Tests
 */
class ezcCacheStorageFilePlainTest extends ezcCacheStorageTest
{
    /**
     * data 
     * 
     * @var array
     * @access protected
     */
    protected $data = array(
        1 => "Test 1 2 3 4 5 6 7 8\\\\",
        2 => 'La la la 02064 lololo',
        3 => 12345,
        4 => 12.3746,
    );

	public static function suite()
	{
		return new PHPUnit_Framework_TestSuite( "ezcCacheStorageFilePlainTest" );
	}
}
?>
