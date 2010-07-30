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
 * @copyright Copyright (C) 2005-2010 eZ Systems AS. All rights reserved.
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
class ezcDatabaseSchemaOracleDiffTest extends ezcDatabaseSchemaGenericDiffTest
{
    protected function resetDb()
    {
        $tables = $this->db->query( "SELECT table_name FROM user_tables" )->fetchAll();
        array_walk( $tables, create_function( '&$item,$key', '$item = $item[0];' ) );

        foreach ( $tables as $tableName )
        {
            $this->db->query( "DROP TABLE \"$tableName\"" );
        }
    }

    protected function setUp()
    {
        try
        {
            $this->db = ezcDbInstance::get();
        }
        catch ( Exception $e )
        {
            $this->markTestSkipped();
        }

        $this->testFilesDir = dirname( __FILE__ ) . '/testfiles/';
        $this->tempDir = $this->createTempDir( 'ezcDatabaseOracleTest' );
        $this->resetDb();
    }

    protected function getDiffExpectations1()
    {
        $expected = array (
            0 => 'DROP INDEX "tertiary"',
            1 => 'ALTER TABLE "bugdb_change" DROP CONSTRAINT "bugdb_change_pkey"',
            2 => 'ALTER TABLE "bugdb_change" DROP COLUMN "integerfield1"',
            3 => 'ALTER TABLE "bugdb_change" MODIFY "integerfield3" varchar2(64)',
            4 => 'ALTER TABLE "bugdb_change" ADD "integerfield2" number DEFAULT 0 NOT NULL',
            5 => 'ALTER TABLE "bugdb_change" ADD CONSTRAINT "bugdb_change_pkey" PRIMARY KEY ( "integerfield2" )',
            6 => 'CREATE UNIQUE INDEX "secondary" ON "bugdb_change" ( "integerfield3" )',
            7 => "CREATE TABLE \"bugdb_added\" (\n\t\"integerfield1\" number\n)",
            8 => 'DROP TABLE "bugdb_deleted"',
        );
        return $expected;
    }

    protected function getDiffExpectations2()
    {
        $expected = array (
            0 => 'DROP INDEX "join"',
            1 => 'ALTER TABLE "bugdb_change" DROP CONSTRAINT "bugdb_change_pkey"',
            2 => 'ALTER TABLE "bugdb_change" DROP COLUMN "from"',
            3 => 'ALTER TABLE "bugdb_change" ADD "group" number DEFAULT 0 NOT NULL',
            4 => 'ALTER TABLE "bugdb_change" ADD CONSTRAINT "bugdb_change_pkey" PRIMARY KEY ( "group" )',
            5 => 'CREATE UNIQUE INDEX "from" ON "bugdb_change" ( "table" )',
            6 => "CREATE TABLE \"order\" (\n\t\"right\" number\n)",
            7 => 'DROP TABLE "select"',
        );
        return $expected;
    }

    public static function suite()
    {
        return new PHPUnit_Framework_TestSuite( 'ezcDatabaseSchemaOracleDiffTest' );
    }
}
?>
