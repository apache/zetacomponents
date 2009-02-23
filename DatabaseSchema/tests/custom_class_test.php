<?php
/**
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package DatabaseSchema
 * @subpackage Tests
 */

require dirname( __FILE__ ) . '/testfiles/classes/custom_classes.php';

/**
 * @package DatabaseSchema
 * @subpackage Tests
 */
class ezcDatabaseSchemaCustomClassesTest extends ezcTestCase
{
    protected function setUp()
    {
        $this->testFilesDir = dirname( __FILE__ ) . '/testfiles';
        $this->tempDir = $this->createTempDir( 'ezcDatabaseSchemaCustomClassesTest' );
        ezcDbSchema::setOptions( new ezcDbSchemaOptions( array(
            'tableClassName' => 'ezcDbSchemaTable',
            'fieldClassName' => 'ezcDbSchemaField',
            'indexClassName' => 'ezcDbSchemaIndex',
            'indexFieldClassName' => 'ezcDbSchemaIndexField',
        ) ) );
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

    public function testDefaultClasses1()
    {
        $schema = $this->getSchema()->getSchema();
        self::assertEquals( 'ezcDbSchemaTable', get_class( $schema['ce_bad_word'] ) );
        self::assertEquals( 'ezcDbSchemaField', get_class( $schema['ce_bad_word']->fields['badword_id'] ) );
        self::assertEquals( 'ezcDbSchemaIndex', get_class( $schema['ce_message_category_rel']->indexes['message_category_rel'] ) );
        self::assertEquals( 'ezcDbSchemaIndexField', get_class( $schema['ce_message_category_rel']->indexes['message_category_rel']->indexFields['message_id'] ) );
    }

    public function testCustomTableClass()
    {
        ezcDbSchema::$options->tableClassName = 'myCustomDbTable';

        $schema = $this->getSchema()->getSchema();
        self::assertEquals( 'myCustomDbTable', get_class( $schema['ce_bad_word'] ) );
        self::assertEquals( 'ezcDbSchemaField', get_class( $schema['ce_bad_word']->fields['badword_id'] ) );
        self::assertEquals( 'ezcDbSchemaIndex', get_class( $schema['ce_message_category_rel']->indexes['message_category_rel'] ) );
        self::assertEquals( 'ezcDbSchemaIndexField', get_class( $schema['ce_message_category_rel']->indexes['message_category_rel']->indexFields['message_id'] ) );
    }

    public function testCustomTableField()
    {
        ezcDbSchema::$options->fieldClassName = 'myCustomDbField';

        $schema = $this->getSchema()->getSchema();
        self::assertEquals( 'ezcDbSchemaTable', get_class( $schema['ce_bad_word'] ) );
        self::assertEquals( 'myCustomDbField', get_class( $schema['ce_bad_word']->fields['badword_id'] ) );
        self::assertEquals( 'ezcDbSchemaIndex', get_class( $schema['ce_message_category_rel']->indexes['message_category_rel'] ) );
        self::assertEquals( 'ezcDbSchemaIndexField', get_class( $schema['ce_message_category_rel']->indexes['message_category_rel']->indexFields['message_id'] ) );
    }

    public function testCustomTableIndex()
    {
        ezcDbSchema::$options->indexClassName = 'myCustomDbIndex';

        $schema = $this->getSchema()->getSchema();
        self::assertEquals( 'ezcDbSchemaTable', get_class( $schema['ce_bad_word'] ) );
        self::assertEquals( 'ezcDbSchemaField', get_class( $schema['ce_bad_word']->fields['badword_id'] ) );
        self::assertEquals( 'myCustomDbIndex', get_class( $schema['ce_message_category_rel']->indexes['message_category_rel'] ) );
        self::assertEquals( 'ezcDbSchemaIndexField', get_class( $schema['ce_message_category_rel']->indexes['message_category_rel']->indexFields['message_id'] ) );
    }

    public function testCustomTableIndexField()
    {
        ezcDbSchema::$options->indexFieldClassName = 'myCustomDbIndexField';

        $schema = $this->getSchema()->getSchema();
        self::assertEquals( 'ezcDbSchemaTable', get_class( $schema['ce_bad_word'] ) );
        self::assertEquals( 'ezcDbSchemaField', get_class( $schema['ce_bad_word']->fields['badword_id'] ) );
        self::assertEquals( 'ezcDbSchemaIndex', get_class( $schema['ce_message_category_rel']->indexes['message_category_rel'] ) );
        self::assertEquals( 'myCustomDbIndexField', get_class( $schema['ce_message_category_rel']->indexes['message_category_rel']->indexFields['message_id'] ) );
    }

    public function testWrongCustomClassArgument()
    {
        try
        {
            ezcDbSchema::$options->tableClassName = 1;
            self::fail( "Expected exception not thrown." );
        }
        catch ( ezcBaseValueException $e )
        {
            self::assertEquals( "The value '1' that you were trying to assign to setting 'tableClassName' is invalid. Allowed values are: string that contains a class name.", $e->getMessage() );
        }

        try
        {
            ezcDbSchema::$options->fieldClassName = 2;
            self::fail( "Expected exception not thrown." );
        }
        catch ( ezcBaseValueException $e )
        {
            self::assertEquals( "The value '2' that you were trying to assign to setting 'fieldClassName' is invalid. Allowed values are: string that contains a class name.", $e->getMessage() );
        }

        try
        {
            ezcDbSchema::$options->indexClassName = 3;
            self::fail( "Expected exception not thrown." );
        }
        catch ( ezcBaseValueException $e )
        {
            self::assertEquals( "The value '3' that you were trying to assign to setting 'indexClassName' is invalid. Allowed values are: string that contains a class name.", $e->getMessage() );
        }
        try
        {
            ezcDbSchema::$options->indexFieldClassName = 4;
            self::fail( "Expected exception not thrown." );
        }
        catch ( ezcBaseValueException $e )
        {
            self::assertEquals( "The value '4' that you were trying to assign to setting 'indexFieldClassName' is invalid. Allowed values are: string that contains a class name.", $e->getMessage() );
        }
    }

    public function testWrongCustomClasses()
    {
        try
        {
            ezcDbSchema::$options->tableClassName = 'myFaultyCustomDbTable';
            self::fail( "Expected exception not thrown." );
        }
        catch ( ezcBaseInvalidParentClassException $e )
        {
            self::assertEquals( "Class 'myFaultyCustomDbTable' does not exist, or does not inherit from the 'ezcDbSchemaTable' class.", $e->getMessage() );
        }

        try
        {
            ezcDbSchema::$options->fieldClassName = 'myFaultyCustomDbField';
            self::fail( "Expected exception not thrown." );
        }
        catch ( ezcBaseInvalidParentClassException $e )
        {
            self::assertEquals( "Class 'myFaultyCustomDbField' does not exist, or does not inherit from the 'ezcDbSchemaField' class.", $e->getMessage() );
        }

        try
        {
            ezcDbSchema::$options->indexClassName = 'myFaultyCustomDbIndex';
            self::fail( "Expected exception not thrown." );
        }
        catch ( ezcBaseInvalidParentClassException $e )
        {
            self::assertEquals( "Class 'myFaultyCustomDbIndex' does not exist, or does not inherit from the 'ezcDbSchemaIndex' class.", $e->getMessage() );
        }

        try
        {
            ezcDbSchema::$options->indexFieldClassName = 'myFaultyCustomDbIndexField';
            self::fail( "Expected exception not thrown." );
        }
        catch ( ezcBaseInvalidParentClassException $e )
        {
            self::assertEquals( "Class 'myFaultyCustomDbIndexField' does not exist, or does not inherit from the 'ezcDbSchemaIndexField' class.", $e->getMessage() );
        }

    }

    public function testWrongProperty()
    {
        try
        {
            ezcDbSchema::$options->doesNotExist = 'foo';
            self::fail( "Expected exception not thrown." );
        }
        catch ( ezcBasePropertyNotFoundException $e )
        {
            self::assertEquals( "No such property name 'doesNotExist'.", $e->getMessage() );
        }
    }

    public function testDefaultClasses2()
    {
        $schema = $this->getSchema()->getSchema();
        self::assertEquals( 'ezcDbSchemaTable', get_class( $schema['ce_bad_word'] ) );
        self::assertEquals( 'ezcDbSchemaField', get_class( $schema['ce_bad_word']->fields['badword_id'] ) );
        self::assertEquals( 'ezcDbSchemaIndex', get_class( $schema['ce_message_category_rel']->indexes['message_category_rel'] ) );
        self::assertEquals( 'ezcDbSchemaIndexField', get_class( $schema['ce_message_category_rel']->indexes['message_category_rel']->indexFields['message_id'] ) );
    }

    public static function suite()
    {
        return new PHPUnit_Framework_TestSuite( 'ezcDatabaseSchemaCustomClassesTest' );
    }
}
?>
