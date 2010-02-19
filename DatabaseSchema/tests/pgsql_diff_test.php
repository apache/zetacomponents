<?php
/**
 * @copyright Copyright (C) 2005-2010 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package DatabaseSchema
 * @subpackage Tests
 */

require_once 'generic_diff_test.php';
/**
 * @package DatabaseSchema
 * @subpackage Tests
 */
class ezcDatabaseSchemaPgSqlDiffTest extends ezcDatabaseSchemaGenericDiffTest
{
    protected function resetDb()
    {
        $tables = $this->db->query( "SELECT table_name FROM information_schema.tables WHERE table_schema = 'public'" )->fetchAll();
        array_walk( $tables, create_function( '&$item,$key', '$item = $item[0];' ) );

        foreach ( $tables as $tableName )
        {
            $this->db->query( "DROP TABLE \"$tableName\"" );
        }
    }

    public function setUp()
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
        $this->tempDir = $this->createTempDir( 'ezcDatabasePgSqlTest' );
        $this->resetDb();
    }

    protected function getDiffExpectations1()
    {
        $expected = array (
            0 => 'DROP INDEX "tertiary"',
            1 => 'ALTER TABLE "bugdb_change" DROP CONSTRAINT bugdb_change_pkey',
            2 => 'ALTER TABLE "bugdb_change" DROP "integerfield1"',
            3 => 'ALTER TABLE "bugdb_change" ALTER "integerfield3" TYPE varchar(64) USING CAST("integerfield3" AS  varchar(64))',
            4 => 'ALTER TABLE "bugdb_change" ADD "integerfield2" bigint NOT NULL DEFAULT 0',
            5 => 'ALTER TABLE "bugdb_change" ADD CONSTRAINT "bugdb_change_pkey" PRIMARY KEY ( "integerfield2" )',
            6 => 'CREATE UNIQUE INDEX "secondary" ON "bugdb_change" ( "integerfield3" )',
            7 => "CREATE TABLE \"bugdb_added\" (\n\t\"integerfield1\" bigint\n)",
            8 => 'DROP TABLE "bugdb_deleted"',
        );
        return $expected;
    }

    protected function getDiffExpectations2()
    {
        $expected = array (
            0 => 'DROP INDEX "join"',
            1 => 'ALTER TABLE "bugdb_change" DROP CONSTRAINT bugdb_change_pkey',
            2 => 'ALTER TABLE "bugdb_change" DROP "from"',
            3 => 'ALTER TABLE "bugdb_change" ADD "group" bigint NOT NULL DEFAULT 0',
            4 => 'ALTER TABLE "bugdb_change" ADD CONSTRAINT "bugdb_change_pkey" PRIMARY KEY ( "group" )',
            5 => 'CREATE UNIQUE INDEX "from" ON "bugdb_change" ( "table" )',
            6 => "CREATE TABLE \"order\" (\n\t\"right\" bigint\n)",
            7 => 'DROP TABLE "select"',
        );
        return $expected;
    }

    public static function suite()
    {
        return new PHPUnit_Framework_TestSuite( 'ezcDatabaseSchemaPgSqlDiffTest' );
    }
}
?>
