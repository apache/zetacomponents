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
class ezcPersistentSessionIdentityDecoratorRelationQueryCreatorTest extends ezcPersistentSessionIdentityDecoratorRelationPrefetchTest
{
    public static function suite()
    {
        return new PHPUnit_Framework_TestSuite( __CLASS__ );
    }

    public function testCreateOneLevelOneRelationLoadQuery()
    {
        $this->assertEquals(
            $this->getLoadQueryDummy( $this->getOneLevelOneRelationQueryDummy() )->getQuery(),
            $this->getLoadQuery(
                $this->getOneLevelOneRelationRelations()
            )->getQuery()
        );
    }

    public function testCreateOneLevelOneRelationFindQuery()
    {
        $this->assertEquals(
            $this->getFindQueryDummy( $this->getOneLevelOneRelationQueryDummy() )->getQuery(),
            $this->getFindQuery(
                $this->getOneLevelOneRelationRelations()
            )->getQuery()
        );
    }

    public function testCreateOneLevelMultiRelationLoadQuery()
    {
        $this->assertEquals(
            $this->getLoadQueryDummy( $this->getOneLevelMultiRelationQueryDummy() )->getQuery(),
            $this->getLoadQuery(
                $this->getOneLevelMultiRelationRelations()
            )->getQuery()
        );
    }

    public function testCreateOneLevelMultiRelationFindQuery()
    {
        $this->assertEquals(
            $this->getFindQueryDummy( $this->getOneLevelMultiRelationQueryDummy() )->getQuery(),
            $this->getFindQuery(
                $this->getOneLevelMultiRelationRelations()
            )->getQuery()
        );
    }

    public function testCreateMultiLevelSingleRelationLoadQuery()
    {
        $this->assertEquals(
            $this->getLoadQueryDummy( $this->getMultiLevelSingleRelationQueryDummy() )->getQuery(),
            $this->getLoadQuery(
                $this->getMultiLevelSingleRelationRelations()
            )->getQuery()
        );
    }

    public function testCreateMultiLevelSingleRelationFindQuery()
    {
        $this->assertEquals(
            $this->getFindQueryDummy( $this->getMultiLevelSingleRelationQueryDummy() )->getQuery(),
            $this->getFindQuery(
                $this->getMultiLevelSingleRelationRelations()
            )->getQuery()
        );
    }

    public function testCreateMultiLevelMultiRelationLoadQuery()
    {
        $this->assertEquals(
            $this->getLoadQueryDummy( $this->getMultiLevelMultiRelationQueryDummy() )->getQuery(),
            $this->getLoadQuery(
                $this->getMultiLevelMultiRelationRelations()
            )->getQuery()
        );
    }

    public function testCreateMultiLevelMultiRelationFindQuery()
    {
        $this->assertEquals(
            $this->getFindQueryDummy( $this->getMultiLevelMultiRelationQueryDummy() )->getQuery(),
            $this->getFindQuery(
                $this->getMultiLevelMultiRelationRelations()
            )->getQuery()
        );
    }

    protected function getLoadQueryDummy( $q )
    {
        $q->where(
            $q->expr->eq(
                $this->qi( 'PO_persons' ) . '.' . $this->qi( 'id' ),
                $q->bindValue( 1 )
            )
        );
        return $q;
    }

    protected function getFindQueryDummy( $q )
    {
        return new ezcPersistentFindWithRelationsQuery(
            $q,
            'RelationTestPerson',
            $this->getOneLevelOneRelationRelations()
        );
    }

    protected function getOneLevelOneRelationQueryDummy()
    {
        $q = $this->db->createSelectQuery();

        $q->select(
            $q->alias(
               $this->qi( 'PO_persons' ) . '.' . $this->qi( 'id' ),
               $this->qi( 'id' )
            ),
            $q->alias(
               $this->qi( 'PO_persons' ) . '.' . $this->qi( 'firstname' ),
               $this->qi( 'firstname' )
            ),
            $q->alias(
               $this->qi( 'PO_persons' ) . '.' . $this->qi( 'surname' ),
               $this->qi( 'surname' )
            ),
            $q->alias(
               $this->qi( 'PO_persons' ) . '.' . $this->qi( 'employer' ),
               $this->qi( 'employer' )
            ),
            $q->alias(
               $this->qi( 'employer' ) . '.' . $this->qi( 'id' ),
               $this->qi( 'employer_id' )
            ),
            $q->alias(
               $this->qi( 'employer' ) . '.' . $this->qi( 'name' ),
               $this->qi( 'employer_name' )
            )
        )->from(
            $this->qi( 'PO_persons' )
        )->leftJoin(
            $q->alias(
                $this->qi( 'PO_employers' ),
                $this->qi( 'employer' )
            ),
            $q->expr->eq(
                $this->qi( 'PO_persons' ) . '.' . $this->qi( 'employer' ),
                $this->qi( 'employer' ) . '.' . $this->qi( 'id' )
            )
        );

        return $q;
    }

