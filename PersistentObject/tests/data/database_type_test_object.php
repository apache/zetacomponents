<?php
/**
CREATE TABLE IF NOT EXISTS `PO_database_type_test` (
  `id` int(11) NOT NULL auto_increment,
  `bool` tinyint(1) NOT NULL,
  `int` int(11) NOT NULL,
  `str` varchar(100) NOT NULL,
  `lob` blob NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
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

class DatabaseTypeTestObject
{
    public $id     = null;
    public $bool   = null;
    public $int    = null;
    public $str    = null;
    public $lob    = null;
                
    /**
     * Inserts some data to use for testing.
     */
    public static function insertData()
    {
        $db = ezcDbInstance::get();
        $stmt = $db->prepare(
            "insert into " . $db->quoteIdentifier( "PO_database_type_test" ) . 
            " (" .
                $db->quoteIdentifier( "bool" ) . ", " .
                $db->quoteIdentifier( "int" )  . ", " .
                $db->quoteIdentifier( "str" )  . ", " .
                $db->quoteIdentifier( "lob" )  . 
            " ) VALUES ( :bool, :int, :str, :lob )"
        );

        $stmt->bindValue( ':bool', 1 );
        $stmt->bindValue( ':int', 23 );
        $stmt->bindValue( ':str', 'Non binary string' );
        $stmt->bindValue( ':lob', "Binary \x00 string", PDO::PARAM_LOB );

        $stmt->execute();

        $stmt->bindValue( ':bool', 0 );
        $stmt->bindValue( ':int', -42 );
        $stmt->bindValue( ':str', "Binary \x00 string", PDO::PARAM_STR );
        $stmt->bindValue( ':lob', "Binary \x00 string", PDO::PARAM_LOB );

        $stmt->execute();
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
        $schema->writeToFile( 'array', dirname( __FILE__ ) . '/database_type.dba' );
    }

    /**
     * Loads the schema from file into the database.
     *
     * If autoIncrement is set to false a schema with the id field not set to autoincrement is used.
     */
    public static function setupTables( $autoIncrement = true )
    {
        $db = ezcDbInstance::get();
        $schema = ezcDbSchema::createFromFile( 'array', dirname( __FILE__ ) . '/database_type.dba' );
        $schema->writeToDb( $db );
    }

    public static function cleanup()
    {
        $db = ezcDbInstance::get();
        if ( $db->getName() == "oracle" )
        {
            $db->exec( "DROP SEQUENCE " . $db->quoteIdentifier( "PO_database_type_test_id_seq" ) );
        }
        $db->exec( "DROP TABLE " . $db->quoteIdentifier( "PO_database_type_test" ) );
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
        $result['id']   = $this->id;
        $result['bool'] = $this->bool;
        $result['int']  = $this->int;
        $result['str']  = $this->str;
        $result['lob']  = $this->lob;
        return $result;
    }
}

?>
