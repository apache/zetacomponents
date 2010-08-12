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
class ezcDatabaseSchemaComparatorTest extends ezcTestCase
{
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
    }

    public function testCompareSame1()
    {
        $schema1 = new ezcDbSchema( array(
            'bugdb' => new ezcDbSchemaTable(
                array (
                    'integerfield1' => new ezcDbSchemaField( 'integer' ),
                )
            ),
        ) );
        $schema2 = new ezcDbSchema( array(
            'bugdb' => new ezcDbSchemaTable(
                array (
                    'integerfield1' => new ezcDbSchemaField( 'integer' ),
                )
            ),
        ) );
        self::assertEquals( new ezcDbSchemaDiff(), ezcDbSchemaComparator::compareSchemas( $schema1, $schema2 ) );
    }

    public function testCompareSame2()
    {
        $schema1 = new ezcDbSchema( array(
            'bugdb' => new ezcDbSchemaTable(
                array (
                    'integerfield1' => new ezcDbSchemaField( 'integer' ),
                    'integerfield2' => new ezcDbSchemaField( 'integer' ),
                )
            ),
        ) );
        $schema2 = new ezcDbSchema( array(
            'bugdb' => new ezcDbSchemaTable(
                array (
                    'integerfield2' => new ezcDbSchemaField( 'integer' ),
                    'integerfield1' => new ezcDbSchemaField( 'integer' ),
                )
            ),
        ) );
        self::assertEquals( new ezcDbSchemaDiff(), ezcDbSchemaComparator::compareSchemas( $schema1, $schema2 ) );
    }

    public function testComparePrimaryUniqueAndNonUniqueMakesNoDifference()
    {
        $schema1 = new ezcDbSchema( array(
            'bugdb' => new ezcDbSchemaTable(
                array (
                    'integerfield1' => new ezcDbSchemaField( 'integer' ),
                ),
                array (
                    'primary' => new ezcDbSchemaIndex(
                        array(
                            'integerfield1' => new ezcDbSchemaIndexField()
                        ),
                        true, true
                    )
                )
            ),
        ) );
        $schema2 = new ezcDbSchema( array(
            'bugdb' => new ezcDbSchemaTable(
                array (
                    'integerfield1' => new ezcDbSchemaField( 'integer' ),
                ),
                array (
                    'primary' => new ezcDbSchemaIndex(
                        array(
                            'integerfield1' => new ezcDbSchemaIndexField(),
                        ),
                        true, false
                    )
                )
            ),
        ) );

        $diff = ezcDbSchemaComparator::compareSchemas( $schema1, $schema2 );
        $this->assertEquals(0, count($diff->changedTables));
    }

    public function testCompareMissingTable()
    {
        $schema1 = new ezcDbSchema( array(
            'bugdb' => new ezcDbSchemaTable(
                array (
                    'integerfield1' => new ezcDbSchemaField( 'integer' ),
                )
            ),
        ) );
        $schema2 = new ezcDbSchema( array(
        ) );

        $expected = new ezcDbSchemaDiff( array(), array(),
            array(
                'bugdb' => true
            )
        );
        self::assertEquals( $expected, ezcDbSchemaComparator::compareSchemas( $schema1, $schema2 ) );
    }

    public function testCompareNewTable()
    {
        $schema1 = new ezcDbSchema( array(
        ) );
        $schema2 = new ezcDbSchema( array(
            'bugdb' => new ezcDbSchemaTable(
                array (
                    'integerfield1' => new ezcDbSchemaField( 'integer' ),
                )
            ),
        ) );

        $expected = new ezcDbSchemaDiff( array(
            'bugdb' => new ezcDbSchemaTable(
                array (
                    'integerfield1' => new ezcDbSchemaField( 'integer' ),
                )
            ),
        ) );
        self::assertEquals( $expected, ezcDbSchemaComparator::compareSchemas( $schema1, $schema2 ) );
    }

    public function testCompareMissingField()
    {
        $schema1 = new ezcDbSchema( array(
            'bugdb' => new ezcDbSchemaTable(
                array (
                    'integerfield1' => new ezcDbSchemaField( 'integer' ),
                    'integerfield2' => new ezcDbSchemaField( 'integer' ),
                )
            ),
        ) );
        $schema2 = new ezcDbSchema( array(
            'bugdb' => new ezcDbSchemaTable(
                array (
                    'integerfield2' => new ezcDbSchemaField( 'integer' ),
                )
            ),
        ) );

        $expected = new ezcDbSchemaDiff ( array(), 
            array (
                'bugdb' => new ezcDbSchemaTableDiff( array(), array(),
                    array (
                        'integerfield1' => true,
                    )
                )
            )
        );
        self::assertEquals( $expected, ezcDbSchemaComparator::compareSchemas( $schema1, $schema2 ) );
    }

    public function testCompareNewField()
    {
        $schema1 = new ezcDbSchema( array(
            'bugdb' => new ezcDbSchemaTable(
                array (
                    'integerfield1' => new ezcDbSchemaField( 'integer' ),
                )
            ),
        ) );
        $schema2 = new ezcDbSchema( array(
            'bugdb' => new ezcDbSchemaTable(
                array (
                    'integerfield1' => new ezcDbSchemaField( 'integer' ),
                    'integerfield2' => new ezcDbSchemaField( 'integer' ),
                )
            ),
        ) );

        $expected = new ezcDbSchemaDiff ( array(), 
            array (
                'bugdb' => new ezcDbSchemaTableDiff (
                    array (
                        'integerfield2' => new ezcDbSchemaField( 'integer' ),
                    )
                ),
            )
        );
        self::assertEquals( $expected, ezcDbSchemaComparator::compareSchemas( $schema1, $schema2 ) );
    }

    public function testCompareChangedFields()
    {
        $schema1 = new ezcDbSchema( array(
            'bugdb' => new ezcDbSchemaTable(
                array (
                    'charfield1' => new ezcDbSchemaField( 'char', 32, true, "default", false ),
                )
            ),
        ) );
        $schema2 = new ezcDbSchema( array(
            'bugdb' => new ezcDbSchemaTable(
                array (
                    'charfield1' => new ezcDbSchemaField( 'char', 32, true, "default", true ),
                )
            ),
        ) );

        $expected = new ezcDbSchemaDiff ( array(), 
            array (
                'bugdb' => new ezcDbSchemaTableDiff( array(),
                    array (
                        'charfield1' => new ezcDbSchemaField( 'char', 32, true, "default", true ),
                    )
                ),
            )
        );
        self::assertEquals( $expected, ezcDbSchemaComparator::compareSchemas( $schema1, $schema2 ) );
    }

    public function testCompareRemovedIndex()
    {
        $schema1 = new ezcDbSchema( array(
            'bugdb' => new ezcDbSchemaTable(
                array (
                    'integerfield1' => new ezcDbSchemaField( 'integer' ),
                    'integerfield2' => new ezcDbSchemaField( 'integer' ),
                ),
                array (
                    'primary' => new ezcDbSchemaIndex(
                        array(
                            'integerfield1' => new ezcDbSchemaIndexField()
                        ),
                        true
                    )
                )
            ),
        ) );
        $schema2 = new ezcDbSchema( array(
            'bugdb' => new ezcDbSchemaTable(
                array (
                    'integerfield1' => new ezcDbSchemaField( 'integer' ),
                    'integerfield2' => new ezcDbSchemaField( 'integer' ),
                )
            ),
        ) );

        $expected = new ezcDbSchemaDiff ( array(), 
            array (
                'bugdb' => new ezcDbSchemaTableDiff( array(), array(), array(), array(), array(),
                    array (
                        'primary' => true
                    )
                ),
            )
        );
        self::assertEquals( $expected, ezcDbSchemaComparator::compareSchemas( $schema1, $schema2 ) );
    }

    public function testCompareNewIndex()
    {
        $schema1 = new ezcDbSchema( array(
            'bugdb' => new ezcDbSchemaTable(
                array (
                    'integerfield1' => new ezcDbSchemaField( 'integer' ),
                    'integerfield2' => new ezcDbSchemaField( 'integer' ),
                )
            ),
        ) );
        $schema2 = new ezcDbSchema( array(
            'bugdb' => new ezcDbSchemaTable(
                array (
                    'integerfield1' => new ezcDbSchemaField( 'integer' ),
                    'integerfield2' => new ezcDbSchemaField( 'integer' ),
                ),
                array (
                    'primary' => new ezcDbSchemaIndex(
                        array(
                            'integerfield1' => new ezcDbSchemaIndexField()
                        ),
                        true
                    )
                )
            ),
        ) );

        $expected = new ezcDbSchemaDiff ( array(), 
            array (
                'bugdb' => new ezcDbSchemaTableDiff( array(), array(), array(),
                    array (
                        'primary' => new ezcDbSchemaIndex(
                            array(
                                'integerfield1' => new ezcDbSchemaIndexField()
                            ),
                            true
                        )
                    )
                ),
            )
        );
        self::assertEquals( $expected, ezcDbSchemaComparator::compareSchemas( $schema1, $schema2 ) );
    }

    public function testCompareChangedIndex()
    {
        $schema1 = new ezcDbSchema( array(
            'bugdb' => new ezcDbSchemaTable(
                array (
                    'integerfield1' => new ezcDbSchemaField( 'integer' ),
                    'integerfield2' => new ezcDbSchemaField( 'integer' ),
                ),
                array (
                    'primary' => new ezcDbSchemaIndex(
                        array(
                            'integerfield1' => new ezcDbSchemaIndexField()
                        ),
                        true
                    )
                )
            ),
        ) );
        $schema2 = new ezcDbSchema( array(
            'bugdb' => new ezcDbSchemaTable(
                array (
                    'integerfield1' => new ezcDbSchemaField( 'integer' ),
                    'integerfield2' => new ezcDbSchemaField( 'integer' ),
                ),
                array (
                    'primary' => new ezcDbSchemaIndex(
                        array(
                            'integerfield1' => new ezcDbSchemaIndexField(),
                            'integerfield2' => new ezcDbSchemaIndexField()
                        ),
                        true
                    )
                )
            ),
        ) );

        $expected = new ezcDbSchemaDiff ( array(), 
            array (
                'bugdb' => new ezcDbSchemaTableDiff( array(), array(), array(), array(),
                    array (
                        'primary' => new ezcDbSchemaIndex(
                            array(
                                'integerfield1' => new ezcDbSchemaIndexField(),
                                'integerfield2' => new ezcDbSchemaIndexField()
                            ),
                            true
                        )
                    )
                ),
            )
        );
        self::assertEquals( $expected, ezcDbSchemaComparator::compareSchemas( $schema1, $schema2 ) );
    }

    public static function suite()
    {
        return new PHPUnit_Framework_TestSuite( 'ezcDatabaseSchemaComparatorTest' );
    }
}
?>
