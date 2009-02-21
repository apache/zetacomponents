<?php
/**
 * @copyright Copyright (C) 2005-2009 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @package PersistentObject
 * @subpackage Tests
 */

require_once 'data/relation_test_person.php';
require_once 'data/relation_test_address.php';
require_once 'data/relation_test_employer.php';

/**
 * Tests the ezcPersistentBasicIdentityMap class.
 *
 * @package PersistentObject
 * @subpackage Tests
 */
class ezcPersistentBasicIdentityMapTest extends ezcTestCase
{
    protected $definitionManager;

    public static function suite()
    {
        return new PHPUnit_Framework_TestSuite( __CLASS__ );
    }

    public function setUp()
    {
        $this->definitionManager = new ezcPersistentCodeManager(
            dirname( __FILE__ ) . '/data'
        );
    }

    public function tearDown()
    {
    }

    /*
     * __construct()
     */

    public function testCtor()
    {
        $idMap = new ezcPersistentBasicIdentityMap(
            $this->definitionManager
        );

        $this->assertAttributeSame(
            $this->definitionManager,
            'definitionManager',
            $idMap
        );
        $this->assertAttributeEquals(
            array(),
            'identities',
            $idMap
        );
    }

    /* 
     * getIdentity()
     */

    public function testGetIdentityFailureNotExists()
    {
        $idMap = new ezcPersistentBasicIdentityMap(
            $this->definitionManager
        );
        
        $this->assertNull(
            $idMap->getIdentity( 'RelationTestPerson', 23 )
        );
    }

    public function testGetIdentitySingleRecordedSuccess()
    {
        $idMap = new ezcPersistentBasicIdentityMap(
            $this->definitionManager
        );
        
        $obj     = new RelationTestPerson();
        $obj->id = 23;

        $idMap->setIdentity( $obj );
        
        $this->assertSame(
            $obj,
            $idMap->getIdentity( 'RelationTestPerson', 23 )
        );
    }

    public function testGetIdentityMultipleRecordedSameClassSuccess()
    {
        $idMap = new ezcPersistentBasicIdentityMap(
            $this->definitionManager
        );
        
        $objA     = new RelationTestPerson();
        $objA->id = 23;
        
        $objB     = new RelationTestPerson();
        $objB->id = 42;

        $idMap->setIdentity( $objA );
        $idMap->setIdentity( $objB );

        $this->assertSame(
            $objA,
            $idMap->getIdentity( 'RelationTestPerson', 23 )
        );

        $this->assertSame(
            $objB,
            $idMap->getIdentity( 'RelationTestPerson', 42 )
        );
    }

    public function testGetIdentityMultipleRecordedDifferentClassSuccess()
    {
        $idMap = new ezcPersistentBasicIdentityMap(
            $this->definitionManager
        );
        
        $objA     = new RelationTestPerson();
        $objA->id = 23;
        
        $objB     = new RelationTestAddress();
        $objB->id = 42;

        $idMap->setIdentity( $objA );
        $idMap->setIdentity( $objB );

        $this->assertSame(
            $objA,
            $idMap->getIdentity( 'RelationTestPerson', 23 )
        );

        $this->assertSame(
            $objB,
            $idMap->getIdentity( 'RelationTestAddress', 42 )
        );
    }

    /*
     * setIdentity()
     */

    public function testSetIdentitySingleObjectSuccess()
    {
        $idMap = new ezcPersistentBasicIdentityMap(
            $this->definitionManager
        );
        
        $obj     = new RelationTestPerson();
        $obj->id = 23;

        $idMap->setIdentity( $obj );

        $this->assertAttributeEquals(
            array(
                'RelationTestPerson' => array(
                    23 => new ezcPersistentIdentity(
                        $obj
                    )
                ),
            ),
            'identities',
            $idMap
        );
    }

    public function testSetIdentityTowObjectsSameClassSuccess()
    {
        $idMap = new ezcPersistentBasicIdentityMap(
            $this->definitionManager
        );
        
        $objA     = new RelationTestPerson();
        $objA->id = 23;

        $objB     = new RelationTestPerson();
        $objB->id = 42;

        $idMap->setIdentity( $objA );

        $this->assertAttributeEquals(
            array(
                'RelationTestPerson' => array(
                    23 => new ezcPersistentIdentity(
                        $objA
                    ),
                ),
            ),
            'identities',
            $idMap
        );

        $idMap->setIdentity( $objB );

        $this->assertAttributeEquals(
            array(
                'RelationTestPerson' => array(
                    23 => new ezcPersistentIdentity(
                        $objA
                    ),
                    42 => new ezcPersistentIdentity(
                        $objB
                    ),
                ),
            ),
            'identities',
            $idMap
        );
    }

    public function testSetIdentityTowObjectsDifferentClassSuccess()
    {
        $idMap = new ezcPersistentBasicIdentityMap(
            $this->definitionManager
        );
        
        $objA     = new RelationTestPerson();
        $objA->id = 23;

        $objB     = new RelationTestAddress();
        $objB->id = 23;

        $idMap->setIdentity( $objA );

        $this->assertAttributeEquals(
            array(
                'RelationTestPerson' => array(
                    23 => new ezcPersistentIdentity(
                        $objA
                    ),
                ),
            ),
            'identities',
            $idMap
        );

        $idMap->setIdentity( $objB );

        $this->assertAttributeEquals(
            array(
                'RelationTestPerson' => array(
                    23 => new ezcPersistentIdentity(
                        $objA
                    ),
                ),
                'RelationTestAddress' => array(
                    23 => new ezcPersistentIdentity(
                        $objB
                    ),
                ),
            ),
            'identities',
            $idMap
        );
    }

    public function testSetIdentityMissingDefinitionFailure()
    {
        $idMap = new ezcPersistentBasicIdentityMap(
            $this->definitionManager
        );

        $obj     = new stdClass();
        $obj->id = 23;

        try
        {
            $idMap->setIdentity( $obj );
            $this->fail( 'Exception not thrown on missing persistence definition.' );
        }
        catch( ezcPersistentDefinitionNotFoundException $e ) {}
    }

