<?php
/**
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package PersistentObject
 * @subpackage Tests
 */

require_once dirname( __FILE__ ) . "/../data/relation_test_employer.php";
require_once dirname( __FILE__ ) . "/../data/relation_test_person.php";
require_once dirname( __FILE__ ) . "/../data/relation_test_address.php";

/**
 * Tests ezcPersistentManyToOneRelation class.
 *
 * @package PersistentObject
 * @subpackage Tests
 */
class ezcPersistentSessionIdentityDecoratorRelationTest extends ezcTestCase
{
    protected $session;

    protected $idSession;

    protected $idMap;

    public static function suite()
    {
        return new PHPUnit_Framework_TestSuite( __CLASS__ );
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

        $this->idMap = new ezcPersistentBasicIdentityMap(
            $this->session->definitionManager
        );

        $this->idSession = new ezcPersistentSessionIdentityDecorator(
            $this->session,
            $this->idMap
        );
    }

    public function teardown()
    {
        RelationTestEmployer::cleanup();
    }
    
    // Tests using the actual relation definition

    public function testGetRelatedObjectsEmployer1()
    {
        $person = $this->idSession->load( "RelationTestPerson", 1 );

        $related1 = $this->idSession->getRelatedObjects( $person, "RelationTestEmployer" );
        
        $this->assertEquals(
            1,
            count( $related1 ),
            "Related RelationTestPerson objects not fetched correctly."
        );

        $related2 = $this->idSession->getRelatedObjects( $person, "RelationTestEmployer" );

        foreach ( $related1 as $id => $relObj )
        {
            $this->assertSame(
                $relObj,
                $related2[$id],
                'Object in second load not the same not.'
            );
        }
        foreach ( $related2 as $id => $relObj )
        {
            $this->assertSame(
                $relObj,
                $related1[$id],
                'Object in first load not the same not.'
            );
        }
    }

    public function testGetRelatedObjectsEmployer1Refetch()
    {
        $person = $this->idSession->load( "RelationTestPerson", 1 );

        $related1 = $this->idSession->getRelatedObjects( $person, "RelationTestEmployer" );
        
        $this->assertEquals(
            1,
            count( $related1 ),
            "Related RelationTestPerson objects not fetched correctly."
        );

        // Refetch
        $this->idSession->options->refetch = true;

        $related2 = $this->idSession->getRelatedObjects( $person, "RelationTestEmployer" );

        foreach ( $related1 as $id => $relObj )
        {
            $this->assertNotSame(
                $relObj,
                $related2[$id],
                'Object in second load not the same not.'
            );
            $this->assertEquals(
                $relObj,
                $related2[$id],
                'Object in second load not the same not.'
            );
        }
        foreach ( $related2 as $id => $relObj )
        {
            $this->assertNotSame(
                $relObj,
                $related1[$id],
                'Object in first load not the same not.'
            );
            $this->assertEquals(
                $relObj,
                $related1[$id],
                'Object in first load not the same not.'
            );
        }
    }

    public function testGetRelatedObjectEmployer1()
    {
        $person = $this->idSession->load( "RelationTestPerson", 1 );
        $employer1 = $this->idSession->getRelatedObject( $person, "RelationTestEmployer" );
        $employer2 = $this->idSession->getRelatedObject( $person, "RelationTestEmployer" );

        $this->assertSame( $employer1, $employer2 );
    }

    public function testGetRelatedObjectEmployer1Refetch()
    {
        $person = $this->idSession->load( "RelationTestPerson", 1 );
        $employer1 = $this->idSession->getRelatedObject( $person, "RelationTestEmployer" );

        // Refetch
        $this->idSession->options->refetch = true;

        $employer2 = $this->idSession->getRelatedObject( $person, "RelationTestEmployer" );

        $this->assertNotSame( $employer1, $employer2 );
        $this->assertEquals( $employer1, $employer2 );
    }

    public function testAddRelatedObjectEmployerFailureReverse()
    {
        $person = $this->idSession->load( "RelationTestPerson", 2 );
        $employer = $this->idSession->load( "RelationTestEmployer", 2 );

        try
        {
            $this->idSession->addRelatedObject( $person, $employer );
            $this->fail( "Exception not thrown on adding a new relation that is marked as reverse." );
        }
        catch ( ezcPersistentRelationOperationNotSupportedException $e ) {}

        // New relation not reflected in identity map
        $employers = $this->idSession->getRelatedObjects( $person, 'RelationTestEmployer' );
        foreach( $employers as $relEmpl )
        {
            $this->assertNotSame(
                $employer,
                $relEmpl
            );
        }
        $persons = $this->idSession->getRelatedObjects( $employer, 'RelationTestPerson' );
        foreach ( $persons as $relPer )
        {
            $this->assertNotSame(
                $person,
                $relPer
            );
        }
    }

