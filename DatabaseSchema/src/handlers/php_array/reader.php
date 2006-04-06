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
class ezcDbSchemaPhpArrayReader implements ezcDbSchemaFileReader, ezcDbSchemaDiffFileReader
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
     * This handler supports loading a difference schema
     * from XML files.
     */
    public function getDiffReaderType()
    {
        return ezcDbSchema::FILE;
    }

    /**
     * This handler supports loading schema
     * from XML files.
     */
    public function getReaderDiffType()
    {
        return ezcDbSchema::FILE;
    }

    /**
     * Load schema from a .php file.
     * @returns ezcDbSchema
     */
    public function loadFromFile( $file )
    {
        if ( !file_exists( $file ) )
        {
            throw new ezcBaseFileNotFoundException( $file, 'schema' );
        }

        $schema = include $file;
        if ( !is_array( $schema ) || count( $schema ) != 2 )
        {
            throw new ezcDbSchemaInvalidSchemaException( 'File does not have the correct structure' );
        }
        // @TODO: Add validator call here

        return new ezcDbSchema( $schema[0], $schema[1] );
    }
    
    /**
     * Load schema differences from a .php file.
     * @returns ezcDbSchemaDiff
     */
    public function loadDiffFromFile( $file )
    {
        if ( !file_exists( $file ) )
        {
            throw new ezcBaseFileNotFoundException( $file, 'differences schema' );
        }

        $schema = include $file;
        if ( !is_object( $schema ) || get_class( $schema ) != 'ezcDbSchemaDiff' )
        {
            throw new ezcDbSchemaInvalidSchemaException( 'File does not have the correct structure' );
        }

        return $schema;
    }
}
?>