    public function testSetIdentitySameObjectTwiceSuccess()
    {
        $idMap = new ezcPersistentBasicIdentityMap(
            $this->definitionManager
        );
        
        $obj     = new RelationTestPerson();
        $obj->id = 23;

        $idMap->setIdentity( $obj );

        $this->assertAttributeEquals(
            array(
                'RelationTestPerson' => array(
                    23 => new ezcPersistentIdentity(
                        $obj
                    )
                ),
            ),
            'identities',
            $idMap
        );

        $idMap->setIdentity( $obj );

        $this->assertAttributeEquals(
            array(
                'RelationTestPerson' => array(
                    23 => new ezcPersistentIdentity(
                        $obj
                    )
                ),
            ),
            'identities',
            $idMap
        );
    }

    public function testSetIdentityEqualObjectTwiceFailure()
    {
        $idMap = new ezcPersistentBasicIdentityMap(
            $this->definitionManager
        );
        
        $objA     = new RelationTestPerson();
        $objA->id = 23;
        
        $objB     = new RelationTestPerson();
        $objB->id = 23;

        $idMap->setIdentity( $objA );

        $this->assertAttributeEquals(
            array(
                'RelationTestPerson' => array(
                    23 => new ezcPersistentIdentity(
                        $objA
                    )
                ),
            ),
            'identities',
            $idMap
        );

        $idMap->setIdentity( $objB );

        $this->assertAttributeEquals(
            array(
                'RelationTestPerson' => array(
                    23 => new ezcPersistentIdentity(
                        $objB
                    )
                ),
            ),
            'identities',
            $idMap
        );
    }

    /*
     * replaceRelatedObjects()
     */

    public function testSetRelatedObjectsWithoutNameNotExistsSuccess()
    {
        $idMap = new ezcPersistentBasicIdentityMap(
            $this->definitionManager
        );
        
        $obj     = new RelationTestPerson();
        $obj->id = 23;
        
        $relatedObjects = new ArrayObject();
        $relatedObjects[42] = new RelationTestAddress();
        $relatedObjects[42]->id = 42;
        $relatedObjects[65] = new RelationTestAddress();
        $relatedObjects[65]->id = 65;

        $idMap->setIdentity( $obj );
        $idMap->setIdentity( $relatedObjects[42] );
        $idMap->setIdentity( $relatedObjects[65] );

        $idMap->setRelatedObjects( $obj, $relatedObjects->getArrayCopy(), 'RelationTestAddress' );

        $identities = $this->readAttribute(
            $idMap, 'identities'
        );

        $this->assertTrue( isset( $identities['RelationTestAddress'][42]->references ) );
        $this->assertTrue( isset( $identities['RelationTestAddress'][65]->references ) );

        $this->assertEquals(
            array(
                'RelationTestPerson' => array(
                    23 => new ezcPersistentIdentity(
                        $obj,
                        array( 'RelationTestAddress' => $relatedObjects )
                    )
                ),
                'RelationTestAddress' => array(
                    42 => new ezcPersistentIdentity(
                        $relatedObjects[42],
                        array(),
                        array(),
                        $identities['RelationTestAddress'][42]->references
                    ),
                    65 => new ezcPersistentIdentity(
                        $relatedObjects[65],
                        array(),
                        array(),
                        $identities['RelationTestAddress'][65]->references
                    ),
                ),
            ),
            $identities
        );

        $this->assertEquals(
            1, count( $identities['RelationTestAddress'][42]->references )
        );
        $this->assertEquals(
            1, count( $identities['RelationTestAddress'][65]->references )
        );
    }

    public function testSetRelatedObjectsWithNameNotExsistsSuccess()
    {
        $idMap = new ezcPersistentBasicIdentityMap(
            $this->definitionManager
        );
        
        $obj     = new RelationTestPerson();
        $obj->id = 23;
        
        $relatedObjects = array();
        $relatedObjects[42] = new RelationTestAddress();
        $relatedObjects[42]->id = 42;
        $relatedObjects[65] = new RelationTestAddress();
        $relatedObjects[65]->id = 65;

        $idMap->setIdentity( $obj );
        $idMap->setIdentity( $relatedObjects[42] );
        $idMap->setIdentity( $relatedObjects[65] );

        $idMap->setRelatedObjectSet( $obj, $relatedObjects, 'set_name' );

        $identities = $this->readAttribute(
            $idMap, 'identities'
        );

        $this->assertTrue( isset( $identities['RelationTestAddress'][42]->references ) );
        $this->assertTrue( isset( $identities['RelationTestAddress'][65]->references ) );

        $this->assertEquals(
            array(
                'RelationTestPerson' => array(
                    23 => new ezcPersistentIdentity(
                        $obj,
                        array(),
                        array( 'set_name' => new ArrayObject( $relatedObjects ) )
                    )
                ),
                'RelationTestAddress' => array(
                    42 => new ezcPersistentIdentity(
                        $relatedObjects[42],
                        array(),
                        array(),
                        $identities['RelationTestAddress'][42]->references
                    ),
                    65 => new ezcPersistentIdentity(
                        $relatedObjects[65],
                        array(),
                        array(),
                        $identities['RelationTestAddress'][65]->references
                    ),
                ),
            ),
            $identities
        );

        $this->assertEquals(
            1, count( $identities['RelationTestAddress'][42]->references )
        );
        $this->assertEquals(
            1, count( $identities['RelationTestAddress'][65]->references )
        );
    }

    public function testSetRelatedObjectsTwiceWithDifferentNamesNotExistSuccess()
    {
        $idMap = new ezcPersistentBasicIdentityMap(
            $this->definitionManager
        );
        
        $obj     = new RelationTestPerson();
        $obj->id = 23;
        
        $relatedObjects = array();
        $relatedObjects[42] = new RelationTestAddress();
        $relatedObjects[42]->id = 42;
        $relatedObjects[65] = new RelationTestAddress();
        $relatedObjects[65]->id = 65;

        $idMap->setIdentity( $obj );
        $idMap->setIdentity( $relatedObjects[42] );
        $idMap->setIdentity( $relatedObjects[65] );

        $idMap->setRelatedObjectSet( $obj, $relatedObjects, 'first_set' );
        $idMap->setRelatedObjectSet( $obj, $relatedObjects, 'second_set' );

        $identities = $this->readAttribute(
            $idMap, 'identities'
        );

        $this->assertTrue( isset( $identities['RelationTestAddress'][42]->references ) );
        $this->assertTrue( isset( $identities['RelationTestAddress'][65]->references ) );

        $this->assertEquals(
            array(
                'RelationTestPerson' => array(
                    23 => new ezcPersistentIdentity(
                        $obj,
                        array(),
                        array(
                            'first_set' => new ArrayObject( $relatedObjects ),
                            'second_set' => new ArrayObject( $relatedObjects )
                        )
                    ),
                ),
                'RelationTestAddress' => array(
                    42 => new ezcPersistentIdentity(
                        $relatedObjects[42],
                        array(),
                        array(),
                        $identities['RelationTestAddress'][42]->references
                    ),
                    65 => new ezcPersistentIdentity(
                        $relatedObjects[65],
                        array(),
                        array(),
                        $identities['RelationTestAddress'][65]->references
                    ),
                ),
            ),
            $identities
        );

        $this->assertEquals(
            2, count( $identities['RelationTestAddress'][42]->references )
        );
        $this->assertEquals(
            2, count( $identities['RelationTestAddress'][65]->references )
        );
    }

