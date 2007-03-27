<?php
/**
 * File containing the ezcDbSchemaXmlReader class.
 *
 * @package DatabaseSchema
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Handler that reads database definitions and database difference definitions from a file in an XML format.
 *
 * @package DatabaseSchema
 * @version //autogentag//
 */
class ezcDbSchemaXmlReader implements ezcDbSchemaFileReader, ezcDbSchemaDiffFileReader
{
    /**
     * Returns what type of reader writer this class implements.
     *
     * This method always returns ezcDbSchema::FILE
     *
     * @return int
     */
    public function getReaderType()
    {
        return ezcDbSchema::FILE;
    }

    /**
     * Returns what type of schema difference reader this class implements.
     *
     * This method always returns ezcDbSchema::FILE
     *
     * @return int
     */
    public function getDiffReaderType()
    {
        return ezcDbSchema::FILE;
    }

    /**
     * Extracts information about a table field from the XML element $field
     * 
     * @param SimpleXMLElement $field
     *
     * @return ezcDbSchemaField
     */
    private function parseField( SimpleXMLElement $field )
    {
        return new ezcDbSchemaField(
            (string) $field->type,
            isset( $field->length ) ? (string) $field->length : false,
            isset( $field->notnull ) ? ((string) $field->notnull == 'true' ? true : false ) : false,
            isset( $field->default ) ? (string) $field->default : null,
            isset( $field->autoincrement ) ? ((string) $field->autoincrement == 'true' ? true : false ) : false,
            isset( $field->unsigned ) ? ((string) $field->unsigned == 'true' ? true : false ) : false
        );
    }

    /**
     * Extracts information about an index from the XML element $index
     * 
     * @param SimpleXMLElement $index
     *
     * @return ezcDbSchemaIndex
     */
    private function parseIndex( SimpleXMLElement $index )
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

    /**
     * Extracts information about a table from the XML element $table
     * 
     * @param SimpleXMLElement $table
     *
     * @return ezcDbSchemaTable
     */
    private function parseTable( SimpleXMLElement $table )
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

    /**
     * Extracts information about changes to a table from the XML element $table
     * 
     * @param SimpleXMLElement $table
     *
     * @return ezcDbSchemaTableDiff
     */
    private function parseChangedTable( SimpleXMLElement $table )
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

    /**
     * Returns the schema definition in $xml as an ezcDbSchema
     * 
     * @param SimpleXMLElement $xml
     *
     * @return ezcDbSchema
     */
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

    /**
     * Returns the schema differences definition in $xml as an ezcDbSchemaDiff
     * 
     * @param SimpleXMLElement $xml
     *
     * @return ezcDbSchemaDiff
     */
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
     * Opens the XML file $file for parsing
     *
     * @throws ezcBaseFileNotFoundException if the file $file could not be
     *         found.
     * @throws ezcDbSchemaInvalidSchemaException if the XML in the $file is
     *         corrupted or when the file could not be opened.
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
            throw new ezcDbSchemaInvalidSchemaException( "The schema file '{$file}' is not valid XML." );
        }

        return $xml;
    }

    /**
     * Returns the database schema stored in the XML file $file
     *
     * @throws ezcBaseFileNotFoundException if the file $file could not be
     *         found.
     * @throws ezcDbSchemaInvalidSchemaException if the XML in the $file is
     *         corrupt or when the file could not be opened.
     *
     * @param string $file
     * @return ezcDbSchema
     */
    public function loadFromFile( $file )
    {
        $xml = $this->openXmlFile( $file );
        return $this->parseXml( $xml );
    }

    /**
     * Returns the database differences stored in the XML file $file
     *
     * @throws ezcBaseFileNotFoundException if the file $file could not be
     *         found.
     * @throws ezcDbSchemaInvalidSchemaException if the XML in the $file is
     *         corrupt or when the file could not be opened.
     *
     * @param string $file
     * @return ezcDbSchemaDiff
     */
    public function loadDiffFromFile( $file )
    {
        $xml = $this->openXmlFile( $file );
        return $this->parseDiffXml( $xml );
    }
}
?>
