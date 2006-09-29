<?php

ezcTestRunner::addFileToFilter( __FILE__ );

/*
CREATE TABLE `PO_addresses` (
  `id` tinyint(3) unsigned NOT NULL auto_increment,
  `street` varchar(100) NOT NULL,
  `zip` varchar(5) NOT NULL,
  `city` varchar(100) NOT NULL,
  `type` varchar(10) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

CREATE TABLE `PO_employers` (
  `id` tinyint(4) NOT NULL auto_increment,
  `name` varchar(100) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

CREATE TABLE `PO_persons` (
  `id` tinyint(4) NOT NULL auto_increment,
  `firstname` varchar(100) NOT NULL,
  `surename` varchar(100) NOT NULL,
  `employer` tinyint(4) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

CREATE TABLE `PO_persons_addresses` (
  `person_id` tinyint(4) NOT NULL,
  `address_id` tinyint(4) NOT NULL,
  PRIMARY KEY  (`person_id`,`address_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
*/

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

        $db->exec( "INSERT INTO `PO_persons` (`firstname`, `surename`, `employer`) VALUES ('Theodor', 'Gopher', 2);" );
        $db->exec( "INSERT INTO `PO_persons` (`firstname`, `surename`, `employer`) VALUES ('Frederick', 'Ajax', 1);" );
        $db->exec( "INSERT INTO `PO_persons` (`firstname`, `surename`, `employer`) VALUES ('Raymond', 'Socialweb', 1);" );

        $db->exec( "INSERT INTO `PO_persons_addresses` ( `person_id`, `address_id`) VALUES ( 1, 1);" );
        $db->exec( "INSERT INTO `PO_persons_addresses` ( `person_id`, `address_id`) VALUES ( 1, 2);" );
        $db->exec( "INSERT INTO `PO_persons_addresses` ( `person_id`, `address_id`) VALUES ( 1, 4);" );
        $db->exec( "INSERT INTO `PO_persons_addresses` ( `person_id`, `address_id`) VALUES ( 2, 1);" );
        $db->exec( "INSERT INTO `PO_persons_addresses` ( `person_id`, `address_id`) VALUES ( 2, 3);" );
        $db->exec( "INSERT INTO `PO_persons_addresses` ( `person_id`, `address_id`) VALUES ( 2, 4);" );
        $db->exec( "INSERT INTO `PO_persons_addresses` ( `person_id`, `address_id`) VALUES ( 3, 4);" );
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
        $db->exec( "DROP TABLE PO_employers" );
        $db->exec( "DROP TABLE PO_persons" );
        $db->exec( "DROP TABLE PO_persons_addresses" );
    }

}


?>
