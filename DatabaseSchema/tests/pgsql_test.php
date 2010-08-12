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

require_once 'generic_test.php';
/**
 * @package DatabaseSchema
 * @subpackage Tests
 */
class ezcDatabaseSchemaPgsqlTest extends ezcDatabaseSchemaGenericTest
{
    public function setUp()
    {
        try
        {
            $this->db = ezcDbInstance::get();
            if ($this->db->getName() != 'pgsql' ) 
            {
                throw new Exception("Skiping tests for PostgreSQL");
            }
            $this->testFilesDir = dirname( __FILE__ ) . '/testfiles/';
            $this->tempDir = $this->createTempDir( 'ezcDatabasePgSqlTest' );

            $tables = $this->db->query( "SELECT table_name FROM information_schema.tables WHERE table_schema = 'public'" )->fetchAll();
            array_walk( $tables, create_function( '&$item,$key', '$item = $item[0];' ) );

            foreach ( $tables as $tableName )
            {
                $this->db->query( "DROP TABLE \"$tableName\"" );
            }
        }
        catch ( Exception $e )
        {
            $this->markTestSkipped( $e->getMessage() );
        }

    }

    public static function suite()
    {
        return new PHPUnit_Framework_TestSuite( 'ezcDatabaseSchemaPgSqlTest' );
    }
}
?>
