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
class ezcPersistentIdentitySessionRelationQueryCreatorTest extends ezcPersistentIdentitySessionRelationPrefetchTest
{
    public static function suite()
    {
        return new PHPUnit_Framework_TestSuite( __CLASS__ );
    }

    public function testCreateOneLevelOneRelationQuery()
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
               $this->qi( 'PO_employers_1' ) . '.' . $this->qi( 'id' ),
               $this->qi( 'PO_employers_1_id' )
            ),
            $q->alias(
               $this->qi( 'PO_employers_1' ) . '.' . $this->qi( 'name' ),
               $this->qi( 'PO_employers_1_name' )
            )
        )->from(
            $this->qi( 'PO_persons' )
        )->leftJoin(
            $q->alias(
                $this->qi( 'PO_employers' ),
                $this->qi( 'PO_employers_1' )
            ),
            $q->expr->eq(
                $this->qi( 'PO_persons' ) . '.' . $this->qi( 'employer' ),
                $this->qi( 'PO_employers_1' ) . '.' . $this->qi( 'id' )
            )
        )->where(
            $q->expr->eq(
                $this->qi( 'PO_persons' ) . '.' . $this->qi( 'id' ),
                $q->bindValue( 1 )
            )
        );

        $this->assertEquals(
            $q->getQuery(),
            $this->getOneLevelOneRelationQuery(
                $this->getOneLevelOneRelationRelations()
            )->getQuery()
        );
    }

    public function testCreateOneLevelMultiRelationQuery()
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
               $this->qi( 'PO_employers_1' ) . '.' . $this->qi( 'id' ),
               $this->qi( 'PO_employers_1_id' )
            ),
            $q->alias(
               $this->qi( 'PO_employers_1' ) . '.' . $this->qi( 'name' ),
               $this->qi( 'PO_employers_1_name' )
            ),
            $q->alias(
               $this->qi( 'PO_addresses_1' ) . '.' . $this->qi( 'id' ),
               $this->qi( 'PO_addresses_1_id' )
            ),
            $q->alias(
               $this->qi( 'PO_addresses_1' ) . '.' . $this->qi( 'street' ),
               $this->qi( 'PO_addresses_1_street' )
            ),
            $q->alias(
               $this->qi( 'PO_addresses_1' ) . '.' . $this->qi( 'zip' ),
               $this->qi( 'PO_addresses_1_zip' )
            ),
            $q->alias(
               $this->qi( 'PO_addresses_1' ) . '.' . $this->qi( 'city' ),
               $this->qi( 'PO_addresses_1_city' )
            ),
            $q->alias(
               $this->qi( 'PO_addresses_1' ) . '.' . $this->qi( 'type' ),
               $this->qi( 'PO_addresses_1_type' )
            )
        )->from(
            $this->qi( 'PO_persons' )
        )->leftJoin(
            $q->alias(
                $this->qi( 'PO_employers' ),
                $this->qi( 'PO_employers_1' )
            ),
            $q->expr->eq(
                $this->qi( 'PO_persons' ) . '.' . $this->qi( 'employer' ),
                $this->qi( 'PO_employers_1' ) . '.' . $this->qi( 'id' )
            )
        )->leftJoin(
            $q->alias(
                $this->qi( 'PO_persons_addresses' ),
                $this->qi( 'PO_persons_addresses_1' )
            ),
            $q->expr->eq(
                $this->qi( 'PO_persons' ) . '.' . $this->qi( 'id' ),
                $this->qi( 'PO_persons_addresses_1' ) . '.' . $this->qi( 'person_id' )
            )
        )->leftJoin(
            $q->alias(
                $this->qi( 'PO_addresses' ),
                $this->qi( 'PO_addresses_1' )
            ),
            $q->expr->eq(
                $this->qi( 'PO_persons_addresses_1' ) . '.' . $this->qi( 'address_id' ),
                $this->qi( 'PO_addresses_1' ) . '.' . $this->qi( 'id' )
            )
        )->where(
            $q->expr->eq(
                $this->qi( 'PO_persons' ) . '.' . $this->qi( 'id' ),
                $q->bindValue( 1 )
            )
        );

        $this->assertEquals(
            $q->getQuery(),
            $this->getOneLevelMultiRelationQuery(
                $this->getOneLevelMultiRelationRelations()
            )->getQuery()
        );
    }

    public function testCreateMultiLevelSingleRelationQuery()
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
               $this->qi( 'PO_addresses_1' ) . '.' . $this->qi( 'id' ),
               $this->qi( 'PO_addresses_1_id' )
            ),
            $q->alias(
               $this->qi( 'PO_addresses_1' ) . '.' . $this->qi( 'street' ),
               $this->qi( 'PO_addresses_1_street' )
            ),
            $q->alias(
               $this->qi( 'PO_addresses_1' ) . '.' . $this->qi( 'zip' ),
               $this->qi( 'PO_addresses_1_zip' )
            ),
            $q->alias(
               $this->qi( 'PO_addresses_1' ) . '.' . $this->qi( 'city' ),
               $this->qi( 'PO_addresses_1_city' )
            ),
            $q->alias(
               $this->qi( 'PO_addresses_1' ) . '.' . $this->qi( 'type' ),
               $this->qi( 'PO_addresses_1_type' )
            ),
            $q->alias(
               $this->qi( 'PO_persons_1' ) . '.' . $this->qi( 'id' ),
               $this->qi( 'PO_persons_1_id' )
            ),
            $q->alias(
               $this->qi( 'PO_persons_1' ) . '.' . $this->qi( 'firstname' ),
               $this->qi( 'PO_persons_1_firstname' )
            ),
            $q->alias(
               $this->qi( 'PO_persons_1' ) . '.' . $this->qi( 'surname' ),
               $this->qi( 'PO_persons_1_surname' )
            ),
            $q->alias(
               $this->qi( 'PO_persons_1' ) . '.' . $this->qi( 'employer' ),
               $this->qi( 'PO_persons_1_employer' )
            )
        )->from(
            $this->qi( 'PO_persons' )
        )->leftJoin(
            $q->alias(
                $this->qi( 'PO_persons_addresses' ),
                $this->qi( 'PO_persons_addresses_1' )
            ),
            $q->expr->eq(
                $this->qi( 'PO_persons' ) . '.' . $this->qi( 'id' ),
                $this->qi( 'PO_persons_addresses_1' ) . '.' . $this->qi( 'person_id' )
            )
        )->leftJoin(
            $q->alias(
                $this->qi( 'PO_addresses' ),
                $this->qi( 'PO_addresses_1' )
            ),
            $q->expr->eq(
                $this->qi( 'PO_persons_addresses_1' ) . '.' . $this->qi( 'address_id' ),
                $this->qi( 'PO_addresses_1' ) . '.' . $this->qi( 'id' )
            )
        )->leftJoin(
            $q->alias(
                $this->qi( 'PO_persons_addresses' ),
                $this->qi( 'PO_persons_addresses_2' )
            ),
            $q->expr->eq(
                $this->qi( 'PO_addresses_1' ) . '.' . $this->qi( 'id' ),
                $this->qi( 'PO_persons_addresses_2' ) . '.' . $this->qi( 'address_id' )
            )
        )->leftJoin(
            $q->alias(
                $this->qi( 'PO_persons' ),
                $this->qi( 'PO_persons_1' )
            ),
            $q->expr->eq(
                $this->qi( 'PO_persons_addresses_2' ) . '.' . $this->qi( 'person_id' ),
                $this->qi( 'PO_persons_1' ) . '.' . $this->qi( 'id' )
            )
        )->where(
            $q->expr->eq(
                $this->qi( 'PO_persons' ) . '.' . $this->qi( 'id' ),
                $q->bindValue( 1 )
            )
        );

        $this->assertEquals(
            $q->getQuery(),
            $this->getMultiLevelSingleRelationQuery(
                $this->getMultiLevelSingleRelationRelations()
            )->getQuery()
        );
    }

    public function testCreateMultiLevelMultiRelationQuery()
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
               $this->qi( 'PO_addresses_1' ) . '.' . $this->qi( 'id' ),
               $this->qi( 'PO_addresses_1_id' )
            ),
            $q->alias(
               $this->qi( 'PO_addresses_1' ) . '.' . $this->qi( 'street' ),
               $this->qi( 'PO_addresses_1_street' )
            ),
            $q->alias(
               $this->qi( 'PO_addresses_1' ) . '.' . $this->qi( 'zip' ),
               $this->qi( 'PO_addresses_1_zip' )
            ),
            $q->alias(
               $this->qi( 'PO_addresses_1' ) . '.' . $this->qi( 'city' ),
               $this->qi( 'PO_addresses_1_city' )
            ),
            $q->alias(
               $this->qi( 'PO_addresses_1' ) . '.' . $this->qi( 'type' ),
               $this->qi( 'PO_addresses_1_type' )
            ),
            $q->alias(
               $this->qi( 'PO_persons_1' ) . '.' . $this->qi( 'id' ),
               $this->qi( 'PO_persons_1_id' )
            ),
            $q->alias(
               $this->qi( 'PO_persons_1' ) . '.' . $this->qi( 'firstname' ),
               $this->qi( 'PO_persons_1_firstname' )
            ),
            $q->alias(
               $this->qi( 'PO_persons_1' ) . '.' . $this->qi( 'surname' ),
               $this->qi( 'PO_persons_1_surname' )
            ),
            $q->alias(
               $this->qi( 'PO_persons_1' ) . '.' . $this->qi( 'employer' ),
               $this->qi( 'PO_persons_1_employer' )
            ),
            $q->alias(
               $this->qi( 'PO_employers_1' ) . '.' . $this->qi( 'id' ),
               $this->qi( 'PO_employers_1_id' )
            ),
            $q->alias(
               $this->qi( 'PO_employers_1' ) . '.' . $this->qi( 'name' ),
               $this->qi( 'PO_employers_1_name' )
            ),
            $q->alias(
               $this->qi( 'PO_birthdays_1' ) . '.' . $this->qi( 'person_id' ),
               $this->qi( 'PO_birthdays_1_person_id' )
            ),
            $q->alias(
               $this->qi( 'PO_birthdays_1' ) . '.' . $this->qi( 'birthday' ),
               $this->qi( 'PO_birthdays_1_birthday' )
            ),
            $q->alias(
               $this->qi( 'PO_employers_2' ) . '.' . $this->qi( 'id' ),
               $this->qi( 'PO_employers_2_id' )
            ),
            $q->alias(
               $this->qi( 'PO_employers_2' ) . '.' . $this->qi( 'name' ),
               $this->qi( 'PO_employers_2_name' )
            ),
            $q->alias(
               $this->qi( 'PO_birthdays_2' ) . '.' . $this->qi( 'person_id' ),
               $this->qi( 'PO_birthdays_2_person_id' )
            ),
            $q->alias(
               $this->qi( 'PO_birthdays_2' ) . '.' . $this->qi( 'birthday' ),
               $this->qi( 'PO_birthdays_2_birthday' )
            )
        )->from(
            $this->qi( 'PO_persons' )
        )->leftJoin(
            $q->alias(
                $this->qi( 'PO_persons_addresses' ),
                $this->qi( 'PO_persons_addresses_1' )
            ),
            $q->expr->eq(
                $this->qi( 'PO_persons' ) . '.' . $this->qi( 'id' ),
                $this->qi( 'PO_persons_addresses_1' ) . '.' . $this->qi( 'person_id' )
            )
        )->leftJoin(
            $q->alias(
                $this->qi( 'PO_addresses' ),
                $this->qi( 'PO_addresses_1' )
            ),
            $q->expr->eq(
                $this->qi( 'PO_persons_addresses_1' ) . '.' . $this->qi( 'address_id' ),
                $this->qi( 'PO_addresses_1' ) . '.' . $this->qi( 'id' )
            )
        )->leftJoin(
            $q->alias(
                $this->qi( 'PO_persons_addresses' ),
                $this->qi( 'PO_persons_addresses_2' )
            ),
            $q->expr->eq(
                $this->qi( 'PO_addresses_1' ) . '.' . $this->qi( 'id' ),
                $this->qi( 'PO_persons_addresses_2' ) . '.' . $this->qi( 'address_id' )
            )
        )->leftJoin(
            $q->alias(
                $this->qi( 'PO_persons' ),
                $this->qi( 'PO_persons_1' )
            ),
            $q->expr->eq(
                $this->qi( 'PO_persons_addresses_2' ) . '.' . $this->qi( 'person_id' ),
                $this->qi( 'PO_persons_1' ) . '.' . $this->qi( 'id' )
            )
        )->leftJoin(
            $q->alias(
                $this->qi( 'PO_employers' ),
                $this->qi( 'PO_employers_1' )
            ),
            $q->expr->eq(
                $this->qi( 'PO_persons_1' ) . '.' . $this->qi( 'employer' ),
                $this->qi( 'PO_employers_1' ) . '.' . $this->qi( 'id' )
            )
        )->leftJoin(
            $q->alias(
                $this->qi( 'PO_birthdays' ),
                $this->qi( 'PO_birthdays_1' )
            ),
            $q->expr->eq(
                $this->qi( 'PO_persons_1' ) . '.' . $this->qi( 'id' ),
                $this->qi( 'PO_birthdays_1' ) . '.' . $this->qi( 'person_id' )
            )
        )->leftJoin(
            $q->alias(
                $this->qi( 'PO_employers' ),
                $this->qi( 'PO_employers_2' )
            ),
            $q->expr->eq(
                $this->qi( 'PO_persons' ) . '.' . $this->qi( 'employer' ),
                $this->qi( 'PO_employers_2' ) . '.' . $this->qi( 'id' )
            )
        )->leftJoin(
            $q->alias(
                $this->qi( 'PO_birthdays' ),
                $this->qi( 'PO_birthdays_2' )
            ),
            $q->expr->eq(
                $this->qi( 'PO_persons' ) . '.' . $this->qi( 'id' ),
                $this->qi( 'PO_birthdays_2' ) . '.' . $this->qi( 'person_id' )
            )
        )->where(
            $q->expr->eq(
                $this->qi( 'PO_persons' ) . '.' . $this->qi( 'id' ),
                $q->bindValue( 1 )
            )
        );
        $this->assertEquals(
            $q->getQuery(),
            $this->getMultiLevelMultiRelationQuery(
                $this->getMultiLevelMultiRelationRelations()
            )->getQuery()
        );
    }

    protected function qi( $identifier )
    {
        return $this->db->quoteIdentifier( $identifier );
    }
}

?>
