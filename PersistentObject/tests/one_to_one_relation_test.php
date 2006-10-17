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

require_once dirname( __FILE__ ) . "/data/relation_test_person.php";
require_once dirname( __FILE__ ) . "/data/relation_test_birthday.php";

/**
 * Tests ezcPersistentOneToOneRelation class.
 *
 * @package PersistentObject
 * @subpackage Tests
 */
class ezcPersistentOneToOneRelationTest extends ezcTestCase
{

    private $session;

    public static function suite()
    {
        return new PHPUnit_Framework_TestSuite( "ezcPersistentOneToOneRelationTest" );
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
        RelationTestBirthday::cleanup();
    }
    
    // Tests of the relation definition class

    public function testGetAccessSuccess()
    {
        $relation = new ezcPersistentOneToOneRelation( "PO_persons", "PO_addresses" );

        $this->assertEquals( "PO_persons", $relation->sourceTable );
        $this->assertEquals( "PO_addresses", $relation->destinationTable );
        $this->assertEquals( array(), $relation->columnMap );
        $this->assertEquals( false, $relation->reverse );
        $this->assertEquals( false, $relation->cascade );
    }

    public function testGetAccessFailure()
    {
        $relation = new ezcPersistentOneToOneRelation( "PO_persons", "PO_addresses" );
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
        $relation = new ezcPersistentOneToOneRelation( "PO_persons", "PO_addresses" );

        $this->assertTrue( isset( $relation->sourceTable ) );
        $this->assertTrue( isset( $relation->destinationTable ) );
        $this->assertTrue( isset( $relation->columnMap ) );
        $this->assertTrue( isset( $relation->reverse ) );
        $this->assertTrue( isset( $relation->cascade ) );
    }

    public function testSetAccessSuccess()
    {
        $relation = new ezcPersistentOneToOneRelation( "PO_persons", "PO_addresses" );
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
    }

    public function testSetAccessFailure()
    {
        $relation = new ezcPersistentOneToOneRelation( "PO_persons", "PO_addresses" );
        $tableMap = new ezcPersistentDoubleTableMap( "other_persons_id", "other_persons_id", "other_addresses_id", "other_addresses_id" );

        try
        {
            $relation->sourceTable = 23;
            $this->fail( "Exception not thrown on invalid value for ezcPersistentOneToOneRelation->sourceTable." );
        }
        catch ( ezcBaseValueException $e )
        {
        }

        try
        {
            $relation->destinationTable = 42;
            $this->fail( "Exception not thrown on invalid value for ezcPersistentOneToOneRelation->destinationTable." );
        }
        catch ( ezcBaseValueException $e )
        {
        }

        try
        {
            $relation->columnMap = array( $tableMap );
            $this->fail( "Exception not thrown on invalid value for ezcPersistentOneToOneRelation->columnMap." );
        }
        catch ( ezcBaseValueException $e )
        {
        }
        
        try
        {
            $relation->columnMap = array();
            $this->fail( "Exception not thrown on invalid value for ezcPersistentOneToOneRelation->columnMap." );
        }
        catch ( ezcBaseValueException $e )
        {
        }

        try
        {
            $relation->reverse = array();
            $this->fail( "Exception not thrown on invalid value for ezcPersistentOneToOneRelation->reverse." );
        }
        catch ( ezcBaseValueException $e )
        {
        }

        try
        {
            $relation->cascade = array();
            $this->fail( "Exception not thrown on invalid value for ezcPersistentOneToOneRelation->cascade." );
        }
        catch ( ezcBaseValueException $e )
        {
        }
    }
    
    // Tests using the actual relation definition

    public function testGetRelatedObjectsBirthday1()
    {
        $person = $this->session->load( "RelationTestPerson", 1 );
        $res = array (
            0 => 
            RelationTestBirthday::__set_state(array(
                'person' => '1',
                'birthday' => '327535201',
            )),
        );
        $this->assertEquals(
            $res,
            $this->session->getRelatedObjects( $person, "RelationTestBirthday" ),
            "Related RelationTestPerson objects not fetched correctly."
        );
    }
    
    public function testGetRelatedObjectsBirthday2()
    {
        $person = $this->session->load( "RelationTestPerson", 2 );
        $res = array(
            0 => 
            RelationTestBirthday::__set_state(array(
                'person' => '2',
                'birthday' => '-138243599',
            )),
        );
        $this->assertEquals(
            $res,
            $this->session->getRelatedObjects( $person, "RelationTestBirthday" ),
            "Related RelationTestPerson objects not fetched correctly."
        );
    }
    
    public function testGetRelatedObjectBirthday1()
    {
        $person = $this->session->load( "RelationTestPerson", 1 );

        $res = RelationTestBirthday::__set_state(array(
            'person' => '1',
            'birthday' => '327535201',
        ));

        $this->assertEquals(
            $res,
            $this->session->getRelatedObject( $person, "RelationTestBirthday" ),
            "Related RelationTestPerson objects not fetched correctly."
        );
    }

    public function testGetRelatedObjectBirthday2()
    {
        $person = $this->session->load( "RelationTestPerson", 2 );
        $res = RelationTestBirthday::__set_state(array(
            'person' => '2',
            'birthday' => '-138243599',
        ));
        $this->assertEquals(
            $res,
            $this->session->getRelatedObject( $person, "RelationTestBirthday" ),
            "Related RelationTestPerson objects not fetched correctly."
        );
    }
 
    public function testAddRelatedObjectsBirthday2()
    {
        $person = $this->session->load( "RelationTestPerson", 3 );
        
        $birthday = new RelationTestBirthday();
        $birthday->setState( array(
            "birthday"  => 1161019786,
        ) );

        $this->session->addRelatedObjects( $person, array( $birthday ) );
        
        $res = RelationTestBirthday::__set_state( array( 
            'person' => '3',
            'birthday' => 1161019786,
        ));

        $this->assertEquals(
            $res,
            $birthday,
            "Relation not established correctly"
        );
    }
 
    public function testAddRelatedObjectBirthday2()
    {
        $person = $this->session->load( "RelationTestPerson", 3 );
        
        $birthday = new RelationTestBirthday();
        $birthday->setState( array(
            "birthday"  => 1161019786,
        ) );

        $this->session->addRelatedObject( $person, $birthday );
        
        $res = RelationTestBirthday::__set_state( array( 
            'person' => '3',
            'birthday' => 1161019786,
        ));

        $this->assertEquals(
            $res,
            $birthday,
            "Relation not established correctly"
        );
    }
}

?>
