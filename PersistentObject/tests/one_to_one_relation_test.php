<?php
/**
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package PersistentObject
 * @subpackage Tests
 */

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
}

?>
