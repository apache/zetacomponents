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

/**
 * @package DatabaseSchema
 * @subpackage Tests
 */
class ezcDatabaseSchemaPersistentTest extends ezcTestCase
{
    protected function setUp()
    {
        $this->testFilesDir = dirname( __FILE__ ) . '/testfiles';
        $this->tempDir = $this->createTempDir( 'ezcDatabasePersistentTest' );
    }

    protected function tearDown()
    {
        $this->removeTempDir();
    }

    public function getSchema()
    {
        $schema = ezcDbSchema::createFromFile( 'xml', $this->testFilesDir . '/webbuilder.schema.xml' );
        return $schema;
    }

    public function testPersistentGenerationSuccess()
    {
        $schema = $this->getSchema();
        $schema->writeToFile( 'persistent', $this->tempDir );

        $d = dir( $this->testFilesDir . '/persistent' );
        while ( ( $entry = $d->read() ) !== false )
        {
            if ( $entry[0] == '.' )
            {
                continue;
            }
            if ( !file_exists( $this->tempDir . '/' . $entry ) )
            {
                $this->fail( "PersistentObject definition '{$entry}' not created!" );
            }
            $this->assertEquals( 
                file_get_contents( $this->testFilesDir . '/persistent/' . $entry ),
                file_get_contents( $this->tempDir . '/' . $entry ),
                "PersistentObject definition for file '{$entry}' differs"
            );
        }
    }

    public function testPersistentGenerationFailureMissingDir()
    {
        $schema = $this->getSchema();
        try
        {
            $schema->writeToFile( 'persistent', $this->tempDir . '/unavailable' );
        }
        catch ( ezcBaseFileException $e )
        {
            return;
        }
        $this->fail( "Expected ezcBaseFileException not thrown on saving PersistentObject definitions to non-existent directory." );
    }

    public function testPersistentGenerationFailureNonDir()
    {
        $schema = $this->getSchema();
        try
        {
            $schema->writeToFile( 'persistent', __FILE__ );
        }
        catch ( ezcBaseFileException $e )
        {
            return;
        }
        $this->fail( "Expected ezcBaseFileException not thrown on saving PersistentObject definitions to a non-directory." );
    }

    /* Issue #12937 */
    public function testGenerateCorrectTypeStringPrimary()
    {
        $schema = ezcDbSchema::createFromFile( 'xml', $this->testFilesDir . '/bug-12937-persitent-string-id.xml' );
        $schema->writeToFile( 'persistent', $this->tempDir );
        
        $this->assertEquals(
            require $this->tempDir . '/liveuser_translations_string_id.php',
            require $this->testFilesDir . '/persistent_bug_12937/liveuser_translations_string_id.php'
        );
    }

    public static function suite()
    {
        return new PHPUnit_Framework_TestSuite( 'ezcDatabaseSchemaPersistentTest' );
    }
}
?>
