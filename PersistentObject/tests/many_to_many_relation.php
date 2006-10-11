<?php
/**
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package PersistentObject
 * @subpackage Tests
 */

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
}

?>
