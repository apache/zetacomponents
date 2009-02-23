<?php
/**
 * File containing the ezcDbSchemaFileWriter interface
 *
 * @package DatabaseSchema
 * @version //autogen//
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * This class provides the interface for file schema writers
 *
 * @package DatabaseSchema
 * @version //autogen//
 */
interface ezcDbSchemaFileWriter extends ezcDbSchemaWriter
{
    /**
     * Saves the schema definition in $schema to the file $file.
     *
     * @param string      $file
     * @param ezcDbSchema $schema
     */
    public function saveToFile( $file, ezcDbSchema $schema );
}
?>
