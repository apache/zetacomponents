<?php
/**
 * @copyright Copyright (C) 2005-2010 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package PersistentObject
 * @subpackage Tests
 */

require_once "data/keywordtest/table_class.php";
require_once "data/keywordtest/where_class.php";
require_once "data/keywordtest/sequence_class.php";

/**
 * These tests tests for the usage of keywords for table and column names.
 * Basically this means that we are testing that all table and column names
 * are properly escaped.
 *
 * @package PersistentObject
 * @subpackage Tests
 */
class ezcPersistentKeywordTest extends ezcTestCase
{
    private $session = null;
    private $hasTables = false;

    protected function setUp()
    {
        try
        {
            $db = ezcDbInstance::get();
        }
        catch ( Exception $e )
        {
            $this->markTestSkipped( 'There was no database configured' );
        }

        Table::setupTable();
//        Table::saveSchema();
        $this->session = new ezcPersistentSession( ezcDbInstance::get(),
                                                   new ezcPersistentCodeManager( dirname( __FILE__ ) . "/data/keywordtest" ) );
    }

    protected function tearDown()
    {
        Table::cleanup();
    }

    public static function suite()
    {
        return new PHPUnit_Framework_TestSuite( 'ezcPersistentKeywordTest' );
    }

    // Test saving a valid object
    public function testSave()
    {
        $object = new Table();
        $object->select = 42;
        $this->session->save( $object );

        $this->assertEquals( 1, $object->from );

        $object2 = $this->session->loadIfExists( 'Table', 1 );
        $this->assertNotEquals( NULL, $object2 );
        $this->assertEquals( 42, $object2->select );
    }

    public function testUpdate()
    {
        $object = new Table();
        $object->select = 42;
        $this->session->save( $object );

        $this->assertEquals( 1, $object->from );

        $object2 = $this->session->loadIfExists( 'Table', 1 );
        $this->assertNotEquals( NULL, $object2 );
        $this->assertEquals( 42, $object2->select );

        $object2->select = 99;
        $this->session->update( $object2 );

        $object3 = $this->session->loadIfExists( 'Table', 1 );
        $this->assertNotEquals( NULL, $object3 );
        $this->assertEquals( 99, $object3->select );
    }

    public function testSaveOrUpdateSave()
    {
        $object = new Table();
        $object->select = 42;
        $this->session->saveOrUpdate( $object );

        $this->assertEquals( 1, $object->from );

        $object2 = $this->session->loadIfExists( 'Table', 1 );
        $this->assertNotEquals( NULL, $object2 );
        $this->assertEquals( 42, $object2->select );
    }

    public function testSaveOrUpdateUpdate()
    {
        $object = new Table();
        $object->select = 42;
        $this->session->save( $object );

        $this->assertEquals( 1, $object->from );

        $object2 = $this->session->loadIfExists( 'Table', 1 );
        $this->assertNotEquals( NULL, $object2 );
        $this->assertEquals( 42, $object2->select );

        $object2->select = 99;
        $this->session->saveOrUpdate( $object2 );

        $object3 = $this->session->loadIfExists( 'Table', 1 );
        $this->assertNotEquals( NULL, $object3 );
        $this->assertEquals( 99, $object3->select );
    }

    public function testDelete()
    {
        $object = new Table();
        $object->select = 42;
        $this->session->save( $object );

        $this->assertEquals( 1, $object->from );

        $object2 = $this->session->loadIfExists( 'Table', 1 );
        $this->assertNotEquals( NULL, $object2 );
        $this->assertEquals( 42, $object2->select );

        $this->session->delete( $object2 );

        $this->assertNull( $this->session->loadIfExists( 'Table', 1 ) );
    }

    public function testSaveAlias()
    {
        $object = new Sequence();
        $object->trigger = 42;
        $this->session->save( $object );

        $this->assertEquals( 1, $object->column );

        $object2 = $this->session->loadIfExists( 'Sequence', 1 );
        $this->assertNotEquals( NULL, $object2 );
        $this->assertEquals( 42, $object2->trigger );
    }

    public function test1NGetRelatedObject()
    {
        $object = new Table();
        $object->select = 42;
        $this->session->save( $object );

        $rel = new Where();
        $rel->update = 1; // correct relation
        $this->session->save( $rel );

        $relation = $this->session->getRelatedObjects( $object, "Where" );
        $this->assertNotEquals( count( $relation ), 0 );
    }

    public function test1NGetRelatedObjects()
    {
        $object = new Table();
        $object->select = 42;
        $this->session->save( $object );

        $rel = new Where();
        $rel->update = 1; // correct relation
        $this->session->save( $rel );

        $relations = $this->session->getRelatedObjects( $object, "Where" );
        $this->assertEquals( 1, count( $relations ) );
    }

    public function test1NAddAndRemoveRelatedObject()
    {
        $object = new Table();
        $object->select = 42;
        $this->session->save( $object );

        $rel = new Where();
        $rel->update = 1; // correct relation
        $this->session->save( $rel );
        // First let's remove the old relation
        $this->session->removeRelatedObject( $object, $rel );

        // Let's create a new object to relate to
        $object2 = new Table();
        $object2->select = 99;
        $this->session->save( $object2 ); // id 2

        $this->session->addRelatedObject( $object2, $rel );
        $this->session->update( $rel );

        // test that it worked
        $relations = $this->session->getRelatedObjects( $object, "Where" );
        $this->assertEquals( 0, count( $relations ) );

        $relations = $this->session->getRelatedObjects( $object2, "Where" );
        $this->assertEquals( 1, count( $relations ) );
    }

    public function testNMAddRelatedObject()
    {
        $object = new Table();
        $object->select = 42;
        $this->session->save( $object );

        $rel = new Like();
        $this->session->save( $rel );

        $this->session->addRelatedObject( $object, $rel );
    }

    public function testNMgetRelatedObject()
    {
        $object = new Table();
        $object->select = 42;
        $this->session->save( $object );

        $rel = new Like();
        $this->session->save( $rel );

        $this->session->addRelatedObject( $object, $rel );
        $this->assertNotEquals( count( $this->session->getRelatedObject( $object, "Like" ) ), 0 );
    }

    public function testNMgetRelatedObjects()
    {
        $object = new Table();
        $object->select = 42;
        $this->session->save( $object );

        $rel = new Like();
        $this->session->save( $rel );

        $this->session->addRelatedObject( $object, $rel );
        $this->assertEquals( 1, count( $this->session->getRelatedObjects( $object, "Like" ) ) );
    }

    public function testNMRemoveRelatedObject()
    {
        $object = new Table();
        $object->select = 42;
        $this->session->save( $object );

        $rel = new Like();
        $this->session->save( $rel );


        $this->session->addRelatedObject( $object, $rel );
        $this->session->removeRelatedObject( $object, $rel );

        $this->assertEquals( 0, count( $this->session->getRelatedObjects( $object, "Like" ) ) );
    }
}

?>
