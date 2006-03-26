<?php
/**
 * File containing the ezcDbSchemaPhpArrayReader class.
 *
 * @package DatabaseSchema
 * @version //autogentag//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Handler for files containing PHP arrays that represent DB schema.
 *
 * @package DatabaseSchema
 */
class ezcDbSchemaXmlReader implements ezcDbSchemaFileReader
{
    /**
     * This handler supports loading schema
     * from XML files.
     */
    public function getReaderType()
    {
        return ezcDbSchema::FILE;
    }

    /**
     * Load schema from a .xml file.

     * @returns ezcDbSchema
     */
    public function loadFromFile( $file )
    {
        if ( !file_exists( $file ) )
        {
            throw new ezcBaseFileNotFoundException( $file, 'schema' );
        }

        $xml = @simplexml_load_file( $file );
        if ( !$xml )
        {
            throw new ezcDbSchemaInvalidSchemaException( "The schema file <{$file}> is not valid XML." );
        }

        return $this->parseXml( $xml );
    }

    private function parseXml( SimpleXMLElement $xml )
    {
        $schema = array();

        foreach ( $xml->table as $table )
        {
            $tableName = (string) $table->name;
            $fields = array();
            $indexes = array();

            foreach ( $table->declaration->field as $field )
            {
                $fieldName = (string) $field->name;
                $fields[$fieldName] = new ezcDbSchemaField(
                    (string) $field->type,
                    isset( $field->length ) ? (string) $field->length : false,
                    isset( $field->notnull ) ? (string) $field->notnull : false,
                    isset( $field->default ) ? (string) $field->default : null,
                    isset( $field->autoincrement ) ? (string) $field->autoincrement : false,
                    isset( $field->unsigned ) ? (string) $field->unsigned : false
                );
            }

            foreach ( $table->declaration->index as $index )
            {
                $indexName = (string) $index->name;

                $indexFields = array();

                foreach ( $index->field as $indexField )
                {
                    $indexFieldName = (string) $indexField->name;

                    $indexFields[$indexFieldName] = new ezcDbSchemaIndexField(
                        isset( $indexField->sorting ) ? (string) $indexField->sorting : null
                    );
                }

                $indexes[$indexName] = new ezcDbSchemaIndex(
                    $indexFields,
                    isset( $index->primary ) ? (string) $index->primary : false,
                    isset( $index->unique ) ? (string) $index->unique : false
                );
            }

            $schema[$tableName] = new ezcDbSchemaTable( $fields, $indexes );
        }

        return new ezcDbSchema( $schema );
    }
}
?>
