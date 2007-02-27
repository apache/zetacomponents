<?php
/**
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
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
class ezcDatabaseSchemaGenericDiffTest extends ezcTestCase
{
    public function tearDown()
    {
        $this->removeTempDir();
    }

    private static function getSchema1()
    {
        return new ezcDbSchema( array(
            'bugdb' => new ezcDbSchemaTable(
                array (
                    'integerfield1' => new ezcDbSchemaField( 'integer' ),
                )
            ),
            'bugdb_deleted' => new ezcDbSchemaTable(
                array (
                    'integerfield1' => new ezcDbSchemaField( 'integer' ),
                )
            ),
            'bugdb_change' => new ezcDbSchemaTable(
                array (
                    'integerfield1' => new ezcDbSchemaField( 'integer' ),
                    'integerfield3' => new ezcDbSchemaField( 'integer' ),
                ),
                array (
                    'primary' => new ezcDbSchemaIndex(
                        array(
                            'integerfield1' => new ezcDbSchemaIndexField()
                        ),
                        true
                    ),
                    'tertiary' => new ezcDbSchemaIndex(
                        array(
                            'integerfield3' => new ezcDbSchemaIndexField()
                        ),
                        false,
                        true
                    )
                )
            ),
        ) );
    }

    private static function getSchema2()
    {
        return new ezcDbSchema( array(
            'bugdb' => new ezcDbSchemaTable(
                array (
                    'integerfield1' => new ezcDbSchemaField( 'integer' ),
                )
            ),
            'bugdb_added' => new ezcDbSchemaTable(
                array (
                    'integerfield1' => new ezcDbSchemaField( 'integer' ),
                )
            ),
            'bugdb_change' => new ezcDbSchemaTable(
                array (
                    'integerfield2' => new ezcDbSchemaField( 'integer', 0, true ),
                    'integerfield3' => new ezcDbSchemaField( 'text', 64 ),
                ),
                array (
                    'secondary' => new ezcDbSchemaIndex(
                        array(
                            'integerfield3' => new ezcDbSchemaIndexField()
                        ),
                        false,
                        true
                    ),
                    'primary' => new ezcDbSchemaIndex(
                        array(
                            'integerfield2' => new ezcDbSchemaIndexField()
                        ),
                        true
                    )
                )
            ),
        ) );
    }

    private static function getSchema3()
    {
        return new ezcDbSchema( array(
            'table' => new ezcDbSchemaTable(
                array (
                    'from' => new ezcDbSchemaField( 'integer' ),
                )
            ),
            'select' => new ezcDbSchemaTable(
                array (
                    'group' => new ezcDbSchemaField( 'integer' ),
                )
            ),
            'bugdb_change' => new ezcDbSchemaTable(
                array (
                    'from' => new ezcDbSchemaField( 'integer' ),
                    'table' => new ezcDbSchemaField( 'integer' ),
                ),
                array (
                    'primary' => new ezcDbSchemaIndex(
                        array(
                            'from' => new ezcDbSchemaIndexField()
                        ),
                        true
                    ),
                    'join' => new ezcDbSchemaIndex(
                        array(
                            'table' => new ezcDbSchemaIndexField()
                        ),
                        false,
                        true
                    )
                )
            ),
        ) );
    }

    private static function getSchema4()
    {
        return new ezcDbSchema( array(
            'table' => new ezcDbSchemaTable(
                array (
                    'from' => new ezcDbSchemaField( 'integer' ),
                )
            ),
            'order' => new ezcDbSchemaTable(
                array (
                    'right' => new ezcDbSchemaField( 'integer' ),
                )
            ),
            'bugdb_change' => new ezcDbSchemaTable(
                array (
                    'group' => new ezcDbSchemaField( 'integer' ),
                    'table' => new ezcDbSchemaField( 'integer' ),
                ),
                array (
                    'from' => new ezcDbSchemaIndex(
                        array(
                            'table' => new ezcDbSchemaIndexField()
                        ),
                        false,
                        true
                    ),
                    'primary' => new ezcDbSchemaIndex(
                        array(
                            'group' => new ezcDbSchemaIndexField()
                        ),
                        true
                    )
                )
            ),
        ) );
    }

    private static function getSchemaDiff1()
    {
        return ezcDbSchemaComparator::compareSchemas( self::getSchema1(), self::getSchema2() );
    }

    private static function getSchemaDiff2()
    {
        return ezcDbSchemaComparator::compareSchemas( self::getSchema3(), self::getSchema4() );
    }

    public function testWrite1()
    {
        $schema = self::getSchemaDiff1();
        $ddl = $schema->convertToDDL( $this->db );

        self::assertEquals( $this->getDiffExpectations1(), $ddl );
    }

    public function testApply1()
    {
        $schema1 = self::getSchema1();
        $schema1->writeToDb( $this->db );
        $schemaDiff = self::getSchemaDiff1();
        $schemaDiff->applyToDb( $this->db );
        $schemaInDb = ezcDbSchema::createFromDb( $this->db );
        $this->resetDb();
        self::assertEquals( self::getSchema2(), $schemaInDb );
    }

    public function testWrite2()
    {
        $schema = self::getSchemaDiff2();
        $ddl = $schema->convertToDDL( $this->db );

        self::assertEquals( $this->getDiffExpectations2(), $ddl );
    }

    public function testApply2()
    {
        $schema1 = self::getSchema3();
        $schema1->writeToDb( $this->db );
        $schemaDiff = self::getSchemaDiff2();
        $schemaDiff->applyToDb( $this->db );
        $schemaInDb = ezcDbSchema::createFromDb( $this->db );
        $this->resetDb();
        self::assertEquals( self::getSchema4(), $schemaInDb );
    }

    // bug #8900
    public function testTwoTablesPrimaryKey()
    {
        $fileNameWithout = realpath( $this->testFilesDir . 'bug8900-without-index.xml' );
        $schemaWithout = ezcDbSchema::createFromFile( 'xml', $fileNameWithout );

        $fileNameWith = realpath( $this->testFilesDir . 'bug8900.xml' );
        $schemaWith = ezcDbSchema::createFromFile( 'xml', $fileNameWith );

        $diff = ezcDbSchemaComparator::compareSchemas( $schemaWithout, $schemaWith );
        $text = '';
        foreach ( $diff->convertToDDL( $this->db ) as $statement )
        {
            $text .= $statement . ";\n";
        }
        $name = strtolower( $this->db->getName() );
        $sql = file_get_contents( $this->testFilesDir . "bug8900-diff_{$name}.sql" );
        self::assertEquals( $sql, $text );
    }
}
?>
