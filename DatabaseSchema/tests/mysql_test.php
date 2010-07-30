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

require_once 'generic_test.php';
/**
 * @package DatabaseSchema
 * @subpackage Tests
 */
class ezcDatabaseSchemaMySqlTest extends ezcDatabaseSchemaGenericTest
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

        $tables = $this->db->query( "SHOW TABLES" )->fetchAll();
        array_walk( $tables, create_function( '&$item,$key', '$item = $item[0];' ) );

        foreach ( $tables as $tableName )
        {
            $this->db->query( "DROP TABLE `$tableName`" );
        }

    }

    // bug #12538
    public function testUnsupportedMySQLDbField()
    {
$sql = <<<ENDL
CREATE TABLE `testexternal_musiclists` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `external_id` varchar(256) NOT NULL,
  `url` varchar(256) default NULL,
  `title` varchar(256) NOT NULL,
  `description` text,
  `type` enum('iMix','iTunes') NOT NULL default 'iMix',
  `last_updated` datetime NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `external_id` (`external_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='';
ENDL;
        $this->db->query( $sql );

        try
        {
            $schema = ezcDbSchema::createFromDb( $this->db );
            self::fail( "Expected exception not thrown." );
        }
        catch ( ezcDbSchemaUnsupportedTypeException $e )
        {
            self::assertEquals( "The field type 'enum' is not supported with the 'MySQL' handler.", $e->getMessage() );
        }
    }

    
    public static function suite()
    {
        return new PHPUnit_Framework_TestSuite( 'ezcDatabaseSchemaMySqlTest' );
    }
}
?>
