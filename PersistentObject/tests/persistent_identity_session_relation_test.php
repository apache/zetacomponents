<?php
/**
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package PersistentObject
 * @subpackage Tests
 */

require_once dirname( __FILE__ ) . "/data/relation_test_employer.php";
require_once dirname( __FILE__ ) . "/data/relation_test_person.php";
require_once dirname( __FILE__ ) . "/data/relation_test_address.php";

/**
 * Tests ezcPersistentManyToOneRelation class.
 *
 * @package PersistentObject
 * @subpackage Tests
 */
class ezcPersistentIdentitySessionRelationTest extends ezcTestCase
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

        $this->idSession = new ezcPersistentSession(
            ezcDbInstance::get(),
            new ezcPersistentCodeManager( dirname( __FILE__ ) . "/data/" )
        );

        $this->idMap = new ezcPersistentBasicIdentityMap(
            $this->idSession->definitionManager
        );

        $this->idSession = new ezcPersistentIdentitySession(
            $this->idSession,
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

    public function testGetRelatedObjectEmployer1()
    {
        $person = $this->idSession->load( "RelationTestPerson", 1 );
        $employer1 = $this->idSession->getRelatedObject( $person, "RelationTestEmployer" );
        $employer2 = $this->idSession->getRelatedObject( $person, "RelationTestEmployer" );

        $this->assertSame( $employer1, $employer2 );
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
}

?>
