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
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 * @version //autogentag//
 * @filesource
 * @package Database
 * @subpackage Tests
 */

require_once 'base.php';

/**
 * @package Database
 * @subpackage Tests
 */
class ezcDatabaseHandlerOracleTest extends ezcDatabaseHandlerBaseTest
{
    public static function suite()
    {
         return new PHPUnit_Framework_TestSuite( __CLASS__ );
    }

    protected function setUp()
    {
        $this->handlerClass = 'ezcDbHandlerOracle';
        parent::setUp();
    }

    protected function tearDownTables()
    {
        $sequences = $this->db->query( "SELECT sequence_name FROM user_sequences" )->fetchAll();
        
        foreach ( $sequences as $sequenceDef )
        {
            $this->db->query( 'DROP SEQUENCE "' . $sequenceDef['sequence_name'] . '"' );
        }
        $tables = $this->db->query( "SELECT table_name FROM user_tables ORDER BY table_name" )->fetchAll();

        foreach ( $tables as $tableDef )
        {
            $this->db->query( 'DROP TABLE "' . $tableDef['table_name'] . '"' );
        }
    }
}

?>
