<?php
/**
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package PersistentObject
 * @subpackage Tests
 */

require_once dirname( __FILE__ ) . '/persistent_identity_session_relation_prefetch_test.php';

/**
 * Tests ezcPersistentManyToOneRelation class.
 *
 * @package PersistentObject
 * @subpackage Tests
 */
class ezcPersistentIdentitySessionRelationObjectExtractorTest extends ezcPersistentIdentitySessionRelationPrefetchTest
{
    protected $sesstion;

    protected $idMap;

    protected $extractor;

    public static function suite()
    {
        return new PHPUnit_Framework_TestSuite( __CLASS__ );
    }

    public function setup()
    {
        parent::setup();

        RelationTestPerson::setupTables( $this->db );
        RelationTestPerson::insertData( $this->db );

        $this->session = new ezcPersistentSession(
            $this->db,
            $this->defManager
        );

        $this->idMap = new ezcPersistentBasicIdentityMap(
            $this->defManager
        );

        $this->extractor = new ezcPersistentIdentitySessionRelationObjectExtractor(
            $this->idMap,
            $this->defManager
        );
    }

    public function teardown()
    {
        RelationTestEmployer::cleanup( $this->db );
    }

    public function testOneLevelOneRelationExtract()
    {
        $relations = $this->getOneLevelOneRelationRelations();
        $q         = $this->getOneLevelOneRelationQuery( $relations );
        
        $stmt = $q->prepare();
        $stmt->execute();

        // Actual test
        $this->extractor->extractObjects(
            $stmt, 'RelationTestPerson', 2, $relations
        );

        $person = $this->idMap->getIdentity( 'RelationTestPerson', 2 );
        $this->assertNotNull( $person );
        $this->assertEquals(
            $this->session->load( 'RelationTestPerson', 2 ),
            $person
        );

        $employers = $this->idMap->getRelatedObjects(
            $person, 'RelationTestEmployer'
        );
        
        $this->assertNotNull( $employers );

        $this->assertEquals( 1, count( $employers ) );

        $this->assertEquals(
            current( $employers ),
            current( $this->session->getRelatedObjects( $person, 'RelationTestEmployer' ) )
        );
    }

    public function testOneLevelMultiRelationExtract()
    {
        $relations = $this->getOneLevelMultiRelationRelations();
        $q         = $this->getOneLevelMultiRelationQuery( $relations );
        
        $stmt = $q->prepare();
        $stmt->execute();

        // Actual test
        $this->extractor->extractObjects(
            $stmt, 'RelationTestPerson', 2, $relations
        );

        $person = $this->idMap->getIdentity( 'RelationTestPerson', 2 );
        $this->assertNotNull( $person );
        $this->assertEquals(
            $this->session->load( 'RelationTestPerson', 2 ),
            $person
        );

        $employers = $this->idMap->getRelatedObjects(
            $person, 'RelationTestEmployer'
        );
        
        $this->assertNotNull( $employers );

        $this->assertEquals( 1, count( $employers ) );

        $this->assertEquals(
            current( $employers ),
            current( $this->session->getRelatedObjects( $person, 'RelationTestEmployer' ) )
        );

        $addresses = $this->idMap->getRelatedObjects(
            $person, 'RelationTestAddress'
        );
        
        $this->assertNotNull( $addresses );

        $this->assertEquals( 3, count( $addresses ) );

        $this->assertEquals(
            current( $addresses ),
            current( $this->session->getRelatedObjects( $person, 'RelationTestAddress' ) )
        );
    }

    public function testMultiLevelSingleRelation()
    {
        $relations = $this->getMultiLevelSingleRelationRelations();
        $q         = $this->getMultiLevelSingleRelationQuery( $relations );
        
        $stmt = $q->prepare();
        $stmt->execute();

        // Actual test
        $this->extractor->extractObjects(
            $stmt, 'RelationTestPerson', 2, $relations
        );

        $person = $this->idMap->getIdentity( 'RelationTestPerson', 2 );
        $this->assertNotNull( $person );
        $this->assertEquals(
            $this->session->load( 'RelationTestPerson', 2 ),
            $person
        );

        $addresses = $this->idMap->getRelatedObjects(
            $person, 'RelationTestAddress'
        );
        
        $this->assertNotNull( $addresses );

        $this->assertEquals( 3, count( $addresses ) );
        
        $realAddresses = $this->session->getRelatedObjects( $person, 'RelationTestAddress' );

        $this->assertObjectSetsEqual( $realAddresses, $addresses );

        foreach ( $addresses as $address )
        {
            $persons = $this->idMap->getRelatedObjects(
                $address, 'RelationTestPerson'
            );

            $this->assertNotNull( $persons );

            $realPersons = $this->session->getRelatedObjects(
                $address, 'RelationTestPerson'
            );

            $this->assertObjectSetsEqual( $realPersons, $persons );
        }
    }

