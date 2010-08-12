<?php
/**
 * File containing the ezcDbUtilitiesSqlite class.
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
 * @package Database
 * @version //autogentag//
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 * @access private
 */

/**
 * Various database methods.
 *
 * This implementation is SQLite specific.
 *
 * This class inherits most of its database handling functionality from
 * PDO ({@link http://php.net/PDO}) -- an object-oriented database abstraction
 * layer that is going to become a new standard for PHP applications.
 *
 * @package Database
 * @todo this class must be renamed
 * @access private
 * @version //autogentag//
 */
class ezcDbUtilitiesSqlite extends ezcDbUtilities
{
    /**
     * Constructs a new db util using the db handler $db.
     *
     * @param ezcDbHandler $db
     */
    public function __construct( $db )
    {
        parent::__construct( $db );
    }

    /**
     * Remove all tables from the database.
     */
    public function cleanup()
    {
        $this->db->begin();
        $rslt = $this->db->query( 'SELECT * FROM SQLITE_MASTER' );
        $rslt->setFetchMode( PDO::FETCH_NUM );
        $rows = $rslt->fetchAll();
        foreach ( $rows as $row )
        {
            $table = $row[0];
            $this->db->exec( "DROP TABLE `$table`" );
        }
        $this->db->commit();
    }
}

?>
