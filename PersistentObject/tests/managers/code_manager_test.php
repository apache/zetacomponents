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
    public function testFetchValid()
    {
        $manager = new ezcPersistentCodeManager( dirname( __FILE__ ) . "/data/" );
        $def = $manager->fetchDefinition( "SimpleDefinition" );
        $this->assertEquals( true, $def instanceof ezcPersistentObjectDefinition );
    }

    public function testFetchValidTwice()
    {
        $manager = new ezcPersistentCodeManager( dirname( __FILE__ ) . "/data/" );
        $def = $manager->fetchDefinition( "SimpleDefinition" );
        $this->assertEquals( true, $def instanceof ezcPersistentObjectDefinition );
        $def2 = $manager->fetchDefinition( "SimpleDefinition" );
        $this->assertEquals( true, $def2 instanceof ezcPersistentObjectDefinition );
    }

    public function testInvalidClass()
    {
        $manager = new ezcPersistentCodeManager( dirname( __FILE__ ) . "/data/" );
        try
        {
            $manager->fetchDefinition( "NoSuchClass" );
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

    public function testNoNamespace()
    {
        $manager = new ezcPersistentCodeManager( dirname( __FILE__ ) . '/../data/namespaces/' );
        
        $def = $manager->fetchDefinition( 'NoNamespace' );

        $this->assertEquals( 'NoNamespace', $def->class );
        $this->assertEquals( 'no_namespace', $def->table );
    }

    public function testRootNamespace()
    {
        $manager = new ezcPersistentCodeManager( dirname( __FILE__ ) . '/../data/namespaces/' );
        
        $def = $manager->fetchDefinition( '\\RootNamespace' );

        $this->assertEquals( '\\RootNamespace', $def->class );
        $this->assertEquals( 'root_namespace', $def->table );
    }

    public function testSingleNamespace()
    {
        $manager = new ezcPersistentCodeManager( dirname( __FILE__ ) . '/../data/namespaces/' );
        
        $def = $manager->fetchDefinition( '\\foo\\InFooNamespace' );

        $this->assertEquals( '\\foo\\InFooNamespace', $def->class );
        $this->assertEquals( 'in_foo_namespace', $def->table );
    }

    public function testMultipleNamespace()
    {
        $manager = new ezcPersistentCodeManager( dirname( __FILE__ ) . '/../data/namespaces/' );
        
        $def = $manager->fetchDefinition( '\\foo\\Bar\\InBarNamespace' );

        $this->assertEquals( '\\foo\\Bar\\InBarNamespace', $def->class );
        $this->assertEquals( 'in_bar_namespace', $def->table );
    }

    public static function suite()
    {
        return new PHPUnit_Framework_TestSuite( 'ezcPersistentCodeManagerTest' );
    }
}

?>