    public function testRelatedObjectsIdentityLoadedBefore()
    {
        $person = $this->idSession->load( 'RelationTestPerson', 1 );
        $address = $this->idSession->load( 'RelationTestAddress', 2 );

        $addresses = $this->idSession->getRelatedObjects( $person, 'RelationTestAddress' );

        $found = false;
        foreach ( $addresses as $relAddress )
        {
            if ( $address === $relAddress )
            {
                $found = true;
                break;
            }
        }
        $this->assertTrue( $found );
    }

    public function testRelatedObjectsIdentityLoadedBeforeRefetch()
    {
        $person = $this->idSession->load( 'RelationTestPerson', 1 );
        $address = $this->idSession->load( 'RelationTestAddress', 2 );

        // Refetch
        $this->idSession->options->refetch = true;

        $addresses = $this->idSession->getRelatedObjects( $person, 'RelationTestAddress' );

        $found = false;
        foreach ( $addresses as $relAddress )
        {
            if ( $address == $relAddress )
            {
                $this->assertNotSame(
                    $address,
                    $relAddress
                );
                $found = true;
                break;
            }
        }
        $this->assertTrue( $found );
    }
    
    public function testRelatedObjectsIdentityFetchedBefore()
    {
        $person1 = $this->idSession->load( 'RelationTestPerson', 1 );
        $person2 = $this->idSession->load( 'RelationTestPerson', 2 );

        $addresses1 = $this->idSession->getRelatedObjects( $person1, 'RelationTestAddress' );
        $addresses2 = $this->idSession->getRelatedObjects( $person2, 'RelationTestAddress' );

        $found = 0;
        foreach ( $addresses1 as $id => $relAddr )
        {
            if ( isset( $addresses2[$id] ) )
            {
                ++$found;
                $this->assertSame(
                    $relAddr,
                    $addresses2[$id]
                );
            }
        }
        $this->assertEquals( 2, $found );
    }
    
    public function testRelatedObjectsIdentityFetchedBeforeRefetch()
    {
        $person1 = $this->idSession->load( 'RelationTestPerson', 1 );
        $person2 = $this->idSession->load( 'RelationTestPerson', 2 );

        $addresses1 = $this->idSession->getRelatedObjects( $person1, 'RelationTestAddress' );

        // Refetch
        $this->idSession->options->refetch = true;

        $addresses2 = $this->idSession->getRelatedObjects( $person2, 'RelationTestAddress' );

        $found = 0;
        foreach ( $addresses1 as $id => $relAddr )
        {
            if ( isset( $addresses2[$id] ) )
            {
                ++$found;
                $this->assertNotSame(
                    $relAddr,
                    $addresses2[$id]
                );
            }
        }
        $this->assertEquals( 2, $found );
    }

    public function testAddRelatedObjectReflectedInIdentityMap()
    {
        $person = $this->idSession->load( 'RelationTestPerson', 1 );
        $addressesBefore = $this->idSession->getRelatedObjects( $person, 'RelationTestAddress' );

        $newRelAddress = $this->idSession->load( 'RelationTestAddress', 3 );
        $addressesBefore[$newRelAddress->id] = $newRelAddress;

        $this->idSession->addRelatedObject( $person, $newRelAddress );

        $addressesAfter = $this->idSession->getRelatedObjects( $person, 'RelationTestAddress' );

        foreach ( $addressesBefore as $id => $relAddress )
        {
            $this->assertSame( $relAddress, $addressesAfter[$id] );
        }
    }

    public function testRemoveRelatedObjectReflectedInIdentityMap()
    {
        $person = $this->idSession->load( 'RelationTestPerson', 1 );
        $addressesBefore = $this->idSession->getRelatedObjects( $person, 'RelationTestAddress' );

        reset( $addressesBefore );

        $firstKey = key( $addressesBefore );
        $firstObj = current( $addressesBefore );

        $this->idSession->removeRelatedObject( $person, $firstObj );

        $addressesAfter = $this->idSession->getRelatedObjects( $person, 'RelationTestAddress' );

        foreach ( $addressesAfter as $key => $obj )
        {
            $this->assertNotSame( $firstKey, $key );
            $this->assertNotSame( $firstObj, $obj );
        }
    }