    protected function getOneLevelMultiRelationQueryDummy()
    {
        $q = $this->db->createSelectQuery();

        $q->select(
            $q->alias(
               $this->qi( 'PO_persons' ) . '.' . $this->qi( 'id' ),
               $this->qi( 'id' )
            ),
            $q->alias(
               $this->qi( 'PO_persons' ) . '.' . $this->qi( 'firstname' ),
               $this->qi( 'firstname' )
            ),
            $q->alias(
               $this->qi( 'PO_persons' ) . '.' . $this->qi( 'surname' ),
               $this->qi( 'surname' )
            ),
            $q->alias(
               $this->qi( 'PO_persons' ) . '.' . $this->qi( 'employer' ),
               $this->qi( 'employer' )
            ),
            $q->alias(
               $this->qi( 'employer' ) . '.' . $this->qi( 'id' ),
               $this->qi( 'employer_id' )
            ),
            $q->alias(
               $this->qi( 'employer' ) . '.' . $this->qi( 'name' ),
               $this->qi( 'employer_name' )
            ),
            $q->alias(
               $this->qi( 'address' ) . '.' . $this->qi( 'id' ),
               $this->qi( 'address_id' )
            ),
            $q->alias(
               $this->qi( 'address' ) . '.' . $this->qi( 'street' ),
               $this->qi( 'address_street' )
            ),
            $q->alias(
               $this->qi( 'address' ) . '.' . $this->qi( 'zip' ),
               $this->qi( 'address_zip' )
            ),
            $q->alias(
               $this->qi( 'address' ) . '.' . $this->qi( 'city' ),
               $this->qi( 'address_city' )
            ),
            $q->alias(
               $this->qi( 'address' ) . '.' . $this->qi( 'type' ),
               $this->qi( 'address_type' )
            )
        )->from(
            $this->qi( 'PO_persons' )
        )->leftJoin(
            $q->alias(
                $this->qi( 'PO_employers' ),
                $this->qi( 'employer' )
            ),
            $q->expr->eq(
                $this->qi( 'PO_persons' ) . '.' . $this->qi( 'employer' ),
                $this->qi( 'employer' ) . '.' . $this->qi( 'id' )
            )
        )->leftJoin(
            $q->alias(
                $this->qi( 'PO_persons_addresses' ),
                $this->qi( 'PO_persons__address' )
            ),
            $q->expr->eq(
                $this->qi( 'PO_persons' ) . '.' . $this->qi( 'id' ),
                $this->qi( 'PO_persons__address' ) . '.' . $this->qi( 'person_id' )
            )
        )->leftJoin(
            $q->alias(
                $this->qi( 'PO_addresses' ),
                $this->qi( 'address' )
            ),
            $q->expr->eq(
                $this->qi( 'PO_persons__address' ) . '.' . $this->qi( 'address_id' ),
                $this->qi( 'address' ) . '.' . $this->qi( 'id' )
            )
        );

        return $q;
    }

