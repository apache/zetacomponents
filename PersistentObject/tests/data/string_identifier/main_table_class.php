<?php
/**
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
CREATE TABLE main_table
(
  id varchar(255),
  data varchar(255),
  PRIMARY KEY (id)
) TYPE=InnoDB;

CREATE TABLE rel
(
  id varchar(255),
  fk varchar(255),
  PRIMARY KEY (id)
) TYPE=InnoDB;

CREATE TABLE link
(
   main_id varchar(255),
   rel_id varchar(255)
) TYPE=InnoDB;
*/

class MainTable
{
    public $id = null;
    public $data = null;

    /**
     * Inserts some data to use for testing.
     */
    public static function insertCleanData()
    {
    }

    /**
     * Saves the schema from database to file.
     *
     * Use this method if you have changed the definition of the persistent object
     * and need to update the file on disk.
     */
    public static function saveSchema()
    {
        $db = ezcDbInstance::get();
        $schema = ezcDbSchema::createFromDb( $db );
        $schema->writeToFile( 'array', dirname( __FILE__ ) . '/table.dba' );
    }

    /**
     * Loads the schema from file into the database.
     */
    public static function setupTable()
    {
        $db = ezcDbInstance::get();
        // Load schema
        $schema = ezcDbSchema::createFromFile( 'array', dirname( __FILE__ ) . '/table.dba' );
        $schema->writeToDb( $db );
    }

    public static function cleanup()
    {
        $db = ezcDbInstance::get();
        $db->exec( 'DROP TABLE' . $db->quoteIdentifier( 'main_table' ) );
        $db->exec( 'DROP TABLE' . $db->quoteIdentifier( 'rel' ) );
        $db->exec( 'DROP TABLE' . $db->quoteIdentifier( 'link' ) );
        if ( $db->getName() === 'oracle' )
        {
            $db->exec( "DROP SEQUENCE " . $db->quoteIdentifier( "main_table_id_seq" ) );
            $db->exec( "DROP SEQUENCE " . $db->quoteIdentifier( "rel_id_seq" ) );
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
        $result['data'] = $this->data;
        return $result;
    }
}

?>
