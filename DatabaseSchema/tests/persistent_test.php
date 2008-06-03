<?php
/**
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
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
class ezcDatabaseSchemaPersistentTest extends ezcTestCase
{
    protected function setUp()
    {
        $this->testFilesDir = dirname( __FILE__ ) . '/testfiles';
        $this->tempDir = $this->createTempDir( 'ezcDatabasePersistentTest' );
    }

    protected function tearDown()
    {
        $this->removeTempDir();
    }

    public function getSchema()
    {
        $schema = ezcDbSchema::createFromFile( 'xml', $this->testFilesDir . '/webbuilder.schema.xml' );
        return $schema;
    }

    public function testPersistentGenerationSuccess()
    {
        $schema = $this->getSchema();
        $schema->writeToFile( 'persistent', $this->tempDir );

        $d = dir( $this->testFilesDir . '/persistent' );
        while ( ( $entry = $d->read() ) !== false )
        {
            if ( $entry[0] == '.' )
            {
                continue;
            }
            if ( !file_exists( $this->tempDir . '/' . $entry ) )
            {
                $this->fail( "PersistentObject definition '{$entry}' not created!" );
            }
            $this->assertEquals( 
                file_get_contents( $this->testFilesDir . '/persistent/' . $entry ),
                file_get_contents( $this->tempDir . '/' . $entry ),
                "PersistentObject definition for file '{$entry}' differs"
            );
        }
    }

    public function testPersistentGenerationFailureMissingDir()
    {
        $schema = $this->getSchema();
        try
        {
            $schema->writeToFile( 'persistent', $this->tempDir . '/unavailable' );
        }
        catch ( ezcBaseFileException $e )
        {
            return;
        }
        $this->fail( "Expected ezcBaseFileException not thrown on saving PersistentObject definitions to non-existent directory." );
    }

    public function testPersistentGenerationFailureNonDir()
    {
        $schema = $this->getSchema();
        try
        {
            $schema->writeToFile( 'persistent', __FILE__ );
        }
        catch ( ezcBaseFileException $e )
        {
            return;
        }
        $this->fail( "Expected ezcBaseFileException not thrown on saving PersistentObject definitions to a non-directory." );
    }

    /* Issue #12937 */
    public function testGenerateCorrectTypeStringPrimary()
    {
        $schema = ezcDbSchema::createFromFile( 'xml', $this->testFilesDir . '/bug-12937-persitent-string-id.xml' );
        $schema->writeToFile( 'persistent', $this->tempDir );
        
        $this->assertEquals(
            require $this->tempDir . '/liveuser_translations_string_id.php',
            require $this->testFilesDir . '/persistent_bug_12937/liveuser_translations_string_id.php'
        );
    }

    public static function suite()
    {
        return new PHPUnit_Framework_TestSuite( 'ezcDatabaseSchemaPersistentTest' );
    }
}
?>