    protected function getMultiLevelSingleRelationQueryDummy()
    {
        $q = $this->db->createSelectQuery();

        $q->select(
            $q->alias(
               $this->qi( 'PO_persons' ) . '.' . $this->qi( 'id' ),
               $this->qi( 'id' )
            ),
            $q->alias(
               $this->qi( 'PO_persons' ) . '.' . $this->qi( 'firstname' ),
               $this->qi( 'firstname' )
            ),
            $q->alias(
               $this->qi( 'PO_persons' ) . '.' . $this->qi( 'surname' ),
               $this->qi( 'surname' )
            ),
            $q->alias(
               $this->qi( 'PO_persons' ) . '.' . $this->qi( 'employer' ),
               $this->qi( 'employer' )
            ),
            $q->alias(
               $this->qi( 'addresses' ) . '.' . $this->qi( 'id' ),
               $this->qi( 'addresses_id' )
            ),
            $q->alias(
               $this->qi( 'addresses' ) . '.' . $this->qi( 'street' ),
               $this->qi( 'addresses_street' )
            ),
            $q->alias(
               $this->qi( 'addresses' ) . '.' . $this->qi( 'zip' ),
               $this->qi( 'addresses_zip' )
            ),
            $q->alias(
               $this->qi( 'addresses' ) . '.' . $this->qi( 'city' ),
               $this->qi( 'addresses_city' )
            ),
            $q->alias(
               $this->qi( 'addresses' ) . '.' . $this->qi( 'type' ),
               $this->qi( 'addresses_type' )
            ),
            $q->alias(
               $this->qi( 'habitants' ) . '.' . $this->qi( 'id' ),
               $this->qi( 'habitants_id' )
            ),
            $q->alias(
               $this->qi( 'habitants' ) . '.' . $this->qi( 'firstname' ),
               $this->qi( 'habitants_firstname' )
            ),
            $q->alias(
               $this->qi( 'habitants' ) . '.' . $this->qi( 'surname' ),
               $this->qi( 'habitants_surname' )
            ),
            $q->alias(
               $this->qi( 'habitants' ) . '.' . $this->qi( 'employer' ),
               $this->qi( 'habitants_employer' )
            )
        )->from(
            $this->qi( 'PO_persons' )
        )->leftJoin(
            $q->alias(
                $this->qi( 'PO_persons_addresses' ),
                $this->qi( 'PO_persons__addresses' )
            ),
            $q->expr->eq(
                $this->qi( 'PO_persons' ) . '.' . $this->qi( 'id' ),
                $this->qi( 'PO_persons__addresses' ) . '.' . $this->qi( 'person_id' )
            )
        )->leftJoin(
            $q->alias(
                $this->qi( 'PO_addresses' ),
                $this->qi( 'addresses' )
            ),
            $q->expr->eq(
                $this->qi( 'PO_persons__addresses' ) . '.' . $this->qi( 'address_id' ),
                $this->qi( 'addresses' ) . '.' . $this->qi( 'id' )
            )
        )->leftJoin(
            $q->alias(
                $this->qi( 'PO_persons_addresses' ),
                $this->qi( 'addresses__habitants' )
            ),
            $q->expr->eq(
                $this->qi( 'addresses' ) . '.' . $this->qi( 'id' ),
                $this->qi( 'addresses__habitants' ) . '.' . $this->qi( 'address_id' )
            )
        )->leftJoin(
            $q->alias(
                $this->qi( 'PO_persons' ),
                $this->qi( 'habitants' )
            ),
            $q->expr->eq(
                $this->qi( 'addresses__habitants' ) . '.' . $this->qi( 'person_id' ),
                $this->qi( 'habitants' ) . '.' . $this->qi( 'id' )
            )
        );

        return $q;
    }

