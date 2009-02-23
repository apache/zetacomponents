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
 * This class provides the interface for file schema differences writers
 *
 * @package DatabaseSchema
 * @version //autogen//
 */
interface ezcDbSchemaDiffFileWriter extends ezcDbSchemaDiffWriter
{
    /**
     * Saves the differences in $schemaDiff to the file $file
     *
     * @param string          $file
     * @param ezcDbSchemaDiff $schemaDiff
     */
    public function saveDiffToFile( $file, ezcDbSchemaDiff $schemaDiff );
}
?>
