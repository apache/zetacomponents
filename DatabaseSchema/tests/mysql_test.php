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
class ezcDatabaseSchemaMySqlTest extends ezcTestCase
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
        $this->tempDir = $this->createTempDir( 'ezcDatabaseMySqlTest' );

        $tables = $this->db->query( "SHOW TABLES" )->fetchAll();
        array_walk( $tables, create_function( '&$item,$key', '$item = $item[0];' ) );

        foreach ( $tables as $tableName )
        {
            $this->db->query( "DROP TABLE $tableName" );
        }

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

    public function testSimpleMySQL()
    {
        $schema = new ezcDbSchema( self::getSchema() );
        $schema->writeToDb( $this->db );
        $newSchema = ezcDbSchema::createFromDb( $this->db );
        self::assertEquals( $schema, $newSchema );
    }

    public function testXmlMysqlRoundTrip()
    {
        $fileNameOrig = realpath( $this->testFilesDir . 'webbuilder.schema.xml' );
        $schema = ezcDbSchema::createFromFile( 'xml', $fileNameOrig );
        $schema->writeToDb( $this->db );
        
        $newSchema = ezcDbSchema::createFromDb( $this->db );
        $newDDL1 = $newSchema->convertToDDL( $this->db );

        $newSchema->writeToDb( $this->db );
        $newSchema = ezcDbSchema::createFromDb( $this->db );
        $newDDL2 = $newSchema->convertToDDL( $this->db );

        self::assertEquals( $newDDL1, $newDDL2 );
    }

    public function testXmlMysqlInternal1()
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
                'substitution' => new ezcDbSchemaField( 'text', 255, true ),
                'word' => new ezcDbSchemaField( 'text', 255, true ),
            ),
            array(
                'primary' => new ezcDbSchemaIndex(
                    array( 'badword_id' => new ezcDbSchemaIndexField() ), true
                )
            )
        );
        self::assertEquals( $expected, $tableCeBadWord );
    }

    public function testXmlMysqlInternal2()
    {
        $fileNameOrig = realpath( $this->testFilesDir . 'webbuilder.schema.xml' );
        $schema = ezcDbSchema::createFromFile( 'xml', $fileNameOrig );

        $schema->writeToDb( $this->db );
        $newSchema = ezcDbSchema::createFromDb( $this->db );
        $tables = $newSchema->getSchema();

        $tableCeMessageCategoryRel = $tables['ce_message_category_rel'];
        $expected = new ezcDbSchemaTable(
            array(
                'category_id' => new ezcDbSchemaField( 'integer', null, true ),
                'is_shadow' => new ezcDbSchemaField( 'integer', null, true ),
                'message_id' => new ezcDbSchemaField( 'integer', null, true )
            ),
            array(
                'message_category_rel' => new ezcDbSchemaIndex(
                    array(
                        'category_id' => new ezcDbSchemaIndexField(),
                        'message_id' => new ezcDbSchemaIndexField()
                    ),
                    false, false
                )
            )
        );
        self::assertEquals( $expected, $tableCeMessageCategoryRel );
    }

    public function testXmlMysqlInternal3()
    {
        $fileNameOrig = realpath( $this->testFilesDir . 'webbuilder.schema.xml' );
        $schema = ezcDbSchema::createFromFile( 'xml', $fileNameOrig );

        $schema->writeToDb( $this->db );
        $newSchema = ezcDbSchema::createFromDb( $this->db );
        $tables = $newSchema->getSchema();
        
        $tableDebugger = $tables['debugger'];
        $expected = new ezcDbSchemaTable(
            array(
                'session_id' => new ezcDbSchemaField( 'text', 32, true ),
            ),
            array(
                'session_id' => new ezcDbSchemaIndex(
                    array(
                        'session_id' => new ezcDbSchemaIndexField()
                    ),
                    false, false
                )
            )
        );
        self::assertEquals( $expected, $tableDebugger );
    }

    public function testXmlMysqlInternal4()
    {
        $fileNameOrig = realpath( $this->testFilesDir . 'webbuilder.schema.xml' );
        $schema = ezcDbSchema::createFromFile( 'xml', $fileNameOrig );

        $schema->writeToDb( $this->db );
        $newSchema = ezcDbSchema::createFromDb( $this->db );
        $tables = $newSchema->getSchema();

        $tableLiveuserTranslations = $tables['liveuser_translations'];
        $expected = new ezcDbSchemaTable(
            array(
                'description' => new ezcDbSchemaField( 'text', 255, true ),
                'language_id' => new ezcDbSchemaField( 'text', 2, true ),
                'name' => new ezcDbSchemaField( 'text', 50, true ),
                'section_id' => new ezcDbSchemaField( 'integer', null, true ),
                'section_type' => new ezcDbSchemaField( 'integer', null, true ),
                'translation_id' => new ezcDbSchemaField( 'integer', null, true, null, true ),
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
                        'language_id' => new ezcDbSchemaIndexField(),
                        'section_id' => new ezcDbSchemaIndexField(),
                        'section_type' => new ezcDbSchemaIndexField(),
                    ),
                    false, true
                )
            )
        );
        $serializedLiveuserTranslations = 'O:16:"ezcDbSchemaTable":2:{s:6:"fields";a:6:{s:11:"description";O:16:"ezcDbSchemaField":6:{s:4:"type";s:4:"text";s:6:"length";i:255;s:7:"notNull";b:1;s:7:"default";N;s:13:"autoIncrement";b:0;s:8:"unsigned";b:0;}s:11:"language_id";O:16:"ezcDbSchemaField":6:{s:4:"type";s:4:"text";s:6:"length";i:2;s:7:"notNull";b:1;s:7:"default";N;s:13:"autoIncrement";b:0;s:8:"unsigned";b:0;}s:4:"name";O:16:"ezcDbSchemaField":6:{s:4:"type";s:4:"text";s:6:"length";i:50;s:7:"notNull";b:1;s:7:"default";N;s:13:"autoIncrement";b:0;s:8:"unsigned";b:0;}s:10:"section_id";O:16:"ezcDbSchemaField":6:{s:4:"type";s:7:"integer";s:6:"length";i:0;s:7:"notNull";b:1;s:7:"default";N;s:13:"autoIncrement";b:0;s:8:"unsigned";b:0;}s:12:"section_type";O:16:"ezcDbSchemaField":6:{s:4:"type";s:7:"integer";s:6:"length";i:0;s:7:"notNull";b:1;s:7:"default";N;s:13:"autoIncrement";b:0;s:8:"unsigned";b:0;}s:14:"translation_id";O:16:"ezcDbSchemaField":6:{s:4:"type";s:7:"integer";s:6:"length";i:0;s:7:"notNull";b:1;s:7:"default";N;s:13:"autoIncrement";b:1;s:8:"unsigned";b:0;}}s:7:"indexes";a:2:{s:7:"primary";O:16:"ezcDbSchemaIndex":3:{s:11:"indexFields";a:1:{s:14:"translation_id";O:21:"ezcDbSchemaIndexField":1:{s:7:"sorting";N;}}s:7:"primary";b:1;s:6:"unique";b:1;}s:10:"section_id";O:16:"ezcDbSchemaIndex":3:{s:11:"indexFields";a:3:{s:11:"language_id";O:21:"ezcDbSchemaIndexField":1:{s:7:"sorting";N;}s:10:"section_id";O:21:"ezcDbSchemaIndexField":1:{s:7:"sorting";N;}s:12:"section_type";O:21:"ezcDbSchemaIndexField":1:{s:7:"sorting";N;}}s:7:"primary";b:0;s:6:"unique";b:1;}}}';
        self::assertEquals( $expected, $tableLiveuserTranslations );
    }

    // bug #8900
    public function testMysqlTwoTablesPrimaryKey()
    {
        $fileNameOrig = realpath( $this->testFilesDir . 'bug8900.xml' );
        $schema = ezcDbSchema::createFromFile( 'xml', $fileNameOrig );
        $text = '';
        foreach ( $schema->convertToDDL( $this->db ) as $statement )
        {
            $text .= $statement . ";\n";
        }
        $sql = file_get_contents( $this->testFilesDir . 'bug8900.sql' );
        self::assertEquals( $sql, $text );
    }

    public static function suite()
    {
        return new ezcTestSuite( 'ezcDatabaseSchemaMySqlTest' );
    }
}
?>
