<?php
/**
 * File containing the ezcDbSchemaFileDiffReader interface
 *
 * @package DatabaseSchema
 * @version //autogen//
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * This class provides the interface for file difference schema readers
 *
 * @package DatabaseSchema
 * @version //autogen//
 */
interface ezcDbSchemaDiffFileReader extends ezcDbSchemaDiffReader
{
    /**
     * Returns an ezcDbSchemaDiff object created from the differences stored in the file $file
     *
     * @param string $file
     * @return ezcDbSchemaDiff
     */
    public function loadDiffFromFile( $file );
}
?>
