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
class ezcDatabaseSchemaSqliteDiffTest extends ezcDatabaseSchemaGenericDiffTest
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

    protected function resetDb()
    {
        $queryStr = "SELECT name FROM sqlite_master WHERE type='table' 
        UNION ALL SELECT name FROM sqlite_temp_master WHERE type='table'
        ORDER BY name;";

        $tables = $this->db->query( $queryStr )->fetchAll();
        array_walk( $tables, create_function( '&$item,$key', '$item = $item[0];' ) );

        foreach ( $tables as $tableName )
        {
            if ($tableName == 'sqlite_sequence') // clear sqlite_sequence table as it 
                                                 // automatically created by SQLite and couldn't be droped
            {
                $this->db->query( "DELETE FROM sqlite_sequence" );
            }
            else
            {
                $this->db->query( "DROP TABLE '$tableName'" );
            }
        }
    }

    protected function getDiffExpectations1()
    {
        $expected = array (
            0 => "DROP INDEX 'tertiary'",
            1 => "DROP INDEX 'bugdb_change_pri'",
            2 => "ALTER TABLE 'bugdb_change' DROP COLUMN 'integerfield1'",
            3 => "ALTER TABLE 'bugdb_change' CHANGE 'integerfield3' 'integerfield3' text(64)",
            4 => "ALTER TABLE 'bugdb_change' ADD 'integerfield2' integer NOT NULL DEFAULT 0",
            5 => "CREATE UNIQUE INDEX 'bugdb_change_pri' ON 'bugdb_change' ( 'integerfield2' )",
            6 => "CREATE UNIQUE INDEX 'secondary' ON 'bugdb_change' ( 'integerfield3' )",
            7 => "CREATE TABLE 'bugdb_added' (\n\t'integerfield1' integer\n)",
            8 => "DROP TABLE 'bugdb_deleted'",
        );
        return $expected;
    }

    protected function getDiffExpectations2()
    {
        $expected = array (
            0 => "DROP INDEX 'join'",
            1 => "DROP INDEX 'bugdb_change_pri'",
            2 => "ALTER TABLE 'bugdb_change' DROP COLUMN 'from'",
            3 => "ALTER TABLE 'bugdb_change' ADD 'group' integer",
            4 => "CREATE UNIQUE INDEX 'bugdb_change_pri' ON 'bugdb_change' ( 'group' )",
            5 => "CREATE UNIQUE INDEX 'from' ON 'bugdb_change' ( 'table' )",
            6 => "CREATE TABLE 'order' (\n\t'right' integer\n)",
            7 => "DROP TABLE 'select'",
        );
        return $expected;
    }

    public static function suite()
    {
        return new PHPUnit_Framework_TestSuite( 'ezcDatabaseSchemaSqliteDiffTest' );
    }
}
?>
