<?php
/**
 * File containing the ezcDbSchemaPhpArrayWriter class.
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
class ezcDbSchemaXmlWriter implements ezcDbSchemaFileWriter
{
    /**
     */
    public function getWriterType()
    {
        return ezcDbSchema::FILE;
    }

    /**
     * Save schema to an .php file
     */
    public function saveToFile( $file, ezcDbSchema $dbSchema )
    {
        $schema = $dbSchema->getSchema();
        $data = $dbSchema->getData();

        $writer = new XMLWriter();
        $writer->openUri( $file );
        $writer->startDocument( '1.0', 'utf-8' );

        $writer->startElement( 'database' );

        foreach ( $schema as $tableName => $table )
        {
            $writer->flush();
            $writer->startElement( 'table' );
            $writer->startElement( 'name' );
            $writer->text( $tableName );
            $writer->endElement();
            $writer->flush();

            $writer->startElement( 'declaration' );
            $writer->flush();

            // fields 
            foreach ( $table->fields as $fieldName => $field )
            {
                $writer->startElement( 'field' );

                $writer->startElement( 'name' );
                $writer->text( $fieldName );
                $writer->endElement();

                $writer->startElement( 'type' );
                $writer->text( $field->type );
                $writer->endElement();

                if ( $field->length )
                {
                    $writer->startElement( 'length' );
                    $writer->text( $field->length );
                    $writer->endElement();
                }

                if ( $field->autoIncrement )
                {
                    $writer->startElement( 'autoincrement' );
                    $writer->text( 'true' );
                    $writer->endElement();
                }

                if ( $field->notNull )
                {
                    $writer->startElement( 'notnull' );
                    $writer->text( 'true' );
                    $writer->endElement();
                }

                if ( !is_null( $field->default ) )
                {
                    $writer->startElement( 'default' );
                    $writer->text( $this->default );
                    $writer->endElement();
                }

                $writer->endElement();
                $writer->flush();
            }

            // indices
            foreach ( $table->indexes as $indexName => $index )
            {
                $writer->startElement( 'index' );

                $writer->startElement( 'name' );
                $writer->text( $indexName );
                $writer->endElement();

                if ( $index->primary )
                {
                    $writer->startElement( 'primary' );
                    $writer->text( 'true' );
                    $writer->endElement();
                }

                if ( $index->unique )
                {
                    $writer->startElement( 'unique' );
                    $writer->text( 'true' );
                    $writer->endElement();
                }

                foreach ( $index->indexFields as $fieldName => $field )
                {
                    $writer->startElement( 'field' );

                    $writer->startElement( 'name' );
                    $writer->text( $fieldName );
                    $writer->endElement();

                    if ( !is_null( $field->sorting ) )
                    {
                        $writer->startElement( 'sorting' );
                        $writer->text( $field->sorting ? 'ascending' : 'descending' );
                        $writer->endElement();
                    }

                    $writer->endElement();
                }

                $writer->endElement();
                $writer->flush();
            }
            $writer->endElement();
            $writer->flush();

            $writer->endElement();
        }

        $writer->endElement();
        $writer->endDocument();
    }
}
?>
