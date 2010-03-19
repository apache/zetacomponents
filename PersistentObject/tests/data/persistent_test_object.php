<?php
/**
CREATE TABLE PO_test
(
  id integer unsigned not null auto_increment,
  type_varchar varchar(20),
  type_integer integer,
  type_decimal decimal(10,2),
  type_text text,

  PRIMARY KEY (id)
) TYPE=InnoDB;

  type_date date,
*/

class PersistentTestObject
{
    public $id = null;
    public $varchar = null;
    public $integer = null;
    public $decimal = null;
    public $text = null;

    /**
     * Inserts some data to use for testing.
     */
    public static function insertCleanData()
    {
        $db = ezcDbInstance::get();
        $db->exec( "insert into " . $db->quoteIdentifier( "PO_test" ) . " (" 
            . $db->quoteIdentifier( "type_varchar" ) . ", " . $db->quoteIdentifier( "type_integer" ) . ", "
            . $db->quoteIdentifier( "type_decimal" ) . ", " . $db->quoteIdentifier( "type_text" ) . " )
                    VALUES ('Sweden', 9006405, 449.96, 'Sweden has nice girls!' )" );

        $db->exec( "insert into " . $db->quoteIdentifier( "PO_test" ) . " ("
            . $db->quoteIdentifier( "type_varchar" ) . ", " . $db->quoteIdentifier( "type_integer" ) . ", "
            . $db->quoteIdentifier( "type_decimal" ) . ", " . $db->quoteIdentifier( "type_text" ) . " )
                    VALUES ('Norway', 4593041, 385.19, 'Norway has brown goat cheese!' )" );

        $db->exec( "insert into " . $db->quoteIdentifier( "PO_test" ) . " ("
            . $db->quoteIdentifier( "type_varchar" ) . ", " . $db->quoteIdentifier( "type_integer" ) . ", "
            . $db->quoteIdentifier( "type_decimal" ) . ", " . $db->quoteIdentifier( "type_text" ) . " )
                    VALUES ('Ukraine', 47732079, 603.70, 'Ukraine has a long coastline to the black see.' )" );

        $db->exec( "insert into " . $db->quoteIdentifier( "PO_test" ) . " ("
            . $db->quoteIdentifier( "type_varchar" ) . ", " . $db->quoteIdentifier( "type_integer" ) . ", "
            . $db->quoteIdentifier( "type_decimal" ) . ", " . $db->quoteIdentifier( "type_text" ) . " )
                    VALUES ('Germany', 82443000, 357.02, 'Home of the lederhosen!.' )" );
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
        $schema->writeToFile( 'array', dirname( __FILE__ ) . '/persistent_test_object.dba' );
    }

    /**
     * Loads the schema from file into the database.
     *
     * If autoIncrement is set to false a schema with the id field not set to autoincrement is used.
     */
    public static function setupTable()
    {
        $db = ezcDbInstance::get();
        $schema = ezcDbSchema::createFromFile( 'array', dirname( __FILE__ ) . '/persistent_test_object.dba' );
        $schema->writeToDb( $db );
    }

    public static function cleanup()
    {
        $db = ezcDbInstance::get();
        if ( $db->getName() == "oracle" )
        {
            $db->exec( "DROP SEQUENCE " . $db->quoteIdentifier( "PO_test_id_seq" ) );
        }
        $db->exec( "DROP TABLE " . $db->quoteIdentifier( "PO_test" ) );
    }

    /*
    public function saveSqlSchemas()
    {
        $db = ezcDbInstance::get();
        $schema = ezcDbSchema::createFromFile( 'php', dirname( __FILE__ ) . '/persistent_test_object.dba' );
        $schema->writeToFile( dirname( __FILE__ ) . '/persistent_test_object-pgsql.sql', 'pgsql-file', 'schema' );
    }
    */

    public function setState( array $state )
    {
        foreach ( $state as $key => $value )
        {
            $this->$key = $value;
        }
    }

    public function getState()
    {
        $result = array();
        $result['id'] = $this->id;
        $result['decimal'] = $this->decimal;
        $result['varchar'] = $this->varchar;
        $result['integer'] = $this->integer;
        $result['text'] = $this->text;
        $result['no_such_var'] = "bah"; // This is here to make sure it does not provoke an error.
        return $result;
    }
}

?>
