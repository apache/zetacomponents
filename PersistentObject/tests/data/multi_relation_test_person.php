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

class MultiRelationTestPerson
{
    public $id     = null;
    public $name   = null;
    public $mother = null;
    public $father = null;
                
    /**
     * Inserts some data to use for testing.
     */
    public static function insertData()
    {
        $db = ezcDbInstance::get();
        $db->exec( "insert into " . $db->quoteIdentifier( "PO_person" ) . " (" 
            . $db->quoteIdentifier( "name" ) . " )
                    VALUES ('Root mother without parents.')" );
        $db->exec( "insert into " . $db->quoteIdentifier( "PO_person" ) . " (" 
            . $db->quoteIdentifier( "name" ) . " )
                    VALUES ('Root father without parents.')" );

        $db->exec( "insert into " . $db->quoteIdentifier( "PO_person" ) . " (" 
            . $db->quoteIdentifier( "name" ) . ", " . $db->quoteIdentifier( "mother" ) . ", "
            . $db->quoteIdentifier( "father" ) . " )
                    VALUES ('First level child.', 1, 2)" );
        $db->exec( "insert into " . $db->quoteIdentifier( "PO_person" ) . " (" 
            . $db->quoteIdentifier( "name" ) . ", " . $db->quoteIdentifier( "mother" ) . ", "
            . $db->quoteIdentifier( "father" ) . " )
                    VALUES ('Second first level child.', 1, 2)" );
        $db->exec( "insert into " . $db->quoteIdentifier( "PO_person" ) . " (" 
            . $db->quoteIdentifier( "name" ) . ", " . $db->quoteIdentifier( "mother" ) . ", "
            . $db->quoteIdentifier( "father" ) . " )
                    VALUES ('Third first level child.', 1, 2)" );

        $db->exec( "insert into " . $db->quoteIdentifier( "PO_sibling" ) . " (" 
            . $db->quoteIdentifier( "person" ) . ", " . $db->quoteIdentifier( "sibling" ) . " )
                    VALUES (3, 4)" );
        $db->exec( "insert into " . $db->quoteIdentifier( "PO_sibling" ) . " (" 
            . $db->quoteIdentifier( "person" ) . ", " . $db->quoteIdentifier( "sibling" ) . " )
                    VALUES (3, 5)" );
        $db->exec( "insert into " . $db->quoteIdentifier( "PO_sibling" ) . " (" 
            . $db->quoteIdentifier( "person" ) . ", " . $db->quoteIdentifier( "sibling" ) . " )
                    VALUES (4, 3)" );
        $db->exec( "insert into " . $db->quoteIdentifier( "PO_sibling" ) . " (" 
            . $db->quoteIdentifier( "person" ) . ", " . $db->quoteIdentifier( "sibling" ) . " )
                    VALUES (4, 5)" );
        $db->exec( "insert into " . $db->quoteIdentifier( "PO_sibling" ) . " (" 
            . $db->quoteIdentifier( "person" ) . ", " . $db->quoteIdentifier( "sibling" ) . " )
                    VALUES (5, 3)" );
        $db->exec( "insert into " . $db->quoteIdentifier( "PO_sibling" ) . " (" 
            . $db->quoteIdentifier( "person" ) . ", " . $db->quoteIdentifier( "sibling" ) . " )
                    VALUES (5, 4)" );
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
        $schema->writeToFile( 'array', dirname( __FILE__ ) . '/multi_relation.dba' );
    }

    /**
     * Loads the schema from file into the database.
     *
     * If autoIncrement is set to false a schema with the id field not set to autoincrement is used.
     */
    public static function setupTables( $autoIncrement = true )
    {
        $db = ezcDbInstance::get();
        $schema = ezcDbSchema::createFromFile( 'array', dirname( __FILE__ ) . '/multi_relation.dba' );
        $schema->writeToDb( $db );
    }

    public static function cleanup()
    {
        $db = ezcDbInstance::get();
        if ( $db->getName() == "oracle" )
        {
            $db->exec( "DROP SEQUENCE " . $db->quoteIdentifier( "PO_person_id_seq" ) );
        }
        $db->exec( "DROP TABLE " . $db->quoteIdentifier( "PO_person" ) );
        $db->exec( "DROP TABLE " . $db->quoteIdentifier( "PO_sibling" ) );
    }

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
        $result['name'] = $this->name;
        $result['mother'] = $this->mother;
        $result['father'] = $this->father;
        return $result;
    }
}

?>