    public function testLoadWithRelatedObjectsOnce()
    {
        // @TODO: This is currently needed to fix the attribute set in
        // ezcDbHandler. Should be removed as soon as this is fixed!
        $this->session->database->setAttribute( PDO::ATTR_CASE, PDO::CASE_NATURAL );

        $person = $this->idSession->loadWithRelatedObjects(
            'RelationTestPerson',
            2,
            array(
                new ezcPersistentRelationFindDefinition(
                    'RelationTestEmployer'
                ),
                new ezcPersistentRelationFindDefinition(
                    'RelationTestAddress'
                ),
            )
        );

        $this->assertEquals(
            2,
            $person->id
        );
        $this->assertNotNull(
            $person->firstname
        );
        $this->assertNotNull(
            $person->surname
        );

        $this->assertNotNull(
            $this->idMap->getRelatedObjects( $person, 'RelationTestEmployer' )
        );

        $this->assertNotNull(
            $this->idMap->getRelatedObjects( $person, 'RelationTestAddress' )
        );
    }

    public function testLoadWithRelatedObjectsTwice()
    {
        // @TODO: This is currently needed to fix the attribute set in
        // ezcDbHandler. Should be removed as soon as this is fixed!
        $this->session->database->setAttribute( PDO::ATTR_CASE, PDO::CASE_NATURAL );

        $firstPerson = $this->idSession->loadWithRelatedObjects(
            'RelationTestPerson',
            2,
            array(
                new ezcPersistentRelationFindDefinition(
                    'RelationTestEmployer'
                ),
                new ezcPersistentRelationFindDefinition(
                    'RelationTestAddress'
                ),
            )
        );

        $firstEmployers = $this->idSession->getRelatedObjects( $firstPerson, 'RelationTestEmployer' );
        $firstAddresses = $this->idSession->getRelatedObjects( $firstPerson, 'RelationTestAddress' );

        $secondPerson = $this->idSession->loadWithRelatedObjects(
            'RelationTestPerson',
            2,
            array(
                new ezcPersistentRelationFindDefinition(
                    'RelationTestEmployer'
                ),
                new ezcPersistentRelationFindDefinition(
                    'RelationTestAddress'
                ),
            )
        );

        $secondEmployers = $this->idSession->getRelatedObjects( $secondPerson, 'RelationTestEmployer' );
        $secondAddresses = $this->idSession->getRelatedObjects( $secondPerson, 'RelationTestAddress' );

        $this->assertSame( $firstPerson, $secondPerson );

        foreach ( $firstEmployers as $id => $employer )
        {
            $this->assertSame(
                $employer,
                $secondEmployers[$id]
            );
        }

        foreach ( $firstAddresses as $id => $address )
        {
            $this->assertSame(
                $address,
                $secondAddresses[$id]
            );
        }
    }

    public function testCreateRelationFindQueryNoSetName()
    {
        // @TODO: This is currently needed to fix the attribute set in
        // ezcDbHandler. Should be removed as soon as this is fixed!
        $this->session->database->setAttribute( PDO::ATTR_CASE, PDO::CASE_NATURAL );
        
        $person = $this->idSession->load( 'RelationTestPerson', 1 );

        $q = $this->idSession->createRelationFindQuery( $person, 'RelationTestAddress' );

        $this->assertNull(
            $q->relationSetName
        );
        $this->assertNull(
            $q->relationSource
        );
    }

    public function testCreateRelationFindQueryWithSetName()
    {
        // @TODO: This is currently needed to fix the attribute set in
        // ezcDbHandler. Should be removed as soon as this is fixed!
        $this->session->database->setAttribute( PDO::ATTR_CASE, PDO::CASE_NATURAL );
        
        $person = $this->idSession->load( 'RelationTestPerson', 1 );

        $q = $this->idSession->createRelationFindQuery(
            $person,
            'RelationTestAddress',
            null,
            'some set name'
        );

        $this->assertEquals(
            'some set name',
            $q->relationSetName
        );
        $this->assertSame(
            $person,
            $q->relationSource
        );
    }

