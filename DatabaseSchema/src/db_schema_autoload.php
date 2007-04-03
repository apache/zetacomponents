<?php
/**
 * Autoloading helper.
 *
 * @package DatabaseSchema
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @ignore
 */

ezcBase::checkDependency( 'DatabaseSchema', ezcBase::DEP_PHP_EXTENSION, 'simplexml' );

return array(
    'ezcDbSchema'                       => 'DatabaseSchema/schema.php',
    'ezcDbSchemaDiff'                   => 'DatabaseSchema/schema_diff.php',
    'ezcDbSchemaHandlerManager'         => 'DatabaseSchema/handler_manager.php',

    'ezcDbSchemaValidator'              => 'DatabaseSchema/validator.php',
    'ezcDbSchemaTypesValidator'         => 'DatabaseSchema/validators/types.php',
    'ezcDbSchemaIndexFieldsValidator'   => 'DatabaseSchema/validators/index_fields.php',
    'ezcDbSchemaAutoIncrementIndexValidator' => 'DatabaseSchema/validators/auto_increment_index.php',

    'ezcDbSchemaComparator'             => 'DatabaseSchema/comparator.php',
    'ezcDbSchemaTableDiff'              => 'DatabaseSchema/structs/table_diff.php',

    'ezcDbSchemaReader'                 => 'DatabaseSchema/interfaces/schema_reader.php',
    'ezcDbSchemaWriter'                 => 'DatabaseSchema/interfaces/schema_writer.php',
    'ezcDbSchemaDbReader'               => 'DatabaseSchema/interfaces/db_reader.php',
    'ezcDbSchemaDbWriter'               => 'DatabaseSchema/interfaces/db_writer.php',
    'ezcDbSchemaFileReader'             => 'DatabaseSchema/interfaces/file_reader.php',
    'ezcDbSchemaFileWriter'             => 'DatabaseSchema/interfaces/file_writer.php',

    'ezcDbSchemaDiffReader'             => 'DatabaseSchema/interfaces/schema_diff_reader.php',
    'ezcDbSchemaDiffWriter'             => 'DatabaseSchema/interfaces/schema_diff_writer.php',
    'ezcDbSchemaDiffDbWriter'           => 'DatabaseSchema/interfaces/db_diff_writer.php',
    'ezcDbSchemaDiffFileReader'         => 'DatabaseSchema/interfaces/file_diff_reader.php',
    'ezcDbSchemaDiffFileWriter'         => 'DatabaseSchema/interfaces/file_diff_writer.php',

    'ezcDbSchemaCommonSqlWriter'        => 'DatabaseSchema/handlers/common_sql_writer.php',
    'ezcDbSchemaPhpArrayReader'         => 'DatabaseSchema/handlers/php_array/reader.php',
    'ezcDbSchemaPhpArrayWriter'         => 'DatabaseSchema/handlers/php_array/writer.php',
    'ezcDbSchemaXmlReader'              => 'DatabaseSchema/handlers/xml/reader.php',
    'ezcDbSchemaXmlWriter'              => 'DatabaseSchema/handlers/xml/writer.php',
    'XMLWriter'                         => 'DatabaseSchema/handlers/xml/xmlwritersubstitute.php',
    'ezcDbSchemaPersistentWriter'       => 'DatabaseSchema/handlers/persistent/writer.php',
    'ezcDbSchemaMysqlReader'            => 'DatabaseSchema/handlers/mysql/reader.php',
    'ezcDbSchemaMysqlWriter'            => 'DatabaseSchema/handlers/mysql/writer.php',
    'ezcDbSchemaOracleReader'            => 'DatabaseSchema/handlers/oracle/reader.php',
    'ezcDbSchemaOracleWriter'            => 'DatabaseSchema/handlers/oracle/writer.php',
    'ezcDbSchemaPgsqlReader'            => 'DatabaseSchema/handlers/pgsql/reader.php',
    'ezcDbSchemaPgsqlWriter'            => 'DatabaseSchema/handlers/pgsql/writer.php',
    'ezcDbSchemaSqliteReader'            => 'DatabaseSchema/handlers/sqlite/reader.php',
    'ezcDbSchemaSqliteWriter'            => 'DatabaseSchema/handlers/sqlite/writer.php',

    'ezcDbSchemaTable'                  => 'DatabaseSchema/structs/table.php',
    'ezcDbSchemaField'                  => 'DatabaseSchema/structs/field.php',
    'ezcDbSchemaIndex'                  => 'DatabaseSchema/structs/index.php',
    'ezcDbSchemaIndexField'             => 'DatabaseSchema/structs/index_field.php',

    'ezcDbSchemaException'              => 'DatabaseSchema/exceptions/exception.php',
    'ezcDbSchemaInvalidSchemaException' => 'DatabaseSchema/exceptions/invalid_schema.php',
    'ezcDbSchemaUnknownFormatException' => 'DatabaseSchema/exceptions/unknown_format.php',
    'ezcDbSchemaInvalidReaderClassException' => 'DatabaseSchema/exceptions/invalid_reader_class.php',
    'ezcDbSchemaInvalidWriterClassException' => 'DatabaseSchema/exceptions/invalid_writer_class.php',
    'ezcDbSchemaInvalidDiffReaderClassException' => 'DatabaseSchema/exceptions/invalid_diff_reader_class.php',
    'ezcDbSchemaInvalidDiffWriterClassException' => 'DatabaseSchema/exceptions/invalid_diff_writer_class.php',
    'ezcDbSchemaSqliteDropFieldException' => 'DatabaseSchema/exceptions/sqlite_drop_field_exception.php',
    'ezcDbSchemaDropAllColumnsException'  => 'DatabaseSchema/exceptions/drop_all_columns_exception.php',
);
?>
