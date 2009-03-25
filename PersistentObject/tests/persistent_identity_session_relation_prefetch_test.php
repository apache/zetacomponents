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
class ezcPersistentIdentitySessionRelationPrefetchTest extends ezcTestCase
{
    protected $defManager;

    protected $queryCreator;

    protected $db;

    public function setup()
    {
        $this->defManager = new ezcPersistentCodeManager(
            dirname( __FILE__ ) . '/data/'
        );
        $this->queryCreator = new ezcPersistentIdentityRelationQueryCreator(
            $this->defManager
        );
        // Use hardcoded SQLite here, to create unified SQL statements
        $this->db = ezcDbFactory::create( 'sqlite://:memory:' );

        // @TODO: This is currently needed to fix the attribute set in
        // ezcDbHandler. Should be removed as soon as this is fixed!
        $this->db->setAttribute( PDO::ATTR_CASE, PDO::CASE_NATURAL );
    }

    protected function getOneLevelOneRelationRelations()
    {
        return array(
            new ezcPersistentRelationFindDefinition(
                'RelationTestEmployer'
            ),
        );
    }

    protected function getOneLevelOneRelationQuery( $relations )
    {
        $q = new ezcQuerySelect( $this->db );

        $this->queryCreator->createQuery( $q, 'RelationTestPerson', 2, $relations );

        return $q;
    }

    protected function getCreateOneLevelMultiRelationRelations()
    {
        return array(
            new ezcPersistentRelationFindDefinition(
                'RelationTestEmployer'
            ),
            new ezcPersistentRelationFindDefinition(
                'RelationTestAddress'
            ),
        );

    }
    
    protected function getCreateOneLevelMultiRelationQuery( $relations )
    {
        $q = new ezcQuerySelect( $this->db );

        $this->queryCreator->createQuery( $q, 'RelationTestPerson', 2, $relations );

        return $q;
    }

    protected function getCreateMultiLevelSingleRelationRelations()
    {
        return array(
            new ezcPersistentRelationFindDefinition(
                'RelationTestAddress',
                null,
                array(
                    new ezcPersistentRelationFindDefinition(
                        'RelationTestPerson'
                    )
                )
            ),
        );
    }

    protected function getCreateMultiLevelSingleRelationQuery( $relations )
    {
        $q = new ezcQuerySelect( $this->db );

        $this->queryCreator->createQuery( $q, 'RelationTestPerson', 2, $relations );

        return $q;
    }
    

    protected function getCreateMultiLevelMultiRelationRelations()
    {
        return array(
            new ezcPersistentRelationFindDefinition(
                'RelationTestAddress',
                null,
                array(
                    new ezcPersistentRelationFindDefinition(
                        'RelationTestPerson',
                        null,
                        array(
                            new ezcPersistentRelationFindDefinition(
                                'RelationTestEmployer'
                            ),
                            new ezcPersistentRelationFindDefinition(
                                'RelationTestBirthday'
                            ),
                        )
                    )
                )
            ),
            new ezcPersistentRelationFindDefinition(
                'RelationTestEmployer'
            ),
            new ezcPersistentRelationFindDefinition(
                'RelationTestBirthday'
            ),
        );
    }

    protected function getCreateMultiLevelMultiRelationQuery( $relations )
    {
        $q = new ezcQuerySelect( $this->db );

        $this->queryCreator->createQuery( $q, 'RelationTestPerson', 2, $relations );
        
        return $q;
    }
}

?>