    public function testFindRelatedObjectsWithoutSetName()
    {
        // @TODO: This is currently needed to fix the attribute set in
        // ezcDbHandler. Should be removed as soon as this is fixed!
        $this->session->database->setAttribute( PDO::ATTR_CASE, PDO::CASE_NATURAL );
        
        $person = $this->idSession->load( 'RelationTestPerson', 1 );

        $q = $this->idSession->createRelationFindQuery( $person, 'RelationTestAddress' );

        $addresses = $this->idSession->find( $q );

        $this->assertNull(
            $this->idMap->getRelatedObjects( $person, 'RelationTestAddress' )
        );
    }

    public function testFindRelatedObjectsWithSetName()
    {
        // @TODO: This is currently needed to fix the attribute set in
        // ezcDbHandler. Should be removed as soon as this is fixed!
        $this->session->database->setAttribute( PDO::ATTR_CASE, PDO::CASE_NATURAL );
        
        $person = $this->idSession->load( 'RelationTestPerson', 1 );

        $q = $this->idSession->createRelationFindQuery(
            $person,
            'RelationTestAddress',
            null,
            'foobar'
        );

        $addresses = $this->idSession->find( $q );

        $this->assertNotNull(
            $this->idMap->getRelatedObjectSet( $person, 'foobar' )
        );
    }

    public function testFindRelatedObjectsWithSetNameRefetch()
    {
        // @TODO: This is currently needed to fix the attribute set in
        // ezcDbHandler. Should be removed as soon as this is fixed!
        $this->session->database->setAttribute( PDO::ATTR_CASE, PDO::CASE_NATURAL );
        
        $person = $this->idSession->load( 'RelationTestPerson', 1 );

        $q = $this->idSession->createRelationFindQuery(
            $person,
            'RelationTestAddress',
            null,
            'foobar'
        );

        $addresses1 = $this->idSession->find( $q );

        $this->idSession->options->refetch = true;

        $addresses2 = $this->idSession->find( $q );

        foreach( $addresses1 as $key => $origObj )
        {
            $this->assertNotSame(
                $origObj,
                $addresses2[$key]
            );
            $this->assertEquals(
                $origObj,
                $addresses2[$key]
            );
        }
    }

    public function testFindRelatedObjectsWithSetNameFetchTwiceCached()
    {
        // @TODO: This is currently needed to fix the attribute set in
        // ezcDbHandler. Should be removed as soon as this is fixed!
        $this->session->database->setAttribute( PDO::ATTR_CASE, PDO::CASE_NATURAL );
        
        $person = $this->idSession->load( 'RelationTestPerson', 1 );

        $q = $this->idSession->createRelationFindQuery(
            $person,
            'RelationTestAddress',
            null,
            'foobar'
        );

        $addresses1 = $this->idSession->find( $q );

        $addresses2 = $this->idSession->find( $q );

        $this->assertSame( $addresses1, $addresses2 );
    }

    public function testFindWithRelationsUnrestricted()
    {
        // @TODO: This is currently needed to fix the attribute set in
        // ezcDbHandler. Should be removed as soon as this is fixed!
        $this->session->database->setAttribute( PDO::ATTR_CASE, PDO::CASE_NATURAL );
       
        $q = $this->idSession->createFindQueryWithRelations(
            'RelationTestPerson',
            array(
                'addresses' => new ezcPersistentRelationFindDefinition(
                    'RelationTestAddress'
                ),
            )
        );

        $persons = $this->idSession->find( $q );

        $this->assertNotNull( $persons );
        $this->assertTrue( count( $persons ) > 0 );

        $this->assertNotNull(
            $this->idMap->getRelatedObjects( current( $persons ), 'RelationTestAddress' )
        );
    }

    public function testFindWithRelationsRestricted()
    {
        // @TODO: This is currently needed to fix the attribute set in
        // ezcDbHandler. Should be removed as soon as this is fixed!
        $this->session->database->setAttribute( PDO::ATTR_CASE, PDO::CASE_NATURAL );
       
        $q = $this->idSession->createFindQueryWithRelations(
            'RelationTestPerson',
            array(
                'addresses' => new ezcPersistentRelationFindDefinition(
                    'RelationTestAddress'
                ),
            )
        );
        $q->where(
            $q->expr->gt(
                'addresses_id',
                $q->bindValue( 2 )
            )
        );

        $persons = $this->idSession->find( $q );

        $this->assertNotNull( $persons );
        $this->assertTrue( count( $persons ) > 0 );

        $this->assertNull(
            $this->idSession->getRelatedObjects( current( $persons ), 'RelationTestAddress' )
        );
        $this->assertNotNull(
            $this->idSession->getRelatedObjectSubset( current( $persons ), 'addresses' )
        );
    }
}

?>
