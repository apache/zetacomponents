<?php
/**
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package PersistentObject
 * @subpackage Tests
 */

require_once dirname( __FILE__ ) . "/../data/multi_relation_test_person.php";

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
            new ezcPersistentCodeManager( dirname( __FILE__ ) . "/../data/" )
        );
    }

    public function teardown()
    {
        MultiRelationTestPerson::cleanup();
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
        $this->assertTrue( isset( $persons[3] ) && isset( $persons[4] ) );

        $this->assertEquals(
            3,
            $persons[3]->id,
            'First MultiRelationTestPerson object not found correctly.'
        );

        $this->assertEquals(
            4,
            $persons[4]->id,
            'First MultiRelationTestPerson object not found correctly.'
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
        $this->assertTrue( isset( $children[3] ) && isset( $children[4] ) && isset( $children[5] ) );

        $this->assertEquals(
            3,
            $children[3]->id,
            'First child fetched incorrect.'
        );

        $this->assertEquals(
            4,
            $children[4]->id,
            'First child fetched incorrect.'
        );

        $this->assertEquals(
            5,
            $children[5]->id,
            'First child fetched incorrect.'
        );
    }

    public function testFindRelatedObjectsSuccessMotherChild()
    {
        $mother   = $this->session->load( 'MultiRelationTestPerson', 1 );
        $q = $this->session->createRelationFindQuery( $mother, 'MultiRelationTestPerson', 'mothers_children' );
        $children = $this->session->find( $q );

        $this->assertEquals(
            3,
            count( $children ),
            'Number of found children incorrect.'
        );
        $this->assertTrue( isset( $children[3] ) && isset( $children[4] ) && isset( $children[5] ) );

        $this->assertEquals(
            3,
            $children[3]->id,
            'First child fetched incorrect.'
        );

        $this->assertEquals(
            4,
            $children[4]->id,
            'First child fetched incorrect.'
        );

        $this->assertEquals(
            5,
            $children[5]->id,
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
        $this->assertTrue( isset( $children[3] ) && isset( $children[4] ) && isset( $children[5] ) );

        $this->assertEquals(
            3,
            $children[3]->id,
            'First child fetched incorrect.'
        );

        $this->assertEquals(
            4,
            $children[4]->id,
            'First child fetched incorrect.'
        );

        $this->assertEquals(
            5,
            $children[5]->id,
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

    public function testAddObjectsFailureWithoutRelationName()
    {
        $newChild = new MultiRelationTestPerson();
        $newChild->name = "New child";

        $this->session->save( $newChild );

        $mother = $this->session->load( 'MultiRelationTestPerson', 1 );

        try
        {
            $this->session->addRelatedObject( $mother, $newChild );
            $this->fail( 'Exception not thrown on addRelatedObject() without relation name.' );
        }
        catch ( ezcPersistentUndeterministicRelationException $e ) {}
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
          ->from( $this->session->database->quoteIdentifier( 'PO_sibling' ) )
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
    
    public function testRemoveObjectsFailureWithoutRelationName()
    {
        $mother   = $this->session->load( 'MultiRelationTestPerson', 1 );
        $children = $this->session->getRelatedObjects( $mother, 'MultiRelationTestPerson', 'mothers_children' );

        try
        {
            $this->session->removeRelatedObject( $mother, $children[3] );
            $this->fail( 'Exception not thrown on removeRelatedObject() without relation name.' );
        }
        catch ( ezcPersistentUndeterministicRelationException $e ) {}
    }

    public function testRemoveRelatedObjectSuccessMotherChildren()
    {
        $mother   = $this->session->load( 'MultiRelationTestPerson', 1 );
        $children = $this->session->getRelatedObjects( $mother, 'MultiRelationTestPerson', 'mothers_children' );

        foreach( $children as $child )
        {
            $this->session->removeRelatedObject( $mother, $child, 'mothers_children' );

            $this->assertNull(
                $child->mother,
                "MultiRelationTestPerson child {$child->id} not correctly removed from mother."
            );
            $this->assertNotNull(
                $child->father,
                "MultiRelationTestPerson child {$child->id} also removed from father instead from mother only."
            );
        }
    }

    public function testRemoveRelatedObjectSuccessFatherChildren()
    {
        $father   = $this->session->load( 'MultiRelationTestPerson', 2 );
        $children = $this->session->getRelatedObjects( $father, 'MultiRelationTestPerson', 'fathers_children' );

        foreach( $children as $child )
        {
            $this->session->removeRelatedObject( $father, $child, 'fathers_children' );

            $this->assertNull(
                $child->father,
                "MultiRelationTestPerson child {$child->id} not correctly removed from father."
            );
            $this->assertNotNull(
                $child->mother,
                "MultiRelationTestPerson child {$child->id} also removed from mother instead from father only."
            );
        }
    }
    
    public function testRemoveRelatedObjectFailureChildMother()
    {
        $child   = $this->session->load( 'MultiRelationTestPerson', 3 );
        $mother = $this->session->getRelatedObject( $child, 'MultiRelationTestPerson', 'mother' );
        
        try
        {
            $this->session->removeRelatedObject( $child, $mother, 'mother' );
            $this->fail( "MultiRelationTestPerson correctly removed from mother although relation is marked reverse." );
        }
        catch ( ezcPersistentRelationOperationNotSupportedException $e ) {}
    }
    
    public function testRemoveRelatedObjectFailureChildFather()
    {
        $child  = $this->session->load( 'MultiRelationTestPerson', 4 );
        $father = $this->session->getRelatedObject( $child, 'MultiRelationTestPerson', 'father' );
        
        try
        {
            $this->session->removeRelatedObject( $child, $father, 'father' );
            $this->fail( "MultiRelationTestPerson correctly removed from father although relation is marked reverse." );
        }
        catch ( ezcPersistentRelationOperationNotSupportedException $e ) {}
    }

    public function testRemoveRelatedObjectSuccessSiblings()
    {
        $child    = $this->session->load( 'MultiRelationTestPerson', 3 );
        $siblings = $this->session->getRelatedObjects( $child, 'MultiRelationTestPerson', 'siblings' );

        foreach ( $siblings as $sibling )
        {
            $this->session->removeRelatedObject( $child, $sibling, 'siblings' );
        }

        $q = $this->session->database->createSelectQuery();
        $q->select( '*' )
          ->from( $this->session->database->quoteIdentifier( 'PO_sibling' ) )
          ->where(
            $q->expr->eq(
                $this->session->database->quoteIdentifier( 'person' ),
                $q->bindValue( $child->id )
            )
          );

        $stmt = $q->prepare();
        $stmt->execute();
        $rows = $stmt->fetchAll( PDO::FETCH_ASSOC );

        $this->assertEquals(
            0,
            count( $rows ),
            'Incorrect number of relation records after removing all siblings.'
        );
    }

    public function testDeleteCascade()
    {
        $mother   = $this->session->load( 'MultiRelationTestPerson', 1 );

        $this->session->delete( $mother );

        $q = $this->session->createFindQuery( 'MultiRelationTestPerson' );
        $q->where(
            $q->expr->eq(
                'mother',
                $q->bindValue( 1 )
            )
          );

        $stmt = $q->prepare();
        $stmt->execute();
        $rows = $stmt->fetchAll( PDO::FETCH_ASSOC );

        $this->assertEquals(
            0,
            count( $rows ),
            "Cascading while deleting MultiRelationTestPerson mother did not work."
        );
    }

    public function testDeleteNoCascade()
    {
        $father   = $this->session->load( 'MultiRelationTestPerson', 2 );

        $this->session->delete( $father );

        $q = $this->session->createFindQuery( 'MultiRelationTestPerson' );
        $q->where(
            $q->expr->eq(
                'father',
                $q->bindValue( 2 )
            )
          );

        $stmt = $q->prepare();
        $stmt->execute();
        $rows = $stmt->fetchAll( PDO::FETCH_ASSOC );

        $this->assertNotEquals(
            0,
            count( $rows ),
            "Cascaded while deleting MultiRelationTestPerson father while cascade was not desired."
        );
    }

    public function testRemoveRelatioRecordsOnDeleteSiblings()
    {
        $child    = $this->session->load( 'MultiRelationTestPerson', 3 );

        $this->session->delete( $child );

        $q = $this->session->database->createSelectQuery();
        $q->select( '*' )
          ->from( $this->session->database->quoteIdentifier( 'PO_sibling' ) )
          ->where(
            $q->expr->eq(
                $this->session->database->quoteIdentifier( 'person' ),
                $q->bindValue( $child->id )
            )
          );

        $stmt = $q->prepare();
        $stmt->execute();
        $rows = $stmt->fetchAll( PDO::FETCH_ASSOC );

        $this->assertEquals(
            0,
            count( $rows ),
            'Incorrect number of relation records after removing all siblings.'
        );
    }
}

?>
