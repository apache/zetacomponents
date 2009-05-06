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
require_once dirname( __FILE__ ) . "/../data/relation_test_person.php";
require_once dirname( __FILE__ ) . "/../data/relation_test_second_person.php";

/**
 * Tests ezcPersistentManyToManyRelation class.
 *
 * @package PersistentObject
 * @subpackage Tests
 */
class ezcPersistentManyToManyRelationTest extends ezcTestCase
{

    private $session;

    public static function suite()
    {
        return new PHPUnit_Framework_TestSuite( "ezcPersistentManyToManyRelationTest" );
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
        RelationTestPerson::setupTables();
        RelationTestPerson::insertData();
        $this->session = new ezcPersistentSession(
            ezcDbInstance::get(),
            new ezcPersistentCodeManager( dirname( __FILE__ ) . "/../data/" )
        );
    }

    public function teardown()
    {
        RelationTestPerson::cleanup();
    }

    // Tests of the relation definition class

    public function testGetAccessSuccess()
    {
        $relation = new ezcPersistentManyToManyRelation( "PO_persons", "PO_addresses", "PO_persons_addresses" );

        $this->assertEquals( "PO_persons", $relation->sourceTable );
        $this->assertEquals( "PO_addresses", $relation->destinationTable );
        $this->assertEquals( "PO_persons_addresses", $relation->relationTable );
        $this->assertEquals( array(), $relation->columnMap );
        $this->assertEquals( false, $relation->reverse );
    }

    public function testGetAccessFailure()
    {
        $relation = new ezcPersistentManyToManyRelation( "PO_persons", "PO_addresses", "PO_persons_addresses" );
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
        $relation = new ezcPersistentManyToManyRelation( "PO_persons", "PO_addresses", "PO_persons_addresses" );

        $this->assertTrue( isset( $relation->sourceTable ) );
        $this->assertTrue( isset( $relation->destinationTable ) );
        $this->assertTrue( isset( $relation->relationTable ) );
        $this->assertTrue( isset( $relation->columnMap ) );
        $this->assertTrue( isset( $relation->reverse ) );
    }

    public function testSetAccessSuccess()
    {
        $relation = new ezcPersistentManyToManyRelation( "PO_persons", "PO_addresses", "PO_persons_addresses" );
        $tableMap = new ezcPersistentDoubleTableMap( "other_persons_id", "other_persons_id", "other_addresses_id", "other_addresses_id" );

        $relation->sourceTable = "PO_other_persons";
        $relation->destinationTable = "PO_other_addresses";
        $relation->relationTable = "PO_other_persons_other_addresses";
        $relation->columnMap = array( $tableMap );
        $relation->reverse = true;

        $this->assertEquals( $relation->sourceTable, "PO_other_persons" );
        $this->assertEquals( $relation->destinationTable, "PO_other_addresses" );
        $this->assertEquals( $relation->relationTable, "PO_other_persons_other_addresses" );
        $this->assertEquals( $relation->columnMap, array( $tableMap ) );
        $this->assertEquals( $relation->reverse, true );
    }

