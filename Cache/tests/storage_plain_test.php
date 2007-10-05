<?php
/**
 * ezcCacheStorageFilePlainTest
 * 
 * @package Cache
 * @subpackage Tests
 * @version //autogen//
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
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

    public function testGetRemainingLifetimeId()
    {
        $this->storage->setOptions( array( 'ttl' => 10 ) );

        $this->storage->store( '1', 'data1' );

        $this->assertEquals( true, 8 < $this->storage->getRemainingLifetime( '1' ) );

    }

    public function testGetRemainingLifetimeAttributes()
    {
        $this->storage->setOptions( array( 'ttl' => 10 ) );

        $this->storage->store( '1', 'data1', array( 'type' => 'simple' ) );
        $this->storage->store( '2', 'data2', array( 'type' => 'simple' ) );

        $this->assertEquals( true, 8 < $this->storage->getRemainingLifetime( null, array( 'type' => 'simple' ) ) );

    }

    public function testGetRemainingLifetimeNoMatch()
    {
        $this->storage->setOptions( array( 'ttl' => 10 ) );

        $this->assertEquals( 0, $this->storage->getRemainingLifetime( 'no_such_id' ) );

    }

    public static function suite()
	{
		return new PHPUnit_Framework_TestSuite( "ezcCacheStorageFilePlainTest" );
	}
}
?>
