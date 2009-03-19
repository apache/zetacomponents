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
        $this->assertEquals(
            'SELECT id, firstname, surname, employer, PO_employers_1.name AS PO_employers_1_name '
            . 'FROM PO_persons LEFT JOIN PO_employers AS PO_employers_1 '
            . 'ON PO_persons.employer = PO_employers_1.id WHERE id = :ezcValue1',
            $this->getOneLevelOneRelationQuery()->getQuery()
        );
    }

    public function testCreateOneLevelMultiRelationQuery()
    {
        $this->assertEquals(
            'SELECT id, firstname, surname, employer, PO_employers_1.name AS PO_employers_1_name, '
            . 'PO_addresses_1.street AS PO_addresses_1_street, PO_addresses_1.zip AS PO_addresses_1_zip, '
            . 'PO_addresses_1.city AS PO_addresses_1_city, PO_addresses_1.type AS PO_addresses_1_type '
            . 'FROM PO_persons LEFT JOIN PO_employers AS PO_employers_1 ON PO_persons.employer = PO_employers_1.id '
            . 'LEFT JOIN PO_persons_addresses AS PO_persons_addresses_1 ON PO_persons.id = PO_persons_addresses_1.person_id '
            . 'LEFT JOIN PO_addresses AS PO_addresses_1 ON PO_persons_addresses_1.address_id = PO_addresses_1.id '
            . 'WHERE id = :ezcValue1',
            $this->getCreateOneLevelMultiRelationQuery()->getQuery()
        );
    }

    public function testCreateMultiLevelSingleRelationQuery()
    {
        $this->assertEquals(
            'SELECT id, firstname, surname, employer, '
            . 'PO_addresses_1.street AS PO_addresses_1_street, PO_addresses_1.zip AS PO_addresses_1_zip, '
            . 'PO_addresses_1.city AS PO_addresses_1_city, PO_addresses_1.type AS PO_addresses_1_type, '
            . 'PO_persons_1.firstname AS PO_persons_1_firstname, PO_persons_1.surname AS PO_persons_1_surname, '
            . 'PO_persons_1.employer AS PO_persons_1_employer FROM PO_persons LEFT JOIN PO_persons_addresses AS PO_persons_addresses_1 '
            . 'ON PO_persons.id = PO_persons_addresses_1.person_id LEFT JOIN PO_addresses AS PO_addresses_1 '
            . 'ON PO_persons_addresses_1.address_id = PO_addresses_1.id LEFT JOIN PO_persons_addresses AS PO_persons_addresses_2 '
            . 'ON PO_addresses_1.id = PO_persons_addresses_2.address_id LEFT JOIN PO_persons AS PO_persons_1 '
            . 'ON PO_persons_addresses_2.person_id = PO_persons_1.id WHERE id = :ezcValue1',
            $this->getCreateMultiLevelSingleRelationQuery()->getQuery()
        );
    }

    public function testCreateMultiLevelMultiRelationQuery()
    {
        $this->assertEquals(
            'SELECT id, firstname, surname, employer, PO_addresses_1.street AS PO_addresses_1_street, '
            . 'PO_addresses_1.zip AS PO_addresses_1_zip, PO_addresses_1.city AS PO_addresses_1_city, '
            . 'PO_addresses_1.type AS PO_addresses_1_type, PO_persons_1.firstname AS PO_persons_1_firstname, '
            . 'PO_persons_1.surname AS PO_persons_1_surname, PO_persons_1.employer AS PO_persons_1_employer, '
            . 'PO_employers_1.name AS PO_employers_1_name, PO_birthdays_1.birthday AS PO_birthdays_1_birthday, '
            . 'PO_employers_2.name AS PO_employers_2_name, PO_birthdays_2.birthday AS PO_birthdays_2_birthday '
            . 'FROM PO_persons LEFT JOIN PO_persons_addresses AS PO_persons_addresses_1 '
            . 'ON PO_persons.id = PO_persons_addresses_1.person_id LEFT JOIN PO_addresses AS PO_addresses_1 '
            . 'ON PO_persons_addresses_1.address_id = PO_addresses_1.id LEFT JOIN PO_persons_addresses AS PO_persons_addresses_2 '
            . 'ON PO_addresses_1.id = PO_persons_addresses_2.address_id LEFT JOIN PO_persons AS PO_persons_1 '
            . 'ON PO_persons_addresses_2.person_id = PO_persons_1.id LEFT JOIN PO_employers AS PO_employers_1 '
            . 'ON PO_persons_1.employer = PO_employers_1.id LEFT JOIN PO_birthdays AS PO_birthdays_1 '
            . 'ON PO_persons_1.id = PO_birthdays_1.person_id LEFT JOIN PO_employers AS PO_employers_2 '
            . 'ON PO_persons.employer = PO_employers_2.id LEFT JOIN PO_birthdays AS PO_birthdays_2 '
            . 'ON PO_persons.id = PO_birthdays_2.person_id WHERE id = :ezcValue1',
            $this->getCreateMultiLevelMultiRelationQuery()->getQuery()
        );
    }
}

?>
