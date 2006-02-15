<?php
/**
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package PersistentObject
 * @subpackage Tests
 */

require_once "data/persistent_test_object.php";

/**
 * Tests the find iterator.
 *
 * @package PersistentObject
 * @subpackage Tests
 */
class ezcPersistentFindIteratorTest extends ezcTestCase
{
    private $db;
    private $manager;
    private $session;

    public function setUp()
    {
        PersistentTestObject::setupTable();
        PersistentTestObject::insertCleanData();
        $this->manager = new ezcPersistentCodeManager( dirname( __FILE__ ) . "/data/" );
        $this->db = ezcDbInstance::get();
        $this->session = new ezcPersistentSession( $this->db, $this->manager );
    }

    public function tearDown()
    {
        PersistentTestObject::cleanup();
    }

    public static function suite()
    {
        return new ezcTestSuite( 'ezcPersistentFindIteratorTest' );
    }

    public function testFaultyStmtReturnsNull()
    {
        $it = new ezcPersistentFindIterator( $this->db->prepare( "select * from PO_test" ),
                                             $this->manager->fetchDefinition( 'PersistentTestObject' ) );
        $this->assertEquals( null, $it->current() );
        $this->assertEquals( null, $it->next() );
        $this->assertEquals( false, $it->valid() );
    }

    public function testFaultyDefinitionReturnsNull()
    {
        $it = new ezcPersistentFindIterator( $this->db->prepare( "select * from PO_test" ),
                                             new ezcPersistentObjectDefinition );
        $this->assertEquals( null, $it->current() );
        $this->assertEquals( null, $it->next() );
        $this->assertEquals( false, $it->valid() );
    }

    public function testValidIsInvalidBeforeRewind()
    {
        $q = $this->session->createFindQuery( 'PersistentTestObject' );
        $q->where( $q->expr->gt( 'id', 2 ) );
        $stmt = $q->prepare();
        $stmt->execute();
        $it = new ezcPersistentFindIterator( $stmt, $this->manager->fetchDefinition( 'PersistentTestObject' ) );

        $this->assertEquals( false, $it->valid() );
    }

    public function testValidIsValidWhenNextWithoutRewind()
    {
        $q = $this->session->createFindQuery( 'PersistentTestObject' );
        $q->where( $q->expr->gt( 'id', 2 ) );
        $stmt = $q->prepare();
        $stmt->execute();
        $it = new ezcPersistentFindIterator( $stmt, $this->manager->fetchDefinition( 'PersistentTestObject' ) );

        $it->next();
        $this->assertEquals( true, $it->valid() );
    }

    public function testValidIsValidWhenRewindIsCalled()
    {
        $q = $this->session->createFindQuery( 'PersistentTestObject' );
        $q->where( $q->expr->gt( 'id', 2 ) );
        $stmt = $q->prepare();
        $stmt->execute();
        $it = new ezcPersistentFindIterator( $stmt, $this->manager->fetchDefinition( 'PersistentTestObject' ) );

        $it->rewind();
        $this->assertEquals( true, $it->valid() );
    }

    public function testValidNoResults()
    {
        $q = $this->session->createFindQuery( 'PersistentTestObject' );
        $q->where( $q->expr->gt( 'id', 42 ) );
        $stmt = $q->prepare();
        $stmt->execute();
        $it = new ezcPersistentFindIterator( $stmt, $this->manager->fetchDefinition( 'PersistentTestObject' ) );

        $it->rewind();
        $this->assertEquals( null, $it->next() );
        $this->assertEquals( false, $it->valid() );
        // we check two times to make sure that there is no state problems triggering the first time
        $this->assertEquals( null, $it->next() );
        $this->assertEquals( false, $it->valid() );
    }

    public function testValidOneResult()
    {
        $q = $this->session->createFindQuery( 'PersistentTestObject' );
        $q->where( $q->expr->eq( 'id', 3 ) );
        $stmt = $q->prepare();
        $stmt->execute();
        $it = new ezcPersistentFindIterator( $stmt, $this->manager->fetchDefinition( 'PersistentTestObject' ) );

        $object = $it->next();
        // check that the data is correct
        $this->assertEquals( 'Ukraine', $object->varchar );
        $this->assertEquals( 47732079, (int)$object->integer );
        $this->assertEquals( 603.70, (float)$object->decimal );
        $this->assertEquals( 'Ukraine has a long coastline to the black see.', $object->text );

        // check that there are no more results
        $this->assertEquals( null, $it->next() );
    }

    public function testValidManyResults()
    {
        $q = $this->session->createFindQuery( 'PersistentTestObject' );
        $q->where( $q->expr->gt( 'id', 2 ) );
        $stmt = $q->prepare();
        $stmt->execute();
        $it = new ezcPersistentFindIterator( $stmt, $this->manager->fetchDefinition( 'PersistentTestObject' ) );

        $object = $it->next();
        // check that the data is correct
        $this->assertEquals( 'Ukraine', $object->varchar );
        $this->assertEquals( 47732079, (int)$object->integer );
        $this->assertEquals( 603.70, (float)$object->decimal );
        $this->assertEquals( 'Ukraine has a long coastline to the black see.', $object->text );

        $object = $it->next();
        $this->assertEquals( 'Germany', $object->varchar );
        $this->assertEquals( 82443000, (int)$object->integer );
        $this->assertEquals( 357.02, (float)$object->decimal );
        $this->assertEquals( 'Home of the lederhosen!.', $object->text );

        // check that there are no more results
        $this->assertEquals( null, $it->next() );
    }

    public function testThatOnlyOneObjectIsUsed()
    {
        $q = $this->session->createFindQuery( 'PersistentTestObject' );
        $q->where( $q->expr->gt( 'id', 2 ) );
        $stmt = $q->prepare();
        $stmt->execute();
        $it = new ezcPersistentFindIterator( $stmt, $this->manager->fetchDefinition( 'PersistentTestObject' ) );

        $object1 = $it->next();
        $object2 = $it->next();
        $this->assertEquals( $object1, $object2 );
    }

    public function testBreakOutOfIterator()
    {
        $q = $this->session->createFindQuery( 'PersistentTestObject' );
        $it = $this->session->findIterator( $q, 'PersistentTestObject' );
        $i = 0;
        foreach ( $it as $object )
        {
            break;
        }
        $it = $this->session->find( $q, 'PersistentTestObject' );
    }
}
?>
