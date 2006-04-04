<?php
/**
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
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
    public function setUp()
    {
        $this->db = ezcDbInstance::get();
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
        self::assertEquals( array(), ezcDbSchemaComparator::compareSchemas( $schema1, $schema2 ) );
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
        self::assertEquals( array(), ezcDbSchemaComparator::compareSchemas( $schema1, $schema2 ) );
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

        $expected = array( 'removed_tables' => array(
            'bugdb' => new ezcDbSchemaTable(
                array (
                    'integerfield1' => new ezcDbSchemaField( 'integer' ),
                )
            ),
        ) );
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

        $expected = array( 'new_tables' => array(
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

        $expected = array (
            'table_changes' => array (
                'bugdb' => array (
                    'removed_fields' => array (
                        'integerfield1' => true,
                    ),
                ),
            ),
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

        $expected = array (
            'table_changes' => array (
                'bugdb' => array (
                    'added_fields' => array (
                        'integerfield2' => new ezcDbSchemaField( 'integer' ),
                    ),
                ),
            ),
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

        $expected = array (
            'table_changes' => array (
                'bugdb' => array (
                    'changed_fields' => array (
                        'charfield1' => new ezcDbSchemaField( 'char', 32, true, "default", true ),
                    ),
                ),
            ),
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

        $expected = array (
            'table_changes' => array (
                'bugdb' => array (
                    'removed_indexes' => array (
                        'primary' => true
                    ),
                ),
            ),
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

        $expected = array (
            'table_changes' => array (
                'bugdb' => array (
                    'added_indexes' => array (
                        'primary' => new ezcDbSchemaIndex(
                            array(
                                'integerfield1' => new ezcDbSchemaIndexField()
                            ),
                            true
                        )
                    ),
                ),
            ),
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

        $expected = array (
            'table_changes' => array (
                'bugdb' => array (
                    'changed_indexes' => array (
                        'primary' => new ezcDbSchemaIndex(
                            array(
                            'integerfield1' => new ezcDbSchemaIndexField(),
                            'integerfield2' => new ezcDbSchemaIndexField()
                            ),
                            true
                        )
                    ),
                ),
            ),
        );
        self::assertEquals( $expected, ezcDbSchemaComparator::compareSchemas( $schema1, $schema2 ) );
    }

    public static function suite()
    {
        return new ezcTestSuite( 'ezcDatabaseSchemaComparatorTest' );
    }
}
?>
