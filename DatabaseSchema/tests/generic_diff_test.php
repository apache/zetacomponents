<?php
/**
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
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

    public function testWrite2WithDbName()
    {
        $schema = self::getSchemaDiff2();
        $ddl = $schema->convertToDDL( $this->db->getName() );

        self::assertEquals( $this->getDiffExpectations2(), $ddl );
    }

    public function testWrite2WithUnknownDbName()
    {
        $schema = self::getSchemaDiff2();
        try
        {
            $ddl = $schema->convertToDDL( 'hottentottententententoonstellingsterrijnen' );
            self::fail( "Expected exception not thrown." );
        }
        catch ( ezcDbSchemaUnknownFormatException $e )
        {
            self::assertEquals( "There is no 'difference write' handler available for the 'hottentottententententoonstellingsterrijnen' format.", $e->getMessage() );
        }
    }

    public function testWrite2WithBrokenDbName()
    {
        $schema = self::getSchemaDiff2();
        try
        {
            $ddl = $schema->convertToDDL( 42 );
            self::fail( "Expected exception not thrown." );
        }
        catch ( ezcDbSchemaUnknownFormatException $e )
        {
            self::assertEquals( "There is no 'difference write' handler available for the '42' format.", $e->getMessage() );
        }
    }

    public function testApply2()
    {
        $schema1 = self::getSchema3();
        $schema1->writeToDb( $this->db );
        $schemaDiff = self::getSchemaDiff2();
        $schemaDiff->applyToDb( $this->db );
        $schemaInDb = ezcDbSchema::createFromDb( $this->db );
        $this->resetDb();

        $schema4 = self::getSchema4()->getSchema();
        $schemaInDb = $schemaInDb->getSchema();

        self::assertEquals( $schema4['table'], $schemaInDb['table'] );
        self::assertEquals( $schema4['order'], $schemaInDb['order'] );
        self::assertEquals( $schema4['bugdb_change'], $schemaInDb['bugdb_change'] );
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

    // bug #10801
    public function testAddingAutoIncrementField()
    {
        $dbh = $this->db;

        $schema1 = new ezcDbSchema( array(
            'table10801' => new ezcDbSchemaTable( array(
                'id' => ezcDbSchemaField::__set_state( array(
                    'type' => 'integer',
                    'length' => false,
                    'notNull' => false,
                    'default' => 0,
                    'autoIncrement' => false,
                    'unsigned' => false,
                ) ),
                'text' => new ezcDbSchemaField( 'text' )
            ) )
        ) );
        $schema2 = new ezcDbSchema( array(
            'table10801' => new ezcDbSchemaTable( array(
                'id' => ezcDbSchemaField::__set_state( array(
                    'type' => 'integer',
                    'length' => false,
                    'notNull' => true,
                    'default' => null,
                    'autoIncrement' => true,
                    'unsigned' => false,
                ) ),
                'text' => new ezcDbSchemaField( 'text' )
            ) )
        ) );
        $schema1->writeToDb( $dbh );
        $diff = ezcDbSchemaComparator::compareSchemas( $schema1, $schema2 );
        $diff->applyToDb( $dbh );

        $q = $dbh->createInsertQuery();
        $stmt = $q->insertInto( $dbh->quoteIdentifier('table10801') )->set( $dbh->quoteIdentifier('text'), $q->bindValue('text') )->prepare();
        $stmt->execute();

        $q = $dbh->createSelectQuery();
        $stmt = $q->select( '*' )->from( $dbh->quoteIdentifier('table10801') )->prepare();
        $stmt->execute();
        $result = $stmt->fetchAll( PDO::FETCH_ASSOC );
        $this->assertEquals( 1, $result[0]['id'] );
    }
}
?>
