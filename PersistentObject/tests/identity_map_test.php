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

    public function testAddIdentityTowSameObjectsSuccess()
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

    public function testAddIdentityTowDifferentObjectsSuccess()
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
}

?>
