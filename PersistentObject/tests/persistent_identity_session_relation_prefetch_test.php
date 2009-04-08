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
require_once dirname( __FILE__ ) . "/data/relation_test_birthday.php";

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

        try
        {
            $this->db = ezcDbInstance::get();
        }
        catch ( Exception $e )
        {
            $this->markTestSkipped( 'There was no database configured' );
        }

        $this->queryCreator = new ezcPersistentIdentityRelationQueryCreator(
            $this->defManager,
            $this->db
        );

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

    protected function getOneLevelMultiRelationRelations()
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
    
    protected function getOneLevelMultiRelationQuery( $relations )
    {
        $q = new ezcQuerySelect( $this->db );

        $this->queryCreator->createQuery( $q, 'RelationTestPerson', 2, $relations );

        return $q;
    }

    protected function getMultiLevelSingleRelationRelations()
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

    protected function getMultiLevelSingleRelationQuery( $relations )
    {
        $q = new ezcQuerySelect( $this->db );

        $this->queryCreator->createQuery( $q, 'RelationTestPerson', 2, $relations );

        return $q;
    }
    

    protected function getMultiLevelMultiRelationRelations()
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

    protected function getMultiLevelMultiRelationQuery( $relations )
    {
        $q = new ezcQuerySelect( $this->db );

        $this->queryCreator->createQuery( $q, 'RelationTestPerson', 2, $relations );
        
        return $q;
    }
}

?>
