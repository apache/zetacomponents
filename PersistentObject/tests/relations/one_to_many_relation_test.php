<?php
/**
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package PersistentObject
 * @subpackage Tests
 */

require_once dirname( __FILE__ ) . "/../data/relation_test_address.php";
require_once dirname( __FILE__ ) . "/../data/relation_test_employer.php";
require_once dirname( __FILE__ ) . "/../data/relation_test_person.php";
require_once dirname( __FILE__ ) . "/../data/relation_test_birthday.php";

/**
 * Tests ezcPersistentOneToManyRelation class.
 *
 * @package PersistentObject
 * @subpackage Tests
 */
class ezcPersistentOneToManyRelationTest extends ezcTestCase
{

    private $session;

    public static function suite()
    {
        return new PHPUnit_Framework_TestSuite( "ezcPersistentOneToManyRelationTest" );
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
        RelationTestEmployer::setupTables();
        RelationTestEmployer::insertData();
        $this->session = new ezcPersistentSession(
            ezcDbInstance::get(),
            new ezcPersistentCodeManager( dirname( __FILE__ ) . "/../data/" )
        );
    }

    public function teardown()
    {
        RelationTestEmployer::cleanup();
    }
    
    // Tests of the relation definition class

    public function testGetAccessSuccess()
    {
        $relation = new ezcPersistentOneToManyRelation( "PO_persons", "PO_addresses" );

        $this->assertEquals( "PO_persons", $relation->sourceTable );
        $this->assertEquals( "PO_addresses", $relation->destinationTable );
        $this->assertEquals( array(), $relation->columnMap );
        $this->assertEquals( false, $relation->reverse );
        $this->assertEquals( false, $relation->cascade );
    }

    public function testGetAccessFailure()
    {
        $relation = new ezcPersistentOneToManyRelation( "PO_persons", "PO_addresses" );
        try
        {
            $foo = $relation->non_existent;
        }
        catch ( ezcBasePropertyNotFoundException $e )
        {
            return;
        }
        $this->fail( "Exception not thrown on access of non existent property." );
    }
    
    public function testIssetAccessSuccess()
    {
        $relation = new ezcPersistentOneToManyRelation( "PO_persons", "PO_addresses" );

        $this->assertTrue( isset( $relation->sourceTable ) );
        $this->assertTrue( isset( $relation->destinationTable ) );
        $this->assertTrue( isset( $relation->columnMap ) );
        $this->assertTrue( isset( $relation->reverse ) );
        $this->assertTrue( isset( $relation->cascade ) );
    }

    public function testSetAccessSuccess()
    {
        $relation = new ezcPersistentOneToManyRelation( "PO_persons", "PO_addresses" );
        $tableMap = new ezcPersistentSingleTableMap( "other_persons_id", "other_addresses_id" );

        $relation->sourceTable = "PO_other_persons";
        $relation->destinationTable = "PO_other_addresses";
        $relation->columnMap = array( $tableMap );
        $relation->reverse = true;
        $relation->cascade = true;

        $this->assertEquals( $relation->sourceTable, "PO_other_persons" );
        $this->assertEquals( $relation->destinationTable, "PO_other_addresses" );
        $this->assertEquals( $relation->columnMap, array( $tableMap ) );
        $this->assertEquals( $relation->reverse, true );
        $this->assertEquals( $relation->cascade, true );
    }

    public function testSetAccessFailure()
    {
        $relation = new ezcPersistentOneToManyRelation( "PO_persons", "PO_addresses" );
        $tableMap = new ezcPersistentDoubleTableMap( "other_persons_id", "other_persons_id", "other_addresses_id", "other_addresses_id" );

        try
        {
            $relation->sourceTable = 23;
            $this->fail( "Exception not thrown on invalid value for ezcPersistentOneToManyRelation->sourceTable." );
        }
        catch ( ezcBaseValueException $e )
        {
        }

        try
        {
            $relation->destinationTable = 42;
            $this->fail( "Exception not thrown on invalid value for ezcPersistentOneToManyRelation->destinationTable." );
        }
        catch ( ezcBaseValueException $e )
        {
        }

        try
        {
            $relation->columnMap = array( $tableMap );
            $this->fail( "Exception not thrown on invalid value for ezcPersistentOneToManyRelation->columnMap." );
        }
        catch ( ezcBaseValueException $e )
        {
        }
        
        try
        {
            $relation->columnMap = array();
            $this->fail( "Exception not thrown on invalid value for ezcPersistentOneToManyRelation->columnMap." );
        }
        catch ( ezcBaseValueException $e )
        {
        }

        try
        {
            $relation->reverse = array();
            $this->fail( "Exception not thrown on invalid value for ezcPersistentOneToManyRelation->reverse." );
        }
        catch ( ezcBaseValueException $e )
        {
        }

        try
        {
            $relation->cascade = array();
            $this->fail( "Exception not thrown on invalid value for ezcPersistentOneToManyRelation->cascade." );
        }
        catch ( ezcBaseValueException $e )
        {
        }

        try
        {
            $relation->non_existent = true;
            $this->fail( "Exception not thrown on set access on non existent property." );
        }
        catch ( ezcBasePropertyNotFoundException $e )
        {
        }
    }
    
