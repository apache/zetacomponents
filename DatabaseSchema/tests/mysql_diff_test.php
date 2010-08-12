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
 * @package DatabaseSchema
 * @subpackage Tests
 */

require_once 'generic_diff_test.php';
/**
 * @package DatabaseSchema
 * @subpackage Tests
 */
class ezcDatabaseSchemaMysqlDiffTest extends ezcDatabaseSchemaGenericDiffTest
{
    protected function setUp()
    {
        try
        {
            $this->db = ezcDbInstance::get();
        }
        catch ( Exception $e )
        {
            $this->markTestSkipped( "No Database connection available" );
        }
        if ( $this->db->getName() !== 'mysql' )
        {
            $this->markTestSkipped( "We are not testing with MySQL" );
        }

        if ( !( $this->db instanceof ezcDbHandlerMysql ) )
        {
            $this->markTestSkipped();
        }

        $this->testFilesDir = dirname( __FILE__ ) . '/testfiles/';
        $this->tempDir = $this->createTempDir( 'ezcDatabaseMySqlTest' );
        $this->resetDb();
    }

    protected function resetDb()
    {
        $tables = $this->db->query( "SHOW TABLES" )->fetchAll();
        array_walk( $tables, create_function( '&$item,$key', '$item = $item[0];' ) );

        foreach ( $tables as $tableName )
        {
            $this->db->query( "DROP TABLE `$tableName`" );
        }
    }

    protected function getDiffExpectations1()
    {
        $expected = array (
            0 => "ALTER TABLE `bugdb_change` DROP INDEX `tertiary`",
            1 => "ALTER TABLE `bugdb_change` DROP INDEX `primary`",
            2 => "ALTER TABLE `bugdb_change` DROP `integerfield1`",
            3 => "ALTER TABLE `bugdb_change` CHANGE `integerfield3` `integerfield3` varchar(64)",
            4 => "ALTER TABLE `bugdb_change` ADD `integerfield2` bigint NOT NULL DEFAULT 0",
            5 => "ALTER TABLE `bugdb_change` ADD PRIMARY KEY ( `integerfield2` )",
            6 => "ALTER TABLE `bugdb_change` ADD UNIQUE `secondary` ( `integerfield3` )",
            7 => "CREATE TABLE `bugdb_added` (\n\t`integerfield1` bigint\n)",
            8 => "DROP TABLE IF EXISTS `bugdb_deleted`",
        );
        return $expected;
    }

    protected function getDiffExpectations2()
    {
        $expected = array (
            0 => "ALTER TABLE `bugdb_change` DROP INDEX `join`",
            1 => "ALTER TABLE `bugdb_change` DROP INDEX `primary`",
            2 => "ALTER TABLE `bugdb_change` DROP `from`",
            3 => "ALTER TABLE `bugdb_change` ADD `group` bigint NOT NULL DEFAULT 0",
            4 => "ALTER TABLE `bugdb_change` ADD PRIMARY KEY ( `group` )",
            5 => "ALTER TABLE `bugdb_change` ADD UNIQUE `from` ( `table` )",
            6 => "CREATE TABLE `order` (\n\t`right` bigint\n)",
            7 => "DROP TABLE IF EXISTS `select`",
        );
        return $expected;
    }

    public static function suite()
    {
        return new PHPUnit_Framework_TestSuite( 'ezcDatabaseSchemaMysqlDiffTest' );
    }
}
?>
