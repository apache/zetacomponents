<?php
/**
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package PersistentObject
 * @subpackage Tests
 */
ezcTestRunner::addFileToFilter( __FILE__ );

require_once dirname( __FILE__ ) . "/data/relation_test_address.php";
require_once dirname( __FILE__ ) . "/data/relation_test_person.php";

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
        RelationTestPerson::setupTables();
        RelationTestPerson::insertData();
        $this->session = new ezcPersistentSession(
            ezcDbInstance::get(),
            new ezcPersistentCodeManager( dirname( __FILE__ ) . "/data/" )
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
            0 => 
            RelationTestAddress::__set_state(array(
                'id' => '1',
                'street' => 'Httproad 23',
                'zip' => '12345',
                'city' => 'Internettown',
                'type' => 'work',
            )),
            1 => 
            RelationTestAddress::__set_state(array(
                'id' => '2',
                'street' => 'Ftpstreet 42',
                'zip' => '12345',
                'city' => 'Internettown',
                'type' => 'work',
            )),
            2 => 
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
            0 => 
            RelationTestAddress::__set_state(array(
                'id' => '1',
                'street' => 'Httproad 23',
                'zip' => '12345',
                'city' => 'Internettown',
                'type' => 'work',
            )),
            1 => 
            RelationTestAddress::__set_state(array(
                'id' => '3',
                'street' => 'Phpavenue 21',
                'zip' => '12345',
                'city' => 'Internettown',
                'type' => 'private',
            )),
            2 => 
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
    
    public function testGetRelatedObjectPerson1()
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

    public function testGetRelatedObjectPerson2()
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
    
    public function testAddRelatedObjectPerson2()
    {
        $person  = $this->session->load( "RelationTestPerson",  2 );
        $address = $this->session->load( "RelationTestAddress", 2 );

        $this->session->addRelatedObject( $person, $address );

        $q = $this->session->database->createSelectQuery();
        $q->select( "*" )
          ->from( "PO_persons_addresses" )
          ->where(
            $q->expr->eq( "person_id", 2 ),
            $q->expr->eq( "address_id", 2 )
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
}

?>
