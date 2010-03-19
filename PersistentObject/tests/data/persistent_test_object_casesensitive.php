<?php

class PersistentTestObjectCasesensitive
{
    public $id = null;
    public $varChar = null;
    public $integer = null;
    public $DECIMAL = null;
    public $text = null;

    /**
     * Inserts some data to use for testing.
     */
    public static function insertCleanData()
    {
        $db = ezcDbInstance::get();
        $db->exec( "insert into " . $db->quoteIdentifier( "PO_test" ) . " (" 
            . $db->quoteIdentifier( "Type_VarCHAR" ) . ", " . $db->quoteIdentifier( "tYPe_inTEGer" ) . ", "
            . $db->quoteIdentifier( "type_decimal" ) . ", " . $db->quoteIdentifier( "TYPE_TEXT" ) . " )
                    VALUES ('Sweden', 9006405, 449.96, 'Sweden has nice girls!' )" );

        $db->exec( "insert into " . $db->quoteIdentifier( "PO_test" ) . " ("
            . $db->quoteIdentifier( "Type_VarCHAR" ) . ", " . $db->quoteIdentifier( "tYPe_inTEGer" ) . ", "
            . $db->quoteIdentifier( "type_decimal" ) . ", " . $db->quoteIdentifier( "TYPE_TEXT" ) . " )
                    VALUES ('Norway', 4593041, 385.19, 'Norway has brown goat cheese!' )" );

        $db->exec( "insert into " . $db->quoteIdentifier( "PO_test" ) . " ("
            . $db->quoteIdentifier( "Type_VarCHAR" ) . ", " . $db->quoteIdentifier( "tYPe_inTEGer" ) . ", "
            . $db->quoteIdentifier( "type_decimal" ) . ", " . $db->quoteIdentifier( "TYPE_TEXT" ) . " )
                    VALUES ('Ukraine', 47732079, 603.70, 'Ukraine has a long coastline to the black see.' )" );

        $db->exec( "insert into " . $db->quoteIdentifier( "PO_test" ) . " ("
            . $db->quoteIdentifier( "Type_VarCHAR" ) . ", " . $db->quoteIdentifier( "tYPe_inTEGer" ) . ", "
            . $db->quoteIdentifier( "type_decimal" ) . ", " . $db->quoteIdentifier( "TYPE_TEXT" ) . " )
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
        $schema->writeToFile( 'array', dirname( __FILE__ ) . '/persistent_test_object_casesensitive.dba' );
    }

    /**
     * Loads the schema from file into the database.
     */
    public static function setupTable()
    {
        $db = ezcDbInstance::get();
        $schema = ezcDbSchema::createFromFile( 'array', dirname( __FILE__ ) . '/persistent_test_object_casesensitive.dba' );
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
        $result['DECIMAL'] = $this->DECIMAL;
        $result['varChar'] = $this->varChar;
        $result['integer'] = $this->integer;
        $result['text'] = $this->text;
        $result['no_Such_Var'] = "bah"; // This is here to make sure it does not provoke an error.
        return $result;
    }
}

?>
