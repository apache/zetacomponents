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
class ezcDatabaseSchemaTest extends ezcTestCase
{
    private $xmlSchema;
    private $schema;

    protected function setUp()
    {
        $this->xmlSchema = ezcDbSchema::createFromFile( 'xml',  dirname( __FILE__ ) . '/testfiles/bug8900.xml' );

        // get the tables schema from the database schema
        // BY REFERENCE! - otherwise new/deleted tables are NOT updated
        // in the schema
        $this->schema =& $this->xmlSchema->getSchema();
    }

    public function testSchemaAddTable()
    {
        // add a new table (employees) to the database schema
        $this->schema['employees'] = new ezcDbSchemaTable(
                array(
                    'id' => new ezcDbSchemaField( 'integer', false, true, null, true ),
                ),
                array(
                    'primary' => new ezcDbSchemaIndex( array( 'id' => new ezcDbSchemaIndexField() ), true ),
                )
          );

        // test if the table was added
        self::assertEquals( 3, count( $this->xmlSchema->getSchema() ) );
    }

    public function testCreateIndexSql()
    {
        $schema = new ezcDbSchema( array(
            'bugdb' => new ezcDbSchemaTable(
                array(
                    'integerfield1' => new ezcDbSchemaField( 'integer' ),
                    'integerfield2' => new ezcDbSchemaField( 'integer' ),
                ),
                array(
                    'primary' => new ezcDbSchemaIndex( array(
                        'integerfield2' => new ezcDbSchemaIndexField(),
                        'integerfield1' => new ezcDbSchemaIndexField()
                    ),
                    true
                ) )
            ),
        ) );

        $writer = new ezcDbSchemaMysqlWriter();
        $ddl = $writer->convertToDDL( $schema );

        $createIndexDdl = array_pop( $ddl );
        $this->assertEquals( 'ALTER TABLE `bugdb` ADD PRIMARY KEY ( `integerfield2`, `integerfield1` )', $createIndexDdl );
    }

    public function testSchemaRemoveTable()
    {
        // remove the table table2
        unset( $this->schema['table2'] );

        // test if the table was removed
        self::assertEquals( 1, count( $this->xmlSchema->getSchema() ) );
    }

    public function testSchemaAddField()
    {
        // add a new field named salary in the table table1
        $this->schema['table1']->fields['salary'] = new ezcDbSchemaField( 'integer' );

        // test if the field was added
        $schema = $this->xmlSchema->getSchema();
        $field = $schema['table1']->fields['salary'];
        self::assertEquals( 2, count( $schema['table1']->fields ) );
        self::assertEquals( 'integer', $field->type );
        self::assertEquals( 0, $field->length );
        self::assertEquals( false, $field->notNull );
        self::assertEquals( null, $field->default );
        self::assertEquals( false, $field->autoIncrement );
        self::assertEquals( false, $field->unsigned );
    }

    public function testSchemaModifyField()
    {
        // modify the field id in the table table1
        $this->schema['table1']->fields['id']->type = 'float';

        // test if the field was modified
        $schema = $this->xmlSchema->getSchema();
        $field = $schema['table1']->fields['id'];
        self::assertEquals( 1, count( $schema['table1']->fields ) );
        self::assertEquals( 'float', $field->type );
        self::assertEquals( 0, $field->length );
        self::assertEquals( true, $field->notNull );
        self::assertEquals( null, $field->default );
        self::assertEquals( true, $field->autoIncrement );
        self::assertEquals( false, $field->unsigned );
     }

    public function testSchemaRemoveField()
    {
        // remove the field id from the table table1
        unset( $this->schema['table1']->fields['id'] );

        // test if the field was removed
        $schema = $this->xmlSchema->getSchema();
        self::assertEquals( 0, count( $schema['table1']->fields ) );
    }

    public static function suite()
    {
         return new PHPUnit_Framework_TestSuite( 'ezcDatabaseSchemaTest' );
    }
}
?>
