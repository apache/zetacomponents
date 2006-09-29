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
        return new ezcTestSuite( "ezcPersistentOneToManyRelationTest" );
    }

    public function setup()
    {
        RelationTestEmployer::setupTables();
        RelationTestEmployer::insertData();
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
        $employer = $this->session->load( "RelationTestEmployer", 1 );

        $res = array(
          0 => 
          RelationTestPerson::__set_state(array(
             'id' => '2',
             'firstname' => 'Frederick',
             'surename' => 'Ajax',
             'employer' => '1',
          )),
          1 => 
          RelationTestPerson::__set_state(array(
             'id' => '3',
             'firstname' => 'Raymond',
             'surename' => 'Socialweb',
             'employer' => '1',
          )),
        );

        $this->assertEquals(
            $res,
            $this->session->getRelatedObjects( $employer, "RelationTestPerson" ),
            "Related RelationTestPerson objects not fetched correctly."
        );
    }

    public function testGetRelatedObjectsEmployer2()
    {
        $employer = $this->session->load( "RelationTestEmployer", 2 );
        $res = array(
            0 => 
            RelationTestPerson::__set_state(array(
                'id' => '1',
                'firstname' => 'Theodor',
                'surename' => 'Gopher',
                'employer' => '2',
            )),
        );
        $this->assertEquals(
            $res,
            $this->session->getRelatedObjects( $employer, "RelationTestPerson" ),
            "Related RelationTestPerson objects not fetched correctly."
        );
    }
}

?>
