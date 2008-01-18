<?php
/**
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package PersistentObject
 * @subpackage Tests
 */

require_once dirname( __FILE__ ) . "/data/multi_relation_test_person.php";

/**
 * Tests ezcPersistentManyToManyRelation class.
 *
 * @package PersistentObject
 * @subpackage Tests
 */
class ezcPersistentMultiRelationTest extends ezcTestCase
{

    private $session;

    public static function suite()
    {
        return new PHPUnit_Framework_TestSuite( __CLASS__ );
    }

    public function setup()
    {
        try
        {
            $this->db = ezcDbInstance::get();
        }
        catch ( Exception $e )
        {
            $this->markTestSkipped( 'There was no database configured' );
        }
        MultiRelationTestPerson::setupTables();
        MultiRelationTestPerson::insertData();
        $this->session = new ezcPersistentSession(
            ezcDbInstance::get(),
            new ezcPersistentCodeManager( dirname( __FILE__ ) . "/data/" )
        );
    }

    public function teardown()
    {
        // MultiRelationTestPerson::cleanup();
    }

    public function testLoad()
    {
        $rootMother = $this->session->load( 'MultiRelationTestPerson', 1 );
        $this->assertEquals(
            'Root mother without parents.',
            $rootMother->name,
            'MultiRelationTestPerson with ID 1 not loaded correctly.'
        );
        
        $rootFather = $this->session->load( 'MultiRelationTestPerson', 2 );
        $this->assertEquals(
            'Root father without parents.',
            $rootFather->name,
            'MultiRelationTestPerson with ID 2 not loaded correctly.'
        );
    }

    public function testFind()
    {
        $q = $this->session->createFindQuery( 'MultiRelationTestPerson' );
        $q->where(
            $q->expr->gt( 
                $this->session->database->quoteIdentifier( 'id' ),
                $q->bindValue( 2 )
            ),
            $q->expr->lt( 
                $this->session->database->quoteIdentifier( 'id' ),
                $q->bindValue( 5 )
            )
        );
        $persons = $this->session->find( $q, 'MultiRelationTestPerson' );

        $this->assertEquals(
            2,
            count( $persons ),
            'MultiRelationTestPerson object not found correctly.'
        );

        $this->assertEquals(
            3,
            $persons[0]->id,
            'First MultiRelationTestPerson object not found correctly.'
        );

        $this->assertEquals(
            4,
            $persons[1]->id,
            'First MultiRelationTestPerson object not found correctly.'
        );
    }

    public function testGetRelatedObjectsFailureWithoutRelationName()
    {
        $mother = $this->session->load( 'MultiRelationTestPerson', 1 );
        try
        {
            $this->session->getRelatedObjects( $mother, 'MultiRelationTestPerson' );
            $this->fail( 'Exception not thrown on getRelatedObjects() without relation name.' );
        }
        catch ( ezcPersistentUndeterministicRelationException $e ) {}
    }

    public function testGetRelatedObjectFailureWithoutRelationName()
    {
        $mother = $this->session->load( 'MultiRelationTestPerson', 1 );
        try
        {
            $this->session->getRelatedObject( $mother, 'MultiRelationTestPerson' );
            $this->fail( 'Exception not thrown on getRelatedObjects() without relation name.' );
        }
        catch ( ezcPersistentUndeterministicRelationException $e ) {}
    }

    public function testGetRelatedObjectsSuccessMotherChild()
    {
        $mother   = $this->session->load( 'MultiRelationTestPerson', 1 );
        $children = $this->session->getRelatedObjects( $mother, 'MultiRelationTestPerson', 'mothers_children' );

        $this->assertEquals(
            3,
            count( $children ),
            'Number of found children incorrect.'
        );

        $this->assertEquals(
            3,
            $children[0]->id,
            'First child fetched incorrect.'
        );

        $this->assertEquals(
            4,
            $children[1]->id,
            'First child fetched incorrect.'
        );

        $this->assertEquals(
            5,
            $children[2]->id,
            'First child fetched incorrect.'
        );
    }

    public function testGetRelatedObjectSuccessFatherChild()
    {
        $father   = $this->session->load( 'MultiRelationTestPerson', 2 );
        $children = $this->session->getRelatedObjects( $father, 'MultiRelationTestPerson', 'fathers_children' );

        $this->assertEquals(
            3,
            count( $children ),
            'Number of found children incorrect.'
        );

        $this->assertEquals(
            3,
            $children[0]->id,
            'First child fetched incorrect.'
        );

        $this->assertEquals(
            4,
            $children[1]->id,
            'First child fetched incorrect.'
        );

        $this->assertEquals(
            5,
            $children[2]->id,
            'First child fetched incorrect.'
        );
    }
    
    public function testGetRelatedObjectSuccessChildMother()
    {
        $child   = $this->session->load( 'MultiRelationTestPerson', 3 );
        $mother = $this->session->getRelatedObject( $child, 'MultiRelationTestPerson', 'mother' );
        
        $this->assertEquals(
            1,
            $mother->id,
            'Mother fetched incorrectly for child 3'
        );
    }
    
    public function testGetRelatedObjectSuccessChildFather()
    {
        $child  = $this->session->load( 'MultiRelationTestPerson', 4 );
        $father = $this->session->getRelatedObject( $child, 'MultiRelationTestPerson', 'father' );
        
        $this->assertEquals(
            2,
            $father->id,
            'Father fetched incorrectly for MultiRelationTestPerson 4'
        );
    }

    public function testGetRelatedObjectsSuccessSiblings()
    {
        $child    = $this->session->load( 'MultiRelationTestPerson', 3 );
        $siblings = $this->session->getRelatedObjects( $child, 'MultiRelationTestPerson', 'siblings' );

        $this->assertEquals(
            2,
            count( $siblings ),
            'Siblings not correctly found for MultiRelationTestPerson 3'
        );
    }

    public function testSave()
    {
        $newChild = new MultiRelationTestPerson();
        $newChild->name = "New child";

        $this->session->save( $newChild );

        $this->assertEquals(
            6,
            $newChild->id,
            'New MultiRelationTestPerson saved with incorrect ID.'
        );
    }

    public function testAddRelatedObjectOneToManySuccess()
    {
        $newChild = new MultiRelationTestPerson();
        $newChild->name = "New child";

        $this->session->save( $newChild );

        $mother = $this->session->load( 'MultiRelationTestPerson', 1 );

        $this->session->addRelatedObject( $mother, $newChild, 'mothers_children' );
        
        $this->assertEquals(
            $mother->id,
            $newChild->mother,
            'New MultiRelationTestPerson child not added correctly'
        );
    }

    public function testAddRelatedObjectManyToManySuccess()
    {
        $newSibling = new MultiRelationTestPerson();
        $newSibling->name = "New child";

        $this->session->save( $newSibling );

        $sibling = $this->session->load( 'MultiRelationTestPerson', 3 );

        $this->session->addRelatedObject( $sibling, $newSibling, 'siblings' );

        $q = $this->session->database->createSelectQuery();
        $q->select( '*' )
          ->from( 'PO_sibling' )
          ->where(
            $q->expr->eq(
                $this->session->database->quoteIdentifier( 'sibling' ),
                $q->bindValue( $newSibling->id )
            )
          );

        $stmt = $q->prepare();
        $stmt->execute();
        $rows = $stmt->fetchAll( PDO::FETCH_ASSOC );

        $this->assertEquals(
            1,
            count( $rows ),
            'Incorrect number of relation records.'
        );

        $this->assertEquals(
            $sibling->id,
            $rows[0]['person'],
            'Incorrect perso ID in relation record.'
        );
    }
}

?>
