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

    protected $options;

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

        $this->options   =  new ezcPersistentIdentitySessionOptions();
        $this->extractor = new ezcPersistentIdentityRelationObjectExtractor(
            $this->idMap,
            $this->defManager,
            $this->options
        );
    }

    public function teardown()
    {
        RelationTestEmployer::cleanup( $this->db );
    }

    public function testLoadOneLevelOneRelation()
    {
        $relations = $this->getOneLevelOneRelationRelations();
        $q         = $this->getLoadQuery( $relations );
        
        $stmt = $q->prepare();
        $stmt->execute();

        // Actual test
        $this->extractor->extractObjectWithRelatedObjects(
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

    public function testFindOneLevelOneRelationNoRestrictions()
    {
        $relations = $this->getOneLevelOneRelationRelations();
        $q         = $this->getFindQuery( $relations );
        
        $stmt = $q->prepare();
        $stmt->execute();


        // Actual test
        $persons = $this->extractor->extractObjectsWithRelatedObjects(
            $stmt, $q, $relations
        );

        $fakeFind = $this->session->createFindQuery( 'RelationTestPerson' );
        $fakeRes = $this->session->find( $fakeFind );

        $this->assertEquals(
            $fakeRes,
            $persons,
            'Returned extracted object set incorrect.'
        );

        foreach ( $persons as $person )
        {
            $this->assertEquals(
                $this->session->getRelatedObjects( $person, 'RelationTestEmployer' ),
                $this->idMap->getRelatedObjects( $person, 'RelationTestEmployer' )
            );
        }
    }

    public function testFindOneLevelOneRelationRestrictions()
    {
        $relations = $this->getOneLevelOneRelationRelations();
        $q         = $this->getFindQuery( $relations );
        $q->where(
            $q->expr->like(
                $this->qi( 'employer' ) . '.' . $this->qi( 'name' ),
                $q->bindValue( '%Web%' )
            )
        );
        
        $stmt = $q->prepare();
        $stmt->execute();


        // Actual test
        $persons = $this->extractor->extractObjectsWithRelatedObjects(
            $stmt, $q, $relations
        );

        $fakeFind = $this->session->createFindQuery( 'RelationTestPerson' );
        $fakeRes = $this->session->find( $fakeFind );

        $this->assertEquals(
            $fakeRes,
            $persons,
            'Returned extracted object set incorrect.'
        );

        foreach ( $persons as $person )
        {
            $this->assertNull(
                $this->idMap->getRelatedObjects( $person, 'RelationTestEmployer' )
            );
            $this->assertNotNull(
                $this->idMap->getRelatedObjectSet( $person, 'employer' )
            );
        }
    }

    public function testNamedSetNotOverwritten()
    {
        // Create fake named related set
        $person = $this->session->load( 'RelationTestPerson', 2 );
        $this->idMap->setIdentity( $person );

        $birthday = new RelationTestBirthday();
        $birthday->person = 2;
        $relatedObjectSet = array(
            '2' => $birthday
        );

        $this->idMap->setRelatedObjectSet(
            $person, $relatedObjectSet, 'foo'
        );

        // Perform query and extraction
        $relations = $this->getOneLevelOneRelationRelations();
        $q         = $this->getLoadQuery( $relations );
        
        $stmt = $q->prepare();
        $stmt->execute();

        $this->extractor->extractObjectWithRelatedObjects(
            $stmt, 'RelationTestPerson', 2, $relations
        );

        $this->assertSame(
            $person,
            $this->idMap->getIdentity( 'RelationTestPerson', 2 )
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

        
        $this->assertEquals(
            $relatedObjectSet,
            $this->idMap->getRelatedObjectSet( $person, 'foo' )    
        );
    }

    public function testNoRefetch()
    {
        $relations = $this->getOneLevelOneRelationRelations();
        $q         = $this->getLoadQuery( $relations );
        
        $stmt = $q->prepare();
        $stmt->execute();

        $this->extractor->extractObjectWithRelatedObjects(
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

        // $this->options->refetch = true;

        $relations = $this->getOneLevelOneRelationRelations();
        $q         = $this->getLoadQuery( $relations );
        
        $stmt = $q->prepare();
        $stmt->execute();

        $this->extractor->extractObjectWithRelatedObjects(
            $stmt, 'RelationTestPerson', 2, $relations
        );

        $secPerson = $this->idMap->getIdentity( 'RelationTestPerson', 2 );
        $this->assertNotNull( $secPerson );
        $this->assertEquals(
            $this->session->load( 'RelationTestPerson', 2 ),
            $secPerson
        );

        $this->assertSame( $person, $secPerson );

        $secEmployers = $this->idMap->getRelatedObjects(
            $secPerson, 'RelationTestEmployer'
        );
        
        $this->assertNotNull( $secEmployers );

        $this->assertEquals( 1, count( $secEmployers ) );

        $this->assertEquals(
            current( $secEmployers ),
            current( $this->session->getRelatedObjects( $secPerson, 'RelationTestEmployer' ) )
        );

        foreach ( $employers as $id => $employer )
        {
            $this->assertSame(
                $employer,
                $secEmployers[$id]
            );
        }
    }

    public function testRefetch()
    {
        $relations = $this->getOneLevelOneRelationRelations();
        $q         = $this->getLoadQuery( $relations );
        
        $stmt = $q->prepare();
        $stmt->execute();

        $this->extractor->extractObjectWithRelatedObjects(
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

        $this->options->refetch = true;

        $relations = $this->getOneLevelOneRelationRelations();
        $q         = $this->getLoadQuery( $relations );
        
        $stmt = $q->prepare();
        $stmt->execute();

        $this->extractor->extractObjectWithRelatedObjects(
            $stmt, 'RelationTestPerson', 2, $relations
        );

        $secPerson = $this->idMap->getIdentity( 'RelationTestPerson', 2 );
        $this->assertNotNull( $secPerson );
        $this->assertEquals(
            $this->session->load( 'RelationTestPerson', 2 ),
            $secPerson
        );

        $this->assertNotSame( $person, $secPerson );

        $secEmployers = $this->idMap->getRelatedObjects(
            $secPerson, 'RelationTestEmployer'
        );
        
        $this->assertNotNull( $secEmployers );

        $this->assertEquals( 1, count( $secEmployers ) );

        $this->assertEquals(
            current( $secEmployers ),
            current( $this->session->getRelatedObjects( $secPerson, 'RelationTestEmployer' ) )
        );

        foreach ( $employers as $id => $employer )
        {
            $this->assertNotSame(
                $employer,
                $secEmployers[$id]
            );
        }
    }

    public function testLoadOneLevelMultiRelation()
    {
        $relations = $this->getOneLevelMultiRelationRelations();
        $q         = $this->getLoadQuery( $relations );
        
        $stmt = $q->prepare();
        $stmt->execute();

        // Actual test
        $this->extractor->extractObjectWithRelatedObjects(
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

    public function testFindOneLevelMultiRelationNoRestrictions()
    {
        $relations = $this->getOneLevelMultiRelationRelations();
        $q         = $this->getFindQuery( $relations );
        
        $stmt = $q->prepare();
        $stmt->execute();

        // Actual test
        $persons = $this->extractor->extractObjectsWithRelatedObjects(
            $stmt, $q, $relations
        );

        $fakeFind = $this->session->createFindQuery( 'RelationTestPerson' );
        $fakeRes = $this->session->find( $fakeFind );

        $this->assertEquals(
            $fakeRes,
            $persons,
            'Returned extracted object set incorrect.'
        );

        foreach ( $persons as $person )
        {
            $this->assertEquals(
                $this->session->getRelatedObjects( $person, 'RelationTestEmployer' ),
                $this->idMap->getRelatedObjects( $person, 'RelationTestEmployer' )
            );
            $this->assertEquals(
                $this->session->getRelatedObjects( $person, 'RelationTestAddress' ),
                $this->idMap->getRelatedObjects( $person, 'RelationTestAddress' )
            );
        }
    }

    public function testFindOneLevelMultiRelationRestrictions()
    {
        $relations = $this->getOneLevelMultiRelationRelations();
        $q         = $this->getFindQuery( $relations );

        $q->where(
            $q->expr->like(
                $this->qi( 'employer' ) . '.' . $this->qi( 'name' ),
                $q->bindValue( '%Web%' )
            )
        );
        
        $stmt = $q->prepare();
        $stmt->execute();

        // Actual test
        $persons = $this->extractor->extractObjectsWithRelatedObjects(
            $stmt, $q, $relations
        );

        $fakeFind = $this->session->createFindQuery( 'RelationTestPerson' );
        $fakeRes = $this->session->find( $fakeFind );

        $this->assertEquals(
            $fakeRes,
            $persons,
            'Returned extracted object set incorrect.'
        );

        foreach ( $persons as $person )
        {
            $this->assertNull(
                $this->idMap->getRelatedObjects( $person, 'RelationTestEmployer' )
            );
            $this->assertNotNull(
                $this->idMap->getRelatedObjectSet( $person, 'employer' )
            );
            $this->assertNull(
                $this->idMap->getRelatedObjects( $person, 'RelationTestAddress' )
            );
            $this->assertEquals(
                $this->session->getRelatedObjects( $person, 'RelationTestAddress' ),
                $this->idMap->getRelatedObjectSet( $person, 'address' )
            );
        }
    }

    public function testLoadMultiLevelSingleRelation()
    {
        $relations = $this->getMultiLevelSingleRelationRelations();
        $q         = $this->getLoadQuery( $relations );
        
        $stmt = $q->prepare();
        $stmt->execute();

        // Actual test
        $this->extractor->extractObjectWithRelatedObjects(
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

        $this->assertEquals( $realAddresses, $addresses );

        foreach ( $addresses as $address )
        {
            $persons = $this->idMap->getRelatedObjects(
                $address, 'RelationTestPerson'
            );

            $this->assertNotNull( $persons );

            $realPersons = $this->session->getRelatedObjects(
                $address, 'RelationTestPerson'
            );

            $this->assertEquals( $realPersons, $persons );
        }
    }

    public function testFindMultiLevelSingleRelationNoRestrictions()
    {
        $relations = $this->getMultiLevelSingleRelationRelations();
        $q         = $this->getFindQuery( $relations );
        
        $stmt = $q->prepare();
        $stmt->execute();

        // Actual test
        $persons = $this->extractor->extractObjectsWithRelatedObjects(
            $stmt, $q, $relations
        );

        $fakeFind = $this->session->createFindQuery( 'RelationTestPerson' );
        $fakeRes = $this->session->find( $fakeFind );

        $this->assertEquals(
            $fakeRes,
            $persons,
            'Returned extracted object set incorrect.'
        );

        foreach ( $persons as $person )
        {
            $addresses = $this->idMap->getRelatedObjects( $person, 'RelationTestAddress' );
            $this->assertEquals(
                $this->session->getRelatedObjects( $person, 'RelationTestAddress' ),
                $addresses
            );
            foreach( $addresses as $address )
            {
                $this->assertEquals(
                    $this->session->getRelatedObjects( $address, 'RelationTestPerson' ),
                    $this->idMap->getRelatedObjects( $address, 'RelationTestPerson' )
                );
            }
        }
    }

    public function testFindMultiLevelSingleRelationRestrictions()
    {
        $relations = $this->getMultiLevelSingleRelationRelations();
        $q         = $this->getFindQuery( $relations );

        $q->where(
            $q->expr->gt(
                $this->qi( 'addresses' ) . '.' . $this->qi( 'id' ),
                $q->bindValue( 2 )
            )
        );
        
        $stmt = $q->prepare();
        $stmt->execute();

        // Actual test
        $persons = $this->extractor->extractObjectsWithRelatedObjects(
            $stmt, $q, $relations
        );

        $fakeFind = $this->session->createFindQuery( 'RelationTestPerson' );
        $fakeRes = $this->session->find( $fakeFind );

        $this->assertEquals(
            $fakeRes,
            $persons,
            'Returned extracted object set incorrect.'
        );

        foreach ( $persons as $person )
        {
            $this->assertNull(
                $this->idMap->getRelatedObjects( $person, 'RelationTestAddress' )
            );
            $addresses = $this->idMap->getRelatedObjectSet( $person, 'addresses' );
            $this->assertNotNull( $addresses );
            foreach( $addresses as $address )
            {
                $this->assertNull( $this->idMap->getRelatedObjects( $address, 'RelationTestPerson' ) );
                $this->assertEquals(
                    $this->session->getRelatedObjects( $address, 'RelationTestPerson' ),
                    $this->idMap->getRelatedObjectSet( $address, 'habitants' )
                );
            }
        }
    }

    public function testLoadMultiLevelMultiRelation()
    {
        $relations = $this->getMultiLevelMultiRelationRelations();
        $q         = $this->getLoadQuery( $relations );
        
        $stmt = $q->prepare();
        $stmt->execute();

        // Actual test
        $this->extractor->extractObjectWithRelatedObjects(
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

        $this->assertEquals( $realAddresses, $addresses );

        foreach ( $addresses as $address )
        {
            $persons = $this->idMap->getRelatedObjects(
                $address, 'RelationTestPerson'
            );

            $this->assertNotNull( $persons );

            $realPersons = $this->session->getRelatedObjects(
                $address, 'RelationTestPerson'
            );

            $this->assertEquals( $realPersons, $persons );

            foreach ( $persons as $relPerson )
            {
                $employers = $this->idMap->getRelatedObjects( $relPerson, 'RelationTestEmployer' );
                $this->assertNotNull( $employers );
                $realEmployers = $this->session->getRelatedObjects( $relPerson, 'RelationTestEmployer' );
                $this->assertEquals( $realEmployers, $employers );

                $birthdays = $this->idMap->getRelatedObjects( $relPerson, 'RelationTestBirthday' );

                if ( $relPerson->id == 3 )
                {
                    // Person with ID 3 has no birthday assigned
                    $this->assertEquals( array(), $birthdays );
                }
                else
                {
                    $this->assertNotNull( $birthdays );
                    $realBirthdays = $this->session->getRelatedObjects( $relPerson, 'RelationTestBirthday' );
                    $this->assertEquals( $realBirthdays, $birthdays );
                }
            }
        }

        $employers = $this->idMap->getRelatedObjects( $person, 'RelationTestEmployer' );
        $this->assertNotNull( $employers );
        $realEmployers = $this->session->getRelatedObjects( $person, 'RelationTestEmployer' );
        $this->assertEquals( $realEmployers, $employers );

        $birthdays = $this->idMap->getRelatedObjects( $person, 'RelationTestBirthday' );
        $this->assertNotNull( $birthdays );
        $realBirthdays = $this->session->getRelatedObjects( $person, 'RelationTestBirthday' );
        $this->assertEquals( $realBirthdays, $birthdays );
    }

    public function testFindMultiLevelMultiRelationNoRestrictions()
    {
        $relations = $this->getMultiLevelMultiRelationRelations();
        $q         = $this->getFindQuery( $relations );
        
        $stmt = $q->prepare();
        $stmt->execute();

        // Actual test
        $persons = $this->extractor->extractObjectsWithRelatedObjects(
            $stmt, $q, $relations
        );

        $fakeFind = $this->session->createFindQuery( 'RelationTestPerson' );
        $fakeRes = $this->session->find( $fakeFind );

        $this->assertEquals(
            $fakeRes,
            $persons,
            'Returned extracted object set incorrect.'
        );

        foreach ( $persons as $person )
        {
            $addresses = $this->idMap->getRelatedObjects( $person, 'RelationTestAddress' );
            $this->assertEquals(
                $this->session->getRelatedObjects( $person, 'RelationTestAddress' ),
                $addresses
            );
            foreach ( $addresses as $address )
            {
                $habitants = $this->idMap->getRelatedObjects( $address, 'RelationTestPerson' );
                $this->assertEquals(
                    $this->session->getRelatedObjects( $address, 'RelationTestPerson' ),
                    $habitants
                );
                foreach ( $habitants as $habitant )
                {
                    $habitantEmployers = $this->idMap->getRelatedObjects( $habitant, 'RelationTestEmployer' );
                    $this->assertEquals(
                        $this->session->getRelatedObjects( $habitant, 'RelationTestEmployer' ),
                        $habitantEmployers
                    );
                    $habitantBirthdays = $this->idMap->getRelatedObjects( $habitant, 'RelationTestBirthday' );
                    $this->assertEquals(
                        $this->session->getRelatedObjects( $habitant, 'RelationTestBirthday' ),
                        $habitantBirthdays
                    );
                }
            }
            $this->assertEquals(
                $this->session->getRelatedObjects( $person, 'RelationTestEmployer' ),
                $this->idMap->getRelatedObjects( $person, 'RelationTestEmployer' )
            );
            $this->assertEquals(
                $this->session->getRelatedObjects( $person, 'RelationTestBirthday' ),
                $this->idMap->getRelatedObjects( $person, 'RelationTestBirthday' )
            );
        }
    }

    public function testFindMultiLevelMultiRelationRestrictions()
    {
        $relations = $this->getMultiLevelMultiRelationRelations();
        $q         = $this->getFindQuery( $relations );

        $q->where(
            $q->expr->like(
                $this->qi( 'habitant_employer' ) . '.' . $this->qi( 'name' ),
                $q->bindValue( '%Web%' )
            ),
            $q->expr->lt( 
                $this->qi( 'birthday' ) . '.' . $this->qi( 'birthday' ),
                $q->bindValue( 0 )
           )
        );
        
        $stmt = $q->prepare();
        $stmt->execute();

        // Actual test
        $persons = $this->extractor->extractObjectsWithRelatedObjects(
            $stmt, $q, $relations
        );

        $fakeFind = $this->session->createFindQuery( 'RelationTestPerson' );
        $fakeFind->where(
            $fakeFind->expr->eq(
                'id',
                $fakeFind->bindValue( 2 )
            )
        );
        $fakeRes = $this->session->find( $fakeFind );

        $this->assertEquals(
            $fakeRes,
            $persons,
            'Returned extracted object set incorrect.'
        );

        foreach ( $persons as $person )
        {
            $this->assertNull( $this->idMap->getRelatedObjects( $person, 'RelationTestAddress' ) );
            $addresses = $this->idMap->getRelatedObjectSet( $person, 'addresses' );
            $this->assertEquals(
                $this->session->getRelatedObjects( $person, 'RelationTestAddress' ),
                $addresses
            );
            foreach ( $addresses as $address )
            {
                $this->assertNull( $this->idMap->getRelatedObjects( $address, 'RelationTestPerson' ) );
                $habitants = $this->idMap->getRelatedObjectSet( $address, 'habitants' );
                $this->assertEquals(
                    $this->session->getRelatedObjects( $address, 'RelationTestPerson' ),
                    $habitants
                );
                foreach ( $habitants as $habitant )
                {
                    $this->assertNull(
                        $this->idMap->getRelatedObjects( $habitant, 'RelationTestEmployer' )
                    );
                    $habitantEmployers = $this->idMap->getRelatedObjectSet( $habitant, 'habitant_employer' );
                    $this->assertNotNull(
                        $habitantEmployers
                    );
                    $this->assertNull( $this->idMap->getRelatedObjects( $habitant, 'RelationTestBirthday' ) );
                    $habitantBirthdays = $this->idMap->getRelatedObjectSet( $habitant, 'habitant_birthday' );
                    $this->assertEquals(
                        $this->session->getRelatedObjects( $habitant, 'RelationTestBirthday' ),
                        $habitantBirthdays
                    );
                }
            }
            $this->assertNull( $this->idMap->getRelatedObjects( $person, 'RelationTestEmployer' ) );
            $this->assertEquals(
                $this->session->getRelatedObjects( $person, 'RelationTestEmployer' ),
                $this->idMap->getRelatedObjectSet( $person, 'employer' )
            );
            $this->assertNull(
                $this->idMap->getRelatedObjects( $person, 'RelationTestBirthday' )
            );
            $this->assertNotNull(
                $this->idMap->getRelatedObjectSet( $person, 'birthday' )
            );
        }
    }

}

?>