    protected function getMultiLevelMultiRelationQueryDummy()
    {
        $q = $this->db->createSelectQuery();

        $q->select(
            $q->alias(
               $this->qi( 'PO_persons' ) . '.' . $this->qi( 'id' ),
               $this->qi( 'id' )
            ),
            $q->alias(
               $this->qi( 'PO_persons' ) . '.' . $this->qi( 'firstname' ),
               $this->qi( 'firstname' )
            ),
            $q->alias(
               $this->qi( 'PO_persons' ) . '.' . $this->qi( 'surname' ),
               $this->qi( 'surname' )
            ),
            $q->alias(
               $this->qi( 'PO_persons' ) . '.' . $this->qi( 'employer' ),
               $this->qi( 'employer' )
            ),
            $q->alias(
               $this->qi( 'addresses' ) . '.' . $this->qi( 'id' ),
               $this->qi( 'addresses_id' )
            ),
            $q->alias(
               $this->qi( 'addresses' ) . '.' . $this->qi( 'street' ),
               $this->qi( 'addresses_street' )
            ),
            $q->alias(
               $this->qi( 'addresses' ) . '.' . $this->qi( 'zip' ),
               $this->qi( 'addresses_zip' )
            ),
            $q->alias(
               $this->qi( 'addresses' ) . '.' . $this->qi( 'city' ),
               $this->qi( 'addresses_city' )
            ),
            $q->alias(
               $this->qi( 'addresses' ) . '.' . $this->qi( 'type' ),
               $this->qi( 'addresses_type' )
            ),
            $q->alias(
               $this->qi( 'habitants' ) . '.' . $this->qi( 'id' ),
               $this->qi( 'habitants_id' )
            ),
            $q->alias(
               $this->qi( 'habitants' ) . '.' . $this->qi( 'firstname' ),
               $this->qi( 'habitants_firstname' )
            ),
            $q->alias(
               $this->qi( 'habitants' ) . '.' . $this->qi( 'surname' ),
               $this->qi( 'habitants_surname' )
            ),
            $q->alias(
               $this->qi( 'habitants' ) . '.' . $this->qi( 'employer' ),
               $this->qi( 'habitants_employer' )
            ),
            $q->alias(
               $this->qi( 'habitant_employer' ) . '.' . $this->qi( 'id' ),
               $this->qi( 'habitant_employer_id' )
            ),
            $q->alias(
               $this->qi( 'habitant_employer' ) . '.' . $this->qi( 'name' ),
               $this->qi( 'habitant_employer_name' )
            ),
            $q->alias(
               $this->qi( 'habitant_birthday' ) . '.' . $this->qi( 'person_id' ),
               $this->qi( 'habitant_birthday_person' )
            ),
            $q->alias(
               $this->qi( 'habitant_birthday' ) . '.' . $this->qi( 'birthday' ),
               $this->qi( 'habitant_birthday_birthday' )
            ),
            $q->alias(
               $this->qi( 'employer' ) . '.' . $this->qi( 'id' ),
               $this->qi( 'employer_id' )
            ),
            $q->alias(
               $this->qi( 'employer' ) . '.' . $this->qi( 'name' ),
               $this->qi( 'employer_name' )
            ),
            $q->alias(
               $this->qi( 'birthday' ) . '.' . $this->qi( 'person_id' ),
               $this->qi( 'birthday_person' )
            ),
            $q->alias(
               $this->qi( 'birthday' ) . '.' . $this->qi( 'birthday' ),
               $this->qi( 'birthday_birthday' )
            )
        )->from(
            $this->qi( 'PO_persons' )
        )->leftJoin(
            $q->alias(
                $this->qi( 'PO_persons_addresses' ),
                $this->qi( 'PO_persons__addresses' )
            ),
            $q->expr->eq(
                $this->qi( 'PO_persons' ) . '.' . $this->qi( 'id' ),
                $this->qi( 'PO_persons__addresses' ) . '.' . $this->qi( 'person_id' )
            )
        )->leftJoin(
            $q->alias(
                $this->qi( 'PO_addresses' ),
                $this->qi( 'addresses' )
            ),
            $q->expr->eq(
                $this->qi( 'PO_persons__addresses' ) . '.' . $this->qi( 'address_id' ),
                $this->qi( 'addresses' ) . '.' . $this->qi( 'id' )
            )
        )->leftJoin(
            $q->alias(
                $this->qi( 'PO_persons_addresses' ),
                $this->qi( 'addresses__habitants' )
            ),
            $q->expr->eq(
                $this->qi( 'addresses' ) . '.' . $this->qi( 'id' ),
                $this->qi( 'addresses__habitants' ) . '.' . $this->qi( 'address_id' )
            )
        )->leftJoin(
            $q->alias(
                $this->qi( 'PO_persons' ),
                $this->qi( 'habitants' )
            ),
            $q->expr->eq(
                $this->qi( 'addresses__habitants' ) . '.' . $this->qi( 'person_id' ),
                $this->qi( 'habitants' ) . '.' . $this->qi( 'id' )
            )
        )->leftJoin(
            $q->alias(
                $this->qi( 'PO_employers' ),
                $this->qi( 'habitant_employer' )
            ),
            $q->expr->eq(
                $this->qi( 'habitants' ) . '.' . $this->qi( 'employer' ),
                $this->qi( 'habitant_employer' ) . '.' . $this->qi( 'id' )
            )
        )->leftJoin(
            $q->alias(
                $this->qi( 'PO_birthdays' ),
                $this->qi( 'habitant_birthday' )
            ),
            $q->expr->eq(
                $this->qi( 'habitants' ) . '.' . $this->qi( 'id' ),
                $this->qi( 'habitant_birthday' ) . '.' . $this->qi( 'person_id' )
            )
        )->leftJoin(
            $q->alias(
                $this->qi( 'PO_employers' ),
                $this->qi( 'employer' )
            ),
            $q->expr->eq(
                $this->qi( 'PO_persons' ) . '.' . $this->qi( 'employer' ),
                $this->qi( 'employer' ) . '.' . $this->qi( 'id' )
            )
        )->leftJoin(
            $q->alias(
                $this->qi( 'PO_birthdays' ),
                $this->qi( 'birthday' )
            ),
            $q->expr->eq(
                $this->qi( 'PO_persons' ) . '.' . $this->qi( 'id' ),
                $this->qi( 'birthday' ) . '.' . $this->qi( 'person_id' )
            )
        );

        return $q;
    }
}

?>
