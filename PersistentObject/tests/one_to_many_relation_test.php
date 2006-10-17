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
        return new PHPUnit_Framework_TestSuite( "ezcPersistentOneToManyRelationTest" );
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
             'surname' => 'Ajax',
             'employer' => '1',
          )),
          1 => 
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

    public function testGetRelatedObjectsEmployer2()
    {
        $employer = $this->session->load( "RelationTestEmployer", 2 );
        $res = array(
            0 => 
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
    
    public function testGetRelatedObjectEmployer1()
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

    public function testGetRelatedObjectEmployer2()
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

    public function testAddRelatedObjectsEmployer2()
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

        $this->session->addRelatedObjects( $employer, $persons );

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

    public function testAddRelatedObjectEmployer2()
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
}

?>