    public function testSetAccessFailure()
    {
        $relation = new ezcPersistentManyToManyRelation( "PO_persons", "PO_addresses", "PO_persons_addresses" );
        $tableMap = new ezcPersistentSingleTableMap( "other_persons_id", "other_addresses_id" );

        try
        {
            $relation->sourceTable = 23;
            $this->fail( "Exception not thrown on invalid value for ezcPersistentManyToManyRelation->sourceTable." );
        }
        catch ( ezcBaseValueException $e )
        {
        }

        try
        {
            $relation->destinationTable = 42;
            $this->fail( "Exception not thrown on invalid value for ezcPersistentManyToManyRelation->destinationTable." );
        }
        catch ( ezcBaseValueException $e )
        {
        }

        try
        {
            $relation->relationTable = 5;
            $this->fail( "Exception not thrown on invalid value for ezcPersistentManyToManyRelation->relationTable." );
        }
        catch ( ezcBaseValueException $e )
        {
        }

        try
        {
            $relation->columnMap = array( $tableMap );
            $this->fail( "Exception not thrown on invalid value for ezcPersistentManyToManyRelation->columnMap." );
        }
        catch ( ezcBaseValueException $e )
        {
        }
        
        try
        {
            $relation->columnMap = array();
            $this->fail( "Exception not thrown on invalid value for ezcPersistentManyToManyRelation->columnMap." );
        }
        catch ( ezcBaseValueException $e )
        {
        }

        try
        {
            $relation->reverse = array();
            $this->fail( "Exception not thrown on invalid value for ezcPersistentManyToManyRelation->reverse." );
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

    public function testGetRelatedObjectsPerson1()
    {
        $person = $this->session->load( "RelationTestPerson", 1 );
        $res = array (
            1 => 
            RelationTestAddress::__set_state(array(
                'id' => '1',
                'street' => 'Httproad 23',
                'zip' => '12345',
                'city' => 'Internettown',
                'type' => 'work',
            )),
            2 => 
            RelationTestAddress::__set_state(array(
                'id' => '2',
                'street' => 'Ftpstreet 42',
                'zip' => '12345',
                'city' => 'Internettown',
                'type' => 'work',
            )),
            4 => 
            RelationTestAddress::__set_state(array(
                'id' => '4',
                'street' => 'Pythonstreet 13',
                'zip' => '12345',
                'city' => 'Internettown',
                'type' => 'private',
            )),
        );

        $this->assertEquals(
            $res,
            $this->session->getRelatedObjects( $person, "RelationTestAddress" ),
            "Related RelationTestPerson objects not fetched correctly."
        );
    }

    public function testGetRelatedObjectsPerson2()
    {
        $person = $this->session->load( "RelationTestPerson", 2 );
        $res = array (
            1 => 
            RelationTestAddress::__set_state(array(
                'id' => '1',
                'street' => 'Httproad 23',
                'zip' => '12345',
                'city' => 'Internettown',
                'type' => 'work',
            )),
            3 => 
            RelationTestAddress::__set_state(array(
                'id' => '3',
                'street' => 'Phpavenue 21',
                'zip' => '12345',
                'city' => 'Internettown',
                'type' => 'private',
            )),
            4 => 
            RelationTestAddress::__set_state(array(
                'id' => '4',
                'street' => 'Pythonstreet 13',
                'zip' => '12345',
                'city' => 'Internettown',
                'type' => 'private',
            )),
        );

        $this->assertEquals(
            $res,
            $this->session->getRelatedObjects( $person, "RelationTestAddress" ),
            "Related RelationTestPerson objects not fetched correctly."
        );
    }
    
    public function testGetRelatedObjectFromPerson1()
    {
        $person = $this->session->load( "RelationTestPerson", 1 );
        $res = RelationTestAddress::__set_state(array(
            'id' => '1',
            'street' => 'Httproad 23',
            'zip' => '12345',
            'city' => 'Internettown',
            'type' => 'work',
        ));

        $this->assertEquals(
            $res,
            $this->session->getRelatedObject( $person, "RelationTestAddress" ),
            "Related RelationTestPerson objects not fetched correctly."
        );
    }

    public function testGetRelatedObjectFromPerson2()
    {
        $person = $this->session->load( "RelationTestPerson", 2 );
        $res =  RelationTestAddress::__set_state(array(
            'id' => '1',
            'street' => 'Httproad 23',
            'zip' => '12345',
            'city' => 'Internettown',
            'type' => 'work',
        ));

        $this->assertEquals(
            $res,
            $this->session->getRelatedObject( $person, "RelationTestAddress" ),
            "Related RelationTestPerson objects not fetched correctly."
        );
    }

    public function testGetRelatedObjectFromSecondPerson()
    {
        $person = $this->session->load( "RelationTestSecondPerson", 1 );
        $res =  RelationTestAddress::__set_state(array(
            'id' => '1',
            'street' => 'Httproad 23',
            'zip' => '12345',
            'city' => 'Internettown',
            'type' => 'work',
        ));

        $this->assertEquals(
            $res,
            $this->session->getRelatedObject( $person, "RelationTestAddress" ),
            "Related RelationTestPerson objects not fetched correctly."
        );
    }

    public function testGetRelatedPersonsFromAddress1()
    {
        $address = $this->session->load( "RelationTestAddress", 1 );

        $res = array (
            1 => 
            RelationTestPerson::__set_state(array(
             'id' => '1',
             'firstname' => 'Theodor',
             'surname' => 'Gopher',
             'employer' => '2',
            )),
            2 => 
            RelationTestPerson::__set_state(array(
             'id' => '2',
             'firstname' => 'Frederick',
             'surname' => 'Ajax',
             'employer' => '1',
            )),
        );

        $this->assertEquals(
            $res,
            $this->session->getRelatedObjects( $address, "RelationTestPerson" ),
            "Related RelationTestPerson objects not fetched correctly."
        );
    }
    
    public function testAddRelatedObjectToPerson2()
    {
        $person  = $this->session->load( "RelationTestPerson",  2 );
        $address = $this->session->load( "RelationTestAddress", 2 );

        $this->session->addRelatedObject( $person, $address );

        $q = $this->session->database->createSelectQuery();
        $q->select( "*" )
          ->from( $this->session->database->quoteIdentifier( "PO_persons_addresses" ) )
          ->where(
            $q->expr->eq( $this->session->database->quoteIdentifier( "person_id" ), 2 ),
            $q->expr->eq( $this->session->database->quoteIdentifier( "address_id" ), 2 )
          );

        $stmt = $q->prepare();
        $stmt->execute();

        $res =array (
            'address_id' => '2',
            0 => '2',
            'person_id' => '2',
            1 => '2',
        );

        $this->assertEquals(
            $res,
            $stmt->fetch(),
            "Relation not established correctly."
        );
    }
    
    public function testAddRelatedObjectToSecondPerson()
    {
        $person  = $this->session->load( "RelationTestSecondPerson",  2 );
        $address = $this->session->load( "RelationTestAddress", 2 );

        $this->session->addRelatedObject( $person, $address );

        $q = $this->session->database->createSelectQuery();
        $q->select( "*" )
          ->from( $this->session->database->quoteIdentifier( "PO_secondpersons_addresses" ) )
          ->where(
            $q->expr->eq( $this->session->database->quoteIdentifier( "person_firstname" ), $q->bindValue( "Frederick" ) ),
            $q->expr->eq( $this->session->database->quoteIdentifier( "person_surname" ), $q->bindValue( "Ajax" ) ),
            $q->expr->eq( $this->session->database->quoteIdentifier( "address_id" ), 2 )
          );

        $stmt = $q->prepare();
        $stmt->execute();

        $res =array (
            'address_id' => '2',
            0 => '2',
            'person_firstname' => 'Frederick',
            1 => 'Frederick',
            'person_surname' => 'Ajax',
            2 => 'Ajax',
        );

        $this->assertEquals(
            $res,
            $stmt->fetch(),
            "Relation not established correctly."
        );
    }
    
    public function testAddRelatedPersonToAddress2Failure()
    {
        $person  = $this->session->load( "RelationTestPerson",  2 );
        $address = $this->session->load( "RelationTestAddress", 2 );

        try
        {
            $this->session->addRelatedObject( $address, $person );
        }
        catch ( ezcPersistentRelationOperationNotSupportedException $e )
        {
            $this->assertEquals(
                "The relation between 'RelationTestAddress' and 'RelationTestPerson' does not support the operation 'addRelatedObject'. Reason: 'Relation is a reverse relation.'.",
                $e->getMessage(),
                "Exception message incorrect."
            );
            return;
        }
        $this->fail( "Exception not thrown on creation of reverse relation." );
    }
    
    public function testRemoveRelatedAddressesFromPerson1()
    {
        $person    = $this->session->load( "RelationTestPerson", 1 );
        $addresses = $this->session->getRelatedObjects( $person, "RelationTestAddress" );

        foreach ( $addresses as $address )
        {
            $this->session->removeRelatedObject( $person, $address );
        }

        $res = array();

        $this->assertEquals(
            $res,
            $this->session->getRelatedObjects( $person, "RelationTestAddress" ),
            "Related RelationTestPerson objects not deleted correctly."
        );
    }

    public function testRemoveRelatedObjectFromPerson2()
    {
        $person = $this->session->load( "RelationTestPerson", 2 );
        $address = $this->session->getRelatedObject( $person, "RelationTestAddress" );

        $this->session->removeRelatedObject( $person, $address );

        $res = array (
            3 => 
            RelationTestAddress::__set_state(array(
                'id' => '3',
                'street' => 'Phpavenue 21',
                'zip' => '12345',
                'city' => 'Internettown',
                'type' => 'private',
            )),
            4 => 
            RelationTestAddress::__set_state(array(
                'id' => '4',
                'street' => 'Pythonstreet 13',
                'zip' => '12345',
                'city' => 'Internettown',
                'type' => 'private',
            )),
        );

        $this->assertEquals(
            $res,
            $this->session->getRelatedObjects( $person, "RelationTestAddress" ),
            "Related RelationTestPerson objects not deleted correctly."
        );
    }

    public function testRemoveRelatedObjectFromSecondPerson()
    {
        $person = $this->session->load( "RelationTestSecondPerson", 1 );
        $address =  RelationTestAddress::__set_state(array(
            'id' => '1',
            'street' => 'Httproad 23',
            'zip' => '12345',
            'city' => 'Internettown',
            'type' => 'work',
        ));

        $this->session->removeRelatedObject( $person, $address );

        $this->assertEquals(
            array(),
            $this->session->getRelatedObjects( $person, "RelationTestAddress" ),
            "Related RelationTestSecondPerson object not removed correctly."
        );
    }

    public function testDeleteAddress1RelationRecordsSuccess()
    {
        $address = $this->session->load( "RelationTestAddress", 1 );

        $this->assertEquals(
            2,
            sizeof( $this->session->getRelatedObjects( $address, "RelationTestPerson" ) ),
            "Number of Addresses related to Person invalid, test pre-condition failed!"
        );

        $this->session->delete( $address );

        $this->assertEquals(
            array(),
            $this->session->getRelatedObjects( $address, "RelationTestPerson" ),
            "Address relation records not deleted correctly on Person delete."
        );
    }

    public function testGetRelatedObjectWithAmbigiousColumn()
    {
        $person = $this->session->load( "RelationTestPerson", 1 );
        $res =  RelationTestAddress::__set_state(array(
            'id' => '1',
            'street' => 'Httproad 23',
            'zip' => '12345',
            'city' => 'Internettown',
            'type' => 'work',
        ));

        $this->assertEquals(
            $res,
            $this->session->getRelatedObject( $person, "RelationTestAddress" ),
            "Related RelationTestPerson objects not fetched correctly."
        );

        $friends = $this->session->getRelatedObjects( $person, 'RelationTestPerson' );
        $res = array (
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
            $friends
        );
    }

    public function testRemoveRelatedObjectWithAmbigiousColumn()
    {
        $person = $this->session->load( "RelationTestPerson", 1 );
        $res =  RelationTestAddress::__set_state(array(
            'id' => '1',
            'street' => 'Httproad 23',
            'zip' => '12345',
            'city' => 'Internettown',
            'type' => 'work',
        ));

        $this->assertEquals(
            $res,
            $this->session->getRelatedObject( $person, "RelationTestAddress" ),
            "Related RelationTestPerson objects not fetched correctly."
        );

        $friends = $this->session->getRelatedObjects( $person, 'RelationTestPerson' );
        $res = array (
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
            $friends
        );

        $this->session->removeRelatedObject( $person, $friends[2] );

        $friends = $this->session->getRelatedObjects( $person, 'RelationTestPerson' );
        $res = array (
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
            $friends
        );
    }
    
    public function testAddRelatedObjectWithAmbigiousColumn()
    {
        $person = $this->session->load( "RelationTestPerson", 3 );
        $friends = $this->session->getRelatedObjects( $person, 'RelationTestPerson' );

        $this->assertEquals(
            array(),
            $friends
        );
        
        $otherPerson = $this->session->load( "RelationTestPerson", 1 );

        $this->session->addRelatedObject( $person, $otherPerson );

        $friends = $this->session->getRelatedObjects( $person, 'RelationTestPerson' );
        $res = array (
            0 => 
            RelationTestPerson::__set_state(array(
             'id' => '3',
             'firstname' => 'Raymond',
             'surname' => 'Socialweb',
             'employer' => '1',
            )),
        );
    }

    public function testDeleteRelatedObjectWithAmbigiousColumn()
    {
        $person = $this->session->load( "RelationTestPerson", 1 );
        $res =  RelationTestAddress::__set_state(array(
            'id' => '1',
            'street' => 'Httproad 23',
            'zip' => '12345',
            'city' => 'Internettown',
            'type' => 'work',
        ));

        $this->assertEquals(
            $res,
            $this->session->getRelatedObject( $person, "RelationTestAddress" ),
            "Related RelationTestPerson objects not fetched correctly."
        );

        $friends = $this->session->getRelatedObjects( $person, 'RelationTestPerson' );
        $res = array (
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
            $friends
        );

        $this->session->removeRelatedObject( $person, $friends[2] );
        $this->session->removeRelatedObject( $person, $friends[3] );

        $friends = $this->session->getRelatedObjects( $person, 'RelationTestPerson' );

        $this->assertEquals(
            array(),
            $this->session->getRelatedObjects( $person, 'RelationTestPerson' )
        );
    }
}

?>
