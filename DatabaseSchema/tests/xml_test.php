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
class ezcDatabaseSchemaXmlTest extends ezcTestCase
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

    private static function getSchema()
    {
        $tables = array(
            'bugdb' => new ezcDbSchemaTable(
                array (
                    'id' => new ezcDbSchemaField( 'integer', false, true, null, true ),
                    'bug_type' => new ezcDbSchemaField( 'text', 32, true ),
                    'severity' => new ezcDbSchemaField( 'integer', false, true ),
                    'sdesc'    => new ezcDbSchemaField( 'text', 80, true ),
                    'ldesc'    => new ezcDbSchemaField( 'clob', false, true ),
                    'php_version' => new ezcDbSchemaField( 'text', 100, true ),
                ),
                array (
                    'bug_type' => new ezcDbSchemaIndex( array ( 'bug_type' => new ezcDbSchemaIndexField() ), false, false ),
                    'php_version' => new ezcDbSchemaIndex( array ( 'php_version' => new ezcDbSchemaIndexField() ) ),
                    'primary'  => new ezcDbSchemaIndex( array ( 'id' => new ezcDbSchemaIndexField() ), true ),
                )
            ),
            'bugdb_comments' => new ezcDbSchemaTable(
                array (
                    'bug_id' => new ezcDbSchemaField( 'integer', false, true ),
                    'comment' => new ezcDbSchemaField( 'clob', false, true ),
                    'email' => new ezcDbSchemaField( 'text', 32 ),
                ),
                array (
                    'comment' => new ezcDbSchemaIndex( array ( 'comment' => new ezcDbSchemaIndexField() ) ),
                )
            ),
        );
        return $tables;
    }

    public function testCreateFromFileNonExisting()
    {
        try
        {
            ezcDbSchema::createFromFile( 'xml', 'testfiles/isnt-here.xml' );
            self::fail( "Expected exception not thrown" );
        }
        catch ( Exception $e )
        {
            self::assertEquals( "The schema file 'testfiles/isnt-here.xml' could not be found.", $e->getMessage() );
        }
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

    public function testXml()
    {
        $fileName = $this->tempDir . '/xml_write_result.xml'; 
        $schema = new ezcDbSchema( self::getSchema() );
        $schema->writeToFile( 'xml', $fileName );
        $newSchema = ezcDbSchema::createFromFile( 'xml', $fileName );
        self::assertEquals( $schema, $newSchema );
    }

    public function testXmlToUnwriteableDir()
    {
        $fileName = $this->tempDir . '/bogus/xml_write_result.xml'; 
        $schema = new ezcDbSchema( self::getSchema() );
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

    public function testParsingTrueFalse()
    {
        $fileName = realpath( $this->testFilesDir . 'bug10365.xml' );
        $schema = ezcDbSchema::createFromFile( 'xml', $fileName )->getSchema();
        self::assertEquals( $schema['bug10365']->fields['field_notnull']->notNull, true );
        self::assertEquals( $schema['bug10365']->fields['field_notnull']->autoIncrement, true );
        self::assertEquals( $schema['bug10365']->fields['field_notnull']->unsigned, true );
        self::assertEquals( $schema['bug10365']->fields['field_null']->notNull, false );
        self::assertEquals( $schema['bug10365']->fields['field_null']->autoIncrement, false );
        self::assertEquals( $schema['bug10365']->fields['field_null']->unsigned, false );
    }

    public static function suite()
    {
        return new PHPUnit_Framework_TestSuite( 'ezcDatabaseSchemaXmlTest' );
    }
}
?>