    public function testSetRelatedObjectsMissingIdentityFailure()
    {
        $idMap = new ezcPersistentBasicIdentityMap(
            $this->definitionManager
        );
        
        $obj     = new RelationTestPerson();
        $obj->id = 23;
        
        $relatedObjects = array();
        $relatedObjects[42] = new RelationTestAddress();
        $relatedObjects[42]->id = 42;
        $relatedObjects[65] = new RelationTestAddress();
        $relatedObjects[65]->id = 65;

        $idMap->setIdentity( $obj );
        $idMap->setIdentity( $relatedObjects[42] );

        try
        {
            $idMap->setRelatedObjects( $obj, $relatedObjects, 'RelationTestAddress' );
            $this->fail( 'Exception not thrown on add of related objects where an identity is missing.' );
        }
        catch ( ezcPersistentIdentityMissingException $e ) {}

        $identities = $this->readAttribute(
            $idMap, 'identities'
        );

        $this->assertEquals(
            array(
                'RelationTestPerson' => array(
                    23 => new ezcPersistentIdentity( $obj )
                ),
                'RelationTestAddress' => array(
                    42 => new ezcPersistentIdentity( $relatedObjects[42] ),
                ),
            ),
            $identities
        );
    }

    public function testSetRelatedObjectsWithoutNameAlreadyExistSuccess()
    {
        $idMap = new ezcPersistentBasicIdentityMap(
            $this->definitionManager
        );
        
        $obj     = new RelationTestPerson();
        $obj->id = 23;
        
        $relatedObjects = array();
        $relatedObjects[42] = new RelationTestAddress();
        $relatedObjects[42]->id = 42;
        $relatedObjects[65] = new RelationTestAddress();
        $relatedObjects[65]->id = 65;

        $idMap->setIdentity( $obj );
        $idMap->setIdentity( $relatedObjects[42] );
        $idMap->setIdentity( $relatedObjects[65] );

        $idMap->setRelatedObjects( $obj, $relatedObjects, 'RelationTestAddress' );
        $idMap->setRelatedObjects( $obj, $relatedObjects, 'RelationTestAddress' );

        $identities = $this->readAttribute(
            $idMap, 'identities'
        );

        $this->assertTrue( isset( $identities['RelationTestAddress'][42]->references ) );
        $this->assertTrue( isset( $identities['RelationTestAddress'][65]->references ) );

        $this->assertEquals(
            array(
                'RelationTestPerson' => array(
                    23 => new ezcPersistentIdentity( $obj, array( 'RelationTestAddress' => new ArrayObject( $relatedObjects ) ) )
                ),
                'RelationTestAddress' => array(
                    42 => new ezcPersistentIdentity(
                        $relatedObjects[42],
                        array(),
                        array(),
                        $identities['RelationTestAddress'][42]->references
                    ),
                    65 => new ezcPersistentIdentity(
                        $relatedObjects[65],
                        array(),
                        array(),
                        $identities['RelationTestAddress'][65]->references
                    ),
                ),
            ),
            $identities
        );

        $this->assertEquals(
            1, count( $identities['RelationTestAddress'][42]->references )
        );
        $this->assertEquals(
            1, count( $identities['RelationTestAddress'][65]->references )
        );
    }

    public function testSetRelatedObjectsWithNameAlreadyExistSuccess()
    {
        $idMap = new ezcPersistentBasicIdentityMap(
            $this->definitionManager
        );
        
        $obj     = new RelationTestPerson();
        $obj->id = 23;
        
        $relatedObjects = array();
        $relatedObjects[42] = new RelationTestAddress();
        $relatedObjects[42]->id = 42;
        $relatedObjects[65] = new RelationTestAddress();
        $relatedObjects[65]->id = 65;

        $idMap->setIdentity( $obj );
        $idMap->setIdentity( $relatedObjects[42] );
        $idMap->setIdentity( $relatedObjects[65] );

        $idMap->setRelatedObjectSet( $obj, $relatedObjects, 'set_name' );
        $idMap->setRelatedObjectSet( $obj, $relatedObjects, 'set_name' );

        $identities = $this->readAttribute(
            $idMap, 'identities'
        );

        $this->assertTrue( isset( $identities['RelationTestAddress'][42]->references ) );
        $this->assertTrue( isset( $identities['RelationTestAddress'][65]->references ) );

        $this->assertEquals(
            array(
                'RelationTestPerson' => array(
                    23 => new ezcPersistentIdentity(
                        $obj,
                        array(),
                        array( 'set_name' => new ArrayObject( $relatedObjects ) )
                    )
                ),
                'RelationTestAddress' => array(
                    42 => new ezcPersistentIdentity(
                        $relatedObjects[42],
                        array(),
                        array(),
                        $identities['RelationTestAddress'][42]->references
                    ),
                    65 => new ezcPersistentIdentity(
                        $relatedObjects[65],
                        array(),
                        array(),
                        $identities['RelationTestAddress'][65]->references
                    ),
                ),
            ),
            $identities
        );

        $this->assertEquals(
            1, count( $identities['RelationTestAddress'][42]->references )
        );
        $this->assertEquals(
            1, count( $identities['RelationTestAddress'][65]->references )
        );
    }

