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
class ezcDatabaseSchemaMysqlDiffTest extends ezcDatabaseSchemaGenericDiffTest
{
    protected function setUp()
    {
        try
        {
            $this->db = ezcDbInstance::get();
        }
        catch ( Exception $e )
        {
            $this->markTestSkipped( "No Database connection available" );
        }
        if ( $this->db->getName() !== 'mysql' )
        {
            $this->markTestSkipped( "We are not testing with MySQL" );
        }

        if ( !( $this->db instanceof ezcDbHandlerMysql ) )
        {
            $this->markTestSkipped();
        }

        $this->testFilesDir = dirname( __FILE__ ) . '/testfiles/';
        $this->tempDir = $this->createTempDir( 'ezcDatabaseMySqlTest' );
        $this->resetDb();
    }

    protected function resetDb()
    {
        $tables = $this->db->query( "SHOW TABLES" )->fetchAll();
        array_walk( $tables, create_function( '&$item,$key', '$item = $item[0];' ) );

        foreach ( $tables as $tableName )
        {
            $this->db->query( "DROP TABLE `$tableName`" );
        }
    }

    protected function getDiffExpectations1()
    {
        $expected = array (
            0 => "ALTER TABLE `bugdb_change` DROP INDEX `tertiary`",
            1 => "ALTER TABLE `bugdb_change` DROP INDEX `primary`",
            2 => "ALTER TABLE `bugdb_change` DROP `integerfield1`",
            3 => "ALTER TABLE `bugdb_change` CHANGE `integerfield3` `integerfield3` varchar(64)",
            4 => "ALTER TABLE `bugdb_change` ADD `integerfield2` bigint NOT NULL DEFAULT 0",
            5 => "ALTER TABLE `bugdb_change` ADD PRIMARY KEY ( `integerfield2` )",
            6 => "ALTER TABLE `bugdb_change` ADD UNIQUE `secondary` ( `integerfield3` )",
            7 => "CREATE TABLE `bugdb_added` (\n\t`integerfield1` bigint\n)",
            8 => "DROP TABLE IF EXISTS `bugdb_deleted`",
        );
        return $expected;
    }

    protected function getDiffExpectations2()
    {
        $expected = array (
            0 => "ALTER TABLE `bugdb_change` DROP INDEX `join`",
            1 => "ALTER TABLE `bugdb_change` DROP INDEX `primary`",
            2 => "ALTER TABLE `bugdb_change` DROP `from`",
            3 => "ALTER TABLE `bugdb_change` ADD `group` bigint",
            4 => "ALTER TABLE `bugdb_change` ADD PRIMARY KEY ( `group` )",
            5 => "ALTER TABLE `bugdb_change` ADD UNIQUE `from` ( `table` )",
            6 => "CREATE TABLE `order` (\n\t`right` bigint\n)",
            7 => "DROP TABLE IF EXISTS `select`",
        );
        return $expected;
    }

    public static function suite()
    {
        return new PHPUnit_Framework_TestSuite( 'ezcDatabaseSchemaMysqlDiffTest' );
    }
}
?>
