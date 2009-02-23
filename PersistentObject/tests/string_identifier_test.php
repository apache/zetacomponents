<?php
/**
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package PersistentObject
 * @subpackage Tests
 */

require_once "data/string_identifier/main_table_class.php";
require_once "data/string_identifier/rel_class.php";

/**
 * These tests check if persistent object works properly with string identifiers.
 *
 * @package PersistentObject
 * @subpackage Tests
 */
class ezcPersistentStringIdentifierTest extends ezcTestCase
{
    private $session = null;

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

        MainTable::setupTable();
//        MainTable::saveSchema();
        $this->session = new ezcPersistentSession( ezcDbInstance::get(),
                                                   new ezcPersistentCodeManager( dirname( __FILE__ ) . "/data/string_identifier" ) );
    }

    protected function tearDown()
    {
        MainTable::cleanup();
    }

    public static function suite()
    {
        return new PHPUnit_Framework_TestSuite( 'ezcPersistentStringIdentifierTest' );
    }

    // Test saving a valid object
    public function testSave()
    {
        $object = new MainTable();
        $object->id = "id";
        $object->data = "42";
        $this->session->save( $object );

        $this->assertEquals( "id", $object->id );

        $object2 = $this->session->loadIfExists( 'MainTable', "id" );
        $this->assertNotEquals( NULL, $object2 );
        $this->assertEquals( "42", $object2->data );
    }

    public function testUpdate()
    {
        $object = new MainTable();
        $object->id = "id";
        $object->data = "42";
        $this->session->save( $object );

        $this->assertEquals( "id", $object->id );

        $object2 = $this->session->loadIfExists( 'MainTable', "id" );
        $this->assertNotEquals( NULL, $object2 );
        $this->assertEquals( "42", $object2->data );

        $object2->data = "99";
        $this->session->update( $object2 );

        $object3 = $this->session->loadIfExists( 'MainTable', "id" );
        $this->assertNotEquals( NULL, $object3 );
        $this->assertEquals( "99", $object3->data );
    }

    public function testSaveOrUpdateSave()
    {
        $object = new MainTable();
        $object->id = "id";
        $object->data = "42";
        $this->session->saveOrUpdate( $object );
        $this->assertEquals( "id", $object->id );

        $object2 = $this->session->loadIfExists( 'MainTable', "id" );
        $this->assertNotEquals( NULL, $object2 );
        $this->assertEquals( "42", $object2->data );
    }

    public function testSaveOrUpdateUpdate()
    {
        $object = new MainTable();
        $object->id = "id";
        $object->data = "42";
        $this->session->save( $object );

        $this->assertEquals( "id", $object->id );

        $object2 = $this->session->loadIfExists( 'MainTable', "id" );
        $this->assertNotEquals( NULL, $object2 );
        $this->assertEquals( "42", $object2->data );
        $object2->data = "99";
        $this->session->saveOrUpdate( $object2 );

        $object3 = $this->session->loadIfExists( 'MainTable', "id" );
        $this->assertNotEquals( NULL, $object3 );
        $this->assertEquals( "99", $object3->data );
    }

    public function testDelete()
    {
        $object = new MainTable();
        $object->id = "id";
        $object->data = "42";
        $this->session->save( $object );

        $this->assertEquals( "id", $object->id );

        $object2 = $this->session->loadIfExists( 'MainTable', "id" );
        $this->assertNotEquals( NULL, $object2 );
        $this->assertEquals( "42", $object2->data );

        $this->session->delete( $object2 );

        $this->assertNull( $this->session->loadIfExists( 'MainTable', "id" ) );
    }

    public function testSaveAlias()
    {
/*        $object = new Sequence();
        $object->trigger = "42";
        $this->session->save( $object );

        $this->assertEquals( 1, $object->column );

        $object2 = $this->session->loadIfExists( 'Sequence', 1 );
        $this->assertNotEquals( NULL, $object2 );
        $this->assertEquals( "42", $object2->trigger );*/
    }

    public function test1NGetRelatedObject()
    {
        $object = new MainTable();
        $object->id = "id";
        $object->data = "42";
        $this->session->save( $object );

        $rel = new Rel1();
        $rel->id = "rel_id";
        $rel->fk = "id"; // correct relation
        $this->session->save( $rel );

        $relation = $this->session->getRelatedObjects( $object, "Rel1" );
        $this->assertNotEquals( count( $relation ), 0 );
    }

    public function test1NGetRelatedObjects()
    {
        $object = new MainTable();
        $object->id = "id";
        $object->data = "42";
        $this->session->save( $object );

        $rel = new Rel1();
        $rel->id = "rel_id";
        $rel->fk = "id"; // correct relation
        $this->session->save( $rel );

        $relations = $this->session->getRelatedObjects( $object, "Rel1" );
        $this->assertEquals( 1, count( $relations ) );
    }

    public function test1NAddAndRemoveRelatedObject()
    {
        $object = new MainTable();
        $object->id = "id";
        $object->data = "42";
        $this->session->save( $object );

        $rel = new Rel1();
        $rel->id = "rel_id";
        $rel->fk = "id"; // correct relation
        $this->session->save( $rel );
        // First let's remove the old relation
        $this->session->removeRelatedObject( $object, $rel );

        // Let's create a new object to relate to
        $object2 = new MainTable();
        $object2->id = "id2";
        $object2->data = "99";
        $this->session->save( $object2 ); // id 2

        $this->session->addRelatedObject( $object2, $rel );
        $this->session->update( $rel );

        // test that it worked
        $relations = $this->session->getRelatedObjects( $object, "Rel1" );
        $this->assertEquals( 0, count( $relations ) );

        $relations = $this->session->getRelatedObjects( $object2, "Rel1" );
        $this->assertEquals( 1, count( $relations ) );
    }

    public function testNMAddRelatedObject()
    {
        $object = new MainTable();
        $object->id = "id";
        $object->data = "42";
        $this->session->save( $object );

        $rel = new Rel2();
        $rel->id = "rel_id";
        $this->session->save( $rel );

        $this->session->addRelatedObject( $object, $rel );
    }

    public function testNMgetRelatedObject()
    {
        $object = new MainTable();
        $object->id = "id";
        $object->data = "42";
        $this->session->save( $object );

        $rel = new Rel2();
        $rel->id = "rel_id";
        $this->session->save( $rel );

        $this->session->addRelatedObject( $object, $rel );
        $this->assertNotEquals( count( $this->session->getRelatedObject( $object, "Rel2" ) ), 0 );
    }

    public function testNMgetRelatedObjects()
    {
        $object = new MainTable();
        $object->id = "id";
        $object->data = "42";
        $this->session->save( $object );

        $rel = new Rel2();
        $rel->id = "rel_id";
        $this->session->save( $rel );

        $this->session->addRelatedObject( $object, $rel );
        $this->assertEquals( 1, count( $this->session->getRelatedObjects( $object, "Rel2" ) ) );
    }

    public function testNMRemoveRelatedObject()
    {
        $object = new MainTable();
        $object->id = "id";
        $object->data = "42";
        $this->session->save( $object );

        $rel = new Rel2();
        $rel->id = "rel_id";
        $this->session->save( $rel );


        $this->session->addRelatedObject( $object, $rel );
        $this->session->removeRelatedObject( $object, $rel );

        $this->assertEquals( 0, count( $this->session->getRelatedObjects( $object, "Rel2" ) ) );
    }
}

?>