    public function testMultiLevelMultiRelation()
    {
        $relations = $this->getMultiLevelMultiRelationRelations();
        $q         = $this->getMultiLevelMultiRelationQuery( $relations );
        
        $stmt = $q->prepare();
        $stmt->execute();

        // Actual test
        $this->extractor->extractObjects(
            $stmt, 'RelationTestPerson', 2, $relations
        );

        $person = $this->idMap->getIdentity( 'RelationTestPerson', 2 );
        $this->assertNotNull( $person );
        $this->assertEquals(
            $this->session->load( 'RelationTestPerson', 2 ),
            $person
        );

        $addresses = $this->idMap->getRelatedObjects(
            $person, 'RelationTestAddress'
        );
        
        $this->assertNotNull( $addresses );

        $this->assertEquals( 3, count( $addresses ) );
        
        $realAddresses = $this->session->getRelatedObjects( $person, 'RelationTestAddress' );

        $this->assertObjectSetsEqual( $realAddresses, $addresses );

        foreach ( $addresses as $address )
        {
            $persons = $this->idMap->getRelatedObjects(
                $address, 'RelationTestPerson'
            );

            $this->assertNotNull( $persons );

            $realPersons = $this->session->getRelatedObjects(
                $address, 'RelationTestPerson'
            );

            $this->assertObjectSetsEqual( $realPersons, $persons );

            foreach ( $persons as $relPerson )
            {
                $employers = $this->idMap->getRelatedObjects( $relPerson, 'RelationTestEmployer' );
                $this->assertNotNull( $employers );
                $realEmployers = $this->session->getRelatedObjects( $relPerson, 'RelationTestEmployer' );
                $this->assertObjectSetsEqual( $realEmployers, $employers );

                $birthdays = $this->idMap->getRelatedObjects( $relPerson, 'RelationTestBirthday' );

                if ( $relPerson->id == 3 )
                {
                    // Person with ID 3 has no birthday assigned
                    $this->assertNull( $birthdays );
                }
                else
                {
                    $this->assertNotNull( $birthdays );
                    $realBirthdays = $this->session->getRelatedObjects( $relPerson, 'RelationTestBirthday' );
                    $this->assertObjectSetsEqual( $realBirthdays, $birthdays );
                }
            }
        }

        $employers = $this->idMap->getRelatedObjects( $person, 'RelationTestEmployer' );
        $this->assertNotNull( $employers );
        $realEmployers = $this->session->getRelatedObjects( $person, 'RelationTestEmployer' );
        $this->assertObjectSetsEqual( $realEmployers, $employers );

        $birthdays = $this->idMap->getRelatedObjects( $person, 'RelationTestBirthday' );
        $this->assertNotNull( $birthdays );
        $realBirthdays = $this->session->getRelatedObjects( $person, 'RelationTestBirthday' );
        $this->assertObjectSetsEqual( $realBirthdays, $birthdays );
    }

    protected function assertObjectSetsEqual( $realObjects, $identityObjects )
    {
        reset( $identityObjects );
        reset( $realObjects );

        do
        {
            $this->assertEquals(
                current( $realObjects ),
                current( $identityObjects ),
                'Object set differs.'
            );
            next( $identityObjects );
            next( $realObjects );
        } while ( current( $realObjects ) !== false && current( $identityObjects ) !== false );

        $this->assertFalse(
            current( $realObjects ),
            'Real object set has more elements than identity object set.'
        );
        $this->assertFalse(
            current( $identityObjects ),
            'Identity object set has more elements than real object set.'
        );
    }
}

?>
