<?php
/**
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package PersistentObject
 * @subpackage Tests
 */

require_once dirname( __FILE__ ) . "/data/relation_test_employer.php";
require_once dirname( __FILE__ ) . "/data/relation_test_person.php";

/**
 * Tests ezcPersistentManyToOneRelation class.
 *
 * @package PersistentObject
 * @subpackage Tests
 */
class ezcPersistentManyToOneRelationTest extends ezcTestCase
{

    private $session;

    public static function suite()
    {
        return new PHPUnit_Framework_TestSuite( "ezcPersistentManyToOneRelationTest" );
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
        RelationTestEmployer::cleanup();
    }

    public function testGetRelatedObjectsEmployer1()
    {
        $employer = $this->session->load( "RelationTestPerson", 1 );
        $res = array (
        0 => 
            RelationTestEmployer::__set_state(array(
                'id' => '2',
                'name' => 'Oldschool Web 1.x company',
            )),
        );

        $this->assertEquals(
            $res,
            $this->session->getRelatedObjects( $employer, "RelationTestEmployer" ),
            "Related RelationTestPerson objects not fetched correctly."
        );
    }

    public function testGetRelatedObjectsEmployer2()
    {
        $employer = $this->session->load( "RelationTestPerson", 2 );
        $res = array (
            0 => RelationTestEmployer::__set_state(array(
                'id' => '1',
                'name' => 'Great Web 2.0 company',
            )),
        );

        $this->assertEquals(
            $res,
            $this->session->getRelatedObjects( $employer, "RelationTestEmployer" ),
            "Related RelationTestPerson objects not fetched correctly."
        );
    }

    public function testGetRelatedObjectEmployer1()
    {
        $employer = $this->session->load( "RelationTestPerson", 1 );
        $res = RelationTestEmployer::__set_state(array(
                'id' => '2',
                'name' => 'Oldschool Web 1.x company',
        ));

        $this->assertEquals(
            $res,
            $this->session->getRelatedObject( $employer, "RelationTestEmployer" ),
            "Related RelationTestPerson objects not fetched correctly."
        );
    }

    public function testGetRelatedObjectEmployer2()
    {
        $employer = $this->session->load( "RelationTestPerson", 2 );
        $res = RelationTestEmployer::__set_state(array(
                'id' => '1',
                'name' => 'Great Web 2.0 company',
        ));

        $this->assertEquals(
            $res,
            $this->session->getRelatedObject( $employer, "RelationTestEmployer" ),
            "Related RelationTestPerson objects not fetched correctly."
        );
    }
}

?>
