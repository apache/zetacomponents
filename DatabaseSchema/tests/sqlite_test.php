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
class ezcDatabaseSchemaSqliteTest extends ezcDatabaseSchemaGenericTest
{
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
        $this->tempDir = $this->createTempDir( 'ezcDatabaseSqliteTest' );

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

    // test for bug #13072
    public function testUppercaseDataTypes()
    {
        $path = dirname( __FILE__ ) . '/testfiles/bug13072.sqlite';
        $db = ezcDbFactory::create( "sqlite://$path" );
        $newSchema = ezcDbSchema::createFromDb( $db );
        $schema = $newSchema->getSchema();

        self::assertEquals( 'integer', $schema['authors']->fields['id']->type );
        self::assertEquals( 'text', $schema['authors']->fields['firstname']->type );
        self::assertEquals( 'text', $schema['ownership']->fields['critique']->type );
    }

    public static function suite()
    {
        return new PHPUnit_Framework_TestSuite( 'ezcDatabaseSchemaSqliteTest' );
    }
}
?>
