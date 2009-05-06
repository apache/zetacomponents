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
require_once dirname( __FILE__ ) . "/../data/relation_test_birthday.php";

/**
 * Tests ezcPersistentManyToOneRelation class.
 *
 * @package PersistentObject
 * @subpackage Tests
 */
class ezcPersistentSessionIdentityDecoratorRelationPrefetchTest extends ezcTestCase
{
    protected $defManager;

    protected $queryCreator;

    protected $db;

    public function setup()
    {
        $this->defManager = new ezcPersistentCodeManager(
            dirname( __FILE__ ) . '/../data/'
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

    protected function getLoadQuery( $relations )
    {
        return $this->queryCreator->createLoadQuery( 'RelationTestPerson', 2, $relations );
    }

    protected function getFindQuery( $relations )
    {
        return $this->queryCreator->createFindQuery( 'RelationTestPerson', $relations );
    }

    protected function getOneLevelOneRelationRelations()
    {
        return array(
            'employer' => new ezcPersistentRelationFindDefinition(
                'RelationTestEmployer'
            ),
        );
    }

    protected function getOneLevelMultiRelationRelations()
    {
        return array(
            'employer' => new ezcPersistentRelationFindDefinition(
                'RelationTestEmployer'
            ),
            'address' => new ezcPersistentRelationFindDefinition(
                'RelationTestAddress'
            ),
        );

    }

    protected function getMultiLevelSingleRelationRelations()
    {
        return array(
            'addresses' => new ezcPersistentRelationFindDefinition(
                'RelationTestAddress',
                null,
                array(
                    'habitants' => new ezcPersistentRelationFindDefinition(
                        'RelationTestPerson'
                    )
                )
            ),
        );
    }

    protected function getMultiLevelMultiRelationRelations()
    {
        return array(
            'addresses' => new ezcPersistentRelationFindDefinition(
                'RelationTestAddress',
                null,
                array(
                    'habitants' => new ezcPersistentRelationFindDefinition(
                        'RelationTestPerson',
                        null,
                        array(
                            'habitant_employer' => new ezcPersistentRelationFindDefinition(
                                'RelationTestEmployer'
                            ),
                            'habitant_birthday' => new ezcPersistentRelationFindDefinition(
                                'RelationTestBirthday'
                            ),
                        )
                    )
                )
            ),
            'employer' => new ezcPersistentRelationFindDefinition(
                'RelationTestEmployer'
            ),
            'birthday' => new ezcPersistentRelationFindDefinition(
                'RelationTestBirthday'
            ),
        );
    }

    protected function qi( $identifier )
    {
        return $this->db->quoteIdentifier( $identifier );
    }
}

?>