    public function testSetRelatedObjectsInconsistentFailure()
    {
        $idMap = new ezcPersistentBasicIdentityMap(
            $this->definitionManager
        );
        
        $obj     = new RelationTestPerson();
        $obj->id = 23;
        
        $relatedObjects = array();
        $relatedObjects[42] = new RelationTestAddress();
        $relatedObjects[42]->id = 42;
        $relatedObjects[65] = new RelationTestEmployer();
        $relatedObjects[65]->id = 65;

        $idMap->setIdentity( $obj );
        $idMap->setIdentity( $relatedObjects[42] );
        $idMap->setIdentity( $relatedObjects[65] );

        try
        {
            $idMap->setRelatedObjects( $obj, $relatedObjects, 'RelationTestAddress' );
            $this->fail( 'Exception not thrown on inconsistent related object set.' );
        }
        catch ( ezcPersistentIdentityRelatedObjectsInconsistentException $e ) {}

        $identities = $this->readAttribute(
            $idMap, 'identities'
        );

        $this->assertTrue( isset( $identities['RelationTestAddress'][42]->references ) );
        $this->assertTrue( isset( $identities['RelationTestEmployer'][65]->references ) );

        $this->assertEquals(
            array(
                'RelationTestPerson' => array(
                    23 => new ezcPersistentIdentity( $obj )
                ),
                'RelationTestAddress' => array(
                    42 => new ezcPersistentIdentity(
                        $relatedObjects[42],
                        array(),
                        array(),
                        $identities['RelationTestAddress'][42]->references
                    ),
                                    ),
                'RelationTestEmployer' => array(
                    65 => new ezcPersistentIdentity(
                        $relatedObjects[65],
                        array(),
                        array(),
                        $identities['RelationTestEmployer'][65]->references
                    ),

                ),
            ),
            $identities
        );

        $this->assertEquals(
            0,
            count( $identities['RelationTestAddress'][42]->references ),
            'Rel count of valid object incorrect,'
        );
        $this->assertEquals(
            0,
            count( $identities['RelationTestEmployer'][65]->references ),
            'Rel count of invalid object incorrect,'
        );
    }

    /*
     * addRelatedObject()
     */

    public function testAddRelatedObjectToExistingSetSuccess()
    {
        $idMap = new ezcPersistentBasicIdentityMap(
            $this->definitionManager
        );
        
        $obj     = new RelationTestPerson();
        $obj->id = 23;
        
        $relatedObjects = array();
        $relatedObjects[42] = new RelationTestAddress();
        $relatedObjects[42]->id = 42;
        $relatedObjects[65] = new RelationTestAddress();
        $relatedObjects[65]->id = 65;

        $idMap->setIdentity( $obj );
        $idMap->setIdentity( $relatedObjects[42] );
        $idMap->setIdentity( $relatedObjects[65] );

        $idMap->setRelatedObjects( $obj, $relatedObjects, 'RelationTestAddress' );

        $identities = $this->readAttribute(
            $idMap, 'identities'
        );

        $this->assertTrue( isset( $identities['RelationTestAddress'][42]->references ) );
        $this->assertTrue( isset( $identities['RelationTestAddress'][65]->references ) );

        $this->assertEquals(
            array(
                'RelationTestPerson' => array(
                    23 => new ezcPersistentIdentity(
                        $obj,
                        array( 'RelationTestAddress' => new ArrayObject( $relatedObjects ) )
                    )
                ),
                'RelationTestAddress' => array(
                    42 => new ezcPersistentIdentity(
                        $relatedObjects[42],
                        array(),
                        array(),
                        $identities['RelationTestAddress'][42]->references
                    ),
                    65 => new ezcPersistentIdentity(
                        $relatedObjects[65],
                        array(),
                        array(),
                        $identities['RelationTestAddress'][65]->references
                    ),
                ),
            ),
            $identities
        );

        $this->assertEquals(
            1,
            count( $identities['RelationTestAddress'][42]->references ),
            'Rel count of valid object incorrect,'
        );
        $this->assertEquals(
            1,
            count( $identities['RelationTestAddress'][65]->references ),
            'Rel count of valid object incorrect,'
        );

        $newRelatedObject     = new RelationTestAddress();
        $newRelatedObject->id = 3;
        
        $idMap->setIdentity( $newRelatedObject );
        $idMap->addRelatedObject( $obj, $newRelatedObject, 'RelationTestAddress' );

        $identities = $this->readAttribute(
            $idMap, 'identities'
        );

        $this->assertTrue( isset( $identities['RelationTestAddress'][42]->references ) );
        $this->assertTrue( isset( $identities['RelationTestAddress'][65]->references ) );
        $this->assertTrue( isset( $identities['RelationTestAddress'][3]->references ) );

        $this->assertEquals(
            array(
                'RelationTestPerson' => array(
                    23 => new ezcPersistentIdentity(
                        $obj,
                        array( 'RelationTestAddress' => new ArrayObject( $relatedObjects + array( 3 => $newRelatedObject ) ) )
                    ),
                ),
                'RelationTestAddress' => array(
                    42 => new ezcPersistentIdentity(
                        $relatedObjects[42],
                        array(),
                        array(),
                        $identities['RelationTestAddress'][42]->references
                    ),
                    65 => new ezcPersistentIdentity(
                        $relatedObjects[65],
                        array(),
                        array(),
                        $identities['RelationTestAddress'][65]->references
                    ),
                    3  => new ezcPersistentIdentity(
                        $newRelatedObject,
                        array(),
                        array(),
                        $identities['RelationTestAddress'][3]->references
                    ),
                ),
            ),
            $identities
        );

        $this->assertEquals(
            1,
            count( $identities['RelationTestAddress'][42]->references ),
            'Rel count of valid object incorrect,'
        );
        $this->assertEquals(
            1,
            count( $identities['RelationTestAddress'][65]->references ),
            'Rel count of valid object incorrect,'
        );
        $this->assertEquals(
            1,
            count( $identities['RelationTestAddress'][3]->references ),
            'Rel count of valid object incorrect,'
        );
    }