    // Tests using the actual relation definition

    public function testGetRelatedObjectsFromEmployer1Success()
    {
        $employer = $this->session->load( "RelationTestEmployer", 1 );

        $res = array(
          2 => 
          RelationTestPerson::__set_state(array(
             'id' => '2',
             'firstname' => 'Frederick',
             'surname' => 'Ajax',
             'employer' => '1',
          )),
          3 => 
          RelationTestPerson::__set_state(array(
             'id' => '3',
             'firstname' => 'Raymond',
             'surname' => 'Socialweb',
             'employer' => '1',
          )),
        );

        $this->assertEquals(
            $res,
            $this->session->getRelatedObjects( $employer, "RelationTestPerson" ),
            "Related RelationTestPerson objects not fetched correctly."
        );
    }

    public function testGetRelatedObjectsFromEmployer2Success()
    {
        $employer = $this->session->load( "RelationTestEmployer", 2 );
        $res = array(
            1 => 
            RelationTestPerson::__set_state(array(
                'id' => '1',
                'firstname' => 'Theodor',
                'surname' => 'Gopher',
                'employer' => '2',
            )),
        );
        $this->assertEquals(
            $res,
            $this->session->getRelatedObjects( $employer, "RelationTestPerson" ),
            "Related RelationTestPerson objects not fetched correctly."
        );
    }

    public function testFindRelatedObjectsFromEmployer2Success()
    {
        $employer = $this->session->load( "RelationTestEmployer", 2 );
        $q = $this->session->createRelationFindQuery( $employer, 'RelationTestPerson' );

        $res = array(
            1 => 
            RelationTestPerson::__set_state(array(
                'id' => '1',
                'firstname' => 'Theodor',
                'surname' => 'Gopher',
                'employer' => '2',
            )),
        );
        $this->assertEquals(
            $res,
            $this->session->find( $q ),
            "Related RelationTestPerson objects not fetched correctly."
        );
    }
    
    public function testGetRelatedObjectFromEmployer1Success()
    {
        $employer = $this->session->load( "RelationTestEmployer", 1 );

        $res = RelationTestPerson::__set_state(array(
             'id' => '2',
             'firstname' => 'Frederick',
             'surname' => 'Ajax',
             'employer' => '1',
        ));

        $this->assertEquals(
            $res,
            $this->session->getRelatedObject( $employer, "RelationTestPerson" ),
            "Related RelationTestPerson objects not fetched correctly."
        );
    }

    public function testGetRelatedObjectFromEmployer2Success()
    {
        $employer = $this->session->load( "RelationTestEmployer", 2 );
        $res = RelationTestPerson::__set_state(array(
                'id' => '1',
                'firstname' => 'Theodor',
                'surname' => 'Gopher',
                'employer' => '2',
        ));
        $this->assertEquals(
            $res,
            $this->session->getRelatedObject( $employer, "RelationTestPerson" ),
            "Related RelationTestPerson objects not fetched correctly."
        );
    }

    public function testGetRelatedObjectFromEmployer3Failure()
    {
        $employer = $this->session->load( "RelationTestEmployer", 3 );
        try
        {
            $this->session->getRelatedObject( $employer, "RelationTestPerson" );
        }
        catch ( ezcPersistentRelatedObjectNotFoundException $e )
        {
            return;
        }
        $this->fail( "Exception not thrown when getRelatedObject() does not find a record." );
    }

