<?php
/**
 * @copyright Copyright (C) 2005-2010 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package PersistentObject
 * @subpackage Tests
 */

/**
 * Tests the code manager.
 *
 * @package PersistentObject
 * @subpackage Tests
 */
class ezcPersistentCodeManagerTest extends ezcTestCase
{
    private $manager = null;

    protected function setUp()
    {
        $this->manager = new ezcPersistentCodeManager( dirname( __FILE__ ) . "/data/" );
    }

    public function testFetchValid()
    {
        $def = $this->manager->fetchDefinition( "SimpleDefinition" );
        $this->assertEquals( true, $def instanceof ezcPersistentObjectDefinition );
    }

    public function testFetchValidTwice()
    {
        $def = $this->manager->fetchDefinition( "SimpleDefinition" );
        $this->assertEquals( true, $def instanceof ezcPersistentObjectDefinition );
        $def2 = $this->manager->fetchDefinition( "SimpleDefinition" );
        $this->assertEquals( true, $def2 instanceof ezcPersistentObjectDefinition );
    }

    public function testInvalidClass()
    {
        try
        {
            $this->manager->fetchDefinition( "NoSuchClass" );
        }
        catch ( Exception $e )
        {
            return;
        }
        $this->fail( "Fetching a non-existent definition did not throw an exception." );
    }

    public function testInvalidDirectory()
    {
        $manager = new ezcPersistentCodeManager( dirname( __FILE__ ) . "/nosuchthing/" );
        try
        {
            $manager->fetchDefinition( "SimpleDefinition" );
        }
        catch ( Exception $e )
        {
            return;
        }
        $this->fail( "Fetching a definition from a non existent path did not fail.." );
    }

    public static function suite()
    {
        return new PHPUnit_Framework_TestSuite( 'ezcPersistentCodeManagerTest' );
    }
}

?>