    public function testAddRelatedObjectIgnoredEmptySetSuccess()
    {
        $idMap = new ezcPersistentBasicIdentityMap(
            $this->definitionManager
        );
        
        $obj     = new RelationTestPerson();
        $obj->id = 23;
        
        $idMap->setIdentity( $obj );

        $this->assertAttributeEquals(
            array(
                'RelationTestPerson' => array(
                    23 => new ezcPersistentIdentity(
                        $obj
                    )
                ),
            ),
            'identities',
            $idMap
        );

        $newRelatedObject     = new RelationTestAddress();
        $newRelatedObject->id = 3;
        
        $idMap->setIdentity( $newRelatedObject );

        $idMap->addRelatedObject( $obj, $newRelatedObject );

        $this->assertAttributeEquals(
            array(
                'RelationTestPerson' => array(
                    23 => new ezcPersistentIdentity(
                        $obj
                    )
                ),
                'RelationTestAddress' => array(
                    3  => new ezcPersistentIdentity( $newRelatedObject ),
                ),
            ),
            'identities',
            $idMap
        );
    }

    public function testAddRelatedObjectInvalidateNamedSetsSuccess()
    {
        $idMap = new ezcPersistentBasicIdentityMap(
            $this->definitionManager
        );
        
        $obj     = new RelationTestPerson();
        $obj->id = 23;
        
        $relatedObjects = array();
        $relatedObjects[42] = new RelationTestAddress();
        $relatedObjects[42]->id = 42;
        $relatedObjects[65] = new RelationTestAddress();
        $relatedObjects[65]->id = 65;

        $idMap->setIdentity( $obj );
        $idMap->setIdentity( $relatedObjects[42] );
        $idMap->setIdentity( $relatedObjects[65] );

        $idMap->setRelatedObjects( $obj, $relatedObjects, 'RelationTestAddress' );
        $idMap->setRelatedObjectSet( $obj, $relatedObjects, 'named_set' );

        $identities = $this->readAttribute(
            $idMap, 'identities'
        );

        $this->assertTrue( isset( $identities['RelationTestAddress'][42]->references ) );
        $this->assertTrue( isset( $identities['RelationTestAddress'][65]->references ) );

        $this->assertEquals(
            array(
                'RelationTestPerson' => array(
                    23 => new ezcPersistentIdentity(
                        $obj,
                        array( 'RelationTestAddress' => new ArrayObject( $relatedObjects ) ),
                        array( 'named_set' => new ArrayObject( $relatedObjects ) )
                    )
                ),
                'RelationTestAddress' => array(
                    42 => new ezcPersistentIdentity(
                        $relatedObjects[42],
                        array(),
                        array(),
                        $identities['RelationTestAddress'][42]->references
                    ),
                    65 => new ezcPersistentIdentity(
                        $relatedObjects[65],
                        array(),
                        array(),
                        $identities['RelationTestAddress'][65]->references
                    ),
                ),
            ),
            $identities
        );

        $this->assertEquals(
            2,
            count( $identities['RelationTestAddress'][42]->references ),
            'Rel count of valid object incorrect,'
        );
        $this->assertEquals(
            2,
            count( $identities['RelationTestAddress'][65]->references ),
            'Rel count of valid object incorrect,'
        );

        $newRelatedObject     = new RelationTestAddress();
        $newRelatedObject->id = 3;
        
        $idMap->setIdentity( $newRelatedObject );
        $idMap->addRelatedObject( $obj, $newRelatedObject );

        $identities = $this->readAttribute(
            $idMap, 'identities'
        );

        $this->assertTrue( isset( $identities['RelationTestAddress'][42]->references ) );
        $this->assertTrue( isset( $identities['RelationTestAddress'][65]->references ) );
        $this->assertTrue( isset( $identities['RelationTestAddress'][3]->references ) );

        $this->assertEquals(
            array(
                'RelationTestPerson' => array(
                    23 => new ezcPersistentIdentity(
                        $obj,
                        array( 'RelationTestAddress' => new ArrayObject( $relatedObjects + array( 3 => $newRelatedObject ) ) )
                    )
                ),
                'RelationTestAddress' => array(
                    42 => new ezcPersistentIdentity(
                        $relatedObjects[42],
                        array(),
                        array(),
                        $identities['RelationTestAddress'][42]->references
                    ),
                    65 => new ezcPersistentIdentity(
                        $relatedObjects[65],
                        array(),
                        array(),
                        $identities['RelationTestAddress'][65]->references
                    ),
                    3  => new ezcPersistentIdentity(
                        $newRelatedObject,
                        array(),
                        array(),
                        $identities['RelationTestAddress'][3]->references
                    ),
                ),
            ),
            $identities
        );

        $this->assertEquals(
            1,
            count( $identities['RelationTestAddress'][42]->references ),
            'Rel count of valid object incorrect,'
        );
        $this->assertEquals(
            1,
            count( $identities['RelationTestAddress'][65]->references ),
            'Rel count of valid object incorrect,'
        );
        $this->assertEquals(
            1,
            count( $identities['RelationTestAddress'][3]->references ),
            'Rel count of valid object incorrect,'
        );
    }

    public function testAddRelatedObjectMissingIdentityFailure()
    {
        $idMap = new ezcPersistentBasicIdentityMap(
            $this->definitionManager
        );
        
        $obj     = new RelationTestPerson();
        $obj->id = 23;
        
        $idMap->setIdentity( $obj );

        $newRelatedObject     = new RelationTestAddress();
        $newRelatedObject->id = 3;
        
        try
        {
            $idMap->addRelatedObject( $obj, $newRelatedObject );
            $this->fail( 'Exception not thrown on add of related object where the identity is missing.' );
        }
        catch ( ezcPersistentIdentityMissingException $e ) {}

        $this->assertAttributeEquals(
            array(
                'RelationTestPerson' => array(
                    23 => new ezcPersistentIdentity(
                        $obj
                    )
                ),
            ),
            'identities',
            $idMap
        );
    }

    public function testAddRelatedObjectMissingDefinitionFailure()
    {
        $idMap = new ezcPersistentBasicIdentityMap(
            $this->definitionManager
        );
        
        $obj     = new RelationTestPerson();
        $obj->id = 23;
        
        $idMap->setIdentity( $obj );

        $newRelatedObject     = new stdClass();
        $newRelatedObject->id = 3;
        
        try
        {
            $idMap->addRelatedObject( $obj, $newRelatedObject );
            $this->fail( 'Exception not thrown on missing definition of a related object.' );
        }
        catch ( ezcPersistentDefinitionNotFoundException $e ) {}

        $this->assertAttributeEquals(
            array(
                'RelationTestPerson' => array(
                    23 => new ezcPersistentIdentity(
                        $obj
                    )
                ),
            ),
            'identities',
            $idMap
        );
    }