    public function testAddRelatedPersonsToEmployer2Success()
    {
        $employer = $this->session->load( "RelationTestEmployer", 2 );
        $persons[0] = new RelationTestPerson();
        $persons[0]->setState( array(
            "firstname" => "Tobias",
            "surname"  => "Preprocess",
        ) );
        $persons[1] = new RelationTestPerson();
        $persons[1]->setState( array(
            "firstname" => "Jan",
            "surname"  => "Soap",
        ) );

        foreach ( $persons as $person )
        {
            $this->session->addRelatedObject( $employer, $person );
        }

        $res = array (
            0 => 
            RelationTestPerson::__set_state(array(
                'id' => null,
                'firstname' => 'Tobias',
                'surname' => 'Preprocess',
                'employer' => 2,
            )),
            1 => 
            RelationTestPerson::__set_state(array(
                'id' => null,
                'firstname' => 'Jan',
                'surname' => 'Soap',
                'employer' => 2,
            )),
        );

        $this->assertEquals(
            $res,
            $persons,
            "Relation not established correctly"
        );
    }

    public function testAddRelatedPersonToEmployer2Success()
    {
        $employer = $this->session->load( "RelationTestEmployer", 2 );
        $person = new RelationTestPerson();
        $person->setState( array(
            "firstname" => "Jan",
            "surname"  => "Soap",
        ) );

        $this->session->addRelatedObject( $employer, $person );

        $res = RelationTestPerson::__set_state(array(
            'id' => null,
            'firstname' => 'Jan',
            'surname' => 'Soap',
            'employer' => 2,
        ));

        $this->assertEquals(
            $res,
            $person,
            "Relation not established correctly"
        );
    }

    public function testAddRelatedPersonToEmployer2SaveSuccess()
    {
        $employer = $this->session->load( "RelationTestEmployer", 2 );
        $person = new RelationTestPerson();
        $person->setState( array(
            "firstname" => "Jan",
            "surname"  => "Soap",
        ) );

        $this->session->addRelatedObject( $employer, $person );
        $this->session->save( $person );

        $res = RelationTestPerson::__set_state(array(
            'id' => 4,
            'firstname' => 'Jan',
            'surname' => 'Soap',
            'employer' => 2,
        ));

        $this->assertEquals(
            $res,
            $person,
            "Relation not established correctly"
        );
    }

    public function testAddRelatedObjectAddressFailureNonExsitentRelation()
    {
        $employer = $this->session->load( "RelationTestEmployer", 2 );
        $address = new RelationTestAddress();
        $address->setState(
            array(
                "street" => "Test road",
                "zip"    => 12345,
                "city"   => "Testing town",
                "type"   => "private"
            )
        );

        try
        {
            $this->session->addRelatedObject( $employer, $address );
        }
        catch ( ezcPersistentRelationNotFoundException $e )
        {
            return;
        }
        $this->fail( "Exception not thrown on undefined relation." );
    }

    public function testAddRelatedPersonsToEmployer2SaveSuccess()
    {
        $employer = $this->session->load( "RelationTestEmployer", 2 );
        $persons[0] = new RelationTestPerson();
        $persons[0]->setState( array(
            "firstname" => "Tobias",
            "surname"  => "Preprocess",
        ) );
        $persons[1] = new RelationTestPerson();
        $persons[1]->setState( array(
            "firstname" => "Jan",
            "surname"  => "Soap",
        ) );

        foreach ( $persons as $person )
        {
            $this->session->addRelatedObject( $employer, $person );
        }

        foreach ( $persons as $person )
        {
            $this->session->save( $person );
        }

        $res = array(
          0 => 
          RelationTestPerson::__set_state(array(
             'id' => 4,
             'firstname' => 'Tobias',
             'surname' => 'Preprocess',
             'employer' => 2,
          )),
          1 => 
          RelationTestPerson::__set_state(array(
             'id' => 5,
             'firstname' => 'Jan',
             'surname' => 'Soap',
             'employer' => 2,
          )),
        );

        $this->assertEquals(
            $res,
            $persons,
            "Relation not established correctly"
        );
    }

    public function testRemoveRelatedObjectFromEmployer2Success()
    {
        $employer = $this->session->load( "RelationTestEmployer", 2 );
        $person   = $this->session->getRelatedObject( $employer, "RelationTestPerson" );

        $this->session->removeRelatedObject( $employer, $person );

        $res = RelationTestPerson::__set_state(array(
            'id' => '1',
            'firstname' => 'Theodor',
            'surname' => 'Gopher',
            'employer' => null,
        ));
        $this->assertEquals(
            $res,
            $person,
            "Related RelationTestPerson objects not removed correctly."
        );
    }

    public function testRemoveRelatedPersonsFromEmployer1StoreSuccess()
    {
        $employer = $this->session->load( "RelationTestEmployer", 1 );
        $persons  = $this->session->getRelatedObjects( $employer, "RelationTestPerson" );

        foreach ( $persons as $person )
        {
            $this->session->removeRelatedObject( $employer, $person );
            $this->session->update( $person );
        }

        $res = array();

        $this->assertEquals(
            $res,
            $this->session->getRelatedObjects( $employer, "RelationTestPerson" ),
            "Related RelationTestPerson objects not fetched correctly."
        );
    }

