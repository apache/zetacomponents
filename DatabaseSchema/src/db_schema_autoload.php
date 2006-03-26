<?php
/**
 * Autoloading helper.
 *
 * @package DatabaseSchema
 * @version //autogentag//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @ignore
 */
return array(
    'ezcDbSchema'                       => 'DatabaseSchema/schema.php',
    'ezcDbSchemaHandlerManager'         => 'DatabaseSchema/handler_manager.php',

    'ezcDbSchemaValidator'              => 'DatabaseSchema/validator.php',
    'ezcDbSchemaTypesValidator'         => 'DatabaseSchema/validators/types.php',
    'ezcDbSchemaIndexFieldsValidator'   => 'DatabaseSchema/validators/index_fields.php',

    'ezcDbSchemaComparator'             => 'DatabaseSchema/comparator.php',

    'ezcDbSchemaReader'                 => 'DatabaseSchema/interfaces/schema_reader.php',
    'ezcDbSchemaWriter'                 => 'DatabaseSchema/interfaces/schema_writer.php',
    'ezcDbSchemaDbReader'               => 'DatabaseSchema/interfaces/db_reader.php',
    'ezcDbSchemaDbWriter'               => 'DatabaseSchema/interfaces/db_writer.php',
    'ezcDbSchemaFileReader'             => 'DatabaseSchema/interfaces/file_reader.php',
    'ezcDbSchemaFileWriter'             => 'DatabaseSchema/interfaces/file_writer.php',

    'ezcDbSchemaPhpArrayReader'         => 'DatabaseSchema/handlers/php_array/reader.php',
    'ezcDbSchemaPhpArrayWriter'         => 'DatabaseSchema/handlers/php_array/writer.php',
    'ezcDbSchemaXmlReader'              => 'DatabaseSchema/handlers/xml/reader.php',
    'ezcDbSchemaXmlWriter'              => 'DatabaseSchema/handlers/xml/writer.php',
    'XMLWriter'                         => 'DatabaseSchema/handlers/xml/xmlwritersubstitute.php',
    'ezcDbSchemaMysqlReader'            => 'DatabaseSchema/handlers/mysql/reader.php',
    'ezcDbSchemaMysqlWriter'            => 'DatabaseSchema/handlers/mysql/writer.php',

    'ezcDbSchemaTable'                  => 'DatabaseSchema/structs/table.php',
    'ezcDbSchemaField'                  => 'DatabaseSchema/structs/field.php',
    'ezcDbSchemaIndex'                  => 'DatabaseSchema/structs/index.php',
    'ezcDbSchemaIndexField'             => 'DatabaseSchema/structs/index_field.php',

    'ezcDbSchemaException'              => 'DatabaseSchema/exceptions/exception.php',
    'ezcDbSchemaInvalidSchemaException' => 'DatabaseSchema/exceptions/invalid_schema.php',
    'ezcDbSchemaUnknownFormatException' => 'DatabaseSchema/exceptions/unknown_format.php',
    'ezcDbSchemaInvalidReaderClassException' => 'DatabaseSchema/exceptions/invalid_reader_class.php',
    'ezcDbSchemaInvalidWriterClassException' => 'DatabaseSchema/exceptions/invalid_writer_class.php',

   /*
    'ezcDbSchemaException'           => 'DatabaseSchema/exceptions/exception.php',
    'ezcDbSchemaComparator'          => 'DatabaseSchema/comparator.php',
    'ezcDbSchemaTransformations'     => 'DatabaseSchema/transformations.php',
    'ezcDbSchemaHandler'             => 'DatabaseSchema/handler.php',
    'ezcDbSchemaHandlerDataTransfer' => 'DatabaseSchema/handlers/data_transfer.php',
    'ezcDbSchemaHandlerXml'          => 'DatabaseSchema/handlers/xml.php',
    'ezcDbSchemaHandlerSql'          => 'DatabaseSchema/handlers/sql.php',
    'ezcDbSchemaHandlerPgsql'        => 'DatabaseSchema/handlers/pgsql.php',
    'ezcDbSchemaHandlerMysql'        => 'DatabaseSchema/handlers/mysql.php',
    'ezcDbSchemaHandlerOracle'       => 'DatabaseSchema/handlers/oracle.php',
    */
);
?>