    public function testAddRelatedObjectTwiceFailure()
    {
        $idMap = new ezcPersistentBasicIdentityMap(
            $this->definitionManager
        );
        
        $obj     = new RelationTestPerson();
        $obj->id = 23;
        
        $relatedObjects = array();
        $relatedObjects[42] = new RelationTestAddress();
        $relatedObjects[42]->id = 42;
        $relatedObjects[65] = new RelationTestAddress();
        $relatedObjects[65]->id = 65;

        $idMap->setIdentity( $obj );
        $idMap->setIdentity( $relatedObjects[42] );
        $idMap->setIdentity( $relatedObjects[65] );

        $idMap->setRelatedObjects( $obj, $relatedObjects, 'RelationTestAddress' );

        $newRelatedObject     = new RelationTestAddress();
        $newRelatedObject->id = 3;
        
        $idMap->setIdentity( $newRelatedObject );
        $idMap->addRelatedObject( $obj, $newRelatedObject, 'RelationTestAddress' );

        $identities = $this->readAttribute(
            $idMap, 'identities'
        );

        $this->assertTrue( isset( $identities['RelationTestAddress'][42]->references ) );
        $this->assertTrue( isset( $identities['RelationTestAddress'][65]->references ) );
        $this->assertTrue( isset( $identities['RelationTestAddress'][3]->references ) );

        $this->assertEquals(
            array(
                'RelationTestPerson' => array(
                    23 => new ezcPersistentIdentity(
                        $obj,
                        array( 'RelationTestAddress' => new ArrayObject( $relatedObjects + array( 3 => $newRelatedObject ) ) )
                    ),
                ),
                'RelationTestAddress' => array(
                    42 => new ezcPersistentIdentity(
                        $relatedObjects[42],
                        array(),
                        array(),
                        $identities['RelationTestAddress'][42]->references
                    ),
                    65 => new ezcPersistentIdentity(
                        $relatedObjects[65],
                        array(),
                        array(),
                        $identities['RelationTestAddress'][65]->references
                    ),
                    3  => new ezcPersistentIdentity(
                        $newRelatedObject,
                        array(),
                        array(),
                        $identities['RelationTestAddress'][3]->references
                    ),
                ),
            ),
            $identities
        );

        $this->assertEquals(
            1,
            count( $identities['RelationTestAddress'][42]->references ),
            'Rel count of valid object incorrect,'
        );
        $this->assertEquals(
            1,
            count( $identities['RelationTestAddress'][65]->references ),
            'Rel count of valid object incorrect,'
        );
        $this->assertEquals(
            1,
            count( $identities['RelationTestAddress'][3]->references ),
            'Rel count of valid object incorrect,'
        );

        try
        {
            $idMap->addRelatedObject( $obj, $newRelatedObject, 'RelationTestAddress' );
            $this->fail( 'Exception not thrown on double add of same new related object.' );
        }
        catch( ezcPersistentIdentityRelatedObjectsAlreadyExistException $e ) {}

        $identities = $this->readAttribute(
            $idMap, 'identities'
        );

        $this->assertTrue( isset( $identities['RelationTestAddress'][42]->references ) );
        $this->assertTrue( isset( $identities['RelationTestAddress'][65]->references ) );
        $this->assertTrue( isset( $identities['RelationTestAddress'][3]->references ) );

        $this->assertEquals(
            array(
                'RelationTestPerson' => array(
                    23 => new ezcPersistentIdentity(
                        $obj,
                        array( 'RelationTestAddress' => new ArrayObject( $relatedObjects + array( 3 => $newRelatedObject ) ) )
                    ),
                ),
                'RelationTestAddress' => array(
                    42 => new ezcPersistentIdentity(
                        $relatedObjects[42],
                        array(),
                        array(),
                        $identities['RelationTestAddress'][42]->references
                    ),
                    65 => new ezcPersistentIdentity(
                        $relatedObjects[65],
                        array(),
                        array(),
                        $identities['RelationTestAddress'][65]->references
                    ),
                    3  => new ezcPersistentIdentity(
                        $newRelatedObject,
                        array(),
                        array(),
                        $identities['RelationTestAddress'][3]->references
                    ),
                ),
            ),
            $identities
        );

        $this->assertEquals(
            1,
            count( $identities['RelationTestAddress'][42]->references ),
            'Rel count of valid object incorrect,'
        );
        $this->assertEquals(
            1,
            count( $identities['RelationTestAddress'][65]->references ),
            'Rel count of valid object incorrect,'
        );
        $this->assertEquals(
            1,
            count( $identities['RelationTestAddress'][3]->references ),
            'Rel count of valid object incorrect,'
        );
    }

    /*
     * removeRelatedObject()
     */

    public function testRemoveRelatedObjectSingleSetSuccess()
    {
        $idMap = new ezcPersistentBasicIdentityMap(
            $this->definitionManager
        );
        
        $obj     = new RelationTestPerson();
        $obj->id = 23;
        
        $relatedObjects = array();
        $relatedObjects[42] = new RelationTestAddress();
        $relatedObjects[42]->id = 42;
        $relatedObjects[65] = new RelationTestAddress();
        $relatedObjects[65]->id = 65;

        $idMap->setIdentity( $obj );
        $idMap->setIdentity( $relatedObjects[42] );
        $idMap->setIdentity( $relatedObjects[65] );

        $idMap->setRelatedObjects( $obj, $relatedObjects, 'RelationTestAddress' );
        
        $identities = $this->readAttribute(
            $idMap, 'identities'
        );

        $this->assertTrue( isset( $identities['RelationTestAddress'][42]->references ) );
        $this->assertTrue( isset( $identities['RelationTestAddress'][65]->references ) );

        $this->assertEquals(
            array(
                'RelationTestPerson' => array(
                    23 => new ezcPersistentIdentity(
                        $obj,
                        array( 'RelationTestAddress' => new ArrayObject( $relatedObjects ) )
                    )
                ),
                'RelationTestAddress' => array(
                    42 => new ezcPersistentIdentity(
                        $relatedObjects[42],
                        array(),
                        array(),
                        $identities['RelationTestAddress'][42]->references
                    ),
                    65 => new ezcPersistentIdentity(
                        $relatedObjects[65],
                        array(),
                        array(),
                        $identities['RelationTestAddress'][65]->references
                    ),
                ),
            ),
            $identities
        );

        $this->assertEquals(
            1,
            count( $identities['RelationTestAddress'][42]->references ),
            'Rel count of valid object incorrect,'
        );
        $this->assertEquals(
            1,
            count( $identities['RelationTestAddress'][65]->references ),
            'Rel count of valid object incorrect,'
        );

        $idMap->removeRelatedObject( $obj, $relatedObjects[42] );
        
        $identities = $this->readAttribute(
            $idMap, 'identities'
        );

        $this->assertTrue( isset( $identities['RelationTestAddress'][42]->references ) );
        $this->assertTrue( isset( $identities['RelationTestAddress'][65]->references ) );

        $this->assertEquals(
            array(
                'RelationTestPerson' => array(
                    23 => new ezcPersistentIdentity(
                        $obj,
                        array(
                            'RelationTestAddress' => new ArrayObject( array(
                                65 => $relatedObjects[65],
                            ) )
                        )
                    )
                ),
                'RelationTestAddress' => array(
                    42 => new ezcPersistentIdentity(
                        $relatedObjects[42],
                        array(),
                        array(),
                        $identities['RelationTestAddress'][42]->references
                    ),
                    65 => new ezcPersistentIdentity(
                        $relatedObjects[65],
                        array(),
                        array(),
                        $identities['RelationTestAddress'][65]->references
                    ),
                ),
            ),
            $identities
        );

        $this->assertEquals(
            0,
            count( $identities['RelationTestAddress'][42]->references ),
            'Rel count of valid object incorrect,'
        );
        $this->assertEquals(
            1,
            count( $identities['RelationTestAddress'][65]->references ),
            'Rel count of valid object incorrect,'
        );
    }

