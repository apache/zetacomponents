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
class ezcDbSchemaPhpArrayWriter implements ezcDbSchemaFileWriter, ezcDbSchemaDiffFileWriter
{
    /**
     */
    public function getWriterType()
    {
        return ezcDbSchema::FILE;
    }

    /**
     */
    public function getDiffWriterType()
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
        
        $fileData = '<?php return '. var_export( array( $schema, $data ), true ) . '; ?>';
        file_put_contents( $file, (string) $fileData, FILE_TEXT );
    }

    /**
     * Save schema diff to an .php file
     */
    public function saveDiffToFile( $file, ezcDbSchemaDiff $dbSchemaDiff )
    {
        $fileData = '<?php return '. var_export( $dbSchemaDiff, true ) . '; ?>';
        file_put_contents( $file, (string) $fileData, FILE_TEXT );
    }
}
?>
