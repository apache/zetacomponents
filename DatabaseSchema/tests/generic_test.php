<?php
/**
 * @copyright Copyright (C) 2005-2010 eZ Systems AS. All rights reserved.
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
class ezcDatabaseSchemaGenericTest extends ezcTestCase
{
    public function tearDown()
    {
        $optionsWithoutPrefix = new ezcDbSchemaOptions;
        $optionsWithoutPrefix->tableNamePrefix = '';
        ezcDbSchema::setOptions( $optionsWithoutPrefix );

        $this->removeTempDir();
    }

    private static function getSchema()
    {
        $tables = array(
            'bugdb' => new ezcDbSchemaTable(
                array (
                    'id' => new ezcDbSchemaField( 'integer', false, true, null, true ),
                    'bug_type' => new ezcDbSchemaField( 'text', 32, true ),
                    'severity' => new ezcDbSchemaField( 'integer', false, true, 0 ),
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
                    'bug_id' => new ezcDbSchemaField( 'integer', false, true, 0 ),
                    'comment' => new ezcDbSchemaField( 'clob', false, true ),
                    'email' => new ezcDbSchemaField( 'text', 32 ),
                ),
                array (
                    'email' => new ezcDbSchemaIndex( array ( 'email' => new ezcDbSchemaIndexField() ) ),
                )
            ),
        );
        return $tables;
    }

    private static function getSchemaWithPrefixedTableNames()
    {
        $tables = array(
            'prefix_bugdb' => new ezcDbSchemaTable(
                array (
                    'id' => new ezcDbSchemaField( 'integer', false, true, null, true ),
                    'bug_type' => new ezcDbSchemaField( 'text', 32, true ),
                    'severity' => new ezcDbSchemaField( 'integer', false, true, 0 ),
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
            'prefix_bugdb_comments' => new ezcDbSchemaTable(
                array (
                    'bug_id' => new ezcDbSchemaField( 'integer', false, true, 0 ),
                    'comment' => new ezcDbSchemaField( 'clob', false, true ),
                    'email' => new ezcDbSchemaField( 'text', 32 ),
                ),
                array (
                    'email' => new ezcDbSchemaIndex( array ( 'email' => new ezcDbSchemaIndexField() ) ),
                )
            ),
        );
        return $tables;
    }

    public function testSimple()
    {
        $schema = new ezcDbSchema( self::getSchema() );
        $schema->writeToDb( $this->db );
        $newSchema = ezcDbSchema::createFromDb( $this->db );
        self::assertEquals( $schema, $newSchema );
    }

    public function testXmlRoundTrip()
    {
        $fileNameOrig = realpath( $this->testFilesDir . 'webbuilder.schema.xml' );
        $schema = ezcDbSchema::createFromFile( 'xml', $fileNameOrig );
        $schema->writeToDb( $this->db );
        
        $newSchema = ezcDbSchema::createFromDb( $this->db );
        $newDDL1 = $newSchema->convertToDDL( $this->db );

        // setup an empty schema to wipe out the db
        $emptySchema = new ezcDbSchema( array() );
        $diffToEmptySchema = ezcDbSchemaComparator::compareSchemas( $newSchema, $emptySchema );
        $diffToEmptySchema->applyToDb( $this->db );

        $newSchema->writeToDb( $this->db );
        $newSchema = ezcDbSchema::createFromDb( $this->db );
        $newDDL2 = $newSchema->convertToDDL( $this->db );

        self::assertEquals( $newDDL1, $newDDL2 );
    }

    public function testXmlRoundTripWithDbName()
    {
        $fileNameOrig = realpath( $this->testFilesDir . 'webbuilder.schema.xml' );
        $schema = ezcDbSchema::createFromFile( 'xml', $fileNameOrig );
        $schema->writeToDb( $this->db );
        
        $newSchema = ezcDbSchema::createFromDb( $this->db );
        $newDDL1 = $newSchema->convertToDDL( $this->db->getName() );

        // setup an empty schema to wipe out the db
        $emptySchema = new ezcDbSchema( array() );
        $diffToEmptySchema = ezcDbSchemaComparator::compareSchemas( $newSchema, $emptySchema );
        $diffToEmptySchema->applyToDb( $this->db );

        $newSchema->writeToDb( $this->db );
        $newSchema = ezcDbSchema::createFromDb( $this->db );
        $newDDL2 = $newSchema->convertToDDL( $this->db->getName() );

        self::assertEquals( $newDDL1, $newDDL2 );
    }

    public function testConvertToDDLWithUnknownDbName()
    {
        $fileNameOrig = realpath( $this->testFilesDir . 'webbuilder.schema.xml' );
        $schema = ezcDbSchema::createFromFile( 'xml', $fileNameOrig );
        $schema->writeToDb( $this->db );
        
        $newSchema = ezcDbSchema::createFromDb( $this->db );
        try
        {
            $newDDL1 = $newSchema->convertToDDL( 'hottentottententententoonstellingsterrijnen' );
            self::fail( "Expected exception not thrown." );
        }
        catch ( ezcDbSchemaUnknownFormatException $e )
        {
            self::assertEquals( "There is no 'difference write' handler available for the 'hottentottententententoonstellingsterrijnen' format.", $e->getMessage() );
        }
    }

    public function testConvertToDDLWithBrokenDbName()
    {
        $fileNameOrig = realpath( $this->testFilesDir . 'webbuilder.schema.xml' );
        $schema = ezcDbSchema::createFromFile( 'xml', $fileNameOrig );
        $schema->writeToDb( $this->db );
        
        $newSchema = ezcDbSchema::createFromDb( $this->db );
        try
        {
            $newDDL1 = $newSchema->convertToDDL( 42);
            self::fail( "Expected exception not thrown." );
        }
        catch ( ezcDbSchemaUnknownFormatException $e )
        {
            self::assertEquals( "There is no 'difference write' handler available for the '42' format.", $e->getMessage() );
        }
    }

    public function testXmlInternal1()
    {
        $fileNameOrig = realpath( $this->testFilesDir . 'webbuilder.schema.xml' );
        $schema = ezcDbSchema::createFromFile( 'xml', $fileNameOrig );

        $schema->writeToDb( $this->db );
        $newSchema = ezcDbSchema::createFromDb( $this->db );
        $tables = $newSchema->getSchema();

        $tableCeBadWord = $tables['ce_bad_word'];
        $expected = new ezcDbSchemaTable(
            array(
                'badword_id' => new ezcDbSchemaField( 'integer', null, true, null, true ),
                'word' => new ezcDbSchemaField( 'text', 255, true, 'Hello' ),
				'substitution' => new ezcDbSchemaField( 'text', 255, true, 'world' ),
            ),
            array(
                'primary' => new ezcDbSchemaIndex(
                    array( 'badword_id' => new ezcDbSchemaIndexField() ), true
                )
            )
        );
        self::assertEquals( $expected, $tableCeBadWord );
    }

    public function testXmlInternal2()
    {
        $fileNameOrig = realpath( $this->testFilesDir . 'webbuilder.schema.xml' );
        $schema = ezcDbSchema::createFromFile( 'xml', $fileNameOrig );
        $schema->writeToDb( $this->db );

        $newSchema = ezcDbSchema::createFromDb( $this->db );
        $tables = $newSchema->getSchema();

        $tableCeMessageCategoryRel = $tables['ce_message_category_rel'];
        $expected = new ezcDbSchemaTable(
            array(
                'category_id' => new ezcDbSchemaField( 'integer', null, true, 0 ),
                'is_shadow' => new ezcDbSchemaField( 'boolean', null, true, 'false' ),
                'message_id' => new ezcDbSchemaField( 'integer', null, true, 0 )
            ),
            array(
                'message_category_rel' => new ezcDbSchemaIndex(
                    array(
                        'category_id' => new ezcDbSchemaIndexField(),
                        'message_id' => new ezcDbSchemaIndexField()
                    ),
                    false, true
                )
            )
        );
        self::assertEquals( $expected, $tableCeMessageCategoryRel );
    }

    public function testXmlInternal3()
    {
        $fileNameOrig = realpath( $this->testFilesDir . 'webbuilder.schema.xml' );
        $schema = ezcDbSchema::createFromFile( 'xml', $fileNameOrig );

        $schema->writeToDb( $this->db );
        $newSchema = ezcDbSchema::createFromDb( $this->db );
        $tables = $newSchema->getSchema();
        
        $tableDebugger = $tables['debugger'];
        $expected = new ezcDbSchemaTable(
            array(
                'session_id' => new ezcDbSchemaField( 'text', 32, true, 'test' ),
            ),
            array(
                'session_id' => new ezcDbSchemaIndex(
                    array(
                        'session_id' => new ezcDbSchemaIndexField()
                    ),
                    false, true
                )
            )
        );
        self::assertEquals( $expected, $tableDebugger );
    }

    public function testXmlInternal4()
    {
        $fileNameOrig = realpath( $this->testFilesDir . 'webbuilder.schema.xml' );
        $schema = ezcDbSchema::createFromFile( 'xml', $fileNameOrig );

        $schema->writeToDb( $this->db );
        $newSchema = ezcDbSchema::createFromDb( $this->db );
        $tables = $newSchema->getSchema();

        $tableLiveuserTranslations = $tables['liveuser_translations'];
        $expected = new ezcDbSchemaTable(
            array(
                'translation_id' => new ezcDbSchemaField( 'integer', null, true, null, true ),
                'section_id' => new ezcDbSchemaField( 'integer', null, true, 0 ),
                'section_type' => new ezcDbSchemaField( 'integer', null, false, 0 ),
                'language_id' => new ezcDbSchemaField( 'text', 2, false ),
                'name' => new ezcDbSchemaField( 'text', 50, false ),
                'description' => new ezcDbSchemaField( 'text', 255, false ),
            ),
            array(
                'primary' => new ezcDbSchemaIndex(
                    array(
                        'translation_id' => new ezcDbSchemaIndexField()
                    ),
                    true
                ),
                'section_id' => new ezcDbSchemaIndex(
                    array(
                        'section_id' => new ezcDbSchemaIndexField(),
                        'section_type' => new ezcDbSchemaIndexField(),
                        'language_id' => new ezcDbSchemaIndexField(),
                    ),
                    false, true
                )
            )
        );
        self::assertEquals( $expected, $tableLiveuserTranslations );
    }

    // bug #8900
    public function testTwoTablesPrimaryKey()
    {
        $fileNameOrig = realpath( $this->testFilesDir . 'bug8900.xml' );
        $schema = ezcDbSchema::createFromFile( 'xml', $fileNameOrig );
        $text = '';
        foreach ( $schema->convertToDDL( $this->db ) as $statement )
        {
            $text .= $statement . ";\n";
        }
        $name = strtolower( $this->db->getName() );
        $sql = file_get_contents( $this->testFilesDir . "bug8900_{$name}.sql" );
        self::assertEquals( $sql, $text );
    }

    // bug #10115
    public function testSchemaWithKeywords()
    {
        $table = $this->db->quoteIdentifier( 'table' );
        $from = $this->db->quoteIdentifier( 'from' );
        $select = $this->db->quoteIdentifier( 'select' );
        $this->db->query("CREATE TABLE $table
                (

                 $from integer not null,
                 $select integer,
                 PRIMARY KEY ($from)
                )");
        $schema = ezcDbSchema::createFromDb( $this->db );
    }

    public function testDatatypes()
    {
        $fileNameOrig = realpath( $this->testFilesDir . 'DataTypesTest.xml' );
        $schema = ezcDbSchema::createFromFile( 'xml', $fileNameOrig );
        $schema->writeToDb( $this->db );
        
        $schema = ezcDbSchema::createFromDb( $this->db );
        $schema->writeToFile( 'xml', $this->getTempDir() . '/' . 'DataTypesTest.dump.xml' );
        
        $file_orig = file_get_contents( $fileNameOrig );
        $file_dump = file_get_contents(  $this->getTempDir() . '/' . 'DataTypesTest.dump.xml' );
        self::assertEquals( $file_orig, $file_dump );
    }

    public function testWriteWithPrefixReadWithPrefix()
    {
        $optionsWithPrefix = new ezcDbSchemaOptions;
        $optionsWithPrefix->tableNamePrefix = 'prefix_';
        $schema = new ezcDbSchema( self::getSchema() );

        ezcDbSchema::setOptions( $optionsWithPrefix );
        $schema->writeToDb( $this->db );

        ezcDbSchema::setOptions( $optionsWithPrefix );
        $newSchema = ezcDbSchema::createFromDb( $this->db );

        self::assertEquals( $schema, $newSchema );
    }

    public function testWriteWithPrefixReadWithoutPrefix()
    {
        $optionsWithoutPrefix = new ezcDbSchemaOptions;
        $optionsWithoutPrefix->tableNamePrefix = '';
        $optionsWithPrefix = new ezcDbSchemaOptions;
        $optionsWithPrefix->tableNamePrefix = 'prefix_';
        $schema = new ezcDbSchema( self::getSchema() );
        $schemaWithPrefix = new ezcDbSchema( self::getSchemaWithPrefixedTableNames() );

        ezcDbSchema::setOptions( $optionsWithPrefix );
        $schema->writeToDb( $this->db );

        ezcDbSchema::setOptions( $optionsWithoutPrefix );
        $newSchema = ezcDbSchema::createFromDb( $this->db );

        self::assertEquals( $schemaWithPrefix, $newSchema );
    }

    public function testWriteWithoutPrefixReadWithPrefix()
    {
        $optionsWithoutPrefix = new ezcDbSchemaOptions;
        $optionsWithoutPrefix->tableNamePrefix = '';
        $optionsWithPrefix = new ezcDbSchemaOptions;
        $optionsWithPrefix->tableNamePrefix = 'prefix_';

        $schema = new ezcDbSchema( self::getSchema() );
        $schemaWithPrefix = new ezcDbSchema( self::getSchemaWithPrefixedTableNames() );

        ezcDbSchema::setOptions( $optionsWithoutPrefix );
        $schemaWithPrefix->writeToDb( $this->db );

        ezcDbSchema::setOptions( $optionsWithPrefix );
        $newSchema = ezcDbSchema::createFromDb( $this->db );
        self::assertEquals( $schema, $newSchema );
    }

    // bug #12538: Bad DDL Output from schema comparator
    public function testWriteWithUnsupportedType()
    {
        $tables = array(
            'prefix_bugdb_comments' => new ezcDbSchemaTable(
                array (
                    'email' => new ezcDbSchemaField( 'slartibartfast', 32 ),
                ),
                array ()
            ),
        );
        $schema = new ezcDbSchema( $tables );

        try
        {
            $schema->writeToDb( $this->db );
            self::fail( "Expected exception is not thrown." );
        }
        catch ( ezcDbSchemaUnsupportedTypeException $e )
        {
            self::assertRegexp( "@The field type 'slartibartfast' is not supported with the '(.*)' handler.@", $e->getMessage() );
        }
    }
}
?>
