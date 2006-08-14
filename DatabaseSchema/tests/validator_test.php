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
class ezcDatabaseSchemaValidatorTest extends ezcTestCase
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

    }

    public function testIndexFields()
    {
        $schema = new ezcDbSchema(
            array(
                'bugdb' => new ezcDbSchemaTable(
                    array (
                        'field1' => new ezcDbSchemaField( 'integer' ),
                        'field2' => new ezcDbSchemaField( 'integer' ),
                    ),
                    array (
                        'index1' => new ezcDbSchemaIndex( array ( 'field1' => new ezcDbSchemaIndexField() ) ),
                        'index2' => new ezcDbSchemaIndex( array ( 'field3' => new ezcDbSchemaIndexField() ) ),
                        'index3' => new ezcDbSchemaIndex( array (
                            'field2' => new ezcDbSchemaIndexField(), 
                            'field3' => new ezcDbSchemaIndexField()
                        ) ),
                    )
                ),
            )
        );

        $expected = array(
            "Index <bugdb:index2> references unknown field name <bugdb:field3>.",
            "Index <bugdb:index3> references unknown field name <bugdb:field3>.",
        );
        self::assertEquals( $expected, ezcDbSchemaValidator::validate( $schema ) );
    }

    public function testTypes()
    {
        $schema = new ezcDbSchema( array(
            'bugdb' => new ezcDbSchemaTable(
                array (
                    'integerfield1' => new ezcDbSchemaField( 'integer' ),
                    'integerfield2' => new ezcDbSchemaField( 'int' ),
                    'booleanfield1' => new ezcDbSchemaField( 'boolean' ),
                    'booleanfield2' => new ezcDbSchemaField( 'bool' ),
                    'floatfield1' => new ezcDbSchemaField( 'float' ),
                    'floatfield2' => new ezcDbSchemaField( 'double' ),
                    'decimalfield1' => new ezcDbSchemaField( 'decimal' ),
                    'decimalfield2' => new ezcDbSchemaField( 'numeric' ),
                    'timestampfield1' => new ezcDbSchemaField( 'timestamp' ),
                    'timefield1' => new ezcDbSchemaField( 'time' ),
                    'datefield1' => new ezcDbSchemaField( 'date' ),
                    'textfield1' => new ezcDbSchemaField( 'text' ),
                    'textfield2' => new ezcDbSchemaField( 'char' ),
                    'textfield3' => new ezcDbSchemaField( 'varchar' ),
                    'blobfield1' => new ezcDbSchemaField( 'blob' ),
                    'clobfield1' => new ezcDbSchemaField( 'clob' )
                )
            ),
        ) );

        $expected = array(
            "Field <bugdb:booleanfield2> uses the unsupported type <bool>.",
            "Field <bugdb:decimalfield2> uses the unsupported type <numeric>.",
            "Field <bugdb:floatfield2> uses the unsupported type <double>.",
            "Field <bugdb:integerfield2> uses the unsupported type <int>.",
            "Field <bugdb:textfield2> uses the unsupported type <char>.",
            "Field <bugdb:textfield3> uses the unsupported type <varchar>."
        );
        self::assertEquals( $expected, ezcDbSchemaValidator::validate( $schema ) );
    }

    public static function suite()
    {
        return new ezcTestSuite( 'ezcDatabaseSchemaValidatorTest' );
    }
}
?>
