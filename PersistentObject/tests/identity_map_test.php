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
 * Tests the ezcPersistentIdentityMap class.
 *
 * @package PersistentObject
 * @subpackage Tests
 */
class ezcPersistentIdentityMapTest extends ezcTestCase
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
        $idMap = new ezcPersistentIdentityMap(
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
        $idMap = new ezcPersistentIdentityMap(
            $this->definitionManager
        );
        
        $this->assertNull(
            $idMap->getIdentity( 'RelationTestPerson', 23 )
        );
    }

    public function testGetIdentitySingleRecordedSuccess()
    {
        $idMap = new ezcPersistentIdentityMap(
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
        $idMap = new ezcPersistentIdentityMap(
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
        $idMap = new ezcPersistentIdentityMap(
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
        $idMap = new ezcPersistentIdentityMap(
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
        $idMap = new ezcPersistentIdentityMap(
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
        $idMap = new ezcPersistentIdentityMap(
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
        $idMap = new ezcPersistentIdentityMap(
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
        $idMap = new ezcPersistentIdentityMap(
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
        $idMap = new ezcPersistentIdentityMap(
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
        $idMap = new ezcPersistentIdentityMap(
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

        $this->assertAttributeEquals(
            array(
                'RelationTestPerson' => array(
                    23 => new ezcPersistentIdentity( $obj, array( 'RelationTestAddress' => $relatedObjects ) )
                ),
                'RelationTestAddress' => array(
                    42 => new ezcPersistentIdentity( $relatedObjects[42] ),
                    65 => new ezcPersistentIdentity( $relatedObjects[65] ),
                ),
            ),
            'identities',
            $idMap
        );
    }

    public function testSetRelatedObjectsWithNameNotExsistsSuccess()
    {
        $idMap = new ezcPersistentIdentityMap(
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

        $this->assertAttributeEquals(
            array(
                'RelationTestPerson' => array(
                    23 => new ezcPersistentIdentity(
                        $obj,
                        array(),
                        array( 'set_name' => $relatedObjects )
                    )
                ),
                'RelationTestAddress' => array(
                    42 => new ezcPersistentIdentity( $relatedObjects[42] ),
                    65 => new ezcPersistentIdentity( $relatedObjects[65] ),
                ),
            ),
            'identities',
            $idMap
        );
    }

    public function testSetRelatedObjectsTwiceWithDifferentNamesNotExistSuccess()
    {
        $idMap = new ezcPersistentIdentityMap(
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

        $this->assertAttributeEquals(
            array(
                'RelationTestPerson' => array(
                    23 => new ezcPersistentIdentity(
                        $obj,
                        array(),
                        array(
                            'first_set' => $relatedObjects,
                            'second_set' => $relatedObjects
                        )
                    ),
                ),
                'RelationTestAddress' => array(
                    42 => new ezcPersistentIdentity( $relatedObjects[42] ),
                    65 => new ezcPersistentIdentity( $relatedObjects[65] ),
                ),
            ),
            'identities',
            $idMap
        );
    }

    public function testSetRelatedObjectsMissingIdentityFailure()
    {
        $idMap = new ezcPersistentIdentityMap(
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

        $this->assertAttributeEquals(
            array(
                'RelationTestPerson' => array(
                    23 => new ezcPersistentIdentity( $obj )
                ),
                'RelationTestAddress' => array(
                    42 => new ezcPersistentIdentity( $relatedObjects[42] ),
                ),
            ),
            'identities',
            $idMap
        );
    }

    public function testSetRelatedObjectsWithoutNameAlreadyExistSuccess()
    {
        $idMap = new ezcPersistentIdentityMap(
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

        $this->assertAttributeEquals(
            array(
                'RelationTestPerson' => array(
                    23 => new ezcPersistentIdentity( $obj, array( 'RelationTestAddress' => $relatedObjects ) )
                ),
                'RelationTestAddress' => array(
                    42 => new ezcPersistentIdentity( $relatedObjects[42] ),
                    65 => new ezcPersistentIdentity( $relatedObjects[65] ),
                ),
            ),
            'identities',
            $idMap
        );
    }

    public function testSetRelatedObjectsWithNameAlreadyExistSuccess()
    {
        $idMap = new ezcPersistentIdentityMap(
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

        $this->assertAttributeEquals(
            array(
                'RelationTestPerson' => array(
                    23 => new ezcPersistentIdentity(
                        $obj,
                        array(),
                        array( 'set_name' => $relatedObjects )
                    )
                ),
                'RelationTestAddress' => array(
                    42 => new ezcPersistentIdentity( $relatedObjects[42] ),
                    65 => new ezcPersistentIdentity( $relatedObjects[65] ),
                ),
            ),
            'identities',
            $idMap
        );
    }

    public function testSetRelatedObjectsInconsistentFailure()
    {
        $idMap = new ezcPersistentIdentityMap(
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

        $this->assertAttributeEquals(
            array(
                'RelationTestPerson' => array(
                    23 => new ezcPersistentIdentity( $obj )
                ),
                'RelationTestAddress' => array(
                    42 => new ezcPersistentIdentity( $relatedObjects[42] ),
                ),
                'RelationTestEmployer' => array(
                    65 => new ezcPersistentIdentity( $relatedObjects[65] ),
                ),
            ),
            'identities',
            $idMap
        );
    }

    /*
     * addRelatedObject()
     */

    public function testAddRelatedObjectToExistingSetSuccess()
    {
        $idMap = new ezcPersistentIdentityMap(
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

        $this->assertAttributeEquals(
            array(
                'RelationTestPerson' => array(
                    23 => new ezcPersistentIdentity(
                        $obj,
                        array( 'RelationTestAddress' => $relatedObjects )
                    )
                ),
                'RelationTestAddress' => array(
                    42 => new ezcPersistentIdentity( $relatedObjects[42] ),
                    65 => new ezcPersistentIdentity( $relatedObjects[65] ),
                ),
            ),
            'identities',
            $idMap
        );

        $newRelatedObject     = new RelationTestAddress();
        $newRelatedObject->id = 3;
        
        $idMap->setIdentity( $newRelatedObject );
        $idMap->addRelatedObject( $obj, $newRelatedObject, 'RelationTestAddress' );

        $this->assertAttributeEquals(
            array(
                'RelationTestPerson' => array(
                    23 => new ezcPersistentIdentity(
                        $obj,
                        array( 'RelationTestAddress' => ( $relatedObjects + array( 3 => $newRelatedObject ) ) )
                    ),
                ),
                'RelationTestAddress' => array(
                    42 => new ezcPersistentIdentity( $relatedObjects[42] ),
                    65 => new ezcPersistentIdentity( $relatedObjects[65] ),
                    3  => new ezcPersistentIdentity( $newRelatedObject ),
                ),
            ),
            'identities',
            $idMap
        );
    }

    public function testAddRelatedObjectIgnoredEmptySetSuccess()
    {
        $idMap = new ezcPersistentIdentityMap(
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
        $idMap = new ezcPersistentIdentityMap(
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

        $this->assertAttributeEquals(
            array(
                'RelationTestPerson' => array(
                    23 => new ezcPersistentIdentity(
                        $obj,
                        array( 'RelationTestAddress' => $relatedObjects ),
                        array( 'named_set' => $relatedObjects )
                    )
                ),
                'RelationTestAddress' => array(
                    42 => new ezcPersistentIdentity( $relatedObjects[42] ),
                    65 => new ezcPersistentIdentity( $relatedObjects[65] ),
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
                        $obj,
                        array( 'RelationTestAddress' => $relatedObjects + array( 3 => $newRelatedObject ) )
                    )
                ),
                'RelationTestAddress' => array(
                    42 => new ezcPersistentIdentity( $relatedObjects[42] ),
                    65 => new ezcPersistentIdentity( $relatedObjects[65] ),
                    3  => new ezcPersistentIdentity( $newRelatedObject ),
                ),
            ),
            'identities',
            $idMap
        );
    }

    public function testAddRelatedObjectMissingIdentityFailure()
    {
        $idMap = new ezcPersistentIdentityMap(
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
        $idMap = new ezcPersistentIdentityMap(
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
        $idMap = new ezcPersistentIdentityMap(
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

        $this->assertAttributeEquals(
            array(
                'RelationTestPerson' => array(
                    23 => new ezcPersistentIdentity(
                        $obj,
                        array( 'RelationTestAddress' => ( $relatedObjects + array( 3 => $newRelatedObject ) ) )
                    ),
                ),
                'RelationTestAddress' => array(
                    42 => new ezcPersistentIdentity( $relatedObjects[42] ),
                    65 => new ezcPersistentIdentity( $relatedObjects[65] ),
                    3  => new ezcPersistentIdentity( $newRelatedObject ),
                ),
            ),
            'identities',
            $idMap
        );

        try
        {
            $idMap->addRelatedObject( $obj, $newRelatedObject, 'RelationTestAddress' );
            $this->fail( 'Exception not thrown on double add of same new related object.' );
        }
        catch( ezcPersistentIdentityRelatedObjectsAlreadyExistException $e ) {}
    }

    /*
     * removeRelatedObject()
     */

    public function testRemoveRelatedObjectSingleSetSuccess()
    {
        $idMap = new ezcPersistentIdentityMap(
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
        
        $this->assertAttributeEquals(
            array(
                'RelationTestPerson' => array(
                    23 => new ezcPersistentIdentity(
                        $obj,
                        array( 'RelationTestAddress' => $relatedObjects )
                    )
                ),
                'RelationTestAddress' => array(
                    42 => new ezcPersistentIdentity( $relatedObjects[42] ),
                    65 => new ezcPersistentIdentity( $relatedObjects[65] ),
                ),
            ),
            'identities',
            $idMap,
            'Identity map before removal.'
        );

        $idMap->removeRelatedObject( $obj, $relatedObjects[42] );

        $this->assertAttributeEquals(
            array(
                'RelationTestPerson' => array(
                    23 => new ezcPersistentIdentity(
                        $obj,
                        array(
                            'RelationTestAddress' => array(
                                65 => $relatedObjects[65],
                            )
                        )
                    )
                ),
                'RelationTestAddress' => array(
                    42 => new ezcPersistentIdentity( $relatedObjects[42] ),
                    65 => new ezcPersistentIdentity( $relatedObjects[65] ),
                ),
            ),
            'identities',
            $idMap,
            'Identity map after removal.'
        );
    }

    public function testRemoveRelatedObjectMultipleSetsSuccess()
    {
        $idMap = new ezcPersistentIdentityMap(
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
        
        $this->assertAttributeEquals(
            array(
                'RelationTestPerson' => array(
                    23 => new ezcPersistentIdentity(
                        $obj,
                        array( 'RelationTestAddress' => $relatedObjects ),
                        array( 'set_name' => $relatedObjects )
                    )
                ),
                'RelationTestAddress' => array(
                    42 => new ezcPersistentIdentity( $relatedObjects[42] ),
                    65 => new ezcPersistentIdentity( $relatedObjects[65] ),
                ),
            ),
            'identities',
            $idMap
        );

        $idMap->removeRelatedObject( $obj, $relatedObjects[42] );

        $this->assertAttributeEquals(
            array(
                'RelationTestPerson' => array(
                    23 => new ezcPersistentIdentity(
                        $obj,
                        array(
                            'RelationTestAddress' => array(
                                65 => $relatedObjects[65],
                            ),
                        ),
                        array(
                            'set_name' => array(
                                65 => $relatedObjects[65],
                            ),
                        )
                    )
                ),
                'RelationTestAddress' => array(
                    42 => new ezcPersistentIdentity( $relatedObjects[42] ),
                    65 => new ezcPersistentIdentity( $relatedObjects[65] ),
                ),
            ),
            'identities',
            $idMap
        );
    }

    public function testRemoveRelatedObjectNotExistsSuccess()
    {
        $idMap = new ezcPersistentIdentityMap(
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
        $idMap = new ezcPersistentIdentityMap(
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
        $idMap = new ezcPersistentIdentityMap(
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
        $idMap = new ezcPersistentIdentityMap(
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
        $idMap = new ezcPersistentIdentityMap(
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
        $idMap = new ezcPersistentIdentityMap(
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
        $idMap = new ezcPersistentIdentityMap(
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
        $idMap = new ezcPersistentIdentityMap(
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
        $idMap = new ezcPersistentIdentityMap(
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

        $this->assertAttributeEquals(
            array(
                'RelationTestPerson' => array(
                    23 => new ezcPersistentIdentity(
                        $obj,
                        array( 'RelationTestAddress' => $relatedObjects ),
                        array( 'set_name' => $relatedObjects )
                    )
                ),
                'RelationTestAddress' => array(
                    42 => new ezcPersistentIdentity( $relatedObjects[42] ),
                    65 => new ezcPersistentIdentity( $relatedObjects[65] ),
                ),
            ),
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
}

?>
