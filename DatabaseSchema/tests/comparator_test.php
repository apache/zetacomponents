<?php
/**
 * @copyright Copyright (C) 2005-2010 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
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
