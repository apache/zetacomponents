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
 *
 * Licensed to the Apache Software Foundation (ASF) under one
 * or more contributor license agreements.  See the NOTICE file
 * distributed with this work for additional information
 * regarding copyright ownership.  The ASF licenses this file
 * to you under the Apache License, Version 2.0 (the
 * "License"); you may not use this file except in compliance
 * with the License.  You may obtain a copy of the License at
 * 
 *   http://www.apache.org/licenses/LICENSE-2.0
 * 
 * Unless required by applicable law or agreed to in writing,
 * software distributed under the License is distributed on an
 * "AS IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS OF ANY
 * KIND, either express or implied.  See the License for the
 * specific language governing permissions and limitations
 * under the License.
 *
*/

class PersistentTestObjectNoId
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
        $db->exec( "insert into " . $db->quoteIdentifier( "PO_test" ) . " (id, type_varchar, type_integer,
                    type_decimal, type_text )
                    VALUES ( 1, 'Sweden', 9006405, 449.96, 'Sweden has nice girls!' );" );

        $db->exec( "insert into " . $db->quoteIdentifier( "PO_test" ) . " (id, type_varchar, type_integer,
                    type_decimal, type_text )
                    VALUES (2, 'Norway', 4593041, 385.19, 'Norway has brown goat cheese!' );" );

        $db->exec( "insert into " . $db->quoteIdentifier( "PO_test" ) . " (id, type_varchar, type_integer,
                    type_decimal, type_text )
                    VALUES (3, 'Ukraine', 47732079, 603.70, 'Ukraine has a long coastline to the black see.' );" );

        $db->exec( "insert into " . $db->quoteIdentifier( "PO_test" ) . " (id, type_varchar, type_integer,
                    type_decimal, type_text )
                    VALUES (4, 'Germany', 82443000, 357.02, 'Home of the lederhosen!.' );" );
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
     */
    public static function setupTable()
    {
        $db = ezcDbInstance::get();
        // Load schema
        $schema = ezcDbSchema::createFromFile( 'array', dirname( __FILE__ ) . '/persistent_test_object.dba' );
        $schema->writeToDb( $db );

        // create sequence if it is a postgres database
        if ( $db->getName() == 'pgsql' )
        {
            $db->exec( "CREATE SEQUENCE " . $db->quoteIdentifier( "PO_test_seq" ) . " START 5;" );
        }

    }

    public static function cleanup()
    {
        $db = ezcDbInstance::get();
        $db->exec( "DROP TABLE " . $db->quoteIdentifier( "PO_test" ) . ";" );
        if ( $db->getName() == 'pgsql' )
        {
            $db->exec( "DROP SEQUENCE " . $db->quoteIdentifier( "PO_test_seq" ) . ";" );
        }
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