    public function testRemoveRelatedObjectMultipleSetsSuccess()
    {
        $idMap = new ezcPersistentBasicIdentityMap(
            $this->definitionManager
        );
        
        $obj     = new RelationTestPerson();
        $obj->id = 23;
        
        $relatedObjects = array();
        $relatedObjects[42] = new RelationTestAddress();
        $relatedObjects[42]->id = 42;
        $relatedObjects[65] = new RelationTestAddress();
        $relatedObjects[65]->id = 65;

        $idMap->setIdentity( $obj );
        $idMap->setIdentity( $relatedObjects[42] );
        $idMap->setIdentity( $relatedObjects[65] );

        $idMap->setRelatedObjects( $obj, $relatedObjects, 'RelationTestAddress' );
        $idMap->setRelatedObjectSet( $obj, $relatedObjects, 'set_name' );

        $identities = $this->readAttribute(
            $idMap, 'identities'
        );

        $this->assertTrue( isset( $identities['RelationTestAddress'][42]->references ) );
        $this->assertTrue( isset( $identities['RelationTestAddress'][65]->references ) );
        
        $this->assertEquals(
            array(
                'RelationTestPerson' => array(
                    23 => new ezcPersistentIdentity(
                        $obj,
                        array( 'RelationTestAddress' => new ArrayObject( $relatedObjects ) ),
                        array( 'set_name' => new ArrayObject( $relatedObjects ) )
                    )
                ),
                'RelationTestAddress' => array(
                    42 => new ezcPersistentIdentity(
                        $relatedObjects[42],
                        array(),
                        array(),
                        $identities['RelationTestAddress'][42]->references
                    ),
                    65 => new ezcPersistentIdentity(
                        $relatedObjects[65],
                        array(),
                        array(),
                        $identities['RelationTestAddress'][65]->references
                    ),
                ),
            ),
            $identities
        );

        $this->assertEquals(
            2,
            count( $identities['RelationTestAddress'][42]->references ),
            'Rel count of valid object incorrect,'
        );
        $this->assertEquals(
            2,
            count( $identities['RelationTestAddress'][65]->references ),
            'Rel count of valid object incorrect,'
        );

        $idMap->removeRelatedObject( $obj, $relatedObjects[42] );

        $identities = $this->readAttribute(
            $idMap, 'identities'
        );

        $this->assertTrue( isset( $identities['RelationTestAddress'][42]->references ) );
        $this->assertTrue( isset( $identities['RelationTestAddress'][65]->references ) );

        $this->assertEquals(
            array(
                'RelationTestPerson' => array(
                    23 => new ezcPersistentIdentity(
                        $obj,
                        array(
                            'RelationTestAddress' => new ArrayObject( array(
                                65 => $relatedObjects[65],
                            ) ),
                        ),
                        array(
                            'set_name' => new ArrayObject( array(
                                65 => $relatedObjects[65],
                            ) ),
                        )
                    )
                ),
                'RelationTestAddress' => array(
                    42 => new ezcPersistentIdentity(
                        $relatedObjects[42],
                        array(),
                        array(),
                        $identities['RelationTestAddress'][42]->references
                    ),
                    65 => new ezcPersistentIdentity(
                        $relatedObjects[65],
                        array(),
                        array(),
                        $identities['RelationTestAddress'][65]->references
                    ),
                ),
            ),
            $identities
        );

        $this->assertEquals(
            0,
            count( $identities['RelationTestAddress'][42]->references ),
            'Rel count of valid object incorrect,'
        );
        $this->assertEquals(
            2,
            count( $identities['RelationTestAddress'][65]->references ),
            'Rel count of valid object incorrect,'
        );
    }

    public function testRemoveRelatedObjectNotExistsSuccess()
    {
        $idMap = new ezcPersistentBasicIdentityMap(
            $this->definitionManager
        );
        
        $obj     = new RelationTestPerson();
        $obj->id = 23;

        $idMap->setIdentity( $obj );
        
        $this->assertAttributeEquals(
            array(
                'RelationTestPerson' => array(
                    23 => new ezcPersistentIdentity(
                        $obj
                    )
                ),
            ),
            'identities',
            $idMap
        );
        
        $relatedObject = new RelationTestAddress();
        $relatedObject->id = 42;

        $idMap->removeRelatedObject( $obj, $relatedObject );

        $this->assertAttributeEquals(
            array(
                'RelationTestPerson' => array(
                    23 => new ezcPersistentIdentity(
                        $obj
                    )
                ),
            ),
            'identities',
            $idMap
        );
    }

    /*
     * getRelatedObjects()
     */