    public function testDeleteEmployer2CascadePersonCascadeBirthdaySuccess()
    {
        $employer = $this->session->load( "RelationTestEmployer", 2 );
        $persons  = $this->session->getRelatedObjects( $employer, "RelationTestPerson" );

        $this->session->delete( $employer );

        foreach ( $persons as $person )
        {
            // Check that the specific person got deleted
            $q = $this->session->createFindQuery( "RelationTestPerson" );
            $q->where(
                $q->expr->eq(
                    $this->session->database->quoteIdentifier( "id" ),
                    $q->bindValue( $person->id )
                )
            );

            $this->assertEquals(
                array(),
                $this->session->find( $q, "RelationTestPerson" ),
                "Cascade not performed correctly to RelationTestPerson on delete."
            );
            
            // Check that all birthdays of the persons got deleted
            $q = $this->session->createFindQuery( "RelationTestBirthday" );
            $q->where(
                $q->expr->eq(
                    $this->session->database->quoteIdentifier( "person_id" ),
                    $q->bindValue( $person->id )
                )
            );

            $this->assertEquals(
                array(),
                $this->session->find( $q, "RelationTestBirthday" ),
                "Cascade not performed correctly to RelationTestBirthday on delete."
            );

            // Check that all relations to addresses for the person got deleted
            $q = $this->session->database->createSelectQuery();
            $q->select( "COUNT(*)" )->from( $this->session->database->quoteIdentifier( "PO_persons_addresses" ) )
              ->where( $q->expr->eq( $this->session->database->quoteIdentifier( "person_id" ), $q->bindValue( $person->id ) ) );

            $stmt = $q->prepare();
            $stmt->execute();

            $this->assertEquals(
                0,
                $stmt->fetchColumn(),
                "ManyToMany relations not correctly removed on delete."
            );
            unset( $q, $stmt );
        }

        // Check that the other records are untouched
        $q = $this->session->database->createSelectQuery();
        $q->select( "COUNT(*)" )->from( $this->session->database->quoteIdentifier( "PO_employers" ) );

        $stmt = $q->prepare();
        $stmt->execute();

        $this->assertEquals(
            2,
            $stmt->fetchColumn(),
            "Employer not correctly deleted directly."
        );
        unset( $q, $stmt );
        
        $q = $this->session->database->createSelectQuery();
        $q->select( "COUNT(*)" )->from( $this->session->database->quoteIdentifier( "PO_persons" ) );

        $stmt = $q->prepare();
        $stmt->execute();

        $this->assertEquals(
            2,
            $stmt->fetchColumn(),
            "Persons cascaded from employer not deletec correctly."
        );
        unset( $q, $stmt );
        
        $q = $this->session->database->createSelectQuery();
        $q->select( "COUNT(*)" )->from( $this->session->database->quoteIdentifier( "PO_persons_addresses" ) );

        $stmt = $q->prepare();
        $stmt->execute();

        $this->assertEquals(
            4,
            $stmt->fetchColumn(),
            "Relations from person to address not correctly removed."
        );
        unset( $q, $stmt );
        
        $q = $this->session->database->createSelectQuery();
        $q->select( "COUNT(*)" )->from( $this->session->database->quoteIdentifier( "PO_birthdays" ) );

        $stmt = $q->prepare();
        $stmt->execute();

        $this->assertEquals(
            1,
            $stmt->fetchColumn(),
            "Birthdays cascaded from persons not correctly delted."
        );
    }

    public function testIsRelatedSuccess()
    {
        $person = $this->session->load( "RelationTestPerson", 1 );
        $employer = $this->session->load( "RelationTestEmployer", 2 );

        $this->assertTrue( $this->session->isRelated( $employer, $person ) );
    }

    public function testIsRelatedReverseSuccess()
    {
        $person = $this->session->load( "RelationTestPerson", 1 );
        $employer = $this->session->load( "RelationTestEmployer", 2 );

        $this->assertTrue( $this->session->isRelated( $person, $employer ) );
    }

    public function testIsRelatedFailure()
    {
        $person = $this->session->load( "RelationTestPerson", 1 );

        $employer = new RelationTestEmployer();
        $employer->id = 2342;

        $this->assertFalse( $this->session->isRelated( $person, $employer ) );
        $this->assertFalse( $this->session->isRelated( $employer, $person ) );
    }
}

?>
