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
class ezcDbSchemaXmlReader implements ezcDbSchemaFileReader, ezcDbSchemaDiffFileReader
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
     * This handler supports loading difference schema
     * from XML files.
     */
    public function getDiffReaderType()
    {
        return ezcDbSchema::FILE;
    }

    private function parseField( $field )
    {
        return new ezcDbSchemaField(
            (string) $field->type,
            isset( $field->length ) ? (string) $field->length : false,
            isset( $field->notnull ) ? (string) $field->notnull : false,
            isset( $field->default ) ? (string) $field->default : null,
            isset( $field->autoincrement ) ? (string) $field->autoincrement : false,
            isset( $field->unsigned ) ? (string) $field->unsigned : false
        );
    }

    private function parseIndex( $index )
    {
        $indexFields = array();

        foreach ( $index->field as $indexField )
        {
            $indexFieldName = (string) $indexField->name;

            $indexFields[$indexFieldName] = new ezcDbSchemaIndexField(
                isset( $indexField->sorting ) ? (string) $indexField->sorting : null
            );
        }

        return new ezcDbSchemaIndex(
            $indexFields,
            isset( $index->primary ) ? (string) $index->primary : false,
            isset( $index->unique ) ? (string) $index->unique : false
        );
    }

    private function parseTable( $table )
    {
        $fields = array();
        $indexes = array();

        foreach ( $table->declaration->field as $field )
        {
            $fieldName = (string) $field->name;
            $fields[$fieldName] = $this->parseField( $field ); 
        }

        foreach ( $table->declaration->index as $index )
        {
            $indexName = (string) $index->name;
            $indexes[$indexName] = $this->parseIndex( $index );
        }

        return new ezcDbSchemaTable( $fields, $indexes );
    }

    private function parseChangedTable( $table )
    {
        $addedFields = array();
        foreach ( $table->{'added-fields'}->field as $field )
        {
            $fieldName = (string) $field->name;
            $addedFields[$fieldName] = $this->parseField( $field ); 
        }

        $changedFields = array();
        foreach ( $table->{'changed-fields'}->field as $field )
        {
            $fieldName = (string) $field->name;
            $changedFields[$fieldName] = $this->parseField( $field ); 
        }

        $removedFields = array();
        foreach ( $table->{'removed-fields'}->field as $field )
        {
            $fieldName = (string) $field->name;
            if ( (string) $field->removed == 'true' )
            {
                $removedFields[$fieldName] = true;
            }
        }

        $addedIndexes = array();
        foreach ( $table->{'added-indexes'}->index as $index )
        {
            $indexName = (string) $index->name;
            $addedIndexes[$indexName] = $this->parseIndex( $index ); 
        }

        $changedIndexes = array();
        foreach ( $table->{'changed-indexes'}->index as $index )
        {
            $indexName = (string) $index->name;
            $changedIndexes[$indexName] = $this->parseIndex( $index ); 
        }

        $removedIndexes = array();
        foreach ( $table->{'removed-indexes'}->index as $index )
        {
            $indexName = (string) $index->name;
            if ( (string) $index->removed == 'true' )
            {
                $removedIndexes[$indexName] = true;
            }
        }

        return new ezcDbSchemaTableDiff(
            $addedFields, $changedFields, $removedFields, $addedIndexes,
            $changedIndexes, $removedIndexes
        );
    }

    private function parseXml( SimpleXMLElement $xml )
    {
        $schema = array();

        foreach ( $xml->table as $table )
        {
            $tableName = (string) $table->name;
            $schema[$tableName] = $this->parseTable( $table );
        }

        return new ezcDbSchema( $schema );
    }

    private function parseDiffXml( SimpleXMLElement $xml )
    {
        $newTables = array();
        foreach ( $xml->{'new-tables'}->table as $table )
        {
            $tableName = (string) $table->name;
            $newTables[$tableName] = $this->parseTable( $table );
        }

        $changedTables = array();
        foreach ( $xml->{'changed-tables'}->table as $table )
        {
            $tableName = (string) $table->name;
            $changedTables[$tableName] = $this->parseChangedTable( $table );
        }

        $removedTables = array();
        foreach ( $xml->{'removed-tables'}->table as $table )
        {
            $tableName = (string) $table->name;
            if ( (string) $table->removed == 'true' )
            {
                $removedTables[$tableName] = true;
            }
        }

        return new ezcDbSchemaDiff( $newTables, $changedTables, $removedTables );
    }

    /**
     * Opens the XML file for parsing
     *
     * @return SimpleXML
     */
    private function openXmlFile( $file )
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

        return $xml;
    }

    /**
     * Load schema from a .xml file.

     * @returns ezcDbSchema
     */
    public function loadFromFile( $file )
    {
        $xml = $this->openXmlFile( $file );
        return $this->parseXml( $xml );
    }

    public function loadDiffFromFile( $file )
    {
        $xml = $this->openXmlFile( $file );
        return $this->parseDiffXml( $xml );
    }
}
?>
