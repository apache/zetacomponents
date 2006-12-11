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
class ezcDatabaseSchemaSqliteDiffTest extends ezcTestCase
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

        $this->testFilesDir = dirname( __FILE__ ) . '/testfiles/';
        $this->tempDir = $this->createTempDir( 'ezcDatabaseSqliteTest' );
        $this->resetDb();
    }

    protected function tearDown()
    {
        $this->removeTempDir();
    }

    private function resetDb()
    {
        $queryStr = "SELECT name FROM sqlite_master WHERE type='table' 
        UNION ALL SELECT name FROM sqlite_temp_master WHERE type='table'
        ORDER BY name;";

        $tables = $this->db->query( $queryStr )->fetchAll();
        array_walk( $tables, create_function( '&$item,$key', '$item = $item[0];' ) );

        foreach ( $tables as $tableName )
        {
            if ($tableName == 'sqlite_sequence') //clear sqlite_sequence table as it 
                                                 //automatically created by SQLite and couldn't be droped
            {
                $this->db->query( "DELETE FROM sqlite_sequence" );
            }
            else
            {
                $this->db->query( "DROP TABLE $tableName" );
            }
        }
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
                    'bugdb_change_pri' => new ezcDbSchemaIndex(
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
                    'integerfield2' => new ezcDbSchemaField( 'integer', 0, true, 0 ),
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

    private static function getSchemaDiff()
    {
        return ezcDbSchemaComparator::compareSchemas( self::getSchema1(), self::getSchema2() );
    }

    public function testWrite1()
    {
        $schema = self::getSchemaDiff();
        $ddl = $schema->convertToDDL( $this->db );

        $expected = array (
			0 => 'DROP INDEX \'bugdb_change_pri\'',
            1 => 'DROP INDEX \'tertiary\'',
            2 => 'ALTER TABLE bugdb_change DROP COLUMN integerfield1',
            3 => 'ALTER TABLE bugdb_change CHANGE integerfield3 integerfield3 text(64)',
            4 => 'ALTER TABLE bugdb_change ADD integerfield2 integer NOT NULL DEFAULT 0',
            5 => 'CREATE UNIQUE INDEX bugdb_change_pri ON bugdb_change ( integerfield2 )',
            6 => 'CREATE UNIQUE INDEX secondary ON bugdb_change ( integerfield3 )',
            7 => "CREATE TABLE bugdb_added (\n\tintegerfield1 integer\n)",
            8 => 'DROP TABLE bugdb_deleted',
        );
        self::assertEquals( $expected, $ddl );
    }

    public function testApply1()
    {
        $schema1 = self::getSchema1();
        $schema1->writeToDb( $this->db );
        $schemaDiff = self::getSchemaDiff();
        $schemaDiff->applyToDb( $this->db );
        $schemaInDb = ezcDbSchema::createFromDb( $this->db );
        $this->resetDb();
        self::assertEquals( self::getSchema2(), $schemaInDb );
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
        $sql = file_get_contents( $this->testFilesDir . 'bug8900-diff_sqlite.sql' );
        self::assertEquals( $sql, $text );
    }

    public static function suite()
    {
        return new PHPUnit_Framework_TestSuite( 'ezcDatabaseSchemaSqliteDiffTest' );
    }
}
?>
