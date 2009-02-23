<?php
/**
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
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
class ezcPersistentMultiManagerTest extends ezcTestCase
{
    private $manager = null;

    protected function setUp()
    {
        $managers = array();
        $managers[] = new ezcPersistentCodeManager( dirname( __FILE__ ) . "/data/" );
        $managers[] = new ezcPersistentCodeManager( dirname( __FILE__ ) . "/data2/" );
        $this->manager = new ezcPersistentMultiManager( $managers );
    }

    public function testFetchValid()
    {
        $def = $this->manager->fetchDefinition( "SimpleDefinition" );
        $this->assertEquals( true, $def instanceof ezcPersistentObjectDefinition );
        $this->assertEquals( null, $def->class );

        $def = $this->manager->fetchDefinition( "MyClass" );
        $this->assertEquals( true, $def instanceof ezcPersistentObjectDefinition );
        $this->assertEquals( "MyClass", $def->class );
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

    public function testAddManager()
    {
        $this->manager = new ezcPersistentMultiManager();
        $this->manager->addManager( new ezcPersistentCodeManager( dirname( __FILE__ ) . "/data/" ) );
        $this->manager->addManager( new ezcPersistentCodeManager( dirname( __FILE__ ) . "/data2/" ) );

        // test fetching
        $def = $this->manager->fetchDefinition( "SimpleDefinition" );
        $this->assertEquals( true, $def instanceof ezcPersistentObjectDefinition );
        $this->assertEquals( null, $def->class );

        $def = $this->manager->fetchDefinition( "MyClass" );
        $this->assertEquals( true, $def instanceof ezcPersistentObjectDefinition );
        $this->assertEquals( "MyClass", $def->class );
    }

    public static function suite()
    {
        return new PHPUnit_Framework_TestSuite( 'ezcPersistentMultiManagerTest' );
    }
}

?>
