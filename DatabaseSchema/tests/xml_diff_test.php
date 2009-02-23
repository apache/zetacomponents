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
class ezcDatabaseSchemaXmlDiffTest extends ezcTestCase
{
    protected function setUp()
    {
        $this->testFilesDir = dirname( __FILE__ ) . '/testfiles/';
        $this->tempDir = $this->createTempDir( 'ezcDatabaseXmlTest' );
    }

    protected function tearDown()
    {
        $this->removeTempDir();
    }

    private static function getSchemaDiff()
    {
        $schema1 = new ezcDbSchema( array(
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
                        true
                    )
                )
            ),
        ) );
        $schema2 = new ezcDbSchema( array(
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
                    'integerfield2' => new ezcDbSchemaField( 'integer' ),
                    'integerfield3' => new ezcDbSchemaField( 'char', 64 ),
                ),
                array (
                    'secondary' => new ezcDbSchemaIndex(
                        array(
                            'integerfield1' => new ezcDbSchemaIndexField(),
                            'integerfield3' => new ezcDbSchemaIndexField()
                        ),
                        true
                    ),
                    'tertiary' => new ezcDbSchemaIndex(
                        array(
                            'integerfield2' => new ezcDbSchemaIndexField()
                        ),
                        true
                    )
                )
            ),
        ) );
        return ezcDbSchemaComparator::compareSchemas( $schema1, $schema2 );
    }

    public function testBrokenSchema()
    {
        $fileName = realpath( $this->testFilesDir . 'broken_schema.php' );
        try
        {
            ezcDbSchema::createFromFile( 'xml', $fileName );
            self::fail( "Expected exception not thrown." );
        }
        catch ( ezcDbSchemaInvalidSchemaException $e )
        {
            self::assertEquals( "The schema is invalid. (The schema file '{$fileName}' is not valid XML.)", $e->getMessage() );
        }
    }

    public function testCreateFromFileNonExisting()
    {
        try
        {
            ezcDbSchema::createFromFile( 'xml', 'testfiles/isnt-here.php' );
            self::fail( "Expected exception not thrown" );
        }
        catch ( Exception $e )
        {
            self::assertEquals( "The schema file 'testfiles/isnt-here.php' could not be found.", $e->getMessage() );
        }
    }

    public function testWrite1()
    {
        $fileName = $this->tempDir . '/xml_write_result.xml'; 
        $schema = self::getSchemaDiff();
        $schema->writeToFile( 'xml', $fileName );
        $newSchema = ezcDbSchemaDiff::createFromFile( 'xml', $fileName );
        self::assertEquals( $schema, $newSchema );
    }

    public function testWriteUnwriteableDir()
    {
        $fileName = $this->tempDir . '/bogus/xml_write_result.xml'; 
        $schema = self::getSchemaDiff();
        try
        {
            $schema->writeToFile( 'xml', $fileName );
            $this->fail( 'Expected exception not thrown' );
        }
        catch ( ezcBaseFilePermissionException $e )
        {
            $this->assertEquals( "The file '{$fileName}' can not be opened for writing.", $e->getMessage() );
        }
    }

    public static function suite()
    {
        return new PHPUnit_Framework_TestSuite( 'ezcDatabaseSchemaXmlDiffTest' );
    }
}
?>
