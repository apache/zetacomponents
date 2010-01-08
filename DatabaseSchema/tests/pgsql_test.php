<?php
/**
 * @copyright Copyright (C) 2005-2010 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package DatabaseSchema
 * @subpackage Tests
 */

require_once 'generic_test.php';
/**
 * @package DatabaseSchema
 * @subpackage Tests
 */
class ezcDatabaseSchemaPgsqlTest extends ezcDatabaseSchemaGenericTest
{
    public function setUp()
    {
        try
        {
            $this->db = ezcDbInstance::get();
            if ($this->db->getName() != 'pgsql' ) 
            {
                throw new Exception("Skiping tests for PostgreSQL");
            }
            $this->testFilesDir = dirname( __FILE__ ) . '/testfiles/';
            $this->tempDir = $this->createTempDir( 'ezcDatabasePgSqlTest' );

            $tables = $this->db->query( "SELECT table_name FROM information_schema.tables WHERE table_schema = 'public'" )->fetchAll();
            array_walk( $tables, create_function( '&$item,$key', '$item = $item[0];' ) );

            foreach ( $tables as $tableName )
            {
                $this->db->query( "DROP TABLE \"$tableName\"" );
            }
        }
        catch ( Exception $e )
        {
            $this->markTestSkipped( $e->getMessage() );
        }

    }

    public static function suite()
    {
        return new PHPUnit_Framework_TestSuite( 'ezcDatabaseSchemaPgSqlTest' );
    }
}
?>
