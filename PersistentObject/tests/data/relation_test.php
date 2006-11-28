<?php

ezcTestRunner::addFileToFilter( __FILE__ );

class RelationTest
{
    /**
     * Insert data for the test
     */
    public static function insertData()
    {
        $db = ezcDbInstance::get();

        $db->exec( "INSERT INTO `PO_addresses` (`street`, `zip`, `city`, `type`) VALUES ('Httproad 23', '12345', 'Internettown', 'work');" );
        $db->exec( "INSERT INTO `PO_addresses` (`street`, `zip`, `city`, `type`) VALUES ('Ftpstreet 42', '12345', 'Internettown', 'work');" );
        $db->exec( "INSERT INTO `PO_addresses` (`street`, `zip`, `city`, `type`) VALUES ('Phpavenue 21', '12345', 'Internettown', 'private');" );
        $db->exec( "INSERT INTO `PO_addresses` (`street`, `zip`, `city`, `type`) VALUES ('Pythonstreet 13', '12345', 'Internettown', 'private');" );

        $db->exec( "INSERT INTO `PO_employers` (`name`) VALUES ('Great Web 2.0 company');" );
        $db->exec( "INSERT INTO `PO_employers` (`name`) VALUES ('Oldschool Web 1.x company');" );
        $db->exec( "INSERT INTO `PO_employers` (`name`) VALUES ('Very oldschool print media company');" );

        $db->exec( "INSERT INTO `PO_persons` (`firstname`, `surname`, `employer`) VALUES ('Theodor', 'Gopher', 2);" );
        $db->exec( "INSERT INTO `PO_persons` (`firstname`, `surname`, `employer`) VALUES ('Frederick', 'Ajax', 1);" );
        $db->exec( "INSERT INTO `PO_persons` (`firstname`, `surname`, `employer`) VALUES ('Raymond', 'Socialweb', 1);" );

        $db->exec( "INSERT INTO `PO_persons_addresses` ( `person_id`, `address_id`) VALUES ( 1, 1);" );
        $db->exec( "INSERT INTO `PO_persons_addresses` ( `person_id`, `address_id`) VALUES ( 1, 2);" );
        $db->exec( "INSERT INTO `PO_persons_addresses` ( `person_id`, `address_id`) VALUES ( 1, 4);" );
        $db->exec( "INSERT INTO `PO_persons_addresses` ( `person_id`, `address_id`) VALUES ( 2, 1);" );
        $db->exec( "INSERT INTO `PO_persons_addresses` ( `person_id`, `address_id`) VALUES ( 2, 3);" );
        $db->exec( "INSERT INTO `PO_persons_addresses` ( `person_id`, `address_id`) VALUES ( 2, 4);" );
        $db->exec( "INSERT INTO `PO_persons_addresses` ( `person_id`, `address_id`) VALUES ( 3, 4);" );

        $db->exec( "INSERT INTO `PO_birthdays` (`person_id`, `birthday`) VALUES (1, 327535201);"  );
        $db->exec( "INSERT INTO `PO_birthdays` (`person_id`, `birthday`) VALUES (2, -138243599);" );
    }

    /**
     * Saves the schema from database to file.
     *
     * Use this method if you have changed the definition of the persistent object
     * and need to update the file on disk.
     */
    public function saveSchema()
    {
        $db = ezcDbInstance::get();
        $schema = ezcDbSchema::createFromDb( $db );
        $schema->writeToFile( "array", dirname( __FILE__ ) . "/relation.dba" );
    }

    /**
     * Loads the schema from file into the database.
     */
    public static function setupTables()
    {
        $db = ezcDbInstance::get();
        $schema = ezcDbSchema::createFromFile( "array", dirname( __FILE__ ) . "/relation.dba" );
        $schema->writeToDb( $db );
    }

    public static function cleanup()
    {
        $db = ezcDbInstance::get();
        $db->exec( "DROP TABLE PO_addresses" );
        $db->exec( "DROP TABLE PO_birthdays" );
        $db->exec( "DROP TABLE PO_employers" );
        $db->exec( "DROP TABLE PO_persons" );
        $db->exec( "DROP TABLE PO_persons_addresses" );
    }

}


?>