    public function testGetRelatedObjectsUnnamedSuccess()
    {
        $idMap = new ezcPersistentBasicIdentityMap(
            $this->definitionManager
        );
        
        $obj     = new RelationTestPerson();
        $obj->id = 23;

        $relatedObjects = array();
        $relatedObjects[42] = new RelationTestAddress();
        $relatedObjects[42]->id = 42;
        $relatedObjects[65] = new RelationTestAddress();
        $relatedObjects[65]->id = 65;

        $idMap->setIdentity( $obj );
        $idMap->setIdentity( $relatedObjects[42] );
        $idMap->setIdentity( $relatedObjects[65] );

        $idMap->setRelatedObjects( $obj, $relatedObjects, 'RelationTestAddress' );

        $this->assertEquals(
            $relatedObjects,
            $idMap->getRelatedObjects( $obj, 'RelationTestAddress' )
        );
    }

    public function testGetRelatedObjectsNamedSuccess()
    {
        $idMap = new ezcPersistentBasicIdentityMap(
            $this->definitionManager
        );
        
        $obj     = new RelationTestPerson();
        $obj->id = 23;

        $relatedObjects = array();
        $relatedObjects[42] = new RelationTestAddress();
        $relatedObjects[42]->id = 42;
        $relatedObjects[65] = new RelationTestAddress();
        $relatedObjects[65]->id = 65;

        $idMap->setIdentity( $obj );
        $idMap->setIdentity( $relatedObjects[42] );
        $idMap->setIdentity( $relatedObjects[65] );

        $idMap->setRelatedObjectSet( $obj, $relatedObjects, 'set_name' );

        $this->assertEquals(
            $relatedObjects,
            $idMap->getRelatedObjectSet( $obj, 'set_name' )
        );
    }

    public function testGetRelatedObjectsUnnamedNotExistSuccess()
    {
        $idMap = new ezcPersistentBasicIdentityMap(
            $this->definitionManager
        );
        
        $obj     = new RelationTestPerson();
        $obj->id = 23;

        $idMap->setIdentity( $obj );

        $this->assertEquals(
            null,
            $idMap->getRelatedObjects( $obj, 'RelationTestAddress' )
        );
    }

    public function testGetRelatedObjectsNamedNotExistSuccess()
    {
        $idMap = new ezcPersistentBasicIdentityMap(
            $this->definitionManager
        );
        
        $obj     = new RelationTestPerson();
        $obj->id = 23;

        $idMap->setIdentity( $obj );

        $this->assertEquals(
            null,
            $idMap->getRelatedObjectSet( $obj,'set_name' )
        );
    }

    public function testGetRelatedObjectsUnnamedEmptySuccess()
    {
        $idMap = new ezcPersistentBasicIdentityMap(
            $this->definitionManager
        );
        
        $obj     = new RelationTestPerson();
        $obj->id = 23;

        $idMap->setIdentity( $obj );

        $this->assertEquals(
            null,
            $idMap->getRelatedObjects( $obj, 'RelationTestAddress' )
        );
    }

    public function testGetRelatedObjectsNamedEmptySuccess()
    {
        $idMap = new ezcPersistentBasicIdentityMap(
            $this->definitionManager
        );
        
        $obj     = new RelationTestPerson();
        $obj->id = 23;

        $idMap->setIdentity( $obj );

        $this->assertEquals(
            null,
            $idMap->getRelatedObjectSet( $obj, 'set_name' )
        );
    }

    /*
     * reset()
     */

    public function testResetEmptySuccess()
    {
        $idMap = new ezcPersistentBasicIdentityMap(
            $this->definitionManager
        );

        $this->assertAttributeEquals(
            array(),
            'identities',
            $idMap
        );
        $this->assertAttributeSame(
            $this->definitionManager,
            'definitionManager',
            $idMap
        );

        $idMap->reset();

        $this->assertAttributeEquals(
            array(),
            'identities',
            $idMap
        );
        $this->assertAttributeSame(
            $this->definitionManager,
            'definitionManager',
            $idMap
        );
    }

    public function testResetNonEmptySuccess()
    {
        $idMap = new ezcPersistentBasicIdentityMap(
            $this->definitionManager
        );
        
        $obj     = new RelationTestPerson();
        $obj->id = 23;

        $relatedObjects = array();
        $relatedObjects[42] = new RelationTestAddress();
        $relatedObjects[42]->id = 42;
        $relatedObjects[65] = new RelationTestAddress();
        $relatedObjects[65]->id = 65;

        $idMap->setIdentity( $obj );
        $idMap->setIdentity( $relatedObjects[42] );
        $idMap->setIdentity( $relatedObjects[65] );

        $idMap->setRelatedObjects( $obj, $relatedObjects, 'RelationTestAddress' );
        $idMap->setRelatedObjectSet( $obj, $relatedObjects, 'set_name' );

        $identities = $this->readAttribute(
            $idMap, 'identities'
        );

        $this->assertTrue( isset( $identities['RelationTestAddress'][42]->references ) );
        $this->assertTrue( isset( $identities['RelationTestAddress'][65]->references ) );

        $this->assertEquals(
            array(
                'RelationTestPerson' => array(
                    23 => new ezcPersistentIdentity(
                        $obj,
                        array( 'RelationTestAddress' => new ArrayObject( $relatedObjects ) ),
                        array( 'set_name' => new ArrayObject( $relatedObjects ) )
                    )
                ),
                'RelationTestAddress' => array(
                    42 => new ezcPersistentIdentity(
                        $relatedObjects[42],
                        array(),
                        array(),
                        $identities['RelationTestAddress'][42]->references
                    ),
                    65 => new ezcPersistentIdentity(
                        $relatedObjects[65],
                        array(),
                        array(),
                        $identities['RelationTestAddress'][65]->references
                    ),
                ),
            ),
            $identities
        );
        $this->assertEquals(
            2,
            count( $identities['RelationTestAddress'][42]->references ),
            'Rel count of valid object incorrect,'
        );
        $this->assertEquals(
            2,
            count( $identities['RelationTestAddress'][65]->references ),
            'Rel count of valid object incorrect,'
        );

        $this->assertAttributeSame(
            $this->definitionManager,
            'definitionManager',
            $idMap
        );

        $idMap->reset();

        $this->assertAttributeEquals(
            array(),
            'identities',
            $idMap
        );
        $this->assertAttributeSame(
            $this->definitionManager,
            'definitionManager',
            $idMap
        );
    }
}

?>
