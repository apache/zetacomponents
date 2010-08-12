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


/**
 * @package DatabaseSchema
 * @subpackage Tests
 */
class ezcDatabaseSchemaConversionTest extends ezcTestCase
{
    private $referenceFile;
    private $generatedFile;
    private $deltaFile;

    /**
     * "constructor"
     */
    protected function setUp()
    {
        $this->referenceFile = dirname( __FILE__ ) . '/data/schema.dba';
        $this->generatedFile = dirname( __FILE__ ) . '/data/schema-generated.dba';
        $this->deltaFile     = dirname( __FILE__ ) . '/data/schema-delta.sql';
    }

    /**
     * "destructor"
     */
    protected function tearDown()
    {
        @unlink( $this->generatedFile );
        @unlink( $this->deltaFile );
    }

    /**
     * Compare two schemas loaded from different sources.
     *
     * Load schema #1 from a .php file, save it to mysql db.
     * Then load schema #2 from the same db and save it to another .php file.
     * (the .php files can be then compared manually)
     * Then compare the schemas.
     * There should be no differences.
     *
     * i.e.:
     * php -> schema1 -> mydb -> schema2 -> php
     *
     */
    public function testCompareSchemas()
    {
        $db = ezcDbInstance::get();
        $schema = new ezcDbSchema;

        $schema->load( $this->referenceFile, 'php-file', 'schema' );
        $schema->save( $db, ( $db->getName() . '-db' ) );

        $schema2 = new ezcDbSchema;
        $schema2->load( $db, ( $db->getName() . '-db' ) );
        $schema2->save( $this->generatedFile, 'php-file', 'schema' );

        $diff = $schema->compare( $schema2 );
        $schema->saveDelta( $diff, $this->deltaFile, ( $db->getName() . '-file' ) );
        $this->assertEquals( array(), $diff, 'Found differences in the schemas.' );
    }

    public static function suite()
    {
         return new PHPUnit_Framework_TestSuite( 'ezcDatabaseSchemaConversionTest' );
    }

}

?>
