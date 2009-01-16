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
     * addIdentity()
     */

    public function testAddIdentitySingleObjectSuccess()
    {
        $idMap = new ezcPersistentIdentityMap(
            $this->definitionManager
        );
        
        $obj     = new RelationTestPerson();
        $obj->id = 23;

        $idMap->addIdentity( $obj );

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

    public function testAddIdentityTowObjectsSameClassSuccess()
    {
        $idMap = new ezcPersistentIdentityMap(
            $this->definitionManager
        );
        
        $objA     = new RelationTestPerson();
        $objA->id = 23;

        $objB     = new RelationTestPerson();
        $objB->id = 42;

        $idMap->addIdentity( $objA );

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

        $idMap->addIdentity( $objB );

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

    public function testAddIdentityTowObjectsDifferentClassSuccess()
    {
        $idMap = new ezcPersistentIdentityMap(
            $this->definitionManager
        );
        
        $objA     = new RelationTestPerson();
        $objA->id = 23;

        $objB     = new RelationTestAddress();
        $objB->id = 23;

        $idMap->addIdentity( $objA );

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

        $idMap->addIdentity( $objB );

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

    public function testAddIdentityMissingDefinitionFailure()
    {
        $idMap = new ezcPersistentIdentityMap(
            $this->definitionManager
        );

        $obj     = new stdClass();
        $obj->id = 23;

        try
        {
            $idMap->addIdentity( $obj );
            $this->fail( 'Exception not thrown on missing persistence definition.' );
        }
        catch( ezcPersistentDefinitionNotFoundException $e ) {}
    }

    public function testAddIdentitySameObjectTwiceFailure()
    {
        $idMap = new ezcPersistentIdentityMap(
            $this->definitionManager
        );
        
        $obj     = new RelationTestPerson();
        $obj->id = 23;

        $idMap->addIdentity( $obj );

        try
        {
            $idMap->addIdentity( $obj );
            $this->fail( 'Exception not thrown on double add of same persistent object.' );
        }
        catch ( ezcPersistentIdentityAlreadyExistsException $e ) {}
    }

    public function testAddIdentityEqualObjectTwiceFailure()
    {
        $idMap = new ezcPersistentIdentityMap(
            $this->definitionManager
        );
        
        $objA     = new RelationTestPerson();
        $objA->id = 23;
        
        $objB     = new RelationTestPerson();
        $objB->id = 23;

        $idMap->addIdentity( $objA );

        try
        {
            $idMap->addIdentity( $objB );
            $this->fail( 'Exception not thrown on double add equal persistent objects.' );
        }
        catch ( ezcPersistentIdentityAlreadyExistsException $e ) {}
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

        $idMap->addIdentity( $obj );
        
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

        $idMap->addIdentity( $objA );
        $idMap->addIdentity( $objB );

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

        $idMap->addIdentity( $objA );
        $idMap->addIdentity( $objB );

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
     * replaceIdentity()
     */

    public function testReplaceIdentitySingleObjectSuccess()
    {
        $idMap = new ezcPersistentIdentityMap(
            $this->definitionManager
        );
        
        $obj     = new RelationTestPerson();
        $obj->id = 23;

        $idMap->replaceIdentity( $obj );

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

    public function testReplaceIdentityTowObjectsSameClassSuccess()
    {
        $idMap = new ezcPersistentIdentityMap(
            $this->definitionManager
        );
        
        $objA     = new RelationTestPerson();
        $objA->id = 23;

        $objB     = new RelationTestPerson();
        $objB->id = 42;

        $idMap->replaceIdentity( $objA );

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

        $idMap->replaceIdentity( $objB );

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

    public function testReplaceIdentityTowObjectsDifferentClassSuccess()
    {
        $idMap = new ezcPersistentIdentityMap(
            $this->definitionManager
        );
        
        $objA     = new RelationTestPerson();
        $objA->id = 23;

        $objB     = new RelationTestAddress();
        $objB->id = 23;

        $idMap->replaceIdentity( $objA );

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

        $idMap->replaceIdentity( $objB );

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

    public function testReplaceIdentityMissingDefinitionFailure()
    {
        $idMap = new ezcPersistentIdentityMap(
            $this->definitionManager
        );

        $obj     = new stdClass();
        $obj->id = 23;

        try
        {
            $idMap->replaceIdentity( $obj );
            $this->fail( 'Exception not thrown on missing persistence definition.' );
        }
        catch( ezcPersistentDefinitionNotFoundException $e ) {}
    }

    public function testReplaceIdentitySameObjectTwiceSuccess()
    {
        $idMap = new ezcPersistentIdentityMap(
            $this->definitionManager
        );
        
        $obj     = new RelationTestPerson();
        $obj->id = 23;

        $idMap->replaceIdentity( $obj );

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

        $idMap->replaceIdentity( $obj );

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

    public function testReplaceIdentityEqualObjectTwiceFailure()
    {
        $idMap = new ezcPersistentIdentityMap(
            $this->definitionManager
        );
        
        $objA     = new RelationTestPerson();
        $objA->id = 23;
        
        $objB     = new RelationTestPerson();
        $objB->id = 23;

        $idMap->replaceIdentity( $objA );

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

        $idMap->replaceIdentity( $objB );

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
     * addRelatedObjects()
     */

    public function testAddRelatedObjectsWithoutNameSuccess()
    {
        $idMap = new ezcPersistentIdentityMap(
            $this->definitionManager
        );
        
        $obj     = new RelationTestPerson();
        $obj->id = 23;
        
        $relatedObjects = array();
        $relatedObjects[0] = new RelationTestAddress();
        $relatedObjects[0]->id = 42;
        $relatedObjects[1] = new RelationTestAddress();
        $relatedObjects[1]->id = 65;

        $idMap->addIdentity( $obj );
        $idMap->addIdentity( $relatedObjects[0] );
        $idMap->addIdentity( $relatedObjects[1] );

        $idMap->addRelatedObjects( $obj, $relatedObjects );

        $this->assertAttributeEquals(
            array(
                'RelationTestPerson' => array(
                    23 => new ezcPersistentIdentity( $obj, $relatedObjects )
                ),
                'RelationTestAddress' => array(
                    42 => new ezcPersistentIdentity( $relatedObjects[0] ),
                    65 => new ezcPersistentIdentity( $relatedObjects[1] ),
                ),
            ),
            'identities',
            $idMap
        );
    }

    public function testAddRelatedObjectsWithNameSuccess()
    {
        $idMap = new ezcPersistentIdentityMap(
            $this->definitionManager
        );
        
        $obj     = new RelationTestPerson();
        $obj->id = 23;
        
        $relatedObjects = array();
        $relatedObjects[0] = new RelationTestAddress();
        $relatedObjects[0]->id = 42;
        $relatedObjects[1] = new RelationTestAddress();
        $relatedObjects[1]->id = 65;

        $idMap->addIdentity( $obj );
        $idMap->addIdentity( $relatedObjects[0] );
        $idMap->addIdentity( $relatedObjects[1] );

        $idMap->addRelatedObjects( $obj, $relatedObjects, 'set_name' );

        $this->assertAttributeEquals(
            array(
                'RelationTestPerson' => array(
                    23 => new ezcPersistentIdentity( $obj, array(), array( 'set_name' => $relatedObjects ) )
                ),
                'RelationTestAddress' => array(
                    42 => new ezcPersistentIdentity( $relatedObjects[0] ),
                    65 => new ezcPersistentIdentity( $relatedObjects[1] ),
                ),
            ),
            'identities',
            $idMap
        );
    }

    public function testAddRelatedObjectsTwiceWithDifferentNamesSuccess()
    {
        $idMap = new ezcPersistentIdentityMap(
            $this->definitionManager
        );
        
        $obj     = new RelationTestPerson();
        $obj->id = 23;
        
        $relatedObjects = array();
        $relatedObjects[0] = new RelationTestAddress();
        $relatedObjects[0]->id = 42;
        $relatedObjects[1] = new RelationTestAddress();
        $relatedObjects[1]->id = 65;

        $idMap->addIdentity( $obj );
        $idMap->addIdentity( $relatedObjects[0] );
        $idMap->addIdentity( $relatedObjects[1] );

        $idMap->addRelatedObjects( $obj, $relatedObjects, 'first_set' );
        $idMap->addRelatedObjects( $obj, $relatedObjects, 'second_set' );

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
                    42 => new ezcPersistentIdentity( $relatedObjects[0] ),
                    65 => new ezcPersistentIdentity( $relatedObjects[1] ),
                ),
            ),
            'identities',
            $idMap
        );
    }

    public function testAddRelatedObjectsMissingIdentityFailure()
    {
        $idMap = new ezcPersistentIdentityMap(
            $this->definitionManager
        );
        
        $obj     = new RelationTestPerson();
        $obj->id = 23;
        
        $relatedObjects = array();
        $relatedObjects[0] = new RelationTestAddress();
        $relatedObjects[0]->id = 42;
        $relatedObjects[1] = new RelationTestAddress();
        $relatedObjects[1]->id = 65;

        $idMap->addIdentity( $obj );
        $idMap->addIdentity( $relatedObjects[0] );

        try
        {
            $idMap->addRelatedObjects( $obj, $relatedObjects );
            $this->fail( 'Exception not thrown on add of related objects where an identity is missing.' );
        }
        catch ( ezcPersistentIdentityMissingException $e ) {}

        $this->assertAttributeEquals(
            array(
                'RelationTestPerson' => array(
                    23 => new ezcPersistentIdentity( $obj )
                ),
                'RelationTestAddress' => array(
                    42 => new ezcPersistentIdentity( $relatedObjects[0] ),
                ),
            ),
            'identities',
            $idMap
        );
    }

    public function testAddRelatedObjectsWithoutNameAlreadyExistFailure()
    {
        $idMap = new ezcPersistentIdentityMap(
            $this->definitionManager
        );
        
        $obj     = new RelationTestPerson();
        $obj->id = 23;
        
        $relatedObjects = array();
        $relatedObjects[0] = new RelationTestAddress();
        $relatedObjects[0]->id = 42;
        $relatedObjects[1] = new RelationTestAddress();
        $relatedObjects[1]->id = 65;

        $idMap->addIdentity( $obj );
        $idMap->addIdentity( $relatedObjects[0] );
        $idMap->addIdentity( $relatedObjects[1] );

        $idMap->addRelatedObjects( $obj, $relatedObjects );

        try
        {
            $idMap->addRelatedObjects( $obj, $relatedObjects );
            $this->fail( 'Exception not thrown on double add of related object set.' );
        }
        catch ( ezcPersistentIdentityRelatedObjectsAlreadyExistException $e ) {}

        $this->assertAttributeEquals(
            array(
                'RelationTestPerson' => array(
                    23 => new ezcPersistentIdentity( $obj, $relatedObjects )
                ),
                'RelationTestAddress' => array(
                    42 => new ezcPersistentIdentity( $relatedObjects[0] ),
                    65 => new ezcPersistentIdentity( $relatedObjects[1] ),
                ),
            ),
            'identities',
            $idMap
        );
    }

    public function testAddRelatedObjectsWithNameAlreadyExistFailure()
    {
        $idMap = new ezcPersistentIdentityMap(
            $this->definitionManager
        );
        
        $obj     = new RelationTestPerson();
        $obj->id = 23;
        
        $relatedObjects = array();
        $relatedObjects[0] = new RelationTestAddress();
        $relatedObjects[0]->id = 42;
        $relatedObjects[1] = new RelationTestAddress();
        $relatedObjects[1]->id = 65;

        $idMap->addIdentity( $obj );
        $idMap->addIdentity( $relatedObjects[0] );
        $idMap->addIdentity( $relatedObjects[1] );

        $idMap->addRelatedObjects( $obj, $relatedObjects, 'set_name' );

        try
        {
            $idMap->addRelatedObjects( $obj, $relatedObjects, 'set_name' );
            $this->fail( 'Exception not thrown on double add of related object set.' );
        }
        catch ( ezcPersistentIdentityRelatedObjectsAlreadyExistException $e ) {}

        $this->assertAttributeEquals(
            array(
                'RelationTestPerson' => array(
                    23 => new ezcPersistentIdentity( $obj, array(), array( 'set_name' => $relatedObjects ) )
                ),
                'RelationTestAddress' => array(
                    42 => new ezcPersistentIdentity( $relatedObjects[0] ),
                ),
            ),
            'identities',
            $idMap
        );
    }

    public function testAddRelatedObjectsInconsistentFailure()
    {
        $idMap = new ezcPersistentIdentityMap(
            $this->definitionManager
        );
        
        $obj     = new RelationTestPerson();
        $obj->id = 23;
        
        $relatedObjects = array();
        $relatedObjects[0] = new RelationTestAddress();
        $relatedObjects[0]->id = 42;
        $relatedObjects[1] = new RelationTestEmployer();
        $relatedObjects[1]->id = 65;

        $idMap->addIdentity( $obj );
        $idMap->addIdentity( $relatedObjects[0] );
        $idMap->addIdentity( $relatedObjects[1] );

        try
        {
            $idMap->addRelatedObjects( $obj, $relatedObjects );
            $this->fail( 'Exception not thrown on inconsistent related object set.' );
        }
        catch ( ezcPersistentIdentityRelatedObjectsInconsistentException $e ) {}

        $this->assertAttributeEquals(
            array(
                'RelationTestPerson' => array(
                    23 => new ezcPersistentIdentity( $obj )
                ),
                'RelationTestAddress' => array(
                    42 => new ezcPersistentIdentity( $relatedObjects[0] ),
                ),
                'RelationTestEmployer' => array(
                    65 => new ezcPersistentIdentity( $relatedObjects[1] ),
                ),
            ),
            'identities',
            $idMap
        );
    }

    /*
     * replaceRelatedObjects()
     */

    public function testReplaceRelatedObjectsWithoutNameNotExistsSuccess()
    {
        $idMap = new ezcPersistentIdentityMap(
            $this->definitionManager
        );
        
        $obj     = new RelationTestPerson();
        $obj->id = 23;
        
        $relatedObjects = array();
        $relatedObjects[0] = new RelationTestAddress();
        $relatedObjects[0]->id = 42;
        $relatedObjects[1] = new RelationTestAddress();
        $relatedObjects[1]->id = 65;

        $idMap->addIdentity( $obj );
        $idMap->addIdentity( $relatedObjects[0] );
        $idMap->addIdentity( $relatedObjects[1] );

        $idMap->replaceRelatedObjects( $obj, $relatedObjects );

        $this->assertAttributeEquals(
            array(
                'RelationTestPerson' => array(
                    23 => new ezcPersistentIdentity( $obj, $relatedObjects )
                ),
                'RelationTestAddress' => array(
                    42 => new ezcPersistentIdentity( $relatedObjects[0] ),
                    65 => new ezcPersistentIdentity( $relatedObjects[1] ),
                ),
            ),
            'identities',
            $idMap
        );
    }

    public function testReplaceRelatedObjectsWithNameNotExsistsSuccess()
    {
        $idMap = new ezcPersistentIdentityMap(
            $this->definitionManager
        );
        
        $obj     = new RelationTestPerson();
        $obj->id = 23;
        
        $relatedObjects = array();
        $relatedObjects[0] = new RelationTestAddress();
        $relatedObjects[0]->id = 42;
        $relatedObjects[1] = new RelationTestAddress();
        $relatedObjects[1]->id = 65;

        $idMap->addIdentity( $obj );
        $idMap->addIdentity( $relatedObjects[0] );
        $idMap->addIdentity( $relatedObjects[1] );

        $idMap->replaceRelatedObjects( $obj, $relatedObjects, 'set_name' );

        $this->assertAttributeEquals(
            array(
                'RelationTestPerson' => array(
                    23 => new ezcPersistentIdentity( $obj, array(), array( 'set_name' => $relatedObjects ) )
                ),
                'RelationTestAddress' => array(
                    42 => new ezcPersistentIdentity( $relatedObjects[0] ),
                    65 => new ezcPersistentIdentity( $relatedObjects[1] ),
                ),
            ),
            'identities',
            $idMap
        );
    }

    public function testReplaceRelatedObjectsTwiceWithDifferentNamesNotExistSuccess()
    {
        $idMap = new ezcPersistentIdentityMap(
            $this->definitionManager
        );
        
        $obj     = new RelationTestPerson();
        $obj->id = 23;
        
        $relatedObjects = array();
        $relatedObjects[0] = new RelationTestAddress();
        $relatedObjects[0]->id = 42;
        $relatedObjects[1] = new RelationTestAddress();
        $relatedObjects[1]->id = 65;

        $idMap->addIdentity( $obj );
        $idMap->addIdentity( $relatedObjects[0] );
        $idMap->addIdentity( $relatedObjects[1] );

        $idMap->replaceRelatedObjects( $obj, $relatedObjects, 'first_set' );
        $idMap->replaceRelatedObjects( $obj, $relatedObjects, 'second_set' );

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
                    42 => new ezcPersistentIdentity( $relatedObjects[0] ),
                    65 => new ezcPersistentIdentity( $relatedObjects[1] ),
                ),
            ),
            'identities',
            $idMap
        );
    }

    public function testReplaceRelatedObjectsMissingIdentityFailure()
    {
        $idMap = new ezcPersistentIdentityMap(
            $this->definitionManager
        );
        
        $obj     = new RelationTestPerson();
        $obj->id = 23;
        
        $relatedObjects = array();
        $relatedObjects[0] = new RelationTestAddress();
        $relatedObjects[0]->id = 42;
        $relatedObjects[1] = new RelationTestAddress();
        $relatedObjects[1]->id = 65;

        $idMap->addIdentity( $obj );
        $idMap->addIdentity( $relatedObjects[0] );

        try
        {
            $idMap->replaceRelatedObjects( $obj, $relatedObjects );
            $this->fail( 'Exception not thrown on add of related objects where an identity is missing.' );
        }
        catch ( ezcPersistentIdentityMissingException $e ) {}

        $this->assertAttributeEquals(
            array(
                'RelationTestPerson' => array(
                    23 => new ezcPersistentIdentity( $obj )
                ),
                'RelationTestAddress' => array(
                    42 => new ezcPersistentIdentity( $relatedObjects[0] ),
                ),
            ),
            'identities',
            $idMap
        );
    }

    public function testReplaceRelatedObjectsWithoutNameAlreadyExistSuccess()
    {
        $idMap = new ezcPersistentIdentityMap(
            $this->definitionManager
        );
        
        $obj     = new RelationTestPerson();
        $obj->id = 23;
        
        $relatedObjects = array();
        $relatedObjects[0] = new RelationTestAddress();
        $relatedObjects[0]->id = 42;
        $relatedObjects[1] = new RelationTestAddress();
        $relatedObjects[1]->id = 65;

        $idMap->addIdentity( $obj );
        $idMap->addIdentity( $relatedObjects[0] );
        $idMap->addIdentity( $relatedObjects[1] );

        $idMap->replaceRelatedObjects( $obj, $relatedObjects );
        $idMap->replaceRelatedObjects( $obj, $relatedObjects );

        $this->assertAttributeEquals(
            array(
                'RelationTestPerson' => array(
                    23 => new ezcPersistentIdentity( $obj, $relatedObjects )
                ),
                'RelationTestAddress' => array(
                    42 => new ezcPersistentIdentity( $relatedObjects[0] ),
                    65 => new ezcPersistentIdentity( $relatedObjects[1] ),
                ),
            ),
            'identities',
            $idMap
        );
    }

    public function testReplaceRelatedObjectsWithNameAlreadyExistSuccess()
    {
        $idMap = new ezcPersistentIdentityMap(
            $this->definitionManager
        );
        
        $obj     = new RelationTestPerson();
        $obj->id = 23;
        
        $relatedObjects = array();
        $relatedObjects[0] = new RelationTestAddress();
        $relatedObjects[0]->id = 42;
        $relatedObjects[1] = new RelationTestAddress();
        $relatedObjects[1]->id = 65;

        $idMap->addIdentity( $obj );
        $idMap->addIdentity( $relatedObjects[0] );
        $idMap->addIdentity( $relatedObjects[1] );

        $idMap->replaceRelatedObjects( $obj, $relatedObjects, 'set_name' );
        $idMap->replaceRelatedObjects( $obj, $relatedObjects, 'set_name' );

        $this->assertAttributeEquals(
            array(
                'RelationTestPerson' => array(
                    23 => new ezcPersistentIdentity( $obj, array(), array( 'set_name' => $relatedObjects ) )
                ),
                'RelationTestAddress' => array(
                    42 => new ezcPersistentIdentity( $relatedObjects[0] ),
                ),
            ),
            'identities',
            $idMap
        );
    }

    public function testReplaceRelatedObjectsInconsistentFailure()
    {
        $idMap = new ezcPersistentIdentityMap(
            $this->definitionManager
        );
        
        $obj     = new RelationTestPerson();
        $obj->id = 23;
        
        $relatedObjects = array();
        $relatedObjects[0] = new RelationTestAddress();
        $relatedObjects[0]->id = 42;
        $relatedObjects[1] = new RelationTestEmployer();
        $relatedObjects[1]->id = 65;

        $idMap->addIdentity( $obj );
        $idMap->addIdentity( $relatedObjects[0] );
        $idMap->addIdentity( $relatedObjects[1] );

        try
        {
            $idMap->replaceRelatedObjects( $obj, $relatedObjects );
            $this->fail( 'Exception not thrown on inconsistent related object set.' );
        }
        catch ( ezcPersistentIdentityRelatedObjectsInconsistentException $e ) {}

        $this->assertAttributeEquals(
            array(
                'RelationTestPerson' => array(
                    23 => new ezcPersistentIdentity( $obj )
                ),
                'RelationTestAddress' => array(
                    42 => new ezcPersistentIdentity( $relatedObjects[0] ),
                ),
                'RelationTestEmployer' => array(
                    65 => new ezcPersistentIdentity( $relatedObjects[1] ),
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
        $relatedObjects[0] = new RelationTestAddress();
        $relatedObjects[0]->id = 42;
        $relatedObjects[1] = new RelationTestAddress();
        $relatedObjects[1]->id = 65;

        $idMap->addIdentity( $obj );
        $idMap->addIdentity( $relatedObjects[0] );
        $idMap->addIdentity( $relatedObjects[1] );

        $idMap->addRelatedObjects( $obj, $relatedObjects );

        $this->assertAttributeEquals(
            array(
                'RelationTestPerson' => array(
                    23 => new ezcPersistentIdentity(
                        $obj,
                        $relatedObjects
                    )
                ),
                'RelationTestAddress' => array(
                    42 => new ezcPersistentIdentity( $relatedObjects[0] ),
                    65 => new ezcPersistentIdentity( $relatedObjects[1] ),
                ),
            ),
            'identities',
            $idMap
        );

        $newRelatedObject     = new RelationTestAddress();
        $newRelatedObject->id = 3;
        
        $idMap->addIdentity( $newRelatedObject );

        $this->assertAttributeEquals(
            array(
                'RelationTestPerson' => array(
                    23 => new ezcPersistentIdentity(
                        $obj,
                        array_merge( $relatedObjects, array( 3 => $newRelatedObject ) )
                    ),
                ),
                'RelationTestAddress' => array(
                    42 => new ezcPersistentIdentity( $relatedObjects[0] ),
                    65 => new ezcPersistentIdentity( $relatedObjects[1] ),
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
        
        $idMap->addIdentity( $obj );

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
        
        $idMap->addIdentity( $newRelatedObject );

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
        $relatedObjects[0] = new RelationTestAddress();
        $relatedObjects[0]->id = 42;
        $relatedObjects[1] = new RelationTestAddress();
        $relatedObjects[1]->id = 65;

        $idMap->addIdentity( $obj );
        $idMap->addIdentity( $relatedObjects[0] );
        $idMap->addIdentity( $relatedObjects[1] );

        $idMap->addRelatedObjects( $obj, $relatedObjects );
        $idMap->addRelatedObjects( $obj, $relatedObjects, 'named_set' );

        $this->assertAttributeEquals(
            array(
                'RelationTestPerson' => array(
                    23 => new ezcPersistentIdentity(
                        $obj,
                        $relatedObjects,
                        array( 'named_set' => $relatedObjects )
                    )
                ),
                'RelationTestAddress' => array(
                    42 => new ezcPersistentIdentity( $relatedObjects[0] ),
                    65 => new ezcPersistentIdentity( $relatedObjects[1] ),
                ),
            )
        );

        $newRelatedObject     = new RelationTestAddress();
        $newRelatedObject->id = 3;
        
        $idMap->addIdentity( $newRelatedObject );

        $idMap->addRelatedObject( $obj, $newRelatedObject );

        $this->assertAttributeEquals(
            array(
                'RelationTestPerson' => array(
                    23 => new ezcPersistentIdentity(
                        $obj,
                        $relatedObjects
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

    public function testAddRelatedObjectMissingIdentityFailure()
    {
        $idMap = new ezcPersistentIdentityMap(
            $this->definitionManager
        );
        
        $obj     = new RelationTestPerson();
        $obj->id = 23;
        
        $idMap->addIdentity( $obj );

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
        
        $idMap->addIdentity( $obj );

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
        $relatedObjects[0] = new RelationTestAddress();
        $relatedObjects[0]->id = 42;
        $relatedObjects[1] = new RelationTestAddress();
        $relatedObjects[1]->id = 65;

        $idMap->addIdentity( $obj );
        $idMap->addIdentity( $relatedObjects[0] );
        $idMap->addIdentity( $relatedObjects[1] );

        $idMap->addRelatedObjects( $obj, $relatedObjects );
        
        $this->assertAttributeEquals(
            array(
                'RelationTestPerson' => array(
                    23 => new ezcPersistentIdentity(
                        $obj,
                        $relatedObjects
                    )
                ),
                'RelationTestAddress' => array(
                    42 => new ezcPersistentIdentity( $relatedObjects[0] ),
                    65 => new ezcPersistentIdentity( $relatedObjects[1] ),
                ),
            ),
            'identities',
            $idMap
        );

        $idMap->removeRelatedObject( $obj, $relatedObjects[0] );

        $this->assertAttributeEquals(
            array(
                'RelationTestPerson' => array(
                    23 => new ezcPersistentIdentity(
                        $obj,
                        array(
                            65 => $relatedObjects[1],
                        )
                    )
                ),
                'RelationTestAddress' => array(
                    42 => new ezcPersistentIdentity( $relatedObjects[0] ),
                    65 => new ezcPersistentIdentity( $relatedObjects[1] ),
                ),
            ),
            'identities',
            $idMap
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
        $relatedObjects[0] = new RelationTestAddress();
        $relatedObjects[0]->id = 42;
        $relatedObjects[1] = new RelationTestAddress();
        $relatedObjects[1]->id = 65;

        $idMap->addIdentity( $obj );
        $idMap->addIdentity( $relatedObjects[0] );
        $idMap->addIdentity( $relatedObjects[1] );

        $idMap->addRelatedObjects( $obj, $relatedObjects );
        $idMap->addRelatedObjects( $obj, $relatedObjects, 'set_name' );
        
        $this->assertAttributeEquals(
            array(
                'RelationTestPerson' => array(
                    23 => new ezcPersistentIdentity(
                        $obj,
                        $relatedObjects,
                        array( 'set_name' => $relatedObjects )
                    )
                ),
                'RelationTestAddress' => array(
                    42 => new ezcPersistentIdentity( $relatedObjects[0] ),
                    65 => new ezcPersistentIdentity( $relatedObjects[1] ),
                ),
            ),
            'identities',
            $idMap
        );

        $idMap->removeRelatedObject( $obj, $relatedObjects[0] );

        $this->assertAttributeEquals(
            array(
                'RelationTestPerson' => array(
                    23 => new ezcPersistentIdentity(
                        $obj,
                        array(
                            65 => $relatedObjects[1],
                        ),
                        array(
                            'set_name' => array(
                                65 => $relatedObjects[1],
                            ),
                        )
                    )
                ),
                'RelationTestAddress' => array(
                    42 => new ezcPersistentIdentity( $relatedObjects[0] ),
                    65 => new ezcPersistentIdentity( $relatedObjects[1] ),
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

        $idMap->addIdentity( $obj );
        
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
}

?>
